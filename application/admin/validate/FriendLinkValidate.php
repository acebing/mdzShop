<?php
namespace app\admin\validate;

class  FriendLinkValidate extends BaseValidate {
    // 验证规则
    protected  $rule = [
        ['link_id', 'require|isPositiveInteger'],
        ['link_name', 'require|chsAlphaNum'],
        ['link_url', 'require|url'],
        ['logo_path', 'require'],
        ['id', 'require'],//异步操作的id
        ['val', 'require|number'],//异步更新排序的值
        
    ];
    //提示信息
    protected  $msg = [
    'id.require' => 'link_id名称必须',
    'link_name.require'=>'链接名称必填',
    'logo_path.require'=>'图片路径不能为空',

];
    /**场景设置**/
    protected  $scene = [
        'delete' => ['id'], //删除
        'add' => ['link_name','link_url','logo_path'], //增加 
        'edit' => ['link_id'], //删除
        'upldataOrder' => ['id','val'], //异步更新排序
    ];
}