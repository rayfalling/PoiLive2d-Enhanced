<?php
header( "Content-type: application/javascript; charset: UTF-8" );

//make get_option effective
require_once( '../../../../../wp-config.php' );

echo 'const live2d_Path = "' . LIVE2D_URL . '/live2d/model/poi/";';
echo 'const message_Path = "' . LIVE2D_URL . '/live2d/";';
echo 'const home_Path = "' . home_url() . '/";';

if ( get_option( 'live2d_hitokoto' ) == "checked" ) {
	$noHitoKoto = 'false';
} else {
	$noHitoKoto = 'true';
}
if ( get_option( 'live2d_special_tip' ) == "checked" ) {
	$noSpecialTip = 'false';
} else {
	$noSpecialTip = 'true';
}
if ( get_option( 'live2d_localkoto' ) == "checked" ) {
	$localKoto = 'true';
} else {
	$localKoto = 'false';
}

?>

function renderTip(template, context) {
    const tokenReg = /(\\)?\{([^\{\}\\]+)(\\)?\}/g;
    return template.replace(tokenReg, function (word, slash1, token, slash2) {
        if (slash1 || slash2) {
            return word.replace('\\', '');
        }
        const variables = token.replace(/\s/g, '').split('.');
        let currentObject = context;
        let i, length, variable;
        for (i = 0, length = variables.length; i < length; ++i) {
            variable = variables[i];
            currentObject = currentObject[variable];
            if (currentObject === undefined || currentObject === null) return '';
        }
        return currentObject;
    });
}

String.prototype.renderTip = function (context) {
    return renderTip(this, context);
};


if ('false' === <?php echo $noSpecialTip ?>) {
    const re = /x/;
    console.log(re);
    re.toString = function () {
        showMessage('唔，讨厌～', 5000);
        return '';
    };

    jQuery(document).on('copy', function () {
        showMessage('你都复制了些什么呀？转载要记得加上出处哦！', 5000);
    });
}

function initTips() {
    jQuery.ajax({
        cache: true,
        url: `${message_Path}message.json.php`,
        dataType: "json",
        success: function (result) {
            jQuery.each(result.mouseover, function (index, tips) {
                jQuery(tips.selector).mouseover(function () {
                    let text = tips.text;
                    if (Array.isArray(tips.text)) text = tips.text[Math.floor(Math.random() * tips.text.length + 1) - 1];
                    text = text.renderTip({text: jQuery(this).text()});
                    showMessage(text, 3000);
                });
            });
            jQuery.each(result.click, function (index, tips) {
                jQuery(tips.selector).click(function () {
                    let text = tips.text;
                    if (Array.isArray(tips.text)) text = tips.text[Math.floor(Math.random() * tips.text.length + 1) - 1];
                    text = text.renderTip({text: jQuery(this).text()});
                    showMessage(text, 3000);
                });
            });
        }
    });
}

initTips();

(function () {
    let text;
    if (document.referrer !== '') {
        const referrer = document.createElement('a');
        referrer.href = document.referrer;
        if (`${home_Path}`.indexOf(referrer.hostname) > 0) {
            return;
        }
        text = '嗨！来自 <span style="color:#0099cc;">' + referrer.hostname + '</span> 的朋友！';
        const domain = referrer.hostname.split('.')[1];
        if (referrer.hostname === 'xn--p5q832b.xn--6qq986b3xl' || referrer.hostname === '戴兜.我爱你') {
            text = '<span style="color:#df4300;">❤ 我也爱你~Mua~</span>';
        } else if (domain === 'baidu') {
            text = '嗨！ 你居然通过 百度 找到了我！<br>欢迎访问<span style="color:#0099cc;">「 ' + document.title.split(' - ')[0] + ' 」</span>';
        } else if (domain === 'so') {
            text = '嗨！ 你居然通过 360搜索 找到了我！<br>欢迎访问<span style="color:#0099cc;">「 ' + document.title.split(' - ')[0] + ' 」</span>';
        } else if (domain === 'google') {
            text = '嗨！ 你居然通过 谷歌 找到了我！<br>你一定是一个技术宅吧！</span>';
        }
    } else {
        if (window.location.href === `${home_Path}`) { //主页URL判断，需要斜杠结尾
            const now = (new Date()).getHours();
            if (now > 23 || now <= 5) {
                text = '你是夜猫子呀？这么晚还不睡觉，明天起的来嘛？';
            } else if (now > 5 && now <= 7) {
                text = '早上好！一日之计在于晨，美好的一天就要开始了！';
            } else if (now > 7 && now <= 11) {
                text = '上午好！工作顺利嘛，不要久坐，多起来走动走动哦！';
            } else if (now > 11 && now <= 14) {
                text = '中午了，工作了一个上午，现在是午餐时间！';
            } else if (now > 14 && now <= 17) {
                text = '午后很容易犯困呢，今天的运动目标完成了吗？';
            } else if (now > 17 && now <= 19) {
                text = '傍晚了！窗外夕阳的景色很美丽呢，最美不过夕阳红~~';
            } else if (now > 19 && now <= 21) {
                text = '晚上好，今天过得怎么样？';
            } else if (now > 21 && now <= 23) {
                text = '已经这么晚了呀，早点休息吧，晚安~~';
            } else {
                text = '嗨~ 快来陪我van~吧！';
            }
        } else {
            text = '欢迎阅读<span style="color:#0099cc;">「 ' + document.title.split(' - ')[0] + ' 」</span>';
        }
    }
    showMessage(text, 12000);
    document.addEventListener('visibilitychange', function () {
        if (document.hidden) {
            showMessage("要出门了吗？<br> 我不觉得你能看到这句话（", 5000);
        } else {
            showMessage("欢迎回来，记得把门把手上的指纹擦干净哦。", 5000);
        }
    });
})();

