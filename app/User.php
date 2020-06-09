<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:m/d/Y H:i a',
        'email_verified_at' => 'datetime:m/d/Y H:i a',

    ];

    public static function getUsers($offset, $limit, $dir, $order_by, $search_val)
    {
        return self::offset($offset)
            ->limit($limit)
            ->orderBy($order_by, $dir)
            ->when($search_val, function($query, $search_val) {
                return $query->where('name', 'like', '%'.$search_val.'%')
                            ->orWhere('email', 'like', '%'.$search_val.'%');
            })
            ->get();
    }
}
