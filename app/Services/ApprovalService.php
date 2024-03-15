<?php

namespace App\Services;

use App\Models\Expense;
use App\Models\Approval;
use App\Models\ApprovalStage;
use App\Util\ResponseUtil;

class ApprovalService
{
    public function approveExpense($id, $approver_id)
    {
        try{
            $expense = Expense::with('status','approval')->find($id);
            $approval = Approval::orderBy('id','asc')
                                ->where('expense_id',$id)
                                ->pluck('approver_id')
                                ->toArray();
            $approvalStages = ApprovalStage::orderBy('id', 'asc')
                                ->get();
            $countApproval = count($approval);
            $countApprovalStage = count($approvalStages);
            if($countApproval < 1){
                if($approver_id == $approvalStages->first()->approver_id){
                    $approval = new Approval;
                    $approval->expense_id = $id;
                    $approval->approver_id = $approver_id;
                    $approval->status_id = 2;
                    $approval->save();
                }
                else{
                    return ResponseUtil::errorResponse("Approval tidak sesuai urutan",403);
                }
            }
            else if($countApproval == $countApprovalStage){
                return ResponseUtil::noticeResponse('Semua urutan approval sudah terpenuhi',403,$expense);
            }
            else{
                $getStage = ApprovalStage::orderBy('id','asc')
                                        ->whereNotIn('approver_id',$approval)
                                        ->first();
                if($approver_id == $getStage->approver_id){
                    $approval = new Approval;
                    $approval->expense_id = $id;
                    $approval->approver_id = $approver_id;
                    $approval->status_id = 2;
                    $approval->save();
                    // cek apakah data approval sudah memenuhi stage
                    $approval = Approval::orderBy('id','asc')
                                ->where('expense_id',$id)
                                ->pluck('approver_id')
                                ->toArray();
                    $approvalStages = ApprovalStage::orderBy('id', 'asc')
                                ->get();
                    if(count($approval) == count($approvalStages))
                    {
                        $expense->status_id = 2;
                        $expense->save();
                    }
                }
                else{
                    return ResponseUtil::errorResponse("Approval tidak sesuai urutan",403);
                }
            }
            $newExpense = Expense::with('status','approval')->find($id);
            return ResponseUtil::noticeResponse('success',200,$newExpense);
        }catch(\Exception $e){
            return ResponseUtil::errorResponse($e->getMessage(),422);
        }
    }
}
