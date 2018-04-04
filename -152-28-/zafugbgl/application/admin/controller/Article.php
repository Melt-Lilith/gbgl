<?php
namespace app\admin\controller;
use app\ admin\ model\ Cate as CateModel;
use app\ admin\ model\ Article as ArticleModel;
use app\ admin\ model\ Gbedu as GbeduModel;
use app\ admin\ model\ Jianli as JianliModel;
  use app\ admin\ model\ Homeb as HomebModel;
use app\ admin\ controller\ Common;
class Article extends Common {

	public
	function lst() {
		$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.id,b.sort,b.job,b.birthday,b.niandu,b.peixun,b.shuzhi,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where('a.type',"中层干部")->order( 'b.sort,a.cateid,a.worknum' )->paginate( 50 );
		$department = db( 'cate' )->order( 'id' )->select();
		$this->assign( array(
			'artres' => $artres,
			'department' => $department,
		) );

		if ( request()->isPost() ) {
			$data = input( 'post.' );
			if ( $data[ "part" ] == 0 && $data[ "information" ] == "" ) {
				$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.birthday,b.job,b.sort,b.id,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where('a.type',"中层干部")->order( 'a.cateid,b.sort,a.worknum' )->paginate( 50 );
			} 
			elseif ( $data[ "part" ] == 0 ) {
				if ( $data[ "selectway" ] == "name" ) {
					$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.birthday,b.job,b.sort,b.id,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where('a.type',"中层干部")->order( 'a.cateid,b.sort,a.worknum' )->where( 'a.name', $data[ "information" ] )->paginate( 50 );
				} 
				elseif ( $data[ "selectway" ] == "worknum" ) {
					$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.birthday,b.job,b.sort,b.id,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where('a.type',"中层干部")->order( 'a.cateid,b.sort,a.worknum' )->where( 'a.worknum', $data[ "information" ] )->paginate( 50 );
				}
			} 
			else {
				$i = $data[ "part" ];
				if ( $data[ "selectway" ] == "name"  && $data["information"]=="") {
					$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.birthday,b.job,b.sort,b.id,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where('a.type',"中层干部")->order( 'a.cateid,b.sort,a.worknum' )->where( 'a.cateid', $i )->paginate( 50 );
				} 
				elseif ($data[ "selectway" ] == "name") {
					$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.birthday,b.job,b.sort,b.id,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where('a.type',"中层干部")->order( 'a.cateid,b.sort,a.worknum' )->where( 'a.name', $data[ "information" ] )->where( 'a.cateid', $i )->paginate( 50 );
				}
				elseif ( $data[ "selectway" ] == "worknum" ) {
					$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.birthday,b.job,b.sort,b.id,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where('a.type',"中层干部")->order( 'a.cateid,b.sort,a.worknum' )->where( 'a.worknum', $data[ "information" ] )->where( 'a.cateid', $i )->paginate( 50 );
				}
			}
			$this->assign( array(
				'artres' => $artres,
				'department' => $department,
			) );

			return view();
		}

		return view();
	}
	
	public
	function show() {
		$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.id,b.sort,b.job,b.birthday,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where('a.type',"中层干部")->order( 'a.cateid,b.sort,a.worknum' )->paginate( 50 );
		$department = db( 'cate' )->order( 'id' )->select();
		$this->assign( array(
			'artres' => $artres,
			'department' => $department,
		) );

		if ( request()->isPost() ) {
			$data = input( 'post.' );
			$i=0;
			foreach($data as $value){
			$artres2[$i]= $artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.id,b.sort,b.job,b.birthday,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where('a.type',"中层干部")->order( 'a.cateid,b.sort,a.worknum' )->where('b.id', $value)->find();
			$i++;
			}
			$department = db( 'cate' )->order( 'id' )->select();
			$this->assign( array(
			'artres' => $artres2,
			'department' => $department,
			) );
			return view("article/show");
		}

		return view("article/show");
	}
  public function my1(){
    $data = input( 'post.' );
    $department = db( 'cate' )->order( 'id' )->select();
      if ( $data[ "part" ] == 0 && $data[ "information" ] == "" ) {
        $artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.birthday,b.job,b.sort,b.id,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where('a.type',"中层干部")->order( 'a.cateid,b.sort,a.worknum' )->paginate( 50 );
      } 
      elseif ( $data[ "part" ] == 0 ) {
        if ( $data[ "selectway" ] == "name" ) {
          $artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.birthday,b.job,b.sort,b.id,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where('a.type',"中层干部")->order( 'a.cateid,b.sort,a.worknum' )->where( 'a.name', $data[ "information" ] )->paginate( 50 );
        } 
        elseif ( $data[ "selectway" ] == "worknum" ) {
          $artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.birthday,b.job,b.sort,b.id,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where('a.type',"中层干部")->order( 'a.cateid,b.sort,a.worknum' )->where( 'a.worknum', $data[ "information" ] )->paginate( 50 );
        }
      } 
      else {
        $i = $data[ "part" ];
        if ( $data[ "selectway" ] == "name"  && $data["information"]=="") {
          $artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.birthday,b.job,b.sort,b.id,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where('a.type',"中层干部")->order( 'a.cateid,b.sort,a.worknum' )->where( 'a.cateid', $i )->paginate( 50 );
        } 
        elseif ($data[ "selectway" ] == "name") {
          $artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.birthday,b.job,b.sort,b.id,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where('a.type',"中层干部")->order( 'a.cateid,b.sort,a.worknum' )->where( 'a.name', $data[ "information" ] )->where( 'a.cateid', $i )->paginate( 50 );
        }
        elseif ( $data[ "selectway" ] == "worknum" ) {
          $artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.birthday,b.job,b.sort,b.id,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where('a.type',"中层干部")->order( 'a.cateid,b.sort,a.worknum' )->where( 'a.worknum', $data[ "information" ] )->where( 'a.cateid', $i )->paginate( 50 );
        }
      }
      $this->assign( array(
        'artres' => $artres,
        'department' => $department,
      ) );

      return view('mysort');
  }

