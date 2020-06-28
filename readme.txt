=== Admin Trim Interface ===
Contributors: coffee2code
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6ARCFJ9TX3522
Tags: admin, interface, minimal, customize, coffee2code
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 4.9
Tested up to: 5.4
Stable tag: 3.4

Customize the WordPress admin pages by selectively removing interface elements on a per-user basis.


== Description ==

This plugin uses a combination of WordPress hooks, CSS (when possible), and Javascript (last resort) to removed specified admin interface elements. These elements may be considered by some to be superfluous interface elements that are undesired for one reason or another, so this plugin aids in their visual removal.

Each admin interface element is individually selected for removal. The elements that can be removed are:

* The header WordPress logo (bear in mind this functions as a menu) in the admin bar
* The home icon next to your site's name in the admin bar
* The "Howdy," greeting before your username in the admin bar
* Your username link to your profile in the admin bar
* Your avatar in the admin bar
* The Dashboard menu link in the sidebar
* The contextual "Help" link
* The footer links
* The WordPress version in the footer

(There is an associated screenshot which points out these different sections.)

Note: These settings are global and will affect all users who are able to visit the admin pages.

Links: [Plugin Homepage](https://coffee2code.com/wp-plugins/admin-trim-interface/) | [Plugin Directory Page](https://wordpress.org/plugins/admin-trim-interface/) | [GitHub](https://github.com/coffee2code/admin-trim-interface/) | [Author Homepage](https://coffee2code.com)


== Installation ==

1. Install via the built-in WordPress plugin installer. Or download and unzip `admin-trim-interface.zip` inside the plugins directory for your site (typically `wp-content/plugins/`)
1. Activate the plugin through the 'Plugins' admin menu in WordPress
1. Click the plugin's 'Settings' link next to its 'Deactivate' link (still on the Plugins page), or click on the 'Appearance' -> 'Admin Trim Interface' link, to go to the plugin's admin settings page. Customize the settings to selectively remove admin interface elements.


== Frequently Asked Questions ==

= Does this plugin allow for each admin user to customize the admin interface to their individual liking? =

No. The settings for the plugin apply to all users within the admin pages and not to each user individually.

= Why is the admin dashboard still accessible? =

This plugin does not prevent access to the admin dashboard; it merely provides the ability to hide the admin sidebar menu button that leads to the admin dashboard.


== Screenshots ==

1. A image identifying the different elements of the admin interface that can be selectively disabled by the plugin.
2. An image of the user section of the admin bar when "Howdy" and the username is hidden, leaving only the avatar.
3. An image of the user section of the admin bar when "Howdy" and the avatar is hidden, leaving only the username.
4. A screenshot of the plugin's admin settings page.
5. A screenshot of a fully trimmed admin interface.


== Changelog ==

= 3.4 (2020-06-27) =

### Highlights:

This recommended release adds the ability to hide the "My Sites" icon, prevents output of plugin-specific settings styles on other admin pages, omits the `type` attribute for `style` tag for themes that support 'html5', updates the plugin framework, adds a TODO.md file, updates a few URLs to be HTTPS, expands unit testing, updates compatibility to be WP 4.9 through 5.4+, and more.

### Details:

* New: Add ability to trim "My Sites" icon in admin bar
* New: Add HTML5 compliance by omitting `type` attribute when the theme supports 'html5'
* Change: Prevent output of plugin-page specific CSS elsewhere
* Change: Discontinue handling for contextual help text added via deprecated filter `contextual_help`
* Change: Update plugin framework to 050
    * Allow a hash entry to literally have '0' as a value without being entirely omitted when saved
    * Output donation markup using `printf()` rather than using string concatenation
    * Update copyright date (2020)
    * Note compatibility through WP 5.4+
    * Drop compatibility with version of WP older than 4.9
* New: Add TODO.md and move existing TODO list from top of main plugin file into it
* Change: Refactor handling of dynamic CSS rules and ensure they output properly indented
* Change: Adjust some CSS formatting (add second colon for `::before` and spaces around `>`)
* Change: Adjust output spacing for CSS
* Change: Note compatibility through WP 5.4+
* Change: Drop compatibility for version of WP older than 4.9
* Change: Add missing text domain from a few string translation calls
* Change: Remove unnecessary numbering of sole placeholder in string
* Change: Update links to coffee2code.com to be HTTPS
* Change: Update legend image
* Change: Update screenshot images
* Unit tests:
    * New: Add tests for `add_css()`, `admin_init()`, `explain_nonce()`, `show_admin_notices()`, `show_legend_image()`
    * New: Add test for setting name
    * New: Add helper `set_current_screen()` for setting the current screen, defaulting to plugin's setting page
    * Change: Store plugin instance in test object to simplify referencing it
    * Change: Update tests for default hooks, removing a duplicate and adding 2 that were missing
    * Change: Use HTTPS for link to WP SVN repository in bin script for configuring unit tests (and delete commented-out code)

= 3.3.1 (2019-12-16) =
* Unit tests:
    * Change: Update unit test install script and bootstrap to use latest WP unit test repo
    * New: Add test that plugin initializes itself on `plugins_loaded`
* Change: Note compatibility through WP 5.3+
* Change: Update copyright date (2020)

= 3.3 (2019-04-06) =
* Change: Initialize plugin on `plugins_loaded` action instead of on load
* Change: Update plugin framework to 049
    * 049:
    * Correct last arg in call to `add_settings_field()` to be an array
    * Wrap help text for settings in `label` instead of `p`
    * Only use `label` for help text for checkboxes, otherwise use `p`
    * Ensure a `textarea` displays as a block to prevent orphaning of subsequent help text
    * Note compatibility through WP 5.1+
    * Update copyright date (2019)
* New: Add CHANGELOG.md file and move all but most recent changelog entries into it
* Change: Note compatibility through WP 5.1+
* Change: Update copyright date (2019)
* Change: Update License URI to be HTTPS
* Change: Split paragraph in README.md's "Support" section into two

_Full changelog is available in [CHANGELOG.md](https://github.com/coffee2code/admin-trim-interface/blob/master/CHANGELOG.md)._


== Upgrade Notice ==

= 3.4 =
Recommended update: added ability to hide "My Sites" icon, prevented output of styles for plugin's settings on other admin pages, updated plugin framework, added TODO.md file, updated a few URLs to be HTTPS, expanded unit testing, updated compatibility to be WP 4.9-5.4+, and more.

= 3.3.1 =
Trivial update: modernized unit tests and noted compatibility through WP 5.3+

= 3.3 =
Minor update: tweaked plugin initialization, updated plugin framework to v049, noted compatibility through WP 5.1+, created CHANGELOG.md to store historical changelog outside of readme.txt, and updated copyright date (2019).

= 3.2 =
Minor update: improved responsiveness of settings page; fixed to show admin notices on settings page; added unit tests; updated plugin framework to v048; compatibility is now WP 4.7-4.9; updated copyright date (2018); added README.md; and more.

= 3.1 =
Minor update: improved support for localization; verified compatibility through WP 4.4; updated copyright date (2016)

= 3.0 =
Recommended update: Updated trim capabilities to be WP 4.1 compatible; dropped pre-WP 3.8 support; updated plugin framework.

= 2.2 =
Recommended update: Updated trim capabilities to be WP 3.3 compatible; minor bugfix; dropped pre-WP 3.1 support; updated plugin framework.

= 2.1 =
Recommended update. Update trim capabilities to be WP 3.2 compatible; improved interface trimming techniques; dropped support for versions of WP older than 3.0; updated plugin framework; and more.

= 2.0.3-=
Recommended bugfix release: fixed bug introduced in previous release.

= 2.0.2 =
Minor release: updated underlying plugin framework; noted compatibility with WP 3.1+ and updated copyright date.

= 2.0.1 =
Minor bugfix update of underlying plugin framework.

= 2.0 =
Recommended update! This release fixes WP 3.0 compatibility. It also includes major re-implementation, bug fixes, localization support, and more.
