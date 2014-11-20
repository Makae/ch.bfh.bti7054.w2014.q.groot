<?php
  class OrderPositionJoin extends Join {
    protected static $JOIN_TYPE = 'LEFT';
    protected static $CONFIG_LEFT = array('order', 'o', 'id', 'Order');
    protected static $CONFIG_RIGHT = array('position', 'p', 'order_id', 'Position');
  }
?>