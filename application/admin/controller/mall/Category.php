<?php
namespace app\admin\Controller\mall;
use app\admin\Controller\Base;
use app\admin\validate\CategoryValidate;
use app\lib\exception\MissException;
use app\admin\model\mall\Category as CategoryModel;
class Category extends Base
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
    $this->obj = new CategoryModel;
  }
    
     // 商品分类列表
    public function list()
    {
        // 获取一级分类的数据
        $parentId = input('get.parent_id',0,'intval');
        $categorys = $this->obj->getFirstCategorys($parentId);
        $count=1;
        return $this->view->fetch('mall/goods/goods_category_list', [
            'categorys'=> $categorys,
            'count'    => $count,
        ]);
    }
    // public function map()
    // {
    //     return \ Map::staticimage('丘北');
    // }
    // 商品分类添加
    public function addEdite()
    {   
      $catId = input('get.cat_id');
      
      if ($catId==null) {
      $catdata=[];
      } else {
      $catdata = $this->obj->get($catId);
      // dump($catdata);die;
      }
      // 获取一级分类的数据
      $categorys = $this->obj->getNormalFirstCategory();
      return $this->view->fetch('mall/goods/goods_category_add_edte', [
          'categorys'=> $categorys,
          'catdata'=>$catdata
      ]);
    }
   
    // 商品分类添加/编辑更新操作
    public function categoryHandle()
    { 
        // 判断是否是POST请求
        if(!request()->isPost()) {
            $this->error('请求失败');
        }
        // 获取post请求过来的数据
        $postData =input('post.');
    // 数据校验层
    (new CategoryValidate)->scene('add')->goCheck();
    // dump($postData);die;
    // 执行添加操作并返回自增id
    $res = $this->obj->handle($postData);
    
    if (!$res) {
      // 异常处理层
      $Exception = new MissException([
        'msg' => '不要重复添加',
        'errorCode' => 40000
      ]);
      throw  $Exception;
    }else{
      if (intval($postData['cat_id'])>0) {
        return $this->renderSuccess('编辑成功');
      }
      return $this->renderSuccess('添加成功');
    }


    }
    public function getLevellcat()
    {
      $getData = input('get.parent_id');
     $res = $this->obj->getFirstCategorys($getData);
    return $res;
    // return $res->cat_id;
     // return $this->renderSuccess('获取数据成功','',$res);
    }
   public function getfistcat()
     {
       $getData = input('get.parent_id');
       $categorys = $this->obj->getFirstCategorys($getData);
       $this->assign('categorys',$categorys);
       return $categorys;
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
    // 排序逻辑
    public function listorder($id, $listorder) {
        $data =[
            'sort_order'=>$listorder,
             'cat_id'=>$id
        ];
        $res = $this->obj->update($data);
        if($res) {
            return $this->result($_SERVER['HTTP_REFERER'], 1, '更新成功');
        }else {
            return $this->result($_SERVER['HTTP_REFERER'], 0, '更新失败');
        }
    }
    // 佣金逻辑
    public function commission($id, $commission) {
         $data =[
            'commission_rate'=>$commission,
             'cat_id'=>$id
        ];
        $res = $this->obj->update($data);
        if($res) {
            return $this->result($_SERVER['HTTP_REFERER'], 1, '更新成功');
        }else {
            return $this->result($_SERVER['HTTP_REFERER'], 0, '更新失败');
        }
    }
    // 是否逻辑
    public function show($id, $is_show) {
        $res = $this->obj->save(['is_show'=>$is_show], ['cat_id'=>$id]);
         if($res) {
            return $this->result($_SERVER['HTTP_REFERER'], 1, '更新成功');
        }else {
            return $this->result($_SERVER['HTTP_REFERER'], 0, '更新失败');
        }
    }
    //删除逻辑
    public function remove($id) {
        $res = $this->obj->destroy($id);
      if($res) {
            return $this->result($_SERVER['HTTP_REFERER'], 1, '更新成功');
        }else {
            return $this->result($_SERVER['HTTP_REFERER'], 0, '更新失败');
        }
    }
}