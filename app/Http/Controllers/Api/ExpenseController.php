<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\ExpenseRequest;
use App\Http\Requests\Api\ApproveExpenseRequest;
use App\Models\Expense;
use App\Models\Approval;
use App\Models\ApprovalStage;
use App\Util\ResponseUtil;
use App\Services\ApprovalService;



class ExpenseController extends Controller
{
    protected $approvalService;

    public function __construct(ApprovalService $approvalService)
    {
        $this->approvalService = $approvalService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Post(
     *     path="/expense",
     *     operationId="Create Expense",
     *     tags={"Expenses"},
     *     summary="Create a new expense",
     *     description="Membuat data expense",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Expense data",
     *         @OA\JsonContent(
     *             @OA\Property(property="amount", type="number", example=50000),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Expense created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="amount", type="number", format="float"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */


    public function store(ExpenseRequest $request)
    {
        try{
            $expense = new Expense;
            $expense->amount = $request->amount;
            $expense->status_id = 1;
            $expense->save();

            return ResponseUtil::noticeResponse('success',200,$expense);
        }catch(\Exception $e){
            return ResponseUtil::errorResponse($e->getMessage(),422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     /**
    *    @OA\Get(
    *       path="/expense/{id}",
    *       tags={"Expenses"},
    *       operationId="Get Data",
    *       summary="Data Expense",
    *       description="Mengambil Data Expense",
    *          @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID of the expense",
    *         required=true,
    *         @OA\Schema(
    *             type="integer",
    *             format="int64"
    *         )
    *     ),
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data Expense",
    *               "data": {
    *                   {
    *                   "id": "1",
    *                   "amount": 500000,
    *                  }
    *              }
    *          }),
    *      ),
    *  )
    */
    public function show($id)
    {
        try{
            $expense = Expense::with('status','approval')->find($id);
            if(!$expense){
                return response()->json([
                    'success' => false,
                    'message' => 'data not found',
                ], 401);
            }
            return ResponseUtil::noticeResponse('success',200,$expense);
        }catch(\Exception $e){
            return ResponseUtil::errorResponse($e->getMessage(),422);
        }
    }

    /**
     * @OA\Patch(
     *     path="/expense/{id}/approve",
     *     operationId="update approval Expense",
     *     tags={"Expenses"},
     *     summary="Update data approval expense",
     *     description="Update data approval expense",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the expense",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Expense data",
     *         @OA\JsonContent(
     *             @OA\Property(property="approver_id", type="integer", example=1),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Expense updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="amount", type="integer"),
     *             @OA\Property(property="status_id", type="integer"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Expense not found"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Approval tidak sesuai urutan"
     *     )
     * )
     */

    public function approve(ApproveExpenseRequest $request,$id)
    {
        try{
            $expense = Expense::find($id);
            if(!$expense){
                return ResponseUtil::errorResponse('Data not found',402);
            }
            $result = $this->approvalService->approveExpense($id, $request->approver_id);
            return $result;
        }catch(\Exception $e){
            return ResponseUtil::errorResponse($e->getMessage(),422);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
