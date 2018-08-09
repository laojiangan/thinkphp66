<?php
namespace app\index\controller;
use think\config;
use think\Controller;
use think\Db;

class Comfirm extends Controller{
	//确认订单
	public function comfirm_order(){
		
		$mid=session('unameId');
//		print_r($mid);die;
		$list=db('cart')
		->alias('c')
		->field('c.*,p.name,p.thumb,p.sales')
		->join('__PRODUCT__ p','c.pid=p.id','LEFT')
		->where("mid=$mid")
		->select();
		$midlist=db('address')->where('state=1')->find();
//			print_r($midlist);die;
		$this->assign([
			'list'=>$list,
			'midlist'=>$midlist,
			'title'=>'确认订单',
		]);
		return $this->fetch();
	}
	
//	订单处理
	function orders(){
//		print_r(input('post.'));die;
		$data=[];
		$data['orderid']=date('Ymd').session('unameId').mt_rand(1000, 9999);
		$data['mid']=session('unameId');	
		$addr = db('address')->where(['id'=>input('post.addrsessid')])->find();
		$data['linkman']=$addr['name'];
		$data['mobile']=$addr['phone'];
		$data['address']=$addr['cmbProvince'].$addr['cmbCity'].$addr['cmbArea'].$addr['detailed'];
		$data['state']=input('post.state');
		$data['states']=0;
		$data['ctime']=time();
//		print_r($data);die;
//		//把所要的商品信息: ID 价格 购买数量
		$product=db('cart')
		->alias('c')
		->field('c.*,p.sales')
		->join('__PRODUCT__ p','c.pid=p.id','LEFT')		
		->where(['mid'=>session('unameId'),'state'=>1])
		->select();
//		print_r($product);die;
//		确定查询到多少条
		$num1 = count($product);
		//开启事物
		Db::startTrans();
		//添加订单数据
		$num2 =0;
		foreach($product as $k=>$v){
			$data['pid']=$v['pid'];
			$data['num']=$v['num'];
			$data['price']=$v['num']*$v['sales'];
			$num2 +=db('orders')->insert($data);
		}
//		print_r($num2);die;
		//删除生成点单的购物车商品
		$num3=db('cart')->where(['mid'=>session('unameId'),'state'=>1])->delete();
		if($num1==$num2 && $num2==$num3){
			//提交事务
			Db::commit();
			$info=['info'=>true,'msg'=>'','orderid'=>$data['orderid']];
			return $info;
		}else{
			//回滚事务
			Db::rollback();
			$info=['info'=>false,'msg'=>'提交失败','orderid'=>''];
			return $info;
		}
//		
		
	}
}
?>

