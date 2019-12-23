<?php 
namespace app\admin\Controller\mallsite;
use app\admin\Controller\Base;
use app\admin\validate\AuthRuleValidate;
use app\lib\exception\MissException;
use app\admin\model\mallsite\AuthRule as AuthRuleModel;

/**
 * 阿里短信模板相关操作
 */
class AuthRule extends Base
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
    $this->obj = new AuthRuleModel;
  }
  
  /**
   * 一级权限列表
   * @return array  返回一级权限列表
   */
  public function loadAdminAuthList()
  {
   // 从模型获取一级权限列表
    $firstList = $this->obj->getFistList();
    // 获取分页显示
     return $this->view->fetch('mallsite/admin/admin_auth_first_list',[
      'firstList'=> $firstList
    ]);
  }
  
  /**
   * 二级权限列表
   * @return [type] [description]
   */
  public function loadSecondList()
  {
    $getparentId =input('get.id/d');
    // 从模型获取二级权限列表
    $secondList = $this->obj->getSecondList($getparentId);
    $parentname = $this->obj->getParentName($getparentId);
     return $this->view->fetch('mallsite/admin/admin_auth_second_list',[
      'secondList'=> $secondList,
      'parentname'=> $parentname,
    ]);
  }

  /**
   * 渲染输出添加和编辑权限，共用同一个模板
   */
  public function addAuth()
  {
    $getData=input('get.');
    // 获取一级分类列表
    $firstList = $this->obj->getFistList();
    
    // 如果id的值为0,是添加操作 ，否则是编辑操作
    if ($getData['id']==0&&$getData['pid']==0) {
     $List=[];
     $parentname =[];
    }else{
      // 数据校验层
      (new AuthRuleValidate)->scene('editAuth')->goCheck();
      $List=$this->obj::find($getData['id']);
      $parentname = $this->obj->getParentName($getData['pid']);
      
    }
    return $this->view->fetch('mallsite/admin/admin_auth_add',[
      'firstList'=>$firstList,
      'List'=>$List,
      'parentname'=>$parentname
    ]);
  }

  /**
   * 权限添加和编辑操作
   */
  public function addAuthContent()
  {
    $postData =input('post.');
    
    // 数据校验层
    (new AuthRuleValidate)->scene('add')->goCheck();
    // 执行添加操作
    $res = $this->obj->add($postData);
    if (!$res) {
      // 异常处理层
      $Exception = new MissException([
        'msg' => '权限已经存在，不要重复添加',
        'errorCode' => 40000
      ]);
      throw  $Exception;
    }else{
      if (intval($postData['id'])>0) {
       
        return $this->renderSuccess('编辑成功',url('loadadminauthlist'));
      }
      return $this->renderSuccess('添加成功');
    }
  }

  /**
   * 异步更新auth_name字段
   * @return [type] [description]
   */
  public function editAuthName()
  {
    $postData = input('post.');
    (new AuthRuleValidate)->scene('edit')->goCheck();
    $res = $this->obj->updateAuthName($postData);
  }

  // 异步更新auth_url字段
  public function editAuthUrl()
  {
    $postData = input('post.');
    (new AuthRuleValidate)->scene('edit')->goCheck();
    $res = $this->obj->updateAuthUrl($postData);
  }

  /**
   * 删除权限操作
   * @return [type] [description]
   */
  public function deleteAuth()
  { 
    $parentID=input('get.id');
    $secondList = $this->obj->getSecondList($parentID);
   if ($secondList) {
     return $this->renderError('此权限存在有子目录，不能删除，请先删除子目录');
   }else{
    // 数据校验层
    (new AuthRuleValidate)->scene('delete')->goCheck();
    $res=$this->obj::destroy($parentID);
    if (!$res ) {
      // 异常处理层
      throw new MissException([
        'msg' => '要删除的权限不存在',
        'errorCode' => 40000
      ]);
    }else{
    return $this->renderSuccess('删除成功');
    }
  }
  }
}
