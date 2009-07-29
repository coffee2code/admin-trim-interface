<?php
/*
Plugin Name: Admin Trim Interface
Version: 1.0
Plugin URI: http://coffee2code.com/wp-plugins/admin-trim-interface
Author: Scott Reilly
Author URI: http://coffee2code.com
Description: Customize the WordPress admin pages by selectively removing interface elements.

This plugin uses a combination of CSS (when possible) and Javascript to removed specified admin interface elements.  These
elements may be considered by some to be superfluous interface elements that are undesired for one reason or another, so this
plugin aids in their visual removal.

Each admin interface element is individually selected for removal.  The elements that can be removed are:

* WordPress logo
* The "Visit site"
* The favorites shortcut dropdown
* The "Howdy," greeting before your username
* Your username link to your profile
* The "Turbo" link
* The Dashboard link
* The page header icon
* The contextual "Help" link
* The footer links
* The WordPress version in the footer

(There is an associated screenshot which points out these different sections.)

Note: These settings are global and will affect all users who are able to visit the admin pages.

Compatible with WordPress 2.7+, 2.8+.

=>> Read the accompanying readme.txt file for more information.  Also, visit the plugin's homepage
=>> for more information and the latest updates

Installation:

1. Download the file http://coffee2code.com/wp-plugins/admin-trim-interface.zip and unzip it into your 
/wp-content/plugins/ directory.
2. Activate the plugin through the 'Plugins' admin menu in WordPress

*/

