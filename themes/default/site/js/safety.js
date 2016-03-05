//safety
$(function () {
    var img_size = [];
    setTimeout(function () {
        $(".safety_box").each(function (i) {
            var image = new Image(),
        _this = $(this),
        _img = $("img", _this);
            image.src = _img.attr("src");
            if (image.complete) {
                img_size[img_size.length] = { "width": image.width, "height": image.height }
                _img.width(_img.height() * image.width / image.height);
            } else { }
        })

        $(window).resize(function () {
            $(".safety_box,.safety_box .main").height($(window).height());
            $(".safety_box1,.safety_box1 .main").height($(window).height() - 38);
            $("body").stop().animate({ "scrollTop": webindex * $(window).height() });

            $(".safety_box").each(function (i) {
                var _this = $(this),
                _img = $("img", _this);
                _img.width(_img.height() * img_size[i].width / img_size[i].height);
            })
        }).trigger("resize");
    }, 100)
})

var direction = 0, webindex = 0;
if (document.addEventListener) { document.addEventListener('DOMMouseScroll', scrollFunc, false); }
var web_scroll = function (direction) {
    webindex = webindex + direction;
    if (webindex < 0) webindex = 0;
    else if (webindex > $(".safety_box1,.safety_box").length - 1) webindex = $(".safety_box1,.safety_box").length - 1;
    $("body").animate({ "scrollTop": webindex * $(window).height() + 128 });
}
var scrollFunc = function (e) {
    e = e || window.event;
    if (e.wheelDelta) { //ie滑轮事件
        if (e.wheelDelta > 0) { direction = -1; } else { direction = 1; }
    } else if (e.detail) {  //Firefox滑轮事件
        if (e.detail > 0) { direction = 1; } else { direction = -1; }
    }
    $("body").unbind('scroll');
    if (!$("body").is(":animated")) { web_scroll(direction); }
}
window.onmousewheel = document.onmousewheel = scrollFunc;

