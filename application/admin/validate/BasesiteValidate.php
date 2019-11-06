<?php
namespace app\admin\validate;

class  BasesiteValidate extends BaseValidate {
    
    protected  $rule = [
        ['base_id', 'number', 'base_id必须为数字'],
        ['shop_name', 'require|min:5|max:10', '网站名称不能为空|网站名称不能超过10个字符'],
        ['shop_title','require', '网站标题不能为空'],
        ['shop_desc', 'require','网站描述不能为空'],
        ['shop_keywords', 'require','网站关键字不能为空'],
        ['province_id', 'require|number','地区不能为空'],
        ['shop_address', 'require','详细地址不能为空'],
        ['service_phone', 'require','服务电话不能为空'],
    ];
}