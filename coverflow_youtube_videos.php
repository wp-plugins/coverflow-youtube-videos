<?php
/*
  Plugin Name: Coverflow YouTube Videos
  Plugin URI: http://www.mauromascia.com/en/portfolio/wordpress-plugin-coverflow-youtube-videos/
  Description: Displays a user's Youtube videos in a simil-Coverflow way.
  Author: Mauro Mascia
  Author URI: http://www.mauromascia.com
  Version: 1.0.3
  Tags: Videos, Thumbnails, Playlists, YouTube, HD, Coverflow, HTML5 Lightbox
  License: GPLv3

  Coverflow YouTube Videos is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  Coverflow YouTube Videos is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with Coverflow YouTube Videos. If not, see <http://www.gnu.org/licenses/>.
 */


/* Add [coverflow_youtube_videos] to your post or page to display your videos. */
if (function_exists('fetch_coverflow_youtube_vids')) {
    add_shortcode('coverflow_youtube_videos', 'fetch_coverflow_youtube_vids');
}

function fetch_coverflow_youtube_vids($args) {
    //Useful doc @ http://www.ibm.com/developerworks/xml/library/x-youtubeapi/
    //process incoming attributes assigning defaults if required
    $shortcode_args = shortcode_atts(array(
        "user" => get_option('coverflow_youtube_username'),
        "list" => null
            ), $args);

    $CFYT_BASE_FOLDER = basename(dirname(__FILE__));
    $CFYT_ABSPATH = str_replace("\\", "/", WP_PLUGIN_DIR . '/' . $CFYT_BASE_FOLDER);
    $CFYT_URLPATH = plugins_url($CFYT_BASE_FOLDER);

    $username = $shortcode_args["user"];
    $coverflow_youtube_reflection = get_option('coverflow_youtube_reflection');
    $coverflow_youtube_circular = get_option('coverflow_youtube_circular');
    $coverflow_youtube_scale = get_option('coverflow_youtube_scale');
    $coverflow_youtube_position = get_option('coverflow_youtube_position');

    if ($plist = $shortcode_args["list"]) {
        /*
         * FIX 1.0.3 - This seems not to be useful anymore
        if (strlen($plist) != 18 && strlen($plist) != 16 || (strlen($plist) == 18 && !preg_match("/^(PL|UU|FL)/i", $plist))) {
            return "Playlist ID must be 16 character long or 18 if starting with 'PL' (Play List) or 'UU' (User Uploads) or 'FL' (Favourite List).";
        }

        if (strlen($plist) == 18) {
            $plist = substr($plist, 2); //remove PL|FL|UU
        }
         * 
         */

        $url = 'http://gdata.youtube.com/feeds/api/playlists/' . $plist . '?v=2';
        $type = "user-playlist";
    } else {
        $url = 'http://gdata.youtube.com/feeds/api/users/' . $username . '/uploads';
        $type = "user-uploads";
    }

    $sxml = simplexml_load_file($url);
    //echo "<pre>";print_r($sxml);echo "</pre>"; //debug

    if ($sxml->entry):
        $content = <<<HTML
        
	<div class="ContentFlow" id="Coverflow-Youtube-Videos">
		<div class="loadIndicator"><div class="indicator"></div></div>
        <div class="flow">
        
HTML;

		foreach ($sxml->entry as $entry):
			switch ($type) {
				case "user-uploads":
					$id = end(explode('/', $entry->id));

					$media = $entry->children('http://search.yahoo.com/mrss/');

                    // get video player URL
                    //$attrs = $media->group->player->attributes();
                    //$watch = $attrs['url'];

					// get video thumbnail
					$attrs = $media->group->thumbnail[0]->attributes();
					$thumbnail = $attrs['url'];
					
					$alt = $media->group->title;
					
					break;
                
				case "user-playlist":
				    $id = _get_video_id_from_playlist_entry($entry);
				    
				    $alt = $entry->title;

                    // get video thumbnail
                    $thumbnail = "http://img.youtube.com/vi/$id/0.jpg";
                    break;
			}

			$content.= <<<HTML
			<a href="http://www.youtube.com/embed/$id?rel=0&wmode=transparent" class="html5lightbox item">
				<img alt="$alt" src="$thumbnail" height="auto" width="200" class="content" />
				<div class="caption">$alt</div>
			</a>
HTML;
		endforeach;

		$content.= <<<HTML
		
		</div>
		<div class="globalCaption"></div>
		<div class="scrollbar">
			<div class="preButton"></div>
			<div class="nextButton"></div>
			<div class="slider"><div class="position"></div></div>
		</div>
	</div>
		
HTML;

        //add Highslide and Imageflow capabilities
        $content.= <<<JS
    
    <script type="text/javascript" src="$CFYT_URLPATH/html5lightbox/html5lightbox.js"></script>
    
    <link rel="stylesheet" href="$CFYT_URLPATH/ContentFlow/contentflow.css" type="text/css" media="all" />
    <script type="text/javascript" src="$CFYT_URLPATH/ContentFlow/contentflow.js"></script>
	<script type="text/javascript">
		var myNewFlow = new ContentFlow('Coverflow-Youtube-Videos', {
			reflectionHeight: $coverflow_youtube_reflection,
			scaleFactor: $coverflow_youtube_scale,
			circularFlow: '$coverflow_youtube_circular',
                        startItem: '$coverflow_youtube_position',
			onclickActiveItem: false, //default behaviour open a new window; we'll use html5lightbox instead!
		} ) ;
		
	</script>
JS;

    else:
        $content = "No results found... check the username in the configuration section.<br />";
    endif;

    return $content; // Displays the YouTube video feed.
}

