<?php

namespace App\Models\Index;

use Illuminate\Database\Eloquent\Model;

class EventModel extends Model
{
    public function __construct($data = [])
    {  
      $this->data = $data;  
    }

        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'event';

     /**
     * event
     *
     * @return void
     */
    public function event()
    {
        return $this->belongsTo(EventTypeModel::class);
    }


}
