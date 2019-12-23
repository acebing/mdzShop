<?php 
namespace app\admin\controller;
use app\admin\controller\Base;
use think\Config;
class Error extends Base
{
    public function authError()
    {
        return $this->view->fetch('public/error',[
            'siteMenu' => Config::get('siteMenu')
        ]);
    }
}
