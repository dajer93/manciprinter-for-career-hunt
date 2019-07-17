<?php

get_header();

?>
<style>

html {
  margin: 10px !important;
}

#page-container {
  padding-top: 0!important;
}

#main-header {
  display: none !important;
}

form.orders-container {
  padding: 60px 0;
}

.orders-container {
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.orders-container h1 {
  font-size: 28px;
  text-align: center;
  line-height: 1.5;
  margin-bottom: 10px;
}

.orders-container input {
  width: 80%;
  margin: auto;
  font-size: 24px;
  line-height: 1.5;
  text-align: center;
  padding: .2em .4em;
  border: 2px solid #303030;
}

.orders-container button {
  font-size: 24px;
  margin: 20px auto;
  border: 2px solid #303030;
  background: transparent;
  width: 80%;
  line-height: 1.5;
  padding: .2em .4em;
}

.orders-container .order h2 {
  padding-top: 30px;
}
</style>

<?php
if ( isset($_POST["jam-view-orders-submit"]) && $_POST["jam-view-orders-pincode"] === get_option( "order_management_pincode" ) ) {
  $state = get_option( "order_management_state" );
  $tables = (array)$state;
  ?>
  <div class="orders-container">
    <div class="order">
    <?php foreach($tables as $table) {
      if ( count((array)$table->orders) > 0 ) {
        ?><h2><?php echo $table->name; ?></h2><?php
      }
      foreach($table->orders as $food_id => $quantity) {
        $food = get_post($food_id);
        ?><div><?php echo $quantity. "x " . $food->post_title; ?></div><?php
      }
    } ?>
    </div>
  </div>

  <?php
} else {
  ?>
  <form action="" method="post" class="orders-container">
    <h1>Add meg a pinkódot!</h1>
    <input type="text" name="jam-view-orders-pincode" autofocus>
    <button type="submit" name="jam-view-orders-submit">Login</button>
  </form>
  <?php
}
?>