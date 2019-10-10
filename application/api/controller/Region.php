<?php
namespace app\api\controller;
use think\Controller;
use app\api\model\Region as regionModel;
class Region extends Controller
{
    private  $obj;
    public function _initialize() {
        $this->obj = model("Region");
    }
    /**
     * 省份三级联动
     * @return [type] [description]
     */
    public function getCitysByParentId() {
        $type = (!empty(input('get.type')) ? intval(input('get.type')) : 0);
        $parent = (!empty(input('get.parent')) ? intval(input('get.parent')) : 0);
        $shipping = (!empty(input('get.shipping')) ? intval(input('get.shipping')) : 0);
        $type = $type + 1;
        //返回省份信息
        $region = $this->obj->get_regions($type, $parent);
        if(!$region) {
            return show(0,'error');
        }
        return show(1,'设置成功', $region);
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
    public function add()
    { 
        // 判断是否是POST请求
        if(!request()->isPost()) {
            $this->error('请求失败');
        }
        // return "sdsff";
        // exit();
        // 获取post请求过来的数据
        $data = input('post.');
        // print_r($data);
        // exit();
        // 进行数据验证
        // $validate = validate('Category');
        // $data['cat_name'] = htmlentities($data['cat_name']);
        // if(!$validate->scene('add')->check($data)) {
        //     $this->error($validate->getError());
        // }
        //  if(!empty($data['cat_id'])) {
        //     return $this->update($data);
        // }
        $res = $this->obj->add($data);
        if($res) {
            return show(1, '添加成功' , $res);
        }else {
            return show(1,'添加失败');
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
            return show(1, '删除成功' );
        }else {
            return show(1,'删除失败');
        }
    }
}
