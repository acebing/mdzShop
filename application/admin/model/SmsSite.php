<?php 
namespace app\admin\model;
use think\Model;
class SmsSite extends Model
{	
    // 开启时间戳
    protected  $autoWriteTimestamp = true; 
      
    public function getTemplat()
    {
       return $this->order('id', 'ASC')->select();
    }
    /**
     * 添加操作
     * @param arrat $data post过来的数据
     */
    public function add($data)
    {
       
        if (empty($data['id'])) {
            return $this->save($data);
        }else{
            return $this->where('id', $data['id'])->update($data);
        }
        // return json_encode($postData['send_time']);
    }
}