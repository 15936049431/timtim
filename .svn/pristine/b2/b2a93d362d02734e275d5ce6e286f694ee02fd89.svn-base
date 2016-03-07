monitor.setProject('cse_mainpage').getTrack().getClickAndKeydown();
$(function() {
	var ie6 = window.ActiveXObject && !window.XMLHttpRequest;
	$(document).on('selectstart', function() {
		return false;
	});
	$(document).on('mousewheel', function(e) {
		if (e.originalEvent.wheelDelta > 0) {
			Slider.slidePrev();
		} else {
			Slider.slideNext();
		}
	});
	$('#nav a').on('mousedown', function() {
		Slider.slideTo($(this).parent().index())
	});
	var Slider = function() {
		var DURATION = 300;
		var count = $('#slider li').length;
		var current = 0;
		var animating = false;

		function slideTo(idx) {
			if (animating || idx == current) {
				return;
			}
			if (idx < 0) {
				idx = count - 1;
			} else if (idx >= count) {
				return;//idx = 0;
			}
			var up = (idx > current) || (idx == current - count + 1);
			var $lis = $('#slider li');
			var $current = $lis.eq(idx);
			var $prev = $('#slider li.current');
			var offset = $current.height();
			animating = true;
			$current.show().css({
				top: up ? offset : -offset
			}).animate({
				top: 0
			}, DURATION, function() {
				$(this).addClass('current');
				$('#nav li').removeClass('current').eq(idx).addClass('current');
				animating = false;
			});
			$prev.animate({
				top: up ? -offset : offset
			}, DURATION, function() {
				$(this).removeClass('current').hide();
			});
			var $arrow = $('.arrow');
			if (idx == count - 1) {
				$arrow.hide();
			} else {
				$arrow.show();
			}
			current = idx;
			startAutoPlay();
		}
		var timer;

		function startAutoPlay() {
			stop();
			// timer = setTimeout(Slider.slideNext, 5000);
		}

		function stop() {
			timer && clearTimeout(timer);
		}
		return {
			slideTo: slideTo,
			slidePrev: function() {
				if (current == 0) return;
				slideTo(current - 1);
			},
			slideNext: function() {
				slideTo(current + 1);
			},
			startAutoPlay: startAutoPlay,
			stop: stop
		}
	}();
	if (!ie6) {
		Slider.startAutoPlay();
	}
	//手机手势滑动
	var begin_y = 0,
		end_y = 0;
	$("document,body").on("touchstart", function(event) {
		var touch = event.originalEvent.targetTouches[0];
		begin_y = Number(touch.pageY);
		return false;
	}).on("touchmove", function(event) {}).on("touchend", function(event) {
		var touch = event.originalEvent.changedTouches[0];
		end_y = Number(touch.pageY);
		if (begin_y - end_y < -100) {
			Slider.slidePrev();
		} else if (begin_y - end_y > 100) {
			Slider.slideNext();
		}
		return false;
	});
	var ua = navigator.userAgent.toLowerCase();
	if (ua.indexOf("android") > -1 || ua.indexOf("iphone") > -1 || ua.indexOf("ipad") > -1) {
		$(".arrow").hide();
	}
	window.onerror = function() {
		return true
	};
	(function() {
		$('.arrow').on('click', function() {
			Slider.slideNext();
		});
	})();
});
