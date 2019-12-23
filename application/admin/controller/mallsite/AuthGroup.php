<?php 
namespace app\admin\Controller\mallsite;
use app\admin\Controller\Base;
use app\admin\validate\AuthGroupValidate;
use app\lib\exception\MissException;
use app\admin\model\mallsite\AuthRule as AuthRuleModel;
use app\admin\model\mallsite\AuthGroup as AuthGroupModel;

/**
 * 阿里短信模板相关操作
 */
class AuthGroup extends Base
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
    $this->obj = new AuthGroupModel;
  }
  
  /**
   * 管理员列表
   * @return array  返回角色模板列表
   */
  public function loadAdminRoleList()
  {
   // 从模型获取角色模板列表
    $list = $this->obj->getRoleList();
     return $this->view->fetch('mallsite/admin/admin_role',[
      'list'=> $list,
      'page'=>$list->render(),
    ]);
   
   
  }
  /**
   * 渲染输出添加和编辑角色，共用同一个模板
   */
  public function addRole()
  {
    $id=input('get.id/d');
    $authList = $this->getRecommendCats();
    // 如果id的值为0,是添加操作 ，否则是编辑操作
    if ($id==0) {
     $list=[];
     $rules=[];
    }else{
      // 数据校验层
      (new AuthGroupValidate)->scene('edit')->goCheck();
     $list = $this->obj::find($id);
     $rules = explode(',', $list->rules);
    }
    return $this->view->fetch('mallsite/admin/admin_role_add',[
      'list'=>$list,
      'authList'=>$authList,
      'rules'=>$rules
    ]);
  }

  /**
   * 角色添加和编辑操作
   */
  public function addRoleContent()
  {
    $postData =input('post.');
   if($postData['rules']){
    $postData['rules'] = implode(',', $postData['rules']);
   }
    
    // 数据校验层
    (new AuthGroupValidate)->scene('add')->goCheck();
    // dump($postData);die;
    // 执行添加操作
    $res = $this->obj->add($postData);
    if (!$res) {
      // 异常处理层
      $Exception = new MissException([
        'msg' => '非法操作',
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
  public function deleteRole()
  { 
    $id=input('get.id/d');
    // 数据校验层
    (new AuthGroupValidate)->scene('delete')->goCheck();
    $res=$this->obj::destroy($id);
    if (!$res ) {
      // 异常处理层
      throw new MissException([
        'msg' => '非法操作',
        'errorCode' => 40000
      ]);
    }else{
    return $this->renderSuccess('删除成功');
    }
  }
  /**
     * 获取权限分类数据
     */
    public function getRecommendCats() {
      $AdminAuth = new AuthRuleModel; 
      $parentIds = $sedcatArr = $recomCats = [];
      // 获取一级数据
      $cats = $AdminAuth->getNormalRecommendCategoryByParentId(0);
      foreach($cats as $cat) {
          $parentIds[] = $cat->id;
      }
      // 获取二级分类的数据
      $sedCats = $AdminAuth->getNormalCategoryIdParentId($parentIds);

      foreach($sedCats as $sedcat) {
          $sedcatArr[$sedcat->pid][] = [
              'id' => $sedcat->id,
              'title' => $sedcat->title,
          ];
      }
      foreach($cats as $cat) {
          // recomCats 代表是一级 和 二级数据，  []第一个参数是 一级分类的name, 第二个参数 是 此一级分类下面的所有二级分类数据
          $recomCats[$cat->id] = [$cat->id,$cat->title, empty($sedcatArr[$cat->id]) ? [] : $sedcatArr[$cat->id]];
      }
      return $recomCats;
    }
}
