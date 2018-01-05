<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
<!--                显示登录后的用户名-->
                <p><?php
                    if(Yii::$app->user->isGuest){

                        echo "<a href='/admin/login'>请登录</a>";
                    }else{
                       echo "欢迎您：".Yii::$app->user->identity->username;

                    }



                    ?></p>

                <a href="#"><i class="fa fa-calendar-check-o"></i> <?=date('Y-m-d')?></a>
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
                'items' =>mdm\admin\components\MenuHelper::getAssignedMenu(Yii::$app->user->id),





//                    [
////                    ['label' => '某京后台管理', 'options' => ['class' => 'header']],
////                    ['label' => 'Gii生成器', 'icon' => 'file-code-o', 'url' => ['/gii']],
////                    ['label' => '登录', 'icon' => 'dashboard', 'url' => ['/admin/login']],
//
////                    [
////                        'label' => '品牌管理',
////                        'icon' => 'share',
////                        'url' => '/brand/index',
////                        'items' => [
////                            ['label' => '品牌列表', 'icon' => 'file-code-o', 'url' => ['/brand/index'],],
////                            ['label' => '添加品牌', 'icon' => 'plus-square', 'url' => ['/brand/add'],],
////
////                        ],
////                    ],
//
////                    [
////                        'label' => '文章管理',
////                        'icon' => 'share',
////                        'url' => '#',
////                        'items' => [
////                            ['label' => '文章分类', 'icon' => 'file-code-o', 'url' => ['/article-category/index'],],
////                            ['label' => '添加文章分类', 'icon' => 'plus-square', 'url' => ['/article-category/add'],],
////                            [
////                                'label' => '文章详情',
////                                'icon' => 'share',
////                                'url' => '#',
////                                'items' => [
////                                    ['label' => '文章列表', 'icon' => 'file-code-o', 'url' => ['/article/index'],],                 ['label' => '添加文章', 'icon' => 'plus-square', 'url' => ['/article/add'],],
////
////                                ],
////                            ],
////
////
//////                            [
//////                                'label' => 'Level One',
//////                                'icon' => 'circle-o',
//////                                'url' => '#',
//////                                'items' => [
//////                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
//////                                    [
//////                                        'label' => 'Level Two',
//////                                        'icon' => 'circle-o',
//////                                        'url' => '#',
//////                                        'items' => [
//////                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//////                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//////                                        ],
//////                                    ],
//////                                ],
//////                            ],
////                        ],
////                    ],
//
//
//
//
////                    [
////                        'label' => '商品分类管理',
////                        'icon' => 'share',
////                        'url' => '#',
////                        'items' => [
////                            ['label' => '分类列表', 'icon' => 'file-code-o', 'url' => ['/category/index'],],
////                            ['label' => '添加商品分类', 'icon' => 'plus-square', 'url' => ['/category/add'],],
////
////                        ],
////                    ],
//
////                    [
////                        'label' => '商品管理',
////                        'icon' => 'share',
////                        'url' => '#',
////                        'items' => [
////                            ['label' => '商品列表', 'icon' => 'file-code-o', 'url' => ['/goods/index'],],
////                            ['label' => '添加商品', 'icon' => 'plus-square', 'url' => ['/goods/add'],],
////
////                        ],
////                    ],
//
////                    [
////                        'label' => '管理员',
////                        'icon' => 'share',
////                        'url' => '#',
////                        'items' => [
////                            ['label' => '管理员列表', 'icon' => 'file-code-o', 'url' => ['/admin/index'],],
////                            ['label' => '添加管理员', 'icon' => 'plus-square', 'url' => ['/admin/add'],],
////
////                        ],
////                    ],
////                    [
////                        'label' => '权限管理',
////                        'icon' => 'share',
////                        'url' => '#',
////                        'items' => [
////                            ['label' => '权限列表', 'icon' => 'file-code-o', 'url' => ['/permission/index'],],
////                            ['label' => '添加权限', 'icon' => 'plus-square', 'url' => ['/permission/add'],],
////                            ['label' => '角色列表', 'icon' => 'file-code-o', 'url' => ['/role/index'],],
////                            ['label' => '添加角色', 'icon' => 'plus-square', 'url' => ['/role/add'],],
////
////                        ],
////                    ],
//
//
//
////
//                ],
            ]
        ) ?>

    </section>

</aside>
