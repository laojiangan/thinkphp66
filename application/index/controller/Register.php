<?php
namespace app\index\controller;
use think\config;
use think\Controller;

class Register extends Controller{
	public function register(){
		if(request()->isAjax()){
			$data=input('post.');
			$info=['code'=>0,'info'=>false,'msg'=>''];
			$validate=$this->validate($data,[
				'uname'=>'require',
				'upwd'=>'require|confirm',
				'phone'=>'require',
				'val'=>'require',
			],[
			 	'uname.require'=>'用户名不能为空',
			 	'phone.require'=>'手机号码不能为空',
			 	'upwd.require'=>'密码不能为空',
			 	'upwd.confirm'=>'输入密码不一致',
			 	'val.require'=>'验证码不能为空',
			 ]);
			
			if( true ===$validate){
				$data['upwd']=md5(crypt($data['upwd'],config('pwdstring')));
//				$data['upwd_confirm']=md5(crypt($data['upwd_confirm'],config('pwdstring')));
				unset($data['upwd_confirm']);
				unset($data['val']);
				$result=db('member')->insert($data);
				if($result>0){
					$info=['code'=>1,'info'=>true,'msg'=>'注册成功'];
					return $info;
				}else{
					$info=['code'=>0,'info'=>false,'msg'=>'注册失败'];
					return $info;
				}
				
			}else{
				$info['msg']=$validate;
				return $info;
			}
		}
		$this->assign('tlite','注册');
		return $this->fetch();
	}
	
}
?>

