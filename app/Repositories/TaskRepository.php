<?php

namespace App\Repositories;

class TaskRepository extends Repository
{
    /**
     * 依據任務代碼，查詢開放中任務
     */
    public static function findOpeningByCode(string $code)
    {
        $now = now();

        return static::getModel()::ofCode($code)
            ->where(function ($query) use ($now) {
                $query->where('started_at', '<=', $now)
                    ->where('ended_at', '>=', $now);
            })
            ->orWhere(function ($query) use ($now) {
                $query->where('started_at', '<=', $now)
                    ->whereNull('ended_at');
            })
            ->first();
    }

    public static function createRecordByUser(int $user_id, array $task_info = [])
    {
        $task = static::findOpeningByCode($task_info['code']);

        if (!is_null($task)) {
            $field = [
                'user_id' => $user_id,
                'reward_type' => $task_info['reward_type'],
                'reward_value' => $task_info['reward_value'],
                'completed_at' => now()
            ];

            if (isset($task_info['link'])) {
                $field['link'] = $task_info['link'];
            }
            
            $task->taskRecords()->create($field);
        }
    }
    
    public static function getModel()
    {
        return \App\Models\Task::class;
    }
}
