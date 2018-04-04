<?php
namespace app\admin\controller;
use think\Db;
class Up extends Common
{
    public function index(){
            $data=input('post.');
            $data['time']=time();
            if(db('gbinf')->insert($data))
				$this->success('提交成功！');
		    else 
				$this->error('提交失败！');
            return ;
    }
}