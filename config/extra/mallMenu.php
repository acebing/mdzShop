<?php
/**
 * 后台菜单配置
 *    'home' => [
 *       'name' => '首页',                // 菜单名称
 *       'index' => 'index/index',         // 链接
 *     ],
 */
return[
    'goods' => [
        'name' => '商品管理',
        'active'=>'layui-nav-itemed',
        'submenu' => [
            [
                'name' => '商品列表',
                'url' => '/admin/goods/list',
            ],
            [
                'name' => '商品分类',
                'url' => '/admin/category/list',
            ],
            [
                'name' => '品牌管理',
                'url' => '/admin/brand/list',
            ],
            [
                'name' => '商品类型',
                'url' => '/admin/Goods_attr/list',
            ]
            
        ]    
    ],
    'order' => [
        'name' => '订单管理',
        'active'=>'layui-nav-itemed',
        'submenu' => [
            [
                'name' => '订单列表',
                'url' => '/admin/order/list',
            ],
            [
                'name' => '退货订单',
                'url' => '/admin/order/reason',
            ],
            [
                'name' => '退货原因',
                'url' => '/admin/order/reasonList',
            ],
            [
                'name' => '商品评论',
                'url' => '/admin/Comments/list',
            ]
            
        ]    
    ],
    'article' => [
        'name' => '文章管理',
        'submenu' => [
            [
                'name' => '文章分类',
                'url' => '/admin/mallArticle/categoryList',
            ],
            [
                'name' => '文章列表',
                'url' => '/admin/mallArticle/articleList',
            ],
             [
                'name' => '文章自动发布',
                'url' => '/admin/mallArticle/autoRelease',
            ],
        ]
    ],
    'user' => [
        'name' => '会员管理',
        'submenu' => [
            [
                'name' => '会员列表',
                'url' => '/admin/user/list',
            ],
            [
                'name' => '会员收货地址',
                'url' => '/admin/user/addr',
            ],
            [
                'name' => '充值&提现',
                'url' => '/admin/user/toup',
            ],
            [
                'name' => '发票列表',
                'url' => '/admin/user/invoiceList',
            ],
            [
                'name' => '意见反馈',
                'url' => '/admin/user/feedback',
            ],
            [
                'name' => '留言回复',
                'url' => '/admin/user/reply',
            ]
        ]
    ],
    'kill' => [
        'name' => '活动促销',
        'submenu' => [
            [
                'name' => '限时秒杀',
                'url' => '/admin/kill/list',
            ]
        ]
    ]
];
