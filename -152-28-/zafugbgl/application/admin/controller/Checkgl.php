<?php
namespace app\ admin\ controller;
use app\ admin\ model\ Cate as CateModel;
use app\ admin\ controller\ Common;
class Checkgl extends Common {
	/*索引
		lst        基础列表
		lst2       被测评名单（中层干部）
		lst2-2     被测评名单（部门名称）
		show       被测评名单（中层干部）后续存入数据库
		check1     被测评名单预览
		check1_add 添加人员到被测评名单
		dec1 and dec2 删除
		add1 and add2 添加
		lst3       测评人员名单
		show2      测评人员名单后续存入数据库
		check2     测试人员名单预览
		check2_add 添加人员到测试人员名单
		add        添加调查表
		edit       编辑调查表
		del        删除调查表
	*/


	//lst        基础列表
	public

	function lst() {
		$artres = db( 'checktable' )->order( 'id', "desc" )->paginate( 50 );
		//dump($artres);die;
		$department = db( 'cate' )->order( 'id' )->select();
		$this->assign( array(
			'artres' => $artres,
			'department' => $department,
		) );
		return view();
	}

	//lst2       被测评名单（中层干部）
	public

	function lst2() {
		$id = input( 'id' );
		$type = input( 'type' );
		//dump($type);
		if ( $id ) {
			session( 'checktableid', $id );
		}
		if ( $type == "试用期干部测评" ) {
			$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where( 'b.try', "是" )->where( 'a.type', "中层干部" )->order( 'b.sort' )->paginate( 70 );
			$artall = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where( 'b.try', "是" )->where( 'a.type', "中层干部" )->order( 'b.sort' )->select();
		} elseif ( $type == "正职测评" ) {
			$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where( 'b.try', '<>', "是" )->where( 'b.zhiji', '中层副职' )->where( 'a.type', "中层干部" )->order( 'b.sort' )->paginate( 70 );
			$artall = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where( 'b.try', '<>', "是" )->where( 'b.zhiji', '中层副职' )->where( 'a.type', "中层干部" )->order( 'b.sort' )->select();
		}
		else {
			$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where( 'a.type', "中层干部" )->order( 'b.sort' )->paginate( 70 );
			$artall = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where( 'a.type', "中层干部" )->order( 'b.sort' )->select();
		}

		//dump($artres);die;
		$department = db( 'cate' )->order( 'id' )->select();
		$this->assign( array(
			'id' => $id,
			'artres' => $artres,
			'artall' => $artall,
			'department' => $department,
			'type' => $type,

		) );

		if ( request()->isPost() ) {
			$data = input( 'post.' );
			//dump($data);die;
			if ( $data[ 'type' ] == "试用期干部测评" ) {
				if ( $data[ "part" ] == 0 && $data[ "information" ] == "" ) {
					$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where( 'b.try', "是" )->where( 'a.type', "中层干部" )->order( 'b.sort' )->select();
				} elseif ( $data[ "part" ] == 0 ) {
					if ( $data[ "selectway" ] == "name" ) {
						$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where( 'b.try', "是" )->where( 'a.type', "中层干部" )->order( 'b.sort' )->where( 'a.name', $data[ "information" ] )->select();
					} elseif ( $data[ "selectway" ] == "worknum" ) {
						$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where( 'b.try', "是" )->where( 'a.type', "中层干部" )->order( 'b.sort' )->where( 'a.worknum', $data[ "information" ] )->select();
					}
				}
				else {
					$i = $data[ "part" ];
					if ( $data[ "selectway" ] == "name" && $data[ "information" ] == "" ) {
						$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where( 'b.try', "是" )->where( 'a.type', "中层干部" )->order( 'b.sort' )->where( 'a.cateid', $i )->select();
					} elseif ( $data[ "selectway" ] == "name" ) {
						$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where( 'b.try', "是" )->where( 'a.type', "中层干部" )->order( 'b.sort' )->where( 'a.name', $data[ "information" ] )->where( 'a.cateid', $i )->select();
					}
					elseif ( $data[ "selectway" ] == "worknum" ) {
						$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where( 'b.try', "是" )->where( 'a.type', "中层干部" )->order( 'b.sort' )->where( 'a.worknum', $data[ "information" ] )->where( 'a.cateid', $i )->select();
					}
				}
			} else {
				if ( $data[ "part" ] == 0 && $data[ "information" ] == "" ) {
					$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where( 'a.type', "中层干部" )->order( 'b.sort' )->select();
				} elseif ( $data[ "part" ] == 0 ) {
					if ( $data[ "selectway" ] == "name" ) {
						$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where( 'a.type', "中层干部" )->order( 'b.sort' )->where( 'a.name', $data[ "information" ] )->select();
					} elseif ( $data[ "selectway" ] == "worknum" ) {
						$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where( 'a.type', "中层干部" )->order( 'b.sort' )->where( 'a.worknum', $data[ "information" ] )->select();
					}
				}
				else {
					$i = $data[ "part" ];
					if ( $data[ "selectway" ] == "name" && $data[ "information" ] == "" ) {
						$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where( 'a.type', "中层干部" )->order( 'b.sort' )->where( 'a.cateid', $i )->select();
					} elseif ( $data[ "selectway" ] == "name" ) {
						$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where( 'a.type', "中层干部" )->order( 'b.sort' )->where( 'a.name', $data[ "information" ] )->where( 'a.cateid', $i )->select();
					}
					elseif ( $data[ "selectway" ] == "worknum" ) {
						$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where( 'a.type', "中层干部" )->order( 'b.sort' )->where( 'a.worknum', $data[ "information" ] )->where( 'a.cateid', $i )->select();
					}
				}
			}
			$this->assign( array(
				'artres' => $artres,
				'artall' => $artall,
				'department' => $department,
			) );
			return view( "checkgl/show" );
		}

		return view();
	}

