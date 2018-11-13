=== Plugin Name ===
Contributors: brandbrilliance
Donate link: http://j.mp/1QvdGgX
Tags: wp-admin, admin, post state, color, post colours, list, highlight
Requires at least: 3.8
Tested up to: 4.9.8
Stable tag: 2.0.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Highlights the left border color and background color and reformats the post status as visual color tags in the wordpress admin post list view.

== Description ==

Highlights the left border color and background color and reformats the post status as visual color tags in the wordpress admin post list view. Supports the standard Wordpress status for: Published, Future, Draft, Pending, Private, Protected, Sticky (tag only) and custom statuses like Archived (via [Archive Post Status](http://wordpress.org/plugins/archived-post-status/) plugin.

= Posts/Pages Features =

* Adds a left thick border color and highlights the line with a light background color, similar to the comments and plugins admin views.
* Modifies the post status tags added to a Page/Post name to have a tag appearance with matching background color and dashicon
* Both these changes make it super easy to spot the various types of post statuses in the admin view
* Supports all Wordpress Post status values: Published, Future, Draft, Pending, Private, Protected, Sticky (tag only)
* Support for custom post statuses like Archived via [Archive Post Status](http://wordpress.org/plugins/archived-post-status/) plugin  
* Supports the 4.2 status of the Front Page and Posts Page (blog page) to easily spot those posts/pages
* Supports the 4.3 tags of Scheduled Posts to see upcoming posts/pages
* Supports the 4.9.6 tags of Privacy Policy Page 
* Define custom colors using the color picker in the Admin Settings screen
* Define custom dash icons using the dashicons picker in the Admin Settings screen
* Enable/disable view in Admin Settings screen
* Enable/disable icons in Admin Settings screen
* Change the background color lightness value from 0 (dark) to (1) light
* Reset settings to defaults in Admin Settings screen

> <strong>IMPORTANT NOTE</strong><br>
> If all your posts or pages are only published, nothing in the display will change. This plugin doesn't add anything to regular **Published** posts, otherwise the screen will look way too colourful. To see the plugin in action, you will have to set at least one of your posts or pages to DRAFT, PENDING, PROTECTED, PRIVATE or any status **other** than published, to make it show something.

= Notes =

* Icons appear inside the tag, if enabled.
* Published status: color, no tag.
* Scheduled status: color, with tag (WP 4.3+)
* Protected status: overrides color, but still adds tag (multiple tags support)
* Sticky status: tag only (multiple tags support).
* Front Page, Blog Posts: tag only (WP 4.2+)
* Privacy Policy Page (WP 4.9.6+)

= Acknowledgements =

* Some inspiration for the tags was taken from the [WordPress Landing Pages](http://wordpress.org/plugins/landing-pages/) plugin.
* Thanks to [Brad Vincent](http://themergency.com) for his [Dashicons Picker](https://github.com/bradvin/dashicons-picker) with some minor modifications and updates.

== Installation ==

1. Use the Wordpress Admin Plugins installer: Search for the plugin name, and click INSTALL and click the ACTIVATE link
1. -or- Download the ZIP: Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins admin page.
1. Ensure you have some posts or pages that are not just published to see the default colors

== Frequently Asked Questions ==

= Where are the settings? =

You can click the Settings link on the plugin install screen, or find it under SETTINGS: Post State Tags.

= Why are there no default settings to make it look like the screenshots? =

On some installations, the plugin setup doesn't work correctly (haven't figured that out), so the settings appears blank. Just click on the [RESET SETTINGS] button at the bottom to reset the settings, make change after and then SAVE.

= Can I change colors? =

Yes. In the settings admin screen, you can change the color values using the color picker. The lighter background color is automatically calculated using RGB/HSL values.

= Can I change icons? =

Yes. In the settings admin screen, you can pick new dash icons using the picker, or enter the dash icon class, see [DashIcons](https://developer.wordpress.org/resource/dashicons/).

= Are there default colors and icons / How can I reset to defaults? =

You can simply go to the settings and click the reset to defaults button at the bottom to reset all the colors and dash-icons to their default values.

= Can I temporarily disable the plugin? =

Yes. In the settings admin screen, there is a checkbox to disable the output (preserve settings).

= Can I hide the little dash icons? =

Yes. In the settings admin screen, there is a checkbox to disable the tag icons (if you prefer).

= How do I change the light background color value =

There is a back-end setting to change the value of the lightness. The default is 0.97 which creates a 97% lightness of the primary status color setup for each status. The values can range from 0 =  black/dark to 0.5 = full saturation of the color to 1.0 = full white/light.

== Screenshots ==

1. Screenshot sample with default colors for a variety of post types
2. Screenshot showing the new WP4.2 Front Page and Posts Page "status" 
3. Screenshot showing the Settings interface where you can adjust settings like colors, icons 

== Changelog ==

= 2.0.3 =
* Replaced create_function in Settings API library with anonymous function

= 2.0.2 =
* Fixed a bug in the migration check for install and version

= 2.0.1 =
* Refactor plugin as a PHP Class
* Settings API Library used to manage settings Tabs and update settings
* Added additional Lightness value in the advanced tab, to directly control the lightness of the background color.
* Added support for the new Privacy Policy Page (since WP 4.9.6)

= 1.1.8 =
* Compatibility for WP 4.9.8

= 1.1.7 =
* Compatibility for WP 4.7

= 1.1.6 =
* Replace admin url function in settings

= 1.1.5 =
* Fixed installation bug where icons weren't setup correctly (finally)
* Flag as compatible with Wordpress 4.6

= 1.1.4 =
* Flag as compatible with Wordpress 4.5

= 1.1.3 =
* Small style fixes in the way Wordpress 4.4 displays settings

= 1.1.2 =
* Added corrected support for new inline scheduled post status, since WP 4.3

= 1.1.1 =
* Added filter for background color light value, with example code in FAQ

= 1.1.0 =
* Added Settings interface for: enable, icon visbility, post status color picker and dashicons picker

= 1.0.1 =
* Modified post archive status dashicon to match icon from Archived Post Status plugin 

= 1.0 =
* First release using standard Wordpress colors
