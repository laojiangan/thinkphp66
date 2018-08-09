<?php
namespace app\index\controller;

use think\Controller;

class Commond extends Controller{
	public function __construct(){
		parent::__construct();
		$inlist=db('category')->where('fid=93')->select();
		$this->assign([
			'inlist'=>$inlist,
		]);
	}
	
}
?>

