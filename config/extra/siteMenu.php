<?php
/**
 * 后台菜单配置
 *    'home' => [
 *       'name' => '首页',                // 菜单名称
 *       'index' => 'index/index',         // 链接
 *     ],
 */
return[
    'mallsite' => [
        'name' => '平台设置',
        'active'=>'layui-nav-itemed',
        'submenu' => [
            [
                'name' => '基本设置',
                'url' => '/admin/mallsite/basesite',
            ],
            [
                'name' => '地区管理',
                'url' => '/admin/area/areaSite',
            ],
            [
                'name' => '配送管理',
                'url' => '/admin/delivery/deliveryList',
            ],
            [
                'name' => '支付方式',
                'url' => '/admin/mallsite/basePaySite',
            ],
            
            [
                'name' => '友情链接',
                'url' => '/admin/friend_link/friendLinkList',
            ],
             [
                'name' => '第三方登录',
                'url' => '/admin/mallsite/thirdLogin',
            ],
             [
                'name' => '微信公众号',
                'url' => '/admin/mallsite/weixin',
            ],
             [
                'name' => '微信小程序',
                'url' => '/admin/mallsite/weixinxcx',
            ],
             [
                'name' => '阿里短信',
                'url' => '/admin/sms_site/loadTemplatList',
            ],
             [
                'name' => '阿里OSS',
                'url' => '/admin/mallsite/oss',
            ]

        ]
    ],
    'permissions' => [
        'name' => '权限管理',
        'submenu' => [
            [
                'name' => '管理员列表',
                'url' => '/admin/mallsite/permissions',
            ],
            [
                'name' => '下级管理员列表',
                'url' => '/admin/mallsite/permissionsSeeAdminLog',
            ],
             [
                'name' => '角色管理',
                'url' => '/admin/mallsite/permissionsRole',
            ],
        ]
    ],
    'email' => [
        'name' => '邮件',
        'submenu' => [
            [
                'name' => '账号设置',
                'url' => '/admin/email/list',
            ]
        ]
    ],
];
