
//会员基本信息 div仿select 
$.divselect("#user_grade","#user_grade_val");
$.divselect("#user_year","#year_val");
$.divselect("#user_month","#month_val");
$.divselect("#user_day","#day_val");

$(function(){
    $(":input[name='add_sub_user_money']").val(1);
    $(":input[name='add_sub_frozen_money']").val(1);
    
    checked_prop('money_status');

    $(":input[name='money_status']").click(function(){
        var index = $(this).val();
        
        if(index == 1){
            $("#label_user_money").hide();
            $("#label_frozen_money").show();
            $(":input[name='user_money']").val('');
        }else{
            $("#label_user_money").show();
            $("#label_frozen_money").hide();
            $(":input[name='frozen_money']").val('');
        }
    });
    
    $("#submitBtn").click(function(){
		if($("#account_info").valid()){
			//防止表单重复提交
			if(checkSubmit() == true){
				$(this).parents("form").submit();
			}else{
				return false;
			}
        }
    });
	
    $('#account_info').validate({
        errorPlacement:function(error, element){
            var error_div = element.parents('div.label_value').find('div.form_prompt');
            element.parents('div.label_value').find(".notic").hide();
            error_div.append(error);
        },
        rules : {
            change_desc : {
                required : true
            },
            user_money : {
                number : true
            },
            frozen_money : {
                number : true
            },
            rank_points : {
                digits : true
            },
            pay_points : {
                digits : true
            }
        },
        messages : {
            change_desc : {
                required : '<i class="icon icon-exclamation-sign"></i>'+'帐户变动原因不能为空'
            },
            user_money : {
                number : '<i class="icon icon-exclamation-sign"></i>'+'帐户变动原因不能为空'
            },
            frozen_money : {
                number :'<i class="icon icon-exclamation-sign"></i>'+'帐户变动原因不能为空'
            },
            rank_points : {
                digits : '<i class="icon icon-exclamation-sign"></i>'+'帐户变动原因不能为空'
            },
            pay_points : {
                digits : '<i class="icon icon-exclamation-sign"></i>'+'帐户变动原因不能为空'
            }
        }
    });
});
