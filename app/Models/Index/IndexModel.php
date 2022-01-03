<?php

namespace App\Models\Index;

use Illuminate\Database\Eloquent\Model;

class IndexModel extends Model
{
    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function getEvent()
    {
    }
}
