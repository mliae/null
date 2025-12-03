/*================================
 Window tips
================================*/
function tips_add(msg) {
    var obj = $('#notification')
    if ( obj[0] ) return false;
    var title = '<span class="icon Q-quill"></span> '+msg;
    var html = '<div id="notification" class="js-msg"><div class="title">'+ title +'</div><div class="info"></div></div><!-- #notification #-->';
    $('body').append(html);
}

function tips_remove() {
    var notification = $('#notification')[0];
    if (notification) notification.remove();
}

function tips_update(content) {
    tips_add('通知');
    var notification = $('#notification'),
        info = $('#notification .info');
    if ( info.hasClass('has') ) {
        clearTimeout(closeNotification);
        info.removeClass('has');
    }
    var msg = '<span class="msg">'+ content +'</span>';
    info.html(msg);
    info.addClass('has');
    notification.show();
    closeNotification = setTimeout(function() {
        notification.slideUp(300, function() {
            //tips_remove();
        });
    }, 6000);
}
//琛ㄦ儏
function OwO_add(){
	var obj = $('#OwO')
    if ( obj[0] ) return false;
	//琛ㄦ儏鍒楄〃
	for(var i = 1; i <= 39; i++){
		$('.OwO-items').append('<a class="OwO-item" id="OwO" data-action="addSmily" data-smilies="smilies'+i+'"><img src="'+Null_data.TEMPLATE_URL+'images/face/'+i+'.png"></a>');
	}
	$(function owo() {
		var aluContainer = document.querySelector('.OwO-items');
		if (!aluContainer) return;
		$('.OwO-item').on('click', function(e) {
			var myField, _self = e.target.dataset.smilies ? e.target : e.target.parentNode,
				tag = '[' + _self.dataset.smilies + ']';
			if (document.getElementById('comment') && document.getElementById('comment').type == 'textarea') {
				myField = document.getElementById('comment')
			} else {
				return false
			}
			if (document.selection) {
				myField.focus();
				sel = document.selection.createRange();
				sel.text = tag;
				myField.focus()
			} else if (myField.selectionStart || myField.selectionStart == '0') {
				var startPos = myField.selectionStart;
				var endPos = myField.selectionEnd;
				var cursorPos = endPos;
				myField.value = myField.value.substring(0, startPos) + tag + myField.value.substring(endPos, myField.value.length);
				cursorPos += tag.length;
				myField.focus();
				myField.selectionStart = cursorPos;
				myField.selectionEnd = cursorPos
			} else {
				myField.value += tag;
				myField.focus()
			}
		});
	});
}
//poster_share_add
function poster_share_add(src) {
    //var obj = $('.poster-share')
    //if ( obj[0] ) return false;
	
    var html = '<div class="poster-share" id="post_qrcode"><div class="dialog-content dialog-wechat-content windowed"><img class="weixin_share" src="'+src+'"><div class="btn-close"><i class="icon Q-close"></i></div></div></div>';
    $('body').append(html);
	$('body').append('<div class="dialog_overlay"></div>');
	$('.poster-share').addClass('open');
	$(".poster-share .btn-close").click(function () {
		$('.poster-share').removeClass('open');
		$('.dialog_overlay, .poster-share').remove();
	});
}
/*================================
 Loading
================================*/
function loading_template() {
    var html = '<div class="loader">';
        html += '<div class="circle"></div>';
        html += '<div class="circle"></div>';
        html += '<div class="circle"></div>';
        html += '<div class="circle"></div>';
        html += '<div class="circle"></div>';
        html += '</div>';

    return html;
}

function loading_start(target) {
    target.append( loading_template() );
}

function loading_done(target) {
    target.children('.loader').remove();
}
// 淇敼婊氬姩鏉�
function hide_scroll() {
    $('html').css('overflow-y', 'hidden');
    $('body').addClass('fix');
    fixbar = $('#fixedbar');
    if ( fixbar.hasClass('fix') ) {
        fixbar.addClass('fixed');
    }
}

function show_scroll() {
    $('html').css('overflow-y', 'auto');
    $('body').removeClass('fix');
    fixbar = $('#fixedbar');
    if ( fixbar.hasClass('fix') ) {
        fixbar.removeClass('fixed');
    }
}

