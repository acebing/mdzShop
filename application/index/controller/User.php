<?php
namespace app\index\Controller;
use app\index\Controller\Base;
class User extends Base
{
    public function index()
    {
    	
        return $this->view->fetch('user-index');
    }
    
}