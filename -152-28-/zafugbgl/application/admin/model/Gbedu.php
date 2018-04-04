<?php
namespace app\admin\model;
use think\Model;
class Gbedu extends Model
{
    
	protected static function init()
    {
      	Article::event('before_insert',function($gbedu){
      });


      	Article::event('before_update',function($gbedu){
      
      });


    }
    

}
