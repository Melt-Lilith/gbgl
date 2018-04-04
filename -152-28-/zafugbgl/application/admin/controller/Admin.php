<?php
namespace app\ admin\ controller;
use app\ admin\ model\ Admin as AdminModel;
use app\ admin\ controller\ Common;
class Admin extends Common {

	public

	function lst() {

		$auth = new Auth();
		$admin = new AdminModel();
		$adminres = $admin->getadmin();
		$adminres2 = db( "admin" )->field( 'a.id,a.worknum,a.name,a.type,a.cateid,b.catename ' )->alias( 'a' )->join( 'gb_cate b', 'a.cateid=b.id' )->order( 'a.cateid')->paginate( 50, false, [
			'type' => 'boot',
			'var_page' => 'page',
		] );

		$page = $adminres2->render(); //获取分页信息
		$addata = $adminres2->all(); //获取当页的所有二维数组
		foreach ( $addata as $k => $v ) {
			$_groupTitle = $auth->getGroups( $v[ 'id' ] );
			$groupTitle = $_groupTitle[ 0 ][ 'title' ];
			$addata[ $k ][ 'groupTitle' ] = $groupTitle;
		}
		$department = db( 'cate' )->order( 'id' )->select();


		if ( request()->isPost() ) {
			$data = input( 'post.' );
			
			if ( $data[ "part" ] == 0 && $data[ "information" ] == "" ) {
				$adminres2 = db( "admin" )->field( 'a.id,a.worknum,a.name,a.type,a.cateid,b.catename ' )->alias( 'a' )->join( 'gb_cate b', 'a.cateid=b.id' )->order( 'a.cateid' )->paginate( 50, false, [
					'type' => 'boot',
					'var_page' => 'page',
					] );
			} 
			elseif ( $data[ "part" ] == 0 ) {
				if ( $data[ "selectway" ] == "name" ) {
					$adminres2 = db( "admin" )->field( 'a.id,a.worknum,a.name,a.type,a.cateid,b.catename ' )->alias( 'a' )->join( 'gb_cate b', 'a.cateid=b.id' )->order( 'a.id' )->where( 'a.name', $data[ "information" ] )->paginate( 200, false, [
					'type' => 'boot',
					'var_page' => 'page',
					] );
				} 
				elseif ( $data[ "selectway" ] == "worknum" ) {
					$adminres2 = db( "admin" )->field( 'a.id,a.worknum,a.name,a.type,a.cateid,b.catename ' )->alias( 'a' )->join( 'gb_cate b', 'a.cateid=b.id' )->order( 'a.id' )->where( 'a.worknum', $data[ "information" ] )->paginate( 200, false, [
					'type' => 'boot',
					'var_page' => 'page',
					] );
				}
			} 
			else {
				$i = $data[ "part" ];
				if ( $data[ "selectway" ] == "name"  && $data["information"]=="") {
					$adminres2 = db( "admin" )->field( 'a.id,a.worknum,a.name,a.type,a.cateid,b.catename ' )->alias( 'a' )->join( 'gb_cate b', 'a.cateid=b.id' )->order( 'a.id' )->where( 'a.cateid', $i )->paginate( 200, false, [
					'type' => 'boot',
					'var_page' => 'page',
					] );
				} 
				elseif ($data[ "selectway" ] == "name") {
					$adminres2 = db( "admin" )->field( 'a.id,a.worknum,a.name,a.type,a.cateid,b.catename ' )->alias( 'a' )->join( 'gb_cate b', 'a.cateid=b.id' )->order( 'a.id' )->where( 'a.name', $data[ "information" ] )->where( 'a.cateid', $i )->paginate( 200, false, [
					'type' => 'boot',
					'var_page' => 'page',
					] );
				}
				elseif ( $data[ "selectway" ] == "worknum" ) {
					$adminres2 = db( "admin" )->field( 'a.id,a.worknum,a.name,a.type,a.cateid,b.catename ' )->alias( 'a' )->join( 'gb_cate b', 'a.cateid=b.id' )->order( 'a.id' )->where( 'a.worknum', $data[ "information" ] )->where( 'a.cateid', $i )->where( 'a.cateid', $i )->paginate( 200, false, [
					'type' => 'boot',
					'var_page' => 'page',
					] );
				}
			}
			$page = $adminres2->render(); //获取分页信息
			$addata = $adminres2->all(); //获取当页的所有二维数组
			foreach ( $addata as $k => $v ) {
				$_groupTitle = $auth->getGroups( $v[ 'id' ] );
				$groupTitle = $_groupTitle[ 0 ][ 'title' ];
				$addata[ $k ][ 'groupTitle' ] = $groupTitle;
			}
			$this->assign( array(
				'adminres' => $addata,
				'department' => $department,
				'page' => $page,
			) );

			return view();
		}

		$this->assign( 'adminres', $addata );
		$this->assign( 'department', $department );
		$this->assign( 'page', $page );
		return view();
	}

