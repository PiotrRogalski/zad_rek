<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Relations\Pivot;


class TaskUser extends Pivot
{
    public $timestamps = false;
    protected $table = 'task_user';

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
