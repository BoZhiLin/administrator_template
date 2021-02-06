<?php

namespace App\Listeners;

use App\Events\UserMatchInvite;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\User;
use App\Repositories\NotificationRepository;

class UserInviteNotification
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
     * @param  UserMatchInvite  $event
     * @return void
     */
    public function handle(UserMatchInvite $event)
    {
        $from_user = User::find($event->fromUser);
        $target_user = User::find($event->targetUser);
        
        $this->repo->create([
            'user_id' => $target_user->id,
            'title' => __('notification.invite.title'),
            'content' => __('notification.invite.content', ['user' => $from_user->nickname])
        ]);
    }
}
