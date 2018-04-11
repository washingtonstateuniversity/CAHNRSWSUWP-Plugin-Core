<?php namespace WSUWP\CAHNRSWSUWP_Plugin_Core;

/*
* @desc Get plugin base path
* @since 0.0.1
*
* @param string $path Optional path to append
*
* @return string full path
*/
function core_get_plugin_path( $path = '' ) {

	$path = CAHNRSWSUWPCOREPATH . $path;

	return $path;

} // End core_get_plugin_path


/*
* @desc Get plugin base URL
* @since 0.0.1
*
* @param string $path Optional path to append
*
* @return string full path
*/
function core_get_plugin_url( $path = '' ) {

	$path = CAHNRSWSUWPCOREURL . $path;

	return $path;

} // End core_get_plugin_path


/*
* @desc Get plugin version
* @since 0.0.1
*
* @return string Plugin version
*/
function core_get_plugin_version( $path = '' ) {

	return CAHNRSWSUWPCOREVERSION;

} // End core_get_plugin_path


/*
* @desc Get registered post types
* @since 0.0.1
*
* @return array Post types slug => label
*/
function core_get_registered_post_types() {

	global $core_registered_post_types;

	return $core_registered_post_types;

} // End core_get_registered_post_types


/*
* @desc Register post types
* @since 0.0.1
*
* @return array Post types slug => label
*/
function core_register_post_types( $slug, $label ) {

	global $core_registered_post_types;

	$core_registered_post_types[ $slug ] = $label;

} // End core_get_registered_post_types
