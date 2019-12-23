<?php
namespace app\admin\validate;

class  AuthRuleValidate extends BaseValidate {
     // 验证规则
    protected  $rule = [
        ['title', 'require'],
        ['id', 'require'],
        ['pid', 'require'],
        ['id', 'require'],//异步操作的id
        ['val', 'require'],//异步操作的val
        
        
    ];
    //提示信息
    protected  $msg = [
    'id.require' => 'id必须',
    'title.require'=>'管理员名称必填',
    'pid.require'=>'密码必填',
    'id.require' => 'id必须',
    'val.require' => 'val必须',

];
    /**场景设置**/
    protected  $scene = [
        'delete' => ['id'], //删除
        'add' => ['title','pid'], //增加 
        'edit' => ['id','val'], //编辑
        'editAuth' => ['id','pid'] //编辑
    ];
}