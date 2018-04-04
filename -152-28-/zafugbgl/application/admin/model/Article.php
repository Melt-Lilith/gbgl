<?php
namespace app\admin\model;
use think\Model;
class Article extends Model
{
    
	protected static function init()
    {
      	Article::event('before_insert',function($article){
          if($_FILES['img']['tmp_name']){
                $file = request()->file('thumb');
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                if($info){
                    // $thumb=ROOT_PATH . 'public' . DS . 'uploads'.'/'.$info->getExtension();
                    $thumb= 'public' . DS .'uploads'.'/'.$info->getSaveName();
                    $article['img']=$thumb;
                }
            }
      });


      	Article::event('before_update',function($article){
      
      });

      	Article::event('before_delete',function($article){
          
          		$arts=Article::find($article->id);
          		$thumbpath=$_SERVER['DOCUMENT_ROOT'].$arts['img'];
                if(file_exists($thumbpath)){
                	@unlink($thumbpath);
                }
        });


    }
    
  





}
