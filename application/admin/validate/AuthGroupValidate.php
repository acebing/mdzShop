<?php
namespace app\admin\validate;

class  AuthGroupValidate extends BaseValidate {
     // 验证规则
    protected  $rule = [
        ['title', 'require'],
        ['id', 'require'],
        ['rules', 'require']//异步操作的id
       
        
        
    ];
    //提示信息
    protected  $msg = [
    'id.require' => 'id必须',
    'title.require'=>'角色名称不能为空',
    'rules.require' => '权限至少选择一个'
   

];
    /**场景设置**/
    protected  $scene = [
        'delete' => ['id'], //删除
        'add' => ['title','rules'], //增加 
        'edit' => ['id'] //编辑
       
    ];
}