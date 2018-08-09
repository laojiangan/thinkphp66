<?php
namespace app\index\controller;
use app\index\controller\Commond;

class Cart extends Commond{
	//加入购物车
	public function addCart(){
		$info=['code'=>0,'info'=>false,'msg'=>''];
		if(!session('?uname')){
			$info=['code'=>400,'info'=>false,'msg'=>'请先登录'];
			return $info;
		}
		
		//判断该商品是否存在购物车里
		$data['mid']=session('unameId');
		$data['pid']=input('pid');
//		print_r($data['pid']);die;
		$num=input('num');
		$cartDb=db('cart')->where($data)->find();
		if($cartDb){
			//存在就添加数量
			$result=db('cart')->where('id='.$cartDb['id'])->setInc('num',$num);
			
		}else{
			//不存在就添加商品
			$data['num']=$num;
			$data['ctime']=time();
			$result=db('cart')->insert($data);
		}
		
		if($result>0){
			$info=['code'=>500,'info'=>true,'msg'=>'已加入购物车'];
			return $info;
		}else{
			$info=['code'=>401,'info'=>false,'msg'=>'加入失败'];
			return $info;
		}
		
	}
	
	//购物车页面
	public function cartList(){
		$mid=session('unameId');
		$list=db('cart')
		->alias('c')
		->field('c.*,p.name,p.thumb,p.sales')
		->join('__PRODUCT__ p','c.pid=p.id','LEFT')
		->where("mid=$mid")
		->select();
		
		foreach($list as $k=>&$v){
			$v['thumb']=substr($v['thumb'], 1);
			$v['total']=$v['num']*$v['sales'];
		}
//	print_r($list);die;
		
		$this->assign([
			'list'=>$list,
			'title'=>'购物车',
		]);
		return $this->fetch();
	}
	
	function pay($orderid){
		$orders =db('orders')->where(['orderid'=>$orderid])->select();
		$state=$orders[0]['state'];//支付方式
		switch ($state) {
			case 1:
				//支付宝支付
				echo 123132;
				break;
			case 2:
				//余额支付
				$this->assign([
					'orderid'=>$orderid,
					'title'=>'输入密码',
				]);
				$this->fetch();
				break;
		}	
	}
	
	function payment(){
		//余额支付处理
	}
	
	
	function ali_pay(){
		//支付宝支付处理
	}
	
	
}
?>

 