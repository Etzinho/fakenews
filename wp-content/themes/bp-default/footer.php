		</div> <!-- #container -->

		<?php do_action( 'bp_after_container' ); ?>
		<?php do_action( 'bp_before_footer'   ); ?>

		<div id="footer">
			<?php if ( is_active_sidebar( 'first-footer-widget-area' ) || is_active_sidebar( 'second-footer-widget-area' ) || is_active_sidebar( 'third-footer-widget-area' ) || is_active_sidebar( 'fourth-footer-widget-area' ) ) : ?>
				<div id="footer-widgets">
					<?php get_sidebar( 'footer' ); ?>
				</div>
			<?php endif; ?>

			<div id="site-generator" role="contentinfo">
				<?php do_action( 'bp_dtheme_credits' ); ?>
				<p><?php printf( __( 'Proudly powered by <a href="%1$s">WordPress</a> and <a href="%2$s">BuddyPress</a>.', 'buddypress' ), 'http://wordpress.org', 'http://buddypress.org' ); ?></p>
			</div>

			<?php do_action( 'bp_footer' ); ?>

		</div><!-- #footer -->

		<?php do_action( 'bp_after_footer' ); ?>

		<?php wp_footer(); ?>

		<!-- Button trigger modal -->
		<button type="button" class="btn btn-primary" id="newPostBtn" data-toggle="modal" data-target="#createPost"><i class="fas fa-plus"></i>
		</button>

		<!-- Modal -->
		<div class="modal fade" id="createPost" tabindex="-1" role="dialog" aria-labelledby="createPost" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Novo Post</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="new-post-title">Titulo</label>
					<input type="text" class="form-control" id="new-post-title">
				</div>
				<div class="form-group">
				<label for="new-post-content">Conteudo</label>
					<textarea class="form-control" id="new-post-content" rows="3"></textarea>
				</div>
				<?php 
					$current_user = wp_get_current_user();
					$user_id = $current_user->ID;
				?>
				<input type="hidden" id="new-post-author" value="<?= $user_id ?>">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary" id="createPostSave">Publicar</button>
			</div>
			</div>
		</div>
		</div>

	</body>

</html>