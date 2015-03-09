<?php
/**
 * Plugin Name: Admin Trim Interface
 * Version:     3.0
 * Plugin URI:  http://coffee2code.com/wp-plugins/admin-trim-interface/
 * Author:      Scott Reilly
 * Author URI:  http://coffee2code.com/
 * Text Domain: admin-trim-interface
 * Domain Path: /lang/
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Description: Customize the WordPress admin pages by selectively removing interface elements.
 *
 * Compatible with WordPress 3.8 through 4.1+.
 *
 * =>> Read the accompanying readme.txt file for instructions and documentation.
 * =>> Also, visit the plugin's homepage for additional information and updates.
 * =>> Or visit: https://wordpress.org/plugins/admin-trim-interface/
 *
 * @package Admin_Trim_Interface
 * @author  Scott Reilly
 * @version 3.0
 */

/*
 * TODO:
 * - Options to remove other admin bar icons: my sites
 * - Options to remvoe other admin bar nodes: udpates, comments, new content, search (front-end)
 */

/*
	Copyright (c) 2009-2015 by Scott Reilly (aka coffee2code)

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

defined( 'ABSPATH' ) or die();

if ( ! class_exists( 'c2c_AdminTrimInterface' ) ) :

require_once( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'c2c-plugin.php' );

class c2c_AdminTrimInterface extends C2C_Plugin_039 {

	/**
	 * The one true instance.
	 *
	 * @var c2c_AdminTrimInterface
	 */
	private static $instance;

	/**
	 * Get singleton instance.
	 *
	 * @since 3.0
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor
	 */
	protected function __construct() {
		parent::__construct( '3.0', 'admin-trim-interface', 'c2c', __FILE__, array( 'settings_page' => 'themes' ) );
		register_activation_hook( __FILE__, array( __CLASS__, 'activation' ) );
		self::$instance = $this;
	}

	/**
	 * Handles activation tasks, such as registering the uninstall hook.
	 *
	 * @since 2.1
	 */
	public static function activation() {
		register_uninstall_hook( __FILE__, array( __CLASS__, 'uninstall' ) );
	}

	/**
	 * Handles uninstallation tasks, such as deleting plugin options.
	 *
	 * This can be overridden.
	 *
	 * @since 2.0
	 */
	public static function uninstall() {
		delete_option( 'c2c_admin_trim_interface' );
	}

	/**
	 * Initializes the plugin's configuration and localizable text variables.
	 */
	public function load_config() {
		$this->name      = __( 'Admin Trim Interface', $this->textdomain );
		$this->menu_name = __( 'Admin Trim Interface', $this->textdomain );

		$this->config = array(
			'hide_wp_logo' => array( 'input' => 'checkbox', 'default' => false, 'numbered' => true,
					'label' => __( 'Hide WordPress logo in admin bar?', $this->textdomain ) ),
			'hide_home_icon' => array( 'input' => 'checkbox', 'default' => false, 'numbered' => true,
					'label' => __( 'Hide home icon in admin bar?', $this->textdomain ) ),
			'hide_howdy' => array( 'input' => 'checkbox', 'default' => false, 'numbered' => true,
					'label' => __( 'Hide "Howdy"?', $this->textdomain ) ),
			'hide_username' => array( 'input' => 'checkbox', 'default' => false, 'numbered' => true,
					'label' => __( 'Hide username in admin bar?', $this->textdomain ) ),
			'hide_avatar' => array( 'input' => 'checkbox', 'default' => false, 'wpgte' => '3.2.99', 'numbered' => true,
					'label' => __( 'Hide user avatar in admin bar?', $this->textdomain ) ),
			'hide_dashboard' => array( 'input' => 'checkbox', 'default' => false, 'numbered' => true,
					'label' => __( 'Hide Dashboard menu link?', $this->textdomain ) ),
			'hide_help' => array( 'input' => 'checkbox', 'default' => false, 'numbered' => true,
					'label' => __( 'Hide contextual "Help" link?', $this->textdomain ) ),
			'hide_footer_left' => array( 'input' => 'checkbox', 'default' => false, 'numbered' => true,
					'label' => __( 'Hide footer links?', $this->textdomain ) ),
			'hide_footer_version' => array( 'input' => 'checkbox', 'default' => false, 'numbered' => true,
					'label' => __( 'Hide WordPress version in footer?', $this->textdomain ) )
		);
	}

	/**
	 * Override the plugin framework's register_filters() to actually actions against filters.
	 */
	public function register_filters() {
		add_action( '_network_admin_menu',                     array( $this, 'hide_dashboard' ) );
		add_action( '_user_admin_menu',                        array( $this, 'hide_dashboard' ) );
		add_action( '_admin_menu',                             array( $this, 'hide_dashboard' ) );
		add_action( 'admin_init',                              array( $this, 'admin_init' ) );
		add_action( 'admin_enqueue_scripts',                   array( $this, 'add_css' ) );
		add_action( 'wp_enqueue_scripts',                      array( $this, 'add_css' ) );
		add_filter( 'contextual_help',                         array( $this, 'clear_contextual_help' ), 1000 );
		add_filter( 'admin_bar_menu',                          array( $this, 'admin_bar_menu' ), 5 );
		add_action( 'admin_head',                              array( $this, 'hide_help_tabs' ) );
		add_filter( 'explain_nonce_'.$this->nonce_field,       array( $this, 'explain_nonce' ) );
		add_action( $this->get_hook( 'before_settings_form' ), array( $this, 'show_legend_image' ) );
	}

	/**
	 * Remove call to core_update_footer filter.
	 *
	 * @since 2.1
	 */
	public function admin_init() {
		$options = $this->get_options();

		if ( $options['hide_footer_left'] ) {
			add_filter( 'admin_footer_text', '__return_false' );
		}

		if ( $options['hide_footer_version'] ) {
			remove_filter( 'update_footer', 'core_update_footer' );
		}
	}

	/**
	 * Hides help tabs.
	 *
	 * @since 2.2
	 */
	public function hide_help_tabs() {
		$options = $this->get_options();

		if ( $options['hide_help'] ) {
			$screen = get_current_screen();
			$screen->remove_help_tabs();
		}
	}

	/**
	 * Clears old-style contextual help defined via filter.
	 *
	 * @since 2.2
	 *
	 * @param string  $text The contextual help text.
	 * @return string Empty string if help tab is being hidden.
	 */
	public function clear_contextual_help( $text ) {
		$options = $this->get_options();

		if ( $options['hide_help'] ) {
			$text = '';
		}

		return $text;
	}

	/**
	 * Hides the dashboard menu link.
	 *
	 * @since 2.1
	 */
	public function hide_dashboard() {
		global $menu, $submenu;
		$options = $this->get_options();

		if ( $options['hide_dashboard'] ) {
			remove_menu_page( 'index.php' );
			remove_menu_page( 'separator1' );
		}
	}

	/**
	 * Modify admin bar according to settings.
	 *
	 * Much of the node building is based on wp_admin_bar_my_account_item().
	 *
	 * @since 2.2
	 *
	 * @param obj $wp_admin_bar The admin bar.
	 */
	public function admin_bar_menu( $wp_admin_bar ) {
		$options = $this->get_options();

		// Possibly hide the WP logo.
		if ( $options['hide_wp_logo'] ) {
			remove_action( 'admin_bar_menu', 'wp_admin_bar_wp_menu', 10 );
		}

		// Now determine if the user node needs removal/paring.

		$user_id = get_current_user_id();

		if ( ! $user_id ) {
			return;
		}

		$current_user = wp_get_current_user();
		$profile_url  = get_edit_profile_url( $user_id );

		// If any element in the my-account admin bar node is being hidden,
		// remove the whole thing and rebuild it
		if ( $options['hide_username'] || $options['hide_howdy'] || $options['hide_avatar'] ) {
			remove_action( 'admin_bar_menu', 'wp_admin_bar_my_account_item', 7 );
		}

		// All done if everything in the my-account node is being hidden.
		if ( $options['hide_username'] && $options['hide_howdy'] && $options['hide_avatar'] ) {
			return;
		}

		/*
		 * The rest of this function is adapted from wp_admin_bar_my_account_item().
		 */

		$avatar = $options['hide_avatar'] ? '' : get_avatar( $user_id, 26 );
		if ( $options['hide_howdy'] ) {
			$howdy = $options['hide_username'] ? '' : $current_user->display_name;
		} else {
			$howdy = $options['hide_username'] ? __( 'Howdy' ) : sprintf( __( 'Howdy, %1$s' ), $current_user->display_name );
		}

		$class = empty( $avatar ) ? '' : 'with-avatar';

		$wp_admin_bar->add_menu( array(
			'id'        => 'my-account',
			'parent'    => 'top-secondary',
			'title'     => $howdy . $avatar,
			'href'      => $profile_url,
			'meta'      => array(
				'class'     => $class,
			),
		) );
	}

	/**
	 * Output message if nonce has expired.
	 *
	 * @param string  $msg The message WordPress would have shown.
	 * @return string The error message.
	 */
	public function explain_nonce( $msg ) {
		return __( 'Unable to perform action: Your WordPress session has expired.  Please login and try again.' );
	}

	/**
	 * Outputs CSS.
	 *
	 * Runs for both front-end and admin areas of the site.
	 */
	public function add_css() {
		$options   = $this->get_options();
		$css       = array();
		$extra_css = '';

		// Don't bother outputting CSS related to admin bar if it isn't showing.
		if ( is_admin_bar_showing() ) {

			// Remove the home icon from admin bar.
			if ( $options['hide_home_icon'] ) {
				if ( is_admin() ){
					$extra_css .= '.wp-admin #wpwrap #wpadminbar #wp-admin-bar-site-name>.ab-item:before { content: ""; }' . "\n";
				} else {
					$extra_css .= 'body #wpadminbar #wp-admin-bar-site-name>.ab-item:before { content: ""; }' . "\n";
				}
			}

			// Remove the user icon from admin bar.
			if ( $options['hide_avatar'] ) {
				$css[] = 'body #wp-admin-bar-user-info .avatar';
				$extra_css .= 'body #wp-admin-bar-my-account>.ab-item:before { content: ""; }' . "\n";
			}

		}

		// Style the legend image on the plugin's setting page.
		if ( is_admin() ) {
			$extra_css .= ".c2c-ati-image { position:absolute;left:300px;top:170px; }\n";
		}

		if ( ! empty( $css ) || ! empty( $extra_css ) ) {
			$css = implode( ', ', $css );
			if ( ! empty( $css ) ) {
				$css = "$css { display:none; }\n";
			}
			echo <<<HTML
		<style type="text/css">
		{$css}
		{$extra_css}
		</style>

HTML;
		}
	}

	/**
	 * Outputs the text above the setting form.
	 *
	 * @param string $localized_heading_text Optional. Localized page heading text.
	 */
	public function options_page_description( $localized_heading_text = '' ) {
		$options = $this->get_options();
		parent::options_page_description( __( 'Admin Trim Interface Settings', $this->textdomain ) );
		echo '<p>' . __( 'Use the image at the right to correlate the settings below with the admin interface element they hide.', $this->textdomain ) . '</p>';
		echo '<p>' . __( 'Note: These settings are global and will affect all users who are able to visit the admin pages.', $this->textdomain ) . '</p>';
	}

	/**
	 * Outputs the image that demonstrates the sections of the site that admin that correspond to the various settings.
	 */
	public function show_legend_image() {
		$link = plugins_url( 'screenshot-1.png', __FILE__ );
		echo "<a href='$link' title='settings to admin interface mapping; click to view full size' class='c2c-ati-image'>";
		echo "<img src='$link' width='425' alt='settings to admin interface mapping' />";
		echo '<br /><center><em>' . __( 'Click to view full size.', $this->textdomain ) . '</em></center></a>';
	}
} // end c2c_AdminTrimInterface

c2c_AdminTrimInterface::get_instance();

endif; // end if !class_exists()
