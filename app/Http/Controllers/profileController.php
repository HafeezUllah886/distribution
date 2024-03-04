<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class profileController extends Controller
{
    public function index()
    {
        return view('auth.setting.index');
    }

    public function updateProfile(request $req)
    {
        $user = User::find(auth()->user()->id);
        $user->name = $req->name;
        $user->email = $req->email;
        $user->save();

        return redirect()->route('logout')->with('success', "Profile Updated Successfully");
    }

    public function updatePassword(request $req)
    {
        $req->validate(
            [
                'password' => 'required|min:5|confirmed'
            ]
        );
        $user = User::find(auth()->user()->id);
        $user->password = Hash::make($req->password);
        $user->save();

        return redirect()->route('logout')->with('success', "Password Changed");
    }
}
