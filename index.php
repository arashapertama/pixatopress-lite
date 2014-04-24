<?php
/*
Plugin Name: PixatoPress Lite
Plugin URI: http://PixatoPress.com/
Description: The ulitmate plugin for creating massive wallpaper sites using WordPress in just minutes.
Date: 2014, Apr 24
Author: Jorgen Schetters, Kaspar Lenferink
Author URI: http://PixatoPress.com/
Version: 1.2
*/

/*
Author: Jorgen Schetters, Kaspar Lenferink
Website: http://www.PixatoPress.com
Copyright 2013-14 Kaspar Lenferink All Rights Reserved.
*/

if(!function_exists('wp_get_current_user')) {
    include(ABSPATH . "wp-includes/pluggable.php"); 
}

define('PX_DIR', dirname(__FILE__));
define('PX_INCLUDES_DIR', PX_DIR . "/includes");
define('PX_ASSETS_DIR', PX_DIR . "/assets");
define('PX_URL', WP_PLUGIN_URL . "/" . basename(PX_DIR));
define('PX_INCLUDES_URL', PX_URL . "/includes");
define('PX_ASSETS_URL', PX_URL . "/assets");
define('PX_VERSION', '1.1');

require_once('includes/plugpages.php');

//=====================================================================
// Menu Options Page
// =====================================================================
function pixato_create_menu() {

	// Create top-level menu
	add_menu_page( 'PixatoPress Lite', 'PixatoPress Lite', 'administrator', __FILE__, 'pixato_home_page', plugins_url('images/pixatopress.png', __FILE__) );

	// Create sub menu pages
	add_submenu_page( __FILE__, 'Settings', 'Settings', 'administrator', 'pixato-settings', 'pixato_settings_page' );
	//add_submenu_page( __FILE__, 'Help', 'Help', 'administrator', 'pixato-help', 'pixato_help_page' );
}
// create custom plugin settings menu
add_action( 'admin_menu', 'pixato_create_menu');


/************************************************************************/
/* Plugin Activation Hook */
/************************************************************************/
register_activation_hook(__FILE__, 'pixato_activate');
function pixato_activate() {
    
    flush_rewrite_rules();
    
    // Set defualt options set
	$pixatoSettings = array (
    	'defaultContent' => 'Download {title} free HD Wallpaper from the available resolutions. If you don\'t find the exact resolution you are looking for, then go for \'Original\' or higher resolution which may fits perfect to your desktop.',
    	'defaultNumOfTags' => 3,
    	'defaultTagModifiers' => 'wallpaper, hd wallpaper, desktop wallpaper, high res wallpaper, high res desktop wallpaper',
    );

	update_option('pixatoSettings', $pixatoSettings);

}

/************************************************************************/
/* Plugin Deactivation Hook */
/************************************************************************/
register_deactivation_hook(__FILE__, 'pixato_deactivate');
function pixato_deactivate() {
    
    flush_rewrite_rules();

    // Delete plugin option sets
    delete_option( 'pixatoSettings' );
}

