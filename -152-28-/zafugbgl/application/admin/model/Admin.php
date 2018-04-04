<?php
namespace app\admin\model;
use think\Model;
class Admin extends Model
{
   
   public function addadmin($data){
    if(empty($data) || !is_array($data)){
        return false;
    }
    if($data['password']){
        $data['password']=md5($data['password']);
    }
    $adminData=array();
    $adminData['worknum']=$data['worknum'];
	$adminData['name']=$data['name'];
    $adminData['password']=$data['password'];
    $adminData['type']=$data['type'];
	$adminData['cateid']=$data['cateid'];
    if($this->save($adminData)){
        $groupAccess['uid']=$this->id;
        $groupAccess['group_id']=$data['group_id'];
        db('auth_group_access')->insert($groupAccess);
        return true;
    }else{
        return false;
    }

   }

   public function getadmin(){
    return $this::paginate(5,false,[
        'type'=>'boot',
        'var_page' => 'page',
        ]);
   }

   public function saveadmin($data,$admins){
        if(!$data['worknum']){
            return 2;//管理员用户名为空
        }
        if(!$data['password']){
            $data['password']=$admins['password'];
        }else{
            $data['password']=md5($data['password']);
        }
        db('auth_group_access')->where(array('uid'=>$data['id']))->update(['group_id'=>$data['group_id']]);
        return $this::update(['worknum'=>$data['worknum'],'name'=>$data['name'],'type'=>$data['type'],'cateid'=>$data['cateid'],'password'=>$data['password']],['id'=>$data['id']]);
    
    }

    public function saveapassword($data,$admins){
    //dump($data);die;
        if(!$data['worknum']){
            return 2;//管理员用户名为空
        }
        if(!$data['password']){
            $data['password']=$admins['password'];
        }else{
            $data['password']=md5($data['password']);
        }

        
        return $this::update(['worknum'=>$data['worknum'],'password'=>$data['password']],['id'=>$data['id']]);
    
    }

    public function deladmin($id){
        $data=db("admin")->where('id',$id)->find();

        db( "article" )->where('adminid',$data["worknum"])->delete();
        db( "jianli" )->where('adminid',$data["worknum"])->delete();
        db( "gbedu" )->where('adminid',$data["worknum"])->delete();
        db( "homeb" )->where('adminid',$data["worknum"])->delete();
        if($this::destroy($id)){
            return 1;
        }else{
            return 2;
        }
    }
 
    public function login($data){
        $admin=db('admin')->where('worknum',$data['worknum'])->find();
        if($admin){
            if($admin['password']==md5($data['password'])){
                 for ($i = 0; $i < 9; $i++) 
              { 
                $rand[]=chr(mt_rand(48, 122)); 
              } 
               $rand=implode('',$rand);
              
               db('admin')->where('worknum',$data['worknum'])->update(['random'=>$rand]);
         $url='http://ip.taobao.com/service/getIpInfo.php?ip='.$_SERVER["REMOTE_ADDR"];
         $result = file_get_contents($url);
         $result = json_decode($result,true);
         //dump($result);die;

               db('login')->insert(['random'=> $rand,'worknum'=> $admin['worknum'],'time'=>date('Y-m-d H:i:s'),'ip'=>$_SERVER["REMOTE_ADDR"],'area'=>$result['data']['country'].$result['data']['region'].$result['data']['city']]);
               session('random',$rand);
                session('id', $admin['id']);
                session('worknum', $admin['worknum']);
                session('name', $admin['name']);

           


                return 2; //登录密码正确的情况
            }else{
                return 3; //登录密码错误
            }
        }else{
            return 1; //用户不存在的情况
        }

    }
  
}
