<?php 
namespace app\admin\model\mallsite;
use think\Model;
class AuthGroup extends Model
{	
    // 开启时间戳
    protected  $autoWriteTimestamp = true; 
    /**
     * 获取角色列表并分页查询
     * @param  int $curr  当前页
     * @param  int $limit 每页显示多条
     * @return array        
     */
    public function getRoleList()
    {
       return $this->order('id', 'ASC')->paginate(5);
;
    }
     
    /**
     * 添加操作
     * @param arrat $data post过来的数据
     */
    public function add($data)
    {
       

        if ($data['id']==0) {
           
            return $this->allowField(true)->save($data); 
        }else{
            return $this->allowField(true)->save($data,['id' =>$data['id']]);
        }
        
    }
     
}