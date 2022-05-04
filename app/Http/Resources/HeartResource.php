<?php

namespace App\Http\Resources;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class HeartResource extends JsonResource
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
            'message' => new MessageResource(Message::find($this->message_id)),
            'created_at' => $this->created_at,
        ];
    }
}
