<?php
namespace app\admin\validate;
use think\Validate;
class Admin extends Validate
{

    protected $rule=[
        'worknum'=>'unique:admin|require|max:25|number',
        'password'=>'require|min:6',
    ];


    protected $message=[
        'worknum.require'=>'工号不得为空！',
        'worknum.unique'=>'工号不得重复！',
        'worknum.number'=>'工号必须为数字！',
        'password.require'=>'密码不得为空！',
        'password.min'=>'密码不得少于6位！',
    ];

    protected $scene=[
        'add'=>['worknum','password'],
        'edit'=>['worknum','password'=>'min:6'],
    ];





    

    




   

	












}
