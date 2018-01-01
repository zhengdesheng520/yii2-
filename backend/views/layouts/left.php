<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
<!--                显示登录后的用户名-->
                <p><?=Yii::$app->user->identity->username?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => '某京后台管理', 'options' => ['class' => 'header']],
                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => '登录', 'icon' => 'dashboard', 'url' => ['/admin/login']],

                    [
                        'label' => '品牌管理',
                        'icon' => 'share',
                        'url' => '/brand/index',
                        'items' => [
                            ['label' => '品牌列表', 'icon' => 'file-code-o', 'url' => ['/brand/index'],],
                            ['label' => '添加品牌', 'icon' => 'dashboard', 'url' => ['/brand/add'],],

                        ],
                    ],

                    [
                        'label' => '文章管理',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => '文章分类', 'icon' => 'file-code-o', 'url' => ['/article-category/index'],],
                            ['label' => '添加文章分类', 'icon' => 'dashboard', 'url' => ['/article-category/add'],],
                            [
                                'label' => '文章详情',
                                'icon' => 'share',
                                'url' => '#',
                                'items' => [
                                    ['label' => '文章列表', 'icon' => 'file-code-o', 'url' => ['/article/index'],],                 ['label' => '添加文章', 'icon' => 'dashboard', 'url' => ['/article/add'],],

                                ],
                            ],


//                            [
//                                'label' => 'Level One',
//                                'icon' => 'circle-o',
//                                'url' => '#',
//                                'items' => [
//                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
//                                    [
//                                        'label' => 'Level Two',
//                                        'icon' => 'circle-o',
//                                        'url' => '#',
//                                        'items' => [
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                        ],
//                                    ],
//                                ],
//                            ],
                        ],
                    ],




                    [
                        'label' => '商品分类管理',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => '分类列表', 'icon' => 'file-code-o', 'url' => ['/category/index'],],
                            ['label' => '添加商品分类', 'icon' => 'dashboard', 'url' => ['/category/add'],],

                        ],
                    ],

                    [
                        'label' => '商品管理',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => '商品列表', 'icon' => 'file-code-o', 'url' => ['/goods/index'],],
                            ['label' => '添加商品', 'icon' => 'dashboard', 'url' => ['/goods/add'],],

                        ],
                    ],

                    [
                        'label' => '管理员',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => '管理员列表', 'icon' => 'file-code-o', 'url' => ['/admin/index'],],
                            ['label' => '添加管理员', 'icon' => 'dashboard', 'url' => ['/admin/add'],],

                        ],
                    ],





                ],
            ]
        ) ?>

    </section>

</aside>
