<?php 
namespace app\admin\controller;
use think\Request;
use think\Controller;
use think\Config;
use think\File;
class Base extends Controller
{
   public function _initialize()
    {
         $this->assign([
                'mallMenu' => Config::get('mallMenu'),
                'siteMenu' => Config::get('siteMenu'), // 后台菜单
            ]); 
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
  
}
