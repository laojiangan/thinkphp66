<?php
namespace app\index\controller;
use think\config;
use think\Controller;

class Index extends Controller{
	public function index(){
		$inlist=db('category')->where('fid=93')->select();
		$prolist=db('product')->select();
		$alist=db('product')->paginate(4);
		
		$this->assign([
			'prolist'=>$prolist,
			'alist'=>$alist,
			'inlist'=>$inlist,
			'title'=>'首页',
		]);
		return $this->fetch();
	}
	
}
?>

