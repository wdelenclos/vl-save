<div class="wrap">

  <?php if ( $renamed_file = get_transient( 'authorized-digital-sellers-txt-notice-init-file-renamed' ) ) : ?>

    <div class="notice notice-info is-dismissible">
      <p><?php _e( 'You have an existing ads.txt-file which has been renamed to prevent problems. You might choose to delete it but this is not necessary.', 'authorized-digital-sellers-txt' ); ?></p>
      <p><code><?php printf(__('Location: %1$s', 'authorized-digital-sellers-txt' ), $renamed_file ); ?></code></p>
    </div>
    
    <?php delete_transient( 'authorized-digital-sellers-txt-notice-init-file-renamed' ); ?>

  <?php endif; ?>

  <?php if ( get_transient( 'authorized-digital-sellers-txt-notice-delete-existing-file' ) ) : ?>

    <div class="notice notice-warning is-dismissible">
      <p><?php _e( 'You have an existing ads.txt-file that could not be renamed. Please delete the file in order to make this plugin work.', 'authorized-digital-sellers-txt' ); ?></p>
      <p><code><?php printf(__('Location: %1$s', 'authorized-digital-sellers-txt' ), get_home_path() . 'ads.txt' ); ?></code></p>
    </div>

    <?php delete_transient( 'authorized-digital-sellers-txt-notice-delete-existing-file' ); ?>

  <?php endif; ?>

  <h1><?php _e( 'ADS.txt', 'authorized-digital-sellers-txt' ); ?></h1>

  <div class="authorized-digital-sellers-txt-block">

    <form method="post" action="options.php">

      <h2><?php _e( 'Contents of your ads.txt', 'authorized-digital-sellers-txt' ); ?></h2>

      <?php settings_fields( 'authorized-digital-sellers-txt-settings' ); ?>
      <?php do_settings_sections( 'authorized-digital-sellers-txt-settings' ); ?>

      <textarea class="widefat" name="authorized_digital_sellers_txt" id="authorized_digital_sellers_txt" rows="10"><?php echo esc_attr( $txt_content ); ?></textarea>

      <?php submit_button(); ?>

    </form>

  </div>

  <div class="authorized-digital-sellers-txt-block">
    <h2><?php _e( 'About Authorized Digital Sellers', 'authorized-digital-sellers-txt' ); ?></h2>
    <p><?php _e( 'Authorized Digital Sellers (or ads.txt), is an IAB initiative to improve transparency in programmatic advertising. Publishers can create their own ads.txt files to identify who is authorized to sell their inventory. The files are publicly available and crawlable by buyers, third-party vendors, and exchanges.', 'authorized-digital-sellers-txt' ); ?></p>
    <a href="https://support.google.com/dfp_premium/answer/7441288" class="button"><?php _e( 'Read more', 'authorized-digital-sellers-txt' ); ?></a>
  </div>

  <div class="authorized-digital-sellers-txt-block">
    <h2><?php _e( 'Example', 'authorized-digital-sellers-txt' ); ?></h2>
    <pre><code>google.com, pub-0000000000000000, DIRECT, f08c47fec0942fa0<br>google.com, pub-0000000000000000, RESELLER, f08c47fec0942fa0</code></pre>
    <a href="https://support.google.com/dfp_premium/answer/7441288"><?php _e( '&raquo; More examples', 'authorized-digital-sellers-txt' ); ?></a>
  </div>

</div>
