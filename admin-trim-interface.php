<?php
/**
 * @package Admin_Trim_Interface
 * @author Scott Reilly
 * @version 2.0
 */
/*
Plugin Name: Admin Trim Interface
Version: 2.0
Plugin URI: http://coffee2code.com/wp-plugins/admin-trim-interface/
Author: Scott Reilly
Author URI: http://coffee2code.com
Text Domain: admin-trim-interface
Description: Customize the WordPress admin pages by selectively removing interface elements.

Compatible with WordPress 2.8+, 2.9+, 3.0+.

=>> Read the accompanying readme.txt file for instructions and documentation.
=>> Also, visit the plugin's homepage for additional information and updates.
=>> Or visit: http://wordpress.org/extend/plugins/admin-trim-interface/

*/

/*
Copyright (c) 2009-2010 by Scott Reilly (aka coffee2code)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy,
modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR
IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

if ( is_admin() && !class_exists( 'c2c_AdminTrimInterface' ) ) :

require_once( 'c2c-plugin.php' );

class c2c_AdminTrimInterface extends C2C_Plugin_014 {

	/**
	 * Constructor
	 */
	function c2c_AdminTrimInterface() {
		$this->C2C_Plugin_014( '2.0', 'admin-trim-interface', 'c2c', __FILE__, array( 'settings_page' => 'themes' ) );
	}

	/**
	 * Initializes the plugin's configuration and localizable text variables.
	 *
	 * @return void
	 */
	function load_config() {
		$this->name = __( 'Admin Trim Interface', $this->textdomain );
		$this->menu_name = __( 'Admin Trim Interface', $this->textdomain );

		$this->config = array(
			'hide_wp_logo' => array( 'input' => 'checkbox', 'default' => false,
					'label' => __( '1. Hide WordPress logo in header?', $this->textdomain ) ),
			'hide_visit_site_link' => array( 'input' => 'checkbox', 'default' => false, 'wplt' => '3.0',
					'label' => __( '2. Hide "Visit site" link?', $this->textdomain ) ),
			'hide_search_engines_blocked' => array( 'input' => 'checkbox', 'default' => false, 'wpgte' => '3.0',
					'label' => __( '2. Hide "Search Engines Blocked" link?', $this->textdomain ) ),
			'hide_favorite_actions' => array( 'input' => 'checkbox', 'default' => false,
					'label' => __( '3. Hide favorite actions shortcuts?', $this->textdomain ) ),
			'hide_howdy' => array( 'input' => 'checkbox', 'default' => false,
					'label' => __( '4. Hide "Howdy"?', $this->textdomain ) ),
			'hide_username' => array( 'input' => 'checkbox', 'default' => false,
					'label' => __( '5. Hide username profile link?', $this->textdomain ) ),
			'hide_turbo_link' => array( 'input' => 'checkbox', 'default' => false, 'wplt' => '3.0',
					'label' => __( '5b. Hide "Turbo" link?', $this->textdomain ) ),
			'hide_dashboard' => array( 'input' => 'checkbox', 'default' => false,
					'label' => __( '6. Hide Dashboard menu link?', $this->textdomain ) ),
			'hide_page_heading_icon' => array( 'input' => 'checkbox', 'default' => false,
					'label' => __( '7. Hide page heading icon?', $this->textdomain ) ),
			'hide_help' => array( 'input' => 'checkbox', 'default' => false,
					'label' => __( '8. Hide contextual "Help" link?', $this->textdomain ) ),
			'hide_footer_left' => array( 'input' => 'checkbox', 'default' => false,
					'label' => __( '9. Hide footer links?', $this->textdomain ) ),
			'hide_footer_version' => array( 'input' => 'checkbox', 'default' => false,
					'label' => __( '10. Hide WordPress version in footer?', $this->textdomain ) )
		);
	}

	/**
	 * Override the plugin framework's register_filters() to actually actions against filters.
	 *
	 * @return void
	 */
	function register_filters() {
		add_action( 'admin_head', array( &$this, 'add_admin_css' ) );
		add_action( 'admin_menu', array( &$this, 'admin_menu' ) );
		add_action( 'admin_print_footer_scripts', array( &$this, 'add_admin_js' ) );
		add_filter( 'explain_nonce_'.$this->nonce_field, array( &$this, 'explain_nonce' ) );
		add_action( $this->get_hook( 'before_settings_form' ), array( &$this, 'show_legend_image' ) );
	}

	/**
	 * Output message if nonce has expired.
	 *
	 * @param string $msg The message WordPress would have shown
	 * @return string The error message
	 */
	function explain_nonce( $msg ) {
		return __( 'Unable to perform action: Your WordPress session has expired.  Please login and try again.' );
	}

	/**
	 * Outputs admin CSS
	 *
	 * @return void (Text is echoed.)
	 */
	function add_admin_css() {
		$options = $this->get_options();

		$css = array();

		if ( $options['hide_wp_logo'] )
			$css[] = '#header-logo';
		if ( $options['hide_visit_site_link'] )
			$css[] = '#wphead h1 a span, #wphead #site-visit-button'; // In WP2.8+ this just needs to be: #wphead #site-visit-button
		if ( $options['hide_search_engines_blocked'] )
			$css[] = '#privacy-on-link'; // For WP3.0+ the site link was replaced by the search enginges blocked link
		if ( $options['hide_favorite_actions'] )
			$css[] = '#favorite-actions';
		if ( $options['hide_help'] )
			$css[] = '#contextual-help-link-wrap'; // This is just for < WP2.8, since 2.8 modifies this via JS
		if ( $options['hide_footer_left'] )
			$css[] = '#footer-left';
		if ( $options['hide_footer_version'] )
			$css[] = '#footer-upgrade';
		if ( $options['hide_dashboard'] )
			$css[] = '#menu-dashboard';
		if ( $options['hide_page_heading_icon'] )
			$css[] = '#icon-index, .icon32';
		if ( $options['hide_username'] )
			$css[] = '#user_info p > a[href=\'profile.php\']';

		// Hack
		$extra_css = '#wphead #site-title { display:inline; }';

		if ( !empty( $css ) ) {
			$css = implode( ', ', $css );
			echo <<<CSS
		<style type="text/css">
		{$css} { display:none; }
		{$extra_css}
		</style>

CSS;
		}
	}

	/**
	 * Outputs admin JavaScript
	 *
	 * @return void (Text is echoed.)
	 */
	function add_admin_js() {
		$options = $this->get_options();

		$do_turbo = $this->is_option_valid( 'hide_turbo_link' );  // pre WP 3.0

		$js = array();

		if ( $options['hide_dashboard'] )
			$js[] = "\$('.wp-menu-separator:first').remove();";

		if ( $do_turbo && $options['hide_turbo_link'] )
			$js[] = "\$('.turbo-nag').remove();";

		if ( $options['hide_howdy'] ) {
			$js[] = "\$('#user_info p').after('<p></p>');";
			$js[] = "\$('#user_info p > a, #user_info p > span').appendTo($('#user_info p:last'));";
			$js[] = "\$('#user_info p:first').remove();";
		}

		if ( $options['hide_help'] )
			$js[] = "\$('#contextual-help-link-wrap').remove();";

		if ( $do_turbo && $options['hide_howdy'] && $options['hide_username'] )
			$js[] = "\$('.turbo-nag').html(\$('.turbo-nag a'))";

		if ( $do_turbo ) { // Pre WP 3.0
			if ( ( !$options['hide_username'] && ( $options['hide_turbo_link'] && $options['hide_howdy'] ) ) ||
				 ( $options['hide_howdy'] && ( !$options['hide_turbo_link'] || !$options['hide_username'] ) ) )
				$js[] = "\$('#user_info p a:last').before(' | ');";
		} else {
			if ( !$options['hide_username'] && $options['hide_howdy'] )
				$js[] = "\$('#user_info p a:last').before(' | ');";
		}
		
		if ( !empty( $js ) ) {
			$js = implode( "\n", $js );
			echo <<<JS
		<script type="text/javascript">
		jQuery(document).ready(function($) {
			{$js}
		});
		</script>

JS;
		}
	}

	/**
	 * Outputs the text above the setting form
	 *
	 * @return void (Text will be echoed.)
	 */
	function options_page_description() {
		$options = $this->get_options();
		parent::options_page_description( __( 'Admin Trim Interface Settings', $this->textdomain ) );
		echo '<p>' . __( 'Use the image at the bottom to correlate the settings below with the admin interface element they hide.', $this->textdomain ) . '</p>';
		echo '<p>' . __( 'Note: These settings are global and will affect all users who are able to visit the admin pages.', $this->textdomain ) . '</p>';
	}

	/**
	 * Outputs the image that demonstrates the sections of the site that admin that correspond to the various settings.
	 */
	function show_legend_image() {
		echo "<img src='" . plugins_url( basename( $_GET['page'], '.php' ) . '/screenshot-1.png' ) . "' alt='settings to admin mapping' style='position:absolute;left:450px;' />";
	}
} // end c2c_AdminTrimInterface

$GLOBALS['c2c_admin_trim_interface'] = new c2c_AdminTrimInterface();

endif; // end if !class_exists()

?>