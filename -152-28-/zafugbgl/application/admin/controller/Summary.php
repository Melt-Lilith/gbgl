<?php
namespace app\ admin\ controller;
use app\ admin\ model\ Admin as AdminModel;
use app\ admin\ model\ Summary as SummaryModel;
use app\ admin\ controller\ Common;
class Summary extends Common {

	public
	function gerenlst() {
		$artres = db( 'checktable' )->order( 'sumid' )->paginate( 20 );
		$department = db( 'cate' )->order( 'id' )->select();
		$this->assign( array(
			'artres' => $artres,
			'department' => $department,
		) );
		return view(); 
	}


	public

	function Summary() {
		$id = input( 'id' );
		$type = db( 'checktable' )->field( 'type' )->where( 'id', $id )->find();
		$yonghuid = session( 'id' ); //当前用户ID
		$yonghuinf = db( "admin" )->where( "id", $yonghuid )->find(); //当前用户除密码外的信息
		$yonghucateinf = db( "cate" )->where( 'id', $yonghuinf[ "cateid" ] )->find(); //当前用户的部门信息

		if ( $type[ "type" ] == "班子测评" ) {
			$artres = db( 'checktable' )->field( 'a.name checkname,a.timestart,a.timeend,b.cateid,c.catename,a.type,c.sort' )->alias( 'a' )->join( 'gb_bechecked b', 'a.id=b.sumid' )->join( 'gb_cate c', 'c.id=b.cateid' )->where( 'a.id', $id )->order( 'c.sort,c.id' )->select();
			if ( !$artres ) {
				$this->error( '无候选部门信息！', url( 'gerenlst' ) );
			}
			//读取统计信息
			foreach ( $artres as $key => $value ) {
				$data1 = db( "data" )->where( 'sumid', $id )->where( 'cateid', $artres[ $key ][ "cateid" ] )->where( 'bzsummary', '优秀' )->count();
				//总评价中优秀的数目 
				$data2 = db( "data" )->where( 'sumid', $id )->where( 'cateid', $artres[ $key ][ "cateid" ] )->where( 'bzsummary', '良好' )->count();
				//总评价中良好的数目
				$data3 = db( "data" )->where( 'sumid', $id )->where( 'cateid', $artres[ $key ][ "cateid" ] )->where( 'bzsummary', '合格' )->count();
				//总评价中合格的数目
				$data4 = db( "data" )->where( 'sumid', $id )->where( 'cateid', $artres[ $key ][ "cateid" ] )->where( 'bzsummary', '不合格' )->count();
				//总评价中不合格的数目
				$score3 = db( "data" )->field('score3')->where( 'sumid', $id )->where( 'cateid', $artres[ $key ][ "cateid" ] )->avg('score3');
				//总评价中的总分
				$artres[ $key ][ 'data1' ] = $data1;
				$artres[ $key ][ 'data2' ] = $data2;
				$artres[ $key ][ 'data3' ] = $data3;
				$artres[ $key ][ 'data4' ] = $data4;
				$artres[ $key ][ 'score3' ] = $score3;
			}
			//dump($artres);die;
			//END

			$this->assign( array(
				'artres' => $artres,
			) );
			return view();
		} elseif ( $type[ "type" ] == "民主测评" || $type[ "type" ] == "中层互评" ) {
			$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,c.catename,e.id tableid,e.name checkname,e.timestart,e.timeend ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_bechecked d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where( 'e.id', $id )->where( 'a.type', "中层干部" )->order( 'b.sort' )->select();
			if ( !$artres ) {
				$this->error( '无候选人信息！', url( 'gerenlst' ) );
			}



			//读取统计信息

			foreach ( $artres as $key => $value ) {
				$value_cate= db("cate")->where('id',$value['cateid'])->find();
				$data1 = db( "data" )->where( 'sumid', $id )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'Summary', '优秀' )->count();
				//总评价中优秀的数目 
				$data2 = db( "data" )->where( 'sumid', $id )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'Summary', '称职' )->count();
				//总评价中称职的数目
				$data3 = db( "data" )->where( 'sumid', $id )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'Summary', '基本称职' )->count();
				//总评价中基本称职的数目
				$data4 = db( "data" )->where( 'sumid', $id )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'Summary', '不称职' )->count();
				//总评价中不称职的数目
				if ( $type[ "type" ] == "民主测评" ) {
                    //dump($yonghucateinf);die;
            
                    if($value_cate['keywords'] == "机关部门"){
                    	$allvote = db( 'check' )->field( 'c.name as tablename,c.id as tableid,b.worknum as beworknum,a.worknum,d.cateid as becateid,d.name as bename,e.cateid,e.name,e.type,e.catename' )->alias( 'a' )->join( 'gb_bechecked b', 'a.sumid=b.sumid' )->where( 'b.worknum', $value[ "worknum" ] )->join( 'gb_checktable c', 'a.sumid=c.id' )->join( 'gb_view_yonghu d', 'd.worknum=b.worknum' )->join( 'gb_view_yonghu e', 'e.worknum=a.worknum and d.keywords=e.keywords' )->where( 'c.id', $id )->order( 'e.cateid' )->count();

						//dump($allvote);die;
						$votenum = db( 'data' )->where( 'sumid', $id )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->count();
						if ( $allvote == 0 ) {
							$votenum = 1;
							$allvote = 1;
						}
						$percent = $votenum / $allvote * 100;
						$percents = sprintf( "%.2f", $percent );
						$artres[ $key ][ 'allvote' ] = $allvote;
						$artres[ $key ][ 'votenum' ] = $votenum;
						$artres[ $key ]['weitoupiaonum'] = $allvote - $votenum;
						$artres[ $key ][ 'percents' ] = $percents;
                    }
                     elseif($value_cate['keywords'] == "教学部门"){
                    	$allvote = db( 'check' )->field( 'c.name as tablename,c.id as tableid,b.worknum as beworknum,a.worknum,d.cateid as becateid,d.name as bename,e.cateid,e.name,e.type,e.catename' )->alias( 'a' )->join( 'gb_bechecked b', 'a.sumid=b.sumid' )->where( 'b.worknum',$value[ "worknum" ] )->join( 'gb_checktable c', 'a.sumid=c.id' )->join( 'gb_view_yonghu d', 'd.worknum=b.worknum' )->join( 'gb_view_yonghu e', 'e.worknum=a.worknum and d.cateid=e.cateid' )->where( 'c.id', $id )->order( 'e.cateid' )->count();

						//dump($allvote);die;
						$votenum = db( 'data' )->where( 'sumid', $id )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->count();
						if ( $allvote == 0 ) {
							$votenum = 1;
							$allvote = 1;
						}
						$percent = $votenum / $allvote * 100;
						$percents = sprintf( "%.2f", $percent );
						$artres[ $key ][ 'allvote' ] = $allvote;
						$artres[ $key ][ 'votenum' ] = $votenum;
						$artres[ $key ]['weitoupiaonum'] = $allvote - $votenum;
						$artres[ $key ][ 'percents' ] = $percents;
                    }

				} 
				elseif ( $type[ "type" ] == "中层互评" ) {
					$allvote = db( 'check' )->field( 'c.name as tablename,c.id as tableid,b.worknum as beworknum,a.worknum,d.cateid as becateid,d.name as bename,e.cateid,e.name,e.type,e.catename' )->alias( 'a' )->join( 'gb_bechecked b', 'a.sumid=b.sumid' )->where( 'b.worknum',$value[ "worknum"])->join( 'gb_checktable c', 'a.sumid=c.id' )->join( 'gb_view_yonghu d', 'd.worknum=b.worknum' )->join( 'gb_view_yonghu e', 'e.worknum=a.worknum and d.keywords2<>e.keywords2' )->where( 'c.id', $id )->order( 'e.cateid' )->count();
					$votenum = db( 'data' )->where( 'sumid', $id )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->count();
				
					if ( $allvote == 0 ) {
						$votenum = 1;
						$allvote = 1;
					}
					$percent = $votenum / $allvote * 100;
					$percents = sprintf( "%.2f", $percent );
					$artres[ $key ][ 'allvote' ] = $allvote;
					$artres[ $key ][ 'votenum' ] = $votenum;
					$artres[ $key ]['weitoupiaonum'] = $allvote - $votenum;
					$artres[ $key ][ 'percents' ] = $percents;
					//dump($allvote);
				}
				if($votenum!=0)
					$artres[ $key ][ 'data1' ] = ($data1 + $data2 * 0.8+0.6*$data3)/$votenum*100;
				else
					$artres[ $key ][ 'data1' ]=0;
			}
			//dump($artres);
			//读取表单数据END





			$department = db( 'cate' )->order( 'id' )->select();
			$this->assign( array(
				'artres' => $artres,
				'department' => $department,
			) );
			return view();
		}
		elseif ( $type[ "type" ] == "正职测评") {

			$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,c.catename,e.id tableid,e.name checkname,e.timestart,e.timeend,b.zhiji ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_bechecked d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where( 'e.id', $id )->where( 'a.type', "中层干部" )->where('b.zhiji = "中层副职"')->order( 'b.sort' )->select();
			//dump($artres);die;

			if ( !$artres ) {
				$this->error( '无候选人信息！', url( 'gerenlst' ) );
			}
			//读取统计信息

			foreach ( $artres as $key => $value ) {
				$data1 = db( "data" )->where( 'sumid', $id )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'Summary', '优秀' )->count();
				//总评价中优秀的数目 
				$data2 = db( "data" )->where( 'sumid', $id )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'Summary', '称职' )->count();
				//总评价中称职的数目
				$data3 = db( "data" )->where( 'sumid', $id )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'Summary', '基本称职' )->count();
				//总评价中基本称职的数目
				$data4 = db( "data" )->where( 'sumid', $id )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'Summary', '不称职' )->count();
				//总评价中不称职的数目
				if ( $type[ "type" ] == "正职测评" ) {
					$allvote = db( 'check' )->field( 'c.name,c.id,a.sumid,b.worknum as beworknum,a.worknum,d.cateid as becateid,e.cateid' )->alias( 'a' )->join( 'gb_bechecked b', 'a.sumid=b.sumid' )->where( 'b.worknum', $value[ "worknum" ] )->join( 'gb_checktable c', 'a.sumid=c.id' )->join( 'gb_admin d', 'd.worknum=b.worknum' )->join( 'gb_admin e', 'e.worknum=a.worknum and d.cateid=e.cateid' )->where( 'c.id', $id )->count();
					
					$votenum = db( 'data' )->where( 'sumid', $id )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->count();
					
					//dump($votenum);die;
					if ( $allvote == 0 ) {
						$votenum = 1;
						$allvote = 1;
					}
					$percent = $votenum / $allvote * 100;
					$percents = sprintf( "%.2f", $percent );
					$artres[ $key ][ 'allvote' ] = $allvote;
					$artres[ $key ][ 'votenum' ] = $votenum;
					$artres[$key]['weitoupiaonum'] = $allvote - $votenum;
					$artres[ $key ][ 'percents' ] = $percents;
				}
				if($votenum!=0)
					$artres[ $key ][ 'data1' ] = ($data1 + $data2 * 0.8+0.6*$data3)/$votenum*100;
				else
					$artres[ $key ][ 'data1' ]=0;
				//dump($artres[$key]);
			}
			//dump($artres);
			//END

			$department = db( 'cate' )->order( 'id' )->select();
			$this->assign( array(
				'artres' => $artres,
				'department' => $department,
				) );
			return view();
		}
		elseif ( $type[ "type" ] == "德的考核考察" || $type[ "type" ] == "德的干部互评" ) {
			$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,c.catename,e.id tableid,e.name checkname,e.timestart,e.timeend ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_bechecked d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where( 'e.id', $id )->where( 'a.type', "中层干部" )->order( 'b.sort' )->select();
			if ( !$artres ) {
				$this->error( '无候选人信息！', url( 'gerenlst' ) );
			}
			//读取统计信息

			foreach ( $artres as $key => $value ) {
				$data1 = db( "data" )->where( 'sumid', $id )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'Summary', '好' )->count();
				//总评价中优秀的数目 
				$data2 = db( "data" )->where( 'sumid', $id )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'Summary', '较好' )->count();
				//总评价中称职的数目
				$data3 = db( "data" )->where( 'sumid', $id )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'Summary', '一般' )->count();
				//总评价中基本称职的数目
				$data4 = db( "data" )->where( 'sumid', $id )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'Summary', '不称职' )->count();
				//总评价中不称职的数目
				if ( $type[ "type" ] == "德的考核考察" ) {
					$allvote = db( 'check' )->field( 'c.name,c.id,a.sumid,b.worknum as beworknum,a.worknum,d.cateid as becateid,e.cateid' )->alias( 'a' )->join( 'gb_bechecked b', 'a.sumid=b.sumid' )->where( 'b.worknum', $value[ "worknum" ] )->join( 'gb_checktable c', 'a.sumid=c.id' )->join( 'gb_admin d', 'd.worknum=b.worknum' )->join( 'gb_admin e', 'e.worknum=a.worknum and d.cateid=e.cateid' )->where( 'c.id', $id )->count();
					$votenum = db( 'data' )->where( 'sumid', $id )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->count();
					if ( $allvote == 0 ) {
						$votenum = 1;
						$allvote = 1;
					}
					$percent = $votenum / $allvote * 100;
					$percents = sprintf( "%.2f", $percent );
					$artres[ $key ][ 'allvote' ] = $allvote;
					$artres[ $key ][ 'votenum' ] = $votenum;
					$artres[ $key ][ 'percents' ] = $percents;
				} elseif ( $type[ "type" ] == "德的干部互评" ) {
					$allvote = db( 'check' )->field( 'c.name,c.id,a.sumid,b.worknum as beworknum,a.worknum,d.cateid as becateid,e.cateid' )->alias( 'a' )->join( 'gb_bechecked b', 'a.sumid=b.sumid' )->where( 'b.worknum', $value[ "worknum" ] )->join( 'gb_checktable c', 'a.sumid=c.id' )->join( 'gb_admin d', 'd.worknum=b.worknum' )->join( 'gb_admin e', 'e.worknum=a.worknum and d.cateid<>e.cateid' )->where( 'c.id', $id )->count();
					$votenum = db( 'data' )->where( 'sumid', $id )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->count();
					if ( $allvote == 0 ) {
						$votenum = 1;
						$allvote = 1;
					}
					$percent = $votenum / $allvote * 100;
					$percents = sprintf( "%.2f", $percent );
					$artres[ $key ][ 'allvote' ] = $allvote;
					$artres[ $key ][ 'votenum' ] = $votenum;
					$artres[ $key ][ 'percents' ] = $percents;
					//dump($allvote);
				}
				if($votenum!=0)
					$artres[ $key ][ 'data1' ] = ($data1 + $data2 * 0.8+0.6*$data3)/$votenum*100;
				else
					$artres[ $key ][ 'data1' ]=0;
				//dump($artres[$key]);
			}
			//dump($artres);
			//END
			if ( !$artres ) {
				$this->error( '无候选人信息！', url( 'lst' ) );
			}
			$department = db( 'cate' )->order( 'id' )->select();
			$this->assign( array(
				'artres' => $artres,
				'department' => $department,
			) );
			return view();
		}
		elseif ( $type[ "type" ] == "试用期干部测评" ) {
			$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,c.catename,e.id tableid,e.name checkname,e.timestart,e.timeend ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_bechecked d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where( 'e.id', $id )->where( 'a.type', "中层干部" )->where( 'try', '是' )->order( 'b.sort' )->select();
			if ( !$artres ) {
				$this->error( '无候选人信息！', url( 'gerenlst' ) );
			}

			//读取统计信息
			foreach ( $artres as $key => $value ) {
				$data1 = db( "data" )->where( 'sumid', $id )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'srd', '优秀' )->count();
				//总评价中优秀的数目 
				$data2 = db( "data" )->where( 'sumid', $id )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'srd', '称职' )->count();
				//总评价中称职的数目
				$data3 = db( "data" )->where( 'sumid', $id )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'srd', '基本称职' )->count();
				//总评价中基本称职的数目
				$data4 = db( "data" )->where( 'sumid', $id )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'srd', '不称职' )->count();
				//总评价中不称职的数目
				$inf = db( 'view_yonghu' )->where( 'worknum', $value[ 'worknum' ] )->find();
				if ( $inf[ "keywords" ] == "机关部门" ) {
					$allvote = db( 'check' )->field( 'c.name as tablename,c.id as tableid,b.worknum as beworknum,a.worknum,d.cateid as becateid,d.name as bename,e.cateid,e.name' )->alias( 'a' )->join( 'gb_bechecked b', 'a.sumid=b.sumid' )->where( 'b.worknum', $value[ "worknum" ] )->join( 'gb_checktable c', 'a.sumid=c.id' )->join( 'gb_view_yonghu d', 'd.worknum=b.worknum' )->join( 'gb_view_yonghu e', 'e.worknum=a.worknum and d.keywords=e.keywords' )->where( 'c.id', $id )->count();
				} else {
					$allvote = db( 'check' )->field( 'c.name,c.id,a.sumid,b.worknum as beworknum,a.worknum,d.cateid as becateid,e.cateid' )->alias( 'a' )->join( 'gb_bechecked b', 'a.sumid=b.sumid' )->where( 'b.worknum', $value[ "worknum" ] )->join( 'gb_checktable c', 'a.sumid=c.id' )->join( 'gb_admin d', 'd.worknum=b.worknum' )->join( 'gb_admin e', 'e.worknum=a.worknum and d.cateid=e.cateid' )->where( 'c.id', $id )->count();
				}
				$votenum = db( 'data' )->where( 'sumid', $id )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->count();
				if ( $allvote == 0 ) {
					$votenum = 1;
					$allvote = 1;
				}
				$percent = $votenum / $allvote * 100;
				$percents = sprintf( "%.2f", $percent );
				$artres[ $key ][ 'allvote' ] = $allvote;
				$artres[ $key ][ 'votenum' ] = $votenum;
				$artres[ $key ][ 'percents' ] = $percents;
				if($votenum!=0)
				$artres[ $key ][ 'data1' ] = ($data1 + $data2 * 0.8+0.6*$data3)/$votenum*100;
			else
				$artres[ $key ][ 'data1' ]=0;
				//dump($artres[$key]);
			}
			//dump($artres);die;
			//END
			if ( !$artres ) {
				$this->error( '无候选人信息！', url( 'lst' ) );
			}
			$department = db( 'cate' )->order( 'id' )->select();
			$this->assign( array(
				'artres' => $artres,
				'department' => $department,
			) );


			return view();
		}
	}


	public

	function weitoupiao() {
		$tableid = input( 'id' );
		//dump($tableid);die;
		$worknum = input( 'worknum' );
		$inf = db( 'view_yonghu' )->where( 'worknum', $worknum )->find();
		$type = db( 'checktable' )->field( 'type' )->where( 'id', $tableid )->find();
        if($type['type'] == "民主测评"){
			if ( $inf[ 'keywords' ] == '机关部门' ) {
				$allvote = db( 'check' )->field( 'c.name as tablename,c.id as tableid,b.worknum as beworknum,a.worknum,d.cateid as becateid,d.name as bename,e.cateid,e.name,e.type,e.catename' )->alias( 'a' )->join( 'gb_bechecked b', 'a.sumid=b.sumid' )->where( 'b.worknum', $worknum )->join( 'gb_checktable c', 'a.sumid=c.id' )->join( 'gb_view_yonghu d', 'd.worknum=b.worknum' )->join( 'gb_view_yonghu e', 'e.worknum=a.worknum and d.keywords=e.keywords' )->where( 'c.id', $tableid )->order( 'e.cateid' )->select(); //总名单
	            //dump($allvote);die;
				$votenum = db( 'data' )->field( 'b.*' )->alias( 'a' )->join( 'gb_view_yonghu b', 'a.worknum=b.worknum' )->where( 'a.sumid', $tableid )->where( 'a.beworknum', $worknum )->select(); //已投票名单

				$weitoupiao = $allvote;
				foreach ( $weitoupiao as $i => $value1 ) {
					foreach ( $votenum as $j => $value2 ) {
						if ( $value1[ 'worknum' ] == $value2[ 'worknum' ] ) {
							unset( $weitoupiao[ $i ] );
						}
					}
				}

				//未投票名单
				$tableinf = db( 'checktable' )->where( 'id', $tableid )->find();
			}
			elseif ( $inf[ 'keywords' ] == '教学部门' ) {
					$allvote = db( 'check' )->field( 'c.name as tablename,c.id as tableid,b.worknum as beworknum,a.worknum,d.cateid as becateid,d.name as bename,e.cateid,e.name,e.type,e.catename' )->alias( 'a' )->join( 'gb_bechecked b', 'a.sumid=b.sumid' )->where( 'b.worknum', $worknum )->join( 'gb_checktable c', 'a.sumid=c.id' )->join( 'gb_view_yonghu d', 'd.worknum=b.worknum' )->join( 'gb_view_yonghu e', 'e.worknum=a.worknum and d.cateid=e.cateid' )->where( 'c.id', $tableid )->order( 'e.cateid' )->select();
					//dump($allvote);die; //总名单
					$votenum = db( 'data' )->field( 'b.*' )->alias( 'a' )->join( 'gb_view_yonghu b', 'a.worknum=b.worknum' )->where( 'a.sumid', $tableid )->where( 'a.beworknum', $worknum )->select(); //已投票名单

					$weitoupiao = $allvote;
					foreach ( $weitoupiao as $i => $value1 ) {
						foreach ( $votenum as $j => $value2 ) {
							if ( $value1[ 'worknum' ] == $value2[ 'worknum' ] ) {
								unset( $weitoupiao[ $i ] );
							}
						}
					}
					//未投票名单
					$tableinf = db( 'checktable' )->where( 'id', $tableid )->find();
				}
		}
		if($type['type'] == "中层互评"){
			if ( $inf[ 'keywords' ] == '机关部门' ) {
				$allvote = db( 'check' )->field( 'c.name as tablename,c.id as tableid,b.worknum as beworknum,a.worknum,d.cateid as becateid,d.name as bename,e.cateid,e.name,e.type,e.catename' )->alias( 'a' )->join( 'gb_bechecked b', 'a.sumid=b.sumid' )->where( 'b.worknum', $worknum )->join( 'gb_checktable c', 'a.sumid=c.id' )->join( 'gb_view_yonghu d', 'd.worknum=b.worknum' )->join( 'gb_view_yonghu e', 'e.worknum=a.worknum and d.keywords2<>e.keywords2' )->where( 'c.id', $tableid )->order( 'e.cateid' )->select(); //总名单
	            //dump($allvote);die;
				$votenum = db( 'data' )->field( 'b.*' )->alias( 'a' )->join( 'gb_view_yonghu b', 'a.worknum=b.worknum' )->where( 'a.sumid', $tableid )->where( 'a.beworknum', $worknum )->select(); //已投票名单

				$weitoupiao = $allvote;
				foreach ( $weitoupiao as $i => $value1 ) {
					foreach ( $votenum as $j => $value2 ) {
						if ( $value1[ 'worknum' ] == $value2[ 'worknum' ] ) {
							unset( $weitoupiao[ $i ] );
						}
					}
				}

				//未投票名单
				$tableinf = db( 'checktable' )->where( 'id', $tableid )->find();
			}
			elseif ( $inf[ 'keywords' ] == '教学部门' ) {
					$allvote = db( 'check' )->field( 'c.name as tablename,c.id as tableid,b.worknum as beworknum,a.worknum,d.cateid as becateid,d.name as bename,e.cateid,e.name,e.type,e.catename' )->alias( 'a' )->join( 'gb_bechecked b', 'a.sumid=b.sumid' )->where( 'b.worknum', $worknum )->join( 'gb_checktable c', 'a.sumid=c.id' )->join( 'gb_view_yonghu d', 'd.worknum=b.worknum' )->join( 'gb_view_yonghu e', 'e.worknum=a.worknum and d.keywords2<>e.keywords2' )->where( 'c.id', $tableid )->order( 'e.cateid' )->select();
					//dump($allvote);die; //总名单
					$votenum = db( 'data' )->field( 'b.*' )->alias( 'a' )->join( 'gb_view_yonghu b', 'a.worknum=b.worknum' )->where( 'a.sumid', $tableid )->where( 'a.beworknum', $worknum )->select(); //已投票名单

					$weitoupiao = $allvote;
					foreach ( $weitoupiao as $i => $value1 ) {
						foreach ( $votenum as $j => $value2 ) {
							if ( $value1[ 'worknum' ] == $value2[ 'worknum' ] ) {
								unset( $weitoupiao[ $i ] );
							}
						}
					}
					//未投票名单
					$tableinf = db( 'checktable' )->where( 'id', $tableid )->find();
				}
		}

		if($type['type'] =="正职测评"){
				$allvote = db( 'check' )->field( 'c.name,c.id,a.sumid,b.worknum as beworknum,a.worknum,d.cateid as becateid,e.cateid' )->alias( 'a' )->join( 'gb_bechecked b', 'a.sumid=b.sumid' )->where( 'b.worknum', $worknum )->join( 'gb_checktable c', 'a.sumid=c.id' )->join( 'gb_admin d', 'd.worknum=b.worknum' )->join( 'gb_admin e', 'e.worknum=a.worknum and d.cateid=e.cateid' )->where( 'c.id', $tableid )->select(); //总名单
	            //dump($allvote);die;
				$votenum = db( 'data' )->field( 'b.*' )->alias( 'a' )->join( 'gb_view_yonghu b', 'a.worknum=b.worknum' )->where( 'a.sumid', $tableid )->where( 'a.beworknum', $worknum )->select(); //已投票名单

				$weitoupiao = $allvote;
				foreach ( $weitoupiao as $i => $value1 ) {
					foreach ( $votenum as $j => $value2 ) {
						if ( $value1[ 'worknum' ] == $value2[ 'worknum' ] ) {
							unset( $weitoupiao[ $i ] );
						}
					}
				}

				//未投票名单
				$tableinf = db( 'checktable' )->where( 'id', $tableid )->find();
		}


		$department = db( 'cate' )->order( 'id' )->select();


		//dump($allvote['0']);die;
		$this->assign( 'inf', $allvote['0'] );
		$this->assign( 'adminres', $weitoupiao );
		$this->assign( 'department', $department );
		// $this->assign( 'page', $page );
		$this->assign( 'tableinf', $tableinf );
		return view();
	}
     
    public

	function yitoupiao() {
		$tableid = input( 'id' );
		$worknum = input( 'worknum' );
		$inf = db( 'view_yonghu' )->where( 'worknum', $worknum )->find();
		//dump($inf);die;
		if ( $inf[ 'keywords' ] == '机关部门' ) {
			$allvote = db( 'check' )->field( 'c.name as tablename,c.id as tableid,b.worknum as beworknum,a.worknum,d.cateid as becateid,d.name as bename,e.cateid,e.name,e.type,e.catename' )->alias( 'a' )->join( 'gb_bechecked b', 'a.sumid=b.sumid' )->where( 'b.worknum', $worknum )->join( 'gb_checktable c', 'a.sumid=c.id' )->join( 'gb_view_yonghu d', 'd.worknum=b.worknum' )->join( 'gb_view_yonghu e', 'e.worknum=a.worknum and d.keywords=e.keywords' )->where( 'c.id', $tableid )->order( 'e.cateid' )->select();  //总名单

            //dump($allvote);die;
			$votenum = db( 'data' )->field( 'b.*' )->alias( 'a' )->join( 'gb_view_yonghu b', 'a.worknum=b.worknum' )->where( 'a.sumid', $tableid )->where( 'a.beworknum', $worknum )->select(); //已投票名单

			$yitoupiao = $votenum;
			//dump($votenum);die;
			$tableinf = db( 'checktable' )->where( 'id', $tableid )->find();
		} elseif ( $inf[ 'keywords' ] == '教学部门' ) {
				$allvote = db( 'check' )->field( 'c.name as tablename,c.id as tableid,b.worknum as beworknum,a.worknum,d.cateid as becateid,d.name as bename,e.cateid,e.name,e.type,e.catename' )->alias( 'a' )->join( 'gb_bechecked b', 'a.sumid=b.sumid' )->where( 'b.worknum', $worknum )->join( 'gb_checktable c', 'a.sumid=c.id' )->join( 'gb_view_yonghu d', 'd.worknum=b.worknum' )->join( 'gb_view_yonghu e', 'e.worknum=a.worknum and d.cateid=e.cateid' )->where( 'c.id', $tableid )->order( 'e.cateid' )->select();
				//dump($allvote);die; //总名单
				$votenum = db( 'data' )->field( 'b.*' )->alias( 'a' )->join( 'gb_view_yonghu b', 'a.worknum=b.worknum' )->where( 'a.sumid', $tableid )->where( 'a.beworknum', $worknum )->select(); //已投票名单

				$yitoupiao = $votenum;
				$tableinf = db( 'checktable' )->where( 'id', $tableid )->find();
			}

		$department = db( 'cate' )->order( 'id' )->select();


		//dump($allvote['0']);die;
		$this->assign( 'inf', $allvote['0'] );
		$this->assign( 'adminres', $yitoupiao );
		$this->assign( 'department', $department );
		// $this->assign( 'page', $page );
		$this->assign( 'tableinf', $tableinf );
		return view();
	}


	public

	function huizong() {
		$tableid = input( 'id' );
		$use_worknum = session('worknum');
		//dump($use_worknum);die;
		//dump($tableid);die;
		$worknum = input( 'worknum' );
		//dump($worknum);die;
		$inf = db( 'view_yonghu' )->where( 'worknum', $worknum )->find();
		$tableinf = db( 'checktable' )->where( 'id', $tableid )->find();
		$tabletype = $tableinf['type'];
		//dump($tabletype);die;
		$department = db( 'cate' )->order( 'id' )->select();
		//dump($tableinf);die;
	    if($tabletype=='试用期干部测评')
	    {
	   	       if($worknum==0)
	   			$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,c.catename,e.id tableid,e.name checkname,e.timestart,e.timeend ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_bechecked d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where( 'e.id', $tableid )->where( 'a.type', "中层干部" )->where( 'try', '是' )->order( 'b.sort' )->select();
	   		else
	   			$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,c.catename,e.id tableid,e.name checkname,e.timestart,e.timeend ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_bechecked d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where( 'e.id', $tableid )->where( 'a.type', "中层干部" )->where('a.worknum',$worknum)->where( 'try', '是' )->order( 'b.sort' )->select();
	   	}
	   	elseif($tabletype=='民主测评')
	   	{
	   		if($worknum==0)
	   			$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,c.catename,e.id tableid,e.name checkname,e.timestart,e.timeend ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_bechecked d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where( 'e.id', $tableid )->where( 'a.type', "中层干部" )->order( 'b.sort' )->select();
	   		else
	   			$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,c.catename,e.id tableid,e.name checkname,e.timestart,e.timeend ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_bechecked d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where( 'e.id', $tableid )->where( 'a.type', "中层干部" )->where('a.worknum',$worknum)->order( 'b.sort' )->select();
	   	}
	   	elseif($tabletype=='中层互评')
	   	{
	   		if($worknum==0)
	   			$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,c.catename,e.id tableid,e.name checkname,e.timestart,e.timeend ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_bechecked d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where( 'e.id', $tableid )->where( 'a.type', "中层干部" )->order( 'b.sort' )->select();
	   		else
	   			$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,c.catename,e.id tableid,e.name checkname,e.timestart,e.timeend ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_bechecked d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where( 'e.id', $tableid )->where( 'a.type', "中层干部" )->where('a.worknum',$worknum)->order( 'b.sort' )->select();
	   	}
	   	elseif($tabletype=='正职测评')
	   	{
	   		if($worknum==0)
	   			$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,c.catename,e.id tableid,e.name checkname,e.timestart,e.timeend ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_bechecked d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where( 'e.id', $tableid )->where( 'b.zhiji', "中层副职" )->order( 'b.sort' )->select();
	   		else
	   			$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,c.catename,e.id tableid,e.name checkname,e.timestart,e.timeend ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_bechecked d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where( 'e.id', $tableid )->where( 'b.zhiji', "中层副职" )->where('a.worknum',$worknum)->order( 'b.sort' )->select();
	   	}
	   	else
	   	{
	   		if($worknum==0)
	   			$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,c.catename,e.id tableid,e.name checkname,e.timestart,e.timeend ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_bechecked d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where( 'e.id', $tableid )->where( 'a.type', "中层干部" )->order( 'b.sort' )->select();
	   		else
	   			$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,c.catename,e.id tableid,e.name checkname,e.timestart,e.timeend ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_bechecked d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where( 'e.id', $tableid )->where( 'a.type', "中层干部" )->where('a.worknum',$worknum)->order( 'b.sort' )->select();
	   	}



		if ( !$artres ) {
			$this->error( '无候选人信息！', url( 'gerenlst' ) );
		}

	// 	//读取统计信息
	// 	if($tableinf=='试用期干部测评'){
	// 	//dump($artres);die;
	// 	foreach ( $artres as $key => &$value ) {
	// 		$value['data1'] = db( "data" )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'srd', '优秀' )->count();
	// 		//总评价中优秀的数目 
	// 		$value['data2'] = db( "data" )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'srd', '称职' )->count();
	// 		//总评价中称职的数目
	// 		$value['data3'] = db( "data" )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'srd', '基本称职' )->count();
	// 		//总评价中基本称职的数目
	// 		$value['data4'] = db( "data" )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'srd', '不称职' )->count();
	// 		//总评价中不称职的数目
	// 		$value['data5'] = db( "data" )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'zssr', '同意' )->count();
	// 		//总评价中同意的数目
	// 		$value['data6'] = db( "data" )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'zssr', '不同意' )->count();
	// 		//总评价中不同意的数目
	// 		$value['data7'] = db( "data" )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'zssr',null)->count();
	// 		//总评价中弃权的数目
	// 		$inf = db( 'view_yonghu' )->where( 'worknum', $value[ 'worknum' ] )->find();
	// 		if ( $inf[ "keywords" ] == "机关部门" ) {
	// 			$allvote = db( 'check' )->field( 'c.name as tablename,c.id as tableid,b.worknum as beworknum,a.worknum,d.cateid as becateid,d.name as bename,e.cateid,e.name' )->alias( 'a' )->join( 'gb_bechecked b', 'a.sumid=b.sumid' )->where( 'b.worknum', $value[ "worknum" ] )->join( 'gb_checktable c', 'a.sumid=c.id' )->join( 'gb_view_yonghu d', 'd.worknum=b.worknum' )->join( 'gb_view_yonghu e', 'e.worknum=a.worknum and d.keywords=e.keywords' )->where( 'c.id', $tableid )->count();
	// 		} else {
	// 			$allvote = db( 'check' )->field( 'c.name,c.id,a.sumid,b.worknum as beworknum,a.worknum,d.cateid as becateid,e.cateid' )->alias( 'a' )->join( 'gb_bechecked b', 'a.sumid=b.sumid' )->where( 'b.worknum', $value[ "worknum" ] )->join( 'gb_checktable c', 'a.sumid=c.id' )->join( 'gb_admin d', 'd.worknum=b.worknum' )->join( 'gb_admin e', 'e.worknum=a.worknum and d.cateid=e.cateid' )->where( 'c.id', $tableid )->count();
	// 		}
	// 		$votenum = db( 'data' )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->count();
	// 		if ( $allvote == 0 ) {
	// 			$votenum = 1;
	// 			$allvote = 1;
	// 		}
	// 		$percent = $votenum / $allvote * 100;
	// 		$percents = sprintf( "%.2f", $percent );
	// 		$artres[ $key ][ 'allvote' ] = $allvote;
	// 		$artres[ $key ][ 'votenum' ] = $votenum;
	// 		if($value['votenum']!=0)
	// 		{
				
	// 			$value['per']=100*($value['data1']+$value['data2'])/$value['votenum']; 
	// 			$value['total']=($value['data1']+0.8*$value['data2']+0.6*$value['data3'])/$value['votenum']*100;
	// 			$value['dp1']=$value['data1']/$value['votenum']*100;
	// 		$value['dp2']=$value['data2']/$value['votenum']*100;
	// 		$value['dp3']=$value['data3']/$value['votenum']*100;
	// 		$value['dp4']=$value['data4']/$value['votenum']*100;
	// 		$value['dp5']=$value['data5']/$value['votenum']*100;
	// 		$value['dp6']=$value['data6']/$value['votenum']*100;
	// 		$value['dp7']=$value['data7']/$value['votenum']*100;
	// 		}
	// 	else
	// 	{
	// 		$value['per']=0;
	// 		$value['total']=0;
	// 		$value['dp1']=0;
	// 		$value['dp2']=0;
	// 		$value['dp3']=0;
	// 		$value['dp4']=0;
	// 		$value['dp5']=0;
	// 		$value['dp6']=0;
	// 		$value['dp7']=0;
			
	// 	}
		  
	// 		//dump($artres[$key]);
	// 	}
	// }
//dump($tableinf);die;
	if($tabletype=='民主测评'||$tabletype=='正职测评'||$tabletype=='中层互评'){
        $summ=new SummaryModel;
		foreach ( $artres as $key => $value ) {
			//数据统计
		 		$artres[$key]['mingzhuvotenum'] =$summ->gerenmingzhucount($tableid,$value['worknum']);
		 		$artres[$key]['devotenum'] = $summ->gerendecount($tableid,$value['worknum']);
                //单项评分
		 		//neng 好 较好 一般 差 数据统计
		 		$artres[$key]['neng']['hao'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.neng = "好"');
		 		$artres[$key]['neng']['jiaohao'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.neng = "较好"');
		 		$artres[$key]['neng']['yiban'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.neng = "一般"');
		 		$artres[$key]['neng']['cha'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.neng = "差"');
		 		//neng 好 较好 一般 差 数据统计END
               
		 		//qin 好 较好 一般 差 数据统计
		 		$artres[$key]['qin']['hao'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.qin = "好"');
		 		$artres[$key]['qin']['jiaohao'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.qin = "较好"');
		 		$artres[$key]['qin']['yiban'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.qin = "一般"');
		 		$artres[$key]['qin']['cha'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.qin = "差"');
		 		//qin 好 较好 一般 差 数据统计END
		 		// $artres[$key]['qin']['pingfen'] =$summ->getgrade($artres[$key]['qin']['hao'],$artres[$key]['qin']['jiaohao'],$artres[$key]['qin']['yiban'],$artres[$key]['qin']['cha']);
                //单项评分
		 		//ji 好 较好 一般 差 数据统计
		 		$artres[$key]['ji']['hao'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.ji = "好"');
		 		$artres[$key]['ji']['jiaohao'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.ji = "较好"');
		 		$artres[$key]['ji']['yiban'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.ji = "一般"');
		 		$artres[$key]['ji']['cha'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.ji = "差"');
		 		//ji 好 较好 一般 差 数据统计END
		 		// $artres[$key]['ji']['pingfen'] =$summ->getgrade($artres[$key]['ji']['hao'],$artres[$key]['ji']['jiaohao'],$artres[$key]['ji']['yiban'],$artres[$key]['ji']['cha']);
		 		//单项评分
		 		//lian 好 较好 一般 差 数据统计
		 		$artres[$key]['lian']['hao'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.lian = "好"');
		 		$artres[$key]['lian']['jiaohao'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.lian = "较好"');
		 		$artres[$key]['lian']['yiban'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.lian = "一般"');
		 		$artres[$key]['lian']['cha'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.lian = "差"');
		 		//lian 好 较好 一般 差 数据统计 end
		 		// $artres[$key]['lian']['pingfen'] =$summ->getgrade($artres[$key]['lian']['hao'],$artres[$key]['lian']['jiaohao'],$artres[$key]['lian']['yiban'],$artres[$key]['lian']['cha']);
                //单项评分
		 		//总体评价 优秀 良好 合格 不合格 数据统计
		 		$artres[$key]['summary']['youxiu'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.summary = "优秀"');
		 		$artres[$key]['summary']['chenzhi'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.summary = "称职"');
		 		$artres[$key]['summary']['jibenchenzhi'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.summary = "基本称职"');
		 		$artres[$key]['summary']['buchenzhi'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.summary = "不称职"');
		 		//总体评价 优秀 良好 合格 不合格 数据统计ENd

                //zzde 好 较好 一般 差 数据统计
		 		$artres[$key]['zzde']['hao'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.zzde = "好"');
		 		$artres[$key]['zzde']['jiaohao'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.zzde = "较好"');
		 		$artres[$key]['zzde']['yiban'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.zzde = "一般"');
		 		$artres[$key]['zzde']['cha'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.zzde = "差"');
		 		$artres[$key]['zzde']['buliaojie'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.zzde = "不了解"');
		 		//zzde 好 较好 一般 差 数据统计END
               
		 		//shde 好 较好 一般 差 数据统计
		 		$artres[$key]['shde']['hao'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.shde = "好"');
		 		$artres[$key]['shde']['jiaohao'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.shde = "较好"');
		 		$artres[$key]['shde']['yiban'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.shde = "一般"');
		 		$artres[$key]['shde']['cha'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.shde = "差"');
		 		$artres[$key]['shde']['buliaojie'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.shde = "不了解"');
		 		//shde 好 较好 一般 差 数据统计END
		 		// $artres[$key]['qin']['pingfen'] =$summ->getgrade($artres[$key]['qin']['hao'],$artres[$key]['qin']['jiaohao'],$artres[$key]['qin']['yiban'],$artres[$key]['qin']['cha']);
                //单项评分

		 		//zyde 好 较好 一般 差 数据统计
		 		$artres[$key]['zyde']['hao'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.zyde = "好"');
		 		$artres[$key]['zyde']['jiaohao'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.zyde = "较好"');
		 		$artres[$key]['zyde']['yiban'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.zyde = "一般"');
		 		$artres[$key]['zyde']['cha'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.zyde = "差"');
		 		$artres[$key]['zyde']['buliaojie'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.zyde = "不了解"');
		 		//zyde 好 较好 一般 差 数据统计END
		 		// $artres[$key]['ji']['pingfen'] =$summ->getgrade($artres[$key]['ji']['hao'],$artres[$key]['ji']['jiaohao'],$artres[$key]['ji']['yiban'],$artres[$key]['ji']['cha']);
		 		//单项评分
		 		//jtde 好 较好 一般 差 数据统计
		 		$artres[$key]['jtde']['hao'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.jtde = "好"');
		 		$artres[$key]['jtde']['jiaohao'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.jtde = "较好"');
		 		$artres[$key]['jtde']['yiban'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.jtde = "一般"');
		 		$artres[$key]['jtde']['cha'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.jtde = "差"');
		 		$artres[$key]['jtde']['buliaojie'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.jtde = "不了解"');
		 		//jtde 好 较好 一般 差 数据统计 end
		 		// $artres[$key]['lian']['pingfen'] =$summ->getgrade($artres[$key]['lian']['hao'],$artres[$key]['lian']['jiaohao'],$artres[$key]['lian']['yiban'],$artres[$key]['lian']['cha']);
                //单项评分
		 		//总体评价2 优秀 良好 合格 不合格 数据统计
		 		$artres[$key]['summary2']['hao'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.summary2 = "好"');
		 		$artres[$key]['summary2']['jiaohao'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.summary2 = "较好"');
		 		$artres[$key]['summary2']['yiban'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.summary2 = "一般"');
		 		$artres[$key]['summary2']['cha'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.summary2 = "差"');
		 		$artres[$key]['summary2']['buliaojie'] =$summ->gerenfenxiangcount($tableid,$value['worknum'],'d.summary2 = "不了解"');
		 		//总体评价2 优秀 良好 合格 不合格 数据统计ENd

		 		// $artres[$key]['summary']['pingfen'] =$summ->getgrade($artres[$key]['summary']['youxiu'],$artres[$key]['summary']['chenzhi'],$artres[$key]['summary']['jibenchenzhi'],$artres[$key]['summary']['buchenzhi']);

                //单项评分
				// $data_all_geren = db( "data" )->alias('d')->join('gb_admin a','a.worknum = d.worknum')->join('gb_cate c','c.id = a.cateid')->where( 'd.sumid', $tableid)->where('d.beworknum',$value_2['worknum'])->select();
				
				// $k1=0.1;
				// $k2=0.1;
				// $k3=0.1;
				// $k4=0.1;
				// $k5=0.1;
				// $k6=0.5;
				// $artres[$key3]['pingfen'] = $artres[$key3]['de']['pingfen']*$k1 + $artres[$key3]['neng']['pingfen']*$k2+ $artres[$key3]['qin']['pingfen']*$k3 +$artres[$key3]['ji']['pingfen']*$k4+$artres[$key3]['lian']['pingfen']*$k5+$artres[$key3]['summary']['pingfen']*$k6;
				// $artres[$key3]['pingfen'] = round($artres[$key3]['pingfen'],2);
				// $artres[$key3]['de']['pingfen']=round( $artres[$key3]['de']['pingfen'],2);
 			// 	$artres[$key3]['neng']['pingfen']=round( $artres[$key3]['neng']['pingfen'],2);
				// $artres[$key3]['qin']['pingfen']=round( $artres[$key3]['qin']['pingfen'],2);
				// $artres[$key3]['ji']['pingfen']=round( $artres[$key3]['ji']['pingfen'],2);
				// $artres[$key3]['lian']['pingfen']=round( $artres[$key3]['lian']['pingfen'],2);
				// $artres[$key3]['summary']['pingfen']=round( $artres[$key3]['summary']['pingfen'],2);
		  
			//dump($artres[$key]);
		}
	}

	else if($tabletype=='中层互评'){
		//dump($artres);die;
		foreach ( $artres as $key => $value ) {
			$value['data1'] = db( "data" )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'srd', '优秀' )->count();
			//总评价中优秀的数目 
			$value['data2'] = db( "data" )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'srd', '称职' )->count();
			//总评价中称职的数目
			$value['data3'] = db( "data" )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'srd', '基本称职' )->count();
			//总评价中基本称职的数目
			$value['data4'] = db( "data" )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'srd', '不称职' )->count();
			//总评价中不称职的数目
			$value['data5'] = db( "data" )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'zssr', '同意' )->count();
			//总评价中同意的数目
			$value['data6'] = db( "data" )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'zssr', '不同意' )->count();
			//总评价中不同意的数目
			$value['data7'] = db( "data" )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'zssr',null)->count();
			//总评价中弃权的数目
			$inf = db( 'view_yonghu' )->where( 'worknum', $value[ 'worknum' ] )->find();
			if ( $inf[ "keywords" ] == "机关部门" ) {
				$allvote = db( 'check' )->field( 'c.name as tablename,c.id as tableid,b.worknum as beworknum,a.worknum,d.cateid as becateid,d.name as bename,e.cateid,e.name' )->alias( 'a' )->join( 'gb_bechecked b', 'a.sumid=b.sumid' )->where( 'b.worknum', $value[ "worknum" ] )->join( 'gb_checktable c', 'a.sumid=c.id' )->join( 'gb_view_yonghu d', 'd.worknum=b.worknum' )->join( 'gb_view_yonghu e', 'e.worknum=a.worknum and d.keywords=e.keywords' )->where( 'c.id', $tableid )->count();
			} else {
				$allvote = db( 'check' )->field( 'c.name,c.id,a.sumid,b.worknum as beworknum,a.worknum,d.cateid as becateid,e.cateid' )->alias( 'a' )->join( 'gb_bechecked b', 'a.sumid=b.sumid' )->where( 'b.worknum', $value[ "worknum" ] )->join( 'gb_checktable c', 'a.sumid=c.id' )->join( 'gb_admin d', 'd.worknum=b.worknum' )->join( 'gb_admin e', 'e.worknum=a.worknum and d.cateid=e.cateid' )->where( 'c.id', $tableid )->count();
			}
			$votenum = db( 'data' )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->count();
			if ( $allvote == 0 ) {
				$votenum = 1;
				$allvote = 1;
			}
			$percent = $votenum / $allvote * 100;
			$percents = sprintf( "%.2f", $percent );
			$artres[ $key ][ 'allvote' ] = $allvote;
			$artres[ $key ][ 'votenum' ] = $votenum;
			if($value['votenum']!=0)
			{
				
				$value['per']=100*($value['data1']+$value['data2'])/$value['votenum']; 
				$value['total']=($value['data1']+0.8*$value['data2']+0.6*$value['data3'])/$value['votenum']*100;
				$value['dp1']=$value['data1']/$value['votenum']*100;
			$value['dp2']=$value['data2']/$value['votenum']*100;
			$value['dp3']=$value['data3']/$value['votenum']*100;
			$value['dp4']=$value['data4']/$value['votenum']*100;
			$value['dp5']=$value['data5']/$value['votenum']*100;
			$value['dp6']=$value['data6']/$value['votenum']*100;
			$value['dp7']=$value['data7']/$value['votenum']*100;
			}
		else
		{
			$value['per']=0;
			$value['total']=0;
			$value['dp1']=0;
			$value['dp2']=0;
			$value['dp3']=0;
			$value['dp4']=0;
			$value['dp5']=0;
			$value['dp6']=0;
			$value['dp7']=0;
			
		}
		  
			//dump($artres[$key]);
		}
	}
	else if($tabletype=='正职测评'){
		//dump($artres);die;
		foreach ( $artres as $key => $value ) {
			$value['data1'] = db( "data" )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'srd', '优秀' )->count();
			//总评价中优秀的数目 
			$value['data2'] = db( "data" )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'srd', '称职' )->count();
			//总评价中称职的数目
			$value['data3'] = db( "data" )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'srd', '基本称职' )->count();
			//总评价中基本称职的数目
			$value['data4'] = db( "data" )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'srd', '不称职' )->count();
			//总评价中不称职的数目
			$value['data5'] = db( "data" )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'zssr', '同意' )->count();
			//总评价中同意的数目
			$value['data6'] = db( "data" )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'zssr', '不同意' )->count();
			//总评价中不同意的数目
			$value['data7'] = db( "data" )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'zssr',null)->count();
			//总评价中弃权的数目
			$inf = db( 'view_yonghu' )->where( 'worknum', $value[ 'worknum' ] )->find();
			if ( $inf[ "keywords" ] == "机关部门" ) {
				$allvote = db( 'check' )->field( 'c.name as tablename,c.id as tableid,b.worknum as beworknum,a.worknum,d.cateid as becateid,d.name as bename,e.cateid,e.name' )->alias( 'a' )->join( 'gb_bechecked b', 'a.sumid=b.sumid' )->where( 'b.worknum', $value[ "worknum" ] )->join( 'gb_checktable c', 'a.sumid=c.id' )->join( 'gb_view_yonghu d', 'd.worknum=b.worknum' )->join( 'gb_view_yonghu e', 'e.worknum=a.worknum and d.keywords=e.keywords' )->where( 'c.id', $tableid )->count();
			} else {
				$allvote = db( 'check' )->field( 'c.name,c.id,a.sumid,b.worknum as beworknum,a.worknum,d.cateid as becateid,e.cateid' )->alias( 'a' )->join( 'gb_bechecked b', 'a.sumid=b.sumid' )->where( 'b.worknum', $value[ "worknum" ] )->join( 'gb_checktable c', 'a.sumid=c.id' )->join( 'gb_admin d', 'd.worknum=b.worknum' )->join( 'gb_admin e', 'e.worknum=a.worknum and d.cateid=e.cateid' )->where( 'c.id', $tableid )->count();
			}
			$votenum = db( 'data' )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->count();
			if ( $allvote == 0 ) {
				$votenum = 1;
				$allvote = 1;
			}
			$percent = $votenum / $allvote * 100;
			$percents = sprintf( "%.2f", $percent );
			$artres[ $key ][ 'allvote' ] = $allvote;
			$artres[ $key ][ 'votenum' ] = $votenum;
			if($value['votenum']!=0)
			{
				
				$value['per']=100*($value['data1']+$value['data2'])/$value['votenum']; 
				$value['total']=($value['data1']+0.8*$value['data2']+0.6*$value['data3'])/$value['votenum']*100;
				$value['dp1']=$value['data1']/$value['votenum']*100;
			$value['dp2']=$value['data2']/$value['votenum']*100;
			$value['dp3']=$value['data3']/$value['votenum']*100;
			$value['dp4']=$value['data4']/$value['votenum']*100;
			$value['dp5']=$value['data5']/$value['votenum']*100;
			$value['dp6']=$value['data6']/$value['votenum']*100;
			$value['dp7']=$value['data7']/$value['votenum']*100;
			}
		else
		{
			$value['per']=0;
			$value['total']=0;
			$value['dp1']=0;
			$value['dp2']=0;
			$value['dp3']=0;
			$value['dp4']=0;
			$value['dp5']=0;
			$value['dp6']=0;
			$value['dp7']=0;
			
		}
		  
			//dump($artres[$key]);
		}
	}
	else{
		echo "string";die;
		$sum = array();
		$sum['hao'] = 0;
		$sum['jiaohao'] = 0;
		$sum['yiban'] = 0;
		$sum['cha'] = 0;
		//dump($artres);
		foreach ( $artres as $key => &$value ) {
			$data_geren = db("data")->where('sumid', $tableid)->where( 'beworknum', $artres[ $key ][ "worknum"])->where('worknum',$use_worknum)->find();
			//dump($data_geren);die;
			//if()

			$value['data1'] = db( "data" )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'neng', '好' )->count();
			//总评价中优秀的数目 
			$value['data2'] = db( "data" )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'neng', '较好' )->count();
			//总评价中称职的数目
			$value['data3'] = db( "data" )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'neng', '一般' )->count();
			//总评价中基本称职的数目
			$value['data4'] = db( "data" )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'neng', '差' )->count();
			//总评价中不称职的数目
			$value['data5'] = db( "data" )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'zssr', '同意' )->count();
			//总评价中同意的数目
			$value['data6'] = db( "data" )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'zssr', '不同意' )->count();
			//总评价中不同意的数目
			$value['data7'] = db( "data" )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->where( 'zssr',null)->count();
			//总评价中弃权的数目
			

			$inf = db( 'view_yonghu' )->where( 'worknum', $value[ 'worknum' ] )->find();
			if ( $inf[ "keywords" ] == "机关部门" ) {
				$allvote = db( 'check' )->field( 'c.name as tablename,c.id as tableid,b.worknum as beworknum,a.worknum,d.cateid as becateid,d.name as bename,e.cateid,e.name' )->alias( 'a' )->join( 'gb_bechecked b', 'a.sumid=b.sumid' )->where( 'b.worknum', $value[ "worknum" ] )->join( 'gb_checktable c', 'a.sumid=c.id' )->join( 'gb_view_yonghu d', 'd.worknum=b.worknum' )->join( 'gb_view_yonghu e', 'e.worknum=a.worknum and d.keywords=e.keywords' )->where( 'c.id', $tableid )->count();
			} else {
				$allvote = db( 'check' )->field( 'c.name,c.id,a.sumid,b.worknum as beworknum,a.worknum,d.cateid as becateid,e.cateid' )->alias( 'a' )->join( 'gb_bechecked b', 'a.sumid=b.sumid' )->where( 'b.worknum', $value[ "worknum" ] )->join( 'gb_checktable c', 'a.sumid=c.id' )->join( 'gb_admin d', 'd.worknum=b.worknum' )->join( 'gb_admin e', 'e.worknum=a.worknum and d.cateid=e.cateid' )->where( 'c.id', $tableid )->count();
			}
			$votenum = db( 'data' )->where( 'sumid', $tableid )->where( 'beworknum', $artres[ $key ][ "worknum" ] )->count();
			if ( $allvote == 0 ) {
				$votenum = 1;
				$allvote = 1;
			}
			$percent = $votenum / $allvote * 100;
			$percents = sprintf( "%.2f", $percent );
			$artres[ $key ][ 'allvote' ] = $allvote;
			$artres[ $key ][ 'votenum' ] = $votenum;
			if($value['votenum']!=0)
			{
				
				$value['per']=100*($value['data1']+$value['data2'])/$value['votenum']; 
				$value['total']=($value['data1']+0.8*$value['data2']+0.6*$value['data3'])/$value['votenum']*100;
				$value['dp1']=$value['data1']/$value['votenum']*100;
			$value['dp2']=$value['data2']/$value['votenum']*100;
			$value['dp3']=$value['data3']/$value['votenum']*100;
			$value['dp4']=$value['data4']/$value['votenum']*100;
			$value['dp5']=$value['data5']/$value['votenum']*100;
			$value['dp6']=$value['data6']/$value['votenum']*100;
			$value['dp7']=$value['data7']/$value['votenum']*100;
			}
		else
		{    
			$value['votenum']=0;
			$value['per']=0;
			$value['total']=0;
			$value['dp1']=0;
			$value['dp2']=0;
			$value['dp3']=0;
			$value['dp4']=0;
			$value['dp5']=0;
			$value['dp6']=0;
			$value['dp7']=0;
			
		}
		  
			//dump($artres[$key]);
		}
	}
		//dump($artres);
		//END
		if ( !$artres ) {
			$this->error( '无候选人信息！', url( 'lst' ) );
		}
		
		$this->assign( array(
			'artres' => $artres,
			
		) );
		$this->assign( 'tableinf', $tableinf );
		return view();
	}

	public
	function huizonggeren() {
		$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where( 'a.type', "中层干部" )->order( 'b.sort' )->paginate( 10 );
		$department = db( 'cate' )->order( 'id' )->select();
		$this->assign( array(
			'artres' => $artres,
			'department' => $department,
		) );
		return view();
	}



	public
	function export() {
		$exceldata = db( 'checktable' )->field( 'a.name checkname,a.timestart,a.timeend,b.cateid,c.catename,a.type,c.sort' )->alias( 'a' )->join( 'gb_bechecked b', 'a.id=b.sumid' )->join( 'gb_cate c', 'c.id=b.cateid' )->where( 'a.type' ,'班子测评' )->order( 'c.sort,c.id' )->select();
			
		$id = db( 'checktable' )->value('id');
			foreach ( $exceldata as $key => $value ) {
				$data1 = db( "data" )->where( 'sumid', $id )->where( 'cateid', $exceldata[ $key ][ "cateid" ] )->where( 'bzsummary', '优秀' )->count();
				//总评价中优秀的数目 
				$data2 = db( "data" )->where( 'sumid', $id )->where( 'cateid', $exceldata[ $key ][ "cateid" ] )->where( 'bzsummary', '良好' )->count();
				//总评价中良好的数目
				$data3 = db( "data" )->where( 'sumid', $id )->where( 'cateid', $exceldata[ $key ][ "cateid" ] )->where( 'bzsummary', '合格' )->count();
				//总评价中合格的数目
				$data4 = db( "data" )->where( 'sumid', $id )->where( 'cateid', $exceldata[ $key ][ "cateid" ] )->where( 'bzsummary', '不合格' )->count();
				//总评价中不合格的数目
				$score3 = db( "data" )->field('score3')->where( 'sumid', $id )->where( 'cateid', $exceldata[ $key ][ "cateid" ] )->avg('score3');
				//总评价中的总分
				$exceldata[ $key ][ 'data1' ] = $data1;
				$exceldata[ $key ][ 'data2' ] = $data2;
				$exceldata[ $key ][ 'data3' ] = $data3;
				$exceldata[ $key ][ 'data4' ] = $data4;
				$exceldata[ $key ][ 'score3' ] = $score3;
			}
			//dump($exceldata);die;
			        $data = array();
          foreach ($exceldata as $k => $goods_info) {
               $data[$k]['B'] = $goods_info['catename'];
               $data[$k]['C'] = $goods_info['data1'];
               $data[$k]['D'] = $goods_info['data2'];
               $data[$k]['E'] = $goods_info['data3'];
               $data[$k]['F'] = $goods_info['data4'];
               $data[$k]['G'] = $goods_info['score3'];
          }
//dump($data);die;
          $filename = '班子测评' . time();
          $this->getExcel($filename, $data);
	}

	private function getExcel($filename, $data)
     {
          //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
          require_once(ROOT_PATH . 'vendor/PHPExcel.php');//引入PHP EXCEL类
          require_once(ROOT_PATH . 'Vendor/PHPExcel/IOFactory.php');//引入PHP EXCEL类
          require_once(ROOT_PATH . 'Vendor/PHPExcel/Writer/Excel5.php');//引入PHP EXCEL类
          require_once(ROOT_PATH . 'Vendor/PHPExcel/Writer/PDF.php');//引入PHP EXCEL PDF类
          // require_once(ROOT_PATH . 'Vendor/PHPExcel/Writer/Excel2007.php');//引入PHP EXCEL类
          require_once(ROOT_PATH . 'Vendor/PHPExcel/Reader/Excel5.php');//引入PHP EXCEL类
          // require_once(ROOT_PATH . 'Vendor/PHPExcel/Reader/Excel2007.php');//引入PHP EXCEL类
          require_once(ROOT_PATH . 'Vendor/PHPExcel/style.php');//引入PHP EXCEL类

          
          

          $date = date("Y_m_d", time());
          $filename .= ".xls";

          //创建PHPExcel对象，注意，不能少了\
          $objPHPExcel = new \PHPExcel();


          $column = 3;
          $objActSheet = $objPHPExcel->getActiveSheet();


          $objActSheet->mergeCells('A1:G1');      // A1:G1合并
          $objActSheet->setCellValue('A1', '浙江农林大学班子测评汇总');

          $objActSheet->setCellValue('A2', '序号');
          $objActSheet->setCellValue('B2', '部门');
          $objActSheet->setCellValue('C2', '优秀');
          $objActSheet->setCellValue('D2', '良好');
          $objActSheet->setCellValue('E2', '合格');
          $objActSheet->setCellValue('F2', '不合格');
          $objActSheet->setCellValue('G2', '平均分');


          // $objPHPExcel->getActiveSheet()->getStyle('A2:E8')->getAlignment()->setWrapText(true);

//设置宽width
// Set column widths
          $objActSheet->getColumnDimension('A')->setWidth(10);
          $objActSheet->getColumnDimension('B')->setWidth(10);
          $objActSheet->getColumnDimension('C')->setWidth(10);
          $objActSheet->getColumnDimension('D')->setWidth(10);
          $objActSheet->getColumnDimension('E')->setWidth(10);

// 设置单元格高度
// 所有单元格默认高度
          $objActSheet->getDefaultRowDimension()->setRowHeight(30);
// 第一行的默认高度
          $objActSheet->getRowDimension('2')->setRowHeight(36);
          $objActSheet->getRowDimension('1')->setRowHeight(40);

          //print_r($data);exit;
          foreach ($data as $key => $rows) { //行写入
               $span = ord("A");
               $j = chr($span);
               $xuhao=$key+1;
               $objActSheet->setCellValue($j . $column, $xuhao);
               $span = ord("B");
               foreach ($rows as $keyName => $value) {// 列写入
                    $j = chr($span);
                    $objActSheet->setCellValue($j . $column, $value);
                    $span++;
               }
               $column++;
          }

          // $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('黑体');
          // $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
          // $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setUnderline(\PHPExcel_Style_Font::UNDERLINE_SINGLE);
          // $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

         

          $styleThinBlackBorderOutline = array(
               'borders' => array(
                    'allborders' => array(
                         'style' => \PHPExcel_Style_Border::BORDER_THIN,   //设置border样式
                         //'style' => PHPExcel_Style_Border::BORDER_THICK,  另一种样式
                         'color' => array('argb' => 'FF000000'),          //设置border颜色
                    ),
               ),
          );

          // $objPHPExcel->getActiveSheet()->getStyle('A2:E3')->applyFromArray($styleThinBlackBorderOutline);
          // $objPHPExcel->getActiveSheet()->getStyle('A5:E6')->applyFromArray($styleThinBlackBorderOutline);
          // $objPHPExcel->getActiveSheet()->getStyle('A8:E9')->applyFromArray($styleThinBlackBorderOutline);
          // $objPHPExcel->getActiveSheet()->getStyle('A11:E14')->applyFromArray($styleThinBlackBorderOutline);

          $filename = iconv("utf-8", "gb2312", $filename);

          //重命名表
          //$objPHPExcel->getActiveSheet()->setTitle('test');
          //设置活动单指数到第一个表,所以Excel打开这是第一个表
          $objPHPExcel->setActiveSheetIndex(0);
          ob_end_clean();//清除缓冲区,避免乱码



          	//EXCEL
       header('Content-Type: application/vnd.ms-excel');
       header("Content-Disposition: attachment;filename=\"$filename\"");
       header('Cache-Control: max-age=0');

          $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output'); //文件通过浏览器下载


          //END


          //PDF
          // header('Content-Type: application/PDF');
          // header("Content-Disposition: attachment;filename=\"$filename\"");
          // header('Cache-Control: max-age=0');

          // $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
          // $objWriter->save('php://output'); //文件通过浏览器下载.

          // header('Content-Type: application/pdf');
          // header('Content-Disposition: attachment;filename="01simple.pdf"');
          // header('Cache-Control: max-age=0');
          // $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
          // $objWriter->save('php://output');



        //END


     }

}