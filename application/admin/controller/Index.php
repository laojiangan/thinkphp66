<?php

namespace app\admin\controller;

//加载配置文件
use app\admin\controller\Publics;
use think\Controller;
use think\Config;

//类
class Index extends Publics{
	//方法
	function index(){
		//读取配置文件
//		dump(Config::get());
		$this->assign('tlite','后台首页');
		return $this->fetch();//加载视图
	}
}


?>