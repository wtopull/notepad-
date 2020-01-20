<?php


namespace app\common\validate;


use think\Validate;

class Users extends Validate
{
    protected $rule = [
        'username' => 'require|max:50',
        'password' => 'require|min:6',
        'repassword' => 'require|confirm:password'
    ];

    protected $message = [
        'username.require' => '用户名必须',
        'username.max' => '用户名最多不能超过50个字符',
        'password.require' => '密码不能为空',
        'password.min' => '密码长度不能低于六位数',
        'repassword.require' => '确认密码不能为空',
        'repassword.confirm' => '密码与确认密码不一致',

    ];
    protected $scene = [
        'register' => ['username', 'password', 'repassword'],
        'login' => ['username', 'password']
    ];


}