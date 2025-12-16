<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ZoomService
{
    protected string $baseUrl = 'https://api.zoom.us/v2/';
    protected string $oauthUrl = 'https://zoom.us/oauth/token';

    protected string $clientId;
    protected string $clientSecret;

    public function __construct()
    {
        $this->clientId     = config('services.zoom.client_id');
        $this->clientSecret = config('services.zoom.client_secret');
    }

    /**
     * Get valid access token for a user
     */
    public function getUserAccessToken(User $user): string
    {
        if (!$user->zoom_access_token) {
            throw new Exception('User does not have a Zoom token yet.');
        }

        if (
            $user->zoom_token_expiry &&
            Carbon::parse($user->zoom_token_expiry)->isFuture()
        ) {
            return $user->zoom_access_token;
        }

        return $this->refreshUserAccessToken($user);
    }

    /**
     * Refresh Zoom token using refresh_token
     */
    protected function refreshUserAccessToken(User $user): string
    {
        if (!$user->zoom_refresh_token) {
            throw new Exception('Zoom refresh token missing.');
        }

        $response = Http::asForm()
            ->withBasicAuth($this->clientId, $this->clientSecret)
            ->post($this->oauthUrl, [
                'grant_type'    => 'refresh_token',
                'refresh_token' => $user->zoom_refresh_token,
            ]);

        if ($response->failed()) {
            Log::error('Zoom token refresh failed', [
                'response' => $response->body(),
            ]);
            throw new Exception('Zoom token refresh failed.');
        }

        $data = $response->json();

        $user->update([
            'zoom_access_token'  => $data['access_token'],
            'zoom_refresh_token' => $data['refresh_token'],
            'zoom_token_expiry'  => Carbon::now()->addSeconds($data['expires_in']),
        ]);

        return $data['access_token'];
    }

    /**
     * Create Zoom meeting for authenticated user
     */
    public function createMeeting(User $user, array $meetingData): array
    {
        $token = $this->getUserAccessToken($user);

        $response = Http::withToken($token)
            ->post($this->baseUrl . 'users/me/meetings', $meetingData);

        if ($response->failed()) {
            Log::error('Zoom meeting creation failed', [
                'response' => $response->body(),
            ]);
            throw new Exception('Zoom meeting creation failed.');
        }

        return $response->json();
    }

    /**
     * Delete Zoom meeting
     */
    public function deleteMeeting(User $user, string $zoomMeetingId): bool
    {
        $token = $this->getUserAccessToken($user);

        $response = Http::withToken($token)
            ->delete($this->baseUrl . "meetings/{$zoomMeetingId}");

        if ($response->failed()) {
            Log::error('Zoom meeting deletion failed', [
                'response' => $response->body(),
            ]);
            throw new Exception('Zoom meeting deletion failed.');
        }

        return true;
    }
}
