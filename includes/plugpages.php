<?php

// Plugin Settings Page
function pixato_settings_page() {
?>
<div class="wrap">

<div id="poststuff" class="metabox-holder">
	<img src="<?php echo PX_URL . '/images/pixatopresslite.png'; ?>" title="Pixato Press Lite" />
</div>

<div id="poststuff" class="metabox-holder has-right-sidebar">

    <?php include 'plugsidebar.php'; ?>

    <?php $pixatoSettings = get_option('pixatoSettings'); ?>

	<div class="has-sidebar sm-padded">
	<div id="post-body-content" class="has-sidebar-content">
	<div class="meta-box-sortabless">

	<div class="postbox">
	<h3 class="hndle">Settings</h3>
	<div class="inside">
		<form method="post" action="">
		<table>
        <tr>
            <td>
            <label>Default Post Content:</label>
            </td>
            <td>
            <label for="txtDefaultContent">
                <textarea  name="txtDefaultContent" rows="4" cols="50"><?php echo $pixatoSettings[defaultContent]; ?></textarea>
                <img src="<?php echo PX_ASSETS_URL . '/css/images/question_blue.png'; ?>" title="Enter default content for the wallpaper posts."/>
            </label>
            </td>
        </tr>

        <tr>
            <td>
            <label>Default Number of Tags:</label>
            </td>
            <td>
			<label for="txtDefaultNumOfTags">
                <input type="text" id="txtDefaultNumOfTags" name="txtDefaultNumOfTags" value="<?php echo $pixatoSettings[defaultNumOfTags]; ?>" size="10" />
                <img src="<?php echo PX_ASSETS_URL . '/css/images/question_blue.png'; ?>" title="Enter number of tags for the wallpaper posts."/>
            </label>
            </td>
        </tr>

		<tr>
            <td>
            <label>Default Tag Modifiers:</label>
            </td>
			<td>
            <label for="txtDefaultTagModifiers">
                <textarea  name="txtDefaultTagModifiers" rows="4" cols="50"><?php echo $pixatoSettings[defaultTagModifiers]; ?></textarea>
                <img src="<?php echo PX_ASSETS_URL . '/css/images/question_blue.png'; ?>" title="Enter default tag modifiers for the wallpaper posts."/>
            </label>
            </td>
		</tr>
        
		<tr>
			<td>
			<p class="submit">
			<input type="hidden" name="px_updateSettings" value="Y" />
			<input type="submit" class="button-primary" value="<?php _e('Update Settings') ?>" />
			</p>
			</td>
		</tr>
		</table>
		</form>

	</div>
	</div> <!--postbox-->


	</div> <!--has-sidebar-content-->
	</div> <!--meta-box-sortabless-->
	</div> <!--has-sidebar sm-padded-->

<?php // var_dump($pixatoSettings); ?>

</div> <!--metabox-holder has-right-sidebar-->
</div> <!--wrap-->

<?php
}

if( $_POST['px_updateSettings'] == 'Y' ) {
	
    $pixatoSettings = get_option('pixatoSettings');

	$pixatoSettings = array (
    	'defaultContent' => $_POST['txtDefaultContent'],
    	'defaultNumOfTags' => $_POST['txtDefaultNumOfTags'],
    	'defaultTagModifiers' => $_POST['txtDefaultTagModifiers'],
    );

	update_option('pixatoSettings', $pixatoSettings);

	echo '<div class="updated fade"><p><strong>Settings updated successfully.</strong></p></div>';

} 

// Plugin Data Help Page
function pixato_help_page() {
?>
<div class="wrap">
        <form action="" method="POST">

<div class="metabox-holder">
	<img src="<?php echo PX_URL . '/images/pixatopresslite.png'; ?>" title="Pixato Press Lite" />
</div>

<div id="poststuff" class="metabox-holder has-right-sidebar">

    <?php include 'plugsidebar.php'; ?>

	<div class="has-sidebar sm-padded">
	<div id="post-body-content" class="has-sidebar-content">
	<div class="meta-box-sortabless">

	<div class="postbox">
	<h3 class="hndle">Help</h3>
	<div class="inside">



	</div>
	</div> <!--postbox-->


	</div> <!--meta-box-sortabless-->
	</div> <!--has-sidebar-content-->
	</div> <!--has-sidebar sm-padded-->


</div> <!--metabox-holder has-right-sidebar-->
        </form>
</div> <!--wrap-->

<?php
}
