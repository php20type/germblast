<?php

namespace App\Services;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ZoomService
{
    protected $baseUrl = 'https://api.zoom.us/v2/';
    protected $oauthUrl = 'https://zoom.us/oauth/token';

    protected $clientId;
    protected $clientSecret;

    public function __construct()
    {
        $this->clientId     = config('services.zoom.client_id');
        $this->clientSecret = config('services.zoom.client_secret');
    }

     public function getUserAccessToken(User $user)
    {
        // CASE 1 — no token stored yet
        if (!$user->zoom_access_token) {
            throw new Exception("User does not have a Zoom token yet.");
        }

        // CASE 2 — token is still valid
        if ($user->zoom_token_expiry && Carbon::parse($user->zoom_token_expiry)->isFuture()) {
            return $user->zoom_access_token;
        }

        // CASE 3 — refresh token
        return $this->refreshUserAccessToken($user);
    }

    /**
     * Refresh user Zoom token using refresh_token
     */
    public function refreshUserAccessToken(User $user)
    {
        if (!$user->zoom_refresh_token) {
            throw new Exception("No refresh token available for user.");
        }

        $response = Http::asForm()
            ->withBasicAuth($this->clientId, $this->clientSecret)
            ->post($this->oauthUrl, [
                'grant_type'    => 'refresh_token',
                'refresh_token' => $user->zoom_refresh_token,
            ]);

        if ($response->failed()) {
            Log::error("Zoom token refresh failed: ".$response->body());
            throw new Exception('Zoom token refresh failed.');
        }

        $data = $response->json();

        // Store refreshed access + expiry
        $user->update([
            'zoom_access_token'  => $data['access_token'],
            'zoom_refresh_token' => $data['refresh_token'],
            'zoom_token_expiry'  => Carbon::now()->addSeconds($data['expires_in']),
        ]);

        return $data['access_token'];
    }

    /**
     * Create a Zoom Meeting for a user
     */
    public function createMeeting(User $user, array $meetingData)
    {
        $token = $this->getUserAccessToken($user);

        $response = Http::withToken($token)
            ->post($this->baseUrl.'users/me/meetings', $meetingData);

        if ($response->failed()) {
            Log::error("Zoom meeting create failed: ".$response->body());
            throw new Exception('Zoom meeting creation failed.');
        }

        return $response->json();
    }

    /**
     * Delete Zoom Meeting by meeting id
     */
    public function deleteMeeting(User $user, $meetingId)
    {
        $token = $this->getUserAccessToken($user);

        $response = Http::withToken($token)
            ->delete($this->baseUrl."meetings/{$meetingId}");

        if ($response->failed()) {
            Log::error("Zoom meeting deletion failed: ".$response->body());
            throw new Exception('Zoom meeting deletion failed.');
        }

        return true;
    }

}