/*================================
 Overlay add & remove
================================*/
function overlay_add(name) {
    var tag = '<section id="overlay" class="'+ name +'"><div id="modal" class=""><div class="windowed"></div></div></section>';
    if ( !$( '#overlay.'+ name )[0] ) {
        $('body').append(tag);
    }
}

function overlay_remove(name) {
    $('.'+name).click(function(e) {
        if (e.target.id == 'overlay') {
            $(this).slideUp(300, function() {
                $(this).remove();
            });
            show_scroll();
        }
    });
}

function overlay_disappear(name) {
    $('#overlay.' + name).slideUp(300, function() {
        $('#overlay.' + name).remove();
    });
    show_scroll();
}


//get_post_data
function get_post_data(id, url, execute) {
    className = 'jspost';
    $.ajax({
        type: 'POST',
        data: {
            action: 'ajax_content_post',
            id: id,
        },
        dataType:'html',
        timeout : 6000,
        beforeSend:function() {
            overlay_add(className);
            modal = $('#overlay #modal');
            loading_start(modal);
        },
        error:function(request, status, err) {
            if ( status == 'timeout' ) {
                alert("加载超时了~");
                location.replace(url); // 寤惰繜6绉掑悗鑷姩閲嶈浇
            }
            overlay_disappear(className);
        },
        success:function(data) {
            hide_scroll();
			loading_done(modal);
            modal.append(data);//modal.html(data);
            if ( execute ) execute();
            window.addEventListener('popstate', function(e) {
                overlay_remove(className);
            },false);

            $('.full-link, .post-tags a, .meta a').click( function(e) {
				e.preventDefault(); // 鍘婚櫎榛樿浜嬩欢
				var url = $(this).attr("href");
				pjax.loadUrl(url);
				overlay_disappear(className);
            });
            overlay_remove(className);
        }
    }); // end ajax
    return;
}

