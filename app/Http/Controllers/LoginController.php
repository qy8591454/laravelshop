<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
	public function show()
	{
		return view('login.login');
	}
	public function loginshow(Request $request)
	{
		$name=Input::get('name');//取
		$password=Input::get('password');
		if (empty($name)||empty($password)){
            $arr=['code'=>'1','status'=>'error','data'=>'账号密码不能为空'];
            return json_encode($arr);
        }else{
            $res=DB::select("select * from user where name='$name'and password='$password'");
            if ($res){
                $request->session()->put('name', $name);//存
                $arr=['code'=>'0','status'=>'ok','data'=>'登陆成功'];
                return json_encode($arr);
            }else{
                $arr=['code'=>'1','status'=>'error','data'=>'登陆失败'];
                return json_encode($arr);
            }
        }
    }
    public function loginout(Request $request){
        $request->session()->forget('name');//删
        return redirect()->action('LoginController@show');
    }
	
}