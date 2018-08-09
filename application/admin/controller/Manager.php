<?php
namespace app\admin\controller;
use app\admin\controller\Goods;
use think\Loader;
use think\Db;
use app\admin\model\Urse;
	
	
class Manager extends Publics{
	public function manList(){
//			$id=input('id');
		$list=Db::name('manager')->order('id','desc')->paginate();
//			print_r($list);die;
		$rolelist=Db::name('role')->select();
//			print_r($rolelist);die;
//			if($rolelist['id']==$list['roid']){
//				$list['roid']=$rolelist['name'];
//			}
//			$this->assign('rolelist',$rolelist);
		$this->assign('list',$list);
		$this->assign('tlite','角色列表');
		return $this->fetch();
	}
	
	public function manAdd(){
		
		if(request()->isPost()){
//					print_r(input('post.'));die;
			$data=input('post.');
//				print_r($data);die;
			
			
			$validate=$this->validate($data,[
				'roid'=>'gt:0',
			 	'name'=>'require',
			 	'uname'=>'require',
			 	'pwd'=>'require|confirm',
			 ],[
			 	'name.gt'=>'请输入账号',
			 	'uname.require'=>'昵称不能为空',
			 	'pwd.require'=>'密码不能为空',
			 	'pwd.confirm'=>'输入密码不一致',
			 ]);
			 //定义数组中的uname
//				 print_r($validate);die;
			 $uname= $data['uname'];
			 //以昵称为查询条件查询所以uname
			 $uname_up=Db::name('manager')->where("uname='$uname'")->find();
			 //然后判断是否已存在
			 if($uname_up) $this->error('用户名已存在');
			 
			 if(true===$validate){
				$model= new Urse($data);
				$model->save($this->request->post());
//					print_r($model);die;
//					$return=Db::name('manager')->insert($data);
				if($model){
					$this->success('操作成功','Manager/manList','','1');die;
				}else{
					$this->error('操作失败','','','1');die;
				}
			 }else{
			 	$this->error($validate);
			 }			
		}

		$roleList=db('role')->select();//角色
		$this->assign('roleList',$roleList);
		$this->assign('tlite','角色添加');
		return $this->fetch();
	}
	
	public function manUp(){
		$id=input('id');
//			echo $id;die;
		$one = Db::name('manager')->where('id='.$id)->find();
//			print_r($one);die;
		if(request()->isPost()){
//					print_r(input('post.'));die;
			$data=input('post.');
//				print_r($data);die;
			$return=Db::name('product')->where("id='$id'")->update($data);
			if($return>0){
				$this->success('操作成功','Product/proList','','1');die;
			}else{
				$this->error('操作失败','','','1');die;
			}	

		}
		$roleList=db('role')->select();//角色
		$this->assign('roleList',$roleList);
		$this->assign('one',$one);
		$this->assign('tlite','角色编辑');
		return $this->fetch();
	}
	
	public function manDelete(){
		$id=input('id');
		$return=Db::name('manager')->where("id=$id")->delete();
		if($return>0){
				$this->success('删除成功','Manager/manList','','1');die;
			}else{
				$this->error('删除失败','','','1');die;
			}
	}
	
}
	
	
?>