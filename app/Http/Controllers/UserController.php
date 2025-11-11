<?php

namespace App\Http\Controllers;
use App\Models\User;

class UserController extends Controller
{
    public function destroy(user $user)
    {
        if(auth()->user()->isAdmin()){
            abort(403, 'Anda tidak berhak menghapus user.');
        }
        if($user->id === auth()->user()->id){
            return back()->with('error', 'Anda tidak boleh menghapus diri sendiri.');
        }
        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }   
}
