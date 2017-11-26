<!-- List Template Start -->
<ul>
<?php
  if ($show_cir) {
?>
<li><a href="<?php echo $cir_url; ?>">[lang id="skip"]<?php echo $cirilica_title; ?>[/lang]</a></li>
<?php
  }
?>
<?php
  if ($show_lat) {
?>
<li><a href="<?php echo $lat_url; ?>"><?php echo $latinica_title; ?></a></li>
<?php
  }
?>
</ul>
<!-- List Template End -->