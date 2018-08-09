<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Member;
class Login extends Commond{
	//登录
	public function login(){
		if(request()->isAjax()){
			$data=input('post.');
			$info=['code'=>0,'info'=>false,'msg'=>''];
			$validate=$this->validate($data,[
				'uname'=>'require',
				'upwd'=>'require',
			],[
			 	'uname.require'=>'用户名不能为空',
			 	'upwd.require'=>'密码不能为空',
			 ]);
				
			if( true ===$validate){
				$data['upwd']=md5(crypt($data['upwd'],config('pwdstring')));

				$result=db('member')->where($data)->find();
				if($result>0){
					session('uname',$result['uname']);
					session('unameId',$result['id']);
					$info=['code'=>1,'info'=>true,'msg'=>'登录成功'];
					return $info;
				}else{
					$info=['code'=>0,'info'=>false,'msg'=>'登录失败'];
					return $info;
				}
				
			}else{
				$info['msg']=$validate;
				return $info;
			}	

		}
		$this->assign('tlite','登录');
		return $this->fetch();
	}
	
	//退出
	public function logout(){
		session(null);
		$this->error('退出成功','index/index');
		
	}


	
}

?>

