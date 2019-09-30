<?php
namespace app\admin\Controller;
use app\admin\Controller\Base;
class Category extends Base
{   
    private  $obj;
    public function _initialize() {
        $this->obj = model("Category");
    }
     // 商品分类列表
    public function list()
    {
        // 获取一级分类的数据
        $parentId = input('get.parent_id',0,'intval');
        $categorys = $this->obj->getFirstCategorys($parentId);
        $count= $this->obj->count();
        // echo($count);
        // exit();
        return $this->view->fetch('mall/goods_category_list', [
            'categorys'=> $categorys,
            'count'    => $count,
        ]);
    }
    // 商品分类添加
    public function add()
    {   
        // 获取一级分类的数据
        $categorys = $this->obj->getNormalFirstCategory();
        return $this->view->fetch('mall/goods_category_add', [
            'categorys'=> $categorys,
        ]);
    }
    // 编辑商品分类
    public function edit($cat_id)
    {   // 获取分类id
         $catId = input('get.cat_id',0,'intval');
         if ($catId<1) {
             $this->error('参数不合法');
         }
         // 通过分类id获取分类的详细信息
         $category = $this->obj->get($catId);
        // 获取所有分类的数据
        $categorys =  $this->obj->getNormalFirstCategory();
        // var_dump($categorys);
        // exit();
        return $this->view->fetch('mall/goods_category_edit', [
            'categorys'=>$categorys,
            'category'=> $category,
        ]);
    }
    // 商品分类添加/编辑更新操作
    public function save()
    { 
        // 判断是否是POST请求
        if(!request()->isPost()) {
            $this->error('请求失败');
        }
        // 获取post请求过来的数据
        $data = input('post.');
        // print_r($data);
        // exit();
        // 进行数据验证
        $validate = validate('Category');
        $data['cat_name'] = htmlentities($data['cat_name']);
        if(!$validate->scene('add')->check($data)) {
            $this->error($validate->getError());
        }
         if(!empty($data['cat_id'])) {
            return $this->update($data);
        }
        $res = $this->obj->add($data);
        if($res) {
            $this->success('新增成功');
        }else {
            $this->error('新增失败');
        }


    }
     public function update($data) {
        $res =  $this->obj->save($data, ['cat_id' => intval($data['cat_id'])]);
        if($res) {
            $this->success('更新成功');
        } else {
            $this->error('更新失败');
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