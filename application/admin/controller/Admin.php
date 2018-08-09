<?php 
namespace app\admin\controller;

use think\Controller;
use think\Config;
//use think\Request;
use think\Db;


class Admin extends Controller{
	public function login(){
//		echo md5(crypt('123',config('pwdstring')));die;
//		$pwd=config('pwdstring');
		if(request()->isAjax()){
//			print_r($_POST);die;
			$info=['error'=>false,'msg'=>''];
			
			if(!captcha_check(input('post.val'))){
				$info['msg']='验证码错误';
				return $info;
			}
			
			$name=input('post.name');
			$one = Db::name('message')->where("name='$name'")->find();//单条查询
//			print_r($one);die;
			if(!$one){
				$info['msg']='用户名不存在';
				return $info;
			}
			
			if($one['pwd'] != md5(crypt(input('post.pwd'),config('pwdstring')))){
//				print_r($one['pwd']);die;
//				print_r(input('post.password'));die;
				$info['msg']='账号或密码有误';
				return $info;
			}
			
			session('name',$name);
			session('nameId',$one['id']);
			trace('登录成功','info');
			
			$info=['error'=>true,'msg'=>'登录成功'];
			return $info;
		}
		$this->assign('tlite','登录');
		return $this->fetch();
		
	}
	
	public function logout(){
		session(null);
		$this->error('退出成功','login','','1');
	}
	
}	
	
	
	
	
	
	
	
	
	
	
	
	
	
?>