<div id="sub-menu">
  <ul class="menu">
  <?php foreach($entries as $key => $value) {  $_key1 = $key;  $_value1 = $value;?>
    <li class="<?php if(isset($value['cls'])) echo $value['cls'];?>">
      <span class="stdanimation1_2 <?php if(isset($value['icon'])) echo $value['icon'];?>"></span>
      <a class="stdanimation1_4" href="<?php if(isset($value['link'])) echo $value['link'];?>"><?php if(isset($value['label'])) echo $value['label'];?></a>
    </li>
  <?php }   $key = $_key1;  $value = $_value1;  unset($_key1);  unset($_value1);?>
  </ul>
</div>