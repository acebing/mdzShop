<?php 
namespace app\admin\model\mallsite;
use think\Model;

class Email extends Model
{	
	// 开启时间戳
	protected  $autoWriteTimestamp = true;

	// 分类数据保存
	public function add($data)
	{
		// $data['is_show']=1;
		return $this ->save($data);
	}
    // 获取一级分类数据
    public function getEmailSite() {
        $data = [
            'email_id' =>1,
        ];
        return $this->where($data)
            ->select();
    }

}