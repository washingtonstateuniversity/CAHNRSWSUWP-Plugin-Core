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
class Publications_Module extends Core_Module {

	public $slug = 'publications';

	public $register_args = array(
		'label'          => 'Publications',
		'helper_text'    => 'Where supported by Theme',
	);


	/**
	 * Init the module here
	 */
	public function init() {

	} // End init


} // End Sub_Layouts

$ccore_publications_module = new Publications_Module();
