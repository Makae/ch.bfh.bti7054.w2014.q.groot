<div id="logo">
  <span class="stdanimation1_4">G</span>
</div>
<form id="search">
  <select name="category">
    <option value="1">Fantasy</option>
    <option value="2">Horror</option>
    <option value="3">Mein kleiner Scheich</option>
  </select>
  <input type="text" name="search_text" id="search_text" />
  <button type="submit" name="search" value="search">Suchen</button>
</form>
<ul class="menu menu-main">
  <?php foreach($main_menu as $key => $value) {  $_key1 = $key;  $_value1 = $value;?>
    <li>
      <a class="stdanimation1_2"><?php if(isset($value)) echo $value;?></a>
    </li>
  <?php }   $key = $_key1;  $value = $_value1;  unset($_key1);  unset($_value1);?>
</ul>