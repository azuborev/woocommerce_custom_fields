<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordPress
 * @subpackage W4P-Theme
 * @since W4P Theme 1.0
 */

?>
			<footer id="footer" class="source-org vcard copyright" role="contentinfo">
				<small>
					<?php
					if ( $copyright = get_option( 'w4p_copyright' ) ) {
						echo esc_html( $copyright );
					} else {
						echo sprintf( esc_html__( 'Copyright © %d. %s. All Rights Reserved.', 'w4ptheme' ), date( 'Y' ), get_bloginfo( 'name' ) );
					}
					?>
				</small>
			</footer>

		</div>

		<?php wp_footer(); ?>

	</body>

</html>
