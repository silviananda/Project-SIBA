<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    protected $redirectTo = 'dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:dosen')->except('logout');
        $this->middleware('guest:himpunan')->except('logout');
        $this->middleware('guest:super_admin')->except('logout');
    }

    //pengecekan untuk login
    public function postlogin(Request $request)
    {
        if (Auth::guard('dosen')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/dashboard-dosen');
        } elseif (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/dashboard');
        } elseif (Auth::guard('himpunan')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/kegiatan');
        } elseif (Auth::guard('super_admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/data-admin');
        } else {
            return redirect('/')->with('message', 'Email atau Password salah');
        }
        return redirect('/');
    }

    //biar setelah logout di satu tab pas refrech tab lain ke direct halaman login


    public function logout(Request $request)
    {
        if (Auth::guard('dosen')->check()) {
            Auth::guard('dosen')->logout();
        } elseif (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('himpunan')->check()) {
            Auth::guard('himpunan')->logout();
        } elseif (Auth::guard('super_admin')->check()) {
            Auth::guard('super_admin')->logout();
        }
        return redirect('/');
    }
}
