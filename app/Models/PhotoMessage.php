<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoMessage extends Model
{
    use HasFactory;

    protected $fillable = ["url"];

    public function message()
    {
        return $this->morphOne(Message::class, "messageable");
    }
}
