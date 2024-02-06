<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    const maxLengthPassword = 12;
    const minLengthPassword = 5;
    const maxLengthName = 15;
    const maxLengthLastName = 15;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_name',
        'banned_user'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function topics(): HasMany {
        return $this->hasMany(Topic::class);
    }

    public function comments(): HasMany {
        return $this->hasMany(Comment::class);
    }

    public static function passwordLengthCheck($password) {
        return strlen($password) > User::minLengthPassword && strlen($password) <= User::maxLengthPassword;
    }
    public static function nameLengthCheck($name) {
        return strlen($name) > 0 && strlen($name) <= User::maxLengthName;;
    }
    public static function lastNameLengthCheck($lastName) {
        return strlen($lastName) > 0 && strlen($lastName) <= User::maxLengthLastName;;
    }
}
