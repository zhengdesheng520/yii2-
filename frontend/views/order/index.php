<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>填写核对订单信息</title>
	<link rel="stylesheet" href="/user_css/style/base.css" type="text/css">
	<link rel="stylesheet" href="/user_css/style/global.css" type="text/css">
	<link rel="stylesheet" href="/user_css/style/header.css" type="text/css">
	<link rel="stylesheet" href="/user_css/style/fillin.css" type="text/css">
	<link rel="stylesheet" href="/user_css/style/footer.css" type="text/css">

	<script type="text/javascript" src="/user_css/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="/user_css/js/cart2.js"></script>


</head>
<body>
	<!-- 顶部导航 start -->
    <?php

    include_once Yii::getAlias('@app/views/public/top.php');
    ?>
	<!-- 顶部导航 end -->
	
	<div style="clear:both;"></div>
	
	<!-- 页面头部 start -->
	<div class="header w990 bc mt15">
		<div class="logo w990">
			<h2 class="fl"><a href="index.html"><img src="/user_css/images/logo.png" alt="京西商城"></a></h2>
			<div class="flow fr flow2">
				<ul>
					<li>1.我的购物车</li>
					<li class="cur">2.填写核对订单信息</li>
					<li>3.成功提交订单</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- 页面头部 end -->
	
	<div style="clear:both;"></div>

	<!-- 主体部分 start -->
    <form action=""method="post" id="order">
        <input type="hidden"name="_csrf-frontend"value="<?=Yii::$app->request->csrfToken?>">
	<div class="fillin w990 bc mt15">
		<div class="fillin_hd">
			<h2>填写并核对订单信息</h2>
		</div>

		<div class="fillin_bd">
			<!-- 收货人信息  start-->
			<div class="address">
				<h3>收货人信息
<!--                    <a href="javascript:;" id="address_modify">[修改]</a>-->
                </h3>






				<div class="address_select">
					<ul>
                        <?php foreach ($address as $k=>$row):?>
						<li class="<?=$k==0?"cur":""?>">
							<input type="radio" name="address"value="<?=$row->id?>" <?=$row->status?"checked":""?> /><?=$row->name?> <?=$row->province?> <?=$row->city?> <?=$row->town?><?=$row->address?> <?=$row->phone?>
							<a href="">设为默认地址</a>
							<a href="">编辑</a>
							<a href="">删除</a>
						</li>
                        <?php endforeach;?>

					</ul>


				</div>
			</div>
			<!-- 收货人信息  end-->

			<!-- 配送方式 start -->
			<div class="delivery">
				<h3>送货方式 </h3>
<!--				<div class="delivery_info">-->
<!--					<p>普通快递送货上门</p>-->
<!--					<p>送货时间不限</p>-->
<!--				</div>-->

				<div class="delivery_select">
					<table>
						<thead>
							<tr>
								<th class="col1">送货方式</th>
								<th class="col2">运费</th>
								<th class="col3">运费标准</th>
							</tr>
						</thead>
						<tbody>
                        <?php foreach (Yii::$app->params['give'] as $k=>$v):?>
							<tr class="<?=$k==0?"cur":""?>">
<!--                                自定义属性data-price-->
                                <td><input type="radio" name="delivery"value="<?=$v['id']?>"data-price="<?=$v['price']?>" <?=$k==0?"checked":""?>/><?=$v['name']?></td>
                                <td><?=$v['price']?></td>
                                <td><?=$v['intro']?></td>

							</tr>
                        <?php endforeach;?>
						</tbody>
					</table>

				</div>
			</div> 
			<!-- 配送方式 end --> 

			<!-- 支付方式  start-->
			<div class="pay">
				<h3>支付方式</h3>


				<div class="pay_select">
					<table>
                        <?php foreach (Yii::$app->params['pay'] as $k=>$row):?>
						<tr class="<?=$k==0?"cur":""?>">
							<td class="col1">
                                <input type="radio" name="pay"value="<?=$row['id']?>" <?=$k==0?"checked":" "?>/><?=$row['name']?></td>
							<td class="col2"><?=$row['intro']?></td>
						</tr>
                        <?php endforeach;?>

					</table>

				</div>
			</div>
			<!-- 支付方式  end-->

			<!-- 发票信息 start-->
			<div class="receipt">
				<h3>发票信息</h3>
				<div class="receipt_info">
					<p>个人发票</p>
					<p>内容：明细</p>
				</div>

				<div class="receipt_select">
