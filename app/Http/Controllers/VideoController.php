<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Requests\Video\Create;
use App\Http\Requests\Video\Update;
use App\Repositories\VideoRepository;
use App\Http\Requests\Index\Pagination;
use Symfony\Component\HttpFoundation\Response;

class VideoController extends Controller
{
    private $VideoRepo;
    public function __construct(VideoRepository $VideoRepo)
    {
        $this->VideoRepo = $VideoRepo;
        $this->middleware('role:admin', ['only' => ['index', 'update', 'store','show','destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Pagination $request)
    {
        $request->validated();
        return $this->VideoRepo->getList($request->take);
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getVideoToActiveUsers(Pagination $request)
    {
        if(auth()->user()->rule->name == 'client'){
            if(auth()->user()->is_active == 1){
                $request->validated();
                return $this->VideoRepo->getList($request->take);
            }
            return response()->json(['message' => 'You are not active'], Response::HTTP_FORBIDDEN);
        }
        return response()->json(['message' => 'You are not authorized'], Response::HTTP_FORBIDDEN);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        $video = $request->validated();
        $video['user_id'] = auth()->user()->id;  
        if($request->hasFile('image')){
            $video['image'] = $request->file('image')->store('posters');
        }
        if($request->hasFile('video')){
            $video['video'] = $request->file('video')->store('videos');
        }
        return $this->VideoRepo->create($video);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Models\Video  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->VideoRepo->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Models\Video  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $video = $request->validated();
        if($request->hasFile('image')){
            $video['image'] = $request->file('image')->store('posters');
        }
        if($request->hasFile('video')){
            $video['video'] = $request->file('video')->store('videos');
        }
        $this->VideoRepo->update($id, $video);
        return response()->json([
            'success' => true,
            'message' => 'Video updated successfully',
            'data' => $this->VideoRepo->show($id)
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        $this->VideoRepo->delete($video);
        return response()->json([
            'success' => true,
            'message' => 'Video deleted successfully',
        ], Response::HTTP_OK);
    }
}
