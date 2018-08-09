<?php
	namespace app\admin\controller;
//	use app\admin\controller\Publics;
	use think\Loader;
	use think\Db;
	
	class Level extends Publics{
		public function levelList(){
			$list=$this->level();
			$this->assign('list',$list);
			$this->assign('tlite','分类列表');
			return $this->fetch();
		}
		
		public function levelAdd(){
			$id=input('id');
			if(request()->isPost()){
//					print_r(input('post.'));die;
				$data=input('post.');
//				print_r($data);die;
				$return=Db::name('level')->insert($data);
				if($return){
					$this->success('操作成功','Level/levelList','','1');die;
				}else{
					$this->error('操作失败','','','1');die;
				}
			}
			
		
			$list=$this->level();
			$this->assign('list',$list);
			$this->assign('tlite','分类添加');
			return $this->fetch();
		}
		
		public function levelUp(){
			$id=input('id');
//			echo $id;die;
			if(request()->isPost()){
//					print_r(input('post.'));die;
				$data=input('post.');
//				print_r($data);die;
				
				$return=Db::name('level')->where("id=$id")->update($data);
				if($return>0){
					$this->success('操作成功','Level/levelList','','1');die;
				}elseif($return===0){
					$this->error('数据未更新','','','1');die;
				}else{
					$this->error('操作失败','','','1');die;
				}
			}

			$one = Db::name('level')->where('id='.$id)->find();
//			print_r($one);die;
			$this->assign('one',$one);
			$list=$this->level();
			$this->assign('list',$list);
			$this->assign('tlite','分类编辑');
			return $this->fetch();
		}
		
		public function levelDelete(){
			$id=input('id');
			$return=Db::name('level')->where("id=$id")->delete();
			if($return>0){
					$this->success('删除成功','Level/levelList','','1');die;
				}elseif($return===0){
					$this->error('数据未删除','','','1');die;
				}else{
					$this->error('删除失败','','','1');die;
				}
		}
		
	}
	
	
?>