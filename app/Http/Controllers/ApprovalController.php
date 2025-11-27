<?php

namespace App\Http\Controllers;

use App\Services\ApprovalService;
use App\Models\Approval;
use Illuminate\Http\Request;


class ApprovalController extends Controller
{
    public function approve($token)
    {
        $result = ApprovalService::approve($token);
        $approval = Approval::where('approval_token', $token)->first();
        $redirect = $approval->redirect_url ?? '/';

        return redirect($redirect)
            ->with($result['status'] ? 'success' : 'error', $result['message']);
    }

    public function reject($token)
    {
        $result = ApprovalService::reject($token);
        $approval = Approval::where('approval_token', $token)->first();
        $redirect = $approval->redirect_url ?? '/';

        return redirect($redirect)
            ->with($result['status'] ? 'success' : 'error', $result['message']);
    }
}