//点赞
function slzanpd_check(id) {
	return new RegExp('slzanpd_' + id + '=true').test(document.cookie);
}
/*-----------Dajiba-----------*/
Dajiba = {
	Ajax_Single: function () {
		$("body").on("click",".preview .post",function(e){
			var id = $(this).data("id"),url = $(this).data('url');
			var tags = 'a, .preview .post a, .f-bottom>a, .aplayer', targetObj = e.srcElement ? e.srcElement : e.target; // 鎺掗櫎鏌愪簺鏍囩
			if ( !$(targetObj).parents().addBack().is(tags) && id && url ){
				get_post_data(id, url, function(){
					Dajiba.LIKE();
					Dajiba.REWARD();
					Dajiba.Poster_Share();
					Prism.highlightAll();
					//鐏
					baguetteBox.run('#overlay #modal', {
						animation: 'fadeIn',//鍒囨崲鏁堟灉
						noScrollbars: true,//绂佹婊氬姩
						fullScreen: false,//鍏ㄥ睆娴忚
						async: true,//寮傛鍔犺浇鏂囦欢
						captions: function(element) {
							return element.getElementsByTagName('img')[0].alt;
						}
					});
					Dajiba.F_lazy();
				});
			}
		});
    },
	DJ: function() {
		// 鎼滅储妗�
		$('.js-toggle-search').on('click', function() {
			$('.js-toggle-search').toggleClass('is-active');
			$('.js-search').toggleClass('is-visible');
		});

		//瀵艰埅
		$(document).on('click', 'a.header-btn,a.header-off,#mo-nav ul li a', function() {
			if ($('body').is('.header-show')) {
				$('body').removeClass('header-show');
			} else {
				$('body').addClass('header-show');
			}
		});
		//返回顶部
		$('.back2top').click(function() {
			$('html,body').animate({
                scrollTop: 0
            },1000),
            !1
		});
		$(window).scroll(function() {
			$(window).scrollTop() > 100 ? jQuery(".back2top").css({
        		bottom: "2%"
    		}) : jQuery(".back2top").css({
      			bottom: "-110px"
  			})
		});
		//浜岀淮鐮�
		$('#mo-nav .m-avatar .qrcode').click(function() {
			poster_share_add($(this).data('src'));
			//$('img.weixin_share').attr('src', $(this).data('src'));
			
		});

	},
	DX: function() { // 鐏
		baguetteBox.run('.main-central', {
			noScrollbars: true,
			captions: function(element) {
				return element.getElementsByTagName('img')[0].alt;
			}
		});
	},
	F_lazy: function() {
		$("img.lazy").lazyload();
	},
	LIKE: function () {
		//Ajax-like
		$.fn.postLike = function () {
			var id = $(this).data("gid");
			if ($(this).hasClass('done')||slzanpd_check(id)) {
				tips_update('您已经点过赞了~');
				return false;
			} else {
				$(this).addClass('done');
				var action = $(this).data('action'),
					rateHolder = $(this).children('.count');
				var ajax_data = {
					plugin: 'slzanpd',
					action: action,
					id: id,
				};
				//Null_data.BLOG_URL
				$.post(Null_data.BLOG_URL, ajax_data,
					function (data) {
						$(rateHolder).html(data);
					});
				return false;
			}
		};
		$(".like").click(function () {
			$(this).postLike();
		});
	},	
	mlike: function () {
		//Do you like me?
		$(".like-vote").click(function() {
			if ($(".like-title").html() === "Do you like me?") {
				$.post(Null_data.BLOG_URL, {action: 'ajax_mlike_add'},
					function (data) {
						data.success?($(".like-vote span").html(data.like), $(".like-title").html("我也喜欢你")):($(".like-title").html("你的爱我已经感受到了~"));
					}, 'json');
			}
		});
	},	
	REWARD: function () {
		//reward-click
		$(".reward-click").click(function () {
			if ($(".reward").hasClass('open')) {
				$(".reward").removeClass('open');
			} else {
				$(".reward").addClass('open');
			}
		});
	},
	Poster_Share: function () {
		//Poster-Share-click
		$(".poster-share-click").click(function () {
			//poster_share_add($(this).data("src"));
			window.open($(this).attr("data-url"));
			//$('img.weixin_share').attr('src', $(this).data("src"));
			//$('body').append('<div class="dialog_overlay"></div>');
			//$('.poster-share').addClass('open');
		});
	},
	BB: function() {
		//Ajax-JSON瀹炴椂鑾峰彇璇勮澶村儚
		$("input#email").blur(function() {
			var _email = $(this).val();
			if (_email != '') {
				$.ajax({
					type: 'POST',
					url: Null_data.TEMPLATE_URL + 'ajax/user.php', // Ajax璺緞
					data: {
						action: 'ajax_avatar_get',  
						email: _email
					},
					success: function(data) {
						$('.ajaxurl').attr('src', data); // 澶村儚鏍囩
					}
				}); // end ajax
			}
			return false;
		});
		//琛ㄦ儏
		$(function() {
			$('.OwO-logo').on('click', function() {
				OwO_add();
				$('.OwO').toggleClass('OwO-open');
			});
		});
		//ajax璇勮鎻愪氦
		$(document).ready(function() {
			$("#commentform").submit(function() {
				var a = $("#commentform").serialize();
				$("#comment").attr("disabled", "disabled");
				$(".wantcom").html('请稍等，正在提交评论中...');
		        $.post($("#commentform").attr("action"), a, function(a) {
					if(Null_data.EMLOG_VERSION<"6.1.1"){
						var c = /<div class=\"main\">[\r\n]*<p>(.*?)<\/p>/i;
					}else{
						var c = /<div class=\"layui-card-body\">[\r\n]*(.*?)<p>(.*?)<\/p>/i;
					}
		            c.test(a) ? (
					    $(".wantcom").html('<div id="error"></div>'),
						$("#error").html(a.match(c)[1]).show().fadeOut(2500),
						$("#error").show()
					) : (
						c = $("input[name=pid]").val(),
						cancelReply(),
						$("[name=comment]").val(""),
						$(".comment-lists").html($(a).find(".comment-lists").html()),
						$(".comment-pagenavi").html($(a).find(".comment-pagenavi").html()),
						$(".wantcom").html($(a).find(".wantcom").html()),
						0 != c ? (
							a = window.opera ? "CSS1Compat" == document.compatMode ? $("html") : $("body") : $("html,body"), a.animate({
						scrollTop: $("#comment-" + c).offset().top - 200
							}, "normal", function() {
						$(".wantcom").html($(a).find(".wantcom").html())
							})
						) : (
							a = window.opera ? "CSS1Compat" == document.compatMode ? $("html") : $("body") : $("html,body"), a.animate({
							scrollTop: $(".comment-lists").offset().top - 200
							}, "normal", function() {
								$(".wantcom").html($(a).find(".wantcom").html())
							})
						)
					);
          		  $("#comment").attr("disabled", !1)
        		});
				return !1
			})

		});
		Prism.highlightAll(); //浠ｇ爜楂樹寒
	},
  	// 鍒囨崲鏂囩珷绫诲瀷
  	postType:function() {
		$('#post-type ul li').on('click',function(){
          	if(!$(this).hasClass('current')) {
                $('.current').removeClass('current');
                $(this).addClass('current');
              	$('.main-list article').remove();
              	var href = $(this).find('a').attr("ajaxhref");
				$(".navigator a#ajax").hide();
				modal = $('.navigator');
				modal.addClass('loading');
				loading_start(modal);
              	if (href != undefined) {
                    $.ajax({ 
                        url: href,
                        type: "get",
                        error: function(request) {
                            tips_update('加载错误!请联系网站管理员！');
                        },
                        success: function(data) {
							modal.removeClass('loading');
							loading_done(modal);
                            var $result = $(data).find(".main-list article");
                            $('.main-list').append($result.fadeIn(1000));
                            var nexthref = $(data).find(".navigator a#ajax").attr("href");
                          	if (nexthref != undefined) {
                              	$(".navigator a#ajax").attr("href", nexthref).text("LOADING MORE").show();
                              	$(".navigator").show();
                            } else {
								$(".navigator a#ajax").hide();
                            } 
							chongzai.listajax();
                        }
                    });                  
                }
            }
		});
	},


};
/*-----------Dajiba-end----------*/
$(function() {
	Dajiba.DJ();
	Dajiba.DX();
	Dajiba.LIKE();
	Dajiba.mlike();
	Dajiba.BB();
	Dajiba.postType();
	Dajiba.REWARD();
	Dajiba.Poster_Share();
	Dajiba.F_lazy();
	Dajiba.Ajax_Single();
	
});
//閲嶈浇
chongzai = {
	listajax:function() {
		var pjax = new Pjax({
			elements: "#ajax_a a[href]:not([no-pjax])",
			cacheBust: false,
			debug: false,
			selectors: ['title', '.main-central']
		});
		Dajiba.F_lazy();
		Dajiba.DX();
		Dajiba.LIKE();
	}
};
jQuery(document).ready(function($) {
	//ajax璇勮缈婚〉
	$body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
	$(document).on('click', '.comment-pagenavi a', function(e) {
		e.preventDefault();
		$.ajax({
			type: "GET",
			url: $(this).attr('href'),
			beforeSend: function() {
				$('.comment-pagenavi').remove();
				$('.comment-lists').remove();
				
				modal = $('#comments-loading');
				modal.addClass('loading');
				modal.slideDown();
				loading_start(modal);
			},
			dataType: "html",
			success: function(out) {
				result = $(out).find('.comment-lists');
				nextlink = $(out).find('.comment-pagenavi');
				modal.slideUp(550);
				modal.after(result.fadeIn(800));
				modal.removeClass('loading');
				loading_done(modal);
				
				$('.comment-lists').after(nextlink)
			}
		})
	})

	//ajax鐐瑰嚮鍔犺浇鏇村
	$(document).on('click', '.navigator a#ajax', function() {
		let hrefThis = $(this);
		hrefThis.hide();
		modal = $('.navigator');
		modal.addClass('loading');
		loading_start(modal);
		let pageHref = hrefThis.attr("href"); //鑾峰彇涓嬩竴椤电殑閾炬帴鍦板潃
		if (pageHref) { //濡傛灉鍦板潃瀛樺湪
			$.ajax({ //鍙戣捣ajax璇锋眰
				url: pageHref,
				//璇锋眰鐨勫湴鍧€灏辨槸涓嬩竴椤电殑閾炬帴
				type: "get",
				//璇锋眰绫诲瀷鏄痝et
				error: function(request) {
					tips_update('加载失败!请联系网站管理员！');
				},
				success: function(data) { //璇锋眰鎴愬姛
					modal.removeClass('loading');
					loading_done(modal);
					let result = $(data).find(".main-list .post"); //浠庢暟鎹腑鎸戝嚭鏂囩珷鏁版嵁锛岃鏍规嵁瀹為檯鎯呭喌鏇存敼
					$('.main-list').append(result); //灏嗘暟鎹姞杞藉姞杩沵ain-list鐨勬爣绛句腑銆�
					let newHref = $(data).find(".navigator a#ajax").attr("href"); //鎵惧嚭鏂扮殑涓嬩竴椤甸摼鎺�
					chongzai.listajax();
					if (newHref) {
						hrefThis.attr("href", newHref).show();
					} else {
						$(".navigator a#ajax").hide();
					}
					return false;
				}
			});
		}else{
			modal.removeClass('loading');
			loading_done(modal);
		}
		return false;
	});
	

	$(document).on('click', '.t-right .btn', function() {
		var form = new FormData(document.getElementById("Form"));
		$.ajax({
			url:Null_data.BLOG_URL + "?action=twitter",
			type:"POST",
			data:form,
			processData:false,
			contentType:false,
			mimeType:"multipart/form-data",
			success:function(data){
				var reg = RegExp(/ok,/);
				if(data.match(reg)){
					tips_update('鍙戣〃鎴愬姛!');
					pjax.loadUrl(Null_data.BLOG_URL + "t");
				}else{
					tips_update(data);
				}
			},
			error:function(e){
				tips_update("缃戠粶灏忓濮愬嚭宸簡");
			}
		});  
		return false;
	});
  
	//寰闊抽鎾斁鍣�
	nullPlayer = null;
	thisMusicId = -1;
	isPlayingMusic = false;
	$(document).on('click', '.play', function() {
		//console.log(thisMusicId, isPlayingMusic);
		var mid = $(this).data('mid');

		if(isPlayingMusic && mid == thisMusicId && !nullPlayer.paused){
			nullPlayer.pause();//鏆傚仠
			$('#play-' + mid).removeClass('playing');
			thisMusicId = mid;
			isPlayingMusic = false;
			//鏆傚仠
			//console.log('鏆傚仠', thisMusicId, isPlayingMusic);
		}else{
			if(thisMusicId != mid && isPlayingMusic){
				var playoff = '#play-' + thisMusicId;
				//console.log(playoff);
				$(playoff).removeClass('playing');
				nullPlayer.pause();//鏆傚仠涓婁竴闊抽
			}
			//m.paused  //鏄惁鏆傚仠
			thisMusicId = mid;
			//閫氳繃getElementById(ID)鏂规硶鑾峰彇鍒颁竴涓猘udio瀵硅薄
			nullPlayer = document.getElementById('music-' + mid);
			
			$(this).addClass('playing');
			nullPlayer.play();//鎾斁
			isPlayingMusic = true;
			//console.log('鎾斁', thisMusicId, isPlayingMusic);
		}
		
	});
	
});

