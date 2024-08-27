<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'is_done' => $this->is_done,
            'status' => $this->is_done ? 'closed' : 'open', // Assuming you want to keep this status logic
            'creator_id' => $this->creator_id,  // Include the creator_id field
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,  // Include the updated_at field
        ];
    
    }
}