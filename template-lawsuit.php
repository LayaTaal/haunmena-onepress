<?php
/**
 * Template Name: Lawsuit Landing page
 * The template for displaying landing pages for lawsuit conversions
 *
 * This operates like an FAQ page with a right-side sidebar containing an intake form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package OnePress
 */

// Information necessary to display the correct intake form
$form_title = get_post_meta($post->ID, 'lead_form_title', true);
$form_desc = get_post_meta($post->ID, 'lead_form_desc', true);
$form_id = get_post_meta($post->ID, 'lead_form_id', true);
$post_slug = $post->post_name;

// Setup shortcode for form - note that post slug is an important id for analytics
$shortcode = '[contact-form-7 id="' . $form_id . '" html_id="intake_form" html_class="sidebar-form"]';

get_header(); ?>

<script>console.log('<?php echo $post_slug ?>')</script>

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

					<?php endwhile; // End of the loop. ?>

				</main><!-- #main -->
			</div><!-- #primary -->

			<div id="secondary" class="widget-area sidebar sidebar-claim" role="complementary">
				<h3><?php if ($form_title) echo $form_title; ?></h3>
				<p><?php if ($form_desc) echo $form_desc; ?></p>
				<?php echo do_shortcode($shortcode) ?>
			</div><!-- #secondary -->

		</div><!--#content-inside -->
	</div><!-- #content -->

<?php get_footer(); ?>
