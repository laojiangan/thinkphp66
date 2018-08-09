<?php
namespace app\index\controller;
use think\config;
use think\Loader;
use think\Controller;

class User extends Controller{
	public function user(){
			//导航
		$inlist=db('category')->where('fid=93')->select();
		$this->assign('title','个人中心');
		$this->assign('inlist',$inlist);
		return $this->fetch();
	}
	
	
	
	public function address(){
		if(request()->isAjax()){
			$data=input('post.');
//			print_r($data);die;
			$info=['code'=>0,'info'=>false,'msg'=>''];
			$validate=$this->validate($data,[
				'name'=>'require',
			 	'phone'=>'require',
			 	'email'=>'require',
			 	'detailed'=>'require',
			 ],[
			 	'name.require'=>'收件人不能为空',
			 	'phone.require'=>'手机不能为空',
			 	'email.require'=>'邮箱不能为空',
			 	'detailed.require'=>'地址不能为空',
			 ]);
			 if(true===$validate){
			 	$data['mid']=session('unameId');
				$uplist=db('address')->insert($data);
				if($uplist>0){
					$info=['code'=>1,'info'=>true,'msg'=>'添加成功'];
					return $info;
				}else{
					$info=['code'=>0,'info'=>false,'msg'=>'添加失败'];
					return $info;
				}
			 }else{
			 	$this->error($validate);
			 }	  
		}
		$addlist=db('address')->select();
		$this->assign([
			'title'=>'收货地址',
			'addlist'=>$addlist,
		]);
		return $this->fetch();
	}
	
	public function addrDelect(){
		$id=input('id');
		$return=db('address')->where("id=$id")->delete();
		if($return>0){
			$this->success('删除成功','User/address','','1');die;
		}else{
			$this->error('删除失败','','','1');die;
		}
	}
	
	public function addrUp(){
		$id=input('id');
		if(request()->isPost()){
			$data=input('post.');
			$address=db('address')->where("id=$id")->update($data);
			if($address>0){
				$this->success('修改成功','User/address','','1');die;
			}else{
				$this->error('修改失败','','','1');die;
			}
		}
		$addr=db('address')->where("id=$id")->find();
//		print_r($addr);die;
		$addlist=db('address')->select();
		$this->assign([
			'addr'=>$addr,
			'addlist'=>$addlist,
			'title'=>'地址编辑',
		]);
		return $this->fetch();
	}
	
	
	public function logout(){
		session(null);
		$this->error('退出成功','index/index');	
	}
	
}

?>

