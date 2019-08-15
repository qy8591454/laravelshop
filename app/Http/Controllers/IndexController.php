<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index','floor','goods','sort','goodshp','shop']]);
    }
	public function show()
	{
		return view('index.index');
	}
	public function index()
	{

		$user=DB::select("select * from brand");
		return response()->json($user);
	}
	
	private function getTree($arr,$id, $level){
        $list =array();
        foreach ($arr as $key => $value){
        	// $json = $value;
            if ($value->pid == $id){
                $value->level = $level;
                $value->data = $this->getTree($arr,$value->id,$level+1);
                $list[] = $value;
            }           
        }
        return $list;
    }

    function sort($value=''){
    	$arr = DB::select('select * from goods_category where 1');
        $json=$this->getTree($arr,0,0);
        return $json;
    }

    function floor(){
    	$users=DB::select("select goods.id,goods.name,floor.name as f_name from goods inner join floor on goods.fid=floor.id");
    	$floor=[];
    	foreach ($users as $key => $value) {
    		$floor[$value->f_name][]=[$value->name,$value->id];
    	}
		return response()->json($floor);
    }

    function goods(Request $request){
        $id=$request->input('id');
        $arr=DB::select("select goods.name,attrdetails.name as d_name,attribute.name as b_name,attrdetails.attr_id as d_id,attribute.id as b_id,attrdetails.id from goods_attr inner join goods on goods_attr.goods_id=goods.id inner join attribute on goods_attr.attr_id=attribute.id inner join attrdetails on goods_attr.attr_details_id=attrdetails.id where goods_attr.goods_id=$id");
        $attr=[];
        foreach ($arr as $key => $value){
            $attr[$value->b_name][]=[$value->d_name,$value->id];
        }
        $ass['name']=$arr[0]->name;
        $ass['data']=$attr;
        return response()->json($ass);
    }
    function goodshp(Request $request){
        $id=$request->input('id');
        $aid=substr($id, 1);
        $gid=$request->input('uid');
        $arr=DB::select("select * from goodshp where goods_id='$gid' and goods_attr_id='$aid'");
        return response()->json($arr);
    }
    function car(Request $request){
        $num=$request->input('num');
        $goods_id=$request->input('goods_id');
        $user_id=$request->input('user_id');
        $token=$request->input('token');
        DB::insert("insert into car(`uid`,`goods_id`,`number`) values('$user_id','$goods_id','$num')");
    }
    function user_name(Request $request){
        $name=$request->input('name');
        $arr=DB::select("select * from users where name='$name'");
          return response()->json($arr);
    }
    function mycar (){
        $name=auth()->user();
        $id=$name->id;
        $arr=DB::select("select * from car  where uid=$id");
        return response()->json($arr);
    }
//    修改购物车内数量
    function number (Request $request){
        $id=$request->input('id');
        $number=$request->input('number');
        //DB::update("update car set number = $number where id = $id");
    }
    function area(){
        $arr=DB::select("select * from area where area_type=1");
        return response()->json($arr);
    }
    function city(Request $request){
        $id=$request->input('id');
        $arr=DB::select("select * from area where parent_id=$id");
        return response()->json($arr);
    }
    function orders(Request $request){
        $number=$request->input('number');
        // var_dump($number);
        // die;
        $arr=explode(',', substr($number, '1'));
        $order=[];
        foreach ($arr as $key => $value) {
            $ass=DB::select("select * from car where id=$value");
            $order['data'][]=$ass;
        }
        return response()->json($order);
    }
    function orders_add(Request $request){
        $user = auth()->user();
        $u_id = $user->id;
        $arr = DB::table('order')->insertGetId(['u_id' => $u_id, 'status' => '0']);
        $number = $request->input('number');
        $ass = explode(',', substr($number, '1'));
        $monlin=0;
        foreach ($ass as $key => $value) {
            $commt = DB::select("select * from car where id=$value");
            $name = $commt[0]->name;
            $type = $commt[0]->attr_name;
            $number = $commt[0]->number;
            $h_id = $commt[0]->id;
            $price = $number * $commt[0]->price;
            $ass = DB::table("details")->insert(['h_goods'=>$name,'h_type'=>$type,'price'=>$price,'num'=>$number,'h_id'=>$h_id,'order_id'=>$arr]);
            // DB::delete("delete from car where id=$value");
            $monlin+=$price;

        }
        $order=[$monlin,$arr];
        return response()->json($order);
    }
}