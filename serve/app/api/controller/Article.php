<?php


namespace app\api\controller;
use \app\common\model\Article as ar;
use think\facade\Request;


class Article extends Base
{
    /**
     * 控制器中间件 [登录、注册 不需要鉴权]
     * @var array
     */
    protected $middleware = [
        'app\api\middleware\Api',
    ];

    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * 文章列表
     */

    public function article()
    {
        $list = ar::articleList(input(''));
        if ($list) {
            $this->result($list, 2000, '文章数据');
        }
        $this->result([], 2001, '没有文章数据');
    }

    public function info()
    {
        $id = Request::param('id');
        if(!$id){
            $this->result([],2002,'参数错误');
        }
        $article = ar::info($id);
        if($article){
            $this->result($article,2000,'SUCCESS');
        }
        $this->result([],2001,'当前数据不存在');
    }
}