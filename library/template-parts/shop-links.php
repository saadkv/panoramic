
<?php
if ( is_user_logged_in() ) {
?>
	<div class="site-header-right-link">
		<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="my-account"><?php esc_html_e('My Account','panoramic'); ?></a>
	</div>
<?php
} else {
?>
	<div class="site-header-right-link">
		<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="my-account"><?php esc_html_e('Sign In / Register','panoramic'); ?></a>
	</div>
<?php
}
?>

<div class="header-cart">
<?php
get_template_part( 'library/template-parts/header-cart-contents' );
?>
</div>
