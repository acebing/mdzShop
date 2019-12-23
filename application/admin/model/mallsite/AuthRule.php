<?php 
namespace app\admin\model\mallsite;
use think\Model;
class AuthRule extends Model
{	
    // 开启时间戳
    protected  $autoWriteTimestamp = true; 
    /**
     * 获取一级列表
     * @param  int $curr  当前页
     * @param  int $limit 每页显示多条
     * @return array        
     */
    public function getFistList($parentID=0)
    {
       return $this->order('id', 'ASC')->where('pid',$parentID)->select();
    }

    /**
     * 获取二级列表
     * @param  [type] $parentID [description]
     * @return [type]           [description]
     */
    public function getSecondList($parentID)
    {
       return $this->order('id', 'ASC')->where('pid',$parentID)->select();
    }

    /**
     * 获取父级auth_name
     * @param  [type] $parentID [description]
     * @return [type]           [description]
     */
    public function getParentName($parentID)
    {
        return$this->order('id', 'ASC')->field('title,id')->where('id',$parentID)->find();
    }

    /**
     * 添加更新操作
     * @param arrat $data post过来的数据
     */
    public function add($data)
    {
        if ($data['id']==0) {
            return $this->allowField(true)->save($data); 
        }else{
            return $this->allowField(true)->update($data,['id' =>$data['id']]);
        }
    }

    /**
     * 异步更新auth_name字段
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function updateAuthName($data)
        {
            return $this->where('id', $data['id'])->update(['title' => $data['val']]);
        }

    /**
     * 异步更新auth_url字段
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function updateAuthUrl($data)
        {
            return $this->where('id', $data['id'])->update(['name' => $data['val']]);
        }
        
    public function getNormalRecommendCategoryByParentId($id=0) {
        $data = [
            'pid' => $id,
        ];

        $order = [
            'id' => 'asc',
        ];

        $result = $this->where($data)
            ->order($order)
            ->select();
        

        return $result;

    }

    public function getNormalCategoryIdParentId($ids) {
        $data = [
            'pid' => ['in', implode(',', $ids)],
        ];

        $order = [
            'pid' => 'ASC',
        ];

        $result = $this->where($data)
            ->order($order)
            ->select();

        return $result;
    }
}