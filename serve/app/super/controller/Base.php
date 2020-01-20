<?php


namespace app\super\controller;


use app\BaseController;
use think\facade\Session;

class Base extends BaseController
{
    protected function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub

        //获取当前用户
        $admin_id = Session::get('admin.id');
        if (empty($admin_id)) {
            return redirect('Login/index');
        }
    }
}