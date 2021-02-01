<?php

namespace App\Services;

use App\Defined\ResponseDefined;

use App\Models\User;

class NotificationService extends Service
{
    /**
     * 取得屬於自己的通知
     * 
     * @param User $user
     * @return array
     */
    public function getByUser(User $user)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $notifications = $user->notifications()
            ->orderBy('created_at', 'desc')
            ->get();

        $response['data']['notifications'] = $notifications;

        return $response;
    }

    /**
     * 已讀通知
     * 
     * @param User $user
     * @param int $id
     * @return array
     */
    public function markAsRead(User $user, int $id)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $notification = $user->notifications->firstWhere('id', $id);

        if (is_null($notification)) {
            $response['status'] = ResponseDefined::NOTIFICATION_NOT_FOUND;
        } elseif ($notification->is_read) {
            $response['status'] = ResponseDefined::NOTIFICATION_HAS_READ;
        } else {
            $notification->is_read = true;
            $notification->read_at = now();
            $notification->save();
        }
        
        return $response;
    }
}