if ('false' === <?php echo $noHitoKoto ?>) {
    let getActed = false;
    window.hitokotoTimer = 0;
    let hitokotoInterval = false;

    $(document).mousemove(function (e) {
        getActed = true;
    }).keydown(function () {
        getActed = true;
    });
    setInterval(function () {
        if (!getActed) ifActed(); else elseActed();
    }, 1000);

    function ifActed() {
        if (!hitokotoInterval) {
            hitokotoInterval = true;
            hitokotoTimer = window.setInterval(showHitokoto(<?php echo $localKoto; ?>), 20000);
        }
    }

    function elseActed() {
        getActed = hitokotoInterval = false;
        window.clearInterval(hitokotoTimer);
    }
}

function showHitokoto(lk) {
    if (lk) {
        $.getJSON(message_Path + 'localkoto.json.php', function (result) {
            showMessage(result.localkoto, 5000);
        });
    } else {
        $.getJSON('https://v1.hitokoto.cn/', function (result) {
            showMessage(result.hitokoto, 5000);
        });
    }
}

function showMessage(text, timeout) {
    if (Array.isArray(text)) text = text[Math.floor(Math.random() * text.length + 1) - 1];
    jQuery('.message').stop();
    jQuery('.message').html(text).fadeTo(200, 1);
    if (timeout === null) timeout = 5000;
    jQuery('.hide-button').css("top", jQuery("#landlord .message").height() - 30 + "px");
    jQuery('.switch-button').css("top", jQuery("#landlord .message").height() + "px");
    hideMessage(timeout);
}

function hideMessage(timeout) {
    jQuery('.message').stop().css('opacity', 1);
    if (timeout === null) timeout = 5000;
    jQuery('.message').delay(timeout).fadeTo(200, 0);
}

function positionWrap() {
    $('.h2wrap, .h3wrap .h4wrap').click(function () {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            let $target = $(this.hash);
            $target = $target.length && $target || $('[name=' + this.hash.slice(1) + ']');
            if ($target.length) {
                const targetOffset = $target.offset().top;
				<?php if ( current_user_can( 'level_10' ) ): ?>
				<?php if ( get_option( 'live2d_nav-offset' ) ) : ?>
                $('html,body').animate({
                    scrollTop: targetOffset - 32 - <?php echo get_option( 'live2d_nav-offset' ); ?>
                }, 800);
				<?php else: ?>
                $('html,body').animate({
                    scrollTop: targetOffset - 32 - $('nav').height() == undefined ? 0 : $('nav').height()
                }, 800);
				<?php endif; ?>
				<?php else:?>
				<?php if ( get_option( 'live2d_nav-offset' ) ) : ?>
                $('html,body').animate({
                    scrollTop: targetOffset - <?php echo get_option( 'live2d_nav-offset' ); ?>
                }, 800);
				<?php else: ?>
                $('html,body').animate({
                    scrollTop: targetOffset - $('nav').height() == undefined ? 0 : $('nav').height()
                }, 800);
				<?php endif; ?>
				<?php endif; ?>
            }
        }
    });
}

function initLive2d() {
    $('body').append("<div class=\"show-button\">显示</div>");
    if ($('.l2d-menu').fadeOut(0)) {
        $('#hide-button').on('click', function () {
            $('#landlord').css('display', 'none');
            $('.show-button').fadeIn(300);
        });
        $('#switch-button').on('click', function () {
            jQuery("#live2d").animate({opacity: '0'}, 100);
            setTimeout("ChangePoi()", 200);
        });
        $('#catalog-button').on('click', function () {
            let tits = 0;
            let catalog;
            if ($('article h2').length || $('article h3').length || $('article h4').length) {
                catalog = "<p class=\"l2d-cat\">这里有文章的目录哦~</p><br>";
                $('article h2, article h3, article h4').each(function () {
                    $(this).attr("id", "title-" + tits);
                    if (0 == $(this).filter('h2').val()) catalog += "<p class=\"l2d-h2cat\">&raquo;<a class=\"h2wrap\" href=\"#title-" + tits + "\">" + $(this).text() + "</a></p><br>";
                    if (0 == $(this).filter('h3').val()) catalog += "<p class=\"l2d-h3cat\">&raquo;<a class=\"h3wrap\" href=\"#title-" + tits + "\">" + $(this).text() + "</a></p><br>";
                    if (0 == $(this).filter('h4').val()) catalog += "<p class=\"l2d-h3cat\">&raquo;<a class=\"h4wrap\" href=\"#title-" + tits + "\">" + $(this).text() + "</a></p><br>";
                    tits++;
                });
                setTimeout("positionWrap()", 200);
            } else {
                catalog = "然而这里并没有目录。";
            }
            showMessage(catalog, 10000);
        });
    }
    $('#landlord').hover(function () {
        $('.l2d-menu').fadeIn(200)
    }, function () {
        $('.l2d-menu').fadeOut(200)
    });
    $('.show-button').on('click', function () {
        $('#landlord').css('display', 'block');
        $('.show-button').fadeOut(200);
    })
}
initLive2d();

