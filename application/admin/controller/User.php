<?php
namespace app\admin\Controller;
use \think\Config;
use \think\Db;
use app\admin\Controller\Base;
use app\admin\model\Users;
use \think\Request;
class User extends Base
{
	// 用户列表
    public function list()
    {
        return $this->view->fetch('mall/user_list');
    }
   // 添加用户
    public function add()
    {
        
        return $this->view->fetch('mall/user_add');
    }
    // 编辑用户
    public function edit()
    {
        
        return $this->view->fetch('mall/user_edit');
    }
    // 添加用户积分
    public function levelAdd()
    {
        
        return $this->view->fetch('mall/user_add_level');
    }
    // 添加用户群发短信
    public function smsAdd()
    {
        
        return $this->view->fetch('mall/user_add_sms');
    }
    // 群发短信列表
    public function sms()
    {
        
        return $this->view->fetch('mall/user_sms');
    }
    // 收货地址
    public function addr()
    {
        
        return $this->view->fetch('mall/user_addr');
    }
     // 收货地址
    public function addrEdit()
    {
        
        return $this->view->fetch('mall/user_addr_edit');
    }
     // 充值提现
    public function toup()
    {
        
        return $this->view->fetch('mall/user_top_up');
    }
     // 添加充值金额
    public function addtoup()
    {
        
        return $this->view->fetch('mall/user_addtop_up');
    }
       // 资金变动
    public function drawal()
    {
        
        return $this->view->fetch('mall/user_withdrawal');
    }
        // 资金变动
    public function management()
    {
        
        return $this->view->fetch('mall/user_money_management');
    }
     // 发票
    public function invoice()
    {
        
        return $this->view->fetch('mall/user_check_invoice');
    }
      // 发票列表
    public function invoiceList()
    {
        
        return $this->view->fetch('mall/user_invoice');
    }
      // 发票列表
    public function account()
    {
        
        return $this->view->fetch('mall/user_edit_adjust_account');
    }
       // 意见反馈
    public function feedback()
    {
        
        return $this->view->fetch('mall/user_feedback');
    }
       // 留言回复
    public function reply()
    {
        
        return $this->view->fetch('mall/user_reply');
    }
}