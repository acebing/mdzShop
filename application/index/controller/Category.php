<?php
namespace app\index\Controller;
use app\index\Controller\Base;
class Category extends Base
{
    public function index()
    {
    	
        return $this->view->fetch('Category');
    }
}