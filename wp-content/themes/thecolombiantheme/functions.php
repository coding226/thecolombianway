<?php
// Author: Andrei Popa 
// Website: https://www.freelancer.com/u/apopa

function theme_enqueue_styles() {
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'avada-stylesheet' ) );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function theme_enqueue_scripts() {
    wp_register_script('custom-js', get_stylesheet_directory_uri() . '/js/custom.min.js', array( 'jquery' ), '1.0', true);
	wp_enqueue_script('custom-js');

	if (!is_front_page() && !is_home()) {
		wp_register_script('autoscroll-js', get_stylesheet_directory_uri() . '/js/autoscroll.js', array( 'jquery' ), '1.0', true);
		wp_enqueue_script('autoscroll-js');
	}
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');

function avada_lang_setup() {
	$lang = get_stylesheet_directory() . '/languages';
	load_child_theme_textdomain( 'Avada', $lang );
}
add_action( 'after_setup_theme', 'avada_lang_setup' );

//override main menu method
function avada_main_menu( $flyout_menu = false ) {
	$menu_class = 'fusion-menu';
	$main_menu_args = [
		'theme_location' => 'main_navigation',
		'depth'          => 5,
		'menu_class'     => $menu_class,
		'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'fallback_cb'    => 'Avada_Nav_Walker::fallback',
		'walker'         => new Avada_Nav_Walker(),
		'container'      => false,
		'item_spacing'   => 'discard',
		'echo'           => false,
	];
	if ( $flyout_menu ) {
		$menu_class .= ' tcw-menu';
		$flyout_menu_args = apply_filters(
			'fusion_flyout_menu_args',
			[
				'depth'     => 2,
				'container' => false,
				'menu_class' => $menu_class
			]
		);

		$main_menu_args = wp_parse_args( $flyout_menu_args, $main_menu_args );

		$main_menu = wp_nav_menu( $main_menu_args );

		if ( has_nav_menu( 'sticky_navigation' ) ) {
			$sticky_menu_args = [
				'theme_location' => 'sticky_navigation',
				'menu_id'        => 'menu-main-menu-1',
				'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				'walker'         => new Avada_Nav_Walker(),
				'item_spacing'   => 'discard',
			];
			$sticky_menu_args = wp_parse_args( $sticky_menu_args, $main_menu_args );
			$main_menu       .= wp_nav_menu( $sticky_menu_args );
		}

		return $main_menu;

	}
}

function wpcf7_generate_rand_number( $wpcf7_data ) {
	$properties = $wpcf7_data->get_properties();
	$shortcode = '[rand-generator]';
	$mail = $properties['mail']['subject'];
	$mail_2 = $properties['mail_2']['body'];
	if( preg_match( "/{$shortcode}/", $mail ) || preg_match( "/[{$shortcode}]/", $mail_2 ) ) {
		$option = 'wpcf7sg_' . $wpcf7_data->id();
		$rand_num = mt_rand(0000000,9999999);
		$sequence_number = (int)get_option( $option ) + 1;
		update_option( $option, $sequence_number );
		$uniq_num = $sequence_number.$rand_num;
		
		$properties['mail']['subject'] = str_replace( $shortcode, $uniq_num, $mail );
		$properties['mail_2']['body'] = str_replace( $shortcode, $uniq_num, $mail_2 );
		
		$wpcf7_data->set_properties( $properties );
	}
}
add_action( 'wpcf7_before_send_mail', 'wpcf7_generate_rand_number' );


function custom_full_width_featured_image() {
	$display_full_featured_image = False;
	$hero_featured = '';
	if ( ! is_search() ) {
		if ( get_field('display') &&  has_post_thumbnail()) {
			$display_full_featured_image = True;
		}
		$title = get_the_title();
		$subtitle = get_field('subtitle');
		$featured_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
	} elseif ( is_search() ) {	
		$display_full_featured_image = get_field('activate_full_featured_image', 'option');
		$title = get_field('title', 'option');
		$subtitle = get_field('subtitle', 'option');
		$featured_image = get_field('image', 'option');
		$featured_image_url = esc_url($featured_image['url']);
	}
		$hero_featured .= <<<HTML
<div id="loaderContainer">
	<div class="loader"></div>
</div>
<section class="heroFeatured" style="background-image: url(&quot;{$featured_image_url}&quot;);">
	<div class="heroInner">
		<div class="heroCaptions">
			<div class="featuredHeading">
				<div class="textWrap">
					<h1 class="featuredTitle">{$title}</h1>
				</div>
			</div>
HTML;
		if ($subtitle):
		$hero_featured .= <<<HTML
			<div class="featuredDescription">
				<div class="textWrap">
					<div class="featuredSubtitle">{$subtitle}</div>
				</div>
			</div>
HTML;
		endif;
		$hero_featured .= <<<HTML
		</div>
	</div>
	<a class="downIndicator" href="#main"></a>
</section>
HTML;

	if ( $display_full_featured_image && ! is_home() && ! is_front_page() && ! is_archive() ) {
		echo $hero_featured;
	}
}
add_action( 'avada_after_header_wrapper', 'custom_full_width_featured_image' );

function add_style_select_buttons( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
// Register our callback to the appropriate filter
add_filter( 'mce_buttons_2', 'add_style_select_buttons' );


// Callback function to filter the MCE settings
function my_mce_before_init_insert_formats( $init_array ) {  
	// Define the style_formats array
	$style_formats = array(  
		// Each array child is a format with it's own settings
		array(  
			'title' => 'Parrafo principal',  
			'block' => 'span',  
			'classes' => 'parrafo-principal',
			'wrapper' => true,
			
		),
	);  
	// Insert the array, JSON ENCODED, into 'style_formats'
	$init_array['style_formats'] = wp_json_encode( $style_formats );  
	
	return $init_array;  
  
} 
// Attach callback to 'tiny_mce_before_init' 
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' );  


function my_theme_add_editor_styles() {
    add_editor_style( 'css/custom-editor-style.css' );
}
add_action( 'init', 'my_theme_add_editor_styles' );

// Register strings for translations 
if (function_exists('pll_register_string')) {
	add_action('init', function() {
			pll_register_string('tcw-photographs', 'Photographs');
			pll_register_string('tcw-see-also', 'See also');
			//pll_register_string('tcw-loading-results', 'Loading more results');
	});
}

// Add options page 
if ( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' => 'Custom options',
		'menu_title' => 'Custom options',
		'menu_slug' => 'custom_options'
	));
	acf_add_options_sub_page(array(
		'page_title' => 'Search options',
		'menu_title' => 'Search',
		'menu_slug' => 'custom_search_options',
		'parent_slug' => 'custom_options'
	));
}

