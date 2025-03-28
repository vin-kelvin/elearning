<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function redirectTo()
    {
        $user = auth()->user();

        if ($user && $user->role === 'teacher') {
            return '/TeacherDashboard';
        } elseif ($user && $user->role === 'parent') {
            return '/ParentDashboard';
        } elseif ($user && $user->role === 'student') {
            return '/StudentDashboard';
        } else {
            return '/';
        }
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username'; // Change 'username' to the actual field name you're using for login (e.g., 'phone')
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
