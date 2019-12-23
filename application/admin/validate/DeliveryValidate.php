<?php
namespace app\admin\validate;

class  DeliveryValidate extends BaseValidate {
     // 验证规则
    protected  $rule = [
        ['express_name', 'require|chsAlphaNum'],//快递名称
        ['item_fee', 'require|number'],//单件运费金额
        ['base_fee', 'require|number'],//1000克以内费用
        ['step_fee', 'require|number'],//5000克以内续重每500克费用
        ['step_fee1', 'require|number'],//5001克以上续重500克费用
        ['free_money', 'require|number'],//免费额度
        ['region_id', 'require'],//省份id
        ['id', 'require|number']
        
        
    ];
    //提示信息
    protected  $msg = [
    'item_fee.require'=>'单件运费金额必填',
    'base_fee.require'=>'1000克以内费用必填',
    'step_fee.require'=>'5000克以内续重每500克费用必填',
    'step_fee1.require'=>'5001克以上续重500克费用必填',
    'free_money.require'=>'免费额度必填',
    'region_id.require'=>'配送地区必选',
    'id.require' => 'id必须',

];
    /**场景设置**/
    protected  $scene = [
        'delete' => ['id'], //删除
        'by_number' => ['express_name','item_fee','free_money','region_id','id'], //按件数计算
        'by_weight' => ['express_name','base_fee','step_fee','step_fee1','free_money','region_id','id'], //按增加计算 
    ];
}