	public
	function mysort() {
		$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.id,b.sort,b.job,b.birthday,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where('a.type',"中层干部")->order( 'a.cateid,b.sort,a.worknum' )->paginate( 50 );
		$department = db( 'cate' )->order( 'id' )->select();
		$this->assign( array(
			'artres' => $artres,
			'department' => $department,
		) );

		if ( request()->isPost() ) {
			$sorts = input( 'post.' );
			foreach ( $sorts as $k => $v ) {
				db( "article" )->update( [ 'id' => $k, 'sort' => $v ] );
			}
			$this->success( '更新排序成功！', url( 'mysort' ) );
			$artres = db( 'admin' )->field( 'a.worknum,a.name,a.type,a.cateid,b.id,b.sort,b.job,b.birthday,c.catename ' )->alias( 'a' )->join( 'gb_article b', 'a.worknum=b.adminid' )->join( 'gb_cate c', 'c.id=a.cateid' )->where('a.type',"中层干部")->order( 'a.cateid,b.sort,a.worknum' )->paginate( 50 );
			$department = db( 'cate' )->order( 'id' )->select();
			$this->assign( array(
				'artres' => $artres,
				'department' => $department,
			) );

			return view();
		}

		return view();
	}

	public
	function add() {
		if ( request()->isPost() ) {
			$data = input( 'post.' );
			$data[ 'time' ] = time();
			// $file = request()->file( 'img' );
			// 移动到框架应用根目录/public/uploads/ 目录下
			// $info = $file->validate( [ 'ext' => 'jpg,png' ] )->move( ROOT_PATH . 'public' . DS . 'uploads' );

			// if ( $info ) {
			// 	$filexls2 = 'public' . DS . 'uploads' . '/' . $info->getSaveName();
			// 	$filexls = ROOT_PATH . 'public' . DS . 'uploads' . '/' . $info->getSaveName(); //文件路径
			// 	if ( empty( $filexls )or!file_exists( $filexls ) ) {
			// 		$this->error( '请选择照片' );
			// 	}
			// 	$data[ 'img' ] = $filexls2;
			// }
			if ( db( 'article' )->insert( $data ) ) {
				$this->success( '添加干部信息成功', url( 'lst' ) );
			} else {
				$this->error( '添加干部信息失败！' );
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
	public
	function table() {
		

		return view();
	}

public
	function mysearch() {
		$cate=db('cate')->select();
        if (request()->isPost())
        {
        	$post=input('post.');	
        	if($post['cateid']=="#")
        		$post['cateid']='';
        	if($post['sex']=="#")
        		$post['sex']='';
        	if($post['jiguan_p']=="--选择省--")
        		$post['jiguan_p']='';
        	else
        		$post['jiguan_p']=str_replace("省","",$post['jiguan_p']);
        	if($post['jiguan_c']=="--选择市--")
        		$post['jiguan_c']='';
        	else
        		$post['jiguan_c']=str_replace("市","",$post['jiguan_c']);

        	if($post['politics']=="#")
        		$post['politics']='';
        	if($post['edubg']=="#")
        		$post['edubg']='';
        	if($post['ptitle']=="#")
        		$post['ptitle']='';
        	if($post['jobtime1']=="#")
        		$post['jobtime1']='';
        	if($post['alljobtime1']=="#")
        		$post['alljobtime1']='';
        	if($post['birthday1']=="#")
        		$post['birthday1']='';
          if($post['degree']=="#")
            $post['degree']='';
          //学位
        	$res=db('cha')->where("name like '%".$post['name']."%'")->where("worknum like '%".$post['worknum']."%'")->where("cateid like '%".$post['cateid']."%'")->where("sex like '%".$post['sex']."%'")->where("jiguan_p like '%".$post['jiguan_p']."%'")->where("jiguan_c like '%".$post['jiguan_c']."%'")->where("politics like '%".$post['politics']."%'")->where("edubg like '%".$post['edubg']."%'")->where("ptitle like '%".$post['ptitle']."%'")->where("ptitle like '%".$post['degree']."%'")->select();
      
           foreach($res as $k=>&$r)
           {
               $cn=db('cate')->find($r['cateid']);
               $r['catename']=$cn['catename'];
           	   if($post['jobtime1']==">")        //任现职时间
           	   {
           	   	if(strtotime($post['jobtime'])>=strtotime($r['jobtime']))
           	   	{
                     unset($res[$k]);
           	   	}
           	   }
                if($post['jobtime1']=="<")
           	   {
           	   	if(strtotime($post['jobtime'])<=strtotime($r['jobtime']))
           	   	{
                     unset($res[$k]);
           	   	}
           	   }
           	    if($post['jobtime1']=="=")
           	   {
           	   	if(strlen($post['jobtime'])<=5)
           	   	{
           	     if(strtotime($post['jobtime'])-10*2592000>strtotime($r['jobtime'])||strtotime($r['jobtime'])>strtotime($post['jobtime'])+2*2592000)
           	   	{
                     unset($res[$k]);
           	   	}
           	   }
           	   else
           	   {
           	   	if(strtotime($post['jobtime'])>strtotime($r['jobtime'])||strtotime($r['jobtime'])>strtotime($post['jobtime'])+2592000)
           	   	{
                     unset($res[$k]);
           	   	}
           	   }
           	   }



           	    if($post['alljobtime1']==">")                  //工作时间
           	   {
           	   	if(strtotime($post['alljobtime'])>=strtotime($r['alljobtime']))
           	   	{
                     unset($res[$k]);
           	   	}
           	   }
                if($post['alljobtime1']=="<")
           	   {
           	   	if(strtotime($post['alljobtime'])<=strtotime($r['alljobtime']))
           	   	{
                     unset($res[$k]);
           	   	}
           	   }
           	    if($post['alljobtime1']=="=")
           	   {
           	   	if(strlen($post['alljobtime'])<=5)
           	   	{
           	     if(strtotime($post['alljobtime'])-10*2592000>strtotime($r['alljobtime'])||strtotime($r['alljobtime'])>strtotime($post['alljobtime'])+2*2592000)
           	   	{
                     unset($res[$k]);
           	   	}
           	   }
           	   else
           	   {
           	   	if(strtotime($post['alljobtime'])>strtotime($r['alljobtime'])||strtotime($r['alljobtime'])>strtotime($post['alljobtime'])+2592000)
           	   	{
                     unset($res[$k]);
           	   	}
           	   }
           	   }



           	    if($post['birthday1']==">")                  //出生日期
           	   {
           	   	if(strtotime($post['birthday'])>=strtotime($r['birthday']))
           	   	{
                     unset($res[$k]);
           	   	}
           	   }
                if($post['birthday1']=="<")
           	   {
           	   	if(strtotime($post['birthday'])<=strtotime($r['birthday']))
           	   	{
                     unset($res[$k]);
           	   	}
           	   }
           	    if($post['birthday1']=="=")
           	   {
           	   	if(strlen($post['birthday'])<=5)
           	   	{
           	     if(strtotime($post['birthday'])-10*2592000>strtotime($r['birthday'])||strtotime($r['birthday'])>strtotime($post['birthday'])+2*2592000)
           	   	{
                     unset($res[$k]);
           	   	}
           	   }
           	   else
           	   {
           	   	if(strtotime($post['birthday'])>strtotime($r['birthday'])||strtotime($r['birthday'])>strtotime($post['birthday'])+2592000)
           	   	{
                     unset($res[$k]);
           	   	}
           	   }
           	   }
           }


          
         $this->assign('res',$res);
             return view('cha');
        }
        $this->assign('cate',$cate);
		return view();
	}


	public	function alladd() {
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
                    $sheet = 2;//默认表格
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
                    	if ($k >2) {
                    		$uid=db('admin')->field('worknum')->where('name',$v['B'])->find();
                    		$aid=db('article')->field('id')->where('adminid',$uid["worknum"])->find();
                    		$data2['id']=$aid["id"];
                    		$data2['adminid']=$uid["worknum"];
                    		$data2['sex'] = $v['D'];
                    		$data2['birthday'] = $v['E'];
                    		$data2['jiguan_p'] = $v['F'];
                    		$data2['jiguan_c'] = $v['G'];
                    		$data2['chushengdi_p'] = $v['F'];
                    		$data2['chushengdi_c'] = $v['G'];
                    		$data2['politics'] = "中共党员";
                    		$data2['job'] = $v['C'];
                    		$data2['zhiji'] = $v['Q'];
                    		$data2['jobtime'] = $v['N'];
                    		$data2['ranktime'] = $v['O'];
                    		$data2['alljobtime'] = $v['H'];
                    		$data2['joinpartytime'] = $v['I'];
                    		$data2['edubg'] = $v['J'];
                    		$data2['degree'] = $v['K'];
                    		$data2['ptitle'] = $v['L'];
                    		$data2['health'] = "健康";
                    		$data2['specialjob'] = $v['M'];
                    		$data2['specialskill'] = $v['P'];
                    		$article = new ArticleModel;
                    		if ( $article->where('id',$aid["id"])->update( $data2 ) ) {

                    		} else {
                    			dump($aid["id"]);
                    			dump($uid["worknum"]);
                    		}
                    	}

                    }
               } 
               else {
                    $this->error('上传数据失败');
               }

		}
		return view();
	}


