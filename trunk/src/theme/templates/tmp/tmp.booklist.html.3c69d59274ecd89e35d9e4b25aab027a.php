<?php if(isset($title)) { ?>
  <?php if(isset($title)) echo $title;?>
<?php } ?>
<ul class="book-list style-<?php if(isset($style)) echo $style;?>">
<?php foreach($books as $key => $value) {  $_key1 = $key;  $_value1 = $value;?>
  <li class="row">
    <div class="col col_2_12 no-padding">
     <img src="<?php if(isset($value['cover'])) echo $value['cover'];?>" class="cover" />
    </div>
    <div class="col col_10_12">
      <h4><?php if(isset($value['title'])) echo $value['title'];?> - <span class="author"><?php if(isset($value['author'])) echo $value['author'];?></span></h4>
      <p><?php if(isset($value['description'])) echo $value['description'];?></p>
      <a href="?view=productdetail&id=<?php if(isset($value['id'])) echo $value['id'];?>" class="button button-primary clearfix"><?php if(isset($text_details)) echo $text_details;?></a>
    </div>
  </li>
<?php }   if(isset($_key)) { $key = $_key1;  unset($_key1);}  if(isset($_value)) { $value = $_value1;  unset($_value1);}?>
</ul>