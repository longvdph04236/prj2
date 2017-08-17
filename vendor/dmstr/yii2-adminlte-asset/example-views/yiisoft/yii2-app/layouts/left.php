<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Administrator</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>


        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Menu', 'options' => ['class' => 'header']],
                    ['label' => 'Người dùng', 'icon' => 'users', 'url' => ['user/index']],
                    [
                        'label' => 'Quản Lý Khu Vực',
                        'icon' => 'map-marker',
                        'url' => '#',
                        'items'=> [
                             ['label'=>'Quản lý Thành phố','icon'=>'location-arrow','url'=>['city/index'],],
                             ['label'=>'Quản lý Quận Huyện','icon'=>'street-view','url'=>['district/index'],],
                        ]

                    ],
                    ['label' => 'Comments', 'icon' => 'comments-o', 'url' => ['comments/index']]
                ],
            ]
        ) ?>

    </section>

</aside>
