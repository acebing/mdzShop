<?php
namespace app\admin\Controller\index;
use app\admin\Controller\Base;
use app\admin\validate\AdminListValidate;
class Index extends Base
{
	// 商城首页
    public function index()
    {
    	
        return $this->view->fetch('index/index');
    }
   
}