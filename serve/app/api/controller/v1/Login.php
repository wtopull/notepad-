<?php
declare (strict_types=1);

namespace app\api\controller\v1;

use app\common\exception\UserException;
use app\common\validate\Users;
use \app\common\model\Users as mu;
use think\Request;

class Login
{
    private $validate;
    private $user;

    public function __construct()
    {
        $this->validate = new Users();
        $this->user = new mu();
    }

    /**
     * @param Request $request
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * 登录接口
     */
    public function login(Request $request)
    {
        $data = $request->param();
        if(!$this->validate->scene('login')->check($data)){
            return json([
                'code' => 1004,
                'msg' => $this->validate->getError()
            ]);
        }
        $username = $data['username'];
        $password = $data['password'];
        $result = $this->user->login($username,$password);
        return json($result);
    }

    /**
     * @param Request $request
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * 用户注册
     */
    public function register(Request $request)
    {
        $data = $request->param();
        if (!$this->validate->scene('register')->check($data)) {
            return json([
                'code' => 1001,
                'msg' => $this->validate->getError()
            ]);
        }
        $result = $this->user->register($data);
        return json($result);
    }
}
