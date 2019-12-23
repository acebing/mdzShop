<?php 
namespace app\common\model;
use think\Model;

class Category extends Model
{
	protected  $autoWriteTimestamp = true;
	public function add($data)
	{
		
		$data['is_show']=1;
		// $data['create_time']=time();
		return $this ->save($data);
	}
}