<?php
namespace app\admin\Controller\mall;
use app\admin\Controller\Base;
class Mallarticle extends Base
{   
     // 添加文章
    public function addArticle()
    {
        
        return $this->view->fetch('mall/article/article_add_article');
    }
    // 添加文章分类
    public function addCategory()
    {
        
        return $this->view->fetch('mall/article/article_add_class');
    }
    // 文章分类列表 
    public function categoryList()
    {
        
        return $this->view->fetch('mall/article/article_class');
    }
     // 文章列表
    public function articleList()
    {
        
        return $this->view->fetch('mall/article/article_list');
    }
      // 文章自动发布
    public function autoRelease()
    {
        
        return $this->view->fetch('mall/article/article_auto_release');
    }
    
    
}