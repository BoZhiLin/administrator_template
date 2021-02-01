<?php

namespace App\Listeners;

use App\Events\UserVerified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\NotificationRepository;

class VerifiedVipNotification
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
     * @param  UserVerified  $event
     * @return void
     */
    public function handle(UserVerified $event)
    {
        $notification = [
            'user_id' => $event->user->id,
            'title' => $event->title,
            'content' => $event->content
        ];
        $this->repo->create($notification);
    }
}
