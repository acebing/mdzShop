<?php 
namespace app\admin\model\mallsite;
use think\Model;
class Delivery extends Model
{	
    // 开启时间戳
    protected  $autoWriteTimestamp = true; 
    /**
     * 获取管理员列表并分页查询
     * @param  int $curr  当前页
     * @param  int $limit 每页显示多条
     * @return array        
     */
    public function deliveryList()
    {
       return $this->order('id', 'ASC')->select();
        
    }
     
    /**
     * 添加操作
     * @param arrat $data post过来的数据
     */
    public function add($data)
    {
        if ($data['id']==0) {
            if ($this->allowField(true)->save($data)) {
                $accesid = $this->getLastInsID();
                if ($data['fee_compute_mode']=='by_weight') {
                    $data=[
                      'd_id'=>$accesid,
                      'base_fee'=>$data['base_fee'],
                      'step_fee'=>$data['step_fee'],
                      'step_fee1'=>$data['step_fee1'],
                  ];
                    return db('delivery_w')->insert($data);
                }else{
                    $data=[
                      'd_id'=>$accesid,
                      'item_fee'=>$data['item_fee']
                  ];
                    return db('delivery_c')->insert($data);
                }
            }    
           
        }else{
            if ($this->allowField(true)->save($data,['id' =>$data['id']])) {
               return  (new AuthGroupAccess)->allowField(true)->where('uid', $data['id'])->update(['group_id'=>$data['group_id']]);
            }
           
          
        }
        
    }
}