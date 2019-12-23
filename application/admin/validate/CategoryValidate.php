<?php
namespace app\admin\validate;

class  CategoryValidate extends BaseValidate {
     protected  $rule = [
        ['cat_name', 'require|max:5'],
        ['id', 'number'],
        ['is_show', 'number|in:-1,0,1',''],
        ['listorder', 'number'],
    ];
    //提示信息
    protected  $msg = [
    'id.require' => 'id必须',
    'cat_name.require'=>'分类名必须传递|分类名不能超过5个字符',
    
    'is_show.require'=>'状态必须是数字|状态范围不合法'

];
    /**场景设置**/
    protected  $scene = [
        'delete' => ['id'], //删除
        'add' => ['cat_name'], //增加 
        'edit' => ['id'] ,//编辑
        'login' => ['name','password'], //登录验证
    ];
}