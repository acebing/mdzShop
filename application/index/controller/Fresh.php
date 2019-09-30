<?php
namespace app\index\Controller;
use app\index\Controller\Base;
class Fresh extends Base
{
    public function index()
    {
    	
        return $this->view->fetch('fresh');
    }
    public function freshP()
    {
    	
        return $this->view->fetch('fresh-youxuan');
    }
}