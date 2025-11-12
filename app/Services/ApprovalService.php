<?php

namespace App\Services;
use App\Mail\ApprovalMail;
use App\Models\Approval;
use App\Models\Lead;
use App\Models\Timeline;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ApprovalService
{
    /**
     * Create a new class instance.
     */

    // public static function request($email, $action, array $data)
    // {
    //     $approval = Approval::create([
    //         'action' => $action,
    //         'data' => $data,
    //         'email' => $email,
    //         'approval_token' => Str::uuid(),
    //     ]);

    //     Mail::to($email)->send(new ApprovalMail($approval));

    //     return $approval;
    // }
     public static function request($email, $action, array $data, $redirectUrl = null)
    {
        $approval = Approval::create([
            'action' => $action,
            'data' => $data,
            'email' => $email,
            'redirect_url' => $redirectUrl,
            'approval_token' => Str::uuid(),
        ]);

        Mail::to($email)->send(new ApprovalMail($approval));

        return $approval;
    }

    public static function approve($token)
    {
        $approval = Approval::where('approval_token', $token)->first();

        if (!$approval) {
            return ['status' => false, 'message' => 'Invalid or expired approval link'];
        }

        if ($approval->is_approved) {
            return ['status' => false, 'message' => 'This approval link has already been used'];
        }

        $approval->update(['is_approved' => true]);

        // Execute the corresponding action
        self::handleAction($approval->action, $approval->data);

        return ['status' => true, 'message' => 'Action successfully approved and executed'];
    }

    protected static function handleAction($action, $data)
    {
        switch ($action) {
            // CREATE LEAD after approval
            case 'create_lead':
                $validated = $data['data'];
                $creatorId = $data['creator_id'] ?? null;
 
                $lead = Lead::create([
                    'name' => $validated['name'],
                    'assignee_id' => $validated['assignee_id'] ?? null,
                    'close_date' => $validated['close_date'] ?? null,
                    'confidence' => $validated['confidence'] ?? null,
                    'creator_id' => $creatorId,
                ]);

                // Attach related data (companies, people, etc.)
                if (!empty($validated['company_id'])) {
                    $lead->companies()->attach($validated['company_id']);
                }

                if (!empty($validated['person_id'])) {
                    $lead->peoples()->attach($validated['person_id']);
                }

                if (!empty($validated['product_id'])) {
                    foreach ($validated['product_id'] as $index => $productId) {
                        $lead->products()->attach($productId, [
                            'qty' => $validated['quantity'][$index] ?? 1,
                            'price' => $validated['price'][$index] ?? 0,
                        ]);
                    }
                }

                if (!empty($validated['source_id'])) {
                    $lead->sources()->attach($validated['source_id']);
                }

                if (!empty($validated['competitors_id'])) {
                    $lead->competitors()->attach($validated['competitors_id']);
                }

                if (!empty($validated['tag_id'])) {
                    $lead->tags()->attach($validated['tag_id']);
                }

                break;

            // UPDATE LEAD STAGE after approval
            case 'update_lead_stage':
                $lead = Lead::find($data['lead_id']);
                if ($lead) {
                    $lead->update(['stage_id' => $data['new_stage_id']]);

                    // Log timeline
                    Timeline::create([
                        'user_id' => $data['user_id'] ?? null,
                        'owner_type' => 'lead',
                        'owner_id' => $lead->id,
                        'action_type' => 'updated_stage',
                        'description' => "changed the stage of {$lead->name} from {$data['old_stage']} to {$data['new_stage']}",
                    ]);
                }
                break;

            default:
                \Log::warning("Unhandled approval action: {$action}");
                break;
        }
    }
}
