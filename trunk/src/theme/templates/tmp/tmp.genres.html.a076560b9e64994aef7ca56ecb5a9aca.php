<h2><?php if(isset($title)) echo $title;?></h2>
<?php foreach($showcases as $key => $value) {  $_key1 = $key;  $_value1 = $value;?>
  <h3><?php if(isset($value['genre'])) echo $value['genre'];?></h3>
  <?php if(isset($value['showcase'])) echo $value['showcase'];?>
<?php }   if(isset($_key)) { $key = $_key1;  unset($_key1);}  if(isset($_value)) { $value = $_value1;  unset($_value1);}?>