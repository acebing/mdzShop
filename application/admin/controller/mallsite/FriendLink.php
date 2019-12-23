<?php 
namespace app\admin\Controller\mallsite;
use app\admin\Controller\Base;
use app\admin\validate\FriendLinkValidate;
use app\lib\exception\MissException;
use app\admin\model\mallsite\FriendLink as FriendLinkModel;
/**
 * 友情链接相关操作
 */
class FriendLink extends Base
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
    // 实例化FriendLink
    $this->obj = new FriendLinkModel;
  }

  /**
   * 渲染友情链接列表
   * @return [type] [description]
   */
  public function friendLinkList()
  {
    $list = $this->obj->list();
    return $this->view->fetch('mallsite/basesite/friend_link/friend_link_list',[
    'list'=>$list
    ]);
  }

  /**
   * 渲染舔加友情链接列表
   */
  public function addList()
  {
    return $this->view->fetch('mallsite/basesite/friend_link/friend_link_add');
  }

    /**
   * 友情链接添加和编辑操作
   */
  public function add()
    {
      $postData =input('post.');
      (new FriendLinkValidate)->scene('add')->goCheck();
      $res = $this->obj->add($postData);
      if (!$res) {
        $Exception = new MissException([
          'msg' => '该链接已经存在，不要重复添加',
          'errorCode' => 40000
        ]);
        throw  $Exception;
      }else{
        if (!empty($postData['link_id'])) {
          return $this->renderSuccess('编辑成功');
        }
        return $this->renderSuccess('添加成功');
      }
    }

  /**
   * 文件上传
   * @return [type] [description]
   */
  public function imgUpload()  
  {
   $file = request()->file('link_img');
    if($file){
        $info = $file->move('Uploads');
        if($info && $info->getPathname()) {
          // 移动到框架应用根目录/public/uploads/ 目录下
          return $this->renderSuccess('上传成功','',"/".$info->getPathname());
        }
        return renderError('上传失败');
    }
  }

  /**
   * 编辑友情链接操作
   * @return [type] [description]
   */
  public function edirFriendLink()
  {
    $getdata=input('get.link_id/d');
    (new FriendLinkValidate)->scene('edit')->goCheck();
    $editList=$this->obj::find($getdata);
    return $this->view->fetch('mallsite/basesite/friend_link/friend_link_edit',[
      'editList'=>$editList
      ]);
  }

  /**
   * 异步更新排序
   * @return [type] [description]
   */
	public function upldataOrder()
  {
    $postData = input('post.');
    (new FriendLinkValidate)->scene('upldataOrder')->goCheck();
    $res = $this->obj->showOrder($postData);
    if (!$res) {
        $Exception = new MissException([
          'msg' => '更新不成功，请联系技术员',
          'errorCode' => 40000
        ]);
        throw  $Exception;
      }else{
        return $this->renderSuccess('更新成功');
      }
  }

  /**
   * 删除友情链接操作
   * @return [type] [description]
   */
  public function deleteLink($id)
  { 
    (new FriendLinkValidate)->scene('delete')->goCheck();
    
    $res=$this->obj::destroy($id);
    if (!$res ) {
      throw new MissException([
        'msg' => '要删除的友情链接不存在',
        'errorCode' => 40000
      ]);
    }else{
    return $this->renderSuccess('删除成功');
    }
  }
    
}
    