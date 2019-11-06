<?php 
namespace app\admin\Controller;
use app\admin\Controller\Base;
use app\admin\validate\AliSmsValidate;
use app\lib\exception\MissException;
use alisms\AliSms;

/**
 * 阿里短信模板相关操作
 */
class SmsSite extends Base
{
	private  $obj;
  /**
   * 实例化对象
   * @return [type] [description]
   */
  public function _initialize() 
  {
    //实例化父类
    parent::_initialize();
    // 实例化SmsSite
    $this->obj = model("SmsSite");
  }
  
  /**
   * 短信模板
   * @return array  返回短信模板列表
   */
  public function loadTemplatList()
  {
   // 从模型获取短信模板列表
    $list = $this->obj->getTemplat();
     return $this->view->fetch('mallsite/alisms_list',[
      'list'=> $list
    ]);

  }

  /**
   * 渲染输出添加和编辑短信模板，共用同一个模板
   */
  public function addTemplat()
  {
    $id=input('get.id/d');
    // 如果id的值为null,是添加操作 ，否则是编辑操作
    if (is_null($id)) {
     $List=[];
    }else{
      // 异常处理层
      (new AliSmsValidate)->scene('edit')->goCheck();
      $List=$this->obj::find($id);
    }
    // var_dump($List);
    // exit();
    return $this->view->fetch('mallsite/alisms_add',[
      'List'=>$List
    ]);
  }

  /**
   * 短信模板添加和编辑操作
   */
  public function addTemplatContent()
  {
    $postData =input('post.');
    // 数据校验层
    (new AliSmsValidate)->scene('add')->goCheck();
    // 执行添加操作
    $res = $this->obj->add($postData);
    if (!$res) {
      // 异常处理层
      $Exception = new MissException([
        'msg' => '短信模板已经存在，不要重复添加',
        'errorCode' => 40000
      ]);
      throw  $Exception;
    }else{
      if (intval($postData['id'])>0) {
        return $this->renderSuccess('编辑成功');
      }
      return $this->renderSuccess('添加成功');
    }
  }

  /**
   * 删除短信模板操作
   * @return [type] [description]
   */
  public function deleteTemplat($id)
  { 
    // 数据校验层
    (new AliSmsValidate)->scene('delete')->goCheck();
    $res=$this->obj::destroy($id);
    if (!$res ) {
      // 异常处理层
      throw new MissException([
        'msg' => '要删除的短信模板不存在',
        'errorCode' => 40000
      ]);
    }else{
    return $this->renderSuccess('删除成功');
    }
  }

  /**
   * 测试短信发送
   * @return [type] [description]
   */
  public function testTemplat()
  {   
      $getdata=input('get.');
      $id = intval($getdata['id']);
      $phoneNum = intval($getdata['phoneNum']);
      switch ($id) {
        // 验证码通知
        case 1:
         $alicode = 'SMS_141600069';
         $centen = [
          'code'=>mt_rand(100000,999999)
      ];
        break;
        // 验证码通知
        case 2:
        $alicode = 'SMS_141565160';
         $centen = [
          'code'=>mt_rand(100000,999999)
      ];
        break;
        // 验证码通知
        case 3:
        $alicode = 'SMS_141580539';
        $centen = [
          'code'=>mt_rand(100000,999999)
      ];
        break;
        // 商家店铺等级到期时间提醒
        case 4:
        $alicode = 'SMS_141580543';
        $centen = [
          'username'=>'隔壁老沈',
          'gradeendtime'=>date("Y-m-d H:i:s",intval(time()))
          
      ];
        break;
        // 会员充值/提现时
        case 5:
        $alicode = 'SMS_141595548';
        $centen = [
          'username'=>'隔壁老沈',
          'addtime'=>date("Y-m-d H:i:s",intval(time())),
          'fmtamount'=>10,
          'processtype'=>'提现',
          'optime'=>date("Y-m-d H:i:s",intval(time())),
          'examine'=>'通过',
          'usermoney'=>1458795.24
          
      ];
        break;
        // 客户密码找回时
        case 6:
        $alicode = 'SMS_141580542';
        $centen = [
          'sellername'=>'隔壁老沈',
          'loginname'=>'隔壁老王',
          'password'=>'sl122222'
      ];
        break;
        // 商品降价时
        case 7:
        $alicode = 'SMS_141580540';
        $centen = [
          'goodsname'=>'砚山小龙虾',
          'goodsprice'=>9.9
      ];
        break;
        // 门店提货码
        case 8:
        $alicode = 'SMS_141605570';
        $centen = [
          'username'=>'隔壁老沈',
          'code'=>mt_rand(100000,999999)
          
      ];
        break;
        // 商家发货时
        case 9:
        $alicode = 'SMS_141605569';
        $centen = [
          'username'=>'隔壁老沈',
          'consignee'=>'隔壁老沈'
      ];
        break;
        // 客户付款时
        case 10:
        $alicode = 'SMS_141580537';
        $centen = [
          'consignee'=>'隔壁老沈',
          'ordermobile'=>'15912724029'
          
      ];
        break;
        // 客户付款时
        case 11:
        $alicode = 'SMS_141595545';
        $centen = [
          'consignee'=>'隔壁老沈',
          'ordermobile'=>'15912724029'
      ];
        break;
       
      }
      // 获取阿里短信配置文件
      $config = \think\Config::get('alisms');
      $sms= new AliSms($config);
      $res= $sms->alitest($phoneNum,$alicode,$centen);
    if ($res['Message']=='OK') {
       return $this->renderSuccess('发送成功');
    }
  }

}
