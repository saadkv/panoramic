<?php
/**
 * Template Name: Left Sidebar
 *
 */
get_header(); ?>
<?php if ( ! is_front_page() ) : ?>
<?php if ( function_exists( 'bcn_display' ) ) : ?>

<div class="breadcrumbs">
  <?php bcn_display(); ?>
</div>
<?php endif; ?>
<?php endif; ?>
<div class="inner-page-banner">
  <div class="page-banner-content">
    <div class="banner-heading">
      <?php the_title(); ?>
    </div>
    <div class="banner-sub-heading">
      <?php the_field('subtitle'); ?>
    </div>
  </div>
</div>
<?php get_sidebar(); ?>
<div id="primary" class="content-area <?php echo !is_active_sidebar( 'sidebar-1' ) ? 'full-width' : ''; ?>">
  <main id="main" class="site-main" role="main">
    <?php get_template_part( 'library/template-parts/page-title' ); ?>
    <?php while ( have_posts() ) : the_post(); ?>
    <?php get_template_part( 'library/template-parts/content', 'page' ); ?>
    <?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>
    <?php endwhile; // end of the loop. ?>
  </main>
  <!-- #main --> 
</div>
<!-- #primary -->

<?php get_footer(); ?>
