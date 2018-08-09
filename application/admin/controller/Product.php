<?php
	namespace app\admin\controller;
	use app\admin\model\Goods;
	use think\Loader;
	use think\Db;

	
	
	class Product extends Publics{
		public function proList(){
			$list=Db::name('product')
			->alias('p')
			->field('p.*,c.name as cname,b.name as bname')
			->join('tp_category c','p.cid=c.id','LEFT')
			->join('tp_brand b','p.bid=b.id','LEFT')
			->order('id','desc')
			->paginate(10);
			
		
			$this->assign('list',$list);
//			$page = $list->render();
//			$this->assign('page', $page);
			
			$this->assign('tlite','商品列表');
			return $this->fetch();
		}
		
		public function proAdd(){
		
			if(request()->isAjax()){
//				alert(123);die;
				$info=['code'=>0,'info'=>false,'msg'=>''];
				$data=input('post.');
//				print_r($data);die;
				$dataImg = $this->upload('ufile');
				if($dataImg){
				//缩略图
//					file_put_contents('1.txt',$dataImg[0]);
					$thumb=$this->thumb($dataImg[0]);
					//水印图
					$this->water($dataImg[0]);
					
					$data['thumb']=$thumb;
					$data['img']=implode(',', $dataImg);
				}
				$validate=$this->validate($data,[
					'name'=>'require',
					'cid'=>'require',
					'bid'=>'require',
					'stock'=>'require',
					'market'=>'require',
					'sales'=>'require',
					'name'=>'require',
				]);
//				print_r($validate);die;
				if(true===$validate){
					$product= new Goods($data);
					$result=$product->allowField(true)->save();
					if($result){
						$info=['code'=>500,'info'=>true,'msg'=>'操作成功'];
						return $info;						
					}else{
						$info=['code'=>401,'info'=>false,'msg'=>'操作失败'];
						return $info;
					}
				}else{
					$info['code']=400;
					$info['msg']=$validate;
					return $info;
				}
//				print_r($validate);die;
//				$return=Db::name('product')->insert($data);
//				if($return){
//					$this->success('操作成功','Product/proList','','1');die;
//				}else{
//					$this->error('操作失败','','','1');die;
//				}
			}
			
			$cateList=$this->cate();//分类
			$brandList=db('brand')->select();//品牌
			$this->assign('cateList',$cateList);
			$this->assign('brandList',$brandList);
			$this->assign('tlite','商品添加');
			return $this->fetch();
		}
		
		public function proUp(){
			$id=input('id');
//			echo $id;die;

			if(request()->isPost()){
//				print_r(input('post.'));die;
				$data=input('post.');
//				print_r($data);die;
				$validate= $this->validate($data,[
					'name'=>'require',
					'cid'=>'require',
					'bid'=>'require',
				]);
				
				if(true===$validate){
					$product = new Goods();
					$return=$product->allowField(true)->save($data,['id'=>$id]);
					
					if($return>0){
						$this->success('操作成功','Product/proList','','1');die;
					}else{
						$this->error('操作失败','','','1');die;
					}
					
				}else{
					return $this->error($validate);
				}
			}
			
			$one = Db::name('product')->where('id='.$id)->find();
//			print_r($one);die;
			$cateList=$this->cate();//分类
			$brandList=db('brand')->select();//品牌
			$this->assign('cateList',$cateList);
			$this->assign('brandList',$brandList);
			$this->assign('one',$one);
			$this->assign('tlite','商品编辑');
			return $this->fetch();
		}
		
		public function proDelete(){
			$id=input('id');
			$return=Db::name('product')->where("id=$id")->delete();
			if($return>0){
					$this->success('删除成功','Product/proList','','1');die;
				}else{
					$this->error('删除失败','','','1');die;
				}
		}
		
		public function ajaxImg(){
			
			if(request()->isAjax()){
				$file=$_FILES['ufile']['tmp_name'];
				print_r($file);
			}
		}
		
		
	}
	
	
?>