	public
	function edit() {
		$id=input('id');
    $app=input('app');
    //是否管理员 有app管理员 无app普通用户
   $arts = db( 'article' )->where( array( 'id' => input( 'id' ) ) )->find();
  
    if($app)
    {
      $arts1=db('article2')->where('adminid',$arts['adminid'])->find();
    }
    else
        $arts1=$arts;
		
		if ( request()->isPost() ) {
			$data = input( 'post.' );
			$validate = \think\ Loader::validate( 'Article' );
			if ( !$validate->scene( 'edit' )->check( $data ) ) {
				$this->error( $validate->getError() );
			}
			if (request()->file( 'img' )) {														//更新一寸照
				$file = request()->file( 'img' );
				// 移动到框架应用根目录/public/uploads/ 目录下
				$info = $file->validate( [ 'ext' => 'jpg,png' ] )->move( ROOT_PATH . 'public' . DS . 'uploads' );
				
			
				if ( $info ) {
					$filexls2 = 'public' . DS . 'uploads' . '/' . $info->getSaveName();
					$filexls = ROOT_PATH . 'public' . DS . 'uploads' . '/' . $info->getSaveName(); //文件路径
					if ( empty( $filexls )or!file_exists( $filexls ) ) {
					$this->error( '请选择照片' );
					}
					$data[ 'img' ] = $filexls2;
				}
			}
			$article = new ArticleModel;
			//防止时间变成   --空值--
			if($data["birthday"]==""){
				$data["birthday"]=$arts["birthday"];
			}
			if($data["jobtime"]==""){
				$data["jobtime"]=$arts["jobtime"];
			}
			if($data["ranktime"]==""){
				$data["ranktime"]=$arts["ranktime"];
			}
			if($data["alljobtime"]==""){
				$data["alljobtime"]=$arts["alljobtime"];
			}
			if($data["joinpartytime"]==""){
				$data["joinpartytime"]=$arts["joinpartytime"];
			}
			//END



			//防止籍贯和出生地变成   --选择X--
			if($data["jiguan_p"]=="--选择省--"){
				$data["jiguan_p"]=$arts["jiguan_p"];
			}
			if($data["jiguan_c"]=="--选择市--"){
				$data["jiguan_c"]=$arts["jiguan_c"];
			}
			if($data["chushengdi_p"]=="--选择省--"){
				$data["chushengdi_p"]=$arts["chushengdi_p"];
			}
			if($data["chushengdi_c"]=="--选择市--"){
				$data["chushengdi_c"]=$arts["chushengdi_c"];
			}
			//END
      $per=db('auth_group_access')->where('uid',session('id'))->find();
      if($per['group_id']==1)
      { 
        if($app)
        { 
         
              db('approval')->where('adminid',$arts['adminid'])->where('type',1)->update(['status'=>1]);
              db('message')->insert(['title'=>"您的修改申请已通过",'date'=>Time(),'worknum'=>$arts['adminid']]);
            }
        $data['id']=$id;
      if ( $article->update( $data )) {
        $this->success( '修改干部信息成功！', url( 'edit',array('id'=>$id  ) ) );
      } else {
        $this->error( '修改干部信息失败！' );
      }
      }
     else 
      {
       $data['adminid']=session('worknum');
        $data['message']=0;
        $data['time']=Time();
        unset($data['id']);
        db('approval')->insert(['adminid'=>$data['adminid'],'time'=>Time(),'type'=>1]);
         if(db('article2')->insert( $data)){
        $this->success( '修改干部信息成功！请等待审核', url( 'edit',array('id'=>$id  ) ) );
      } 
      else {
        $this->error( '修改干部信息失败！' );
      }
      }

			return;
		}
		$this->assign( array(
      'app'=>$app,
      'arts1'=>$arts1,
			'arts' => $arts,
			'id' => $id,
		) );
		return view();
	}
	
	
	public
	function edit2() {
		$id=input('id');
		$worknum = db( 'article' )->field( 'adminid' )->where( array( 'id' => input( 'id' ) ) )->find();
    $app=input('app');
      $arts= db("gbedu")->where('adminid',$worknum['adminid'])->find();
     if($app)
    {
      $arts1=db("gbedu2")->where('adminid',$worknum['adminid'])->find();
       
    }
    else
      $arts1=$arts;
	
		if ( request()->isPost() ) {
			$data = input( 'post.' );
			$gbedu = new GbeduModel;
			$data["adminid"]=$worknum["adminid"];

      $per=db('auth_group_access')->where('uid',session('id'))->find();
      if($per['group_id']==1)
			{if($arts){
              $data["id"]=$arts["id"];
              $save = $gbedu->update( $data );
            }
            else{
              $save = $gbedu->save( $data );
            }
      
            if ( $save ) 
            {
              if($app)
          { 
              db('approval')->where('adminid',$arts['adminid'])->where('type',2)->update(['status'=>1]);
             db('message')->insert(['title'=>"您的修改申请已通过",'date'=>Time(),'worknum'=>$arts['adminid']]);
            }
              $this->success( '修改干部信息成功！', url( 'edit2',array('id'=>$id  ) )   );
            } else { 
              $this->error( '修改干部信息失败！' );
            }
      }
      else
      { 
        $data['adminid']=session('worknum');
        $data['message']=0;
         $data['time']=Time();
           unset($data['id']);
            db('approval')->insert(['adminid'=>$data['adminid'],'time'=>Time(),'type'=>2]);
            if ( db('gbedu2')->insert($data) ) {
              $this->success( '修改干部信息成功！请等待审核', url( 'edit2',array('id'=>$id  ) )   );
            } else { 
              $this->error( '修改干部信息失败！' );
            }
      }

			return;
		}
		$this->assign( array(
      'app'=>$app,
      'arts1'=>$arts1,
			'arts' => $arts,
			'id' => $id,
		) );
		return view("article/edit2");
	}
	public
	function edit3() {
		$id=input('id');
    $app=input('app');
		$worknum = db( 'article' )->field( 'adminid' )->where( array( 'id' => input( 'id' ) ) )->find();
$arts= db("jianli")->where('adminid',$worknum['adminid'])->order('starttime')->select();
    if($app)
    {
      $arts1= db("jianli2")->where('adminid',$worknum['adminid'])->order('starttime')->select();
      
    }
    else
      $arts1=$arts;
		
		$maxid= db ('jianli')->where('adminid',$worknum['adminid'])->max('id');
		if ( request()->isPost() ) {
			$data = input( 'post.' );
    //  dump($data);die;
			$jianli = new JianliModel;
			$save="";
       $per=db('auth_group_access')->where('uid',session('id'))->find();
       if($per['group_id']==1)
			{
        db('jianli')->where('adminid',$worknum["adminid"])->delete();
        foreach ($data as &$j) {
            unset($j['id']);
            if(!$arts)
            {
              $j['adminid']=$worknum['adminid'];
            }
           $j['adminid']=(isset($j['adminid'])? $j['adminid']:$worknum['adminid']);
            $save=db('jianli')->insert($j);
        }
      //  dump($data);die;
        // foreach ($data as $key => $value) {
        //       if(db('jianli')->where('id',$key)->find()   ){
        //         // echo "1";
        //         $save = $jianli->where('adminid',$worknum["adminid"])->delete();
        //         $value["adminid"]=$worknum["adminid"];
        //         $save=db('jianli')->insert($value);
        //       }
        //       elseif ($value["starttime"]||$value["endtime"]||$value["information"]) {
        //         // echo "2";
        //         $value["adminid"]=$worknum["adminid"];
        //         $save=db('jianli')->insert($value);
        //       }
        //       else{
        //         // echo "3";
        //       }
      
      
        //     }
            if ( $save ) 
            {
              if($app)
              {
              db('approval')->where('adminid',$worknum['adminid'])->where('type',3)->update(['status'=>1]);
              db('message')->insert(['title'=>"您的修改申请已通过",'date'=>Time(),'worknum'=>$worknum['adminid']]);
            }
              $this->success( '修改干部信息成功！',url( 'edit3',array('id'=>$id  ) ) );
            } else {
              $this->error( '修改干部信息失败！' );
            }
            return;
          }
            else
            { 
              foreach($data as &$d)
              {
                $d['adminid']=session('worknum');
        $d['message']=0;
         $d['time']=Time();
        unset($d['id']);
         db('approval')->insert(['adminid'=>$d['adminid'],'time'=>Time(),'type'=>3]);
              }
              if(db('jianli2')->insertAll($data))
               {  $this->success( '修改干部信息成功！请等待审核',url( 'edit3',array('id'=>$id  ) ) );}
               else {
              $this->error( '修改干部信息失败！' );
            }
            }
		}
		$this->assign( array(
      'app'=>$app,
      'arts1'=>$arts1,
			'arts' => $arts,
			'id' => $id,
			'maxid' => $maxid,
		) );
		return view();
	}

