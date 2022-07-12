<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\User\Create;
use App\Http\Requests\User\Update;
use App\Repositories\UserRepository;
use App\Http\Requests\Index\Pagination;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    private $UserRepo;
    public function __construct(UserRepository $UserRepo)
    {
        $this->UserRepo = $UserRepo;
        $this->middleware('role:admin', ['only' => ['index', 'update', 'store','show', 'activeUsers','destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Pagination $request)
    {
        $request->validated();
        return $this->UserRepo->getList($request->take);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        $user = $request->validated();
        $user['password'] = bcrypt($request->password);
        if($request->hasFile('image')){
            $user['image'] = $request->file('image')->store('avatars');
        }
        return $this->UserRepo->create($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->UserRepo->show($id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function activeUsers($id)
    {
        $user = $this->UserRepo->show($id);
        if($user->is_active){
            $user->is_active = 0;
            $user->save();
            return response()->json([
                'success' => true,
                'message' => 'User unactive',
            ], Response::HTTP_OK);
        }else{
            $user->is_active = 1;
            $user->save();
            return response()->json([
                'success' => true,
                'message' => 'User activated',
            ], Response::HTTP_OK);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $user = $request->validated();
        if($request->has('password')){
            $user['password'] = bcrypt($user['password']);
        }
        if($request->hasFile('image')){
            $user['image'] = $request->file('image')->store('avatars');
        }
        $this->UserRepo->update($id, $user);
        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->UserRepo->delete($user);
        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully',
        ], Response::HTTP_OK);
    }
}
