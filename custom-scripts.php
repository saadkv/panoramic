<?php 
/* Register Script */
add_action('wp_enqueue_scripts', 'cf_custom_scripts');
function cf_custom_scripts() {
	// StyleSheets
	wp_enqueue_style('owl.carousel', get_template_directory_uri() . '/css/owl.carousel.min.css', false, '2.2.1' );
	
	// Javascripts
	wp_enqueue_script("jquery-effects-core");
	
	wp_register_script( 'jquery.ulslide', get_template_directory_uri() . '/js/jquery.ulslide.min.js', array( 'jquery' ), '1.5.5', false );
	wp_enqueue_script( 'jquery.ulslide' );
	
	wp_register_script( 'owl.carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array( 'jquery' ), '2.2.1', false );
	wp_enqueue_script( 'owl.carousel' );
}

function cf_has_shortcodes_exists() {
	global $post;
	if( !empty($post) && has_shortcode( $post->post_content, 'cf_clinic_schedule') ) {
		
		// AngularJs 1.5.0
		wp_register_script( 'angularjs', '//ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular.min.js', array( 'jquery' ), '1.5.0', false );
		wp_enqueue_script( 'angularjs' );
	}
}
add_action( 'wp_enqueue_scripts', 'cf_has_shortcodes_exists');

/* News and Events */
add_shortcode('cf_news_display', 'cf_news_shortcode');
function cf_news_shortcode( $atts ) {
	extract(shortcode_atts(array(
			'show' => '10',
			'order' => 'DESC'
	), $atts));
	
	$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	// WP_Query arguments
	$args = array(
		'post_type'              => 'news_and_event',
		'post_status'            => 'publish',
		//'paged'                  => '1',
		'posts_per_page'         => $show,
		'order'                  => $order,
		//'orderby'                => 'date',
	);
	
	// The Query
	$query = new WP_Query( $args );
	
	ob_start();
	echo '<div id="news-container">';
	if ( $query->have_posts() ) {
		
		echo "<h2>News & Events</h2>";
		echo '<ul id="news-slide">';
		while ( $query->have_posts() ) { $query->the_post();
			// do something
			echo sprintf('<li>
							<div class="c4two">
								<div class="box-content">%s</div>
								<div class="box-date">%s</div>
								<div class="box-link read_more"><a href="%s" class="sliding-u-l-r-l">Read more..</a></div>
							</div>
						  </li>',
						  get_the_title(), date('d-m-Y', strtotime(get_post_meta(get_the_ID(), 'date', true))), get_permalink()
				 );
		}
	
		echo '</ul>';
		
	} else {
		// no posts found
	}
	echo '</div>';
	
	// Restore original Post Data
	wp_reset_postdata();
?>
	<script type="text/javascript">
	jQuery(function($) {
		$('#news-container #news-slide').ulslide({
			//width: 433,
			height: 98,
			effect: {
				type: 'carousel', // slide or fade
				axis: 'y',     // x, y
				showCount:4,
				distance: 0    // Distance between frames
			},
			mousewheel: false,
			duration: 1000,
			autoslide: 3000,
			easing: 'easeInOutBack'
		});
	});
	</script>
<?php 
	return ''.ob_get_clean();
}

/* Services Carousel */
add_shortcode('cf_services_display', 'cf_services_shortcode');
function cf_services_shortcode( $atts ) {
	extract(shortcode_atts(array(
			'show' => '10',
			'order' => 'DESC'
	), $atts));
	
	//$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	// WP_Query arguments
	$args = array(
		'post_type'              => 'service_names',
		'post_status'            => 'publish',
		//'paged'                  => '1',
		'posts_per_page'         => $show,
		'order'                  => $order,
		//'orderby'                => 'date',
	);
	
	// The Query
	$query = new WP_Query( $args );
	
	ob_start();
	echo '<div id="service-container">';
	if ( $query->have_posts() ) {
		
		echo '<div class="service-slides owl-carousel owl-carousel-homepage">';
		while ( $query->have_posts() ) { $query->the_post();
			// do something
			$post_id = get_the_ID();
			$external_link = get_post_meta($post_id, 'slide_link', true);
			echo sprintf('<div class="item">
							<a href="%s">
								<div class="box-img">%s</div>
								<div class="box-title">%s</div>
							</a>
						  </div>',
						  ($external_link)? get_permalink($external_link) : get_permalink(), 
						  get_the_post_thumbnail($post_id, array(190,80)), get_the_title()
				 );
		}
	
		echo '</div>';
		
	} else {
		// no posts found
	}
	echo '</div>';
	
	// Restore original Post Data
	wp_reset_postdata();
?>
	<script type="text/javascript">
	jQuery(function($) {
		$('.owl-carousel').owlCarousel({
			items:5,
			loop:true,
			margin:10,
			autoplay:true,
			autoplayHoverPause:true,
			nav:true,
			responsiveClass:true,
			responsive:{
				0:{
					items:1
				},
				600:{
					items:3
				},
				1000:{
					items:5
				}
			}
		})
	});
	</script>
<?php 
	return ''.ob_get_clean();
}

/* Consulting Clinic Schedule */
add_shortcode('cf_clinic_schedule', 'cf_clinic_schedule_shortcode');
function cf_clinic_schedule_shortcode( $atts ) {
	extract(shortcode_atts(array(
			'show' => '-1',
			'order' => 'DESC'
	), $atts));
	
	//$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	// WP_Query arguments
	$args = array(
		'post_type'              => 'clinic_schedule',
		'post_status'            => 'publish',
		//'paged'                  => '1',
		'posts_per_page'         => $show,
		//'order'                  => $order,
		'orderby'                => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
	);
	
	// The Query
	$query = new WP_Query( $args );
	$rows = array();
	
	ob_start();
	echo '<div id="clinic-container" ng-controller="clinicCtrl">';
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) { $query->the_post();
			// do something
			$post_id = get_the_ID();
			$rows[] = array(
						'dr_name' => get_the_title(), 
						'qualification' => get_post_meta($post_id, 'qualification', true), 
						'consultant' => get_post_meta($post_id, 'consultant_of', true), 
						'details' => get_post_meta($post_id, 'consultant_clinics', true), 
						'schedule' => array(
										array( 'day' => 'Monday', 'detail' => get_post_meta($post_id, 'mon_detail', true) ), 
										array( 'day' => 'Tuesday', 'detail' => get_post_meta($post_id, 'tue_detail', true) ), 
										array( 'day' => 'Wednesday', 'detail' => get_post_meta($post_id, 'wed_detail', true) ),
										array( 'day' => 'Thursday', 'detail' => get_post_meta($post_id, 'thu_detail', true) ), 
										array( 'day' => 'Friday', 'detail' => get_post_meta($post_id, 'fri_detail', true) ),
										array( 'day' => 'Saturday', 'detail' => get_post_meta($post_id, 'sat_detail', true) )
						) 
			);
		
		}
	} else {
		// no posts found
	}
