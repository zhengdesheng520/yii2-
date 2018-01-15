/*
@功能：购物车页面js
@作者：diamondwang
@时间：2013年11月14日
*/

//添加提交方法
function submit() {
	document.getElementById('order').submit();

}


$(function(){
 		// 添加点击配送方式从新计算应付金额
	$("input[name=delivery]").change(function () {
		// console.debug(111);
		//找到当前input框下的属性为data-price的；
		var yunfei=$(this).attr('data-price');
		// console.dir(yunfei);
		//添加到对应的地方
		$("#yunFei").text(yunfei);
		var totalPrice=$('#totalPrice').text();
		// console.debug(totalPrice);
		var allMoeny=totalPrice*1+yunfei*1;
		//取小数点后两位toFixed
		allMoeny=allMoeny.toFixed(2);
		console.debug(allMoeny);
		//把总金额展示出来
		$(".allPrice").text(allMoeny);




    });




	//收货人修改
	$("#address_modify").click(function(){
		$(this).hide();
		$(".address_info").hide();
		$(".address_select").show();
	});

	$(".new_address").click(function(){
		$("form[name=address_form]").show();
		$(this).parent().addClass("cur").siblings().removeClass("cur");

	}).parent().siblings().find("input").click(function(){
		$("form[name=address_form]").hide();
		$(this).parent().addClass("cur").siblings().removeClass("cur");
	});

	//送货方式修改
	$("#delivery_modify").click(function(){
		$(this).hide();
		$(".delivery_info").hide();
		$(".delivery_select").show();
	})

	$("input[name=delivery]").click(function(){
		$(this).parent().parent().addClass("cur").siblings().removeClass("cur");
	});

	//支付方式修改
	$("#pay_modify").click(function(){
		$(this).hide();
		$(".pay_info").hide();
		$(".pay_select").show();
	})

	$("input[name=pay]").click(function(){
		$(this).parent().parent().addClass("cur").siblings().removeClass("cur");
	});

	//发票信息修改
	$("#receipt_modify").click(function(){
		$(this).hide();
		$(".receipt_info").hide();
		$(".receipt_select").show();
	})

	$(".company").click(function(){
		$(".company_input").removeAttr("disabled");
	});

	$(".personal").click(function(){
		$(".company_input").attr("disabled","disabled");
	});

});