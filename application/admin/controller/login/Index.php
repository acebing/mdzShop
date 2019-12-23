<?php
namespace app\admin\Controller\login;
use app\admin\model\mallsite\Admin;
use app\admin\validate\AdminValidate;
use think\Controller;
class Index extends Controller
{
	
    // 商城登录首页
    public function index()
    {
        return $this->view->fetch('login/index');
    }

    /**
     * 后台登录操作
     * @return [type] [description]
     */
     public function doLogin()
    {
        
        if(request()->isPost()) {
           $admin = new Admin;
            //获取相关的数据
            $data = input('post.');
           //数据校验层
            (new AdminValidate)->scene('login')->goCheck();
            $ret = $admin->get(['name'=>$data['name']]);
            
            if(!$ret||$ret->id==null) {
               return $this->error('账号不存在,请确认一下');
               exit();
            }
            if($ret->password != md5($data['password'])) {
               return $this->error('密码不正确');
            }
            $admin->updateById(['last_login_time'=>time()], $ret->id);
            // 保存用户信息  admin是作用域
            session('adminInfo', $ret, 'admin');
            return $this->success('登录成功', url('index.index/index'));

        }else {
            // 获取session
            $account = session('adminInfo', '', 'admin');
            if($account && $account->id) {
                return $this->redirect(url('index.index/index'));
            }
            return $this->fetch();
        }
    }

    public function logout() {
        // 清除session
        session(null, 'admin');
        // 跳出
        $this->redirect('login.index/index');
    }
    
}