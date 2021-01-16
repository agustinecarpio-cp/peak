<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class ChangePasswordController extends Controller
{
    public function show()
    {
        return view('auth.change-password');
    }

    public function changePassword(Request $request)
    {
        $user = User::query()->find(auth()->user()->id);

        $user->update(['password' => Hash::make($request->get('new_password'))]);

        return redirect(RouteServiceProvider::HOME);

    }
}
