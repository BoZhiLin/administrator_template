<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Defined\ConfigDefined;
use App\Models\Config;

class ConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $configs = [
            ['type' => ConfigDefined::DEFAULT_EXPIRED_IN, 'value' => 3],
            ['type' => ConfigDefined::GENERAL_EXPIRED_IN, 'value' => 30]
        ];

        foreach ($configs as $config) {
            $model = new Config();
            $model->type = $config['type'];
            $model->value = $config['value'];
            $model->save();
        }
    }
}
