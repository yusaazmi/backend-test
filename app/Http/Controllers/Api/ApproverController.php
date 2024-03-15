<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Approver;
use App\Http\Requests\Api\ApproversRequest;
use App\Util\ResponseUtil;


class ApproverController extends Controller
{
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
     *     path="/approvers",
     *     operationId="Create Approver",
     *     tags={"Approvers"},
     *     summary="Create a new Approver",
     *     description="Membuat data Approver",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Approvers data",
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Mariana"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Approvers created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer",default=1),
     *             @OA\Property(property="name", type="string",default="Mariana"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(ApproversRequest $request)
    {
        try{
            $approver = new Approver;
            $approver->name = $request->name;
            $approver->save();

            return ResponseUtil::noticeResponse('success',200,$approver);
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