	public

	function add() {
		$department = db( 'cate' )->order( 'id' )->select();
		if ( request()->isPost() ) {
			$data = input( 'post.' );
			$validate = \think\ Loader::validate( 'Admin' );
			if ( !$validate->scene( 'add' )->check( $data ) ) {
				$this->error( $validate->getError() );
			}
			$admin = new AdminModel();
			if ($data["type"]=="中层干部") {
				$articledata = array(
					'adminid' => $data[ "worknum" ],
				);
				$articledata[ 'time' ] = time();
				db( "article" )->insert( $articledata );
			}

			if ( $admin->addadmin( $data ) ) {
				$this->success( '添加用户成功！', url( 'lst' ) );
			} else {
				$this->error( '添加用户失败！' );
			}
			return;
		}
		$authGroupRes = db( 'auth_group' )->select();
		$this->assign( 'authGroupRes', $authGroupRes );
		$this->assign( 'department', $department );
		return view();
	}

	public

	function alladd() {
		if (request()->isPost()) {
			require(ROOT_PATH . 'vendor/PHPExcel.php');//引入PHP EXCEL类
               $data = input('post.');
               $file = request()->file('filexls');
               // 移动到框架应用根目录/public/uploads/ 目录下
               if ($file=="") {
                    $this->error('请选择数据样本');
               }
               $info = $file->validate(['ext' => 'xls,xlsx'])->move(ROOT_PATH . 'public' . DS . 'uploads');

               if ($info) {
                    $filexls2 = 'public' . DS . 'uploads' . DS . $info->getSaveName();
                    $filexls = ROOT_PATH . 'public' . DS . 'uploads' . DS . $info->getSaveName();//Excel文件路径
                    $sheet = 3;//默认表格
                    if (empty($filexls) or !file_exists($filexls)) {
                         $this->error('请选择数据样本');
                    }

                    //read
                    $PHPReader = new \PHPExcel_Reader_Excel2007();        //建立reader对象
                    if (!$PHPReader->canRead($filexls)) {
                         $PHPReader = new \PHPExcel_Reader_Excel5();
                         if (!$PHPReader->canRead($filexls)) {
                              echo 'no Excel';
                              return;
                         }
                    }
                    $PHPExcel = $PHPReader->load($filexls);        //建立excel对象
                    $currentSheet = $PHPExcel->getSheet($sheet);        //**读取excel文件中的指定工作表*/
                    $allColumn = $currentSheet->getHighestColumn();        //**取得最大的列号*/
                    $allRow = $currentSheet->getHighestRow();        //**取得一共有多少行*/
                    $excelData = array();
                    for ($rowIndex = 1; $rowIndex <= $allRow; $rowIndex++) {        //循环读取每个单元格的内容。注意行从1开始，列从A开始
                         for ($colIndex = 'A'; $colIndex <= $allColumn; $colIndex++) {
                              $addr = $colIndex . $rowIndex;
                              $cell = $currentSheet->getCell($addr)->getCalculatedValue();
                              if ($cell instanceof \PHPExcel_RichText) { //富文本转换字符串
                                   $cell = $cell->__toString();
                              }
                              $excelData[$rowIndex][$colIndex] = $cell;
                         }
                    }

                    foreach ($excelData as $k => $v) {
                    	
                         if ($k >= 2) {
                         	//ganbu。excel文件导入
                         	  // $cateid=db("cate")->where("catename",$v['F'])->find();
                         	  // $data2['group_id'] = '5';
                            //   $data2['worknum'] = $v['B'];
                            //   $data2['name'] = $v['C'];
                            //   $data2['password'] = '123456';
                            //   $data2['type'] = $v['L'];
                            //   if($cateid["id"]==""){
                            //   	$data2['cateid'] = "111111";
                            //   }
                            //   else{
                            //   	$data2['cateid'] = $cateid["id"];
                            //   }
                            //   //$res2 = db('test')->where('A', 'B')->insert($data2);
                            //   if ($data2["type"]=="中层干部") {
                            //   	$articledata = array(
                            //   		'adminid' => $data2[ "worknum" ],
                            //   		);
                            //   	$articledata[ 'time' ] = time();
                            //   	db( "article" )->insert( $articledata );
                            //   }
                         	// $admin = new AdminModel();
                         	// if ( $admin->addadmin( $data2 ) ) {
                         	// } else {
                         	// 	$this->error( '添加用户失败！' );
                         	// }
                              //END

                              //试用期干部导入
                         	$cateid=db("cate")->where("catename",$v['C'])->find();
                         	  
                              $data2['worknum'] = $v['A'];
                              $data2['name'] = $v['B'];
                              $data2['password'] = $v['D'];
                              if($data2['password']){
                              	$data2['password']=md5($data2['password']);
                              }
                              if($cateid["id"]==""){
                              	$data2['cateid'] = "111111";
                              }
                              else{
                              	$data2['cateid'] = $cateid["id"];
                              }
                              $exist=db('admin')->where('worknum',$data2['worknum'])->find();
                              // dump($exist);
                              // dump($data2);
                             if($exist){
                             	unset($data2['group_id']);  
                             	unset($data2['type']); 
                             	db('admin')->where('id', $exist["id"])->update($data2);
                             }
                             else{
                             	$admin = new AdminModel();
                             	$data2['group_id'] = '5';
                             	$data2['type'] = '普通教职工';
                             	$admin->addadmin( $data2);
                             }
                              //END
                              
                         }

                    }
                    return view();
               } 
               else {
                    $this->error('上传数据失败');
               }

		}
		return view();
	}

