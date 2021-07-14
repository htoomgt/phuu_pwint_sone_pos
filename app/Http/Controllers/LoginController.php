<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use \Illuminate\View\View;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * To display login page
     * @author Htoo Maung Thait
     * @return \Illuminate\View\View
     */
    public function showLoginPage(): View
    {
        return view('login');
    }

    /**
     * To authenticate user with username and passwords
     * @author Htoo Maung Thait
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function authenticate(Request $request): RedirectResponse
    {

        $validated = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $username = $request->username;
        $password = $request->password;

        if (Auth::attempt(['username' => $username, 'password' => $password, 'status' => 'active'])) {
            $userId = Auth::user()->id;
            $user = User::find($userId);
            $userRole = $user->getRoleNames()[0];

            if($userRole != "sale-person"){
                return redirect()->route('home.dashboard');
            }
            else{
                return redirect()->route('sale.point');
            }


        } else {
            return back()->with('login_status', 'Username or password is wrong!');
        }

    }

    /**
     * Logout from the system
     * @author Htoo Maung Thait
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        if ($request->action == 'logout') {
            Session::flush();
            Auth::logout();
            return redirect()->route('login.show');
        }
        else{
            return back();
        }

    }
}
