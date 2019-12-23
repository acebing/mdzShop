<?php 
namespace app\admin\Controller\mallsite;
use app\admin\Controller\Base;
use app\admin\model\mallsite\Email as EmailModel;
/**
 * 
 */
class Email extends Base
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
    $this->obj = new EmailModel;
  }
    public function list()
    {
        // 获取邮箱设置的数据
        $val = $this->obj::get(1);
        return $this->view->fetch('mallsite/email/email', [
            'val'=> $val,
        ]);
    }
	// 邮箱添加/编辑更新操作
    public function save()
    { 
        // 判断是否是POST请求
        if(!request()->isPost()) {
            $this->error('请求失败');
        }
        // 获取post请求过来的数据
        $data = input('post.');
        // 进行数据验证 暂时未做
        // $validate = validate('Category');
        // $data['cat_name'] = htmlentities($data['cat_name']);
        // if(!$validate->scene('add')->check($data)) {
        //     $this->error($validate->getError());
        // }
        // 如果email_id不为空，执行更新操作
         if(!empty($data['email_id'])) {
            return $this->update($data);
        }
        //否则执行添加操作
        $res = model("Email")::add($data);
        if($res) {
            $this->success('新增成功');
        }else {
            $this->error('新增失败');
        }


    }
    // 更新操作
     public function update($data) {
        $res =  model("Email")::save($data, ['id' => intval($data['email_id'])]);
        if($res) {
            $this->success('更新成功');
        } else {
            $this->error('更新失败');
        }
    }
    // 邮箱发送测试
    public function testEmail($to)
    {	
    	 $title="邮件发送测试";
    	 $content="邮件发送成功";
    	$res = \phpmailer\Email::send($to,$title,$content);
    	if($res) {
            return $this->result($_SERVER['HTTP_REFERER'], 1, '邮件发送成功');
        }else {
            return $this->result($_SERVER['HTTP_REFERER'], 0, '邮件发送失败');
        }
    }
}