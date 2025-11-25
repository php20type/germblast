    <h2>
        @if ($type === 'lead_created')
            New Lead Created
        @elseif ($type === 'lead_assigned')
            New Lead Assigned
        @elseif ($type === 'meeting_required')
            Initial Meeting Required
        @elseif ($type === 'meeting_scheduled')
            Initial Meeting Scheduled
        @endif
    </h2>

    <p><strong>Lead Name:</strong> {{ $data['lead_name'] }}</p>
    <p><strong>Assignee:</strong> {{ $data['assignee'] }}</p>

    @if (isset($data['close_date']))
        <p><strong>Close Date:</strong> {{ $data['close_date'] }}</p>
    @endif

    @if (isset($data['meeting_time']))
        <p><strong>Meeting Time:</strong> {{ $data['meeting_time'] }}</p>
    @endif

    <p>This is an automated notification.</p>