/*
Copyright (c) 2009 by Scott Reilly (aka coffee2code)

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

if ( !class_exists('AdminTrimInterface') ) :

class AdminTrimInterface {
	var $plugin_name = 'Admin Trim Interface';
	var $admin_options_name = 'c2c_admin_trim_interface';
	var $nonce_field = 'admin_trim_interface';
	var $show_admin = true;	// Change this to false if you don't want the plugin's admin page shown.
	var $config = array(
		// input can be 'checkbox', 'short_text', 'text', 'textarea', 'inline_textarea', 'select', 'hidden', 'password', or 'none'
		//	an input type of 'select' must then have an 'options' value (an array) specified
		// datatype can be 'array' or 'hash'
		// can also specify input_attributes
		'hide_wp_logo' => array('input' => 'checkbox', 'default' => false,
				'label' => '1. Hide WordPress logo in header?'),
		'hide_visit_site_link' => array('input' => 'checkbox', 'default' => false,
				'label' => '2. Hide "Visit site" link?'),
		'hide_favorite_actions' => array('input' => 'checkbox', 'default' => false,
				'label' => '3. Hide favorite actions shortcuts?'),
		'hide_howdy' => array('input' => 'checkbox', 'default' => false,
				'label' => '4. Hide "Howdy"?'),
		'hide_username' => array('input' => 'checkbox', 'default' => false,
				'label' => '5. Hide username profile link?'),
		'hide_turbo_link' => array('input' => 'checkbox', 'default' => false,
				'label' => '6. Hide "Turbo" link?'),
		'hide_dashboard' => array('input' => 'checkbox', 'default' => false,
				'label' => '7. Hide Dashboard menu link?'),
		'hide_page_heading_icon' => array('input' => 'checkbox', 'default' => false,
				'label' => '8. Hide page heading icon?'),
		'hide_help' => array('input' => 'checkbox', 'default' => false,
				'label' => '9. Hide contextual "Help" link?'),
		'hide_footer_left' => array('input' => 'checkbox', 'default' => false,
				'label' => '10. Hide footer links?'),
		'hide_footer_version' => array('input' => 'checkbox', 'default' => false,
				'label' => '11. Hide WordPress version in footer?')
	);
	var $options = array(); // Don't use this directly
	var $plugin_basename;
	var $saved_settiongs = false;

	function AdminTrimInterface() {
		if ( !is_admin() ) return;

		$this->plugin_name = __($this->plugin_name);
		$this->plugin_basename = plugin_basename(__FILE__);

		add_action('load-appearance_page_admin-trim-interface/admin-trim-interface', array(&$this, 'maybe_save_options'));
		add_action('admin_head', array(&$this, 'add_css'));
		add_action('admin_menu', array(&$this, 'admin_menu'));
		add_action('admin_footer', array(&$this, 'add_js'));
		add_filter('explain_nonce_'.$this->nonce_field, array(&$this, 'explain_nonce'));
	}

	function explain_nonce( $msg ) {
		return __('Unable to perform action: Your WordPress session has expired.  Please login and try again.');
	}

	function install() {
		$this->options = $this->get_options();
		update_option($this->admin_options_name, $this->options);
	}

	function add_css() {
		$options = $this->get_options();

		$css = array();

		if ( $options['hide_wp_logo'] )
			$css[] = '#header-logo';
		if ( $options['hide_visit_site_link'] )
			$css[] = '#wphead h1 a span, #wphead #site-visit-button'; // In 2.8+ this just needs to be: #wphead #site-visit-button
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
			$css[] = '#user_info p > a[title=\'Edit your profile\']';

		// Hack to make 
		$extra_css = '#wphead #site-title { display:inline; }';

		if ( !empty($css) ) {
			$css = implode(', ', $css);
			echo <<<CSS
		<style type="text/css">
		{$css} { display:none; }
		{$extra_css}
		</style>
CSS;
		}
	}

	function add_js() {
		$options = $this->get_options();

		$js = array();

		if ( $options['hide_turbo_link'] )
			$js[] = "\$('.turbo-nag').remove();";

		if ( $options['hide_howdy'] ) {
			$js[] = "\$('#user_info p').after('<p></p>');";
			$js[] = "\$('#user_info p > a, #user_info p > span').appendTo($('#user_info p:last'));";
			$js[] = "\$('#user_info p:first').remove();";
		}

		if ( $options['hide_visit_site_link'] )
			$js[] = "\$('#contextual-help-link-wrap').remove();";

		if ( $options['hide_howdy'] && $options['hide_username'] )
			$js[] = "\$('.turbo-nag').html(\$('.turbo-nag a'))";

//		if ( $options['hide_username'] )
//			$js[] = "\$('#user_info p > a:first').hide();";

		if ( !$options['hide_turbo_link'] || !$options['hide_username'] )
			$js[] = "\$('#user_info a[title=\'Log Out\']').before(' | ');";
		
		if ( !empty($js) ) {
			$js = implode("\n", $js);
			echo <<<JS
		<script type="text/javascript">
		jQuery(document).ready(function($) {
			{$js}
		});
		</script>
JS;
		}
	}

	function admin_menu() {
		if ( $this->show_admin ) {
			global $wp_version;
			if ( current_user_can('manage_options') ) {
				if ( version_compare( $wp_version, '2.6.999', '>' ) )
					add_filter( 'plugin_action_links_' . $this->plugin_basename, array(&$this, 'plugin_action_links') );
				add_theme_page($this->plugin_name, $this->plugin_name, 9, $this->plugin_basename, array(&$this, 'options_page'));
			}
		}
	}

	function plugin_action_links($action_links) {
		$settings_link = '<a href="themes.php?page='.$this->plugin_basename.'">' . __('Settings') . '</a>';
		array_unshift( $action_links, $settings_link );

		return $action_links;
	}

	function get_options() {
		if ( !empty($this->options) ) return $this->options;
		// Derive options from the config
		$options = array();
		foreach ( array_keys($this->config) as $opt ) {
			$options[$opt] = $this->config[$opt]['default'];
		}
        $existing_options = get_option($this->admin_options_name);
        if ( !empty($existing_options) ) {
            foreach ($existing_options as $key => $value)
                $options[$key] = $value;
        }            
		$this->options = $options;
        return $options;
	}

	function maybe_save_options() {
		$options = $this->get_options();
		// See if user has submitted form
		if ( isset($_POST['submitted']) ) {
			check_admin_referer($this->nonce_field);

			foreach ( array_keys($options) AS $opt ) {
				$options[$opt] = htmlspecialchars(stripslashes($_POST[$opt]));
				$input = $this->config[$opt]['input'];
				if ( ($input == 'checkbox') && !$options[$opt] )
					$options[$opt] = 0;
				if ( $this->config[$opt]['datatype'] == 'array' ) {
					if ( $input == 'text' )
						$options[$opt] = explode(',', str_replace(array(', ', ' ', ','), ',', $options[$opt]));
					else
						$options[$opt] = array_map('trim', explode("\n", trim($options[$opt])));
				}
				elseif ( $this->config[$opt]['datatype'] == 'hash' ) {
					if ( !empty($options[$opt]) ) {
						$new_values = array();
						foreach ( explode("\n", $options[$opt]) AS $line ) {
							list($shortcut, $text) = array_map('trim', explode("=>", $line, 2));
							if ( !empty($shortcut) ) $new_values[str_replace('\\', '', $shortcut)] = str_replace('\\', '', $text);
						}
						$options[$opt] = $new_values;
					}
				}
			}
			// Remember to put all the other options into the array or they'll get lost!
			update_option($this->admin_options_name, $options);
			$this->options = $options;
			$this->saved_settings = true;
		}
	}

	function options_page() {
		$options = $this->get_options();
		if ( $this->saved_settings )
			echo "<div id='message' class='updated fade'><p><strong>" . __('Settings saved.') . '</strong></p></div>';

		$action_url = $_SERVER[PHP_SELF] . '?page=' . $this->plugin_basename;
		$img_dir = get_option('siteurl') . '/wp-content/plugins/' . basename($_GET['page'], '.php');
		$logo = $img_dir . '/c2c_minilogo.png';

		echo <<<END
		<div class='wrap'>
			<div class="icon32" style="width:44px;"><img src='$logo' alt='A plugin by coffee2code' /><br /></div>
			<h2>{$this->plugin_name} Settings</h2>
			<p>Use the image at the bottom to correlate the settings below with the admin interface element they hide.</p>

			<p>Note: These settings are global and will affect all users who are able to visit the admin pages.</p>
			<form name="configure_smtp" action="$action_url" method="post">	
END;
				wp_nonce_field($this->nonce_field);
		echo '<table width="100%" cellspacing="2" cellpadding="5" class="optiontable editform form-table">';
				$first = true;
				foreach ( array_keys($options) as $opt ) {
					$input = $this->config[$opt]['input'];
					if ( $input == 'none' ) continue;
					$label = $this->config[$opt]['label'];
					$value = $options[$opt];
					if ( $input == 'checkbox' ) {
						$checked = ( $value == 1 ) ? 'checked=checked ' : '';
						$value = 1;
					} else {
						$checked = '';
					};
					if ( $this->config[$opt]['datatype'] == 'array' ) {
						if ( $input == 'textarea' || $input == 'inline_textarea' )
							$value = implode("\n", $value);
						else
							$value = implode(', ', $value);
					} elseif ( $this->config[$opt]['datatype'] == 'hash' ) {
						$new_value = '';
						foreach ( $value AS $shortcut => $replacement ) {
							$new_value .= "$shortcut => $replacement\n";
						}
						$value = $new_value;
					}
					echo "<tr valign='top'>";
					if ( $input == 'textarea' ) {
						echo "<td colspan='2'>";
						if ($label) echo "<strong>$label</strong><br />";
						echo "<textarea name='$opt' id='$opt' {$this->config[$opt]['input_attributes']}>" . $value . '</textarea>';
					} else {
						echo "<th scope='row'>$label</th><td>";
						if ( $input == 'inline_textarea' )
							echo "<textarea name='$opt' id='$opt' {$this->config[$opt]['input_attributes']}>" . $value . '</textarea>';
						elseif ( $input == 'select' ) {
							echo "<select name='$opt' id='$opt'>";
							foreach ($this->config[$opt]['options'] as $sopt) {
								$selected = $value == $sopt ? " selected='selected'" : '';
								echo "<option value='$sopt'$selected>$sopt</option>";
							}
							echo "</select>";
						} else {
							$tclass = ($input == 'short_text') ? 'small-text' : 'regular-text';
							if ($input == 'short_text') $input = 'text';
							echo "<input name='$opt' type='$input' id='$opt' value='$value' class='$tclass' $checked {$this->config[$opt]['input_attributes']} />";
						}
					}
					if ( $this->config[$opt]['help'] ) {
						echo "<br /><span style='color:#777; font-size:x-small;'>";
						echo $this->config[$opt]['help'];
						echo "</span>";
					}
					echo "</td>";
					if ( $first ) {
						$first = false;
						echo "<td rowspan='11'><img src='$img_dir/screenshot-1.png' alt='settings to admin mapping'/></td>";
					}
					echo "</tr>";
				}
		echo <<<END
			</table>
			<input type="hidden" name="submitted" value="1" />
			<div class="submit"><input type="submit" name="Submit" class="button-primary" value="Save Changes" /></div>
		</form>
			</div>
END;
				echo <<<END
				<style type="text/css">
					#c2c {
						text-align:center;
						color:#888;
						background-color:#ffffef;
						padding:5px 0 0;
						margin-top:12px;
						border-style:solid;
						border-color:#dadada;
						border-width:1px 0;
					}
					#c2c div {
						margin:0 auto;
						padding:5px 40px 0 0;
						width:45%;
						min-height:40px;
						background:url('$logo') no-repeat top right;
					}
					#c2c span {
						display:block;
						font-size:x-small;
					}
				</style>
				<div id='c2c' class='wrap'>
					<div>
					This plugin brought to you by <a href="http://coffee2code.com" title="coffee2code.com">Scott Reilly, aka coffee2code</a>.
					<span><a href="http://coffee2code.com/donate" title="Please consider a donation">Did you find this plugin useful?</a></span>
					</div>
				</div>
END;
	}

} // end AdminTrimInterface

endif; // end if !class_exists()

if ( class_exists('AdminTrimInterface') )
	new AdminTrimInterface();

?>