<?php
/**
 * +----------------------------------------------------------------------
 * | 用户中心控制器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | WECHAT: zhaoyingjie4125
 *                .::::::::::               | DATETIME: 2019/07/19
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

namespace app\api\controller;


use app\api\service\JwtAuth;
use app\common\model\Users;
use Qcloud\Cos\Client;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\Request;
use think\facade\Session;

class User extends Base
{
    /**
     * 控制器中间件 [登录、注册 不需要鉴权]
     * @var array
     */
    protected $middleware = [
        'app\api\middleware\Api' => ['except' => ['login', 'register', 'getCaptcha']],
    ];

    //上传验证规则
    protected $uploadValidate = ['file' => [
        // 限制文件大小(单位b)，这里限制为4M
        //'fileSize' => 4 * 1024 * 1024,
        // 限制文件后缀，多个后缀以英文逗号分割
        'fileExt' => 'jpg,png,gif,jpeg,rar,zip,avi,rmvb,3gp,flv,mp3,txt,doc,xls,ppt,pdf,xls,docx,xlsx,doc'
        // 更多规则请看“上传验证”的规则，文档地址https://www.kancloud.cn/manual/thinkphp6_0/1037629#_444
    ]];

    /**
     * @api {post} /User/login 01、会员登录
     * @apiGroup User
     * @apiVersion 6.0.0
     * @apiDescription 系统登录接口，返回 token 用于操作需验证身份的接口
     * @apiParam (请求参数：) {string}            username 登录用户名
     * @apiParam (请求参数：) {string}            password 登录密码
     * @apiParam (响应字段：) {string}            token    Token
     * @apiSuccessExample {json} 成功示例
     * {"code":1,"msg":"登录成功","time":1563525780,"data":{"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhcGkuc2l5dWNtcy5jb20iLCJhdWQiOiJzaXl1Y21zX2FwcCIsImlhdCI6MTU2MzUyNTc4MCwiZXhwIjoxNTYzNTI5MzgwLCJ1aWQiOjEzfQ.prQbqT00DEUbvsA5M14HpNoUqm31aj2JEaWD7ilqXjw"}}
     * @apiErrorExample {json} 失败示例
     * {"code":0,"msg":"帐号或密码错误","time":1563525638,"data":[]}
     */
    public function login()
    {
        $username = trim(Request::param('username'));
        $password = trim(Request::param('password'));
        if (!$username || !$password) {
            $this->result([], 1001, '帐号或密码不能为空');
        }
        //校验用户名密码
        $user = Users::where('username', $username)
            ->where('password', md5($password))
            ->field('username,theme,language,isrelease,status,image,id')
            ->find();

        if (empty($user)) {
            $this->result([], 1002, '帐号或密码错误');
        } else {
            if ($user['status'] == 1) {
                //获取jwt的句柄
                $jwtAuth = JwtAuth::getInstance();
                $token = $jwtAuth->setUid($user['id'])->encode()->getToken();
                //更新信息
                Users::where('id', $user['id'])
                    ->update(['last_login_time' => time(), 'last_login_ip' => Request::ip()]);
                $user['token'] = $token;
                $this->result($user, 1000, '登录成功');
            } else {
                $this->result([], 0, '用户已被禁用');
            }
        }
    }

    /**
     * @api {post} /User/register 02、会员注册
     * @apiGroup User
     * @apiVersion 6.0.0
     * @apiDescription  系统注册接口，返回是否成功的提示，需再次登录
     * @apiParam (请求参数：) {string}            email 邮箱
     * @apiParam (请求参数：) {string}            password 密码
     * @apiSuccessExample {json} 成功示例
     * {"code":1,"msg":"注册成功","time":1563526721,"data":[]}
     * @apiErrorExample {json} 失败示例
     * {"code":0,"msg":"邮箱已被注册","time":1563526693,"data":[]}
     */
    public function register()
    {
        $username = trim(Request::param("username"));
        $password = trim(Request::param("password"));
        $repassword = trim(Request::param("repassword"));
        $captcha = trim(Request::param("captcha"));

        //非空判断
        if (empty($username) || empty($password) || empty($repassword)) {
            $this->result([], 1003, '请输入用户名、密码和确认密码');
        }

        //密码长度不能低于6位
        if (strlen($password) < 6) {
            $this->result([], 1004, '密码长度不能低于6位');
        }

        //密码和确认密码不一致
        if ($password !== $repassword) {
            $this->result([], 1005, '密码和确认密码不一致');
        }

        //防止重复
        $id = Db::name('users')->where('username', '=', $username)->find();
        if ($id) {
            $this->result([], 1006, '用户名已被注册');
        }

        //注册入库
        $data = [];
        $data['username'] = $username;
        $data['password'] = md5($password);
        $data['last_login_time'] = $data['create_time'] = time();
        $data['create_ip'] = $data['last_login_ip'] = Request::ip();
        $data['status'] = 1;
        $data['type_id'] = 1;
        $data['sex'] = Request::post('sex') ? Request::post('sex') : 0;
        $id = Db::name('users')->insertGetId($data);
        if ($id) {
            $this->result([], 1000, '注册成功');
        } else {
            $this->result([], 1007, '注册失败,服务器错误');
        }
    }

    /**
     * @api {post} /User/index 03、会员中心首页
     * @apiGroup User
     * @apiVersion 6.0.0
     * @apiDescription  会员中心首页，返回用户个人信息
     * @apiParam (请求参数：) {string}            token Token
     * @apiSuccessExample {json} 响应数据样例
     * {"code":1,"msg":"","time":1563517637,"data":{"id":13,"email":"test110@qq.com","password":"e10adc3949ba59abbe56e057f20f883e","sex":1,"last_login_time":1563517503,"last_login_ip":"127.0.0.1","qq":"123455","mobile":"","mobile_validated":0,"email_validated":0,"type_id":1,"status":1,"create_ip":"127.0.0.1","update_time":1563507130,"create_time":1563503991,"type_name":"注册会员"}}
     */
    public function index()
    {
        $user = Db::name('users')
            ->alias('u')
            ->leftJoin('users_type ut', 'u.type_id = ut.id')
            ->field('u.*,ut.name as type_name')
            ->where('u.id', $this->getUid())
            ->find();
        return $this->result($user, 1000, '');
    }

    /**
     * @api {post} /User/editPwd 04、修改密码
     * @apiGroup User
     * @apiVersion 6.0.0
     * @apiDescription  修改会员密码，返回成功或失败提示
     * @apiParam (请求参数：) {string}            token Token
     * @apiParam (请求参数：) {string}            oldPassword 原密码
     * @apiParam (请求参数：) {string}            newPassword 新密码
     * @apiSuccessExample {json} 成功示例
     * {"code":1,"msg":"密码修改成功","time":1563527107,"data":[]}
     * @apiErrorExample {json} 失败示例
     * {"code":0,"msg":"token已过期","time":1563527082,"data":[]}
     */
    public function editPwd()
    {
        $oldPassword = trim(Request::param("oldPassword"));
        $newPassword = trim(Request::param("newPassword"));

        //为空判断
        if (!$oldPassword || !$newPassword) {
            $this->result([], 0, '请输入原密码和新密码');
        }

        //密码长度不能低于6位
        if (strlen($newPassword) < 6) {
            $this->result([], 0, '密码长度不能低于6位');
        }

        //查看原密码是否正确
        $user = Users::where('id', $this->getUid())
            ->where('password', md5($oldPassword))
            ->find();
        if (!$user) {
            $this->result([], 0, '原密码输入有误');
        }

        //更新信息
        $user = Users::find($this->getUid());
        $user->password = md5($newPassword);
        $user->save();
        $this->result([], 1, '密码修改成功');
    }

    /**
     * @api {post} /User/editInfo 05、修改信息
     * @apiGroup User
     * @apiVersion 6.0.0
     * @apiDescription  修改用户信息，返回成功或失败提示
     * @apiParam (请求参数：) {string}            token Token
     * @apiParam (请求参数：) {string}            sex 性别 [1男/0女]
     * @apiParam (请求参数：) {string}            qq  qq
     * @apiParam (请求参数：) {string}            mobile  手机号
     * @apiSuccessExample {json} 成功示例
     * {"code":0,"msg":"修改成功","time":1563507660,"data":[]}
     * @apiErrorExample {json} 失败示例
     * {"code":0,"msg":"token已过期","time":1563527082,"data":[]}
     */
    public function editInfo()
    {
        $arr = Request::param();

        if(isset($arr['theme'])){
            $data['theme'] = $arr['theme'];
        }

        if(isset($arr['language'])){
            $data['language'] = $arr['language'];
        }
//        $data['theme'] = trim(Request::param("theme"))?trim(Request::param("theme")):0;
//
//        $data['language'] = trim(Request::param("language"));
//        $data['mobile'] = trim(Request::param("mobile"));
        if (isset($data['username'])) {
            //不可和其他用户的一致
            $id = Users::
            where('username', $data['username'])
                ->where('id', '<>', $this->getUid())
                ->find();
            if ($id) {
                $this->result([], 0, '用户昵称已存在');
            }
        }
        //更新信息
//        print_r($this->getUid());die;
        Users::where('id', $this->getUid())
            ->update($data);
        $this->result([], 1, '修改成功');
    }



    /**
     * 获取用户id
     * @return mixed
     */
    protected function getUid()
    {
        $jwtAuth = JwtAuth::getInstance();
        return $jwtAuth->getUid();
    }

    public function getCaptcha()
    {
        $username = trim(Request::param('username'));
        if (!$username) {
            $this->result([], 0, '验证码获取失败');
        }
        $code = rand(1000, 9999);
        Session::set($username, $code);
        $this->result([], 1, '您的验证码是:' . $code);
    }

    public function upload()
    {
        $file = request()->file('file');
        try {
            validate($this->uploadValidate)
                ->check(['file' => $file]);
            $savename = \think\facade\Filesystem::disk('public')->putFile('uploads', $file);
//            $this->txCos($savename);
            return '/' . $savename;
        } catch (ValidateException $e) {
            return $e->getMessage();
        }
    }

    public function txCos($file)
    {
//        echo \think\facade\app::getRootPath().'public/storage/'.$file;
//        die;
//        E:\php\PHPTutorial\WWW\science\/public/storage/uploads/20200124\0b6bb13aebafc908b3bfbbcd941fabe2.png
//        E:\php\PHPTutorial\WWW\science\/public/storage/uploads/20200124\524336a15ce144920819a34cc43cf0e6.png
        $filePath = \think\facade\app::getRootPath().'public/storage/'.$file;
        echo $filePath;die;
        $secretId = "AKIDXu7Azbj72lGXaQ6TeYCahX7RUGn47uQh"; //"云 API 密钥 SecretId";
        $secretKey = "DBsJTOGzSiiTyCE1YrwlW8VdWAZijW5Q"; //"云 API 密钥 SecretKey";
        $region = "ap-guangzhou"; //设置一个默认的存储桶地域
        $cosClient = new Client(
            array(
                'region' => $region,
//                'schema' => 'https', //协议头部，默认为http
                'credentials' => array(
                    'secretId' => $secretId,
                    'secretKey' => $secretKey)));
        try {
            $bucket = "haha-1253480702"; //存储桶名称 格式：BucketName-APPID
//            $key = "cd7b3b0723321bebf08007a6";
            $result = $cosClient->upload(array(
                'Bucket' => $bucket,
                'Key' => $file,
                'Body' => fopen($filePath, 'rb')));

            print_r($result);
            return $result;
        } catch (\Exception $e) {
            echo "$e\n";
        }
    }


    public function uploadImg()
    {
        $config = TENGXUN;
        $file = request()->file('file');
        $pathname = $file->getInfo()['tmp_name'];
        $image = \think\Image::open($file->getInfo()['tmp_name']);
        // 返回图片的宽度
        $width = $image->width();
        $height = $image->height();
        $savename = "/xgtk/" . date("Y") . "/" . date("m") . "/" . date("d") . "/" . md5(microtime()) . '.jpg';
        //引用COS sdk
        require dirname(dirname(dirname(DIR))) . '/extend/cos-php-sdk-v5/vendor/autoload.php';
        $cosClient = new \Qcloud\Cos\Client(
            array(
                'region' => $config['region'],
                'credentials' => array(
                    'appId' => $config['credentials']['APPID'],
                    'secretId' => $config['credentials']['SecretId'],
                    'secretKey' => $config['credentials']['SecretKey']
                )
            )
        );

        $data = array('Bucket' => $config['bucket'], 'Key' => $savename, 'Body' => fopen($pathname, 'rb'));
        //判断文件大小 大于5M就分块上传
        $result = $cosClient->Upload($data['Bucket'], $data['Key'], $data['Body']);
        //上传成功，自己编码

        if (!empty($result)) {
            //是否删除本地
            //  dump($result);
            @unlink($pathname);
            $data = '';
            $data['url'] = 'https://' . $result['Location'];
            $data['width'] = $width;
            $data['height'] = $height;
            //dump($data);
            exit(json_encode($data));
        }
    }

}
