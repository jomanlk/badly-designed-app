<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => new UserResource(User::find($this->user_id)),
            'message' => $this->message,
            'heart_count' => $this->heart_count,
	        'recent_heart' => new HeartResource($this->recent_heart),
            'channels' => explode(' ', $this->channels),
            'hearts' => HeartResource::collection($this->whenLoaded('hearts'))
        ];
    }
}
