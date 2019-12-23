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
                'url' => '/admin/mall.goods/list',
            ],
            [
                'name' => '商品分类',
                'url' => '/admin/mall.category/list',
            ],
            [
                'name' => '品牌管理',
                'url' => '/admin/mall.brand/list',
            ],
            [
                'name' => '商品类型',
                'url' => '/admin/mall._goods_attr/list',
            ]
            
        ]    
    ],
    'order' => [
        'name' => '订单管理',
        'active'=>'layui-nav-itemed',
        'submenu' => [
            [
                'name' => '订单列表',
                'url' => '/admin/mall.order/list',
            ],
            [
                'name' => '退货订单',
                'url' => '/admin/mall.order/reason',
            ],
            [
                'name' => '退货原因',
                'url' => '/admin/mall.order/reasonList',
            ],
            [
                'name' => '商品评论',
                'url' => '/admin/mall.comments/list',
            ]
            
        ]    
    ],
    'article' => [
        'name' => '文章管理',
        'submenu' => [
            [
                'name' => '文章分类',
                'url' => '/admin/mall.Mallarticle/categoryList',
            ],
            [
                'name' => '文章列表',
                'url' => '/admin/mall.Mallarticle/articleList',
            ],
             [
                'name' => '文章自动发布',
                'url' => '/admin/mall.Mallarticle/autoRelease',
            ],
        ]
    ],
    'user' => [
        'name' => '会员管理',
        'submenu' => [
            [
                'name' => '会员列表',
                'url' => '/admin/mall.user/list',
            ],
            [
                'name' => '会员收货地址',
                'url' => '/admin/mall.user/addr',
            ],
            [
                'name' => '充值&提现',
                'url' => '/admin/mall.user/toup',
            ],
            [
                'name' => '发票列表',
                'url' => '/admin/mall.user/invoiceList',
            ],
            [
                'name' => '意见反馈',
                'url' => '/admin/mall.user/feedback',
            ],
            [
                'name' => '留言回复',
                'url' => '/admin/mall.user/reply',
            ]
        ]
    ],
    'kill' => [
        'name' => '活动促销',
        'submenu' => [
            [
                'name' => '限时秒杀',
                'url' => '/admin/mall.kill/list',
            ]
        ]
    ]
];
