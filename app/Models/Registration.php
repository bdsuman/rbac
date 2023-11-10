<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Registration extends Model
{
    protected $fillable=['name','mobile','email','remark','event_id','user_id'];
    
    function event():BelongsTo{
        return $this->belongsTo(Event::class);
    }
}
