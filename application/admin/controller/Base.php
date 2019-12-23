<?php 
namespace app\admin\controller;
use think\Request;
use think\Controller;
use think\Config;
use auth\Auth;
// use app\admin\Controller\Error;
class Base extends Controller
{
     /* @var string $route 当前控制器名称 */
    protected $controller = '';

    /* @var string $route 当前方法名称 */
    protected $action = '';

    /* @var string $route 当前路由uri */
    protected $routeUri = '';

    /* @var string $route 当前路由：分组名称 */
    protected $group = '';
    public $account;
   public function _initialize()
    {
        // 当前路由信息
        $this->getRouteinfo();
        // 权限认证
        // $this->authCheck();
        $this->assign([
                // 'adminName'=>$this->getLoginName(),
                'mallMenu' => Config::get('mallMenu'),
                'siteMenu' => Config::get('siteMenu'), // 后台菜单
            ]); 
        
        // if(!$this->isLogin()) {
        //     return $this->redirect(url('login.index/index'));
        // }
    }

     //判定是否登录
    protected function isLogin() {
        // 获取sesssion
        $user = $this->getLoginUser();
        if($user && $user->id) {
            return true;
        }
        return false;

    }

    protected function getLoginUser() {
        if(!$this->account) {
            $this->account = session('adminInfo', '', 'admin');
        }
        return $this->account;
    }
    protected function getLoginName() {
      
         $name = $this->getLoginUser();
         return $name->name;
    }
     /**
     * 解析当前路由参数 （分组名称、控制器名称、方法名）
     */
    protected function getRouteinfo()
    {
        // 控制器名称
        $this->controller = toUnderScore($this->request->controller());//驼峰命名转下划线命名
        // 方法名称
        $this->action = $this->request->action();
        // 控制器分组 (用于定义所属模块)
        // $groupstr = strstr($this->controller, '.', true);
        // $this->group = $groupstr !== false ? $groupstr : $this->controller;
        // 当前uri
        $this->routeUri = $this->controller . '/' . $this->action;
    }
    /**
     * 返回封装后的 API 数据到客户端
     * @param int $code
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderJson($code = 1, $msg = '', $url = '', $data = [])
    {
        return compact('code', 'msg', 'url', 'data');
    }

    /**
     * 返回操作成功json
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderSuccess($msg = 'success', $url = '', $data = [])
    {
        return $this->renderJson(1, $msg, $url, $data);
    }

    /**
     * 返回操作失败json
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderError($msg = 'error', $url = '', $data = [])
    {
        return $this->renderJson(0, $msg, $url, $data);
    }

    /**
     * 获取post数据 (数组)
     * @param $key
     * @return mixed
     */
    protected function postData($key)
    {
        return $this->request->post($key . '/a');
    }
    /**
     * 获取get数据 (数组)
     * @param $key
     * @return mixed
     */
    protected function getData($key)
    {
        return $this->request->get($key . '/d');
    }
   protected function authCheck()
    {
        $request = Request::instance();
        $auth = new Auth;
        $account = session('adminInfo', '', 'admin');
        $uid = $account->id;
        $url= $request->controller() . '/' . $request->action();
        // dump($url);die;
        if (!$auth -> check($url,$uid)) {
           return $this->error('无权限访问',url('index.index/index'));
        }
        
    }
}
