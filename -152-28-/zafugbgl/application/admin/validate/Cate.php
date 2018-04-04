<?php
namespace app\admin\validate;
use think\Validate;
class Cate extends Validate
{

    protected $rule=[
        'catename'=>'unique:cate|require|max:100',
    ];


    protected $message=[
        'catename.require'=>'部门名称不得为空！',
        'catename.unique'=>'部门名称不得重复！',
    ];

    protected $scene=[
        'add'=>['catename'],
        'edit'=>['catename'],
    ];





    

    




   

	












}
