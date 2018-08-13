<?php namespace WSUWP\CAHNRSWSUWP_Plugin_Core;

if ( ! defined( 'ABSPATH' ) ) {

	exit; // Exit if accessed directly

} // End if


/**
 * Uses theme filters to add sub layouts to the page with sidebars.
 * 
 * @version 0.0.1
 * @author CAHNRS Communications, Danial Bleile
 */
class Expire_Content_Module extends Core_Module {

	public $slug = 'expire_content';

	public $register_args = array(
		'label'          => 'Expire Content',
		'helper_text'    => 'Auto remove old content',
	);


	/**
	 * Init the module here
	 */
	public function init() {

	} // End init


} // End Sub_Layouts

$ccore_expire_content_module = new Expire_Content_Module();
