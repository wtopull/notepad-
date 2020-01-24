<?php


namespace app\api\controller;


use app\common\model\Cate;
use app\common\model\Article;
use think\facade\Request;

class TabBars extends Base
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
     */
    public function cateArticleInfos()
    {
        $page = Request::param('page') ?? 1;
        $cate = Request::param('cate_id');
        if (!$cate) {
            $this->result([], 2002, '参数错误');
        }
        //获取当前分类的子分类
        $cates = Cate::cateGetList(['parentid' => $cate]);
        if (!$cates) {
            $this->result([], 0, '该类目不一级分类');
        }
//        print_r(array_keys($cates)[0]);die;
        $cateArticles = Article::articleList(['cate_id' => array_keys($cates)[0]], $page);
        $data['lable'] = $cates;
        $data['articles'] = $cateArticles;
//        print_r($data);die;
        $this->result($data, 1, 'SUCCESS');
    }


    public function cateArticles()
    {
        $page = Request::param('page') ?? 1;
        $cate = Request::param('cate_id');
        if (!$cate) {
            $this->result([], 2002, '参数错误');
        }
        $articles = Article::articleList(['cate_id'=>$cate],$page);
        $this->result($articles,1,'SUCCESS');
    }
}