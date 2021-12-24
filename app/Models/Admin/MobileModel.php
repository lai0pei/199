<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;

class MobileModel extends Model implements ToModel
{
    use HasFactory;

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function model(array $row)
    {
        dd($row[1]['mobile']);
    }
}
