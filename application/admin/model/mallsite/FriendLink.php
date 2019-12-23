<?php 
namespace app\admin\model\mallsite;
use think\Model;
class FriendLink extends Model
{	
        /**
         * 添加操作
         * @param arrat $data post过来的数据
         */
        public function add($data)
        {
            $linkdata=[
                'link_name'=>$data['link_name'],
                'link_url'=>$data['link_url'],
                'logo_path'=>$data['logo_path'],
                'show_order'=>$data['show_order']
            ];
        	if (empty($data['link_id'])) {
                return $this->save($linkdata);
            }else{
                return $this->where('link_id', $data['link_id'])->update($linkdata);
            }
            
        }
        /**
         * 获取所有的数据
         * @param  [type] $order [description]
         * @return [type]        [description]
         */
        public function list()
        {
               return $this->order('show_order', 'ASC')->select();
        }
        public function showOrder($data)
        {
              return $this->where('link_id', $data['id'])->update(['show_order' => $data['val']]);
        }
}