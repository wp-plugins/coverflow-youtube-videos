=== Plugin Name ===
Contributors: baba_mmx
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=WQA7VVGLLW6UN
Tags: video, playlists, youyube, coverflow, contentflow, html5lightbox, lightbox
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 1.0.1
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Displays a user's Youtube videos in a simil-Coverflow way.

== Description ==

Displays a user's Youtube videos in a simil-Coverflow way.

This plugin uses ContentFlow v1.0.2 and HTML5Lightbox Javascript 
libraries to mimic the Coverflow's Apple visualization interface.

* [ContentFlow](http://www.jacksasylum.eu/ContentFlow/license.php "ContentFlow") is licensed as MIT *GPL-compatible*
* [HTML5Lightbox](http://html5box.com/html5lightbox/index.php "HTML5Lightbox") is licensed as GPLv2

== Installation ==

1. Unzip the archive of the plugin or download it from the [official Wordpress plugin repository](http://wordpress.org/extend/plugins/coverflow-youtube-videos/ "Coverflow Youtube Videos")
2. Upload the folder 'coverflow-youtube-videos' to the Wordpress plugin directory (../wp-content/plugins/)
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Configure it as you like

== Frequently Asked Questions ==

= Do I need to edit any files? =
No, once followed the installation instruction you have done. Just check for file permissions (chmod +x).

= How do I display the user's YouTube videos? =
Add this shortcode to either a post or page: **[coverflow_youtube_videos]**.

= How do I enable videos of a specific user? =
Go to 'Settings -> Coverflow YouTube Videos' and change the username of the Youtube user.
You can use the attribute "user" to change global username per page.
You can also specify a user playlist per page by adding a "list" attribute in the shortcode,
i.e. **[coverflow_youtube_videos list="PLAYLIST_ID"]**

= I need some plugin modifications. How can I tell you what I want? =
Send me an email at **info@mauromascia.com** and we'll talk about it.

== Screenshots ==

1. User's YouTube videos shown in a simil-Coverflow way
2. Single video overlay
3. Configuration panel

== Changelog ==

= 1.0.1 =
* Fixed: issue with thumbnails on playlists

= 1.0 =
* First release

== Upgrade Notice ==

== Credits ==

Sebs Studio [Sebastien](http://www.sebs-studio.com/ "Sebs Studio") for the "My YouTube Videos" plugin used as initial code for this project.

