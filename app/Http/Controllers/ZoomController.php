<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\ZoomMeeting;
use App\Services\ZoomService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ZoomController extends Controller
{
    protected $zoomService;

    public function __construct(ZoomService $zoomService)
    {
        $this->zoomService = $zoomService;
    }

    public function createMeeting(Request $request, int $meetingId)
    {
        $meeting = Meeting::findOrFail($meetingId);

        if ($meeting->meeting_type !== 'zoom') {
            return response()->json([
                'message' => 'Zoom meeting can only be created for Zoom type meetings.',
            ], 422);
        }

        /** Build ISO start time */
        $startTime = Carbon::parse(
            $meeting->date.' '.$meeting->start_time,
            config('app.timezone')
        )->toIso8601String();

        /** Payload for Zoom */
        $meetingData = [
            'topic' => $meeting->name,
            'type' => 2,
            'start_time' => $startTime,
            'duration' => (int) $meeting->duration,
            'agenda' => $meeting->description ?? 'Scheduled meeting',
            'settings' => [
                'join_before_host' => false,
                'waiting_room' => true,
                'mute_upon_entry' => true,
                'approval_type' => 0,
                'auto_recording' => 'none',
            ],
        ];

        try {
            $zoomMeeting = $this->zoomService->createMeeting($meetingData);

            ZoomMeeting::create([
                'meeting_id' => $meeting->id,
                'zoom_meeting_id' => $zoomMeeting['id'] ?? null,
                'uuid' => $zoomMeeting['uuid'] ?? null,
                'host_id' => $zoomMeeting['host_id'] ?? null,
                'topic' => $zoomMeeting['topic'] ?? null,
                'status' => $zoomMeeting['status'] ?? null,
                'start_time' => $meeting->start_time,
                'end_time' => $meeting->end_time,
                'duration' => $meeting->duration,
                'date' => $meeting->date,
                'timezone' => $zoomMeeting['timezone'] ?? 'UTC',
                'agenda' => $zoomMeeting['agenda'] ?? null,
                'password' => $zoomMeeting['password'] ?? null,
                'start_url' => $zoomMeeting['start_url'] ?? null,
                'join_url' => $zoomMeeting['join_url'] ?? null,
                'response' => json_encode($zoomMeeting),
            ]);

            return response()->json([
                'message' => 'Zoom meeting created successfully!',
                'data' => $zoomMeeting,
            ]);

        } catch (\Exception $e) {
            \Log::error('Zoom meeting creation failed', [
                'meeting_id' => $meetingId,
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => 'Failed to create Zoom meeting',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

     public function updateMeeting(Meeting $meeting)
    {
        $zoom = $meeting->zoom;

        if (!$zoom) {
            return;
        }

        $startTimeIso = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $meeting->date.' '.$meeting->start_time,
            config('app.timezone')
        )->toIso8601String();

        $payload = [
            'topic'      => $meeting->name,
            'start_time'=> $startTimeIso,
            'duration'  => (int) $meeting->duration,
            'agenda'    => $meeting->description,
        ];

        try {
            $this->zoomService->updateMeeting(
                $zoom->zoom_meeting_id,
                $payload
            );

            $zoom->update([
                'date'       => $meeting->date,
                'start_time' => $meeting->start_time,
                'end_time'   => $meeting->end_time,
                'duration'   => $meeting->duration,
            ]);

        } catch (\Throwable $e) {
            Log::error('Zoom meeting update failed', [
                'meeting_id' => $meeting->id,
                'zoom_id'    => $zoom->zoom_meeting_id,
                'error'      => $e->getMessage(),
            ]);
        }
    }

      public function deleteMeeting(Meeting $meeting)
    {
        $zoom = $meeting->zoom;

        if (!$zoom) {
            return;
        }

        try {
            $this->zoomService->deleteMeeting($zoom->zoom_meeting_id);
            $zoom->delete();

        } catch (\Throwable $e) {
            Log::error('Zoom meeting deletion failed', [
                'meeting_id' => $meeting->id,
                'zoom_id'    => $zoom->zoom_meeting_id,
                'error'      => $e->getMessage(),
            ]);
        }
    }
}
