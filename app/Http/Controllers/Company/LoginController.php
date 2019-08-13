<?php
namespace App\Http\Controllers\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     *  默认使用手机号登陆
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'mobile';
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/company';
    protected $username;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:company', ['except' => 'logout']);
        $this->username = config('company.global.username');
    }
    /**
     * 重写登录视图页面
     * @author Holy
     * @date   2018-04-02
     * @return [type]
     */
    public function showLoginForm()
    {
        return view('company.auth.login');
    }
    /**
     * 自定义认证驱动
     * @author Holy
     * @date   2018-04-02
     * @return [type]
     */
    protected function guard()
    {
        return auth()->guard('company');
    }

    /**
     * 企业后台退出跳转到后台登录页面
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/company/login');
    }
}