	public
	function edit4() {
		$id=input('id');
    $app=input('app');
		$worknum = db( 'article' )->field( 'adminid' )->where( array( 'id' => input( 'id' ) ) )->find();
    $arts= db('homeb')->where('adminid',$worknum['adminid'])->select();
      if($app)
      {
        $arts1= db('homeb2')->where('adminid',$worknum['adminid'])->select();
         $this->assign('arts1',$arts1);
      }
      else
        $arts1=$arts;
		
		$maxid= db ('homeb')->where('adminid',$worknum['adminid'])->max('id');
		
		if ( request()->isPost() ) {
			$data = input( 'post.' );
    //  dump($data);die;
			$homeb = new HomebModel;
			$save="";
       $per=db('auth_group_access')->where('uid',session('id'))->find();
       if($per['group_id']==1)
     { // dump($data);die;
           // foreach ($data as $key => $value) {
           //   if(db('homeb')->where('id',$key)->find()   ){
           //     // echo "1";
           //     $save = $homeb->where('adminid',$worknum["adminid"])->delete();
     
           //     $value["adminid"]=$worknum["adminid"];
           //     db('homeb')->insert($value);
     
           //   }
     
           //   elseif ($value["name"]||$value["birthday"]||$value["party"]||$value["workpalce"]) {
           //     // echo "2";
           //     $value["adminid"]=$worknum["adminid"];
           //     $save = db('homeb')->insert($value);
           //   }
           //   else{
           //     // echo "3";
           //   }
     
     
           // }
     db('homeb')->where('adminid',$worknum["adminid"])->delete();
        foreach ($data as &$h) {
            unset($h['id']);
            $h['adminid']=(isset($j['adminid'])? $h['adminid']:$worknum['adminid']);
            $save=db('homeb')->insert($h);
        }
     
           if ( $save ) {
            if($app)
              {
              db('approval')->where('adminid',$worknum['adminid'])->where('type',4)->update(['status'=>1]);
               db('message')->insert(['title'=>"您的修改申请已通过",'date'=>Time(),'worknum'=>$worknum['adminid']]);
            }
             $this->success( '修改干部信息成功！',url( 'edit4',array('id'=>$id  ) ) );
           } else {
             $this->error( '修改干部信息失败！' );
           }
           return; 
            }
            else
            {
              foreach($data as &$d)
              {
                $d['adminid']=session('worknum');
        $d['message']=0;
         $d['time']=Time();
        unset($d['id']);
         db('approval')->insert(['adminid'=>$d['adminid'],'time'=>Time(),'type'=>4]);
              }
                if (db('homeb2')->insertAll($data)) {
             $this->success( '修改干部信息成功！请等待审核',url( 'edit4',array('id'=>$id  ) ) );
           } else {
             $this->error( '修改干部信息失败！' );
           }
            }

		}
		
		$this->assign( array(
      'app'=>$app,
      'arts1'=>$arts1,
			'arts' => $arts,
			'id' => $id,
			'maxid' => $maxid,
		) );
		return view();
	}







