<?php

namespace Auth\Infrastructure\Eloquent;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class EloquentUser
 *
 * @package Auth\Infrastructure\Eloquent
 */
class EloquentUser extends Authenticatable
{
    use Notifiable;

    /** @var boolean  オートインクリメントの可否 */
    public $incrementing = false;
    /** @var string  プライマキーのカラム名 */
    protected $primaryKey = 'id';
    /** @var string  プライマキーの型 */
    protected $keyType = 'string';
    /** @var string テーブル名 */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var string[]
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
