<?php
namespace app\admin\Controller\mallsite;
use app\admin\Controller\Base;
use app\api\model\Region as regionModel;
use app\admin\validate\DeliveryValidate;
use app\lib\exception\MissException;
use app\admin\model\mallsite\Delivery as DeliveryModel;
use think\Db;
class Delivery extends Base
{      
    private  $obj;
  /**
   * 实例化对象
   * @return [type] [description]
   */
  public function _initialize() 
  {
    //实例化父类
    parent::_initialize();
    // 实例化SmsSite
    $this->obj = new DeliveryModel;
  }
    public function deliveryList()

    {
        // 获取打印机列表
        $printer=Db('printer')->where('id',1)->find();
         // 获取打印机列表
        $time=Db('delivery_time')->select();
        // 从配送区域表获取配送区域信息
        $deliveryList = $this->obj->deliveryList();
        // 遍历出省份ID
        foreach ($deliveryList as $key => $value) {
          $arr = $value->toArray();
          $region_id = $arr['region_id'];
          // 实例化省份表
          $res =  new regionModel;
          $list = $res->all($region_id);
          // 遍历出省份名称
          foreach ($list as $k => $v) {
            $region_name_arr = $v->toArray();
            // 获取省份名称
            $arr=[];
            $arr = $region_name_arr['region_name'];
            dump($arr);
             
        }
        }
        die;
        return $this->view->fetch('mallsite/basesite/delivery/index',[
             'printer'=> $printer,
             'time'=> $time,
             'deliveryList'=> $deliveryList,
             'list'=>$list
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
        $id=input('get.id/d');
        // 三级联动
        $regionModel=new regionModel();
        // 返回省份列表
        $region = $regionModel->getRegions();
        $express=Db::name('express')->select();
        if ($id==0) {
           $list=[];
           $mode=[];
        }else{
          $list=$this->obj::find($id);
         
         if ($list->fee_compute_mode=='by_weight') {
          $mode = db('delivery_w')->where('d_id',$list->id)->find();

         } else {
          $mode = db('delivery_c')->where('d_id',$list->id)->find();
          // dump($mode);die;
         }
         
        }
        return $this->view->fetch('mallsite/basesite/delivery/area_add_express',[
            'express'=> $express,
            'region'=> $region,
            'list'=> $list,
            'mode'=> $mode,
           
        ]);
       
    }

   public function addGoodsTransport()
  {
    $postData =input('post.');
   if($postData['region_id']){
    $postData['region_id'] = implode(',', $postData['region_id']);
   }
   if ($postData['fee_compute_mode']=='by_weight') {
     // 数据校验层
    (new DeliveryValidate)->scene('by_weight')->goCheck();
   }
   if ($postData['fee_compute_mode']=='by_number') {
     // 数据校验层
    (new DeliveryValidate)->scene('by_number')->goCheck();
   }
    $res = $this->obj->add($postData);
    if (!$res) {
      // 异常处理层
      $Exception = new MissException([
        'msg' => '非法操作',
        'errorCode' => 40000
      ]);
      throw  $Exception;
    }else{
      if (intval($postData['id'])>0) {
        return $this->renderSuccess('编辑成功');
      }
      return $this->renderSuccess('添加成功');
    }
  }
  public function deleteDelivery()
  { 
    $id= input('get.');
    // 数据校验层
    (new DeliveryValidate)->scene('delete')->goCheck();
    $DeliveryId = $this->obj::get($id);
    dump($DeliveryId );die;
    $wid=db('delivery_w')->where('d_id',$id)->delete();
    $cid=db('delivery_c')->where('d_id',$id)->delete();
    if (!$adminid && !$wid && !$cid) {
      // 异常处理层
      throw new MissException([
        'msg' => '非法操作',
        'errorCode' => 40000
      ]);
    }else{
    return $this->renderSuccess('删除成功');
    }
  }
      // 添加快递鸟模板
    public function AddKuaidiniao()
    {
        
        return $this->view->fetch('mallsite/basesite/delivery/kuaidiniao');
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
        return $this->view->fetch('mallsite/basesite/delivery/add_time');
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

       return $this->view->fetch('mallsite/basesite/delivery/edit_time',[
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