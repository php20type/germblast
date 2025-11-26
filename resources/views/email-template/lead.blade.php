<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        @if ($type === 'lead_created')
            New Lead Created
        @elseif ($type === 'lead_assigned')
            Lead Assigned
        @elseif ($type === 'meeting_required')
            Initial Meeting Required
        @elseif ($type === 'meeting_scheduled')
            Initial Meeting Scheduled
        @else
            Lead Notification
        @endif
    </title>

    <style>
        body {
            font-family: "Arial", sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 25px;
            color: #333;
        }

        .email-container {
            max-width: 650px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h2 {
            margin: 0;
            font-size: 26px;
            color: #1A73E8;
            font-weight: 700;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .details-table td {
            padding: 12px 8px;
            font-size: 15px;
            border-bottom: 1px solid #ececec;
        }

        .details-table td:first-child {
            width: 36%;
            color: #555;
            font-weight: 600;
        }

        .footer-msg {
            margin-top: 25px;
            font-size: 14px;
            padding: 15px;
            background: #e9f3ff;
            border-left: 4px solid #1A73E8;
            border-radius: 5px;
            color: #333;
        }

        /* Mobile Responsive */
        @media(max-width: 600px) {
            .email-container {
                padding: 20px;
            }
            .details-table td {
                font-size: 14px;
                padding: 10px 6px;
            }
        }
    </style>
</head>
<body>

<div class="email-container">

    <!-- Dynamic Title -->
    <div class="header">
        <h2>
            @if ($type === 'lead_created')
                New Lead Created
            @elseif ($type === 'lead_assigned')
                Lead Assigned
            @elseif ($type === 'meeting_required')
                Initial Meeting Required
            @elseif ($type === 'meeting_scheduled')
                Meeting Scheduled
            @else
                Lead Notification
            @endif
        </h2>
    </div>

    <!-- Data table -->
    <table class="details-table">

        <tr>
            <td>Lead Name</td>
            <td>{{ $data['lead_name'] }}</td>
        </tr>

        <tr>
            <td>Assignee</td>
            <td>{{ $data['assignee'] }}</td>
        </tr>

        @if(isset($data['close_date']))
        <tr>
            <td>Close Date</td>
            <td>{{ $data['close_date'] ?? 'N/A' }}</td>
        </tr>
        @endif

        @if(isset($data['meeting_time']))
        <tr>
            <td>Meeting Time</td>
            <td>{{ $data['meeting_time'] }}</td>
        </tr>
        @endif

    </table>

    <!-- Footer message -->
    <p class="footer-msg">
        This is an automated notification related to the lead status update:
        <strong>{{ str_replace('_',' ', ucfirst($type)) }}</strong>.
    </p>

</div>

</body>
</html>
