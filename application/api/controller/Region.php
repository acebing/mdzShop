<?php
namespace app\api\controller;
use think\Controller;
use app\api\model\Region as regionModel;
class Region extends Controller
{
    private  $obj;
    public function _initialize() {
        $this->obj = model("Region");
    }
    /**
     * 省份三级联动
     * @return [type] [description]
     */
    public function getCitysByParentId() {
        $type = (!empty(input('get.type')) ? intval(input('get.type')) : 0);
        $parent = (!empty(input('get.parent')) ? intval(input('get.parent')) : 0);
        $shipping = (!empty(input('get.shipping')) ? intval(input('get.shipping')) : 0);
        $type = $type + 1;
        //返回省份信息
        $region = $this->obj->get_regions($type, $parent);
        
        if(!$region) {
            return show(0,'error');
        }else{
            return show(1,'设置成功', $region);
        }
    }
    // 返回省份名称
    public function getRegionName()
    {
        $parent = (!empty(input('get.parent')) ? intval(input('get.parent')) : 0);
         if (0 < $parent) {
            $name= $this->obj
            // 需要要查询的字段
            ->field('region_name')
           ->where('region_id', $parent)
           //获取查询字段的值
           ->value('region_name');
           if (!$name) {
                return show(0,'error');
           }else{
             return show(1,'获取数据成功',$name);
           }
         
        }
    }
    /**
     * 删除地区
     * @return [type] [description]
     */
    public function remove()
    {
        $region_id = intval(input('get.id'));
        $res = $this->obj->destroy($region_id);
        if (!$res) {
                return show(0,'error');
           }else{
             return show(1,'删除成功',$res);
           }
    }
    /**
     * 添加地区
     */
    public function add()
    {
        $data=input('get.');
        $res = $this->obj->save($data);
        if (!$res) {
                return show(0,'error');
           }else{
             return show(1,'添加成功',$res);
           }
    }
    public function update()
    {
        $data = input('post.');
        $res = $this->obj->save(['region_name'=>$data['val']],['region_id'=>intval($data['id'])]);
        if (!$res) {
                return show(0,'error');
           }else{
             return show(1,'更新成功',$res);
           }
    }
   
}
