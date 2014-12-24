<?php
  class OrderPositionJoin extends Join {
    protected static $JOIN_TYPE = 'LEFT';
    protected static $CONFIG_LEFT = array('Order', 'o', 'id');
    protected static $CONFIG_RIGHT = array('Position', 'p', 'order_id');
  }
?>