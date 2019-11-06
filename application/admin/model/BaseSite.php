<?php 
namespace app\admin\model;
use think\Model;

class BaseSite extends Model
{	
	protected $autoWriteTimestamp = true;  
	// 分类数据保存
	public function add($data)
	{
		// $data['is_show']=1;
		return $this ->save($data,['base_id' =>$data['base_id']]);
	}
	
}