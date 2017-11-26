<!-- Selection Template Start -->
<form action="" method="post">
<select name="<?php echo $lang_identificator; ?>" id="lang" onchange="this.form.submit()">
<option value="<?php echo $stl_lang_cir_id; ?>" <?php echo $current_language==$stl_lang_cir_id ? 'selected="selected"' : '' ?>>[lang id="skip"]<?php echo $cirilica_title; ?>[/lang]</option>
<option value="<?php echo $stl_lang_lat_id; ?>" <?php echo $current_language==$stl_lang_lat_id ? 'selected="selected"' : '' ?>><?php echo $latinica_title; ?></option>
</select>
</form>
<!-- Selection Template End -->