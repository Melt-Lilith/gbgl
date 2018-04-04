<?php
namespace app\ admin\ controller;
use app\ admin\ model\ Cate as CateModel;
use app\ admin\ controller\ Common;
class Ceping extends Common {
		/*
	ceping/lst1  民主测评
    ceping/lst2  德的考核考察（已弃置）
    ceping/lst3  班子测评
    ceping/lst4  民主干部互评 （中层互评）
    ceping/lst5  德的干部互评（已弃置）
    ceping/lst6  试用期干部测评（已挂起）
    ceping/lst7  自定义 
    ceping/lst8  正职测评 
	*/
    public
    function lst1() {
		//判断用户调查表状态：已测评——1;未测评——2;已过期——3;未开始——4; ceping/lst1  民主测评
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
    	}

		//END


    	$time=time();
    	$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","民主测评")->paginate( 10 );
    	$this->assign( array(
    		'artres' => $artres,
    		'time' => $time,
    		) );
    	if ( request()->isPost() ) {
    		$data = input( 'post.' );
			//dump($data);die;
    		if($data["status"]=="1"){
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","民主测评")->where("a.status","1")->paginate( 10 );
    		}
    		elseif($data["status"]=="2"){
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","民主测评")->where("a.status","2")->paginate( 10 );
    		}
    		elseif($data["status"]=="3"){
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","民主测评")->where("a.status","3")->paginate( 10 );
    		}
    		elseif($data["status"]=="4"){
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","民主测评")->where("a.status","4")->paginate( 10 );
    		}
    		else{
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","民主测评")->where("a.status","2")->paginate( 10 );
    		}
    		$time=time();
    		$this->assign( array(
    			'artres' => $artres,
    			) );

    		return view();
    	}
    	return view();
    }


    public function lst2() {
		//判断用户调查表状态：已测评——1;未测评——2;已过期——3;未开始——4;ceping/lst2  德的考核考察（已弃置）
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
    	}

		//END
    	$time=time();
    	$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","德的考核考察")->paginate( 10 );
    	$this->assign( array(
    		'artres' => $artres,
    		'time' => $time,
    		) );
    	if ( request()->isPost() ) {
    		$data = input( 'post.' );
    		if($data["status"]=="1"){
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","德的考核考察")->where("a.status","1")->paginate( 10 );
    		}
    		elseif($data["status"]=="2"){
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","德的考核考察")->where("a.status","2")->paginate( 10 );
    		}
    		elseif($data["status"]=="3"){
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","德的考核考察")->where("a.status","3")->paginate( 10 );
    		}
    		elseif($data["status"]=="4"){
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","德的考核考察")->where("a.status","4")->paginate( 10 );
    		}
    		else{
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","德的考核考察")->where("a.status","2")->paginate( 10 );
    		}
    		$time=time();
    		$this->assign( array(
    			'artres' => $artres,
    			'time' => $time,
    			) );

    		return view();
    	}
    	return view();
    }

    public function lst3() {
		//判断用户调查表状态：已测评——1;未测评——2;已过期——3;未开始——4;ceping/lst3  班子测评
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
    	}

		//END
    	$time=time();
    	$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","班子测评")->paginate( 10 );
    	$this->assign( array(
    		'artres' => $artres,
    		'time' => $time,
    		) );
    	if ( request()->isPost() ) {
    		$data = input( 'post.' );
    		if($data["status"]=="1"){
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","班子测评")->where("a.status","1")->paginate( 10 );
    		}
    		elseif($data["status"]=="2"){
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","班子测评")->where("a.status","2")->paginate( 10 );
    		}
    		elseif($data["status"]=="3"){
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","班子测评")->where("a.status","3")->paginate( 10 );
    		}
    		elseif($data["status"]=="4"){
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","班子测评")->where("a.status","4")->paginate( 10 );
    		}
    		else{
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","班子测评")->where("a.status","2")->paginate( 10 );
    		}
    		$time=time();
    		$this->assign( array(
    			'artres' => $artres,
    			'time' => $time,
    			) );

    		return view();
    	}
    	return view();
    }

    public
    function lst4() {
		//判断用户调查表状态：已测评——1;未测评——2;已过期——3;未开始——4;ceping/lst4  中层互评
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
    	}

		//END


    	$time=time();
    	$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","中层互评")->paginate( 10 );
		//dump($yonghuid);die;
    	$this->assign( array(
    		'artres' => $artres,
    		'time' => $time,
    		) );
    	if ( request()->isPost() ) {
    		$data = input( 'post.' );
			//dump($data);die;
    		if($data["status"]=="1"){
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","中层互评")->where("a.status","1")->paginate( 10 );
    		}
    		elseif($data["status"]=="2"){
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","中层互评")->where("a.status","2")->paginate( 10 );
    		}
    		elseif($data["status"]=="3"){
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","中层互评")->where("a.status","3")->paginate( 10 );
    		}
    		elseif($data["status"]=="4"){
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","中层互评")->where("a.status","4")->paginate( 10 );
    		}
    		else{
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","中层互评")->where("a.status","2")->paginate( 10 );
    		}
    		$time=time();
    		$this->assign( array(
    			'artres' => $artres,
    			) );

    		return view();
    	}
    	return view();
    }


    public function lst5() {
		//判断用户调查表状态：已测评——1;未测评——2;已过期——3;未开始——4;ceping/lst5  德的干部互评（已弃置）
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
    	}

		//END
    	$time=time();
    	$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","德的干部互评")->paginate( 10 );
    	$this->assign( array(
    		'artres' => $artres,
    		'time' => $time,
    		) );
    	if ( request()->isPost() ) {
    		$data = input( 'post.' );
    		if($data["status"]=="1"){
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","德的干部互评")->where("a.status","1")->paginate( 10 );
    		}
    		elseif($data["status"]=="2"){
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","德的干部互评")->where("a.status","2")->paginate( 10 );
    		}
    		elseif($data["status"]=="3"){
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","德的干部互评")->where("a.status","3")->paginate( 10 );
    		}
    		elseif($data["status"]=="4"){
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","德的干部互评")->where("a.status","4")->paginate( 10 );
    		}
    		else{
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","德的干部互评")->where("a.status","2")->paginate( 10 );
    		}
    		$time=time();
    		$this->assign( array(
    			'artres' => $artres,
    			'time' => $time,
    			) );

    		return view();
    	}
    	return view();
    }

    public function lst6() {
		//判断用户调查表状态：已测评——1;未测评——2;已过期——3;未开始——4;ceping/lst6  试用期干部测评（已挂起）
    	$yonghuid=session('id');
    	$yh_check=db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->select();
		//dump($yh_check);die;
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
    	}

		//END
    	$time=time();
    	$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","试用期干部测评")->paginate( 10 );
		//dump($artres);
    	$this->assign( array(
    		'artres' => $artres,
    		'time' => $time,
    		) );
    	if ( request()->isPost() ) {
    		$data = input( 'post.' );
			//dump($data);die;
    		if($data["status"]=="1"){
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","试用期干部测评")->where("a.status","1")->paginate( 10 );
    		}
    		elseif($data["status"]=="2"){
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","试用期干部测评")->where("a.status","2")->paginate( 10 );
    		}
    		elseif($data["status"]=="3"){
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","试用期干部测评")->where("a.status","3")->paginate( 10 );
    		}
    		elseif($data["status"]=="4"){
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","试用期干部测评")->where("a.status","4")->paginate( 10 );
    		}
    		else{
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","试用期干部测评")->where("a.status","2")->paginate( 10 );
    		}
    		$time=time();
    		$this->assign( array(
    			'artres' => $artres,
    			'time' => $time,
    			) );

    		return view();
    	}
    	return view();
    }
    public function lst7(){

    }
	//自定义
    public function lst8(){
		//判断用户调查表状态：已测评——1;未测评——2;已过期——3;未开始——4;//ceping/lst8  正职测评 
    	$yonghuid=session('id');
		//dump($yonghuid);die;
		//dump($yonghuid);die;
    	$yh_check=db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->select();
		//dump($yh_check);
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
    	}

		//END


    	$time=time();
    	$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","正职测评")->paginate( 10 );
		//dump($artres);die;
    	$this->assign( array(
    		'artres' => $artres,
    		'time' => $time,
    		) );
    	if ( request()->isPost() ) {
    		$data = input( 'post.' );
			//dump($data);die;
    		if($data["status"]=="1"){
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","正职测评")->where("a.status","1")->paginate( 10 );
    		}
    		elseif($data["status"]=="2"){
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","正职测评")->where("a.status","2")->paginate( 10 );
    		}
    		elseif($data["status"]=="3"){
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","正职测评")->where("a.status","3")->paginate( 10 );
    		}
    		elseif($data["status"]=="4"){
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","正职测评")->where("a.status","4")->paginate( 10 );
    		}
    		else{
    			$artres = db("check")->field( 'a.worknum,a.status,b.* ' )->alias( 'a' )->where('a.allvote',"<>",0)->join( 'gb_checktable b', 'a.sumid=b.id' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where("c.id",$yonghuid)->where("b.type","正职测评")->where("a.status","2")->paginate( 10 );
    		}
    		$time=time();
    		$this->assign( array(
    			'artres' => $artres,
    			) );

    		return view();
    	}
    	return view();
    }

    public function checklst() {
    	$id=input('id');

		$yonghuid=session('id');				//当前用户ID
		$yonghuinf=db("admin")->field('a.id,a.worknum,a.name,a.type,a.cateid')->alias( 'a' )->where("a.id",$yonghuid)->find();   //当前用户除密码外的信息
		$type= db('checktable')->field('type')->where('id',$id)->find();
		$yonghucateinf=db("cate")->where('id',$yonghuinf["cateid"])->find();//当前用户的部门信息
		// dump($yonghuinf);
		// dump($yonghucateinf);die;
		if($type["type"]=="班子测评")
		{
			$artres = db( 'checktable' )->field('a.name checkname,a.timestart,a.timeend,c.catename,b.cateid,a.type')->alias( 'a' )->join( 'gb_bechecked b', 'a.id=b.sumid' )->join( 'gb_cate c', 'c.id=b.cateid' )->where('c.id',$yonghuinf["cateid"])->where('a.id',$id)->select();
			if(!$artres){
				$this->error( '无候选部门信息！', url( 'lst3' ) );
			}
		//判断是否对此部门投过票
			foreach ($artres as $key => $value) {
				if($cepxx=db("data")->where("sumid",$id)->where("worknum",$yonghuinf["worknum"])->where("cateid",$value["cateid"])->find()){
					$artres[$key]["status"]="1";
					//数据有效性判断

					if($cepxx['bzsummary']==NULL)
					{
						$artres[$key]["status"]="2";
						db('data')->where('Id',$cepxx['Id'])->delete();
					}

								//数据有效性判断END
				}
				else{
					$artres[$key]["status"]="2";
				}
			}
		//END
			$department = db( 'cate' )->order( 'id' )->select();
			$checktable=db("checktable")->where("id",$id)->find();
			$this->assign( array(
				'type' => $type["type"],
				'artres' => $artres,
				'department' => $department,
				'id' => $id,
				'checktable' => $checktable,
				) );
			return view();
		}
		elseif($type["type"]=="民主测评" || $type["type"]=="德的考核考察")
		{
			
			if ($yonghucateinf['keywords']=="机关部门") {
				$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename,e.name checkname,e.timestart,e.timeend ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_bechecked d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where('e.id',$id)->where('a.type',"中层干部")->where('b.try','<>',"是")->where('c.keywords',"机关部门")->order( 'b.sort,a.worknum' )->select();
			}
			elseif ($yonghucateinf['keywords']=="教学部门") {
				$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename,e.name checkname,e.timestart,e.timeend ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_bechecked d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where('e.id',$id)->where('a.type',"中层干部")->where('b.try','<>',"是")->where('a.cateid',$yonghuinf["cateid"])->order( 'b.sort,a.worknum' )->select();
			}
			//dump($artres);die;
			if(!$artres){
				if($type["type"]=="民主测评" ){
					$this->error( '无候选人信息！', url( 'lst1' ) );
				}
				elseif($type["type"]=="德的考核考察"){
					$this->error( '无候选人信息！', url( 'lst2' ) );
				}
			}
		//判断是否对此人投过票
			foreach ($artres as $key => $value) {
				if($cepxx=db("data")->where("sumid",$id)->where("worknum",$yonghuinf["worknum"])->where("beworknum",$value["worknum"])->find()){
					$artres[$key]["status"]="1";
					//数据有效性判断

					if($cepxx['neng']==NULL||$cepxx['qin']==NULL||$cepxx['ji']==NULL||$cepxx['lian']==NULL||$cepxx['summary']==NULL||$cepxx['zzde']==NULL||$cepxx['zyde']==NULL||$cepxx['shde']==NULL||$cepxx['jtde']==NULL||$cepxx['summary2']==NULL)
					{
						$artres[$key]["status"]="2";
						db('data')->where('Id',$cepxx['Id'])->delete();
					}

								//数据有效性判断END
				}
				else{
					$artres[$key]["status"]="2";
				}
			}
		//END
			$department = db( 'cate' )->order( 'id' )->select();
			$checktable=db("checktable")->where("id",$id)->find();
			$this->assign( array(
				'type' => $type["type"],
				'artres' => $artres,
				'department' => $department,
				'id' => $id,
				'checktable' => $checktable,
				) );
			return view();
		}
		elseif($type["type"]=="中层互评" || $type["type"]=="德的干部互评")
		{
			if ($yonghucateinf['keywords2']=="机关部门") {
				$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename,e.name checkname,e.timestart,e.timeend ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_bechecked d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where('e.id',$id)->where('a.type',"中层干部")->where('b.try','<>',"是")->where('b.pinrenzhi','<>',"是")->where('c.keywords2',"教学部门")->order( 'b.sort,a.worknum' )->select();
			}
			elseif ($yonghucateinf['keywords2']=="教学部门") {
				$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename,e.name checkname,e.timestart,e.timeend ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_bechecked d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where('e.id',$id)->where('a.type',"中层干部")->where('b.try','<>',"是")->where('b.pinrenzhi','<>',"是")->where('c.keywords2',"机关部门")->order( 'b.sort,a.worknum' )->select();
			}
			
			if(!$artres){
				if($type["type"]=="民主干部互评" ){
					$this->error( '无候选人信息！', url( 'lst4' ) );
				}
				elseif($type["type"]=="德的干部互评"){
					$this->error( '无候选人信息！', url( 'lst5' ) );
				}
			}
		//判断是否对此人投过票
			foreach ($artres as $key => $value) {
				if($cepxx=db("data")->where("sumid",$id)->where("worknum",$yonghuinf["worknum"])->where("beworknum",$value["worknum"])->find()){
					$artres[$key]["status"]="1";
					//数据有效性判断

					if($cepxx['neng']==NULL||$cepxx['qin']==NULL||$cepxx['ji']==NULL||$cepxx['lian']==NULL||$cepxx['summary']==NULL||$cepxx['zzde']==NULL||$cepxx['zyde']==NULL||$cepxx['shde']==NULL||$cepxx['jtde']==NULL||$cepxx['summary2']==NULL)
					{
						$artres[$key]["status"]="2";
						db('data')->where('Id',$cepxx['Id'])->delete();
					}

								//数据有效性判断END
				}
				else{
					$artres[$key]["status"]="2";
				}
			}
		//END
			$department = db( 'cate' )->order( 'id' )->select();
			$checktable=db("checktable")->where("id",$id)->find();
			$this->assign( array(
				'type' => $type["type"],
				'artres' => $artres,
				'department' => $department,
				'id' => $id,
				'checktable' => $checktable,
				) );
			return view();
		}
		elseif($type["type"]=="正职测评")
		{
			$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename,e.name checkname,e.timestart,e.timeend ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_bechecked d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where('e.id',$id)->where('b.zhiji',"中层副职")->where('b.try','<>',"是")->where('a.cateid',$yonghuinf["cateid"])->order( 'b.sort,a.worknum' )->select();
			//dump($artres);die;
			if(!$artres){
				if($type["type"]=="正职测评" ){
					$this->error( '无候选人信息！', url( 'lst8' ) );
				}
			}
		//判断是否对此人投过票
			foreach ($artres as $key => $value) {
				if($cepxx=db("data")->where("sumid",$id)->where("worknum",$yonghuinf["worknum"])->where("beworknum",$value["worknum"])->find()){
					$artres[$key]["status"]="1";
					//数据有效性判断

					if($cepxx['neng']==NULL||$cepxx['qin']==NULL||$cepxx['ji']==NULL||$cepxx['lian']==NULL||$cepxx['summary']==NULL)
					{
						$artres[$key]["status"]="2";
						db('data')->where('Id',$cepxx['Id'])->delete();
					}

								//数据有效性判断END
				}
				else{
					$artres[$key]["status"]="2";
				}
			}
		//END
			$department = db( 'cate' )->order( 'id' )->select();
			$checktable=db("checktable")->where("id",$id)->find();
			$this->assign( array(
				'type' => $type["type"],
				'artres' => $artres,
				'department' => $department,
				'id' => $id,
				'checktable' => $checktable,
				) );
			return view();
		}
		/*elseif($type["type"]=="试用期干部测评" )
		{
			if($yonghucateinf["keywords"]=="机关部门"){
				$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename,e.name checkname,e.timestart,e.timeend ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_bechecked d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where('e.id',$id)->where('b.try',"是")->where('a.type',"中层干部")->where('c.keywords',$yonghucateinf["keywords"])->order( 'b.sort,a.worknum' )->select();
			}
			else{
				$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename,e.name checkname,e.timestart,e.timeend ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_bechecked d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where('e.id',$id)->where('b.try',"是")->where('a.type',"中层干部")->where('a.cateid',$yonghuinf["cateid"])->order( 'b.sort,a.worknum' )->select();
			}
			
			//dump($artres);die;
			if(!$artres){
				if($type["type"]=="民主测评" ){
					$this->error( '无候选人信息！', url( 'lst1' ) );
				}
				elseif($type["type"]=="德的考核考察"){
					$this->error( '无候选人信息！', url( 'lst2' ) );
				}
			}
		//判断是否对此人投过票
			foreach ($artres as $key => $value) {
				if($cepxx=db("data")->where("sumid",$id)->where("worknum",$yonghuinf["worknum"])->where("beworknum",$value["worknum"])->find()){
					$artres[$key]["status"]="1";
					//数据有效性判断

					if($cepxx['bzgzsj']==NULL||$cepxx['bzggcx']==NULL||$cepxx['bzgzzf']==NULL||$cepxx['bzdflz']==NULL||$cepxx['bzsummary']==NULL)
					{
						$artres[$key]["status"]="2";
						db('data')->where('Id',$cepxx['Id'])->delete();
					}

					//数据有效性判断END
				}
				else{
					$artres[$key]["status"]="2";
				}
			}
		//END
			$department = db( 'cate' )->order( 'id' )->select();
			$checktable=db("checktable")->where("id",$id)->find();
			$this->assign( array(
				'type' => $type["type"],
				'artres' => $artres,
				'department' => $department,
				'id' => $id,
				'checktable' => $checktable,
				) );
			return view();
		}*/
	}

	public function cepin1() {
		$tableid=input("id");					//调查表ID

        if(input('param.page')) {
            $page=input('param.page');
            session('cepin1page', $page);
        }
        //提交当前页面位置
		if($tableid){
			session('tableid', $tableid );
		}
		$yonghuid=session('id');				//当前用户ID
		$yonghuinf=db("admin")->field('id,worknum,name,type,cateid')->where("id",$yonghuid)->find();   //当前用户除密码外的信息
		$yonghucateinf=db("cate")->where('id',$yonghuinf["cateid"])->find();//当前用户的部门信息
		$type= db('checktable')->field('type')->where('id',$tableid)->find();
        //计算pagecount
        if($type['type']=='民主测评') {
            if ($yonghucateinf['keywords']=="机关部门") {
                $pageCount = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename,e.name checkname,e.timestart,e.timeend ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_bechecked d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where('e.id',$tableid)->where('a.type',"中层干部")->where('b.try','<>',"是")->where('c.keywords',"机关部门")->order( 'b.sort,a.worknum' )->count();
            }
            elseif ($yonghucateinf['keywords']=="教学部门") {
                $pageCount = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename,e.name checkname,e.timestart,e.timeend ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_bechecked d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where('e.id',$tableid)->where('a.type',"中层干部")->where('b.try','<>',"是")->where('a.cateid',$yonghuinf["cateid"])->order( 'b.sort,a.worknum' )->count();
            } 
            session('pageCount', $pageCount);
        }
        elseif($type['type']=='正职测评') {
            $pageCount = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename,e.name checkname,e.timestart,e.timeend ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_bechecked d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where('e.id',$tableid)->where('b.zhiji',"中层副职")->where('b.try','<>',"是")->where('a.cateid',$yonghuinf["cateid"])->order( 'b.sort,a.worknum' )->count(); 
            session('pageCount', $pageCount);
        }
        elseif($type['type']=='中层互评') {
            if ($yonghucateinf['keywords2']=="机关部门") {
                $pageCount = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename,e.name checkname,e.timestart,e.timeend ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_bechecked d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where('e.id',$tableid)->where('a.type',"中层干部")->where('b.try','<>',"是")->where('b.pinrenzhi','<>',"是")->where('c.keywords2',"教学部门")->order( 'b.sort,a.worknum' )->count();
            }
            elseif ($yonghucateinf['keywords2']=="教学部门") {
                $pageCount = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename,e.name checkname,e.timestart,e.timeend ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_bechecked d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where('e.id',$tableid)->where('a.type',"中层干部")->where('b.try','<>',"是")->where('b.pinrenzhi','<>',"是")->where('c.keywords2',"机关部门")->order( 'b.sort,a.worknum' )->count();
            }
            session('pageCount', $pageCount);
        }

        //计算pagecountend
		if ( request()->isPost() ) {
			$data = input( 'post.' );
            //dump($data);die;
			$data[ 'time' ] = time();
			$data[ 'worknum' ] = $yonghuinf["worknum"];
			$data[ 'sumid' ] = session('tableid');

			//判断是否对此人投过票
			$exist=db("data")->where('sumid',$data['sumid'])->where('worknum',$data['worknum'])->where('beworknum',$data['beworknum'])->find();
			if($exist) {
				$this->error( '已有投票' );
			}
			//判断是否对此人投过票END
			//数据有效性判断
			if(!isset($data['neng'])||!isset($data['qin'])||!isset($data['ji'])||!isset($data['lian'])||!isset($data['summary']))
			{
				$this->error( '网络波动请重新投票' );
			}
			//数据有效性判断END

			//民主分数计算
			if($data['summary']=='优秀')
			{
				$data['score1']=100;
			}
			elseif ($data['summary']=='称职') {
				$data['score1']=80;
			}
			elseif ($data['summary']=='基本称职') {
				$data['score1']=60;
			}
			elseif ($data['summary']=='不称职') {
				$data['score1']=0;
			}
			//民主分数计算END
			
			

			


			//session('tableid', null);
			//存储数据
            //dump($data);
            //dump(db( 'data' )->insert( $data ));die;
			if ( db( 'data' )->insert( $data ) ) {
                $newPage=session('cepin1page')+1;
                //dump($newPage);die;
                $worknum=session('worknum');
               
                $pageCount=session('pageCount');
                //dump($pageCount);die;
                if($newPage<=$pageCount) {
                    $url='cepin1/id/'.session('tableid').'.html?page='.$newPage;
                    header("Location:$url");
                } 
                else {
                    $this->success( '测评完成！' ,url( 'checklst',array('id'=>$data[ 'sumid' ]) ) );
                }
            } 
            else {
				$this->error( '测评失败！' );
			}
			return;
		}


		if($type["type"]=="民主测评" || $type["type"]=="德的考核考察")
		{

			if ($yonghucateinf['keywords']=="机关部门") {
				$checkobject=db("view_checktable")->field( 'a.*,b.sort ' )->alias( 'a' )->join( 'gb_article b', 'a.beworknum=b.adminid' )->where("a.id",$tableid)->where("a.worknum",$yonghuinf["worknum"])->join( 'gb_view_yonghu c', 'c.worknum=a.beworknum' )->where('c.keywords',"机关部门")->where('b.try','<>',"是")->order( 'b.sort,a.beworknum' )->paginate(1,true);						
				$checkobject2=db("view_checktable")->field( 'a.*,b.sort ' )->alias( 'a' )->join( 'gb_article b', 'a.beworknum=b.adminid' )->where("a.id",$tableid)->where("a.worknum",$yonghuinf["worknum"])->join( 'gb_view_yonghu c', 'c.worknum=a.beworknum' )->where('c.keywords',"机关部门")->where('b.try','<>',"是")->order( 'b.sort,a.beworknum' )->select();
			}
			elseif ($yonghucateinf['keywords']=="教学部门") {
				$checkobject=db("view_checktable")->field( 'a.*,b.sort ' )->alias( 'a' )->join( 'gb_article b', 'a.beworknum=b.adminid' )->where("a.id",$tableid)->where("a.worknum",$yonghuinf["worknum"])->where('a.cateid',$yonghuinf["cateid"])->order( 'b.sort,a.beworknum' )->where('b.try','<>',"是")->paginate(1,true);						
				$checkobject2=db("view_checktable")->field( 'a.*,b.sort ' )->alias( 'a' )->join( 'gb_article b', 'a.beworknum=b.adminid' )->where("a.id",$tableid)->where("a.worknum",$yonghuinf["worknum"])->where('a.cateid',$yonghuinf["cateid"])->order( 'b.sort,a.beworknum' )->where('b.try','<>',"是")->select();
			}
			//dump($checkobject2);die;

		}
		elseif($type["type"]=="中层互评" || $type["type"]=="德的干部互评")
		{
			if ($yonghucateinf['keywords2']=="机关部门") {
				$checkobject=db("view_checktable")->field( 'a.*,b.sort ' )->alias( 'a' )->join( 'gb_article b', 'a.beworknum=b.adminid' )->where("a.id",$tableid)->where("a.worknum",$yonghuinf["worknum"])->join( 'gb_view_yonghu c', 'c.worknum=a.beworknum' )->where('c.keywords2',"教学部门")->where('b.try','<>',"是")->where('b.pinrenzhi','<>',"是")->order( 'b.sort,a.beworknum' )->paginate(1,true);						
				$checkobject2=db("view_checktable")->field( 'a.*,b.sort ' )->alias( 'a' )->join( 'gb_article b', 'a.beworknum=b.adminid' )->where("a.id",$tableid)->where("a.worknum",$yonghuinf["worknum"])->join( 'gb_view_yonghu c', 'c.worknum=a.beworknum' )->where('c.keywords2',"教学部门")->where('b.try','<>',"是")->where('b.pinrenzhi','<>',"是")->order( 'b.sort,a.beworknum' )->select();
                //dump($checkobject);
			}
			elseif ($yonghucateinf['keywords2']=="教学部门") {
				$checkobject=db("view_checktable")->field( 'a.*,b.sort ' )->alias( 'a' )->join( 'gb_article b', 'a.beworknum=b.adminid' )->where("a.id",$tableid)->where("a.worknum",$yonghuinf["worknum"])->join( 'gb_view_yonghu c', 'c.worknum=a.beworknum' )->where('c.keywords2',"机关部门")->where('b.try','<>',"是")->where('b.pinrenzhi','<>',"是")->order( 'b.sort,a.beworknum' )->paginate(1,true);				
				$checkobject2=db("view_checktable")->field( 'a.*,b.sort ' )->alias( 'a' )->join( 'gb_article b', 'a.beworknum=b.adminid' )->where("a.id",$tableid)->where("a.worknum",$yonghuinf["worknum"])->join( 'gb_view_yonghu c', 'c.worknum=a.beworknum' )->where('c.keywords2',"机关部门")->where('b.try','<>',"是")->where('b.pinrenzhi','<>',"是")->order( 'b.sort,a.beworknum' )->select();
			}
		}
		elseif($type["type"]=="正职测评")
		{
			$checkobject=db("view_checktable")->field( 'a.*,b.sort ' )->alias( 'a' )->join( 'gb_article b', 'a.beworknum=b.adminid' )->where("a.id",$tableid)->where("a.worknum",$yonghuinf["worknum"])->where('a.cateid',$yonghuinf["cateid"])->where('b.try','<>',"是")->order( 'b.sort,a.beworknum' )->paginate(1,true);						
			$checkobject2=db("view_checktable")->field( 'a.*,b.sort ' )->alias( 'a' )->join( 'gb_article b', 'a.beworknum=b.adminid' )->where("a.id",$tableid)->where("a.worknum",$yonghuinf["worknum"])->where('a.cateid',$yonghuinf["cateid"])->where('b.try','<>',"是")->order( 'b.sort,a.beworknum' )->select();

		}
		//dump($checkobject2);die;
		$checknum=count($checkobject2);
		$checkobjectall=$checkobject->all();
		$checkobjectrender=$checkobject->render();
		$check=db("checktable")->alias('a')->join('gb_check b', 'a.id=b.sumid')->where("a.id",$tableid)->where("b.worknum",$yonghuinf["worknum"])->select();
		$zero=strtotime($check["0"]["timestart"]);
		$year=date("Y",$zero);
		

		//判断是否对此人投过票
        $cepxx="";
		foreach ($checkobjectall as $key => $value) {
			if(db("data")->where("sumid",$tableid)->where("worknum",$yonghuinf["worknum"])->where("beworknum",$value["beworknum"])->find()){
				$checkobjectall[$key]["status"]="1";
				$cepxx = db('data')->where('beworknum',$checkobjectall['0']['beworknum'])->where('worknum',$yonghuinf["worknum"])->find();
				//dump($cepxx);die;
			}
			else{
				$checkobjectall[$key]["status"]="2";
				$cepxx="";
			}
		}
		//dump($type);die;
		//END
        //dump($checkobjectall);die;
		
		$this->assign( array(
			'year' => $year,
			'tableid' => $tableid,
            'page' => $page,
            'pageCount' => $pageCount,
			'checkobject' => $checkobjectall,
			'checkobjectrender' => $checkobjectrender,
            'type' => $type,
			'cepxx' => $cepxx
			) );
		return view();
	}

	public function cepin2() {
		$tableid=input("id");					//调查表ID
        if(input('param.page')) {
            $page=input('param.page');
            session('cepin1page', $page);
        }
        //提交当前页面位置
		if($tableid){
			session('tableid', $tableid );
		}
		$yonghuid=session('id');				//当前用户ID
		$yonghuinf=db("admin")->where("id",$yonghuid)->find();   //当前用户除密码外的信息
		$type= db('checktable')->field('type')->where('id',$tableid)->find();
		if ( request()->isPost() ) {
			$data = input( 'post.' );
			//dump($data);die;
			$data[ 'time' ] = time();
			$data[ 'worknum' ] = $yonghuinf["worknum"];
			$data[ 'sumid' ] = session('tableid');
			session('tableid', null);


			if (  db( 'data' )->insert( $data ) ) {
				$this->success( '测评成功！' ,url( 'checklst',array('id'=>$data[ 'sumid' ]) ) );
			} else {
				$this->error( '测评失败！' );
			}
			return;
		}
		if($type["type"]=="民主测评" || $type["type"]=="德的考核考察")
		{
			$checkobject=db("view_checktable")->field( 'a.*,b.sort ' )->alias( 'a' )->join( 'gb_article b', 'a.beworknum=b.adminid' )->where("a.id",$tableid)->where("a.worknum",$yonghuinf["worknum"])->where('a.cateid',$yonghuinf["cateid"])->order( 'b.sort,a.beworknum' )->paginate(1,true);						
			$checkobject2=db("view_checktable")->field( 'a.*,b.sort ' )->alias( 'a' )->join( 'gb_article b', 'a.beworknum=b.adminid' )->where("a.id",$tableid)->where("a.worknum",$yonghuinf["worknum"])->where('a.cateid',$yonghuinf["cateid"])->order( 'b.sort,a.beworknum' )->select();
		}
		elseif($type["type"]=="中层互评" || $type["type"]=="德的干部互评")
		{
			$checkobject=db("view_checktable")->field( 'a.*,b.sort ' )->alias( 'a' )->join( 'gb_article b', 'a.beworknum=b.adminid' )->where("a.id",$tableid)->where("a.worknum",$yonghuinf["worknum"])->where('a.cateid','<>',$yonghuinf["cateid"])->order( 'b.sort,a.beworknum' )->paginate(1,true);						
			$checkobject2=db("view_checktable")->field( 'a.*,b.sort ' )->alias( 'a' )->join( 'gb_article b', 'a.beworknum=b.adminid' )->where("a.id",$tableid)->where("a.worknum",$yonghuinf["worknum"])->where('a.cateid','<>',$yonghuinf["cateid"])->order( 'b.sort,a.beworknum' )->select();
		}
		$checknum=count($checkobject2);
		$checkobjectall=$checkobject->all();
		$checkobjectrender=$checkobject->render();
		$check=db("checktable")->alias('a')->join('gb_check b', 'a.id=b.sumid')->where("a.id",$tableid)->where("b.worknum",$yonghuinf["worknum"])->select();
		$zero=strtotime($check["0"]["timestart"]);
		$year=date("Y",$zero);


		//判断是否对此人投过票
		foreach ($checkobjectall as $key => $value) {
			if(db("data")->where("sumid",$tableid)->where("worknum",$yonghuinf["worknum"])->where("beworknum",$value["beworknum"])->find()){
				$checkobjectall[$key]["status"]="1";
				$cepxx = db('data')->where('beworknum',$checkobjectall['0']['beworknum'])->where('worknum',$yonghuinf["worknum"])->find();
				//dump($cepxx);die;
			}
			else{
				$checkobjectall[$key]["status"]="2";
				$cepxx="";
			}
		}
		//END

		
		$this->assign( array(
			'year' => $year,
			'tableid' => $tableid,
			'checkobject' => $checkobjectall,
			'checkobjectrender' => $checkobjectrender,
			'cepxx' => $cepxx,
			) );
		return view();
	}
	public function cepin3() {
		$tableid=input("id");
        if(input('param.page')) {
            $page=input('param.page');
            session('cepin1page', $page);
        }
        //提交当前页面位置
		if($tableid){
			session('tableid', $tableid );
		}
		$yonghuid=session('id');
		$yonghuinf=db("admin")->where("id",$yonghuid)->find();

        $pageCount = db( 'checktable' )->field('a.name checkname,a.timestart,a.timeend,c.catename,b.cateid,a.type')->alias( 'a' )->join( 'gb_bechecked b', 'a.id=b.sumid' )->join( 'gb_cate c', 'c.id=b.cateid' )->where('c.id',$yonghuinf["cateid"])->where('a.id',$tableid)->count();
            session('pageCount', $pageCount);

		if ( request()->isPost() ) {
			$data = input( 'post.' );
			$data[ 'time' ] = time();
			$data[ 'worknum' ] = $yonghuinf["worknum"];
			$data[ 'sumid' ] = session('tableid');
			
			//判断是否对此人投过票
			$exist=db("data")->where('sumid',$data['sumid'])->where('worknum',$data['worknum'])->where('cateid',$data['cateid'])->find();
			if ($exist) {
				$this->error( '已有投票' );
			}

			//END
			//数据有效性判断
			if(!isset($data['bzsummary']))
			{
				$this->error( '网络波动请重新投票' );
			}
			//数据有效性判断END


			//班子测评分数计算

			if($data['bzsummary']=='优秀')
			{
				$data['score3']=100;
			}
			elseif ($data['bzsummary']=='良好') {
				$data['score3']=80;
			}
			elseif ($data['bzsummary']=='合格') {
				$data['score3']=60;
			}
			elseif ($data['bzsummary']=='不合格') {
				$data['score3']=0;
			}

			//班子测评分数计算END

			//数据存储
			if (  db( 'data' )->insert( $data ) ) {
                $newPage=session('cepin1page')+1;
                $worknum=session('worknum');
                $pageCount=session('pageCount');
                if($newPage<=$pageCount) {
                    $url='cepin1/id/'.session('tableid').'.html?page='.$newPage;
                    header("Location:$url");
                } 
                else {
                    $this->success( '测评完成！' ,url( 'checklst',array('id'=>$data[ 'sumid' ]) ) );
                }
            } 
            else {
                $this->error( '测评失败！' );
            }
            return;
		}
		$cateid=input("cateid");

		$checkobject=db("checktable")->alias('a')->join('gb_check b', 'a.id=b.sumid')->where("a.id",$tableid)->where("b.worknum",$yonghuinf["worknum"])->select();
		$department = db( 'cate' )->where( 'id',$cateid )->select();
		$zero=strtotime($checkobject["0"]["timestart"]);
		$year=date("Y",$zero);
		// dump($checkobject);
		// dump($department);die;

		//判断是否对此人投过票
		foreach ($checkobject as $key => $value) {
			if(db("data")->where("sumid",$tableid)->where("worknum",$yonghuinf["worknum"])->where("cateid",$department["0"]["id"])->find()){
				$checkobject[$key]["status"]="1";
				$cepxx = db('data')->where('cateid',$department["0"]["id"])->where('worknum',$yonghuinf["worknum"])->find();
				//dump($cepxx);die;
			}
			else{
				$checkobject[$key]["status"]="2";
				$cepxx="";
			}
		}
		//END
		//dump($checkobject);die;

		$this->assign( array(
			'year' => $year,
            'page' => $page,
            'pageCount' => $pageCount,
			'department' => $department,
			'checkobject' => $checkobject,
			'cepxx' => $cepxx,
			) );
		return view();
	}


	public function cepin4() {
		$tableid=input("id");					//调查表ID
		if($tableid){
			session('tableid', $tableid );
		}
		$yonghuid=session('id');				//当前用户ID
		$yonghuinf=db("admin")->where("id",$yonghuid)->find();   //当前用户除密码外的信息
		$yonghucateinf=db("cate")->where('id',$yonghuinf["cateid"])->find();//当前用户的部门信息
		$type= db('checktable')->field('type')->where('id',$tableid)->find();
		$name = db('checktable')->field('name')->where('id',$tableid)->find();
		//dump($name);die;
		if ( request()->isPost() ) {
			$data = input( 'post.' );
			//dump($data);die;
			if(!isset($data['srd']))
				$this->error( '测评失败！' );
			if(!isset($data['zssr']))
				$this->error( '测评失败！' );
			$data[ 'time' ] = time();
			$data[ 'worknum' ] = $yonghuinf["worknum"];
			$data[ 'sumid' ] = session('tableid');
			session('tableid', null);


			if (  db( 'data' )->insert( $data ) ) {
				$this->success( '测评成功！' ,url( 'checklst',array('id'=>$data[ 'sumid' ]) ) );
			} else {
				$this->error( '测评失败！' );
			}
			return;
		}
		if($yonghucateinf["keywords"]=="机关部门")
		{
			$checkobject=db("view_checktable")->field( 'a.*,b.sort ' )->alias( 'a' )->join( 'gb_article b', 'a.beworknum=b.adminid' )->where("a.id",$tableid)->where("a.worknum",$yonghuinf["worknum"])->join( 'gb_cate c', 'c.id=a.cateid' )->where('c.keywords',$yonghucateinf["keywords"])->order( 'b.sort,a.beworknum' )->paginate(1,true);						
			$checkobject2=db("view_checktable")->field( 'a.*,b.sort ' )->alias( 'a' )->join( 'gb_article b', 'a.beworknum=b.adminid' )->where("a.id",$tableid)->where("a.worknum",$yonghuinf["worknum"])->join( 'gb_cate c', 'c.id=a.cateid' )->where('c.keywords',$yonghucateinf["keywords"])->order( 'b.sort,a.beworknum' )->select();
		}
		else{
			$checkobject=db("view_checktable")->field( 'a.*,b.sort ' )->alias( 'a' )->join( 'gb_article b', 'a.beworknum=b.adminid' )->where("a.id",$tableid)->where("a.worknum",$yonghuinf["worknum"])->join( 'gb_cate c', 'c.id=a.cateid' )->where('a.cateid',$yonghuinf["cateid"])->order( 'b.sort,a.beworknum' )->paginate(1,true);						
			$checkobject2=db("view_checktable")->field( 'a.*,b.sort ' )->alias( 'a' )->join( 'gb_article b', 'a.beworknum=b.adminid' )->where("a.id",$tableid)->where("a.worknum",$yonghuinf["worknum"])->join( 'gb_cate c', 'c.id=a.cateid' )->where('a.cateid',$yonghuinf["cateid"])->order( 'b.sort,a.beworknum' )->select();
		}
		
		
		$checknum=count($checkobject2);
		$checkobjectall=$checkobject->all();
		$checkobjectrender=$checkobject->render();
		$check=db("checktable")->alias('a')->join('gb_check b', 'a.id=b.sumid')->where("a.id",$tableid)->where("b.worknum",$yonghuinf["worknum"])->select();
		$zero=strtotime($check["0"]["timestart"]);
		$year=date("Y",$zero);
		


		//判断是否对此人投过票
		foreach ($checkobjectall as $key => $value) {
			if(db("data")->where("sumid",$tableid)->where("worknum",$yonghuinf["worknum"])->where("beworknum",$value["beworknum"])->find()){
				$checkobjectall[$key]["status"]="1";
				$cepxx = db('data')->where('beworknum',$checkobjectall['0']['beworknum'])->where('worknum',$yonghuinf["worknum"])->find();
				//dump($cepxx);die;
			}
			else{
				$checkobjectall[$key]["status"]="2";
				$cepxx="";
			}
		}
		//END
		//dump($checkobjectall);die;

		if(!isset($cepxx)){
			$cepxx = "";
		}
		$this->assign( array(
			'year' => $year,
			'tableid' => $tableid,
			'checkobject' => $checkobjectall,
			'checkobjectrender' => $checkobjectrender,
			'cepxx' => $cepxx,
			'name' => $name,
			) );
		return view();
	}
}