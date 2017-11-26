<?php

if( ! empty ($_POST['Submit']) ) {
?>
<div class="updated"><p><strong><?php _e('Options saved.', 'srbtranslatin'); ?></strong></p></div>
<?php
}

    // Now display the options editing screen

    echo '<div class="wrap">';

    // header

    echo "<h2>" . __( 'SrbTransLat Plugin Options', 'srbtranslatin') . "</h2>";

    // options form
    
    ?>

<form name="form1" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
<table class="form-table">

<tr>
<th scope="row"><?php _e("Script identificator:", 'srbtranslatin'); ?></th>
<td><input name="<?php echo $stl_lang_identificator_data_field_name; ?>" type="text" value="<?php echo $stl_lang_identificator_opt_val; ?>"?><br />
<?php echo __('Set what identificator for script selection will be used in urls.', 'srbtranslatin'); ?>
<?php
	if ( $stl_wpml_plugin_active && ($stl_lang_identificator_opt_val == 'lang') ) {
?>
<br /><span style="color:red"><?php echo __("WARNING! You have WPML installed! Using 'lang' for url identificator for SrbTranslating will create conflicts with WMPL! Change identificator!", 'srbtranslatin'); ?></span>
<?php
	}
?>
</td>
</tr>

<!--
<tr>
<th scope="row"><?php _e("Cyrillic Identificator Value:", 'srbtranslatin'); ?></th>
<td><input name="<?php echo $stl_lang_cir_id_data_field_name; ?>" type="text" value="<?php echo $stl_lang_cir_id_opt_val; ?>"?><br />
<?php echo __('Set what value should be used for Cyrillic script identificator in urls.', 'srbtranslatin'); ?>
</td>
</tr>

<tr>
<th scope="row"><?php _e("Latin Identificator Value:", 'srbtranslatin'); ?></th>
<td><input name="<?php echo $stl_lang_lat_id_data_field_name; ?>" type="text" value="<?php echo $stl_lang_lat_id_opt_val; ?>"?><br />
<?php echo __('Set what value should be used for Latin script identificator in urls.', 'srbtranslatin'); ?>
</td>
</tr>
-->

<tr>
<th scope="row"><?php _e("Default script:", 'srbtranslatin'); ?></th>
<td>
<select name="<?php echo $stl_default_language_data_field_name; ?>">
<option value="<?php echo $stl_lang_cir_id_opt_val; ?>" <?php echo $stl_default_language_opt_val==$stl_lang_cir_id_opt_val ? 'selected="selected"' : '' ?>><?php echo __('Cyrillic', 'srbtranslatin'); ?></option>
<option value="<?php echo $stl_lang_lat_id_opt_val; ?>" <?php echo $stl_default_language_opt_val==$stl_lang_lat_id_opt_val ? 'selected="selected"' : '' ?>><?php echo __('Latin', 'srbtranslatin'); ?></option>
<!--<option value="ifcir" <?php echo $stl_default_language_opt_val=='ifcir' ? 'selected="selected"' : '' ?>><?php echo __("Cyrillic, if visitor's browser accepts it", 'srbtranslatin') ?></option>-->

</select>
<br /><?php _e("Set script that would be used as default, if user do not make script choice", 'srbtranslatin'); ?></td>
</tr>

<tr>
<th scope="row"><?php _e("Use cookie:", 'srbtranslatin'); ?></th>
<td><input name="<?php echo $stl_use_cookie_data_field_name; ?>" type="checkbox" <?php echo $stl_use_cookie_val==1 ? 'checked="checked"' : '' ?>> <?php _e("use cookie", 'srbtranslatin'); ?><br />
<?php echo __('Check to make blog remember users last script selection to cookie.', 'srbtranslatin'); ?>
</td>
</tr>

<tr>
<th scope="row"><?php _e("File name language delimiter:", 'srbtranslatin'); ?></th>
<td><input name="<?php echo $stl_file_lang_delimiter_data_field_name; ?>" type="text" value="<?php echo $stl_file_lang_delimiter_opt_val ?>"><br />
<?php echo __("Delimiter to be used in file name to identify language used in file.", 'srbtranslatin'); ?>
</td>
</tr>

<tr>
<th scope="row"><?php _e("Permalink options:", 'srbtranslatin'); ?></th>
<td><input name="<?php echo $stl_transliterate_title_data_field_name; ?>" type="checkbox" <?php echo $stl_transliterate_title_opt_val==1 ? 'checked="checked"' : '' ?>> <?php _e("transliterate title to permalink", 'srbtranslatin'); ?><br />
<?php echo __('Check to make permalinks in Latin alphabet regarding Serbian language.', 'srbtranslatin'); ?>
</td>
</tr>


<tr>
<th scope="row"><?php _e("Sanitizing file names:", 'srbtranslatin'); ?></th>
<td><input name="<?php echo $stl_sanitize_file_names_data_field_name; ?>" type="checkbox" <?php echo $stl_sanitize_file_names_opt_val==1 ? 'checked="checked"' : '' ?>> <?php _e("Remove Cyrillic characters from file name on file upload", 'srbtranslatin'); ?><br />
<?php echo __('Check to remove Cyrillic characters from file name on file upload.', 'srbtranslatin'); ?>
</td>
</tr>

<tr>
<th scope="row"><?php _e("Use Russian Transliteration:", 'srbtranslatin'); ?></th>
<td><input name="<?php echo $stl_use_russian_data_field_name; ?>" type="checkbox" <?php echo $stl_use_russian_opt_val==1 ? 'checked="checked"' : '' ?>> <?php _e('Use Russian transliteration table instead of Serbian.', 'srbtranslatin'); ?><br />
</td>
</tr>


</table>
<hr />

<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options', 'srbtranslatin') ?>" />
</p>

</form>
<?php show_in_footer(); ?>
</div>