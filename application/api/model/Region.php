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
     * 返回地区下级列表
     * @param  [type] $parent [description]
     * @return [type]         [description]
     */
    public function get_regions_list($parent){
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
    /**
     * 返回所属地区
     * @param  [int] $region_id [地区id]
     * @param  [int] $parent_id [地区父级ID]
     * @return [type]            [description]
     */
    public function get_parent($region_id,$parent_id){
         $data = [
         'region_id' =>$region_id,
         'parent_id' =>$parent_id
        ];
        $order = [
            'parent_id' => 'asc',
        ];
        return $this->where( $data)
        ->order($order) 
        ->select();
    }
    /**
     * 得到省份列表
     * @param  integer $parent 省份ID
     * @return arrow          返回查询姐姐
     */
    public function getRegions($parent=1) {
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
}