/************************************************************************/
/* Plugin Primary Menu Page  */
/************************************************************************/
function pixato_home_page() {

	wp_enqueue_media();

?>
<div class="wrap">
<h2></h2>

<form action="" method="POST">

<div id="poststuff" class="metabox-holder">
	<img src="<?php echo PX_URL . '/images/pixatopresslite.png'; ?>" title="Pixato Press Lite" />
</div>

<div class="metabox-holder has-right-sidebar">
<div class="meta-box-sortabless">

    <?php include 'includes/plugsidebar.php'; ?>
    <?php $pixatoSettings = get_option('pixatoSettings'); ?>

	<div class="has-sidebar sm-padded">
	<div id="post-body-content" class="has-sidebar-content">
	<div class="meta-box-sortabless">

	<div class="postbox">
	<h3 class="hndle">Add Wallpapers</h3>
	<div class="inside">

	<div class="uploader">
		<h4>Step 1:</h4>
		<input type="hidden" name="upload_image" id="upload_image" />
		<label for="upload_image_button">
            Upload Wallpapers: <input type="button" class="upload_image_button button-secondary" name="upload_image_button" id="upload_image_button" value="Click To Upload" />
            <img src="<?php echo PX_ASSETS_URL . '/css/images/question_blue.png'; ?>" title="Start by uploading wallpaper images."/>
        </label>
	</div>

	<div class="adder">
	<h4>Step 2:</h4>
	<div id="attach_stat"></div>
	<table>
	<tr>
		<td>
			<label>Select Category:</label>
		</td>
		<td>
			<label for="wallpaper_category">
				<?php $categories = get_categories('hide_empty=0&orderby=name'); ?>
				<select name="wallpaper_category" id="wallpaper_category">
				<?php foreach ($categories as $category_item) { ?>
					<option value="<?php echo $category_item->cat_ID; ?>"><?php echo $category_item->cat_name; ?></option>
				<?php } ?>
				</select>
                <img src="<?php echo PX_ASSETS_URL . '/css/images/question_blue.png'; ?>" title="Select the category under which you want to post the wallpapers"/>
			</label>
		</td>
	</tr>
	<tr>
		<td>
			<label>Post Content:</label>
		</td>
		<td>
			<label for="txtContent">
                <textarea  name="txtContent" rows="4" cols="50"><?php echo $pixatoSettings[defaultContent]; ?></textarea>
                <img src="<?php echo PX_ASSETS_URL . '/css/images/question_blue.png'; ?>" title="Enter your desired content for the posts created. {title} - will be replaced by image title."/>
            </label>
		</td>
	</tr>
	<tr>
		<td>
			<label>Enter Keyword(s):</label>
		</td>
		<td>
			<label for="txtKeywords">
                <textarea  name="txtKeywords" rows="4" cols="50"></textarea>
                <img src="<?php echo PX_ASSETS_URL . '/css/images/question_blue.png'; ?>" title="Enter keywords that will be inserted in your post tags."/>
            </label>
		</td>
	</tr>
	<tr>
		<td>
			<label>Number of Tags:</label>
		</td>
		<td>
			<label for="txtNumOfKeywords">
                <input type="text" name="txtNumOfKeywords" value="<?php echo $pixatoSettings[defaultNumOfTags]; ?>" size="5"/>
                <img src="<?php echo PX_ASSETS_URL . '/css/images/question_blue.png'; ?>" title="Enter the number of tags to be generated per post."/>
            </label>
		</td>
	</tr>
	<tr>
		<td>
			<label>Enable Tag Modifiers:</label>
		</td>
		<td>
			<label for="enableTagModifiers">
                <input type="checkbox" name="enableTagModifiers" value="1" checked="checked" /> <img src="<?php echo plugins_url('assets/css/images/question_blue.png', __FILE__); ?>" title="Check this if you want to enable tag modifiers"/>
            </label>
		</td>
	</tr>
	<tr>
		<td>
			<label>Tag Modifiers:</label>
		</td>
		<td>
			<label for="txtTagModifiers">
                <textarea  name="txtTagModifiers" rows="4" cols="50"><?php echo $pixatoSettings[defaultTagModifiers]; ?></textarea>
                <img src="<?php echo PX_ASSETS_URL . '/css/images/question_blue.png'; ?>" title="Enter tag modifiers that will be comibined with the keywords to generate random tags."/>
            </label>
		</td>
	</tr>
	<tr>
		<td>
			<label>Post Date:</label>
		</td>
		<td>
			<label for="txtPostDateFrom">
                <input type="text" class="txtDatePick" id="txtDateFrom" name="txtDateFrom" value="<?php echo date('d-m-Y'); ?>" size="12" /> To <input type="text" class="txtDatePick" id="txtDateTo" name="txtDateTo" value="<?php echo date('d-m-Y'); ?>" size="12" /> (Format: dd-mm-yyyy)
                <img src="<?php echo PX_ASSETS_URL . '/css/images/question_blue.png'; ?>" title="Select date range for the posts."/>
                </label>
		</td>
	</tr>
	<tr>
		<td></td>
		<td>
			<input type="hidden" name="attach_ids" id="attach_ids" />
			<input type="hidden" name="addWallpapers" value="Y" />
			<label for="publishWallpapers"><input type="submit" class="button-primary" name="publishWallpapers" value="Publish Wallpapers" /></label>
		</td>
	</tr>
	</table>
	</div>
	
	</div>
	</div> <!--postbox-->

	</div> <!--meta-box-sortabless-->
	</div> <!--has-sidebar-content-->
	</div> <!--has-sidebar sm-padded-->

</div> <!--meta-box-sortabless-->
</div> <!--metabox-holder has-right-sidebar-->

</form>

</div>

<?php
}

