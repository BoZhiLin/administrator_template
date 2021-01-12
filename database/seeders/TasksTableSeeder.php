<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Defined\TaskDefined;
use App\Models\Task;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** 有新增任務 都必須添加 */
        $now = now();
        $tasks = [
            [
                'name' => '每日簽到',
                'code' => TaskDefined::TASK_SIGN_IN
            ],
            [
                'name' => '完成個資',
                'code' => TaskDefined::TASK_COMPLETED_PROFILE
            ]
        ];

        foreach ($tasks as $field) {
            $task = new Task();
            $task->name = $field['name'];
            $task->code = $field['code'];
            $task->started_at = $now;
            $task->ended_at = $now->addMonth();
            $task->save();
        }
    }
}
