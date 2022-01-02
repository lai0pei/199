<?php

namespace App\Models\Admin;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ControlModel extends Model
{
    use HasFactory;

    public function getChart(){
        $typeModel = new EventTypeModel();
        $type = $typeModel::select('name')->all()->toArray();
        
    }

    public function getLast7Day(){
        $date = Carbon::today();
        return [
            $date,
            $date->subDays(1),
            $date->subDays(2),
            $date->subDays(3),
            $date->subDays(4),
            $date->subDays(5),
            $date->subDays(6),

        ];
    }
}
