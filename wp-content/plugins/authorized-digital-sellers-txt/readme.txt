=== Authorized Digital Sellers TXT ===
Contributors: jeffreyvr
Tags: ads_txt
Requires at least: 4.3
Tested up to: 4.9.1
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This is a simple plugin that provides you with the option of making a Authorized Digital Sellers -file (ads.txt) that is accesable through your site.com/ads.txt.

== Description ==

This is a simple plugin that provides you with the option of making a Authorized Digital Sellers -file (ads.txt) that is accesable through your site.com/ads.txt.

== Installation ==

Install like any other plugin, directly from your plugins page. After installation you'll find the plugin settings at Settings->ADS.txt.

== Frequently Asked Questions ==

= What is Authorized Digital Sellers? =

Authorized Digital Sellers, or ads.txt, is an IAB initiative to improve transparency in programmatic advertising.

For more information, please check https://support.google.com/dfp_premium/answer/7441288.

= I already have an ads.txt file, will this plugin still work? =

In short: yes. The plugin will rename your ads.txt file in order to prevent conflicts with the plugin. If the file is not renamable due to writability issues you'll have to delete (or rename) it yourself.

If the initial file is renamed you can choose to delete it.

== Links ==

*	[Github](https://github.com/jeffreyvr/authorized-digital-sellers-txt)

== Changelog ==

=1.1=
* Now reads ads.txt-contents from plugin option instead of having a physical file in the root (prevents writability issues).
* Renames ads.txt if it already exists to prevent conflicts with the plugin.

= 1.0 =
* Init release.
