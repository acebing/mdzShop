<?php
namespace app\admin\Controller\mallsite;
use app\admin\Controller\Base;
use app\admin\validate\BasesiteValidate;
use app\api\model\Region as regionModel;
use app\admin\model\mallsite\BaseSite as baseSiteModel;
class BaseSite extends Base
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
    $this->obj = new baseSiteModel;
  }
    public function index()
    {
        
        $regionModel = new regionModel;
        // 三级联动
        $region = $regionModel->getRegions();
        $baseData = $this->obj::get(1);
        return $this->view->fetch('mallsite/basesite/site/index',[
            'region'=> $region,
            'baseData'=>$baseData
        ]);
    }
    public function baseSiteAdd()
    {
        // 判断是否是post请求
        if(!request()->isPost()) {
           $this->renderError('请求类型错误');
        }
        $data = input('post.');
        (new BasesiteValidate())->goCheck();

        $res = $this->obj->add($data);
      
        if (!empty($res) ) {
          return $this->renderSuccess('更新成功');  
        }else{
          return $this->renderError('更新失败');  
        }
    }
}