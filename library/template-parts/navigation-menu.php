<?php
global $is_translucent;

if ( function_exists( 'max_mega_menu_is_enabled' ) && max_mega_menu_is_enabled( 'primary' ) ) {
?>
<nav id="site-navigation" class="main-navigation-mega-menu" style="background: linear-gradient(to bottom, <?php echo( mmm_get_theme_for_location('primary')['container_background_from'] ); ?>, <?php echo( mmm_get_theme_for_location('primary')['container_background_to'] ); ?>);" role="navigation">
	<div id="main-menu" class="main-menu-container">
		<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
	</div>
</nav><!-- #site-navigation -->
<?php 
} else {
?>
<nav id="site-navigation" class="main-navigation border-bottom <?php echo ( $is_translucent ) ? sanitize_html_class( 'translucent' ) : sanitize_html_class( '' ); ?>" role="navigation">
	<span class="header-menu-button" aria-expanded="false"><i class="otb-fa otb-fa-bars"></i></span>
	<div id="main-menu" class="main-menu-container panoramic-mobile-menu-standard-color-scheme">
		<div class="main-menu-close"><i class="otb-fa otb-fa-angle-right"></i><i class="otb-fa otb-fa-angle-left"></i></div>
		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'main-navigation-inner' ) ); ?>
	</div>
</nav><!-- #site-navigation -->
<?php 
}
