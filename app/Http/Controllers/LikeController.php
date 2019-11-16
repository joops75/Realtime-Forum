<?php

namespace App\Http\Controllers;

use App\Model\Like;
use App\Model\Reply;
use Symfony\Component\HttpFoundation\Response;
use App\Events\LikeEvent;

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

        broadcast(new LikeEvent($reply->id, 1))->toOthers();

        return response('created', Response::HTTP_CREATED);
    }
    
    public function unLikeIt(Reply $reply) {
        $reply->like()->delete([
            'user_id' => auth()->user()->id
        ]);

        broadcast(new LikeEvent($reply->id, 0))->toOthers();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