if( $_POST['addWallpapers'] == 'Y' ) {

	$attachIds = explode(",", $_POST['attach_ids']);

    // Prepare Post Tags
	$modifierArr = explode (",", $_POST['txtTagModifiers']);
	//print_r($modifierArr);
	$fulltagsArr = array();

	// Prepare Tags
	if( !empty($_POST['txtKeywords']) or $_POST['txtKeywords'] != '' ) {
		$keywordsArr = explode (",", $_POST['txtKeywords']);
		//print_r($keywordsArr);

        if( $_POST['enableTagModifiers'] == 1 ) {
            for( $i=0; $i<count($keywordsArr); $i++ ) {
                for( $j=0; $j<count($modifierArr); $j++ ) {
				    $fulltagsArr[] = $keywordsArr[$i] . ' ' . $modifierArr[$j];
                }
            }
		}
        else {
            $fulltagsArr = $keywordsArr;
        }
	}
	else {
		$fulltagsArr = explode (",", $_POST['txtTagModifiers']);
	}

	//print_r($fulltagsArr);
	shuffle($fulltagsArr);

	// Slice array to number of tags
	$totalTags = ( $_POST['txtNumOfKeywords'] == 0 ? 3 : $_POST['txtNumOfKeywords'] );
	if( count($fulltagsArr) > $totalTags ) {
		$fulltagsArr = array_slice($fulltagsArr, 0, $totalTags);
	}

	if( !empty($_POST['txtContent']) ) {
		$strContent = $_POST['txtContent'];
	}
	else $strContent = '';

    // Prepare post dates
    $postdate_from = strtotime($_POST['txtDateFrom']);
    $postdate_to = strtotime($_POST['txtDateTo']);


	// Add and Publish posts
	for( $i=0; $i<count($attachIds); $i++ ) {

    	$attachment = get_post($attachIds[$i]);

		// Prepare Post Title
		$StrTitle = str_replace("_", " ", $attachment->post_title);
		$StrTitle = str_replace("-", " ", $StrTitle);
		$StrTitle = ucwords(strtolower($StrTitle));

		// Prepare Post Content
		$strContent = str_replace("{title}", $StrTitle, $strContent);

		// Set Post Time
		$postdate = mt_rand($postdate_from, $postdate_to);
		$postdate = date("Y-m-d H:i:s", $postdate);

	    $postData = array(
    	    'post_title' 	=> $StrTitle,
	        'post_type' 	=> 'post',
	        'post_content' 	=> $strContent,
	        'post_category' => array('0' => $_POST['wallpaper_category']),
			'post_author'   => 1,
			'post_date'     => $postdate,
	        'post_status' 	=> 'publish'


    	);
		//print_r($postData);
    	$post_id = wp_insert_post($postData);

		wp_set_post_terms( $post_id, $fulltagsArr);
//		wp_set_post_categories( $pid, $arrayofcategories );

    	// attach media to post
    	wp_update_post(array(
        	'ID' => $attachIds[$i],
			'post_parent' => $post_id,
		));

	    set_post_thumbnail( $post_id, $attachIds[$i] );
	}

	echo '<div class="updated fade"><p><strong>'.$i.' Wallpaper(s) published successfully.</strong></p></div>';

}


/************************************************************************/
/* Enqueue Scripts and Styles */
/************************************************************************/
function px_add_scripts() {

	wp_register_style( 'px-styles', PX_ASSETS_URL . '/css/px_style.css', null, null, "screen" );
	wp_enqueue_style( 'px-styles' );

    wp_register_script( 'px-script', PX_ASSETS_URL . '/js/px_scripts.js', array('jquery'), WPHP_VERSION);
 	wp_enqueue_script('px-script');  

    wp_enqueue_script('jquery-ui-datepicker');

	wp_register_style( 'jquery-ui-styles', PX_ASSETS_URL . '/css/jquery-ui.css', null, null, "screen" );
	wp_enqueue_style( 'jquery-ui-styles' );

}
add_action( 'admin_enqueue_scripts', 'px_add_scripts' );
add_action( 'admin_print_scripts', 'px_add_scripts' );


?>