	public
	function changeimg() {													//修改一寸照专用
		$arts = db( 'article' )->where( array( 'id' => input( 'id' ) ) )->find();
		if ( request()->isPost() ) {
			$data = input( 'post.' );
			$validate = \think\ Loader::validate( 'Article' );
			if ( !$validate->scene( 'edit' )->check( $data ) ) {
				$this->error( $validate->getError() );
			}
			$file = request()->file( 'img' );
			// 移动到框架应用根目录/public/uploads/ 目录下
			$info = $file->validate( [ 'ext' => 'jpg,png' ] )->move( ROOT_PATH . 'public' . DS . 'uploads' );
			if ( $info ) {
				$filexls2 = 'public' . DS . 'uploads' . '/' . $info->getSaveName();
				$filexls = ROOT_PATH . 'public' . DS . 'uploads' . '/' . $info->getSaveName(); //文件路径
				if ( empty( $filexls )or!file_exists( $filexls ) ) {
					$this->error( '请选择照片' );
				}
				$data[ 'img' ] = $filexls2;
			}
			$article = new ArticleModel;
			$save = $article->update( $data );
			if ( $save ) {
				$this->success( '修改干部信息成功！', url( 'edit' ,array('id'=>$arts['id']) ) );
			} else {
				$this->error( '修改干部信息失败！' );
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

  public
  function uploadfile() {                          //上传必要文件
    $arts = db( 'article' )->where( array( 'id' => input( 'id' ) ) )->find();//dump($arts);die;
    if ( request()->isPost() ) {
      $data = input( 'post.' );
      $validate = \think\ Loader::validate( 'Article' );
      if ( !$validate->scene( 'edit' )->check( $data ) ) {
        $this->error( $validate->getError() );
      }


      //年度考核登记表上传

      $file = request()->file( 'niandu' );
      if($file)
      {
      // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->validate( [ 'ext' => 'doc,docx,pdf' ] )->move( ROOT_PATH . 'public' . DS . 'uploads',true,false );
        if ( $info ) {
          $filexls2 = 'public' . DS . 'uploads' . '/' . $info->getSaveName();
          $filexls = ROOT_PATH . 'public' . DS . 'uploads' . '/' . $info->getSaveName(); //文件路径
          if ( empty( $filexls )or!file_exists( $filexls ) ) {
            $this->error( '请选择文件' );
          }
          $data[ 'niandu' ] = $filexls2;
        }
      }
      //END

      //培训情况登记表上传
      $file2 = request()->file( 'peixun' );
      if($file2)
      {
      // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file2->validate( [ 'ext' => 'doc,docx,pdf' ] )->move( ROOT_PATH . 'public' . DS . 'uploads2',true,false );
        if ( $info ) {
          $filexls2 = 'public' . DS . 'uploads2' . '/' . $info->getSaveName();
          $filexls = ROOT_PATH . 'public' . DS . 'uploads2' . '/' . $info->getSaveName(); //文件路径
          if ( empty( $filexls )or!file_exists( $filexls ) ) {
            $this->error( '请选择文件' );
          }
          $data[ 'peixun' ] = $filexls2;
        }
      }
      //END

      //述职述廉报告上传
      $file3 = request()->file( 'shuzhi' );
      if($file3)
      {
      // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file3->validate( [ 'ext' => 'doc,docx,pdf' ] )->move( ROOT_PATH . 'public' . DS . 'uploads3',true,false );
        if ( $info ) {
          $filexls2 = 'public' . DS . 'uploads3' . '/' . $info->getSaveName();
          $filexls = ROOT_PATH . 'public' . DS . 'uploads3' . '/' . $info->getSaveName(); //文件路径
          if ( empty( $filexls )or!file_exists( $filexls ) ) {
            $this->error( '请选择文件' );
          }
          $data[ 'shuzhi' ] = $filexls2;
        }
      }
      //END


      $article = new ArticleModel;
    //dump($data);die;
      $save = $article->update( $data );
      if ( $save ) {
        //$this->success( '上传文件成功！',  url( 'edit' ,array('id'=>$arts['id']) ));    //返回编辑页
        $this->success( '上传文件成功！',  url( 'index/index' ));    //返回首页
      } else {
        $this->error( '上传文件失败！' );
      }
      return;
    }
    $cate = new CateModel();
    $cateres = $cate->catetree();
    //dump($arts);die;
    $this->assign( array(
      'cateres' => $cateres,
      'arts' => $arts,
    ) );
    return view();
  }



	public
	function del() {
		if ( ArticleModel::destroy( input( 'id' ) ) ) {
			$this->success( '删除干部信息成功！', url( 'lst' ) );
		} else {
			$this->error( '删除干部信息失败！' );
		}
	}

	public
	function export() {
		 $exceldata = db('article')->field( 'a.*,b.name' )->alias('a')->join( 'gb_admin b', 'b.worknum=a.adminid' )->select();
          $data = array();
          foreach ($exceldata as $k => $goods_info) {
               $goods_info['jiguan']=$goods_info['jiguan_p'].$goods_info['jiguan_c'];
               $goods_info['chushengdi']=$goods_info['chushengdi_p'].$goods_info['chushengdi_c'];
               $data[$k]['B'] = $goods_info['name'];
               $data[$k]['C'] = $goods_info['job'];
               $data[$k]['D'] = $goods_info['sex'];
               $data[$k]['E'] = $goods_info['birthday'];
               $data[$k]['F'] = $goods_info['jiguan'];
               $data[$k]['G'] = $goods_info['alljobtime'];
               $data[$k]['H'] = $goods_info['joinpartytime'];
               $data[$k]['I'] = $goods_info['edubg'];
               $data[$k]['J'] = $goods_info['degree'];
               $data[$k]['K'] = $goods_info['ptitle'];
               $data[$k]['L'] = '';
               $data[$k]['M'] = $goods_info['specialjob'];
               $data[$k]['N'] = $goods_info['jobtime'];
               $data[$k]['O'] = $goods_info['ranktime'];
               $data[$k]['P'] = $goods_info['specialskill'];
               $data[$k]['Q'] = $goods_info['zhiji'];
               $data[$k]['R'] = $goods_info['adminid'];
               $data[$k]['S'] = $goods_info['chushengdi'];
               $data[$k]['T'] = $goods_info['politics'];
               $data[$k]['U'] = $goods_info['health'];
               $data[$k]['V'] = $goods_info['jiangcheng'];
               $data[$k]['V'] = $goods_info['jieguo'];
          }

          $filename = '干部汇总' . time();
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


          $objActSheet->mergeCells('A1:W1');      // A1:G1合并
          $objActSheet->setCellValue('A1', '浙江农林大学干部汇总');

          $objActSheet->setCellValue('A2', '序号');
          $objActSheet->setCellValue('B2', '姓名');
          $objActSheet->setCellValue('C2', '职务');
          $objActSheet->setCellValue('D2', '性别');
          $objActSheet->setCellValue('E2', '出生日期');
          $objActSheet->setCellValue('F2', '籍贯');
          $objActSheet->setCellValue('G2', '工作时间');
          $objActSheet->setCellValue('H2', '入党时间');
          $objActSheet->setCellValue('I2', '学历');
          $objActSheet->setCellValue('J2', '学位');
          $objActSheet->setCellValue('K2', '职称');
          $objActSheet->setCellValue('L2', 'ZC');
          $objActSheet->setCellValue('M2', '专业或专长');
          $objActSheet->setCellValue('N2', '任现职时间');
          $objActSheet->setCellValue('O2', '任现级时间');
          $objActSheet->setCellValue('P2', '备注');
          $objActSheet->setCellValue('Q2', '职级');

          $objActSheet->setCellValue('R2', '工号');
          $objActSheet->setCellValue('S2', '出生地');
          $objActSheet->setCellValue('T2', '政治面貌');
          $objActSheet->setCellValue('U2', '健康状况');
          $objActSheet->setCellValue('V2', '奖惩情况');
          $objActSheet->setCellValue('W2', '考核结果');
          
          





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

     public function gbspb($id='19900007')
     {
     	$ar = db('article')->where('adminid',$id)->find();
     	$year = date("Y") - $ar['birthday'];
     	//dump($year);
      vendor('XXX');




      
     	$gb= db('gbedu')->where('adminid',$id)->find();
     	$ad = db('admin')->where('worknum',$id)->find();
     	$ho = db('homeb')->where('adminid',$id)->order("id")->select();
     	$ho[]=array('relation'=>"&nbsp",'name'=>"",'birthday'=>" ",'party'=>' ','workplace'=>" ");
     	$ho[]=array('relation'=>"&nbsp",'name'=>"",'birthday'=>" ",'party'=>' ','workplace'=>" ");
     	$ho[]=array('relation'=>"&nbsp",'name'=>"",'birthday'=>" ",'party'=>' ','workplace'=>" ");
     	$ho[]=array('relation'=>"&nbsp",'name'=>"",'birthday'=>" ",'party'=>' ','workplace'=>" ");
     	$ho[]=array('relation'=>"&nbsp",'name'=>"",'birthday'=>" ",'party'=>' ','workplace'=>" ");
     	$ho[]=array('relation'=>"&nbsp",'name'=>"",'birthday'=>" ",'party'=>' ','workplace'=>" ");

     	$ji = db('jianli')->where('adminid',$id)->find();
    //dump($ar);
     	//dump($gbeduxx);
     //	 dump($ad);
     	// dump($homebxx);
     	// dump($jianlixx);
     	$this->assign(array(
     		'rx' => $ar,
     		'year' => $year,
     		'gx' => $gb,
     		'dx' => $ad,
     		'hx' => $ho,
     		'jx' => $ji,
     		));
    //$html = '';
       if ( request()->isPost() ) 
         {
          //dump(input('post.'));die;
          $data=input('post.');
          $this->word($data['x'],"D:\phpStudy\WWW\gbgl\public\word\z".$ar['adminid'].".doc",$ad['name']);
         }
    
     	return view();
     }

  public function approval()
  {
      $art=db('approval')->where('status',0)->order('time desc')->select();
    
      foreach($art as &$a)
        {
             $a['aid']=$a['id'];
              $artid=db('article')->where('adminid',$a['adminid'])->field('id')->find();
              $a['id']=$artid['id'];
              $name=db('admin')->where('worknum',$a['adminid'])->field('name,cateid')->find();
              $a['name']=$name['name'];
              $cate=db('cate')->find($name['cateid']);
              $a['cate']=$cate['catename'];
              $artres[]=$a;
        }
     
     // dump($artres);die;
       if(isset($artres))
     $this->assign('artres',$artres);
      if ( request()->isPost() ) 
      {
          $data=input("post.");
          //dump($data);die;
          foreach($data as $d)
          {
              if($app=db('approval')->find($d['id']))
               {  
                $app['status']=1;
                db('approval')->update($app);
               db('message')->insert(['title'=>"您的修改申请已通过",'date'=>Time(),'worknum'=>$app['adminid']]);}
               else
               {
               $this->error('找不到申请','article/approval');
               }
          }
          if(!isset($data[1]))
             $this->error('未选择申请','article/approval');
            else
          $this->success('申请已全部通过','index/index');
      }
      return view();
  }
public function reply($worknum="",$type="")
{
     db('approval')->where('adminid',$worknum)->where('type',$type)->update(['status'=>-1]);
      if ( request()->isPost() ) {
          $data=input("post.");
          $data['date']=Time();
          if(db('message')->insert($data))
          {
              $this->success("发送成功！",'index/index');
          }
          else
          {
             $this->error("发送失败！",'index/index');
          }

      }
      $this->assign('worknum',$worknum);
      $this->assign('type',$type);
     return view();
}
public function detail($id="")
{
     $message=db('message')->find($id);
     db('message')->delete($id);
     $this->assign('message',$message);
     return view();
}


public function word($html,$wordname,$file)
{
  $html="<html>".$html."</html>";
  ob_start();
  echo $html; 
  $data = ob_get_contents();
 // $data=file_get_contents($html);
  ob_end_clean(); 
  if(file_exists($wordname))
   unlink($wordname);
 $fp=fopen($wordname,"x");
 fwrite($fp,$data);
 fclose($fp);
    ob_flush();//每次执行前刷新缓存 
    flush(); 
   // $this->success("生成成功！",'lst');

    header('Content-Type:doc'); //指定下载文件类型
header('Content-Disposition: attachment; filename='.$file.'.doc'); //指定下载文件的描述
header('Content-Length:'.filesize($wordname)); //指定下载文件的大小
//将文件内容读取出来并直接输出，以便下载
readfile($wordname);
}
public function niandu_lst1()
{
  return view();
}

public function niandu_lst2()
{
  return view();
}

public function edit5()
{
  return view();
}

public function edit6()
{
  return view();
}

public function edit7()
{
  return view();
}

public function niandu_table1()
{
   if ( request()->isPost() ) 
         {
          //dump(input('post.'));die;
          $data=input('post.');
         // dump($data['x']);die;
          $this->word($data['x'],"D:\phpStudy\WWW\gbgl\public\word\k.doc","111");
         }
  return view();
}

public function niandu_table2()
{
  if ( request()->isPost() ) 
         {
          //dump(input('post.'));die;
          $data=input('post.');
         // dump($data['x']);die;
          $this->word($data['x'],"D:\phpStudy\WWW\gbgl\public\word\p.doc","11");
         }
  return view();
}

}