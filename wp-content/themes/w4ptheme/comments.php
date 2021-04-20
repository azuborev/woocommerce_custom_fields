<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage W4P-Theme
 * @since W4P Theme 1.0
 */

if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' === basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
	die( 'Please do not load this page directly. Thanks!' );
}

if ( post_password_required() ) {
	esc_html_e( 'This post is password protected. Enter the password to view comments.', 'w4ptheme' );
	return false;
}
?>

<?php if ( have_comments() ) : ?>

	<h2 id="comments"><?php comments_number( __( 'No Responses', 'w4ptheme' ), __( 'One Response', 'w4ptheme' ), __( '% Responses', 'w4ptheme' ) ); ?></h2>

	<div class="navigation">
		<div class="next-posts"><?php previous_comments_link() ?></div>
		<div class="prev-posts"><?php next_comments_link() ?></div>
	</div>

	<ol class="commentlist">
		<?php wp_list_comments(); ?>
	</ol>

	<div class="navigation">
		<div class="next-posts"><?php previous_comments_link() ?></div>
		<div class="prev-posts"><?php next_comments_link() ?></div>
	</div>

<?php else : /* this is displayed if there are no comments so far */ { ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	<?php else : /* comments are closed */ { ?>
		<p><?php esc_html_e( 'Comments are closed.', 'w4ptheme' ); ?></p>

	<?php } endif; ?>

<?php } endif; ?>

<?php comment_form(); ?>
