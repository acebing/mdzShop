<?php
/**
 * 城市联动Model
 * Created by PhpStorm.
 * User: 尔等已死
 * Date: 2017/1/14
 * Time: 13:03
 * Description：Region
 */
namespace app\api\model;
use think\Model;
class Region extends Model
{  
    /**
     * 三级联动
     * @param  int $type   [description]
     * @param  [type] $parent [description]
     * @return [type]         [description]
     */
    public function get_regions($type, $parent){
         $data = [
         'parent_id' =>$parent,
         'region_type' =>$type,  
        ];
        $order = [
            'parent_id' => 'asc',
        ];
        return $this->where( $data)
        ->order($order)
        ->select();
    }
    /**
     * 得到省份
     * @param  integer $parent 省份ID
     * @return arrow          返回查询姐姐
     */
    public function getNormalCitysByParentId($parent=1) {
        $data = [
            'parent_id' =>$parent 
        ];
        $order = [
            'parent_id' => 'asc',
        ];
        return $this->where( $data)
            ->order($order)
            ->select();
    }       
    // 分类数据保存
    public function add($data)
    {
        // $data['is_show']=1;
        return $this ->save($data);
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
            // ->select();
            ->paginate(2);
        //echo $this->getLastSql();
        return $result;

    }
}