<?php
namespace app\admin\model;
use think\Model;
class Summary extends Model
{

	protected static function init()
  {
   Summary::event('before_insert',function($article){
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


   Summary::event('before_update',function($article){

   });

   Summary::event('before_delete',function($article){

    $arts=Article::find($article->id);
    $thumbpath=$_SERVER['DOCUMENT_ROOT'].$arts['img'];
    if(file_exists($thumbpath)){
     @unlink($thumbpath);
   }
 });


 }
//  //校领导有效票统计
//  public function xiaolingdaocount($id,$cateid){
    

//     $vote_lingdao = db( "data" )->alias('d')->join('gb_admin a','a.worknum = d.worknum')->join('gb_cate c','c.id = a.cateid')->where('d.cateid','<>','')->where( 'd.sumid', $id )->where('d.cateid',$cateid)->where('a.type = "校领导"')->count();
//     //dump($vote_lingdao);die;

//     return $vote_lingdao;

// }

// //中层有效票
// public function zhongcengcount($id,$cateid){
    

//     $vote_zhongceng = db( "data" )->alias('d')->join('gb_admin a','a.worknum = d.worknum')->join('gb_cate c','c.id = a.cateid')->where('d.cateid','<>','')->where( 'd.sumid', $id )->where('d.cateid',$cateid)->where('a.type = "中层干部"')->count();
//     //dump($vote_lingdao);die;

//     return $vote_zhongceng;

// }
// //服务对象有效票
// public function fuwuduixiangcount($id,$cateid){
    
//     $vote_fuwuduixiang = db( "data" )->alias('d')->join('gb_admin a','a.worknum = d.worknum')->join('gb_cate c','c.id = a.cateid')->where('d.cateid','<>','')->where( 'd.sumid', $id )->where('d.cateid',$cateid)->where('a.server = "服务对象"')->count();
//     //dump($vote_lingdao);die;

//     return $vote_fuwuduixiang;

// }
// //普通老师有效票
// public function putonglaoshicount($id,$cateid){
    
//     $vote_putonglaoshi = db( "data" )->alias('d')->join('gb_admin a','a.worknum = d.worknum')->join('gb_cate c','c.id = a.cateid')->where('d.cateid','<>','')->where( 'd.sumid', $id )->where('d.cateid',$cateid)->where('a.cateid',$cateid)->count();
//     //dump($vote_lingdao);die;

//     return $vote_putonglaoshi;

// }

// //校领导分项有效票统计 
// public function xiaolingdaofenxiangcount($id,$cateid,$value){
//     //value 为分项实际内容  实例：'d.bzgzsj = "好"'  工作实际的好的数目

//     $vote_lingdao = db( "data" )->alias('d')->join('gb_admin a','a.worknum = d.worknum')->join('gb_cate c','c.id = a.cateid')->where('d.cateid','<>','')->where( 'd.sumid', $id )->where('d.cateid',$cateid)->where('a.type = "校领导"')->where($value)->count();

//     return $vote_lingdao;

// }
// //中层分项有效票统计
// public function zhongcengfenxiangcount($id,$cateid,$value){
//     //value 为分项实际内容  实例：'d.bzgzsj = "好"'  工作实际的好的数目

//     $vote_zhongceng = db( "data" )->alias('d')->join('gb_admin a','a.worknum = d.worknum')->join('gb_cate c','c.id = a.cateid')->where('d.cateid','<>','')->where( 'd.sumid', $id )->where('d.cateid',$cateid)->where('a.type = "中层干部"')->where($value)->count();

//     return $vote_zhongceng;

// }
// //服务对象分项有效票统计
// public function fuwuduixiangfenxiangcount($id,$cateid,$value){
//     //value 为分项实际内容  实例：'d.bzgzsj = "好"'  工作实际的好的数目

//     $vote_fuwuduiixang = db( "data" )->alias('d')->join('gb_admin a','a.worknum = d.worknum')->join('gb_cate c','c.id = a.cateid')->where('d.cateid','<>','')->where( 'd.sumid', $id )->where('d.cateid',$cateid)->where('a.server = "服务对象"')->where($value)->count();

//     return $vote_fuwuduixiang;

// }
// //普通老师的分项统计
// public function putonglaoshifenxiangcount($id,$cateid,$value){
//     //value 为分项实际内容  实例：'d.bzgzsj = "好"'  工作实际的好的数目

//     $vote_putonglaoshi = db( "data" )->alias('d')->join('gb_admin a','a.worknum = d.worknum')->join('gb_cate c','c.id = a.cateid')->where('d.cateid','<>','')->where( 'd.sumid', $id )->where('d.cateid',$cateid)->where('a.cateid',$cateid)->where($value)->count();

//     return $vote_putonglaoshi;

// }

//个人有效票
public function gerenmingzhucount($id,$worknum){
    

    $vote_geren = db( "data" )->where( 'sumid', $id)->where( 'beworknum', $worknum)->count();

    return $vote_geren;

}
public function gerendecount($id,$worknum){
    

    $vote_geren = db( "data" )->where( 'sumid', $id)->where( 'beworknum', $worknum)->where('summary2 <> "不了解"')->count();

    return $vote_geren;

}
//个人分项票统计
public function gerenfenxiangcount($id,$beworknum,$value){
    //value 为分项实际内容  实例：'d.bzgzsj = "好"'  工作实际的好的数目

    $vote_geren = db( "data" )->alias('d')->join('gb_admin a','a.worknum = d.worknum')->join('gb_cate c','c.id = a.cateid')->where('d.worknum','<>','')->where( 'd.sumid', $id )->where('d.beworknum',$beworknum)->where($value)->count();


    return $vote_geren;

}

public function getgrade($hao,$jiaohao,$yiban,$cha){
    if(($hao + $jiaohao + $yiban  + $cha ) == 0){
      $grade = 0;
    }
    else{
      $grade = ($hao * 100 + $jiaohao * 80 + $yiban * 60 + $cha * 40)/($hao + $jiaohao + $yiban  + $cha );
    }
    return $grade;

} 




}
