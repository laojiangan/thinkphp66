<?php
namespace app\index\controller;
use app\index\controller\Commond;
use think\Controller;

class Product extends Commond{
	public function pro_details(){
		$id=input('id');
		//导航
		$inlist=db('category')->where('fid=93')->select();
		$prolist=db('product')->where('id='.$id)->find();
//		print_r($prolist);die;
		$prolist['img'] = explode(',',$prolist['img']);
		$detalis=db('product')->paginate(4);
		$this->assign([
			'prolist'=>$prolist,
			'title'=>'产品详情',
			'inlist'=>$inlist,
			'detalis'=>$detalis,
		]);
		return $this->fetch();
	}
	
	
	
	
	public function product(){
		//导航
		$inlist=db('category')->where('fid=93')->select();
//		子分类
		$id=input('id');
		$cone=db('category')->where('id='.$id)->find();
		$childlist=db('category')->where('fid='.$id)->select();
//      品牌		
		$brandlist=db('brand')->select();
	
		//商品
		if(input('bid')){//品牌
			$map['bid']=['eq',input('bid')];
		}
		
		if(!input('cid')){//分类
			$childid=$this->childId($id);//id数组
			$map['cid']=['in',$childid];
		}else{
			$map['cid']=['eq',input('cid')];
		}
		
		if(input('order')=='sales'){
			$order='sales desc';
		}else{
			$order='id desc';
		}
		$plist=db('product')->where($map)->order($order)->select();
//		print_r($this->childId($id));die;
		//广告部分的商品
		$prodlist=db('product')->select();
//		print_r($prodlist);die;
		$this->assign([
			'cone'=>$cone,
			'inlist'=>$inlist,
			'childlist'=>$childlist,
			'brandlist'=>$brandlist,
			'prodlist'=>$prodlist,
			'plist'=>$plist,
			'cid'=>input('cid'),
			'title'=>'商品中心',
		]);
		return $this->fetch();
	}
	
	
	function childId($id=0,$list=[],$spec=0){
		if($spec==0) $list[]=$id;
		$fid=$id;
		$all=db('category')->where("fid=$fid")->select();
//		print_r($all);die;
		foreach($all as $k=>$v){
			$list[]=$v['id'];
			$list=$this->childId($v['id'],$list,$spec+1);
		}
		return $list;
	}
	
	
}
?>