	//lst2-2     被测评名单（部门名称）
	public

	function lst2_2() {
		$id = input( 'id' );
		if ( $id ) {
			session( 'checktableid', $id );
		}
		$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where( 'a.type', "中层干部" )->order( 'b.sort' )->paginate( 70 );
		$department = db( 'cate' )->where( 'keywords = "教学部门"' )->order( 'sort' )->select();
		//班子测评，机关部门不参与。
		$this->assign( array(
			'id' => $id,
			'artres' => $artres,
			'department' => $department,
		) );

		if ( request()->isPost() ) {
			$data = input( 'post.' );
			if ( !$data ) {
				$this->error( '请选择测评对象！', url( 'lst2_2', array( 'id' => $id ) ) );
			}
			$i = 0;
			foreach ( $data as $value ) {
				$department = db( 'cate' )->field( 'id' )->where( 'id', $value )->find();
				$department2[ $i ][ "cateid" ] = $department[ "id" ];
				$department2[ $i ][ "sumid" ] = $id;
				$i++;
			}

			//添加或编辑信息
			$i = 0;
			$flag = 0; //判断添加信息有无失败
			db( 'bechecked' )->where( 'sumid', $id )->delete();
			foreach ( $department2 as $value ) {

				if ( db( 'bechecked' )->insert( $department2[ $i ] ) ) {} else {
					$flag = 1;
				}
				$i++;
			}
			//END

			if ( $flag == 0 ) {
				session( 'checktableid', null );
				$first = session( 'createtable' );
				if ( $first == "1" ) {
					$getID = db( 'checktable' )->max( 'id' ); //$getID即为最后一条记录的ID
					session( 'createtable', null );
					$this->success( '添加测评对象信息成功,现在选取投票对象', url( 'lst3', array( 'id' => $getID ) ) );
				}
				$this->success( '编辑调查表信息成功', url( 'lst' ) );
			} else {
				$this->error( '编辑调查表信息失败！', url( 'lst2_2', array( 'id' => $id ) ) );
			}
			return view();
		}

		return view();
	}

	//show       被测评名单（中层干部）后续存入数据库
	public

