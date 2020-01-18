<?php


namespace app\super\controller;


use app\BaseController;
use think\facade\View;


class Index extends Base
{
    public function index()
    {
        return View::fetch();
    }

    public function welcome()
    {
        return View::fetch();
    }
}