//pjax鍙傛暟閰嶇疆
var pjax = new Pjax({
	elements: 'a[href]:not([no-pjax])',
	// default is "a[href], form[action]"   a:not([href^="#"])      #main a,#mo-nav a,.echo_log a
	cacheBust: false,
	debug: false,
	selectors: ['title',
	'meta[name=keywords]',
	'meta[name=description]',
	'.main-central']
});

//鍦≒jax璇锋眰寮€濮嬪悗瑙﹀彂
document.addEventListener('pjax:send', function() {
	//鍔犺浇鍔ㄧ敾
	$('html').addClass('load');
	$('.main-central').addClass('out');
	$('.back2top').click();
});

//鍦≒jax璇锋眰瀹屾垚鍚庤Е鍙�
document.addEventListener('pjax:complete', function() {
	//閲嶈浇鍑芥暟
	Dajiba.DX();
	Dajiba.BB();
	Dajiba.LIKE();
	Dajiba.postType();
	Dajiba.REWARD();
	Dajiba.Poster_Share();
	Dajiba.F_lazy();
});

//鍦≒jax璇锋眰鎴愬姛鍚庤Е鍙�
document.addEventListener('pjax:success', function() {
	//鍔犺浇鍔ㄧ敾
	$('html').removeClass('load');
	$('.main-central').removeClass('out');
});

