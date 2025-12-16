<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\ZoomMeeting;
use App\Services\ZoomService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ZoomController extends Controller
{
    protected ZoomService $zoomService;

    public function __construct(ZoomService $zoomService)
    {
        $this->zoomService = $zoomService;
    }

    // public function createMeeting(Request $request, $meetingId)
    // {
    //     $meeting = Meeting::findOrFail($meetingId);

    //     /** Allow only Zoom meetings */
    //     if ($meeting->meeting_type !== 'zoom') {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Zoom meeting can only be created for Zoom type meetings.',
    //         ], 422);
    //     }

    //     /** Normalize date + time */
    //     $startTimeIso = Carbon::parse(
    //         $meeting->date . ' ' . $meeting->start_time,
    //         config('app.timezone')
    //     )->toIso8601String();

    //     /** Zoom payload */
    //     $payload = [
    //         'topic' => $meeting->name,
    //         'type' => 2,
    //         'start_time' => $startTimeIso,
    //         'duration' => (int) $meeting->duration,
    //         'agenda' => $meeting->description ?? 'Scheduled Zoom Meeting',
    //         'settings' => [
    //             'join_before_host' => false,
    //             'waiting_room' => true,
    //             'mute_upon_entry' => true,
    //             'approval_type' => 0,
    //             'auto_recording' => 'none',
    //         ],
    //     ];

    //     try {
    //         /** Create Zoom meeting */
    //         $zoomResponse = $this->zoomService->createMeeting(
    //             auth()->user(),
    //             $payload
    //         );

    //         /** Store Zoom meeting locally */
    //         ZoomMeeting::create([
    //             'meeting_id'       => $meeting->id,
    //             'zoom_meeting_id'  => $zoomResponse['id'] ?? null,
    //             'uuid'             => $zoomResponse['uuid'] ?? null,
    //             'host_id'          => $zoomResponse['host_id'] ?? null,
    //             'host_email'       => $zoomResponse['host_email'] ?? null,
    //             'topic'            => $zoomResponse['topic'] ?? null,
    //             'status'           => $zoomResponse['status'] ?? null,
    //             'start_time'       => $meeting->start_time,
    //             'end_time'         => $meeting->end_time,
    //             'duration'         => $meeting->duration,
    //             'date'             => $meeting->date,
    //             'timezone'         => $zoomResponse['timezone'] ?? 'UTC',
    //             'agenda'           => $zoomResponse['agenda'] ?? null,
    //             'password'         => $zoomResponse['password'] ?? null,
    //             'start_url'        => $zoomResponse['start_url'] ?? null,
    //             'join_url'         => $zoomResponse['join_url'] ?? null,
    //             'response'         => json_encode($zoomResponse),
    //         ]);

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Zoom meeting created successfully!',
    //             'data'    => $zoomResponse,
    //         ]);

    //     } catch (\Throwable $e) {
    //         Log::error('Zoom meeting creation failed', [
    //             'meeting_id' => $meeting->id,
    //             'error'      => $e->getMessage(),
    //         ]);

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Failed to create Zoom meeting.',
    //         ], 500);
    //     }
    // }

    public function createMeeting(Request $request, $meetingId)
{
    $meeting = Meeting::findOrFail($meetingId);

    /** Allow only Zoom meetings */
    if ($meeting->meeting_type !== 'zoom') {
        return response()->json([
            'success' => false,
            'message' => 'Zoom meeting can only be created for Zoom type meetings.',
        ], 422);
    }

    /** Build ISO start time */
    $startTimeIso = Carbon::parse(
        $meeting->date . ' ' . $meeting->start_time,
        config('app.timezone')
    )->toIso8601String();

    /** Zoom payload */
    $payload = [
        'topic' => $meeting->name,
        'type' => 2,
        'start_time' => $startTimeIso,
        'duration' => (int) $meeting->duration,
        'agenda' => $meeting->description ?? 'Scheduled Zoom Meeting',
        'settings' => [
            'join_before_host' => false,
            'waiting_room' => true,
            'mute_upon_entry' => true,
            'approval_type' => 0,
            'auto_recording' => 'none',
        ],
    ];

    try {
        /** Create Zoom meeting (S2S OAuth) */
        $zoomResponse = $this->zoomService->createMeeting($payload);

        /** Store Zoom meeting locally */
        ZoomMeeting::create([
            'meeting_id'      => $meeting->id,
            'zoom_meeting_id' => $zoomResponse['id'] ?? null,
            'uuid'            => $zoomResponse['uuid'] ?? null,
            'host_id'         => $zoomResponse['host_id'] ?? null,
            'host_email'      => $zoomResponse['host_email'] ?? null,
            'topic'           => $zoomResponse['topic'] ?? null,
            'status'          => $zoomResponse['status'] ?? null,
            'start_time'      => $meeting->start_time,
            'end_time'        => $meeting->end_time,
            'duration'        => $meeting->duration,
            'date'            => $meeting->date,
            'timezone'        => $zoomResponse['timezone'] ?? 'UTC',
            'agenda'          => $zoomResponse['agenda'] ?? null,
            'password'        => $zoomResponse['password'] ?? null,
            'start_url'       => $zoomResponse['start_url'] ?? null,
            'join_url'        => $zoomResponse['join_url'] ?? null,
            'response'        => json_encode($zoomResponse),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Zoom meeting created successfully!',
        ]);

    } catch (\Throwable $e) {
        Log::error('Zoom meeting creation failed', [
            'meeting_id' => $meeting->id,
            'error' => $e->getMessage(),
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Failed to create Zoom meeting.',
        ], 500);
    }
}
}
