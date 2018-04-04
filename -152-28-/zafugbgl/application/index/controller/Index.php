<?php
namespace app\index\controller;

class Index extends Common
{
    public function index()
    {
    	//首页最新文章调用
    	$articleM=new \app\index\model\Article();
    	$newArtiecleRes=$articleM->getNewArticle();
        $siteHotArt=$articleM->getSiteHot();
        $recArt=$articleM->getRecArt();
        //获取推荐栏目
        $cateM=new \app\index\model\Cate();
        $recIndex=$cateM->getRecIndex();
        //友情链接数据
        $linkRes=db('link')->order('sort desc')->select();
    	$this->assign(array(
    		'newArtiecleRes'=>$newArtiecleRes,
            'siteHotArt'=>$siteHotArt,
            'linkRes'=>$linkRes,
            'recArt'=>$recArt,
            'recIndex'=>$recIndex,
    		));
        return view();
    }
}