	public

	function edit( $id ) {
		$admins = db( 'admin' )->find( $id );

		if ( request()->isPost() ) {
			$data = input( 'post.' );
			$validate = \think\ Loader::validate( 'Admin' );
			if ( !$validate->scene( 'edit' )->check( $data ) ) {
				$this->error( $validate->getError() );
			}
			$admin = new AdminModel();
			$savenum = $admin->saveadmin( $data, $admins );
			if ($data["type"]=="中层干部"&&$admins["type"]!="中层干部") {                       //改成中层干部 添加数据到article表
				$articledata = array(
					'adminid' => $data[ "worknum" ],
				);
				$articledata[ 'time' ] = time();
				db( "article" )->insert( $articledata );
			}
			elseif ($data["type"]!="中层干部"&&$admins["type"]=="中层干部") {                  //从中层干部改成其他类型 从article表删除数据
				$img=db( "article" )->where('adminid',$data["worknum"])->find();
				$thumbpath=$_SERVER['DOCUMENT_ROOT'].$img['img'];
                if(file_exists($thumbpath)){
                	@unlink($thumbpath);
                }
				db( "article" )->where('adminid',$data["worknum"])->delete();
				db( "jianli" )->where('adminid',$data["worknum"])->delete();
				db( "gbedu" )->where('adminid',$data["worknum"])->delete();
				db( "homeb" )->where('adminid',$data["worknum"])->delete();

			}
			if ( $savenum == '2' ) {
				$this->error( '用户名不得为空！' );
			}
			if ( $savenum !== false ) {
				$this->success( '修改成功！', url( 'lst' ) );
			} else {
				$this->error( '修改失败！' );
			}
			return;
		}

		if ( !$admins ) {
			$this->error( '该用户不存在' );
		}
		$authGroupAccess = db( 'auth_group_access' )->where( array( 'uid' => $id ) )->find();
		$authGroupRes = db( 'auth_group' )->select();
		$department = db( 'cate' )->order( 'id' )->select();
		$this->assign( 'department', $department );
		$this->assign( 'authGroupRes', $authGroupRes );
		$this->assign( 'admin', $admins );
		$this->assign( 'groupId', $authGroupAccess[ 'group_id' ] );
		return view();
	}
	public

	function editpassword( $id ) {
		
		$admins = db( 'admin' )->find( $id );
		

		if ( request()->isPost() ) {
			$data = input( 'post.' );
			
			$data['worknum'] = $data['worknum'];//dump($admins);die;
			$data['password'] = $data['password'];//dump($data);die;
	
			$admin = new AdminModel();
			$savenum = $admin->saveapassword( $data, $admins );
			//dump($savenum);die;
			if ( $savenum == '2' ) {
				$this->error( '用户名不得为空！' );
			}
			if ( $savenum !== false ) {
				$this->success( '修改成功！', url( '/admin' ) );
			} else {
				$this->error( '修改失败！' );
			}
			return;
		}

		if ( !$admins ) {
			$this->error( '该用户不存在' );
		}
		$this->assign( 'admin', $admins );
		return view();
	}

	public

	function del( $id ) {
		$admin = new AdminModel();
		$delnum = $admin->deladmin( $id );
		if ( $delnum == '1' ) {
			$this->success( '删除用户成功！', url( 'lst' ) );
		} else {
			$this->error( '删除用户失败！' );
		}
	}

	public

	function logout() {
		session( null );
		$this->success( '退出系统成功！', url( 'login/index' ) );
	}
    public function record()
    {
         $record=db('login')->where('worknum',session('worknum'))->order('time desc')->limit(20)->select();
         
         $this->assign('record',$record);
        return view();
    }

}