<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class EventModel extends Model
{
   
    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function getEventBy(){

        $data = $this->data;

        if(empty($data['id'])){
            return [];
        }
        return self::find($data['id'])->toArray();
    }
}
