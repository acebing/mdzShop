<?php
namespace app\index\Controller;
use app\index\Controller\Base;
class Goods extends Base
{
    public function index()
    {
    	
        return $this->view->fetch('goods');
    }
    
}