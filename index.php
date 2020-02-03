<?php
/*
Plugin Name: PoiLive2D Enhanced
Plugin URI: https://github.com/wanghaiwei/PoiLive2d-Enhanced
Description: 萌萌哒WordPress看板娘耶！
Version: 2.0.2
Author: 墨笙
Author URI: https://rayfalling.com
License: GPL2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

defined( 'ABSPATH' ) or exit;
define( 'LIVE2D_VERSION', '2.0.0' );
define( 'LIVE2D_URL', plugins_url( '', __FILE__ ) );
define( 'LIVE2D_PATH', dirname( __FILE__ ) );

add_action( 'admin_init', 'poilive2d_plugin_redirect' );

function poilive2d_plugin_redirect() {
	if ( get_option( 'do_activation_redirect', false ) ) {
		delete_option( 'do_activation_redirect' );
		wp_redirect( admin_url( 'options-general.php?page=poilive2d' ) );
	}
}

function poilive2d_register_plugin_settings_link( $links ) {
	$settings_link = '<a href="options-general.php?page=poilive2d">设置</a>';
	array_unshift( $links, $settings_link );

	return $links;
}

$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_{$plugin}", 'poilive2d_register_plugin_settings_link' );

if ( is_admin() ) {
	add_action( 'admin_menu', 'poilive2d_menu' );
}

function poilive2d_menu() {
	add_options_page( 'PoiLive2D 控制面板', 'PoiLive2D 设置', 'administrator', 'poilive2d', 'poilive2d_pluginoptions_page' );
}

function poilive2d_pluginoptions_page() {
	require "option.php";
}

//设定默认值
$live2d_setting_default = array(
	'maincolor'          => '#ce00ff',
	'live2d_hitokoto'    => 'checked',
	'live2d_special_tip' => 'checked',
	'live2d_localkoto'   => '',
	'live2d_catalog'     => 'checked',
	'live2d_position'    => 'checked',
	'live2d_nav-offset'  => 0
);

//写入默认设置
if ( ! get_option( 'live2d_maincolor' ) ) {
	update_option( 'live2d_maincolor', $live2d_setting_default['maincolor'] );
}
if ( ! get_option( 'live2d_hitokoto' ) ) {
	update_option( 'live2d_hitokoto', $live2d_setting_default['live2d_hitokoto'] );
}
if ( ! get_option( 'live2d_special_tip' ) ) {
	update_option( 'live2d_special_tip', $live2d_setting_default['live2d_special_tip'] );
}
if ( ! get_option( 'live2d_localkoto' ) ) {
	update_option( 'live2d_localkoto', $live2d_setting_default['live2d_localkoto'] );
}
if ( ! get_option( 'live2d_catalog' ) ) {
	update_option( 'live2d_catalog', $live2d_setting_default['live2d_catalog'] );
}
if ( ! get_option( 'live2d_position' ) ) {
	update_option( 'live2d_position', $live2d_setting_default['live2d_position'] );
}
if ( ! get_option( 'live2d_nav-offset' ) ) {
	update_option( 'live2d_nav-offset', $live2d_setting_default['live2d_nav-offset'] );
}
if ( ! get_option( 'live2d_custommsg' ) ) {
	$json = "{\"mouseover\":[{\"selector\":\".entry-content a\",\"text\":[\"要看看 <span style='color:#0099cc;'>「{text}」</span> 么？\"]},{\"selector\":\".post .post-title\",\"text\":[\"主人写的<s>爽文</s> <span style='color:#0099cc;'>「{text}」</span> ，要看看嘛？\"]},{\"selector\":\".feature-content a\",\"text\":[\"超级热门的 <span style='color:#0099cc;'>「{text}」</span> ，要看看么？\"]},{\"selector\":\".searchbox\",\"text\":[\"在找什么东西呢，需要帮忙吗？\"]},{\"selector\":\".top-social\",\"text\":[\"这里是主人的社交账号啦！不关注一波嘛？\"]},{\"selector\":\".zilla-likes\",\"text\":[\"听说点这个主人会很开心哦~\"]},{\"selector\":\".cd-top\",\"text\":[\"你想要返回顶部嘛？\"]},{\"selector\":\".site-title\",\"text\":[\"你要返回首页是吗？\"]},{\"selector\":\".comments\",\"text\":[\"看了这么久，是时候评论一下啦！\"]},{\"selector\":\".post-nepre.previous\",\"text\":[\"看看主人的上一篇文章怎么样？\"]},{\"selector\":\".post-nepre.next\",\"text\":[\"看看主人的下一篇文章怎么样？\"]},{\"selector\":\".reward-open\",\"text\":[\"你看主人把我扔在这么慢的服务器上，打赏了解一下？\"]},{\"selector\":\".poiplay.playing\",\"text\":[\"这是播放按钮啦~\"]},{\"selector\":\".poi-open-list\",\"text\":[\"戳一下就可以看到歌词哦！\"]},{\"selector\":\"#open-poi-player\",\"text\":[\"听说点这个按钮可以显示/隐藏播放器？\"]},{\"selector\":\".hide-button\",\"text\":[\"我有话唠属性，觉得我烦可以关掉我哦~\"]},{\"selector\":\"#pagination\",\"text\":[\"想看看更久远的内容？\"]}],\"click\":[{\"selector\":\"#landlord #live2d\",\"text\":[\"不要动手动脚的！快把手拿开~~\",\"真…真的是不知羞耻！\",\"Hentai！\",\"再摸的话我可要报警了！⌇●﹏●⌇\",\"110吗，这里有个变态一直在摸我(ó﹏ò｡)\"]}]}";
	update_option( 'live2d_custommsg', $json );
}

require LIVE2D_PATH . '/main.php';
