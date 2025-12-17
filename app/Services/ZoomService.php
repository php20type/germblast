<?php

namespace App\Services;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;

class ZoomService
{
    protected $baseUrl = 'https://api.zoom.us/v2/';
    protected $oauthUrl = 'https://zoom.us/oauth/token';
    protected $clientId;

    protected $clientSecret;

    protected $accountId;

    protected $accessToken;

    protected $tokenExpiry;

    public function __construct()
    {
        $this->clientId     = config('services.zoom.client_id');
        $this->clientSecret = config('services.zoom.client_secret');
        $this->accountId    = config('services.zoom.account_id');
    }

    /**
     * Get or refresh global Zoom access token (S2S)
     */
    public function getAccessToken(): string
    {
        if ($this->accessToken && Carbon::now()->lt($this->tokenExpiry)) {
            return $this->accessToken;
        }

        $response = Http::asForm()
            ->withBasicAuth($this->clientId, $this->clientSecret)
            ->post($this->oauthUrl, [
                'grant_type' => 'account_credentials',
                'account_id' => $this->accountId,
            ]);

        if ($response->failed()) {
            throw new Exception('Zoom S2S token request failed: '.$response->body());
        }

        $data = $response->json();

        $this->accessToken = $data['access_token'];
        $this->tokenExpiry = Carbon::now()->addSeconds($data['expires_in']);

        return $this->accessToken;
    }

    /**
     * Create Zoom meeting (platform account)
     */
    public function createMeeting(array $meetingData): array
    {
        $accessToken = $this->getAccessToken();

        $response = Http::withToken($accessToken)
            ->post($this->baseUrl.'users/me/meetings', $meetingData);

        if ($response->failed()) {
            throw new Exception('Zoom meeting creation failed: '.$response->body());
        }

        return $response->json();
    }

    public function updateMeeting(string $zoomMeetingId, array $payload): void
{
    $token = $this->getAccessToken();

    Http::withToken($token)
        ->patch($this->baseUrl."meetings/{$zoomMeetingId}", $payload)
        ->throw();
}


    /**
     * Delete Zoom meeting
     */
    public function deleteMeeting(string $zoomMeetingId): bool
    {
        $accessToken = $this->getAccessToken();

        $response = Http::withToken($accessToken)
            ->delete($this->baseUrl."meetings/{$zoomMeetingId}");

        if ($response->failed()) {
            throw new Exception('Zoom meeting deletion failed: '.$response->body());
        }

        return true;
    }
}
