== Plugin Name ==

Plugin Name: Coverflow YouTube Videos
Plugin URI: http://www.mauromascia.com/en/portfolio/wordpress-plugin-coverflow-youtube-videos/
Contributors: Mauro Mascia
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=P3U53N8ZWLMD8
Tags: Video, Videos, Thumbnail, Thumbnails, Playlists, YouTube, HD, Coverflow, ContentFlow, HTML5Lightbox
Requires at least: 3.3.1
Tested up to: 3.4.2

Displays a user's Youtube videos in a simil-Coverflow way.


== Description ==

Displays a user's Youtube videos in a simil-Coverflow way.

This plugin uses ContentFlow v1.0.2 and HTML5Lightbox Javascript 
libraries to mimic the Coverflow's Apple visualization interface.

- ContentFlow is licensed as MIT (GPL-compatible):http://www.jacksasylum.eu/ContentFlow/license.php)
- HTML5Lightbox is licensed as GPL2: http://html5box.com/html5lightbox/index.php


== Credits ==

Sebs Studio (Sebastien @ http://www.sebs-studio.com) for the "My YouTube Videos" plugin used as initial code for this project.


== Installation ==

1. Unzip the archive of the plugin (or download it from the Wordpress plugin repository).
2. Upload the folder 'coverflow-youtube-videos' to the Wordpress plugin directory (../wp-content/plugins/)
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Configure it as you like


== Frequently Asked Questions ==

Q1. Do I need to edit any files?
A1. No, once followed the installation instruction you have done. Just check for file permissions (chmod +x).

Q2. How do I display the user's YouTube videos?
A2. Add this shortcode to either a post or page: [coverflow_youtube_videos].

Q3. How do I enable videos of a specific user?
A3. Go to 'Settings -> Coverflow YouTube Videos' and change the username of the Youtube user.
    You can use the attribute "user" to change global username per page.
    You can also specify a user playlist per page by adding a "list" attribute in the shortcode,
	i.e. [coverflow_youtube_videos list="PLAYLIST_ID"]

Q4. I need some plugin modifications. How can I tell you what I want?
A4. Send me an email at info@mauromascia.com and we'll talk about it.


== Screenshots ==

1. cyv1.jpg: User's YouTube videos shown in a simil-Coverflow way
2. cyv2.jpg: Single video overlay
3. cyv3.jpg: Configuration panel


`<?php code(); // goes in backticks ?>`
