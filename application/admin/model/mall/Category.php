<?php 
namespace app\admin\model\mall;
use think\Model;

class Category extends Model
{	
	// 开启时间戳
	protected  $autoWriteTimestamp = true;

	/**
     * 添加操作
     * @param arrat $data post过来的数据
     */
    public function handle($data)
    {
       
        if ($data['cat_id']==0) {
           return $this->allowField(true)->save($data);
           
        }else{
           return $this->allowField(true)->save($data,['cat_id' =>$data['cat_id']]);
        }
        
    }
	// 获取一级分类数据
	public function getNormalFirstCategory() {
        $data = [
            'is_show' => 1,
            'parent_id' => 0,
        ];

        $order = [
            'cat_id' => 'asc',
        ];
        return $this->where($data)
            ->order($order)
            ->select();
    }
    // 获取子分类数据
    public function getFirstCategorys($parentId = 0) {
        $data = [
            'parent_id' => $parentId,
            'is_show' => ['neq',-1],
        ];

        $order =[
            'sort_order' => 'asc',
            'cat_id' => 'asc',
        ];
        $result = $this->where($data)
            ->order($order)
            ->select();
            // ->paginate(2);
        //echo $this->getLastSql();
        return $result;

    }
}