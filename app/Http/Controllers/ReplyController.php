<?php

namespace App\Http\Controllers;

use App\Model\Reply;
use Illuminate\Http\Request;
use App\Model\Question;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\ReplyResource;
use App\Notifications\NewReply;
use App\Events\AddReplyEvent;
use App\Events\DeleteReplyEvent;
use App\Events\EditReplyEvent;

class ReplyController extends Controller
{
    /**
     * Create a new ReplyController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Question $question)
    {
        return ReplyResource::collection($question->replies()->latest()->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Question $question)
    {
        $reply = $question->replies()->create($request->all());

        if ($reply->user_id !== $question->user_id) {
            $question->user->notify(new NewReply($reply));
        }

        broadcast(new AddReplyEvent($question->id, new ReplyResource($reply)))->toOthers();

        return response(new ReplyResource($reply), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question, Reply $reply)
    {
        return new ReplyResource($reply);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question, Reply $reply)
    {
        $reply->update($request->all());

        broadcast(new editReplyEvent(new ReplyResource($reply)))->toOthers();

        return response(new ReplyResource($reply), Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Reply $reply)
    {
        $reply->delete();

        broadcast(new DeleteReplyEvent($question->id, $reply->id))->toOthers();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
