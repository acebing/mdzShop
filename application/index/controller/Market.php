<?php
namespace app\index\Controller;
use app\index\Controller\Base;
class Market extends Base
{
    public function index()
    {
    	
        return $this->view->fetch('market');
    }
    public function marketP()
    {
    	
        return $this->view->fetch('market-xsqg');
    }
}