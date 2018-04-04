<?php
namespace app\admin\controller;
use app\admin\controller\Common;
class Index extends Common
{
    public function index()
    { 

        //状态判断复制于ceping.php
        $yonghuid=session('id');
        $yh_check=db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->select();
        $nowtime=time();
        foreach ($yh_check as $key => $value) {
            $timestart1=$value["timestart"];
            $timestart2=strtotime($timestart1);
            $timeend1=$value["timeend"];
            $timeend2=strtotime($timeend1)+86400;
            if($nowtime<$timestart2){
                $yh_check[$key]["status"]="4";
            }
            elseif ($nowtime>$timeend2) {
                $yh_check[$key]["status"]="3";
            }
            else{
                $yh_check[$key]["status"]="2";
            }
            db( 'check' )->where("sumid",$value["id"])->where("worknum",$value["worknum"])->update(['status' => $yh_check[$key]["status"]]);
            //状态判断复制于ceping.php END
        }


        $a=db('admin')->find(session('id'));
        $ce=db('checktable')->select();
        $sta['minh']=0;
        $sta['minhall']=0;
        $sta['minc']=0;
        $sta['mincall']=0;
        $sta['dec']=0;
        $sta['decall']=0;
        $sta['deh']=0;
        $sta['dehall']=0;
        $sta['ban']=0;
        $sta['banall']=0;
        $sta['shi']=0;
        $sta['shiall']=0;
        $sta['all']=0;
        $sta['done']=0;
        foreach($ce as &$c)
        {
            $check=db('check')->where('worknum',$a['worknum'])->where('sumid',$c['id'])->find();
            if($check['status']==2)
            { 
            $n=db('data')->where('worknum',$a['worknum'])->where('sumid',$c['id'])->count();
            if($a['type']=='中层干部')
            {
            if($c['type']=="民主干部互评")
            {
                $sta['minh']=$sta['minh']+$n;
                $sta['minhall']=$sta['minhall']+$check['allvote'];
            }
             if($c['type']=="德的干部互评")
            {
                 $sta['deh']=$sta['deh']+$n;
                 $sta['dehall']=$sta['dehall']+$check['allvote'];
            }
            }
             if($c['type']=="民主测评")
            {
                 $sta['minc']=$sta['minc']+$n;
                 $sta['mincall']=$sta['mincall']+$check['allvote'];
            } 
            if($c['type']=="德的考核考察")
            {
                 $sta['dec']=$sta['dec']+$n;
                 $sta['decall']=$sta['decall']+$check['allvote'];
            }
            if($c['type']=="班子测评")
            {
                 $sta['ban']=$sta['ban']+$n;
                 $sta['banall']=$sta['banall']+$check['allvote'];
            }
            if($c['type']=="试用期干部测评")
            {
                 $sta['shi']=$sta['shi']+$n;
                 $sta['shiall']=$sta['shiall']+$check['allvote'];
            }
             $sta['done']=$sta['done']+$n;
                 $sta['all']=$sta['all']+$check['allvote'];
        }
        }
        if($sta['all']==0)
            $sta['all']=0;
        else
        $sta['all']=(int)(100*($sta['all']-$sta['done'])/($sta['all']));   
        if($sta['minhall']==0)
         $sta['minh']=100;
        else
        $sta['minh']=(int)(100*($sta['minh'])/($sta['minhall']));
        if($sta['dehall']==0)
        $sta['deh']=100;
        else
        $sta['deh']=(int)(100*($sta['deh'])/($sta['dehall']));
    if($sta['mincall']==0)
        $sta['minc']=100;
        else
        $sta['minc']=(int)(100*($sta['minc'])/($sta['mincall']));
         if($sta['decall']==0)
        $sta['dec']=100;
        else
        $sta['dec']=(int)(100*($sta['dec'])/($sta['decall']));
     if($sta['banall']==0)
        $sta['ban']=100;
        else
        $sta['ban']=(int)(100*($sta['ban'])/($sta['banall']));
    if($sta['shiall']==0)
        $sta['shi']=100;
        else
        $sta['shi']=(int)(100*($sta['shi'])/($sta['shiall']));
       //dump($sta);die;

        $num['all']=db('article')->count();
        $num['bsex']=db('article')->where('sex',"男")->count();   //性别统计
        $num['edubg']=db('article')->where("edubg like '%研究生%' ")->count();//学历统计
        $num['ptitle']=db('article')->where("ptitle in ('教授','高级工程师','副教授','高级实验师','研究员','副研究员','高级讲师','高级会计师') ")->count();//职称统计
        $num['politics']=db('article')->where("politics","中共党员")->count(); 
        $per['bsex']=(int)(100*$num['bsex']/$num['all']);
        $per['gsex']=100-$per['bsex'];
        $per['edubg']=(int)(100*$num['edubg']/$num['all']);
        $per['fedubg']=100-$per['edubg'];
        $per['ptitle']=(int)(100*$num['ptitle']/$num['all']);
        $per['fptitle']=100-$per['ptitle'];
        $per['politics']=(int)(100*$num['politics']/$num['all']);
        $per['fpolitics']=100-$per['politics'];
        $message=db('message')->order('date desc')->where('worknum',0)->limit(2)->select();
       $area =db('login')->where('random',session('random'))->find();
           $artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",session('id'))->order("b.type")->select();
           //表类型统计
           $art=array(0,0,0,0);
           foreach ($artres as $k=>$a) {
            $a['type']=="班子测评"?$art[0]++:($a['type']=="中层互评"?$art[1]++:($a['type']=="正职测评"?$art[2]++:($a['type']=="民主测评"?$art[3]++:"")));
                   if($a['status']!=2) unset($artres[$k]);
                   }  

           $artnum=0;
           for($i=0;$i<4;$i++){ $art[$i]==0?:$artnum++;}

         //   dump( $artres);die;
       $approval=db('approval')->where('status',0)->count();
       $reply=db('message')->order('date desc')->where('worknum',session('worknum'))->limit(3)->select();
       //dump($sta);die;
       /*dump($approval);
       dump($message);
       dump($per);
       dump($num);
       dump($sta);
       dump($area['area']);
       dump($reply);
       die;*/
            $this->assign(array(
                'artnum'=>$artnum,
                'artres'=>$artres,
                'app'=>$approval,
                'message'=>$message,
                'per'=>$per,
                'num'=>$num,
                'sta'=>$sta,
                'area'=>$area['area'],
                'reply'=>$reply
                )
            );
        return view();
    }
}
