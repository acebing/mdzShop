<?php
namespace app\admin\Controller;
use app\admin\Controller\Base;
class MallSite extends Base
{   
     // 基本设置
    public function baseSite()
    {
        
        return $this->view->fetch();
    }
    // 支付设置
    public function basePaySite()
    {
        
        return $this->view->fetch();
    }
    // 地区设置
    public function areaSite()
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
    
       // 添加打印机
    public function basePrintAdd()
    {
        
        return $this->view->fetch();
    }
        // 友情链接列表
    public function friendLinkSite()
    {
        
        return $this->view->fetch();
    }
       // 添加友情链接
    public function friendLinkAdd()
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
        // 添加列表
    public function smsList()
    {
    
        return $this->view->fetch();
    }
         // 添加短信
    public function smsAdd()
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