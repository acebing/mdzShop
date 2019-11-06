<?php
namespace app\admin\Controller;
use app\admin\Controller\Base;
use app\admin\validate\BasesiteValidate;
use app\api\model\Region as regionModel;
use think\Db;
class MallSite extends Base
{   
    
     // 基本设置
    public function baseSite()
    {
        
        $regionModel=new regionModel();
        // 三级联动
        $region=$regionModel->getRegions();
        $baseData = model('BaseSite')::get(1);
        return $this->view->fetch('',[
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
        $res = model('BaseSite')->add($data);
        if (!empty($res) ) {
          return $this->renderSuccess('更新成功');  
        }else{
          return $this->renderError('更新失败');  
        }
    }

    public function delivery()
    {
        return $this->view->fetch();
    }
     // 添加运费模板
    public function areaAddExpress()
    {
        
        return $this->view->fetch();
    }
      // 添加运费模板
    public function areaAddKuaidiniao()
    {
        
        return $this->view->fetch();
    }
   
    // 支付设置
    public function basePaySite()
    {
        
        return $this->view->fetch();
    }
        // OSS
    public function oss()
    {
        
        return $this->view->fetch();
    }
        // OSS
    public function ossAdd()
    {
        
        return $this->view->fetch();
    }
        // 权限设置
    public function permissions()
    {
        
        return $this->view->fetch();
    }
        // 添加管理员
    public function permissionsAddAdmin()
    {
        
        return $this->view->fetch();
    }
        // 权限设置
    public function permissionsAllotAdmin()
    {
        
        return $this->view->fetch();
    }
        // 管理员角色设置
    public function permissionsRole()
    {
        
        return $this->view->fetch();
    }
         // 管理员日志
    public function permissionsSeeAdminLog()
    {
        
        return $this->view->fetch();
    }
         // 第三方登录
    public function thirdLogin()
    {
    
        return $this->view->fetch();
    }
          // 微信公众号设置 
    public function weixin()
    {
    
        return $this->view->fetch();
    }
          // 微信小程序 
    public function weixinxcx()
    {
    
        return $this->view->fetch();
    }
	// 邮箱设置
    public function email()
    {
    	
        return $this->view->fetch();
    }
}