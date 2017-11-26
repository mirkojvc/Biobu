<!-- One Line Template Start -->
<p>
<?php
  if ($show_cir) {
?>
<a href="<?php echo $cir_url; ?>">[lang id="skip"]<?php echo $cirilica_title; ?>[/lang]</a>
<?php
  }
?>
<?php
  if (!$inactive_script_only) {
?>
<?php echo $oneline_separator; ?>
<?php
  }
?>
<?php
  if ($show_lat) {
?>
<a href="<?php echo $lat_url; ?>"><?php echo $latinica_title; ?></a>
<?php
  }
?>

</p>
<!-- One Line Template End -->