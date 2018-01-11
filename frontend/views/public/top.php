<!-- 顶部导航 start -->
<div class="topnav">
    <div class="topnav_bd w1210 bc">
        <div class="topnav_left">

        </div>
        <div class="topnav_right fr">
            <ul>
                <li>
            <?php
            echo Yii::$app->user->isGuest?"您好，欢迎来到养猪城！[<a href='/user/login'>请登录</a>][<a href='/user/regist'>免费注册</a>]":"欢迎您：".Yii::$app->user->identity->username."[<a href='/user/logout '>注销登录</a>]";


            ?>


                </li>




                <li class="line">|</li>
                <li>我的订单</li>
                <li class="line">|</li>
                <li>客户服务</li>

            </ul>
        </div>
    </div>
</div>
<!-- 顶部导航 end -->