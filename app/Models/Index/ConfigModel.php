<?php

namespace App\Models\Index;

use Illuminate\Database\Eloquent\Model;

class ConfigModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'configs';

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function getConfig($name)
    {
        $res = self::where('name', $name)->value('json_data');
        return @unserialize($res) ? unserialize($res) : [];
    }
}
