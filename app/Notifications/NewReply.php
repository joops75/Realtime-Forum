<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Model\Reply;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Http\Resources\ReplyResource;

class NewReply extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'question_title' => $this->reply->question->title,
            'question_path' => $this->reply->question->path,
            'reply_by' => $this->reply->user->name
        ];
    }
    
    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            // structure same as above but with added 'reply' field
            'question_title' => $this->reply->question->title,
            'question_path' => $this->reply->question->path,
            'reply_by' => $this->reply->user->name,
            'reply' => new ReplyResource($this->reply)
        ]);
    }
}
