<?php 
namespace app\common\model;
use think\Model;

class Region extends Model
{
	
	// 获取一级分类数据
	public function getNormalFirstCategory($parent_id =1) {
         $data = [
            'parent_id' => $parent_id
        ];
        $order = [
            'parent_id' => 'asc',
        ];
        return $this->where( $data)
            ->order($order)
            ->select();
    }
    
}