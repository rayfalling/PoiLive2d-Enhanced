<?php
defined( 'ABSPATH' ) or exit;
if ( $_POST['update_plugin_options'] == 'true' ) {
	live2d_options_update();
	echo '<div id="message" class="updated"><h4>设置已成功保存</a></h4></div>';
}
?>
    <style>
        input[type='color'] {
            width: 25px;
            height: 25px;
            padding: .1px 2px;
        }

        textarea {
            width: 60%;
            height: 230px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
    <div class="wrap">
    <h2>PoiLive2D魔改 插件控制面板</h2>
    <form method="POST" action="">
        <input type="hidden" name="update_plugin_options" value="true"/>
        <h3>基本设置</h3>
        <div style="margin-left: 50px">
            <input type="color" name="main-color" id="main-color"
                   value="<?php echo get_option( 'live2d_maincolor' ); ?>"/> 对话框主体颜色
            <p>
                <label class="switch">
                    <input type="checkbox" name="hitokoto"
                           id="hitokoto" <?php echo get_option( 'live2d_hitokoto' ); ?> >
                    <span class="slider round"></span>
                </label>
                <span style="margin-left: 16px">一言显示</span>
            </p>
            <p>
            <label class="switch">
                <input type="checkbox" name="localkoto"
                       id="localkoto" <?php echo get_option( 'live2d_localkoto' ); ?> >
                <span class="slider round"></span>
            </label>
            <span style="margin-left: 16px">本地一言</span>
            </p>
            <p>
                <label class="switch">
                    <input type="checkbox" name="special-tip"
                           id="special-tip" <?php echo get_option( 'live2d_special_tip' ); ?> >
                    <span class="slider round"></span>
                </label>
                <span style="margin-left: 16px">特殊显示</span>
            </p>
            <p>
                <label class="switch">
                    <input type="checkbox" name="catalog"
                           id="catalog" <?php echo get_option( 'live2d_catalog' ); ?> >
                    <span class="slider round"></span>
                </label>
                <span style="margin-left: 16px">文章目录</span>
            </p>
            <p>
                <label class="switch">
                    <input type="checkbox" name="position"
                           id="position" <?php echo get_option( 'live2d_position' ); ?> >
                    <span class="slider round"></span>
                </label>
                <span style="margin-left: 16px">Live2d位置(当前：
				<?php if ( get_option( 'live2d_position' ) == "checked" ) {
					echo "左下";
				} else {
					echo "右下";
				} ?>)</span>
            </p>
        </div>
        <h3>高级设置</h3>
        <div style="margin-left: 50px">
            <input type="checkbox" name="localkoto" id="localkoto" <?php echo get_option( 'live2d_localkoto' ); ?> />
            设置本地一言（需开启一言显示）<p>
            <p>自定义本地一言</p> <textarea name="custom-koto"
                                     id="custom-koto"><?php echo get_option( 'live2d_customkoto' ); ?></textarea>
            <p>自定义提示</p> <textarea name="custom-msg"
                                   id="custom-msg"><?php echo get_option( 'live2d_custommsg' ); ?></textarea>
            <p>请自行校验json有效性，不需要的话请填写{}</p>
        </div>
        <input type="submit" class="button-primary" value="保存设置" style="margin: 20px 0;"/>
        <br><br> PoiLive2D Enhanced 版本 <?php echo LIVE2D_VERSION; ?>
        <br><br>原版插件作者 <a href="https://daidr.me" target="_blank">戴兜</a> &nbsp; <a
                href="https://daidr.me/archives/code-176.html" target="_blank">点击获取最新版本 & 说明</a>
    </form>

<?php
function live2d_options_update() {
	update_option( 'live2d_maincolor', $_POST['main-color'] );

	if ( $_POST['hitokoto'] == 'on' ) {
		update_option( 'live2d_hitokoto', 'checked' );
	} else {
		update_option( 'live2d_hitokoto', '' );
	}

	if ( $_POST['special-tip'] == 'on' ) {
		update_option( 'live2d_special_tip', 'checked' );
	} else {
		update_option( 'live2d_special_tip', '' );
	}

	if ( $_POST['catalog'] == 'on' ) {
		update_option( 'live2d_catalog', 'checked' );
	} else {
		update_option( 'live2d_catalog', '' );
	}

	if ( $_POST['localkoto'] == 'on' ) {
		update_option( 'live2d_localkoto', 'checked' );
	} else {
		update_option( 'live2d_localkoto', '' );
	}

	if ( $_POST['position'] == 'on' ) {
		update_option( 'live2d_position', 'checked' );
	} else {
		update_option( 'live2d_position', '' );
	}

	update_option( 'live2d_customkoto', stripslashes( $_POST['custom-koto'] ) );
	update_option( 'live2d_custommsg', stripslashes( $_POST['custom-msg'] ) );
}

?>