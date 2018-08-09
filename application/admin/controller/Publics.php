<?php

namespace app\admin\controller;
use think\Controller;

class Publics extends Controller{
	public function __construct(){
		parent::__construct();
//		$this->isLogin();
		$list=$this->cate();
//		print_r($list);die;
	}
	
//	protected function isLogin(){
//		if(!session('?name')){
//			$this->error('请先登录','Admin/login');
//		}
//		
//		
//	}
	
	//无极分类   递归
	function cate($id=0,$list=[],$spac=0){
		if($id>0) $spac ++;
		$fid=$id;
		$all=db('category')->where("fid=$fid")->select();
//		print_r($all);die;
		foreach($all as $k=>$v){
			$v['name']=str_repeat('|--', $spac).$v['name'];
			$list[]=$v;
			$list=$this->cate($v['id'],$list,$spac);
		}
		return $list;
	}
	
	//
	function level($id=0,$list=[],$spac=0){
		if($id>0) $spac ++;
		$fid=$id;
		$all=db('level')->where("fid=$fid")->select();
//		print_r($all);die;
		foreach($all as $k=>$v){
			$v['name']=str_repeat('|--', $spac).$v['name'];
			$list[]=$v;
			$list=$this->level($v['id'],$list,$spac);
		}
		return $list;
	}
	
	
	function upload($files){
		$file=request()->file($files);
		$dataImg=[];
		if($file){	
			foreach($file as $k=>$v){
				$filePath='./public/static/admin/upload/'.date('Y-m-d');
				if(!file_exists($filePath)){
					mkdir($filePath,0777,true);
				}
				//验证格式 并上传
				$info=$v->validate(['size'=>2*1024*1024,'ext'=>"jpg,png,gif,jpge"])->rule('uniqid')->move($filePath);
				if($info){
					$dataImg[]=rtrim($filePath,'/').'/'.$info->getSaveName();
				}
			}
		}
		return $dataImg;
	}
	
	
	
	//缩略图
	function thumb($path ,$w=150,$h=150){
//		file_put_contents('1.txt', '222222');
		$image = \think\Image::open($path);
		// 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.png
		$tPath = dirname($path).'/thumb';
		
//				echo $tPath;die;
		if(!file_exists($tPath)){
//					echo 21315;die;
				mkdir($tPath,0777,true);
			}
		$thumPath=$tPath.'/'.basename($path);
		$image->thumb($w, $h)->save($thumPath);
		
		return $thumPath;
		
	}
	
	
	function water($padh,$type=2,$state=9){
		$image = \think\Image::open($padh);
		if($type==1){
			switch ($state){
				case '1':
					// 给原图左上角添加水印并保存water_image.png
					$image->water('./logo.png',\think\Image::WATER_NORTHWEST)->save($padh); 	
					break;
				case '2':
					// 给原图左上角添加水印并保存water_image.png
					$image->water('./logo.png',\think\Image::WATER_NORTH)->save($padh); 	
					break;
				case '3':
					// 给原图左上角添加水印并保存water_image.png
					$image->water('./logo.png',\think\Image::WATER_NORTHEAST)->save($padh); 	
					break;
				case '4':
					// 给原图左上角添加水印并保存water_image.png
					$image->water('./logo.png',\think\Image::WATER_WEST)->save($padh); 	
					break;
				case '5':
					// 给原图左上角添加水印并保存water_image.png
					$image->water('./logo.png',\think\Image::WATER_CENTER)->save($padh); 	
					break;
				case '6':
					// 给原图左上角添加水印并保存water_image.png
					$image->water('./logo.png',\think\Image::WATER_EAST)->save($padh); 	
					break;
				case '7':
					// 给原图左上角添加水印并保存water_image.png
					$image->water('./logo.png',\think\Image::WATER_SOUTHWEST)->save($padh); 	
					break;
				case '8':
					// 给原图左上角添加水印并保存water_image.png
					$image->water('./logo.png',\think\Image::WATER_SOUTH)->save($padh); 	
					break;
				case '9':
					// 给原图左上角添加水印并保存water_image.png
					$image->water('./logo.png',\think\Image::WATER_SOUTHEAST)->save($padh); 	
					break;
			}		
		}else{
			// 给原图左上角添加水印并保存water_image.png
			$image->text('康丽妍','./public/static/admin/font/TEKTONPRO-BOLD.OTF',20,'#ffffff')->save($padh);
		}
	}
	
}


?>