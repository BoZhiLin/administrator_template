<?php

namespace App\Repositories;

class UserMatchRepository extends Repository
{
    public static function sendOrMatch(array $data)
    {
        ['from_id' => $from_id, 'match_id' => $match_id] = $data;
        $match_info = static::getByBothUser($from_id, $match_id);

        if (is_null($match_info)) {
            $model = static::getModel();
            $match_info = new $model();
            $match_info->from_id = $from_id;
            $match_info->match_id = $match_id;
        } else {
            $match_info->is_matched = true;
            $match_info->matched_at = now();
        }

        $match_info->save();
        return $match_info;
    }

    public static function getByBothUser(int $from_id, int $match_id)
    {
        return static::getModel()::where(function ($query) use ($from_id, $match_id) {
                $query->where('from_id', $from_id)
                    ->where('match_id', $match_id);
            })
            ->orWhere(function ($query) use ($from_id, $match_id) {
                $query->where('from_id', $match_id)
                    ->where('match_id', $from_id);
            })
            ->first();
    }

    public static function getModel()
    {
        return \App\Models\UserMatch::class;
    }
}