/* Runs when plugin is activated */
register_activation_hook(__FILE__, 'coverflow_youtube_vids_install');

function coverflow_youtube_vids_install() {
    /* Creates new database field
     * http://codex.wordpress.org/Function_Reference/add_option
     * */
    add_option("coverflow_youtube_username", 'GammaUmma', '', 'yes');
    add_option("coverflow_youtube_reflection", '0.5', '', 'yes');
    add_option("coverflow_youtube_circular", 'yes', '', 'yes');
    add_option("coverflow_youtube_scale", '1', '', 'yes');
    add_option("coverflow_youtube_position", 'center', '', 'yes');
}

/* Runs on plugin deactivation */
register_deactivation_hook(__FILE__, 'coverflow_youtube_vids_remove');

function coverflow_youtube_vids_remove() {
    /* Deletes the database field */
    delete_option('coverflow_youtube_username');
    delete_option('coverflow_youtube_reflection');
    delete_option('coverflow_youtube_circular');
    delete_option('coverflow_youtube_scale');
    delete_option('coverflow_youtube_position');
}

if (is_admin()) {

    function coverflow_youtube_vids_menu() {
        add_options_page('Coverflow YouTube Videos', 'Coverflow YouTube Videos', 'manage_options', __FILE__, 'coverflow_youtube_vids_settings');
    }

    add_action('admin_menu', 'coverflow_youtube_vids_menu');
}

