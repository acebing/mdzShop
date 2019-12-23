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
                'url' => '/admin/mallsite.Base_site/index',
            ],
            [
                'name' => '地区管理',
                'url' => '/admin/mallsite.Area/areaSite',
            ],
            [
                'name' => '配送管理',
                'url' => '/admin/mallsite.Delivery/deliveryList',
            ],
            
            [
                'name' => '友情链接',
                'url' => '/admin/mallsite.Friend_link/friendLinkList',
            ],
            

        ]
    ],
    'admin' => [
        'name' => '权限管理',
        'submenu' => [
            [
                'name' => '管理员列表',
                'url' => '/admin/mallsite.admin/loadAdminList',
            ],
            [
                'name' => '权限列表',
                'url' => '/admin/mallsite.Auth_rule/loadAdminAuthList',
            ],
             [
                'name' => '角色管理',
                'url' => '/admin/mallsite.Auth_group/loadAdminRoleList',
            ],
        ]
    ],
    'email' => [
        'name' => '邮件',
        'submenu' => [
            [
                'name' => '账号设置',
                'url' => '/admin/mallsite.email/list',
            ]
        ]
    ],
];