<!--					<form action="">-->
<!--						<ul>-->
<!--							<li>-->
<!--								<label for="">发票抬头：</label>-->
<!--								<input type="radio" name="type" checked="checked" class="personal" />个人-->
<!--								<input type="radio" name="type" class="company"/>单位-->
<!--								<input type="text" class="txt company_input" disabled="disabled" />-->
<!--							</li>-->
<!--							<li>-->
<!--								<label for="">发票内容：</label>-->
<!--								<input type="radio" name="content" checked="checked" />明细-->
<!--								<input type="radio" name="content" />办公用品-->
<!--								<input type="radio" name="content" />体育休闲-->
<!--								<input type="radio" name="content" />耗材-->
<!--							</li>-->
<!--						</ul>						-->
<!--					</form>-->
<!--					<a href="" class="confirm_btn"><span>确认发票信息</span></a>-->
				</div>
			</div>
			<!-- 发票信息 end-->

			<!-- 商品清单 start -->
			<div class="goods">
				<h3>商品清单</h3>
				<table>
					<thead>
						<tr>
							<th class="col1">商品</th>
							<th class="col3">价格</th>
							<th class="col4">数量</th>
							<th class="col5">小计</th>
						</tr>	
					</thead>
					<tbody>
                    <?php foreach ($goods as $k=>$v):?>
						<tr>
							<td class="col1"><a href=""><img src="<?=$v['logo']?>" alt="" /></a>  <strong><a href=""><?=$v['name']?></a></strong></td>
							<td class="col3">￥<?=$v['shop_price']?></td>
							<td class="col4"> <?=$v['num']?></td>
							<td class="col5">￥<span><?=$v['shop_price']*$v['num']?></span></td>
						</tr>
                    <?php  endforeach;?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="5">
								<ul>
									<li>
										<span>
                                            <?php
                                            $sum=0;
                                            foreach ($goods as $k=>$v){
                                                $sum+=$v['num'];

                                            }
                                            echo "总共".$sum;

                                            ?>
                                            件商品，总商品金额：</span>
                                        <strong>￥ <span id="totalPrice"><?=$totalPrice?>.00</span></strong>
									</li>

									<li>
										<span>运费：</span>
										<em>￥<span id="yunFei"><?=$yunFei[1]?></span></em>
									</li>
									<li>
										<span>应付总额：</span>
                                        <em>￥<span class="allPrice"><?=$allPrice?></span>.00</em>
									</li>
								</ul>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
			<!-- 商品清单 end -->
		
		</div>

		<div class="fillin_ft">
			<a href="javascript:void (0)" onclick="submit()"><span>提交订单</span></a>
			<p>应付总额：￥<strong class="allPrice"><?=$allPrice?></strong>.00元</p>
			
		</div>
	</div>
    </form>
	<!-- 主体部分 end -->

	<div style="clear:both;"></div>
	<!-- 底部版权 start -->
	<div class="footer w1210 bc mt15">
		<p class="links">
			<a href="">关于我们</a> |
			<a href="">联系我们</a> |
			<a href="">人才招聘</a> |
			<a href="">商家入驻</a> |
			<a href="">千寻网</a> |
			<a href="">奢侈品网</a> |
			<a href="">广告服务</a> |
			<a href="">移动终端</a> |
			<a href="">友情链接</a> |
			<a href="">销售联盟</a> |
			<a href="">京西论坛</a>
		</p>
		<p class="copyright">
			 © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号 
		</p>
		<p class="auth">
			<a href=""><img src="/user_css/images/xin.png" alt="" /></a>
			<a href=""><img src="/user_css/images/kexin.jpg" alt="" /></a>
			<a href=""><img src="/user_css/images/police.jpg" alt="" /></a>
			<a href=""><img src="/user_css/images/beian.gif" alt="" /></a>
		</p>
	</div>
	<!-- 底部版权 end -->
</body>
</html>
