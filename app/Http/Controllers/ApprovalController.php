<?php

namespace App\Http\Controllers;

use App\Services\ApprovalService;
use App\Models\Approval;
use Illuminate\Http\Request;


class ApprovalController extends Controller
{
    public function process($token)
    {
        $result = ApprovalService::approve($token);

        $approval = Approval::where('approval_token', $token)->first();

        $redirectUrl = $approval->redirect_url ?? url('/'); // fallback to home

        return redirect($redirectUrl)
            ->with($result['status'] ? 'success' : 'error', $result['message']);
    }
}

