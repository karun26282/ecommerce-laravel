<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Session as FacadesSession;

class AdminController extends Controller
{
    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'username'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        $username = $request->username;
        $users_count = Admin::where(['username' => $request->username, 'password' => $request->password])->count();
        if($users_count > 0){
            $value = $request->session()->put('username', $username);
			$data = $request->session()->get('username');
			if($data){
				return redirect()->to('/dummy/dashboard');
			}
        }else{
            return redirect()->back()->withInput($request->only('username', 'remember'))->withErrors([
                'msg' => 'Username/password not match',
            ]);
        }
    }

    public function logout(){

        FacadesSession::forget('username');
        if(!session('username'))
        {
            return redirect('/dummy/admin');
        }
    }

}
