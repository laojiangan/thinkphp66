<?php
	namespace app\admin\controller;
//	use app\admin\controller\Publics;
	use think\Loader;
	use think\Db;
	
	class Role extends Publics{
		public function roleList(){
			$list=Db::name('role')->select();
			$levelList=Db::name('level')->field('id,name')->select();
			foreach ($list as $k => $v) {
				$levelName=array();
				$idArr=explode('|', $v['level']);
				foreach($levelList as $kk => $vv){
					if(in_array($vv['id'], $idArr)){
						$levelName[]=$vv['name'];
					}
				}
				$list[$k]['level']=implode('|', $levelName);
			}
			
			$this->assign('list',$list);
			$this->assign('tlite','角色列表');
			return $this->fetch();
		}
		
		public function roleAdd(){
//			$id=input('id');
			if(request()->isPost()){
//					print_r(input('post.'));die;
				$data=input('post.');
//				print_r($data);die;
				
				$data['level']= implode('|', $data['level']);
//				print_r($data);die;
				 $validate=$this->validate($data,[
				 	'name'=>'require',
				 ]);
				 if(true===$validate){
				 	$return=Db::name('role')->insert($data);
					if($return){
						$this->success('操作成功','Role/roleList','','1');die;
					}else{
						$this->error('操作失败','','','1');die;
					}
				 }else{
						$this->error($validate);
					}
			}
			
			$list=$this->level();
			$this->assign('list',$list);
			$this->assign('tlite','角色添加');
			return $this->fetch();
		}
		
		public function roleUp(){
			$id=input('id');
//			echo $id;die;
			if(request()->isPost()){
//					print_r(input('post.'));die;
				$data=input('post.');
				print_r($data);die;
				 $validate=$this->validate($data,[
				 	'name'=>'require',
				 ]);
				 if(true===$validate){
				 	$data['level']= implode('|', $data['level']);
					$return=Db::name('role')->where("id=$id")->update($data);
					if($return>0){
						$this->success('操作成功','Role/roelList','','1');die;
					}else{
						$this->error('操作失败','','','1');die;
					}
				}else{
					$this->error($validate);
				}
			}
			$one = Db::name('role')->where('id='.$id)->find();
			$one['level']= explode('|', $one['level']);
//			print_r($one);die;
			$this->assign('one',$one);
			$list=$this->level();
			$this->assign('list',$list);
			$this->assign('tlite','角色编辑');
//			echo 123;die;
			return $this->fetch();
		}
	
		public function roleDelete(){
			$id=input('id');
			$return=Db::name('role')->where("id=$id")->delete();
			if($return>0){
					$this->success('删除成功','Role/roleList','','1');die;
				}else{
					$this->error('删除失败','','','1');die;
				}
		}
		
	}
	
	
?>