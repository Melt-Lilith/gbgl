<?php
namespace app\ admin\ controller;
use app\admin\model\Message as MessageModel;
use app\admin\controller\Common;
class Message extends Common
{

    public function lst(){

        $message = db( "message" )->paginate(50);
        $messageall =$message->all();
        foreach ($messageall as  &$m) {
            $m["date"]=date("y-m-d ",$m["date"]);
        }
        $message2=$message->render();
        $this->assign('message',$messageall);
        $this->assign('message2',$message2);
        return view();
    }

    public function add(){
        if(request()->isPost()){
            $data=input('post.');
            $data['date'] = time();

            if ( db( 'message' )->insert( $data ) ) {
                $this->success( '添加信息成功', url( 'lst' ) );
            } else {
                $this->error( '添加信息失败！' );
            }
            return;
        }


        return view();
    }

    public function edit(){
         $message =new MessageModel();
        if(request()->isPost()){
            $data=input('post.');
            $data["date"] = time();


            db('message')->delete(input('id'));
            $save = db( 'message' )->insert( $data );
            if($save !== false){
                $this->success('修改信息成功！',url('lst'));
            }else{
                $this->error('修改信息失败！');
            }

        }
        
        $messages=$message->find(input('id'));
        
        
        $messages["date"]=date("y-m-d h:i",$messages["date"]);

        $this->assign(array(
            'messages'=>$messages,
            ));
        return view();
 
    }

    public function del(){
        $del=db('message')->delete(input('id'));
        if($del){
            $this->success('删除信息成功！',url('lst'));
        }else{
            $this->error('删除信息失败！');
        }
    }

   
}





    


