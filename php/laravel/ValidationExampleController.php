<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class ADMController extends Controller
{
    public function welcome() {
        echo "<h1>welcome</h1>";
    }

    public function manifest() {
        $admin_user = Session::get('admin_user');
        if (Session::has('admin_role')) {
            if (Session::get('admin_role')=="supervise") {
                $admin_role = "角色管理员";
            } elseif (Session::get('admin_role')=="operator") {
                $admin_role = "普通管理员";
            } else {
                $admin_role = "未知人士";
            }
        } else {
            $admin_role = "非法登录人士";
        }
        $role = ["role" => Session::get('admin_role')];
        return view('admin.default',compact('admin_user','admin_role','role'));
    }

    public function login() {
        Session::forget('admin_captcha');
        return view('admin.system.login');
    }

    public function loginOut() {
        //Log::adminLog(2);    //登出，写日志

        Session::forget('admin_user');
        Session::forget('admin_in');
        Session::forget('admin_captcha');
        Session::forget('admin_id');
        Session::forget('admin_role');
        echo "登出成功";
        return new RedirectResponse(url('/admin/login'));
    }

    public function doLogin(Request $request) {
        $this->getValidationFactory()->extend('captcha', function($attribute, $value, $parameters) {
            return $value == Session::get('admin_captcha');
        });
        $this->validate(
            $request,
            [
                'admin_uname' => 'required',
                'admin_pwd' => 'required',
                'captcha' => 'required|captcha'
            ],
            [
                'admin_uname.required' => '用户名不能为空!',
                'admin_pwd.required' => '密码不能为空!',
                'captcha.required' => '验证码['.Session::get('admin_captcha').']不能为空!',
                'captcha.captcha' => '验证码['.Session::get('admin_captcha').']不正确!'
            ]
        );
        $resultObj = Admin::where(['username'=>$request['admin_uname'],'status'=>1])->first();
        if (is_null($resultObj)) {
            $data = [
                'status' => 0,
                'info'   => '用户名或密码验证失败!',
                'data'   => ''
            ];
        } else {
            $result = $resultObj->toArray();
//            print_r($result);
            $sysPwd = $result['password'];
            $sysSalt = $result['salt'];
            $password = sha1($sysSalt.sha1($request['admin_pwd']));
//            echo $password;
//            exit;
            if (strcmp($password, $sysPwd) == 0) {
                Session::put('admin_user', $request['admin_uname']);
                Session::put('admin_in', '1');
                Session::put('admin_role', $result['role']);
                Session::put('admin_id', $result['id']);
                $data = [
                    'status' => 1,
                    'info'   => '验证成功',
                    'data'   => url('/admin')
                ];

                //Log::adminLog(1);    //登录，写日志
            } else {
                $data = [
                    'status' => 0,
                    'info'   => '用户名或密码验证失败!',
                    'data'   => ''
                ];
            }
        }
        return response()->json($data);
    }
}