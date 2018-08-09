<?php
namespace app\admin\validate;
use think\Validate;


class Product extends Validate{
	protected $rule=[
	  'name'  => 'require|max:20',
	  'cid'  => 'require',
	  'bid'  => 'require',
	];
	
	

}


	
?>