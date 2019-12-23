<?php
namespace app\admin\validate;

class  AdminValidate extends BaseValidate {
     // 验证规则
    protected  $rule = [
        ['name', 'require'],
        ['password', 'require'],
        ['email', 'require|email'],
        ['id', 'require'],//异步操作的id
        
        
    ];
    //提示信息
    protected  $msg = [
    'id.require' => 'id必须',
    'name.require'=>'用户名必填',
    'password.require'=>'密码必填',
    'email.require'=>'邮箱必填'

];
    /**场景设置**/
    protected  $scene = [
        'delete' => ['id'], //删除
        'add' => ['name','password','email'], //增加 
        'edit' => ['id'] ,//编辑
        'login' => ['name','password'], //登录验证
    ];
}