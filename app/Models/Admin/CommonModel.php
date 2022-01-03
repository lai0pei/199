<?php

namespace App\Models\Admin;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class CommonModel extends Model
{
    public function toTime($time)
    {
        return Carbon::parse($time)->format('Y年-m月-d日  | H时:i分:s秒');
    }
    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     *
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
