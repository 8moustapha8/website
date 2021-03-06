<?php
/**
 * Title: Footer template.
 *
 * Description: Defines footer content.
 *
 * Please do not edit this file. This file is part of the Cyber Chimps Framework and all modifications
 * should be made in a child theme.
 *
 * @category Cyber Chimps Framework
 * @package  Framework
 * @since    1.0
 * @author   CyberChimps
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://www.cyberchimps.com/
 */ ?>
 
</div><!-- wrapper -->
</div><!-- container -->

<section class="full-width-container footer-full-width">
	<div class="container">
		<div class="container-fluid">
<?php
if (cyberchimps_get_option('footer_show_toggle') == '1') { 
	
do_action('cyberchimps_before_footer_widgets'); ?>

<div id="footer-widgets" class="row-fluid">
  <div id="footer-widget-container" class="span12">
  <div class="row-fluid">
    <?php if ( !dynamic_sidebar('cyberchimps-footer-widgets')) : ?>
      
      <aside class="widget-container span3">
        <h3 class="widget-title"><?php _e('Pages', 'cyberchimps' ); ?></h3>
        <ul>
            <?php wp_list_pages('title_li=' ); ?>
          </ul>
        </aside>
      
      <aside class="widget-container span3">
          <h3 class="widget-title"><?php _e( 'Archives', 'cyberchimps' ); ?></h3>
          <ul>
            <?php wp_get_archives('type=monthly'); ?>
          </ul>
        </aside>
          
      <aside class="widget-container span3">
        <h3 class="widget-title"><?php _e('Categories', 'cyberchimps' ); ?></h3>
        <ul>
          <?php wp_list_categories('show_count=1&title_li='); ?>
        </ul>
          </aside>
          
          <aside class="widget-container span3">
            <h3 class="widget-title"><?php _e('WordPress', 'cyberchimps' ); ?></h3>
            <ul>
              <?php wp_register(); ?>
              <li><?php wp_loginout(); ?></li>
              <li><a href="<?php echo esc_url( 'http://wordpress.org/' ); ?>" target="_blank" title="<?php esc_attr_e('Powered by WordPress, state-of-the-art semantic personal publishing platform.', 'cyberchimps'); ?>"> <?php _e('WordPress', 'cyberchimps' ); ?></a></li>
              <?php wp_meta(); ?>
          </ul>
      </aside>
      
    <?php endif; ?>
    </div><!-- .row-fluid -->
  </div><!-- #footer-widget-container -->
</div><!-- #footer-widgets .row-fluid  -->

<?php do_action('cyberchimps_after_footer_widgets'); ?>

<?php } ?>	

</div><!-- #wrapper .container-fluid -->

</div><!-- container -->

<?php do_action('cyberchimps_before_footer_container'); ?>

<section class="full-width-container site-footer-full-width">
<div class="container">
		<div class="container-fluid">
      <footer class="site-footer row-fluid">
      
      	<?php
		do_action('cyberchimps_footer');
		// Adding social icons to the footer
		cyberchimps_header_social_icons();
		?>
      
      </footer><!-- .site-footer .row-fluid -->
    
<?php do_action('cyberchimps_after_footer_container'); ?>

</div><!-- container fluid -->

<?php do_action('cyberchimps_after_wrapper'); ?>

</div><!-- container -->
</section>

<?php wp_footer(); ?>
</body>
</html>