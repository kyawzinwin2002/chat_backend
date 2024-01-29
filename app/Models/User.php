<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    public function friends()
    {
        return $this->belongsToMany(User::class, "friends", "user_id", "friend_id")->withPivot("status");
    }

    public function add(User $receiver)
    {
        $this->friends()->attach($receiver->id, ["status" => Status::Pending]);
        $receiver->friends()->attach($this->id, ["status" => Status::Deciding]);
    }

    public function accept(User $sender)
    {
        $this->friends()->sync([$sender->id => ["status" => Status::Friend]], false);
        $sender->friends()->sync([$this->id => ["status" => Status::Friend]], false);
        $conversation = Conversation::create();
        $this->conversations()->attach($conversation);
        $sender->conversations()->attach($conversation);
    }

    public function unfriend(User $friend)
    {
        $this->friends()->detach($friend->id);
        $friend->friends()->detach($this->id);
    }

    public function listOfFriends()
    {
        $friends = $this->load(["friends" => function ($q) {
            $q->wherePivot("status", Status::Friend)->get();
        }])->friends;

        return $friends;
    }

    public function receivedRequests()
    {
        $requests = $this->load(["friends" => function ($q) {
            $q->wherePivot("status", Status::Deciding)->get();
        }])->friends;

        return $requests;
    }

    public function sentRequests()
    {
        $requests = $this->load(["friends" => function ($q) {
            $q->wherePivot("status", Status::Pending)->get();
        }])->friends;

        return $requests;
    }

    public function strangers()
    {
        return User::whereNotIn("id", $this->listOfFriends()->pluck("id")->toArray())
            ->where("id", "<>", $this->id)
            ->get();
    }

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, "conversation_user", "user_id", "conversation_id");
    }

    public function messages()
    {
        return $this->hasMany(Message::class, "user_id");
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
