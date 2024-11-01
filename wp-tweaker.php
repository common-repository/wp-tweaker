<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/*

Plugin Name: WP-Tweaker

Description: This slim plugin removes many (unneeded) standard features from WordPress to give your blog the ultimate performance boost! Currently you can disable 20 WordPress functions each with one mouse click.
Version: 1.3.2
Author: digitalarbyter
Author URI:  https://digitalarbyter.de
Plugin URI:  https://wordpress.org/plugins/wp-tweaker/

*/

/*
1: Remove WP-Version im Header
2: WP-Emojis deaktivieren
3: Remove Windows Live Writer
4: Remove RSD-Link
5: RSS-Links entfernen
6: Shortlink im Header entfernen
7: Angrenzende Links zu Posts im Header entfernen
8: Post-Revisionen auf 5 begrenzen
9: Block http-requests by plugins/themes
10: Disable heartbeat
11: Disable Login-Error
12: Disable new themes on major WP updates
13: Disable the XML-RPC
14: Remove post by email function
15: Disable URL-fields on comments
16: Disable URL auto-linking in comments
17: Remove login-shake on errors
18: Empty WP-Trash every 7 days
19: Remove query strings
20: Disable auto-saving posts

*/

define('wp-tweaker-admin', 1);

if(is_admin())
{
    require plugin_dir_path(__FILE__).'inc/wp-tweaker-admin.php';
}

//Tweaks der eigentlichen Anpassungen
function wptweaker_setting_1()
{
	remove_action('wp_head', 'wp_generator');
}

function wptweaker_setting_2()
{
  remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}

function wptweaker_setting_3()
{
  remove_action('wp_head', 'wlwmanifest_link');
}

function wptweaker_setting_4()
{
  remove_action('wp_head', 'rsd_link');
}

function wptweaker_setting_5()
{
  remove_action('wp_head', 'feed_links', 2);
  remove_action('wp_head', 'feed_links_extra', 3);
}

function wptweaker_setting_6()
{
  remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
  remove_action('wp_head', 'wp_shortlink_header', 10, 0);
}

function wptweaker_setting_7()
{
  remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
}

function wptweaker_setting_8()
{
  define('WP_POST_REVISIONS', 5);
}

function wptweaker_setting_9()
{
  add_filter( 'pre_http_request', '__return_true', 100 );
}

function wptweaker_setting_10()
{
  add_action('init', 'stop_heartbeat', 1);
  function stop_heartbeat()
  	{
  	wp_deregister_script('heartbeat');
  	}
}

function wptweaker_setting_11()
{
  add_filter('login_errors',create_function('$a', "return null;"));
}

function wptweaker_setting_12()
{
  define( 'CORE_UPGRADE_SKIP_NEW_BUNDLED', true );
}

function wptweaker_setting_13()
{
  add_filter('xmlrpc_enabled', '__return_false');
}

function wptweaker_setting_14()
{
  add_filter( 'enable_post_by_email_configuration', '__return_false' );
}

function wptweaker_setting_15()
{
  add_filter('comment_form_default_fields', 'remove_url_field');
  function remove_url_field($fields)
  {
    if(isset($fields['url']))
       unset($fields['url']);
    return $fields;
  }
}

function wptweaker_setting_16()
{
  remove_filter('comment_text', 'make_clickable', 9);
}

function wptweaker_setting_17()
{
  function wpt_login_shake()
  {
	   remove_action('login_head', 'wp_shake_js', 12);
  }
  add_action('login_head', 'wpt_login_shake');
}

function wptweaker_setting_18()
{
  define('EMPTY_TRASH_DAYS', 7 );
}

function wptweaker_setting_19()
{
  function wpt_remove_query_strings ( $some_src ){
    $explode = explode( '?', $some_src );
    return $explode[0];
  }
  add_filter( 'script_loader_src', 'wpt_remove_query_strings', 15, 1 );
  add_filter( 'style_loader_src', 'wpt_remove_query_strings', 15, 1 );
}

function wptweaker_setting_20()
{
  function wpt_disableAutoSave()
  {
    wp_deregister_script('autosave');
  }
  add_action( 'wp_print_scripts', 'wpt_disableAutoSave' );
}



//Fire!
$wptweaker_options=get_option('wptweaker_settings');
if(!empty($wptweaker_options))
{
foreach ($wptweaker_options as $key => $value) {
  if($value == 1)
  {
    add_action('plugins_loaded', $key, 99);
  }
}
}

if( is_admin() )
    $my_settings_page = new WPTweaker_SettingsPage();
?>
