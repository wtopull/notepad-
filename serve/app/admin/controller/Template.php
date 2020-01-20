<?php
/**
 * +----------------------------------------------------------------------
 * | 模板控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | WECHAT: zhaoyingjie4125
 *                .::::::::::               | DATETIME: 2019/03/06
 *           '::::::::::::::..
 *                ..::::::::::::.
 *              ``::::::::::::::::
 *               ::::``:::::::::'        .:::.
 *              ::::'   ':::::'       .::::::::.
 *            .::::'      ::::     .:::::::'::::.
 *           .:::'       :::::  .:::::::::' ':::::.
 *          .::'        :::::.:::::::::'      ':::::.
 *         .::'         ::::::::::::::'         ``::::.
 *     ...:::           ::::::::::::'              ``::.
 *   ```` ':.          ':::::::::'                  ::::..
 *                      '.:::::'                    ':'````..
 * +----------------------------------------------------------------------
 */
namespace app\admin\controller;

use app\common\model\System;

use think\facade\Request;
use think\facade\View;

class Template extends Base
{
    protected $public,$template_path,$template_html,$template_css,$template_js,$template_img,$upload_path;

    // 默认开启备份功能
    protected $templateOpening = true;

    function initialize()
    {
        parent::initialize();
        //查找所有系统设置表数据
        $system = System::getListField()->toArray();
        //格式化设置字段
        $system = sysgem_setup($system);
        $systemArr = [];
        foreach ($system as $k => $v) {
            $systemArr[$v['field']] = $v['value'];
        }
        $system = $systemArr;
        $this->public       = '/template/'.
            $system['template'].
            '/'.
            'index'.
            '/';
        $this->template_path =
            '.'.$this->public;
        $this->template_html = $system['html'];
        $this->template_css  = 'css';
        $this->template_js   = 'js';
        $this->template_img  = 'img';

        $initialize = [
            'html' => $this->template_html, //自定义html目录
            'css'  => $this->template_css,  //自定义css目录
            'js'   => $this->template_js,   //自定义js目录
            'img'  => $this->template_img,  //自定义媒体文件目录
        ];
        View::assign($initialize);

        //查找是否开启了模板修改备份功能
        $this->templateOpening = System::where('field','=','template_opening')->value('value');
    }

    // 列表
    public function index(){
        $type = Request::param('type') ? Request::param('type') : 'html';
        if ($type=='html') {
            $path=$this->template_path.$this->template_html.DIRECTORY_SEPARATOR;
        } else {
            $path=$this->template_path.$type.DIRECTORY_SEPARATOR;
        }
        $files = dir_list($path,$type);
        $templates = array();
        foreach ($files as $key => $file){
            $filename = basename($file);
            $templates[$key]['value']     =  substr($filename, 0, strrpos($filename, '.'));
            $templates[$key]['filename']  = $filename;
            $templates[$key]['filepath']  = $file;
            $templates[$key]['filesize']  = format_bytes(filesize($file));
            $templates[$key]['filemtime'] = filemtime($file);
            $templates[$key]['ext']       = strtolower(substr($filename, strrpos($filename, '.')-strlen($filename)));
        }

        $view = [
            'type'  => $type,        //当前显示的类型
            'list'  => $templates,   //加载数据
            'empty' => empty_list(4),//空数据提示
        ];
        View::assign($view);
        return View::fetch();
    }

    // 添加
    public function add(){
        $type=  Request::param('type') ? Request::param('type') : 'html';

        $view = [
            'type'  => $type,        //当前显示的类型
            'info'  => null,         //加载数据
        ];
        View::assign($view);
        return View::fetch();
    }

    // 添加保存
    public function addPost(){
        if (Request::isPost()) {
            $filename = Request::post('filename');
            $type     = Request::param('type') ? Request::param('type') : 'html';
            if ($type == 'html') {
                $path = $this->template_path.$this->template_html.'/';
            } else {
                $path = $this->template_path.$type.'/';
            }
            $file = $path.$filename.'.'.$type;
            if (file_exists($file)) {
                $this->error('文件已经存在!');
            } else {
                file_put_contents($file,stripslashes(input('post.content')));
                if ($type=='html') {
                    $this->success('添加成功!',url('index', ['type' => 'html']));
                } else {
                    $this->success('添加成功!',url('index', ['type' => $type]));
                }
            }
        }
    }

