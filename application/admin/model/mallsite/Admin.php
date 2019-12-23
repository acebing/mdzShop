<?php 
namespace app\admin\model\mallsite;
use think\Model;
use app\admin\model\mallsite\AuthGroupAccess;
class Admin extends Model
{	
    // 开启时间戳
    protected  $autoWriteTimestamp = true; 
    /**
     * 获取管理员列表并分页查询
     * @param  int $curr  当前页
     * @param  int $limit 每页显示多条
     * @return array        
     */
    public function getAdminList()
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
       
        $data['password']=md5($data['password']);
        if ($data['id']==0) {
            if ($this->allowField(true)->save($data)) {
                $accesid = $this->getLastInsID();
                $data=[
              'uid'=>$accesid,
              'group_id'=>$data['group_id']
            ];
            return (new AuthGroupAccess)->save($data);
            } 
           
        }else{
            if ($this->allowField(true)->save($data,['id' =>$data['id']])) {
               return  (new AuthGroupAccess)->allowField(true)->where('uid', $data['id'])->update(['group_id'=>$data['group_id']]);
            }
           
          
        }
        
    }

     public function updateById($data, $id) {
        // allowField 过滤data数组中非数据表中的数据
        // return $data+$id;
         return $this->allowField(true)->update($data,['id' =>$id]);
    }
}