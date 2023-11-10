<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['name','email','mobile','password','otp'];
    protected $attributes = [
        'otp' => '0'
    ];

    function category():HasMany{
        return $this->HasMany(Category::class);
    }
    function user():HasMany{
        return $this->HasMany(User::class);
    }
}
