<?php
/*
Plugin Name: MWT-文章預載快取
Plugin URI: https://wp.mwt.tw/plugin/mwt-ga
Description: Add Google Analytics traffic in web page
Version: 1.1
Author: Minggo Zhou
Author URI: https://www.minwt.com/
*/

function mwt_admin_preload_actions() {
	if (current_user_can('manage_options'))  {
		add_theme_page("預載文章", "預載文章", 'manage_options', "preload-mode", "mwt_show_admin");
  }
}

function mwt_show_admin(){
	include('preload-mode.php');
}

add_action('admin_menu', 'mwt_admin_preload_actions');