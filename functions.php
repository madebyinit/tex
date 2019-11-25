<?php
/**
 * init_michael functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package init_michael
 */

if ( ! function_exists( 'init_michael_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function init_michael_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on init_michael, use a find and replace
		 * to change 'init_michael' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'init_michael', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'init_michael' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'init_michael_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'init_michael_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function init_michael_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'init_michael_content_width', 640 );
}
add_action( 'after_setup_theme', 'init_michael_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function init_michael_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'init_michael' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'init_michael' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'init_michael_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function enqueue_my_scripts($hook) {
    if ( 'toplevel_page_catalog' != $hook ) {
        return;
    }
    wp_enqueue_script( 'custom_scripts', get_template_directory_uri() . '/js/custom_scripts.js', array(), '111', false );
    $variables = array (
        'ajax_url' => admin_url('admin-ajax.php'),
    );
    echo '<script type="text/javascript">window.wp_data = ' . json_encode($variables) . ';</script>';
}
add_action( 'admin_enqueue_scripts', 'enqueue_my_scripts' );

function init_michael_scripts() {
	wp_enqueue_style( 'init_michael-style', get_stylesheet_uri() );
    wp_enqueue_style ('init_style', get_stylesheet_directory_uri(). '/css/init_style.css');
    wp_enqueue_script( 'init_michael-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'init_michael-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
    wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.4.1.min.js');


    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'init_michael_scripts' );

add_action( 'admin_enqueue_scripts', function(){
    wp_enqueue_style( 'my-wp-admin', get_template_directory_uri() .'/css/wp-admin.css' );
} );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

// ------------------------------------------------------------------

function add_new_taxonomies() {
    register_taxonomy('model',
        array('vehicle'),
        array(
            'hierarchical' => false,
            'labels' => array(
                'name' => 'Car Model',
                'singular_name' => 'Car Model',
                'search_items' =>  'Find Car Model',
                'popular_items' => 'Popular Car Models',
                'all_items' => 'All Car Models',
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => 'Edit Car Model',
                'update_item' => 'Update Car Model',
                'add_new_item' => 'Add New Car Model',
                'new_item_name' => 'New Car Model name',
                'separate_items_with_commas' => 'Separate car models with comas',
                'add_or_remove_items' => 'Add or Delete  Car Model',
                'choose_from_most_used' => 'Choose from most used Car Models',
                'menu_name' => 'Car Model'
            ),
            'public' => true,
            'show_in_nav_menus' => true,
            'show_ui' => true,
            'show_tagcloud' => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'platform',
                'hierarchical' => false

            ),
        )
    );




    register_taxonomy('class',
        array('vehicle'),
        array(
            'hierarchical' => false,
            'labels' => array(
                'name' => 'Car Class',
                'singular_name' => 'Car Class',
                'search_items' =>  'Find Car Class',
                'popular_items' => 'Popular Car Classes',
                'all_items' => 'All Car Classes',
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => 'Edit Car Class',
                'update_item' => 'Update Car Class',
                'add_new_item' => 'Add New Car Class',
                'new_item_name' => 'New Car Class name',
                'separate_items_with_commas' => 'Separate car classes with comas',
                'add_or_remove_items' => 'Add or Delete  Car Class',
                'choose_from_most_used' => 'Choose from most used Car Classes',
                'menu_name' => 'Car Class'
            ),
            'public' => true,
            'show_in_nav_menus' => true,
            'show_ui' => true,
            'show_tagcloud' => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'platform',
                'hierarchical' => false

            ),
        )
    );
}
add_action( 'init', 'add_new_taxonomies', 0 );
register_post_type( 'vehicle’',
    array(
        'labels' => array(
            'name'          => 'Vehicle',
            'singular_name' => 'My Vehicle',
            'new_item' => 'New Vehicle',
            'add_new_item' => 'Add New Vehicle',
            'add_new' => 'Add Vehicle',
        ),
        'public'      => true,
        'has_archive' => true,
        'hierarchical' => true,
        'rewrite' => array( 'slug' => 'vehicle' ),
        'capability_type' => 'post',
        'supports' => array(
            'title',
            'thumbnail'
        ),
        'taxonomies' => array('class','model'),
    )
);
add_action('admin_menu', function(){
    add_menu_page( 'Cars Catalog ',
                   'Cars Catalog',
                   'manage_options',
                   'catalog',
                   'add_my_catalog_setting',
                   '',
                   4
                );
} );
// add thumbnails
function add_my_catalog_setting(){
    require get_template_directory() . '/inc/template-catalog.php';
}
add_theme_support('post-thumbnails');

// =======================
add_action('wp_ajax_myfilter', 'misha_filter_function');
add_action('wp_ajax_nopriv_myfilter', 'misha_filter_function');
function get_vehicles() {
    global $post;
    $carclass_id = $_POST['carclass_id'] ? $_POST['carclass_id'] : '' ; // get POST data
    $carmodel_id = $_POST['carmodel_id'] ? $_POST['carmodel_id'] : '';
    $paged = $_POST['paged'] ? $_POST['paged'] : 1;
    $return_html = '';
    $args = array(
        'post_type' => 'vehicle',
        'paged' => $paged,
    );
    if (!empty($carmodel_id) && !empty($carclass_id)) {
        $args['relation'] = 'AND';
    }
    if (!empty($carclass_id)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'class',
            'terms'    => $carclass_id
        );
    }
    if (!empty($carmodel_id)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'model',
            'terms'    => $carmodel_id
        );
    }
    $vehicle = new WP_Query($args);
    $max_pages = $vehicle->max_num_pages;
    if ($vehicle->have_posts()):
        $return_html .= '<div class="project-block">';
        while ($vehicle->have_posts()): $vehicle->the_post();
            $id = get_the_ID();

            $term_list_model = wp_get_post_terms( $id, 'model', array( 'fields' => 'names' ) );
            $term_list_class = wp_get_post_terms( $id, 'class', array( 'fields' => 'names' ) );
            $thumbnail = get_the_post_thumbnail($post->ID, array(250,250));
            $title = get_the_title();
            $permalink = get_the_permalink();
            $return_html .= '<div class="card">';
            $return_html .= '<a href="' . $permalink . '">';
            $return_html .= $thumbnail;
            $return_html .= '<p class="title-events big-text">' . $title . '</p>';
            $return_html .= '</a>';
            $return_html .= '<p>';
            $return_html .= '<span>';
            $return_html .= 'Model:  ' .  implode("|",$term_list_model);
            $return_html .= '</span>';
            $return_html .= '</br>';
            $return_html .= '<span>';
            $return_html .= 'Class:  '.  implode("|",$term_list_class) ;
            $return_html .= '</span>';
            $return_html .= '</p>';
            $return_html .= '</div>';
        endwhile;
            $return_html .= '</div>';
    endif;
    //TODO -  Hi Teo.  I haven't had time to finish the pagination, but if necessary, I can finish it and make it look like a plugin.  :)
//    if ($paged < $max_pages)
//        $next_page = $paged + 1;
//        $return_html .= '<a id="load-more-events" href="#" class="btn btn-orange" data-page="'. $next_page .'" data-class-id="'. $carclass_id .'" data-model-id="'.$carmodel_id.'">Load More</a>';
//    }
    wp_reset_postdata();
    echo $return_html;
    wp_die();
}


add_action('wp_ajax_get_vehicles', 'get_vehicles');
add_action('wp_ajax_nopriv_get_vehicles', 'get_vehicles');