<?php
/*
Plugin Name: Sort Admin Menus
Plugin URI: http://w-shadow.com/blog/2008/07/09/wp-plugin-sort-admin-menus/
Description: Sorts the items in 'Manage', 'Settings' and 'Plugins' menus in alphabetic order.
Version: 1.2
Author: Janis Elsts
Author URI: http://w-shadow.com/blog/
*/

/*
Created by Janis Elsts (email : whiteshadow@w-shadow.com) 
It's GPL.
*/

//The hook function that does the sorting
function sort_dashboard_menu(){
	global $menu, $submenu, $wp_version;
	
	function comparator($a, $b){
		return strcasecmp($a[0], $b[0]);
	}
	
	//List any menus you want sorted. Each filename corresponds to what you'd
	//see in the address bar after clicking a top-level menu item.
	if ( function_exists('register_uninstall_hook') ) {
		$menus_to_sort = array('tools.php', 'options-general.php');
	} else {
		$menus_to_sort = array('edit.php', 'options-general.php');
	}
	
	//This loop is PHP4-compatible. Yay!
	foreach ($submenu as $key => $items){
		if (!in_array($key, $menus_to_sort)) continue;
		usort($items, "comparator");
		$submenu[$key] = $items;
	}
}

//Set up the hook.  
if ( function_exists('register_uninstall_hook') ){
	//It should run after all the other hooks, so it gets a late priority.
	add_action('admin_menu', 'sort_dashboard_menu', 99990);
} else {
	//It should run before any CSS menu plugins, so it gets the unusual "-1" priority.
	add_action('dashmenu', 'sort_dashboard_menu', -1);
}