// Output in debug.log file
if (!function_exists('write_log')) {
    function write_log($log) {
        if (true === WP_DEBUG) {
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true));
            } else {
                error_log($log);
            }
        }
    }
}

function modify_search_filter( $query ) {
	if ( is_search() && $query->is_search ) {
		if ( isset( $_GET ) && ( 2 < count( $_GET ) || ( 2 === count( $_GET ) && ! isset( $_GET['lang'] ) ) ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			return $query;
		}
		//$terms = explode(' ', $query->get('s'));
		//$keywords = implode(',', $terms);
      


		// $tax_query = array(
		// 	'taxonomy' => 'post_tag', 
		// 	'field' => 'slug', 
		// 	'terms' => $terms,
		// 	'operator'=> 'IN' );
		// 	$query->tax_query->queries[] = $tax_query; 
		// 	$query->query_vars['tax_query'] = $query->tax_query->queries;
		
		// $query->tax_query->queries[] = array(
        //         'taxonomy'=>'post_tag',
        //         'field'=>'slug',
		// 		'terms'=>$terms
		// );
		//$query->query_vars['tax_query'] = $query->tax_query->queries;
		//$query->set( 'post_type', $this->get_search_results_post_types() );
		
		$query->set( 'orderby', array( 'post_type' => 'DESC', 'post_title' => 'ASC' ) );
		//write_log($query);

	}
	return $query;
}
add_filter( 'pre_get_posts', 'modify_search_filter', 500);


function my_smart_search( $search, &$wp_query ) {
    global $wpdb;
 
    if ( empty( $search ))
        return $search;
 
    $terms = $wp_query->query_vars[ 's' ];
    $exploded = explode( ' ', $terms );
    if( $exploded === FALSE || count( $exploded ) == 0 )
        $exploded = array( 0 => $terms );
         
	$search = '';
	$searchor  = '';
    foreach( $exploded as $tag ) {
        $search .= " AND (
            (wp_posts.post_title LIKE '%$tag%')
            OR EXISTS
            (
                SELECT * FROM wp_comments
                WHERE comment_post_ID = wp_posts.ID
                    AND comment_content LIKE '%$tag%'
            )
            OR EXISTS
            (
                SELECT * FROM wp_terms
                INNER JOIN wp_term_taxonomy
                    ON wp_term_taxonomy.term_id = wp_terms.term_id
                INNER JOIN wp_term_relationships
                    ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
                WHERE taxonomy = 'post_tag'
                    AND object_id = wp_posts.ID
                    AND wp_terms.name LIKE '%$tag%'
            )
        )";
    }
    return $search;
}
add_filter( 'posts_search', 'my_smart_search', 500, 2 );

class Avada_Nav_Walker extends Walker_Nav_Menu {

	/**
		 * Are we currently rendering a mega menu?
		 *
		 * @access  private
		 * @var string
		 */
		private $menu_megamenu_status = '';

function start_lvl( &$output, $depth = 0, $args = [] ) {

	if ( 0 === $depth && 'enabled' === $this->menu_megamenu_status ) {
		$output .= '{first_level}';
		$output .= '<div class="fusion-megamenu-holder" {megamenu_final_width}><ul role="menu" class="fusion-megamenu{megamenu_border}{megamenu_interior_width}">';
	} elseif ( 2 <= $depth && 'enabled' === $this->menu_megamenu_status ) {
		$output .= '<ul role="menu" class="sub-menu deep-level">';
	} else {
		$output .= '<ul role="menu" class="sub-menu-custom">';
	}

}

}