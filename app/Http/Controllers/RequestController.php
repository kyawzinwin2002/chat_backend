<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    public function requests()
    {
        return Auth::user()->receivedRequests();
    }

    public function sentRequests()
    {
        return Auth::user()->sentRequests();
    }

    public function delete($id)
    {
        $user = User::find($id);
        return Auth::user()->unfriend($user);
    }
}
