<?php 
namespace app\admin\model\mallsite;
use think\Model;

class BaseSite extends Model
{	
	protected $autoWriteTimestamp = true;  
	// 分类数据保存
	public function add($data)
	{
		
		return $this ->save($data,['base_id' =>$data['base_id']]);
	}
	
}