<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\ApprovalStageRequest;
use App\Models\ApprovalStage;
use App\Util\ResponseUtil;


class ApprovalStageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

      /**
    *    @OA\Get(
    *       path="/approval-stages",
    *       tags={"Approval Stages"},
    *       operationId="Get Data Approval Stages",
    *       summary="Data Approval Stages",
    *       description="Mengambil Data Approval Stages",
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data Approval Stages",
    *               "data": {
    *                   {
    *                   "id": 1,
    *                   "approver_id": 1,
    *                  }
    *              }
    *          }),
    *      ),
    *  )
    */
    public function index()
    {
        try{
            $approvalStage = ApprovalStage::orderBy('id','asc')
                                ->get();
            return ResponseUtil::noticeResponse('success',200,$approvalStage);
        }catch(\Exception $e){
            return ResponseUtil::errorResponse($e->getMessage(),422);
        }
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
     *     path="/approval-stages",
     *     operationId="Create Approval Stages",
     *     tags={"Approval Stages"},
     *     summary="Create a new Approval Stages",
     *     description="Membuat data Approval Stages",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Approval Stagess data",
     *         @OA\JsonContent(
     *             @OA\Property(property="approver_id", type="number", example="1"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Approval Stagess created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer",default=1),
     *             @OA\Property(property="approver_id", type="number",default="1"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(ApprovalStageRequest $request)
    {
        try{
            $approvalStage = new ApprovalStage;
            $approvalStage->approver_id = $request->approver_id;
            $approvalStage->save();

            return ResponseUtil::noticeResponse('success',200,$approvalStage);
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
    public function show($id)
    {
        //
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

     /**
     * @OA\Put(
     *     path="/approval-stages/{id}",
     *     operationId="Update Approval Stages",
     *     tags={"Approval Stages"},
     *     summary="Update a new Approval Stages",
     *     description="Membuat data Approval Stages",
     *          @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the approval stage",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Approval Stagess data",
     *         @OA\JsonContent(
     *             @OA\Property(property="approver_id", type="number", example="1"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Approval Stagess Updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer",default=1),
     *             @OA\Property(property="approver_id", type="number",default="1"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(ApprovalStageRequest $request, $id)
    {
        try{
            $approvalStage = ApprovalStage::find($id);
            if(!$approvalStage){
                return response()->json([
                    'success' => false,
                    'message' => 'data not found',
                ], 401);
            }
            $approvalStage->approver_id = $request->approver_id;
            $approvalStage->save();

            return ResponseUtil::noticeResponse('success',200,$approvalStage);
        }catch(\Exception $e){
            return ResponseUtil::errorResponse($e->getMessage(),422);
        }
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