function coverflow_youtube_vids_settings() {
    $coverflow_youtube_username = get_option('coverflow_youtube_username');
    $coverflow_youtube_reflection = get_option('coverflow_youtube_reflection');
    $coverflow_youtube_circular = get_option('coverflow_youtube_circular');
    $coverflow_youtube_scale = get_option('coverflow_youtube_scale');
    $coverflow_youtube_position = get_option('coverflow_youtube_position');
    ?>

    <div class="wrap">
        <div id="icon-options-general" class="icon32"><br></div>
        <h2>Coverflow YouTube Videos</h2>
        <form method="post" action="options.php">
            <?php wp_nonce_field('update-options'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Username (Global):</th>
                    <td>
                        <input type="text" name="coverflow_youtube_username" value="<?php echo $coverflow_youtube_username; ?>" />
                        <span><i>Default is: GammaUmma.</i></span>
                    </td>
                </tr>
                <tr valign="top">
                    <td colspan="2"><i>You can specify a different user per page by adding "user" attribute in the shortcode, i.e. [coverflow_youtube_videos user="NewUsername"]</i></td>
                </tr>
                <tr>
                    <td colspan="2"><i>Otherwise you can specify a user playlist per page by adding "list" attribute in the shortcode, i.e. [coverflow_youtube_videos list="PLAYLIST_ID"]</i></td>
                </tr>
                <tr><td>&nbsp;</td></tr>
                <tr><td><b>Global Settings</b></td></tr>
                <tr valign="top">
                    <th scope="row">Enable reflection?</th>
                    <td>
                        <select name="coverflow_youtube_reflection" size="1">
                            <option value="0" <?php echo $coverflow_youtube_reflection != '0' ? "" : ' selected="selected"'; ?>>0 (disabled)</option>
                            <option value="0.25" <?php echo $coverflow_youtube_reflection != '0.25' ? "" : ' selected="selected"'; ?>>1/4</option>
                            <option value="0.5" <?php echo $coverflow_youtube_reflection != '0.5' ? "" : ' selected="selected"'; ?>>half (default)</option>
                            <option value="0.75" <?php echo $coverflow_youtube_reflection != '0.75' ? "" : ' selected="selected"'; ?>>3/4</option>
                            <option value="1" <?php echo $coverflow_youtube_reflection != '1' ? "" : ' selected="selected"'; ?>>1</option>
                        </select>
                        <span><i>Select the quantity of reflection that you like respect to the image; 0 disable the reflection.</i></span>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Enable circular?</th>
                    <td>
                        <select name="coverflow_youtube_circular" size="1">
                            <option value="true" <?php echo $coverflow_youtube_circular != 'true' ? "" : ' selected="selected"'; ?>>Yes</option>
                            <option value="false" <?php echo $coverflow_youtube_circular != 'false' ? "" : ' selected="selected"'; ?>>No</option>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Position</th>
                    <td>
                        <select name="coverflow_youtube_position" size="1">
                            <option value="center" <?php echo $coverflow_youtube_position != 'center' ? "" : ' selected="selected"'; ?>>Center</option>
                            <option value="first" <?php echo $coverflow_youtube_position != 'first' ? "" : ' selected="selected"'; ?>>First</option>
                            <option value="last" <?php echo $coverflow_youtube_position != 'last' ? "" : ' selected="selected"'; ?>>Last</option>
                        </select>
                        <span><i>Videos are order by date: set it to "first" or "last" to move the videos. Default is "center"</i></span>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Image scale factor:</th>
                    <td>
                        <select name="coverflow_youtube_scale" size="1">
                            <option value="0.5" <?php echo $coverflow_youtube_scale != '0.5' ? "" : ' selected="selected"'; ?>>0.5</option>
                            <option value="1" <?php echo $coverflow_youtube_scale != '1' ? "" : ' selected="selected"'; ?>>1</option>
                            <option value="1.5" <?php echo $coverflow_youtube_scale != '1.5' ? "" : ' selected="selected"'; ?>>1.5</option>
                            <option value="2" <?php echo $coverflow_youtube_scale != '2' ? "" : ' selected="selected"'; ?>>2</option>
                            <option value="2.5"   <?php echo $coverflow_youtube_scale != '2.5'   ? "" : ' selected="selected"'; ?>>2.5</option>
                            <option value="3" <?php echo $coverflow_youtube_scale != '3' ? "" : ' selected="selected"'; ?>>3</option>
                            <option value="3.5" <?php echo $coverflow_youtube_scale != '3.5' ? "" : ' selected="selected"'; ?>>3.5</option>
                            <option value="4" <?php echo $coverflow_youtube_scale != '4' ? "" : ' selected="selected"'; ?>>4</option>
                            <option value="4.5" <?php echo $coverflow_youtube_scale != '4.5' ? "" : ' selected="selected"'; ?>>4.5</option>
                            <option value="5"   <?php echo $coverflow_youtube_scale != '5'   ? "" : ' selected="selected"'; ?>>5</option>
                        </select>
                        <span><i>Scale the image; default is 1</i></span>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="page_options" value="coverflow_youtube_username, coverflow_youtube_reflection, coverflow_youtube_circular, coverflow_youtube_scale, coverflow_youtube_position" />
            <p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>
        </form>

    </div>
    <?php
}

/**
 * Retrieve the video ID
 * @param type $entry
 * @return type 
 */
function _get_video_id_from_playlist_entry($entry) {
    foreach ($entry->link as $value) {
        $attr = $value->attributes();
        switch ($attr["rel"]) {
            case "alternate":
                preg_match("/v=(?P<id>.+)&/i", $attr["href"], $matches);
                return $matches["id"];

                break;
            
            //TODO: implement other cases
            
            default:
                break;
        }
    }
    
    /** EXAMPLE
[link] => Array
(
    [0] => SimpleXMLElement Object
        (
            [@attributes] => Array
                (
                    [rel] => alternate
                    [type] => text/html
                    [href] => http://www.youtube.com/watch?v=MotNtq41NDw&feature=youtube_gdata
                )

        )

    [1] => SimpleXMLElement Object
        (
            [@attributes] => Array
                (
                    [rel] => http://gdata.youtube.com/schemas/2007#video.responses
                    [type] => application/atom+xml
                    [href] => http://gdata.youtube.com/feeds/api/videos/MotNtq41NDw/responses?v=2
                )

        )

    [2] => SimpleXMLElement Object
        (
            [@attributes] => Array
                (
                    [rel] => http://gdata.youtube.com/schemas/2007#video.related
                    [type] => application/atom+xml
                    [href] => http://gdata.youtube.com/feeds/api/videos/MotNtq41NDw/related?v=2
                )

        )

    [3] => SimpleXMLElement Object
        (
            [@attributes] => Array
                (
                    [rel] => http://gdata.youtube.com/schemas/2007#mobile
                    [type] => text/html
                    [href] => http://m.youtube.com/details?v=MotNtq41NDw
                )

        )

    [4] => SimpleXMLElement Object
        (
            [@attributes] => Array
                (
                    [rel] => related
                    [type] => application/atom+xml
                    [href] => http://gdata.youtube.com/feeds/api/videos/MotNtq41NDw?v=2
                )

        )

    [5] => SimpleXMLElement Object ------ note: here there is not info about the video id
        (
            [@attributes] => Array
                (
                    [rel] => self
                    [type] => application/atom+xml
                    [href] => http://gdata.youtube.com/feeds/api/playlists/D3825F01D6ABC361/PLFZmjErlPdgwT1yIXoBYXNhoKcPqOJu6o?v=2
                )

        )

)
     */
    
}
?>
