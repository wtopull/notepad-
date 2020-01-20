<?php


namespace app\api\controller;


use app\common\model\Ad;

class Ab extends Base
{
    /**
     * 控制器中间件 [登录、注册 不需要鉴权]
     * @var array
     */
    protected $middleware = [
        'app\api\middleware\Api',
    ];

    public function lists()
    {
        $list = Ad::getBannerList();
        if ($list) {
            $this->result($list, 1, '有效广告数据');
        }
        $this->result([], 0, '没有广告数据');
    }
}