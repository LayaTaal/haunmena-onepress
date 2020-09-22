<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package OnePress
 */
 
$avatar = get_avatar( get_the_author_meta( 'email' ), '96' );
$authorEmail = get_the_author_meta( 'email' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( array('list-article', 'clearfix') ); ?>>

<?php if ( $authorEmail != 'info@haunmena.com') { ?>
	<div class="list-article-thumb">
		<?php echo $avatar; ?>
		<h5><?php the_author(); ?></h5>
	</div>
<?php } else { ?>
	<div class="list-article-thumb">
		<?php echo '<img src="http://haunmena.com/wp-content/uploads/2016/08/Logo-Text-Only.png" width="96px">' ?>
	</div>
<?php } ?>

	<div class="list-article-content">
		<div class="list-article-meta">
			<?php the_category(' / '); ?>
		</div>
		<header class="entry-header">
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		</header><!-- .entry-header -->
		<div class="entry-excerpt">
			<?php
				ob_start();
				the_content('');
				$old_content = ob_get_clean();
				$new_content = strip_tags($old_content);
				echo $new_content;
			?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'onepress' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->
	</div>

</article><!-- #post-## -->
