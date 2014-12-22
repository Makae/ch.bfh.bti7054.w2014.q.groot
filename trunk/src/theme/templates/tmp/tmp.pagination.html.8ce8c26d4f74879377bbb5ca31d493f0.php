<div class="pagination-wrapper">
  <ul class="pagination style-<?php if(isset($style)) echo $style;?>">
  <?php if($canPrev) { ?>
    <li class="">
      <a href="<?php if(isset($start['link'])) echo $start['link'];?>"><?php if(isset($start['label'])) echo $start['label'];?></a>
    </li>
    <li>...</li>
  <?php } ?>
  <?php foreach($links as $key => $value) {  $_key1 = $key;  $_value1 = $value;?>
    <li class="<?php if($value['current'] == true) { ?> active <?php } ?>">
      <a href="<?php if(isset($value['link'])) echo $value['link'];?>"><?php if(isset($value['label'])) echo $value['label'];?></a>
    </li>
  <?php }   if(isset($_key)) { $key = $_key1;  unset($_key1);}  if(isset($_value)) { $value = $_value1;  unset($_value1);}?>
  <?php if($canNext) { ?>
    <li>...</li>
    <li class="">
      <a href="<?php if(isset($end['link'])) echo $end['link'];?>"><?php if(isset($end['label'])) echo $end['label'];?></a>
    </li>
  <?php } ?>
  </ul>
</div>