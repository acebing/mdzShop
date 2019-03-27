
$("input[name='signature']").change(function(){
  var isval = $(this).val();
  if(isval == 1){
      $("#signature").show();
  }else{
      $("#signature").hide();
  }
});

$(function(){
  
    
  $(".str_variable").hide();
  
  //表单验证
  $("#submitBtn").click(function(){
    if($("#agency_form").valid()){
      $("#agency_form").submit();
    }
  });

  $('#agency_form').validate({
    errorPlacement:function(error, element){
      var error_div = element.parents('div.label_value').find('div.form_prompt');
      element.parents('div.label_value').find(".notic").hide();
      error_div.append(error);
    },
    rules:{
      temp_id:{
        required:true
      },
      set_sign:{
        required:true
      },
      temp_content:{
        required:true
      },
      send_time:{
        required:true
      }
    },
    messages:{
      temp_id:{
        required:'<i class="icon icon-exclamation-sign"></i>'+temp_id_notic
      },
      set_sign:{
        required:'<i class="icon icon-exclamation-sign"></i>'+set_sign_notic
      },
      temp_content:{
        required:'<i class="icon icon-exclamation-sign"></i>'+temp_content_notic
      },
      send_time:{
        required:'<i class="icon icon-exclamation-sign"></i>'+send_time_notic
      }
    }
  });
});

$.divselect("#send_time_box","#send_time",function(obj){
  loadTemplate();
});
  
function loadTemplate(id)
{
  var orgContent = '';
  var curContent = $('#temp_content').val();
  
  if (orgContent != curContent && orgContent != '')
  {
    if (!confirm(save_confirm)){
      return;
    }
  }
  
  var tpl = $('#send_time').val();
  
  if(id){
    var id = '&id=' + id;
  }else{
    var id = "";
  }

  $.jqueryAjax('alitongxin_configure.php', 'act=loat_template&tpl=' + tpl + id, loadTemplateResponse, "GET", "JSON");
}

/**
 * 将模板的内容载入到文本框中
 */
function loadTemplateResponse(result, textResult)
{
  var personal;
  var company;
  
  if (result.error == 0){
    $("#temp_content").val(result.content);
  }
  
  if(result.tpl == 'sms_order_placed' || result.tpl == 'sms_order_payed'){
    personal = "consignee(收货人), order_mobile(联系方式)";
    company = "shop_name(店铺名称), order_sn(订单号), consignee(收货人), order_region(收货地区), address(收货地址), order_mobile(联系方式)";
  }else if(result.tpl == 'sms_order_shipped'){
    personal = "user_name(会员名称), consignee(收货人)";
    company = "shop_name(店铺名称), user_name(会员名称), consignee(收货人), order_sn(订单号)";
  }else if(result.tpl == 'sms_signin'){
    personal = "code(验证码), product(会员名称)";
    company = "code(验证码), product(会员名称)";
  }else if(result.tpl == 'sms_find_signin' || result.tpl == 'sms_code'){
    personal = "code(验证码)";
    company = "code(验证码)";
  }else if(result.tpl == 'sms_price_notic'){
        personal = "user_name(用户名), goodsname(商品名称), goodsprice(商品价格)";
        company = "user_name(用户名), goodsname(商品名称), goodsprice(商品价格)";
  }else if(result.tpl == 'sms_seller_signin'){
    personal = "login_name(登录账号),password(登录密码)";
    company = "seller_name( 商家名称), login_name(登录账号),password(登录密码)";
  }else if(result.tpl == 'store_order_code'){
    personal = "user_name(用户名),code(提货码)";
    company = "user_name(用户名), order_sn(订单号),code(提货码),store_address(门店地址)";
  }else if(result.tpl == 'user_account_code'){
    personal = "user_name(用户名),fmt_amount(申请金额),process_type(申请类型，提现或充值),examine(审核状态),user_money(余额)";
    company = "user_name(用户名),add_time(添加时间),fmt_amount(申请金额),process_type(申请类型，提现或充值),op_time(审核时间),examine(审核状态),user_money(余额)";
  } else if(result.tpl == 'sms_seller_grade_time'){
        personal = "username(用户名),gradeendtime(过期时间)";
        company = "username(用户名),gradeendtime(过期时间)";
    }
  
  if(result.tpl){
    $(".str_variable").show();
  }else{
    $(".str_variable").hide();
  }
  
  $("#personal").html(personal);
  $("#company").html(company);
}

function get_sms_template(){
  
  var set_sign = $(":input[name='set_sign']").val();
  var temp_id = $(":input[name='temp_id']").val();
  var temp_content = $(":input[name='temp_content']").val();
  var send_time = $(":input[name='send_time']").val();
  var sms_type = 1;
  
  $.jqueryAjax('alitongxin_configure.php', 'act=sms_template' + "&set_sign=" + set_sign + "&temp_id=" + temp_id + "&temp_content=" + temp_content + "&send_time=" + send_time + "&sms_type=" + sms_type, smsTemplateResponse, "GET", "JSON");
}

function smsTemplateResponse(result){
  if(result.error == 1){
    alert(set_sms_phone);
  }else if(result.error == 2){
    alert(sms_temp_set_notic);
  }else{
    alert(send_success);
  }
}
