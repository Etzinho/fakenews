<?php get_header(); ?>

	<div id="content">
		<div class="padder">

			<?php do_action( 'bp_before_blog_single_post' ); ?>

			<div class="page" id="blog-single" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php 
					$current_user = wp_get_current_user();
					$user_id = $current_user->ID;
					?>
					<span id="post-data" data-post="<?php the_ID(); ?>" data-user="<?= $user_id ?>"></span>
					<div class="author-box">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), '50' ); ?>
						<p><?php printf( _x( 'by %s', 'Post written by...', 'buddypress' ), str_replace( '<a href=', '<a rel="author" href=', bp_core_get_userlink( $post->post_author ) ) ); ?></p>
					</div>

					<div class="post-content">
						<h2 class="posttitle"><?php the_title(); ?></h2>

						<p class="date">
							<?php printf( __( '%1$s <span>in %2$s</span>', 'buddypress' ), get_the_date(), get_the_category_list( ', ' ) ); ?>
							<span class="post-utility alignright"><?php edit_post_link( __( 'Edit this entry', 'buddypress' ) ); ?></span>
						</p>

						<div class="entry">
							<?php the_content( __( 'Read the rest of this entry &rarr;', 'buddypress' ) ); ?>

							<?php wp_link_pages( array( 'before' => '<div class="page-link"><p>' . __( 'Pages: ', 'buddypress' ), 'after' => '</p></div>', 'next_or_number' => 'number' ) ); ?>
						</div>

						<?php
						$truth = get_post_meta($post->ID, "truth", TRUE);
						$false = get_post_meta($post->ID, "false", TRUE);
						?>

						<div class="alignleft">
							<span class="vote-truth link <?= (is_array($truth) && in_array($user_id, $truth)) ? "voted" : "" ?>">
							<i class="fas <?= (is_array($truth) && in_array($user_id, $truth)) ? "fa-check" : "fa-chevron-up" ?>"></i> 
							<span class="counter"><?= is_array($truth) ? count($truth) : 0 ?></span> Verdadeiro</span>
						</div>
						<div class="alignright">
							<span class="vote-false link <?= (is_array($false) && in_array($user_id, $false)) ? "voted" : "" ?>">
							<i class="fas <?= (is_array($false) && in_array($user_id, $false)) ? "fa-times" : "fa-chevron-up" ?>"></i> 
							<span class="counter"><?= is_array($false) ? count($false) : 0 ?></span> Falso</span>
						</div>
					</div>

				</div>

			<?php comments_template(); ?>

			<?php endwhile; else: ?>

				<p><?php _e( 'Sorry, no posts matched your criteria.', 'buddypress' ); ?></p>

			<?php endif; ?>

		</div>

		<?php do_action( 'bp_after_blog_single_post' ); ?>

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>