<?php

namespace App\Listeners;

use App\Events\UserVerified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\NotificationRepository;
use App\Defined\SystemDefined;

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
        $this->repo->create([
            'user_id' => $event->user->id,
            'title' => __('notification.verify.title'),
            'content' => __('notification.verify.content', ['day' => SystemDefined::USER_DEFAULT_DAYS])
        ]);
    }
}