//Pjax璇锋眰澶辫触鍚庤Е鍙戯紝璇锋眰瀵硅薄灏嗕綔涓轰竴璧蜂紶閫抏vent.options.request
document.addEventListener('pjax:error', function() {
	bar('绯荤粺鍑虹幇闂锛岃鎵嬪姩鍒锋柊涓€娆�', '3000');
});
//鎼滅储浜嬩欢澶勭悊
$(document).on('submit', '.search-form', function(e) {
	e.preventDefault(); // 鍘婚櫎鎼滅储妗嗛粯璁や簨浠�
	var site = document.location.origin,BLOG_URL=$(".search-modal").attr("action"),
		val = $('.search-form .text-input').val(),
		search = BLOG_URL + '?keyword=' + val;
	pjax.loadUrl(search);

});
$(document).on('submit', '.search-modal', function(e) {
	e.preventDefault(); // 鍘婚櫎鎼滅储妗嗛粯璁や簨浠�
	var site = document.location.origin,BLOG_URL=$(".search-modal").attr("action"),
		val = $('.search-modal .text-input').val(),
		search = BLOG_URL + '?keyword=' + val;
	pjax.loadUrl(search);

});


function commentReply(a) {
	var c = document.getElementById("comment-post");
	document.getElementById("cancel-reply").style.display = "";
	document.getElementById("comment-pid").value = a;
	document.getElementById("content-" + a).appendChild(c);
}

