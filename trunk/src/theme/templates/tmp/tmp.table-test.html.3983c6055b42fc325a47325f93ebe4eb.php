<table>
  <?php if(isset($head)) { ?>
  <thead>
    <tr>
      <?php foreach($head['content'] as $key => $value) {  $_key1 = $key;  $_value1 = $value;?>
        <th><?php if(isset($value)) echo $value;?></th>
      <?php }   if(isset($_key)) { $key = $_key1;  unset($_key1);}  if(isset($_value)) { $value = $_value1;  unset($_value1);}?>
    </tr>
  </thead>
  <?php } ?>
  <?php if(isset($body)) { ?>
  <tbody>
    <?php foreach($body['content'] as $key => $value) {  $_key1 = $key;  $_value1 = $value;?>
    <tr>
      <?php foreach($value as $key => $value) {  $_key2 = $key;  $_value2 = $value;?>
        <th><?php if(isset($value)) echo $value;?><?php if(isset($key)) echo $key;?></th>
      <?php }   if(isset($_key)) { $key = $_key1;  unset($_key1);}  if(isset($_value)) { $value = $_value1;  unset($_value1);}?>
    </tr>
    <?php }   if(isset($_key)) { $key = $_key1;  unset($_key1);}  if(isset($_value)) { $value = $_value1;  unset($_value1);}?>
  </tbody>
  <?php } ?>
  <?php if(isset($foot)) { ?>
  <tfoot>
    <tr>
      <?php foreach($foot as $key => $value) {  $_key1 = $key;  $_value1 = $value;?>
        <th><?php if(isset($value['content'])) echo $value['content'];?></th>
      <?php }   if(isset($_key)) { $key = $_key1;  unset($_key1);}  if(isset($_value)) { $value = $_value1;  unset($_value1);}?>
    </tr>
  </tfoot>
  <?php } ?>
</table>