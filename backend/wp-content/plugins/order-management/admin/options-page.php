<div class="jam-order-management-options-page">
  <h1>Rendelésfelvevő beállítások</h1>
  <?php
  if ( isset( $_POST["jam-sumbit-pincode"]) ) {
    update_option( 'order_management_pincode', $_POST["jam-pincode"] );
    ?>
    <div class="notice notice-success is-dismissible">
        <p>Sikeresen mentetted a pinkódot!</p>
    </div>
    <?php
  }
  ?>
  <form action="" method="post" >
    <p>Itt tudod megadni a pinkódot arra az esetre, ha mobilnetről kell megnézned a rendeléseket.</p>
    <div><label for="jam-pincode">Pinkód (Négyjegyű pinkódot adj meg!)</label></div>
    <div>
      <input name="jam-pincode" required maxlength="4" pattern="\d{4}" type="text" value="<?php echo get_option( 'order_management_pincode' ); ?>" >
      <button type="submit" name="jam-sumbit-pincode">Mentés</button>
    </div>
  </form>
</div>