    // 修改
    public function edit(){
        $filename = Request::param('file');
        $type     = Request::param('type') ? Request::param('type') : 'html';
        if ($type == 'html') {
            $path = $this->template_path.$this->template_html.'/';
        } else {
            $path = $this->template_path.$type.'/';
        }
        $file = $path.$filename;
        if (file_exists($file)) {
            $file = iconv('gb2312','utf-8',$file);
            $content = file_get_contents($file);
            $info = [
                'filename' => $filename,
                'file'     => $file,
                'content'  => $content,
                'type'     => $type
            ];
        } else {
            $this->error('文件不存在！');
        }
        $view = [
            'info' => $info,
            'type' => $type,//当前显示的类型
        ];
        View::assign($view);
        return View::fetch('add');
    }

    // 修改保存
    public function editPost(){
        if (Request::isPost()) {
            $filename = Request::post('filename');
            $type     = Request::param('type') ? Request::param('type') : 'html';
            if ($type == 'html') {
                $path = $this->template_path.$this->template_html.'/';
            } else {
                $path = $this->template_path.$type.'/';
            }
            $file = $path . $filename;
            if (file_exists($file)) {
                //判断是否有写入权限
                if (!is_writable($file)) {
                    $this->error('无写入权限!');
                }

                //备份文件(防止出错)
                if ($this->templateOpening) {
                    //设置备份文件名
                    $newFile = $path . str_replace('.' ,'_back-'.date("Y-m-d_H-i-s").'.', $filename);
                    //执行复制操作
                    copy($file,$newFile);
                }

                if (false !== file_put_contents($file,stripslashes(input('content')))){
                    if ($type == 'html') {
                        $this->success('修改成功!',url('index', ['type' => 'html']));
                    } else {
                        $this->success('修改成功!',url('index', ['type' => $type]));
                    }
                }else{
                    $this->error('修改失败!');
                }
            } else {
                $this->error('文件不存在!');
            }
        }
    }

    // 删除
    public function del(){
        if (Request::isPost()) {
            $id = Request::param('id');
            //删除文件
            $filename = $id;
            $type = Request::param('type') ? Request::param('type') : 'html';
            if ($type == 'html') {
                $path = $this->template_path.$this->template_html.'/';
            } else {
                $path = $this->template_path.$type.'/';
            }
            $file = $path.$filename;
            if (file_exists($file)) {
                unlink($file);
                return json(['error'=>0, 'msg'=>'删除成功!']);
            }else{
                return json(['error'=>1, 'msg'=>'删除失败!']);
            }
        }
    }

    // 媒体文件
    public function img(){
        $path = $this->template_path.$this->template_img.'/'.Request::param('folder');
        $folder = Request::param('folder') ? Request::param('folder') : '';
        $uppath = explode('/',Request::param('folder'));
        $leve = count($uppath)-1;
        unset($uppath[$leve]);
        if ($leve>1) {
            unset($uppath[$leve-1]);
            $uppath = implode('/',$uppath).'/';
        } else {
            $uppath = '';
        }

        $files = glob($path.'*');
        $folders = $templates = array();
        foreach ($files as $key => $file) {
            $filename = basename($file);
            if (is_dir($file)) {
                $folders[$key]['filename'] = $filename;
                $folders[$key]['filepath'] = $file;
                $folders[$key]['ext']      = 'folder';
            } else {
                $templates[$key]['filename'] = $filename;
                $templates[$key]['filepath'] = ltrim($file,'.') ;
                $templates[$key]['ext']      = strtolower(substr($filename,strrpos($filename, '.')-strlen($filename)+1));
                if (!in_array($templates[$key]['ext'], array('gif','jpg','png','bmp'))) {
                    $templates[$key]['ico'] =1;
                }
            }
        }
        $view = [
            'folder'  => $folder,
            'leve'    => $leve,
            'uppath'  => $uppath,
            'path'    => $path,               //路径
            'folders' => $folders,            //文件夹
            'files'   => $templates,          //文件
            'type'    => $this->template_img, //当前显示的类型
        ];
        View::assign($view);
        return View::fetch();
    }

    // 媒体文件删除
    public function imgDel(){
        $path = $this->template_path.$this->template_img.'/'.Request::post('folder');
        $file = $path.Request::post('filename');

        if (file_exists($file)) {
            is_dir($file) ? dir_delete($file) : unlink($file);
            return json(['error'=>0, 'msg'=>'删除成功!']);
        } else {
            return json(['error'=>1, 'msg'=>'文件不存在!']);
        }
    }


}
