<?php
namespace app\api\model;
use app\admin\Controller\Base;
use think\Request;
use think\File;
class UploadFile extends Base
{
    /**
     * 文件上传
     * @param  string $file_name 字段名称
     * @param  string $path      保存路径
     * @return             
     */
    public function upload($file_name,$path){
     $file = request()->file($file_name);
    // 移动到框架应用根目录/public/uploads/ 目录下
    if($file){
        $info = $file->move($path);
        if($info && $info->getPathname()) {
          return $this->renderSuccess('上传成功','',"/".$info->getPathname());
        }
        return renderError('上传失败');
    }
        
    }
}