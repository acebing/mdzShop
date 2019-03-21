// 表格全选/单选状态
$(document).on("click","input[name='all_list']",function(){
    if($(this).prop("checked") == true){
      $(".list-div").find("input[type='checkbox']").prop("checked",true);
      $(".list-div").find("input[type='checkbox']").parents("tr").addClass("tr_bg_org");
    }else{
      $(".list-div").find("input[type='checkbox']").prop("checked",false);
      $(".list-div").find("input[type='checkbox']").parents("tr").removeClass("tr_bg_org");
    }
    btnSubmit();
  });
// 表格全选按钮状态
  function btnSubmit(){
    var length = $(".list-div").find("input[name='checkboxes[]']:checked").length;
    
    $(".list-div").find("input[name='checkboxes[]']:checked").parents("tr").addClass("tr_bg_org");
    
    if(length>0){
      if($("#listDiv *[ectype='btnSubmit']").length>0){
        $("#listDiv *[ectype='btnSubmit']").removeClass("btn_disabled");
        $("#listDiv *[ectype='btnSubmit']").attr("disabled",false);
      }
    }else{
      if($("#listDiv *[ectype='btnSubmit']").length>0){
        $("#listDiv *[ectype='btnSubmit']").addClass("btn_disabled");
        $("#listDiv *[ectype='btnSubmit']").attr("disabled",true);
      }
    }
  }
  //默认执行
  btnSubmit();
  $(document).click(function(e){
    /*
    **点击空白处隐藏展开框  
    */
    
    //会员搜索
    if(e.target.id !='user_name' && !$(e.target).parents("div").is(".select-container")){
      $('.selection_select .select-container').hide();
    }
    //卖场搜索
    if(e.target.id !='rs_name' && !$(e.target).parents("div").is(".select-container")){
      $('.rs_select .select-container').hide();
    }
    //品牌
    if(e.target.id !='brand_name' && !$(e.target).parents("div").is(".brand-select-container")){  
      $('.brand-select-container').hide();
      $('.brandSelect .brand-select-container').hide();
    }
    //分类
    if(e.target.id !='category_name' && !$(e.target).parents("div").is(".select-container")){
      $('.categorySelect .select-container').hide();
    }
    //仿select
    if(e.target.className !='cite' && !$(e.target).parents("div").is(".imitate_select")){
      $('.imitate_select ul').hide();
    }
    //日期选择插件
    if(!$(e.target).parent().hasClass("text_time")){
      $(".iframe_body").removeClass("relative");
    }
    //查看案例
    if(e.target.className !='view-case-tit' && !$(e.target).parents("div").is(".view-case")){
      $('.view-case-info').hide();
    }
  });
  //操作提示展开收起
  $("#explanationZoom").on("click",function(){
    var explanation = $(this).parents(".explanation");
    var width = $(".layui-body").width();
    if($(this).hasClass("shopUp")){
      $(this).removeClass("shopUp");
      $(this).attr("title","收起提示");
      explanation.find(".ex_tit").css("margin-bottom",10);
      explanation.animate({
        width:width-28
      },300,function(){
        $(".explanation").find("ul").show();
      });
    }else{
      $(this).addClass("shopUp");
      $(this).attr("title","提示相关设置操作时应注意的要点");
      explanation.find(".ex_tit").css("margin-bottom",0);
      explanation.animate({
        width:"100"
      },300);
      explanation.find("ul").hide();
    }
  });