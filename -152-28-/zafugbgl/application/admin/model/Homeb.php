<?php
namespace app\admin\model;
use think\Model;
class Homeb extends Model
{
    
	protected static function init()
    {
      	Article::event('before_insert',function($homeb){
      });


      	Article::event('before_update',function($homeb){
      
      });


    }
    

}
