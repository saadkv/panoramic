<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package panoramic
 */
?>
</div>
<!-- #content -->

<footer id="colophon" class="site-footer" role="contentinfo">
  <div class="site-footer-top">
    <div class="site-container">
      <?php if ( is_active_sidebar( 'footer-top' ) ) : ?>
        <?php dynamic_sidebar( 'Footer Top' ); ?>
      <?php endif; ?>
      <div class="clearboth"></div>
    </div>
  </div>
  <div class="site-footer-widgets">
  <div class="site-container">
  <div class="footer-col-1">
  <?php dynamic_sidebar( 'Footer Column 1' ); ?>
  </div>
  <div class="footer-col-2">
  <?php dynamic_sidebar( 'Footer Column 2' ); ?>
  </div>
  </div>
  </div>
  <div class="site-footer-bottom-bar">
    <div class="site-container">
      <div class="site-footer-bottom-bar-left">
        <?php dynamic_sidebar('Copyright Text'); ?>
      </div>
      <div class="site-footer-bottom-bar-right"> </div>
    </div>
    <div class="clearboth"></div>
  </div>
</footer>
<!-- #colophon -->
<div class="right-fixed">	<?php dynamic_sidebar( 'Right Fixed' ); ?></div><div class="left-fixed">	<?php dynamic_sidebar( 'Left Fixed' ); ?></div>
<?php wp_footer(); ?>
</body></html>