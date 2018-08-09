<?php
namespace app\admin\model;
use think\Model;
class Goods extends Model{
	//指明要操作的数据表名
	protected $table = 'tp_product';
	//指定添加时间和更新时间
	protected $createTime='ctime';
	protected $updateTime='utime';
	//自动写入时间
	protected $autoWriteTimestamp = true;
	
	
	
}







?>