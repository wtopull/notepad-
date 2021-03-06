<?php
/**
 * +----------------------------------------------------------------------
 * | 系统设置验证器
 * +----------------------------------------------------------------------
 *                      .::::.
 *                    .::::::::.            | AUTHOR: siyu
 *                    :::::::::::           | EMAIL: 407593529@qq.com
 *                 ..:::::::::::'           | QQ: 407593529
 *             '::::::::::::'               | WECHAT: zhaoyingjie4125
 *                .::::::::::               | DATETIME: 2019/05/15
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
namespace app\admin\validate;

use think\Validate;

class System extends Validate
{
    protected $rule = [
        'group_id|所属分组' => [
            'require' => 'require',
        ],
        'type|字段类型' => [
            'require' => 'require',
        ],
        'field|字段名' => [
            'require' => 'require',
            'max'     => '255',
            'unique'  => 'system',
        ],
        'name|别名' => [
            'require' => 'require',
            'max'     => '255',
            'unique'  => 'system',
        ],
        'sort|排序' => [
            'require' => 'require',
            'number'  => 'number',
        ],
    ];
}