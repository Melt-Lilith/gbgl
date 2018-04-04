<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
class Common extends Controller
{

  public function _initialize(){
    if(!session('id') || !session('worknum')){
     $this->error('您尚未登录系统',url('login/index')); 
   }
   if(!db('admin')->where('random',session('random'))->find())
     { $this->error('您尚未登录系统',url('login/index')); }

   $auth=new Auth();
   $request=Request::instance();
   $con=$request->controller();
   $action=$request->action();
   $name=$con.'/'.$action;
   $notCheck=array('Index/index','Admin/lst','Admin/logout');
   $yonghuid=$request->session('id');
   $yonghuworknum=$request->session('worknum');
   $yonghuname=$request->session('name');
   $yonghutype=db("auth_group_access")->where('uid',$yonghuid)->find(); 
        //title  权限

   $yonghutype2=db("view_yonghu")->where('worknum',$yonghuworknum)->find(); 
        

        //用户信息  worknum name type catename cateid
   if($art=db('article')->where('adminid',session('worknum'))->find())
   {
    $yonghutype2['artid']=$art['id'];
    $yonghutype2['zhiji']=$art['zhiji'];
    $yonghutype2['pinrenzhi']=$art['pinrenzhi'];
  }
  else
  {
    if($yonghutype2['type']=='中层干部')
    $this->error('此账号信息出错',url('login/index'));
  }
 //dump($yonghutype2);die;
  $this->assign('yonghuid',$yonghuid);
  $this->assign('yonghuname',$yonghuname);
  $this->assign('yonghutype',$yonghutype);
  $this->assign('yonghutype2',$yonghutype2);

}


}
