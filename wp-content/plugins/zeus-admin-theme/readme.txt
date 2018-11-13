=== Zeus WordPress Admin ===
Contributors: Luke Hertzler
Donate link: http://example.com/
Tags: admin, Admin page, admin panel, Admin theme style plugin, admin-theme, backend theme, Custom admin theme, flat admin theme, Free admin theme style plugin, modern admin theme, new admin ui, plugin, luke hertzler, simple admin theme, wordpress, WordPress admin Panel, wordpress admin theme, wp admin page, wp admin theme, menu editor, delete menu, add menu, hide menu, create menu, search, search admin, search dashboard, hide toolbar, move toolbar, hide front-end menu
Requires at least: 3.0.1
Tested up to: 4.3.1
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A simple, clean admin theme with select features to extend and improve your WordPress experience.

== Description ==

The Zeus WordPress Admin plugin is a pragmatic solution to improve upon the slow changing WordPress dashboard.  The idea is
to bundle multiple features that bring the WordPress admin to a more modern level.

The plugin extends WordPress by installing the following features:

*   **Improved admin CSS** - Simple and minimal CSS markup to improve read-ability and overall backend experience.  Slightly wider 
admin menu and modifications to colors and spacing go a long way.  Instead of creating an "admin theme" where WordPress becomes 
un-recognizable, I simply took the same approach WordPress had, and improved upon it.
*   **Hide Front-End Toolbar** - Implemented the ability to move the front-end toolbar off the page.  This is especially
important for site that use fixed position navigation menus.  Simply click and arrow on the toolbar and watch is slide away.  Adds
and arrow to your toolbar, when clicked the toolbar will slide away and body will be restored to original position.
*   **Global Admin Search** - Search through your entire WordPress back-end and view real-time results.  Makes jumping to a certain
post/page/product/custom post type extremely easy.  Click the icon in the top bar or type '/' to start a search.
*   **Menu Editor** - Nothing is more annoying than a cluttered menu because every plugin is fighting for space.  Use
the menu editor to hide menu items, move top-level plugins into settings, create your own menu, and more.  The menu editor
is located in the Settings tab.


== Installation ==

To install:

1. Download 'zeus-wordpress-admin.zip'
2. Upload 'zeus-wordpress-admin.zip' to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Where is the admin menu editor? =

You can edit your administration menu by navigation to Settings>Menu Editor.

= How do I search the back-end? =

Start a search by clicking the magnifying glass in the top admin bar or by pressing '/'.

= How do I hide the front-end toolbar? =

Click the arrow in the top right corner of the toolbar.  To open the menu, click the arrow again.

== Screenshots ==

1. Slight adjustments to CSS markup to improve administration experience.
2. Overlay search feature to navigate your back-end.
3. Arrow added to front-end toolbar.  Click to hide the toolbar.
4. Toolbar hidden and arrow on top left.  Click arrow to show the toolbar.
5. Menu Editor UI.

== Changelog ==

= 1.1 =

* Removed WP Sessions and Cookies from the hide front-end toolbar feature until I fix PHP Warnings.
* Increased speed of transition to hide/show front-end toolbar.

= 1.0 =

* Initial commit.

== Upgrade Notice ==

= 1.1 =
Fixed PHP Warning errors by removing WP Sessions and cookies from hide front-end toolbar.

= 1.0 =
Initial plugin launch.
