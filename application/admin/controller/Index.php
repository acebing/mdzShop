<?php
namespace app\admin\Controller;
use \think\Config;
use app\admin\Controller\Base;
class Index extends Base
{
	// 商城首页
    public function index()
    {
    	\phpmailer\Email::send('1991863791@qq.com','企业邮箱','测试1');
        return '发送邮件成功';
        // return $this->view->fetch();
    }
    // 商城登录首页
    public function login()
    {
    	
        return $this->view->fetch();
    }
    public function test()
    {
        Config::set('daa','sdsd');
        dump(Config::get('daa'));
    }
    
}