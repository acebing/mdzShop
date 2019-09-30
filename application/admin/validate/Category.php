<?php
namespace app\admin\validate;
use think\Validate;

class Category extends Validate {
    protected  $rule = [
        ['cat_name', 'require|max:5', '分类名必须传递|分类名不能超过5个字符'],
        ['cat_alias_name','max:4', '分类别名不能超过4个字符'],
        ['id', 'number'],
        ['status', 'number|in:-1,0,1','状态必须是数字|状态范围不合法'],
        ['listorder', 'number'],
    ];

    /**场景设置**/
    protected  $scene = [
        'add' => ['cat_name'],// 添加
        'listorder' => ['id', 'listorder'], //排序
        'status' => ['id', 'status'],
    ];
}