<?php

namespace App\Listeners;

use App\Events\UserMatched;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\User;
use App\Repositories\NotificationRepository;

class UserMatchNotification
{
    protected $repo;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(NotificationRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Handle the event.
     *
     * @param  UserMatched  $event
     * @return void
     */
    public function handle(UserMatched $event)
    {
        $from_user = User::find($event->fromUser);
        $target_user = User::find($event->targetUser);
        $notifications = [
            [
                'user_id' => $event->fromUser,
                'title' => __('notification.like.title'),
                'content' => __('notification.like.content', ['user' => $target_user->nickname])
            ],
            [
                'user_id' => $event->targetUser,
                'title' => __('notification.like.title'),
                'content' => __('notification.like.content', ['user' => $from_user->nickname])
            ]
        ];

        foreach ($notifications as $notification) {
            $this->repo->create([
                'user_id' => $notification['user_id'],
                'title' => $notification['title'],
                'content' => $notification['content']
            ]);
        }
    }
}
