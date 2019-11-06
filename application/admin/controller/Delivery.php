<?php
namespace app\admin\Controller;
use app\admin\Controller\Base;
use app\api\model\Region as regionModel;
use think\Db;
class Delivery extends Base
{   
    public function deliveryList()

    {
        // 获取打印机列表
        $printer=Db('printer')->where('id',1)->find();
         // 获取打印机列表
        $time=Db('delivery_time')->select();
        return $this->view->fetch('mallsite/delivery',[
             'printer'=> $printer,
             'time'=> $time
        ]);
    }
     
    /**
     * 三级联动
     * @return [type] [description]
     */
    public function areaSite()
    {
        $regionModel=new regionModel();
        // 返回省份列表
        $region=$regionModel->getRegions();
        return $this->view->fetch('',[
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
        $parent_id = (!empty(input('get.parent_id')) ? intval(input('get.parent_id')) : 0);
        //返回省份信息
        $region =$regionModel->get_regions_list($region_id);

        // 返回所属地区
        $parent =$regionModel->get_parent($region_id,$parent_id);
        return $this->view->fetch('area_list',[
            'region'=> $region,
            'parent'=> $parent,
        ]);
        
    }
    
     // 添加运费模板
    public function areaAddExpress()
    {
        // 三级联动
        $regionModel=new regionModel();
        // 返回省份列表
        $region = $regionModel->getRegions();
        $express=Db::name('express')->select();
        return $this->view->fetch('mallsite/area_add_express',[
            'express'=> $express,
            'region'=> $region,
           
        ]);
       
    }
    public function goodsTransport()
    {
        $postData= input('post.');
        echo '你选择了:'.implode(',',$postData['region_name']);
        // var_dump($postData);
    }
      // 添加快递鸟模板
    public function AddKuaidiniao()
    {
        
        return $this->view->fetch('mallsite/kuaidiniao');
    }
    
      // 添加打印机
    public function basePrintAdd()
    {
        $postData = input('post.','','htmlspecialchars');
        $printerData=[
            'id'=>$postData['printer_id'],
            'name'=>$postData['printer_name'],
            'manufacturers'=>$postData['printer_manufacturers'],
            'number'=>$postData['printer_number'],
            'key'=>$postData['printer_key'],
            'link_num'=>$postData['printer_link_num']
        ];
       $res=Db('printer')->strict(true)->update($printerData);
        if ($res) {
          $this->success('更新成功');  
        }else{
           $this->error('更新失败');  
        }
        
    }

//*****************自提时间段相关操作start**************//

   // 渲染自提时间段页面
    public function addTime()
    { 
        return $this->view->fetch('mallsite/add_time');
    }
    // 添加/更新自提时间段
    public function postAddTime()
    {
         // 判断是否是POST请求
        if(!request()->isPost()) {
            $this->error('请求失败');
        }
        // 获取post请求过来的数据
       $postData= input('post.','','htmlspecialchars');
       // 如果post过来的id不为空，则执行updata()
       if (!empty($postData['id'])) {
          return $this->updata($postData);
       }
       // 否则执行添加操作
        $res = Db('delivery_time')->strict(true)->insert($postData);
        if($res) {
            $this->success('新增成功');
        }else {
            $this->error('新增失败');
        }
    }
    // 更新操作
    public function updata($postData)
    { 
        $res=Db('delivery_time')
          ->strict(true)
          ->where('id',$postData['id'])
          ->update($postData);
          if($res) {
            $this->success('更新成功');
        } else {
            $this->error('更新失败');
        }    
    }
    // 编辑操作
    public function timeEdit()
    {    
        $getid = input('get.id');

        if (empty($getid) ){
           $this->error('参数不合法');
       }
       $timeEdit=Db('delivery_time')->where('id',$getid)->find();

       return $this->view->fetch('mallsite/edit_time',[
        'timeEdit'=>$timeEdit,
    ]);
    }
    // 删除操作
    public function timeRemove()
    {    
        $getid = input('get.id');

        if (empty($getid) ){
           $this->error('参数不合法');
       }
       $res=Db('delivery_time')->delete($getid);
       if (!$res) {
                return show(0,'error');
           }else{
             return show(1,'删除成功',$res);
           }
      
   
    }

//*****************自提时间段相关操作end**************//     
}