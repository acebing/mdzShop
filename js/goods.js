// 手机购买二维码显示与隐藏
$('.qrcode-wrap').on('mouseover', function(event) {
	$(this).children("div.qrcode_pop").show();
})
.on('mouseout', function(event) {
	$(this).children("div.qrcode_pop").hide();
});
// 商品属性
$('.goods_info_attr1 .si-warp ul li').on('click', function(event) {
	$(this).addClass('selected').siblings().removeClass('selected');
	// event.stopPropagation();
});
// 商品属性
$('.goods_info_attr2 .si-warp ul li').on('click', function(event) {
	$(this).addClass('selected').siblings().removeClass('selected');
	// event.stopPropagation();
});
// 商品介绍
 function goods_daile() {
 	$('.ETab .tab-main ul li').on('click', function(event) {
		$(this).addClass('current').siblings().removeClass('current');
		var i = $(this).index(),
		    tabCon = $(".ETab").find('#tab-con'),
		    tabconItem = $(".ETab .tab-con .item"),
		    detailContent = $(".ETab .tab-con .detail-content"),
		    guarantee =$(".guarantee");
		if (i===0) {
			tabconItem.eq(0).removeClass('none');
			tabconItem.eq(1).addClass('none');
			detailContent.removeClass('none');
		} else if(i===1) {
			tabconItem.eq(0).addClass('none');
			tabconItem.eq(1).removeClass('none');
			detailContent.addClass('none');
		} else if(i===2){
			 tabconItem.eq(0).addClass('none');
			tabconItem.eq(1).removeClass('none');
			detailContent.addClass('none');
			 tabCon.addClass('none');
		}else{
			 tabconItem.eq(0).addClass('none');
			tabconItem.eq(1).removeClass('none');
			detailContent.addClass('none');
			 tabCon.addClass('none');
			 guarantee.addClass('none');
		}

	});
 }
 goods_daile();
 function goodRank() {
 	var rank = $(".g-m-left .g-rank .mc-tab li");
 	rank.click(function() {
 		$(this).addClass('curr').siblings().removeClass('curr');
 		 	});
 }
 goodRank();

    