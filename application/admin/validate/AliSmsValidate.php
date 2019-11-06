<?php
namespace app\admin\validate;

class  AliSmsValidate extends BaseValidate {
    // 验证规则
    protected  $rule = [
        ['temp_id', 'require'],
        ['temp_content', 'require'],
        ['send_time', 'require'],
        ['id', 'require'],//异步操作的id
        
        
    ];
    //提示信息
    protected  $msg = [
    'id.require' => 'temp_id名称必须',
    'temp_id.require'=>'阿里短信内短信模板code必填',
    'temp_content.require'=>'阿里短信内容必填',
    'send_time.require'=>'发送时机必填',

];
    /**场景设置**/
    protected  $scene = [
        'delete' => ['id'], //删除
        'add' => ['temp_id','temp_content','send_time'], //增加 
        'edit' => ['id'] //编辑
    ];
}