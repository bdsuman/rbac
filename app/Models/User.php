<?php
namespace App\Models;
use App\Traits\HasPermissionsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,
        HasFactory,
        Notifiable,
        HasPermissionsTrait;
    protected $fillable = ['name','email','mobile','password','otp','role'];
    protected $attributes = [
        'otp' => '0',
        'mobile'=>''
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    function category():HasMany{
        return $this->HasMany(Category::class);
    }
    function user():HasMany{
        return $this->HasMany(User::class);
    }
}