?>

	<script type="text/javascript">
    var app = angular.module("thiApp", []);
		app.controller("clinicCtrl", function($scope) {
		$scope.clinics = <?php echo json_encode($rows); ?>;
	});
    </script>
    
    <div class="clinic-search">
    	<input type="text" name="clinic_search" ng-model="clinic_search" placeholder="Search Here" />
    </div>
    
    <div class="clinic-item" ng-if="clinics.length > 0" ng-repeat="item in clinics | filter:clinic_search">
		<div class="clbox-left">
			<span>Consultant Name:</span>
            <span>Qualification:</span>
            <span>Consultant Of:</span>
            <span>Clinic Info:</span>
        </div>
			
		<div class="clbox-right">
            <div class="dr-name">{{item.dr_name}}</div>
            <div class="dr-desc">{{item.qualification}}</div>
            <div class="dr-desc">{{item.consultant}}</div>
            
            <table width="200" border="1" ng-if="item.schedule.length > 0">
              <tr ng-if="sch.detail" ng-repeat="sch in item.schedule">
                <th scope="row">{{sch.day}}</th>
                <td>{{sch.detail}}</td>
              </tr>
            </table>
            
			<div class="dr-detail">{{item.details}}</div>
		</div>
	</div>
<?php 
	echo '</div>';
	// End clinic-container
	
	// Restore original Post Data
	wp_reset_postdata();
	return ''.ob_get_clean();
}