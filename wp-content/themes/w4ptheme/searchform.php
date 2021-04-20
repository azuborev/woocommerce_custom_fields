<?php
/**
 * Template for displaying search forms in W4P Theme
 *
 * @package WordPress
 * @subpackage W4P-Theme
 * @since W4P Theme 1.0
 */

?>
<form role="search" method="get" id="searchform"
	  action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div>
		<label for="s"
			   class="screen-reader-text"><?php esc_html_e( 'Search for:', 'w4ptheme' ); ?></label>
		<input type="search" id="s" name="s" value=""/>

		<input type="submit" value="<?php esc_attr_e( 'Search', 'w4ptheme' ); ?>"
			   id="searchsubmit"/>
	</div>
</form>
