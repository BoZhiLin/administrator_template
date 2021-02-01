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
        $details = [
            [
                'user_id' => $event->fromUser,
                'content' => ''
            ],
            [
                'user_id' => $event->targetUser,
                'content' => ''
            ]
        ];
        $user_ids = [
            $event->fromUser,
            $event->targetUser
        ];
        $users = User::find($user_ids); // collection

        foreach ($users as $user) {
            $this->repo->create([
                'user_id' => $user->id,
                'title' => '',
                'content' => ''
            ]);
        }
    }
}
