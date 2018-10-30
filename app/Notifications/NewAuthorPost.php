<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewAuthorPost extends Notification implements ShouldQueue
{
    use Queueable;

    public $post;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($post)
    {
        // Author send to Admin, and request from admin consider this post and apply approved post
        // check function store in Author/PostController, if you understand and view more detail
        $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
       
        $url = url(route('admin.post.show',$this->post->id));

        return (new MailMessage)
                ->greeting('Hello Admin')
                ->line('New post need approved')
                // model Post relation User via user method
                ->line('New post by'.$this->post->user->name.'Need to approved')
                ->line('To approved the post click view button')
                ->line('Post title : '. $this->post->title)
                ->action('View', $url)
                ->line('Thank you for using our application!');

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
            //
        ];
    }
}
