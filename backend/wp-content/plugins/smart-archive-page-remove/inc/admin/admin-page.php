<div class="wrap pp-admin-page-wrapper smart-archive-page-remove">
  <h1>
    <span><?php echo $this->get_plugin_name(); ?></span>
    <nav>
      <?php $this->show_nav_icons( array(
        array( 
          'link'  => 'https://wordpress.org/support/plugin/' . $this->get_plugin_slug() . '/reviews/',
          'title' => __( 'Please rate Plugin', 'smart-archive-page-remove' ),
          'icon'  => 'dashicons-star-filled'
        ),
        array( 
          'link'  => 'https://wordpress.org/plugins/' . $this->get_plugin_slug(),
          'title' => __( 'WordPress.org Plugin Page', 'smart-archive-page-remove' ),
          'icon'  => 'dashicons-wordpress'
        ),
         array( 
          'link'  => 'https://petersplugins.com/docs/' . $this->get_plugin_slug(),
          'title' => __( 'Plugin Doc', 'smart-archive-page-remove' ),
          'icon'  => 'dashicons-book-alt'
        ),
        array( 
          'link'  => 'https://wordpress.org/support/plugin/' . $this->get_plugin_slug(),
          'title' => __( 'Support', 'smart-archive-page-remove' ),
          'icon'  => 'dashicons-editor-help'
        ),
        array( 
          'link'  => 'https://petersplugins.com/',
          'title' => __( 'Authors Website', 'smart-archive-page-remove' ),
          'icon'  => 'dashicons-admin-home'
        ),
        array( 
          'link'  => 'https://www.facebook.com/petersplugins/',
          'title' => __( 'Authors Facebook Page', 'smart-archive-page-remove' ),
          'icon'  => 'dashicons-facebook-alt'
        )
        
      ) ); ?>
    </nav>
  </h1>
    
  <div class="postbox">
    <div class="inside">
              
      <form method="post" action="options.php">
        <?php
          settings_fields( 'smart-archive-page-remove_settings' );
          do_settings_sections( 'smartarchivepageremovesettings' );
          submit_button(); 
        ?>
      </form>
          
    </div>
  </div>
    
</div>