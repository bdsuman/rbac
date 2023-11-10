<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    protected $fillable = ['image','type','title','description','date','time','location','user_id','categorie_id'];
    
    function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
    function category():BelongsTo{
        return $this->belongsTo(Category::class,'categorie_id');
    }
}