	function show() {
		$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where( 'a.type', "中层干部" )->order( 'b.sort' )->paginate( 10 );
		$department = db( 'cate' )->order( 'id' )->select();
		$this->assign( array(
			'artres' => $artres,
			'department' => $department,
		) );
		$id = session( 'checktableid' );
		if ( request()->isPost() ) {
			$data = input( 'post.' );
			$i = 0;
			foreach ( $data as $value ) {
				$artres2[ $i ] = $artres = db( 'admin' )->field( 'a.worknum' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where( 'a.type', "中层干部" )->order( 'b.sort' )->where( 'b.id', $value )->find();
				$artres2[ $i ][ "sumid" ] = $id;
				$i++;
			}
			$department = db( 'cate' )->order( 'id' )->select();

			//添加或编辑信息
			$i = 0;
			$flag = 0; //判断添加信息有无失败
			db( 'bechecked' )->where( 'sumid', $id )->delete();
			foreach ( $artres2 as $value ) {

				if ( db( 'bechecked' )->insert( $artres2[ $i ] ) ) {} else {
					$flag = 1;
				}
				$i++;
			}
			//END

			if ( $flag == 0 ) {
				session( 'checktableid', null );
				$first = session( 'createtable' );
				if ( $first == "1" ) {
					$getID = db( 'checktable' )->max( 'id' );
					//$getID即为最后一条记录的ID
					session( 'createtable', null );
					$this->success( '添加测评对象信息成功,现在选取投票对象', url( 'lst3', array( 'id' => $getID ) ) );
				}

				$this->success( '编辑调查表信息成功', url( 'lst' ) );
			} else {
				$this->error( '编辑调查表信息失败！', url( 'lst2' ) );
			}
			return;
		}

		return view( "checkgl/show" );
	}

	//check1     被测评名单预览
	public

	function check1() {
		$id = input( 'id' );
		$type = db( 'checktable' )->field( 'type' )->where( 'id', $id )->find();
		if ( $type[ "type" ] == "班子测评" ) {
			$artres = db( 'checktable' )->field( 'a.name checkname,a.timestart,a.timeend,c.catename,a.type' )->alias( 'a' )->join( 'gb_bechecked b', 'a.id=b.sumid' )->join( 'gb_cate c', 'c.id=b.cateid' )->order( 'id' )->where( 'a.id', $id )->order( 'c.sort' )->paginate( 70 );
			//验证数据有效
			$num=0;
			foreach ( $artall as $key => $value ) {
				$num++;
			}
			if ( $num == 0 ) {
				$this->error( '无候选部门信息！', url( 'lst' ) );
			}
			//验证数据有效END
			$this->assign( array(
				'artres' => $artres,
			) );
			return view( "checkgl/check1" );
		} elseif ( $type[ "type" ] == "正职测评" ) {
			$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename,e.name checkname,e.timestart,e.timeend,d.sumid ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_bechecked d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where( 'e.id', $id )->where( 'a.type', "中层干部" )->where( 'b.zhiji', '中层副职' )->where( 'b.try', '<>', '是' )->order( 'b.sort' )->paginate( 70 );
			//验证数据有效
			$num=0;
			foreach ( $artall as $key => $value ) {
				$num++;
			}
			if ( $num == 0 ) {
				$this->error( '无候选人信息！', url( 'lst' ) );
			}
			//验证数据有效END
			$department = db( 'cate' )->order( 'id' )->select();
			$this->assign( array(
				'artres' => $artres,
				'department' => $department,
			) );
			return view();
		}
		else {
			$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename,e.name checkname,e.timestart,e.timeend,d.sumid ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_bechecked d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where( 'e.id', $id )->where( 'a.type', "中层干部" )->order( 'b.sort' )->paginate( 70 );
			$a = $artres->isEmpty();
			if ( $a == "true" ) {
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

	function check1_add() {
		$id = input( 'id' );
		$type = db( 'checktable' )->field( 'type' )->where( 'id', $id )->find();
		if ( $type[ "type" ] == "班子测评" ) {
			$artres = db( 'checktable' )->field( 'a.name checkname,a.timestart,a.timeend,c.catename,a.type' )->alias( 'a' )->join( 'gb_bechecked b', 'a.id=b.sumid' )->join( 'gb_cate c', 'c.id=b.cateid' )->order( 'id' )->where( 'a.id', $id )->order( 'c.sort' )->paginate( 70 );
			$a = $artres->isEmpty();
			if ( $a == "true" ) {
				$this->error( '无候选部门信息！', url( 'lst' ) );
			}
			$this->assign( array(
				'artres' => $artres,
			) );
			return view( "checkgl/check1" );
		} elseif ( $type[ "type" ] == "正职测评" ) {
			$artall = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.sort,b.job,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where( 'b.try', '<>', "是" )->where( 'b.zhiji', '中层副职' )->where( 'a.type', "中层干部" )->order( 'b.sort' )->select();
			$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.sort,b.job,c.catename,e.name checkname,e.timestart,e.timeend,d.sumid ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_bechecked d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where( 'e.id', $id )->where( 'a.type', "中层干部" )->where( 'b.zhiji', '中层副职' )->where( 'b.try', '<>', '是' )->order( 'b.sort' )->select(  );
			//dump($artall);
			//dump($artres);
			foreach ( $artall as $i => $value1 ) {
				foreach ( $artres as $j => $value2 ) {
					if ( $value1[ 'worknum' ] == $value2[ 'worknum' ] ) {
						unset( $artall[ $i ] );
					}
				}
			}
			//dump($artall);die;
			//验证数据有效
			$num=0;
			foreach ( $artall as $key => $value ) {
				$num++;
			}
			if ( $num == 0 ) {
				$this->error( '无候选人信息！', url( 'check1',array('id'=>$id) ) );
			}
			//验证数据有效END
			$department = db( 'cate' )->order( 'id' )->select();
			$this->assign( array(
				'id' => $id,
				'artres' => $artres,
				'artall' => $artall,
				'department' => $department,
			) );
			return view();
		}
		else {
			$artall = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.sort,b.job,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where( 'a.type', "中层干部" )->order( 'b.sort' )->select();
			$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename,e.name checkname,e.timestart,e.timeend,d.sumid ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_bechecked d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where( 'e.id', $id )->where( 'a.type', "中层干部" )->order( 'b.sort' )->select();
			foreach ( $artall as $i => $value1 ) {
				foreach ( $artres as $j => $value2 ) {
					if ( $value1[ 'worknum' ] == $value2[ 'worknum' ] ) {
						unset( $artall[ $i ] );
					}
				}
			}
			//验证数据有效
			$num=0;
			foreach ( $artall as $key => $value ) {
				$num++;
			}
			if ( $num == 0 ) {
				$this->error( '无候选人信息！', url( 'check1',array('id'=>$id) ) );
			}
			//验证数据有效END
			$department = db( 'cate' )->order( 'id' )->select();
			$this->assign( array(
				'id' => $id,
				'artres' => $artres,
				'artall' => $artall,
				'department' => $department,
			) );
			return view();
		}
	}

	//dec1 and dec2 删除
	public
	function dec1( $worknum = "", $sumid = "" ) {
		if ( db( 'bechecked' )->where( 'worknum', $worknum )->where( 'sumid', $sumid )->delete() )
			$this->success( '删除成功' );
		else
			$this->error( '删除失败' );
	}
	public

	function dec2( $worknum = "", $sumid = "" ) {
		if ( db( 'check' )->where( 'worknum', $worknum )->where( 'sumid', $sumid )->delete() )
			$this->success( '删除成功' );
		else
			$this->error( '删除失败' );
	}
	//add1 and add2 删除
	public
	function add1( $worknum = "", $sumid = "" ) {
		$data=array();
		$data['sumid']=$sumid;
		$data['worknum']=$worknum;
		if ( db( 'bechecked' )->insert($data) )
			$this->success( '添加成功' );
		else
			$this->error( '添加失败' );
	}
	public

	function add2( $worknum = "", $sumid = "" ) {
		$data=array();
		$data['sumid']=$sumid;
		$data['worknum']=$worknum;
		$data['status']=2;
		
		
		//避免重复添加验证代码
		$true = db( "check" )->where( 'sumid', $sumid )->where( "worknum", $worknum )->select();
		$determine=empty($true);

		$num = 0;

		foreach ( $true as $key => $value ) {
			$num++;
		}
		if ( $num != 0 ) {
			$this->error( '候选人信息已添加 ，请勿重复添加！' );
		}
		//避免重复添加验证代码END
		
		
		
		//计算allvote值
		
		$yonghuinf = db( "admin" )->field( "cateid" )->where( 'worknum', $worknum )->find();
		$cateinf = db( "cate" )->where( 'id', $yonghuinf[ "cateid" ] )->find();
		$checktableinf = db( "checktable" )->where( "id", $sumid )->find();
		//dump($yonghuinf);
		//dump($cateinf);
		//dump($checktableinf);
		if($checktableinf["type"]=="中层测评"){
		$allvote = db( 'bechecked' )->alias( 'a' )->where( 'a.sumid', $sumid )->join( 'gb_view_yonghu b', 'b.worknum=a.worknum' )->where( 'b.cateid', '<>', $yonghuinf[ 'cateid' ] )->where( 'b.keywords2', '<>', $cateinf[ 'keywords2' ] )->count( 'a.id' );
		}
		elseif($checktableinf["type"]=="正职测评"){
			$allvote = db( 'bechecked' )->alias( 'a' )->where( 'a.sumid', $sumid )->join( 'gb_article b', 'b.adminid=a.worknum' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where( 'c.cateid', $yonghuinf[ 'cateid' ] )->where( 'b.zhiji', '中层副职' )->count();
		}
		elseif($checktableinf["type"]=="班子测评"){
			$allvote =1;
		}
		elseif($checktableinf["type"]=="民主测评"){
			$allvote =db( 'bechecked' )->alias( 'a' )->where( 'a.sumid', $sumid )->join( 'gb_view_yonghu b', 'b.worknum=a.worknum' )->where( 'b.cateid', $yonghuinf[ 'cateid' ] )->count( 'id' );
		}
		//dump($allvote);die;
		
		
		//计算allvote值 END
		
		
		
		$data['allvote']=$allvote;
		if ( db( 'check' )->insert($data) )
			$this->success( '添加成功' );
		else
			$this->error( '添加失败' );
	}
	//lst3       测评人员名单
	public

	function lst3() {
		$id = input( 'id' );
		if ( $id ) {
			session( 'checktableid', $id );
		}
		$id = session( 'checktableid' );

		$checktableinf = db( "checktable" )->where( "id", $id )->find();
		if ( $checktableinf[ "type" ] == "中层互评" || $checktableinf[ "type" ] == "德的干部互评" ) {
			$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,a.id,c.catename ' )->alias( 'a' )->join( 'gb_cate c', 'c.id=a.cateid' )->order( 'a.id' )->where( 'a.type', "中层干部" )->paginate( 70 );
			$artall = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,a.id,c.catename ' )->alias( 'a' )->join( 'gb_cate c', 'c.id=a.cateid' )->order( 'a.id' )->where( 'a.type', "中层干部" )->select();
		} elseif ( $checktableinf[ "type" ] == "正职测评" ) {
			$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where( 'b.try', '<>', "是" )->where( 'b.zhiji', '中层正职' )->where( 'a.type', "中层干部" )->order( 'b.sort' )->paginate( 70 );
			$artall = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where( 'b.try', '<>', "是" )->where( 'b.zhiji', '中层正职' )->where( 'a.type', "中层干部" )->order( 'b.sort' )->select();
		}
		elseif ( $checktableinf[ 'type' ] == "班子测评" ) {
			$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,a.id,c.catename ' )->alias( 'a' )->join( 'gb_cate c', 'c.id=a.cateid' )->order( 'a.id' )->where( 'c.keywords', "教学部门" )->paginate( 70 );
			$artall = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,a.id,c.catename ' )->alias( 'a' )->join( 'gb_cate c', 'c.id=a.cateid' )->order( 'a.id' )->where( 'c.keywords', "教学部门" )->select();
		}
		else {
			$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,a.id,c.catename ' )->alias( 'a' )->join( 'gb_cate c', 'c.id=a.cateid' )->order( 'a.id' )->paginate( 70 );
			$artall = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,a.id,c.catename ' )->alias( 'a' )->join( 'gb_cate c', 'c.id=a.cateid' )->order( 'a.id' )->select();
		}
		$department = db( 'cate' )->order( 'id' )->select();
		$this->assign( array(
			'id' => $id,
			'artres' => $artres,
			'artall' => $artall,
			'department' => $department,
		) );

		if ( request()->isPost() ) {
			$data = input( 'post.' );
			if ( $checktableinf[ "type" ] == "中层互评" || $checktableinf[ "type" ] == "德的干部互评" ) {
				if ( $data[ "part" ] == 0 ) {
					$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,a.id,c.catename ' )->alias( 'a' )->join( 'gb_cate c', 'c.id=a.cateid' )->order( 'a.id' )->where( 'a.type', "中层干部" )->select();
				} else {
					$i = $data[ "part" ];
					$artres = $artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,a.id,c.catename ' )->alias( 'a' )->join( 'gb_cate c', 'c.id=a.cateid' )->order( 'a.id' )->where( 'a.cateid', $i )->where( 'a.type', "中层干部" )->select();

				}
			} else {
				if ( $data[ "part" ] == 0 ) {
					$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,a.id,c.catename ' )->alias( 'a' )->join( 'gb_cate c', 'c.id=a.cateid' )->order( 'a.id' )->select();
				} else {
					$i = $data[ "part" ];
					$artres = $artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,a.id,c.catename ' )->alias( 'a' )->join( 'gb_cate c', 'c.id=a.cateid' )->order( 'a.id' )->where( 'a.cateid', $i )->select();

				}
			}
			$this->assign( array(
				'artres' => $artres,
				'department' => $department,
			) );
			return view( "checkgl/show2" );
		}

		return view();
	}

	//show2      测评人员名单后续存入数据库
	public

	function show2() {
		$artres = db( 'admin' )->field( 'a.worknum ' )->alias( 'a' )->join( 'gb_cate c', 'c.id=a.cateid' )->order( 'a.id' )->paginate( 10 );
		$department = db( 'cate' )->order( 'id' )->select();
		$this->assign( array(
			'artres' => $artres,
			'department' => $department,
		) );
		$id = session( 'checktableid' );
		$checktableinf = db( "checktable" )->where( "id", $id )->find();
		if ( request()->isPost() ) {
			$data = input( 'post.' );

			if ( $checktableinf[ "type" ] == "中层互评" || $checktableinf[ "type" ] == "德的干部互评" ) {
				$i = 0;
				foreach ( $data as $value ) {
					$artres2[ $i ] = $artres = db( 'admin' )->field( 'a.worknum' )->alias( 'a' )->join( 'gb_cate c', 'c.id=a.cateid' )->order( 'a.id' )->where( 'a.id', $value )->find();
					$yonghuinf = db( "admin" )->field( "cateid" )->where( 'id', $value )->find();
					$cateinf = db( "cate" )->where( 'id', $yonghuinf[ "cateid" ] )->find();
					//dump($cateinf);
					if ( $cateinf[ "keywords2" ] = "机关部门" ) {
						$artres2[ $i ][ "sumid" ] = $id;
						$artres2[ $i ][ "allvote" ] = db( 'bechecked' )->alias( 'a' )->where( 'a.sumid', $id )->join( 'gb_view_yonghu b', 'b.worknum=a.worknum' )->where( 'b.cateid', '<>', $yonghuinf[ 'cateid' ] )->where( 'b.keywords2', '<>', $cateinf[ 'keywords2' ] )->count( 'a.id' );
						//dump($artres2[$i]["allvote"]);
						$i++;
					} else {
						$artres2[ $i ][ "sumid" ] = $id;
						$artres2[ $i ][ "allvote" ] = db( 'bechecked' )->alias( 'a' )->where( 'a.sumid', $id )->join( 'gb_view_yonghu b', 'b.worknum=a.worknum' )->where( 'b.cateid', '<>', $yonghuinf[ 'cateid' ] )->where( 'b.keywords2', '<>', $cateinf[ 'keywords2' ] )->count( 'a.id' );
						//dump($artres2[$i]["allvote"]);
						$i++;
					}

				} //die;
			} elseif ( $checktableinf[ "type" ] == "民主测评" || $checktableinf[ "type" ] == "德的考核考察" ) {
				$i = 0;
				foreach ( $data as $value ) {
					$artres2[ $i ] = $artres = db( 'admin' )->field( 'a.worknum' )->alias( 'a' )->join( 'gb_cate c', 'c.id=a.cateid' )->order( 'a.id' )->where( 'a.id', $value )->find();
					$yonghuinf = db( "admin" )->field( "cateid" )->where( 'id', $value )->find();
					//dump($yonghuinf);
					$artres2[ $i ][ "sumid" ] = $id;
					$artres2[ $i ][ "allvote" ] = db( 'bechecked' )->alias( 'a' )->where( 'a.sumid', $id )->join( 'gb_view_yonghu b', 'b.worknum=a.worknum' )->where( 'b.cateid', $yonghuinf[ 'cateid' ] )->count( 'id' );
					//dump($artres2[$i]["allvote"]);
					$i++;
				}
			}
			elseif ( $checktableinf[ "type" ] == "试用期干部测评" ) { //试用期改掉了
				$i = 0;
				foreach ( $data as $value ) {
					$artres2[ $i ] = $artres = db( 'admin' )->field( 'a.worknum' )->alias( 'a' )->join( 'gb_cate c', 'c.id=a.cateid' )->order( 'a.id' )->where( 'a.id', $value )->find();
					$yonghuinf = db( "admin" )->field( "cateid" )->where( 'id', $value )->find();
					$cateinf = db( "cate" )->where( 'id', $yonghuinf[ "cateid" ] )->find();
					//dump($cateinf);

					if ( $cateinf[ "keywords" ] == "机关部门" ) {
						$artres2[ $i ][ "sumid" ] = $id;
						$artres2[ $i ][ "allvote" ] = db( 'bechecked' )->alias( 'a' )->where( 'a.sumid', $id )->join( 'gb_view_yonghu b', 'b.worknum=a.worknum' )->join( 'gb_article c', 'c.adminid=a.worknum' )->where( 'b.keywords', $cateinf[ 'keywords' ] )->where( 'c.try', "是" )->count( 'a.id' );
						//dump($artres2[$i]["allvote"]);
						$i++;
					} else {
						$artres2[ $i ][ "sumid" ] = $id;
						$artres2[ $i ][ "allvote" ] = db( 'bechecked' )->alias( 'a' )->where( 'a.sumid', $id )->join( 'gb_view_yonghu b', 'b.worknum=a.worknum' )->where( 'b.cateid', $yonghuinf[ 'cateid' ] )->join( 'gb_article c', 'c.adminid=a.worknum' )->where( 'c.try', "是" )->count( 'a.id' );
						//dump($artres2[$i]["allvote"]);
						$i++;
					}
				}
			}
			elseif ( $checktableinf[ "type" ] == "班子测评" ) {
				$i = 0;
				foreach ( $data as $value ) {
					$artres2[ $i ] = $artres = db( 'admin' )->field( 'a.worknum' )->alias( 'a' )->join( 'gb_cate c', 'c.id=a.cateid' )->order( 'a.id' )->where( 'a.id', $value )->find();
					$artres2[ $i ][ "sumid" ] = $id;
					$artres2[ $i ][ "allvote" ] = 1;
					$i++;
				}
			}
			elseif ( $checktableinf[ "type" ] == "正职测评" ) {
				$i = 0;
				//dump($data);
				foreach ( $data as $value ) {
					//dump($value);
					$artres2[ $i ] = $artres = db( 'admin' )->field( 'a.worknum' )->alias( 'a' )->order( 'a.id' )->join( 'gb_article b', 'b.adminid=a.worknum' )->where( 'b.id', $value )->find();
					$artres2[ $i ][ "sumid" ] = $id;
					$yonghuinf = db( "admin" )->field( "a.cateid" )->alias( 'a' )->join( 'gb_article b', 'b.adminid=a.worknum' )->where( 'b.id', $value )->find();
					$cateinf = db( "cate" )->where( 'id', $yonghuinf[ "cateid" ] )->find();
					//dump($yonghuinf);
					//dump($cateinf);

					//计算allvote值	(总需投票数)
					$artres2[ $i ][ "allvote" ] = db( 'bechecked' )->alias( 'a' )->where( 'a.sumid', $id )->join( 'gb_article b', 'b.adminid=a.worknum' )->join( 'gb_admin c', 'c.worknum=a.worknum' )->where( 'c.cateid', $yonghuinf[ 'cateid' ] )->where( 'b.zhiji', '中层副职' )->count();
					//END


					//dump($artres2[$i]);
					$i++;
				}
			}


			$department = db( 'cate' )->order( 'id' )->select();

			//添加或编辑信息
			$i = 0;
			//判断添加信息有无失败
			$flag = 0;

			db( 'check' )->where( 'sumid', $id )->delete();

			foreach ( $artres2 as $value ) {

				if ( db( 'check' )->insert( $artres2[ $i ] ) ) {} else {
					$flag = 1;
				}
				$i++;
			}
			//END

			if ( $flag == 0 ) {
				session( 'checktableid', null );
				$this->success( '编辑调查表信息成功', url( 'lst' ) );
			} else {
				$this->error( '编辑调查表信息失败！', url( 'lst3' ) );
			}
			return;
		}

		return view( "checkgl/show2" );
	}
	//check2     测试人员名单预览
	public

	function check2() {
		$id = input( 'id' );
		$artres = db( 'admin' )->field( 'a.id,a.worknum,a.name,a.type,c.catename,e.name checkname,e.timestart,e.timeend,d.sumid ' )->alias( 'a' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_check d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where( 'e.id', $id )->order( 'a.id' )->paginate( 50 );
		$a = $artres->isEmpty();
		if ( $a == "true" ) {
			$this->error( '无候选人信息！', url( 'lst' ) );
		}
		$department = db( 'cate' )->order( 'id' )->select();
		$this->assign( array(
			'artres' => $artres,
			'department' => $department,
		) );
		return view( "checkgl/check2" );
	}
	
	public

	function check2_add() {
		$id = input( 'id' );
		$type = db( 'checktable' )->field( 'type' )->where( 'id', $id )->find();
		if ( $type[ "type" ] == "中层互评" ) {
			
			$artall = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,a.id,c.catename ' )->alias( 'a' )->join( 'gb_cate c', 'c.id=a.cateid' )->order( 'a.id' )->where( 'a.type', "中层干部" )->select();
			$artres = db( 'admin' )->field( 'a.id,a.worknum,a.name,a.type,c.catename,e.name checkname,e.timestart,e.timeend,d.sumid ' )->alias( 'a' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_check d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where( 'e.id', $id )->order( 'a.id' )->select();			
		} elseif ( $type[ "type" ] == "正职测评" ) {
			$artall = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.*,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where( 'b.try', '<>', "是" )->where( 'b.zhiji', '中层正职' )->where( 'a.type', "中层干部" )->order( 'b.sort' )->select();
			$artres = db( 'admin' )->field( 'a.id,a.worknum,a.name,a.type,c.catename,e.name checkname,e.timestart,e.timeend,d.sumid ' )->alias( 'a' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_check d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where( 'e.id', $id )->order( 'a.id' )->select();
		}
		elseif(  $type[ "type" ] == "班子测评" ){
			$artall = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,a.id,c.catename ' )->alias( 'a' )->join( 'gb_cate c', 'c.id=a.cateid' )->order( 'a.id' )->where( 'c.keywords', "教学部门" )->select();
			$artres = db( 'admin' )->field( 'a.id,a.worknum,a.name,a.type,c.catename,e.name checkname,e.timestart,e.timeend,d.sumid ' )->alias( 'a' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_check d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where( 'e.id', $id )->order( 'a.id' )->select();
		}
		elseif ( $type[ "type" ] == "民主测评" ) {
			$artall = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,a.id,c.catename ' )->alias( 'a' )->join( 'gb_cate c', 'c.id=a.cateid' )->order( 'a.id' )->select();
			$artres = db( 'admin' )->field( 'a.id,a.worknum,a.name,a.type,c.catename,e.name checkname,e.timestart,e.timeend,d.sumid ' )->alias( 'a' )->join( 'gb_cate c', 'c.id=a.cateid' )->join( 'gb_check d', 'd.worknum=a.worknum' )->join( 'gb_checktable e', 'e.id=d.sumid' )->where( 'e.id', $id )->order( 'a.id' )->select();
		}
		else{
			$this->error( '无此投票类型处理代码！', url( 'check1', array( 'id' => $id ) ) );
		}
		foreach ( $artall as $i => $value1 ) {
			foreach ( $artres as $j => $value2 ) {
				if ( $value1[ 'worknum' ] == $value2[ 'worknum' ] ) {
					unset( $artall[ $i ] );
				}
			}
		}
		//验证数据有效
		$num = 0;
		foreach ( $artall as $key => $value ) {
			$num++;
		}
		if ( $num == 0 ) {
			$this->error( '无候选人信息！', url( 'check1', array( 'id' => $id ) ) );
		}
		//验证数据有效END
		$department = db( 'cate' )->order( 'id' )->select();
		$this->assign( array(
			'id' => $id,
			'artres' => $artres,
			'artall' => $artall,
			'department' => $department,
		) );
		return view();

	}
	//add        添加调查表
	public

	function add() {
		if ( request()->isPost() ) {
			$data = input( 'post.' );
			$data[ 'time' ] = time();

			if ( $data[ 'type' ] == "班子测评" ) {
				if ( db( 'checktable' )->insert( $data ) ) {
					$getID = db( 'checktable' )->max( 'id' );
					//$getID即为最后一条记录的ID
					session( 'createtable', "1" );
					$this->success( '添加调查表信息成功', url( 'lst2_2', array( 'id' => $getID ) ) );
				} else {
					$this->error( '添加调查表信息失败！' );
				}
			} elseif ( $data[ 'type' ] == "德的考核考察" || $data[ 'type' ] == "民主测评" || $data[ 'type' ] == "中层互评" || $data[ 'type' ] == "德的干部互评" || $data[ 'type' ] == "试用期干部测评" || $data[ 'type' ] == "正职测评" ) {
				if ( db( 'checktable' )->insert( $data ) ) {
					$getID = db( 'checktable' )->max( 'id' );
					//$getID即为最后一条记录的ID
					session( 'createtable', '1' );
					$this->success( '添加调查表信息成功,现在选取测评对象', url( 'lst2', array( 'id' => $getID, 'type' => $data[ 'type' ] ) ) );
				} else {
					$this->error( '添加调查表信息失败！' );
				}
			}

			return;
		}

		$cate = new CateModel();
		$cateres = $cate->catetree();
		$department = db( 'cate' )->order( 'id' )->select();
		$this->assign( array(
			'cateres' => $cateres,
			'department' => $department,
		) );

		return view();
	}

	//edit       编辑调查表
	public

	function edit() {
		$arts = db( 'checktable' )->where( array( 'id' => input( 'id' ) ) )->find();
		if ( request()->isPost() ) {
			$data = input( 'post.' );
			$data[ 'time' ] = time();
			if ( db( 'checktable' )->where( "sumid", $data[ "sumid" ] )->update( $data ) ) {
				$this->success( '修改调查表信息成功！', url( 'lst' ) );
			} else {
				$this->error( '修改调查表信息失败！' );
			}
			return;
		}
		$cate = new CateModel();
		$cateres = $cate->catetree();
		$this->assign( array(
			'cateres' => $cateres,
			'arts' => $arts,
		) );
		return view();
	}


	//del        删除调查表
	public

	function del() {
		db( 'check' )->where( 'sumid', input( "id" ) )->delete();
		db( 'bechecked' )->where( 'sumid', input( "id" ) )->delete();
		db( 'data' )->where( 'sumid', input( "id" ) )->delete();
		if ( db( 'checktable' )->where( "id", input( "id" ) )->delete() ) {
			$this->success( '删除调查表信息成功！', url( 'lst' ) );
		} else {
			$this->error( '删除调查表信息失败！' );
		}
	}









}