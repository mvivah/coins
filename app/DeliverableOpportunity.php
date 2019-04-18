<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliverableOpportunity extends Model
{
    protected $guarded = [];
    protected $table = 'deliverable_opportunity';

    public function tasks(){

        return $this->belongsTo('App\Task'); 

    }
}
