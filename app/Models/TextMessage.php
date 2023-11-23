<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextMessage extends Model
{
    use HasFactory;

    protected $fillable = ["content"];

    public function message()
    {
        return $this->morphOne(Message::class,"messageable");
    }

}
