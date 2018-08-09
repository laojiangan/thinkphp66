<?php
	namespace app\admin\controller;
//	use app\admin\controller\Publics;
	use think\Loader;
	use think\Db;
	
	class Brand extends Publics{
		public function brandList(){
			$list=Db::name('brand')->paginate(3);
			$this->assign('list',$list);
//			$page = $list->render();
//			$this->assign('page', $page);
			
			$this->assign('tlite','品牌列表');
			return $this->fetch();
		}
		
		public function brandAdd(){
			
			if(request()->isAjax()){
					
				$data=input('post.');
				$info=['code'=>0,'info'=>false,'msg'=>''];
				$dataImg = $this->upload('ufile');
//				print_r($dataImg);die;
				if($dataImg){
				//缩略图
//					file_put_contents('1.txt',$dataImg[0]);
					$thumb=$this->thumb($dataImg[0]);

					$data['logo']=$thumb;
					
				}
				$validate = Loader::validate('Brand');
				if(!$validate->check($data)){
					($validate->getError());die;
				}
				
				$return=Db::name('brand')->insert($data);
				if($return){
					$info=['code'=>500,'info'=>true,'msg'=>'操作成功'];
						return $info;
				}else{
					$info=['code'=>500,'info'=>true,'msg'=>'操作成功'];
						return $info;
				}
			}
			$this->assign('tlite','品牌添加');
			return $this->fetch();
		}
		
		public function brandUp(){
			$id=input('id');
//			echo $id;die;
			if(request()->isPost()){
//					print_r(input('post.'));die;
				$data=input('post.');
//				print_r($data);die;
				$validate = Loader::validate('Brand');
				if(!$validate->check($data)){
					($validate->getError());die;
				}
				$return=Db::name('brand')->where("id=$id")->update($data);
				if($return>0){
					$this->success('操作成功','Brand/brandList','','1');die;
				}elseif($return===0){
					$this->error('数据未更新','','','1');die;
				}else{
					$this->error('操作失败','','','1');die;
				}
			}

			$one = Db::name('brand')->where('id='.$id)->find();
//			print_r($one);die;
			$this->assign('one',$one);
			$this->assign('tlite','品牌编辑');
			return $this->fetch();
		}
		
		public function brandDelete(){
			$id=input('id');
			$return=Db::name('brand')->where("id=$id")->delete();
			if($return>0){
					$this->success('删除成功','Brand/brandList','','1');die;
				}else{
					$this->error('删除失败','','','1');die;
				}
		}
		
	}
	
	
?>