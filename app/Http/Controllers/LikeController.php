<?php

namespace App\Http\Controllers;

use App\Model\Like;
use App\Model\Reply;
use Symfony\Component\HttpFoundation\Response;

class LikeController extends Controller
{
    /**
     * Create a new LikeController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt');
    }

    public function likeIt(Reply $reply) {
        $reply->like()->create([
            'user_id' => auth()->user()->id
        ]);
        return response('created', Response::HTTP_CREATED);
    }
    
    public function unLikeIt(Reply $reply) {
        $reply->like()->delete([
            'user_id' => auth()->user()->id
        ]);
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
