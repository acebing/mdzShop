<?php 
namespace app\admin\Controller;
use app\admin\Controller\Base;
use app\api\model\Region as regionModel;
use think\Db;
class Area extends Base
{
	/**
     * // 返回一级省份列表
     * @return [type] [description]
     */
    public function areaSite()
    {
        $regionModel=new regionModel();
        // 返回省份列表
        $region=$regionModel->getRegions();
        return $this->view->fetch('mallsite/area_site',[
            'region'=> $region,
        ]);
    }
    /**
     * 返回省份列表
     * @return arrow [description]
     */
    public function getList() {
       $regionModel=new regionModel();
        $region_id = (!empty(input('get.region_id')) ? intval(input('get.region_id')) : 0);
        $parent_id = (!empty(input('get.parent_id')) ? intval(input('get.parent_id')) : 1);
        $region_type = (!empty(input('get.region_type')) ? intval(input('get.region_type')) : 1);
        //返回省份信息
        $region =$regionModel->get_regions_list($region_id);

        // 返回所属地区
        $parent =$regionModel->get_parent($region_id,$parent_id);
        return $this->view->fetch('mallsite/area_list',[
            'region'=> $region,
            'parent'=> $parent,
            'region_type'=>$region_type+1,
            'parent_id'=>$parent_id
        ]);
        
    }
	
}
    