<?php
namespace app\index\Controller;
use app\index\Controller\Base;
class Index extends Base
{
	// 商城首页
    public function index()
    {
    	
        return $this->view->fetch('index');
    }
    // 商城登录首页
    public function login()
    {
    	
        return $this->view->fetch('index/login');
    }
    // 商城登录注册页
    public function res()
    {
    	
        return $this->view->fetch('index/res');
    }
}