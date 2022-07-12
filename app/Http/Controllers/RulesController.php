<?php

namespace App\Http\Controllers;

use App\Models\Rules;
use App\Http\Requests\Rules\Create;
use App\Http\Requests\Rules\Update;
use App\Repositories\RulesRepository;
use App\Http\Requests\Index\Pagination;

class RulesController extends Controller
{
    private $RulesRepo;
    public function __construct(RulesRepository $RulesRepo)
    {
        $this->RulesRepo = $RulesRepo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Pagination $request)
    {
        $request->validated();
        return $this->RulesRepo->getList($request->take);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        // $rule = $request->validated();
        // $response = $this->RulesRepo->create($rule);
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Rule created successfully',
        //     'data' => $response

        // ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rules  $rules
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->RulesRepo->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rules  $rules
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
    //     $rule = $request->validated();
    //     $this->RulesRepo->update($id, $rule);
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Rule updated successfully',
    //     ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rules  $rules
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rules $rule)
    {
    //     $this->RulesRepo->delete($rule);
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Rule deleted successfully',
    //     ], Response::HTTP_OK);
    }
}