function cancelReply() {
	var a = document.getElementById("comment-place"),
		b = document.getElementById("comment-post");
	document.getElementById("comment-pid").value = 0;
	document.getElementById("cancel-reply").style.display = "none";
	a.appendChild(b)
}
/*================================
 Banner
================================*/
var banner_count = 0,
banner_to = $('#banner-2')[0],
banner_bg = $('.banner.bg'),
banner_time = banner_bg.data('time');
function banner() {
    var image = $('#banner-data img'),
        arr = new Array(), count = 0,
        df = banner_bg.css('background-image');
    $.each(image, function(i) {
        arr[i] = $(this).attr('src');
        count++;
    });
    arr[count] = df;
    timer = setInterval(function () {
        banner_count++;
        if (count == banner_count) {
            banner_count = 0;
        }
        banner_bg.css('background-image', 'url('+arr[banner_count]+')');
        //console.log(arr[banner_count]);
    },banner_time);
}
if ( banner_to && banner_time != '') {
    banner();
}



window.onload = function() {
	console.log("%cEmlog Theme NullTwo", "line-height: 50px; text-shadow: 0 1px 0 #ccc,0 2px 0 #c9c9c9,0 3px 0 #bbb,0 4px 0 #b9b9b9,0 5px 0 #aaa,0 6px 1px rgba(0,0,0,.1),0 0 5px rgba(0,0,0,.1),0 1px 3px rgba(0,0,0,.3),0 3px 5px rgba(0,0,0,.2),0 5px 10px rgba(0,0,0,.25),0 10px 10px rgba(0,0,0,.2),0 20px 20px rgba(0,0,0,.15);font-size:30px", "", 'v'+Null_data.Theme_Version)
	console.log("%c 微信 %c", "background:#24272A; color:#ffffff", "", "Diamond0422");
	console.log( document.domain );
	var now = new Date().getTime();
	var page_load_time = now - performance.timing.navigationStart;
	console.log('%c加载所需时间' + Math.round(performance.now() * 100) / 100 + 'ms', 'background: #fff;color: #333;text-shadow: 0 0 2px #eee, 0 0 3px #eee, 0 0 3px #eee, 0 0 2px #eee, 0 0 3px #eee;');
};