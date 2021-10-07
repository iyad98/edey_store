<?php

namespace App\Http\Resources\Comment;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{


    public function toArray($request)
    {
        return [
            'user' => [
                'id' => $this->user->id ,
                'name' => $this->user->first_name ." ".$this->user->last_name ,
                'image' => $this->user->image ,
            ] ,
            'product' => [
                'id' => $this->product->id ,
                'name' => $this->product->name ,
            ],
            'comment' => $this->comment ,
            'date' => $this->created_at->diffForHumans() ,
        ];
    }
}
