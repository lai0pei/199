<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: ControlModel.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Monday, 3rd January 2022 8:01:16 am
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2022 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlModel extends Model
{
    use HasFactory;

    public function __construct($data = [])
    {
        $this->data = $data;
        $this->currentDate = '';
    }

    public function __destruct()
    {
        unset($this->currentDate);
    }

    public function getChart()
    {
        $typeModel = new EventTypeModel();
        $type = $typeModel::select('id', 'name')->get()->toArray();
        $day = $this->getLast7Day();
        $recordChart['x-axis'] = $day;
        $recordChart['legend'] = array_column($type, 'name');
        $recordChart['series'] = $this->getSeriesData($type, $day);
        return $recordChart;
    }

    public function getLast7Day()
    {
        $day = -9;
        $allDay = [];
        for ($day; $day < 1; $day++) {
            array_push($allDay, (date('Y-m-d', strtotime($day . ' day'))));
        }
        return $allDay;
    }

    public function getSeriesData($type, $day)
    {
        $series = [];
        $length = count($type);
        foreach ($type as $k => $v) {
            $series[$k]['name'] = $v['name'];
            $series[$k]['type'] = 'line';
            $series[$k]['stack'] = '总量';
            $series[$k]['areaStyle'] = '{}';
            if ($k === $length) {
                $series[$k]['label'] = '{ normal : { show: true, position : top}}';
            }
            $series[$k]['data'] = $this->calDay($day, $v);
        }

        return $series;
    }

    public function calDay($day, $data)
    {
        $eventModel = new EventModel();
        $tmp = [];
        foreach ($day as $v) {
            $this->currentDate = $v;
            $count = 0;
            $applyUser = $eventModel::where('type_id', $data['id'])->select('id')->with('userApply', function ($query) {
                $query->whereDate('apply_time', $this->currentDate);
            })->get()->toArray();
            foreach ($applyUser as $user) {
                $count += count($user['user_apply']);
            }
            array_push($tmp, $count);
        }
        return $tmp;
    }
}
