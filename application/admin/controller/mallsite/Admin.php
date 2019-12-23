<?php 
namespace app\admin\Controller\mallsite;
use app\admin\Controller\Base;
use app\admin\validate\AdminValidate;
use app\lib\exception\MissException;
use app\admin\model\mallsite\Admin as AdminModel;
use app\admin\model\mallsite\AuthGroup as AuthGroupModel;
use app\admin\model\mallsite\AuthGroupAccess;
use auth\Auth;
use think\Session;
/**
 * 阿里短信模板相关操作
 */
class Admin extends Base
{
	private  $obj;
  /**
   * 实例化对象
   * @return [type] [description]
   */
  public function _initialize() 
  {
    //实例化父类
    parent::_initialize();
    // 实例化SmsSite
    $this->obj = new AdminModel;
  }
  
  /**
   * 管理员列表
   * @return array  返回管理员模板列表
   */
  public function loadAdminList()
  {
   // 从模型获取管理员列表
    $list = $this->obj->getAdminList();
    $auth = new Auth;
    foreach ($list as $k => $v) {
      $title=$auth->getGroups($v['id']);
      $grouptitle = $title[0]['title'];
      $v['grouptitle']=$grouptitle;
    }
    return $this->view->fetch('mallsite/admin/admin_list',[
      'list'=> $list,
      'page'=>$list->render() //分页
    ]);
   
   
  }
  /**
   * 渲染输出添加和编辑管理员，共用同一个模板
   */
  public function addAdmin()
  {
    $id=input('get.id/d');
    $AuthGroup = new AuthGroupModel;
    $authGroupList = $AuthGroup->select();
    // 如果id的值为0,是添加操作 ，否则是编辑操作
    if ($id==0) {
     $List=[];
     $act = 'add';
     $groupName=[];
    }else{
      // 数据校验层
      (new AdminValidate)->scene('edit')->goCheck();
      $List=$this->obj::find($id);
      $access = (new AuthGroupAccess)->where('uid',$id)->find();
      $groupName = (new AuthGroupModel)->where('id',$access->group_id)->find();
      $act = 'edit';
    }
    return $this->view->fetch('mallsite/admin/admin_add',[
      'List'=>$List,
      'authGroupList'=>$authGroupList,
      'groupName'=>$groupName,
      'act'=>$act
    ]);
  }
  /**
   * 异步判断管理员名称是否存在
   * @return [type] [description]
   */
  public function checkAdminName()
  {
    
    $postData =input('post.');
    if ($postData['act']=='edit') {
     return true;
    }
    $adminName = $this->obj->get(['name'=>$postData['name']]);
      if($adminName) {
      return false;
     
      }else{
      return true;
      }
  }
  /**
   * 管理员添加和编辑操作
   */
  public function addAdminContent()
  {
    $postData =input('post.');
    // 数据校验层
    (new AdminValidate)->scene('add')->goCheck();

    // 执行添加操作并返回自增id
    $res = $this->obj->add($postData);
    
    if (!$res) {
      // 异常处理层
      $Exception = new MissException([
        'msg' => '不要重复添加',
        'errorCode' => 40000
      ]);
      throw  $Exception;
    }else{
      if (intval($postData['id'])>0) {
        return $this->renderSuccess('编辑成功');
      }
      return $this->renderSuccess('添加成功');
    }
  }

  /**
   * 删除管理员操作
   * @return [type] [description]
   */
  public function deleteAdmin($id)
  { 
    // 数据校验层
    (new AdminValidate)->scene('delete')->goCheck();
    $adminid = $this->obj::destroy($id);
    $uid=(new AuthGroupAccess)::where('uid','=',$id)->delete();
    if (!$adminid && !$uid) {
      // 异常处理层
      throw new MissException([
        'msg' => '非法操作',
        'errorCode' => 40000
      ]);
    }else{
    return $this->renderSuccess('删除成功');
    }
  }

}
