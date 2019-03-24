<?php

namespace App\Http\Resources;

use App\Model\Task;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $task = Task::find($this->task_id);

        return [
            'id' => $task->id,
            'title' => $task->title,
            'body' => $task->body,
            'updated_at' => $task->updated_at,
            'accepted_at' => $this->accepted_at,
            'user_id' => $task->user_id,
        ];
    }
}
