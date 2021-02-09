<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Answer extends Pivot
{
    protected $guarded = ['id'];  

    protected $casts = ['Note' => 'encrypted'];

    protected $table = 'answers';

}
