<?php
/**
 * Template Name: Lead Page
 * This is a general template for lead pages that generate traffic from Social Media.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package OnePress
 */

get_header();

// Contact Form 7 form id for shortcode
$form_id = get_post_meta($post->ID, 'lead_form_id', true);
$shortcode = '[contact-form-7 id="' . $form_id . '" html_id="claim-form" html_class="sidebar-form"]';

?>
<script>console.log('<?php echo $shortcode ?>')</script>

	<div id="content" class="site-content">

		<div class="page-header">
			<div class="container">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</div>
		</div>

		<div id="content-inside" class="container right-sidebar">
			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">

					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'template-parts/content', 'page' ); ?>

						<?php
							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;
						?>

					<?php endwhile; // End of the loop. ?>

				</main><!-- #main -->
			</div><!-- #primary -->

			<div id="secondary" class="widget-area sidebar sidebar-claim" role="complementary">
				<aside class="widget widget_text">
					<h3>Submit your claim information</h3>
					<?php echo do_shortcode( $shortcode ); ?>
				</aside>
			</div><!-- #secondary -->

		</div><!--#content-inside -->
	</div><!-- #content -->

<?php get_footer(); ?>
