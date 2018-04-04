<?php
namespace app\admin\model;
use think\Model;
class Jianli extends Model
{
    
	protected static function init()
    {
      	Article::event('before_insert',function($jianli){
      });


      	Article::event('before_update',function($jianli){
      
      });


    }
    

}

