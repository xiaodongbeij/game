<?php

namespace App\Models;

use Carbon\Carbon;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Support\Facades\DB;

class UsersReport extends BaseModel
{
    use HasDateTimeFormatter;

    protected $table = 'users_report';
    protected $fillable = ['user_id', 'deposit', 'withdrawal', 'bonus', 'bottom_pour', 'rebates', 'activity', 'addtime', 'created_at','updated_at'];

    public function insertOrUpdate($multipleData)
    {
        $field = implode(',', $this->fillable);
        $sql = "insert into {$this->table}({$field}) values ";
        $date = Carbon::today()->toDateTimeString();
        foreach ($multipleData as $v) {
            $bonus = round($v->bonus,2);
            $bottom_pour = round($v->bottom_pour,2);
           $sql .= "({$v->user_id},0,0,{$bonus},{$bottom_pour},0,0,'{$v->d}','$date','$date'),";
        }
        $sql = rtrim($sql, ',');
        $sql .= "ON DUPLICATE KEY UPDATE ";
        foreach ($this->fillable as $v)
        {
            $sql .= " $v = values($v),";
        }
        $sql = rtrim($sql, ',');

        return DB::select($sql);
    }

    public function scopeUserId($query,$user_id)
    {
        if($user_id)
        {
            return $query->where('user_id', $user_id);
        }
    }

    public function scopeAddtime($query,$addtime)
    {
        $addtime = $addtime ? $addtime : Carbon::today()->toDateString();
        return $query->where('addtime', $addtime);
    }

}
