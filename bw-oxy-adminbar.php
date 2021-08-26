<?php
/*
Plugin Name: Admin bar Oxy Template-Items
Plugin URI: https://blickwert.at
Description: Adds Oxygen Template-Items to Adminbar
Author: David W&ouml;gerer
Version: 0.1
Author URI: https://blickwert.at
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}






 /*******
 * OXY Adminbar entry 
 */

function bw_create_oxy_menu() {
	global $wp_admin_bar;
	$admin_url = admin_url();
	$bloginfo_url = get_bloginfo( 'url' );
	$args = array(
        'orderby' => 'id',
        'order' => 'ASC',
        'post_type'   => 'ct_template'
    );
	$templates = get_posts( $args );
	$args = array(
        'orderby' => 'id',
        'order' => 'ASC',
        'post_type'   => 'page'
    );
	$pages = get_posts( $args );

	$menu_id = 'oxy';
	$wp_admin_bar->add_menu(array('id' => $menu_id, 'title' => __('OXY')));
	$wp_admin_bar->add_menu(array('parent' => $menu_id, 'title' => __('Templates'), 'id' => 'oxy-templates', 'href' => $admin_url.'edit.php?post_type=ct_template', 'meta' => array('target' => '_blank')));
	foreach ($templates as $item) {
        $innerpost = (get_post_meta($item->ID, 'ct_parent_template') ? '&ct_inner=true' : '');
    	$wp_admin_bar->add_menu(array('parent' => $menu_id, 'title' => __('- '.$item->post_title), 'id' => 'oxy-'.$item->post_name , 'href' => $bloginfo_url.'?ct_template='.$item->post_name.'&ct_builder=true'.$innerpost, 'meta' => array('target' => '_blank')));
	}

	$wp_admin_bar->add_menu(array('parent' => $menu_id, 'title' => __('Pages'), 'id' => 'oxy-pages', 'href' => $admin_url.'edit.php?post_type=page', 'meta' => array('target' => '_blank')));
	foreach ($pages as $item) {
        $innerpost = (get_post_meta($item->ID, 'ct_parent_template') ? '&ct_inner=true' : '');
    	$wp_admin_bar->add_menu(array('parent' => $menu_id, 'title' => __('- '.$item->post_title), 'id' => 'oxy-'.$item->post_name , 'href' => $bloginfo_url.'?ct_template='.$item->post_name.'&ct_builder=true'.$innerpost, 'meta' => array('target' => '_blank')));
	}

	$wp_admin_bar->add_menu(array('parent' => $menu_id, 'title' => __('Settings'), 'id' => 'oxy-settings', 'href' => $admin_url.'admin.php?page=oxygen_vsb_settings', 'meta' => array('target' => '_blank')));
}
add_action('admin_bar_menu', 'bw_create_oxy_menu', 40);
