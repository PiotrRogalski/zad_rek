<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Task extends Model
{
    protected $hidden = ['created_at'];
    protected $fillable = [
        'title',
        'body',
        'owner_id',
    ];

    protected $withCount = [
        'users',
        'usersAccepted',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = Str::slug($model->name);
        });
    }

    public function usersAccepted()
    {
        return $this->users()->whereNotNull('accepted_at');
    }

    public function users()
    {
        return $this->belongsToMany(\App\User::class, 'task_user', 'task_id', 'user_id')
                    ->withPivot('accepted_at');
    }

    public function owner()
    {
        return $this->belongsTo(\App\User::class, 'users', 'owner_id', 'id');
    }
}
