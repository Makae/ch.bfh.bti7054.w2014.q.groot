<?php if(isset($title)) { ?>
  <?php if(isset($title)) echo $title;?>
<?php } ?>
<div class="showcase-wrapper" <?php if(isset($config)) { ?> data-config="<?php if(isset($config)) echo $config;?>" <?php } ?>>
  <?php if($navigation) { ?>
  <div class="nav prev stdanimation1_2 <?php if(isset($prev_hidden) && $prev_hidden == true) { ?> hidden <?php } ?>">
    <span class="arrow_carrot-left arrow"></span>
  </div>
  <?php } ?>
  <ul class="showcase style-<?php if(isset($style)) echo $style;?> row">
  <?php foreach($books as $key => $value) {  $_key1 = $key;  $_value1 = $value;?>
    <li class="col col_3_12">
      <a href="?view=productdetail&id=<?php if(isset($value['isbn'])) echo $value['isbn'];?>" class="">
        <img src="<?php if(isset($value['cover'])) echo $value['cover'];?>" class="cover" />
        <div class="overlay stdanimation1_2">
          <h4><?php if(isset($value['title'])) echo $value['title'];?></h4>
          <div class="author"><?php if(isset($value['author'])) echo $value['author'];?></div>
        </div>
      </a>
    </li>
  <?php }   if(isset($_key)) { $key = $_key1;  unset($_key1);}  if(isset($_value)) { $value = $_value1;  unset($_value1);}?>
  </ul>
  <?php if($navigation) { ?>
  <div class="nav next stdanimation1_2  <?php if(isset($prev_hidden) && $prev_hidden == true) { ?> hidden <?php } ?>">
    <span class="arrow_carrot-right arrow"></span>
  </div>
  <?php } ?>
</div>