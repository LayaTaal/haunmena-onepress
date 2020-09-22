<?php
/**
 * Enqueue child styles
 */
function my_theme_enqueue_styles() {

	$parent_style = 'parent-style';

	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/dist/css/core.css', [ $parent_style ],
		filemtime( get_stylesheet_directory() . '/dist/css/core.css' )
	);
}

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function haunmena_widgets_init() {
	register_sidebar( [
		'name'          => esc_html__( 'Personal Injury Sidebar', 'onepress' ),
		'id'            => 'sidebar-injury',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	] );

	register_sidebar( [
		'name'          => esc_html__( 'Insurance Claim Sidebar', 'onepress' ),
		'id'            => 'sidebar-insurance',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	] );

	register_sidebar( [
		'name'          => esc_html__( 'Ryan Haun Sidebar', 'onepress' ),
		'id'            => 'sidebar-ryan-haun',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	] );

	register_sidebar( [
		'name'          => esc_html__( 'Doug Mena Sidebar', 'onepress' ),
		'id'            => 'sidebar-doug-mena',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	] );

	register_sidebar( [
		'name'          => esc_html__( 'Blog Sidebar', 'onepress' ),
		'id'            => 'blog',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	] );

	register_sidebar( [
		'name'          => esc_html__( '3m Sidebar', 'onepress' ),
		'id'            => 'claim',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	] );
}

add_action( 'widgets_init', 'haunmena_widgets_init' );

/*------------------------------------*\
	Helper functions
\*------------------------------------*/

// List all sidebars in a dropdown menu
function sidebar_selectbox( $name = '', $current_value = false ) {
	global $wp_registered_sidebars;

	if ( empty( $wp_registered_sidebars ) ) {
		return;
	}

	$name     = empty( $name ) ? false : ' name="' . esc_attr( $name ) . '"';
	$current  = $current_value ? esc_attr( $current_value ) : false;
	$selected = '';
	?>
    <label>Please select the intake form to use on this page.</label>
    <select<?php echo $name; ?>>
		<?php foreach ( $wp_registered_sidebars as $sidebar ) : ?>
			<?php
			if ( $current ) {
				$selected = selected( $current === $sidebar['id'], true, false );
			} ?>
            <option value="<?php echo $sidebar['id']; ?>"<?php echo $selected; ?>><?php echo $sidebar['name']; ?></option>
		<?php endforeach; ?>
    </select>
	<?php
}

/*------------------------------------*\
	Custom Meta Box for Lead Page
\*------------------------------------*/

function zinnfinity_add_lead_meta() {
	add_meta_box(
		'lead_meta_box',            // Unique ID
		'Shortcode for page form',  // Box title
		'lead_meta_box_html',        // Content callback, must be of type callable
		'page'                        // Post type
	);
}

add_action( 'add_meta_boxes', 'zinnfinity_add_lead_meta' );

function lead_meta_box_html( $post ) {
	$form_title = get_post_meta( $post->ID, 'lead_form_title', true );
	$form_desc  = get_post_meta( $post->ID, 'lead_form_desc', true );
	$form_id    = get_post_meta( $post->ID, 'lead_form_id', true );

	?>
    <div>
        <label for="form_id">Intake form title
            <input type="text" id="form_title" name="form_title" value="<?php echo $form_title ?>"></label>
    </div>
    <div>
        <label for="form_id">A short description of this form
            <input type="text" id="form_desc" name="form_desc" value="<?php echo $form_desc ?>"></label>
    </div>
    <div>
        <label for="form_id">Please enter the Contact Form 7 id of the form to display.
            <input type="number" name="form_id" value="<?php echo $form_id ?>"></label>
    </div>
	<?php
}

function zinnfinity_save_postdata( $post_id ) {
	if ( array_key_exists( 'form_title', $_POST ) ) {
		update_post_meta(
			$post_id,
			'lead_form_title',
			$_POST['form_title']
		);
	}
	if ( array_key_exists( 'form_desc', $_POST ) ) {
		update_post_meta(
			$post_id,
			'lead_form_desc',
			$_POST['form_desc']
		);
	}
	if ( array_key_exists( 'form_id', $_POST ) ) {
		update_post_meta(
			$post_id,
			'lead_form_id',
			$_POST['form_id']
		);
	}
}

add_action( 'save_post', 'zinnfinity_save_postdata' );
