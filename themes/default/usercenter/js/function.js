$(function () {
    //input点击隐藏描述
    setTimeout(function () {
        $("input[type=text],input[type=password]").each(function () {
            if ($(this).val() != "") $(this).siblings(".input_desc").hide();
        }).focus(function () {
            $(this).siblings(".input_desc").hide();
        }).blur(function () {
            if ($(this).val() == "")
                $(this).siblings(".input_desc").show();
        });
        $(".input_desc").click(function () {
            $(this).siblings("input[type=text],input[type=password]").focus();
        });
    }, 500);
    $(".reg_form input").focus(function () {
        $(this).siblings(".Validform_checktip").show();
    }).blur(function () {
        $(this).siblings(".Validform_checktip").hide();
    })

    $(".user_menu dd.sel").parent("dl").show().parent("li").addClass("sel");

    $(".user_menu i").click(function () {
        var s = $(this).next("dl")
        if (s.is(":hidden"))
            s.slideDown();
        else
            s.slideUp();
    })
    
    $(".user_money_main .recharge_type dd").click(function () {
        var index = $(this).index();
        $(this).addClass("sel").siblings().removeClass("sel");
        $(".user_money_main .recharge_choose").eq(index).show().siblings(".recharge_choose").hide();
    })

    $(".user_money_main .recharge_choose li").click(function () {
        $(".user_money_main .recharge_choose li").removeClass("sel");
        $(this).addClass("sel")
    })
})