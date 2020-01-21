<?php


namespace app\common\model;


use think\facade\Db;
use think\facade\Request;

class Article extends Base
{
    /**
     * @param array $where
     * @param int $page
     * @param int $page_size
     * @param array $order
     * @return \think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * 文章列表数局
     */
    public static function articleList($where = array(), $page = 1, $page_size = 15, $order = ['sort', 'sort' => 'desc'])
    {
        if (isset($where['page'])) {
            $page = $where['page'];
        }
        $start = $page_size * $page;
        $articles = Db::table('com_article a')
            ->join('com_cate c', 'a.cate_id=c.id', 'left')
            ->field('a.id,a.cate_id,a.title,a.thumb,c.image,a.sort')
            ->limit($start, $page_size);
        if (isset($where['cate_id'])) {
            $articles->where('cate_id', $where['cate_id']);
        }

        if (isset($where['title'])) {
            $articles->where('a.title', 'like', $where['title'] . '%');
        }
        return $articles->order($order)->select();
    }

    /**
     * @param $id
     * @return array|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * 文章详情
     */
    public static function info($id)
    {
        return self::where('id',$id)
            ->where('status',1)
            ->field('title,content,hits,author')
            ->find();
    }

}