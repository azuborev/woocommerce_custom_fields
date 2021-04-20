<?php
/**
 * W4P Theme Options
 *
 * @link http://codex.wordpress.org/Shortcode_API
 *
 * @package WordPress
 * @subpackage W4P-Theme
 */

// Call late so child themes can override.
add_action( 'after_setup_theme', 'w4ptheme_custom_header_setup', 15 );

/**
 * Adds support for the WordPress 'custom-header' theme feature and registers custom headers.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function w4ptheme_custom_header_setup() {

	add_theme_support(
		'custom-header',
		array(
			'default-image'          => '',
			'random-default'         => false,
			'width'                  => 1280,
			'height'                 => 400,
			'flex-width'             => true,
			'flex-height'            => true,
			'header-text'            => false,
			'uploads'                => true,
			'wp-head-callback'       => 'w4ptheme_custom_header_wp_head',
		)
	);

}

/**
 * Callback function for outputting the custom header CSS to `wp_head`.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function w4ptheme_custom_header_wp_head() {

	if ( ! display_header_text() ) {
		return;
	}

	$hex = get_header_textcolor();

	if ( ! $hex ) {
		return;
	}

	$style = "body.custom-header #site-title a { color: #{$hex}; }";

	echo "\n" . '<style type="text/css" id="custom-header-css">' . esc_html( trim( $style ) ) . '</style>' . "\n";
}


/**
 * Class W4PThemeSettingsPage
 */
class W4PThemeSettingsPage {

	/**
	 * Holds Social profiles. You can add more in __construct() function.
	 *
	 * @var array
	 */
	public $social = array();

	/**
	 * Holds the values to be used in the fields callbacks
	 *
	 * @var $options
	 */
	private $options;

	/**
	 * Start up
	 */
	public function __construct() {
		$this->social = array(
			'facebook' => __( 'Facebook', 'w4ptheme' ),
			'twitter' => __( 'Twitter', 'w4ptheme' ),
			'googleplus' => __( 'Google+', 'w4ptheme' ),
			'instagram' => __( 'Instagram', 'w4ptheme' ),
			'linkedin' => __( 'LinkedIn', 'w4ptheme' ),
		);
		add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'page_init' ) );
	}

	/**
	 * Add options page
	 */
	public function add_plugin_page() {
		// This page will be under "Settings".
		add_theme_page(
			__( 'Theme Options', 'w4ptheme' ),
			__( 'Theme Options', 'w4ptheme' ),
			'manage_options',
			'theme_options',
			array( $this, 'create_theme_options_page' )
		);
	}

	/**
	 * Options page callback
	 */
	public function create_theme_options_page() {
		// Set class property.
		$this->options = array( 'w4p_social_profiles' => get_option( 'w4p_social_profiles' ) );

		$this->options['w4p_contacts_address'] = get_option( 'w4p_contacts_address' );
		$this->options['w4p_contacts_phones'] = get_option( 'w4p_contacts_phones' );
		$this->options['w4p_contacts_skype'] = get_option( 'w4p_contacts_skype' );

		$this->options['w4p_copyright'] = get_option( 'w4p_copyright' ); ?>
		<div class="wrap">
			<!-- <h2>My Settings</h2> -->
			<form method="post" action="options.php">
				<?php
				// This prints out all hidden setting fields.
				settings_fields( 'w4p_options_group' );
				do_settings_sections( 'theme_options' );
				submit_button();
				?>
			</form>
		</div>
	<?php
	}

	/**
	 * Register and add settings
	 */
	public function page_init() {
		register_setting(
			'w4p_options_group', /* Option group */
			'w4p_social_profiles', /* Option name */
			array( $this, 'sanitize_profiles' ) /* Sanitize */
		);

		register_setting(
			'w4p_options_group', /* Option group */
			'w4p_contacts_address' /* Option name */
		);
		register_setting(
			'w4p_options_group', /* Option group */
			'w4p_contacts_phones' /* Option name */
		);
		register_setting(
			'w4p_options_group', /* Option group */
			'w4p_contacts_skype' /* Option name */
		);

		register_setting(
			'w4p_options_group', /* Option group */
			'w4p_copyright', /* Option name */
			array( $this, 'sanitize_copyright' ) /* Sanitize */
		);

		add_settings_section(
			'setting_section_id', /* ID */
			__( 'W4P Theme Options', 'w4ptheme' ), /* Title */
			array( $this, 'print_section_info' ), /* Callback */
			'theme_options' /* Page */
		);

		add_settings_field(
			'w4p_social_profiles', /* ID */
			__( 'Social Profiles', 'w4ptheme' ), /* Title */
			array( $this, 'social_profile_callback' ), /* Callback */
			'theme_options', /* Page */
			'setting_section_id' /* Section */
		);

		add_settings_field(
			'w4p_contacts',
			__( 'Contacts', 'w4ptheme' ),
			array( $this, 'contacts_callback' ),
			'theme_options',
			'setting_section_id'
		);

		add_settings_field(
			'w4p_copyright',
			__( 'Copyright', 'w4ptheme' ),
			array( $this, 'copyright_callback' ),
			'theme_options',
			'setting_section_id'
		);
	}

	/**
	 * 	/**
	 * Sanitize each setting field as needed.
	 *
	 * @param array $input Contains all settings fields as array keys.
	 * @return array
	 */
	public function sanitize_profiles( $input ) {
		$new_input = array();
		// Sanitize Social Profiles values.
		foreach ( (array) $input as $name => $element ) {
			foreach ( $element as $index => $value ) {
				if ( ! empty( $value ) ) {
					$new_input[ $name ][ $index + 1 ] = esc_url( $value );
				}
			}
		}

		return $new_input;
	}

	/**
	 * 	/**
	 * Sanitize each setting field as needed.
	 *
	 * @param array $input Contains all settings fields as array keys.
	 * @return array
	 */
	public function sanitize_copyright( $input ) {
		// Sanitize Copyright value.
		if ( isset( $input ) ) {
			$new_input = ! empty( $input ) ? esc_html( $input ) : $this->get_default_copyright();
		} else {
			$new_input = $this->get_default_copyright();
		}

		return $new_input;
	}

	/**
	 * Return default copyright field text.
	 *
	 * @return string
	 */
	public function get_default_copyright() {
		return sprintf( esc_html__( 'Copyright © %d. %s. All Rights Reserved.', 'w4ptheme' ), date( 'Y' ), get_bloginfo( 'name' ) );
	}

	/**
	 * Print the Section text
	 */
	public function print_section_info() {
		esc_html_e( 'Enter your settings below:', 'w4ptheme' );
	}

	/**
	 * Get the settings option array and print one of its values
	 */
	public function social_profile_callback() {
		if ( ! empty( $this->options['w4p_social_profiles'] ) ) {
			foreach ( (array) $this->options['w4p_social_profiles'] as $name => $element ) {
				foreach ( $element as $index => $value ) { ?>
					<div class="w4p-social-profile">
						<label for="w4p_social_profiles_<?php echo esc_attr( $name ); ?>_<?php echo esc_attr( $index + 1 ); ?>" class="w4p-option-label">
							<?php echo esc_html( $this->social[ $name ] ); ?>:
						</label>
						<input
							type="text"
							id="w4p_social_profiles_<?php echo esc_attr( $name ); ?>_<?php echo esc_attr( $index + 1 ); ?>"
							name="w4p_social_profiles[<?php echo esc_attr( $name ); ?>][]"
							class="<?php echo esc_attr( $name ); ?>"
							value="<?php echo esc_attr( $value ); ?>"
							placeholder="<?php esc_attr_e( 'http://', 'w4ptheme' ); ?>"
						/>
						<button class="button w4p-social-remove"><b>&#8211;</b></button>
					</div>
					<?php
				}
			}
		} else { ?>
			<div class="w4p-social-profile">
				<label for="w4p_social_profiles_facebook_1" class="w4p-option-label"><?php echo esc_html( $this->social['facebook'] ); ?>:</label>
				<input
					type="text"
					id="w4p_social_profiles_facebook_1"
					name="w4p_social_profiles[facebook][]"
					class="facebook"
					value=""
					placeholder="<?php esc_attr_e( 'http://', 'w4ptheme' ); ?>"
				/>
				<button class="button w4p-social-remove">-</button>
			</div>
			<?php	} ?>

		<hr>
		<div class="w4p-social-profile-selector-wrapper">
			<label for="social_profile_selector" class="w4p-option-label"><?php esc_attr_e( 'Select profile: ', 'w4ptheme' ); ?></label>
			<select id="social_profile_selector">
				<?php
				foreach ( $this->social as $name => $option ) { ?>
					<option <?php selected( $name, 'facebook' ); ?> value="<?php echo esc_attr( $name ); ?>"><?php echo esc_html( $option ); ?></option>
				<?php } ?>
			</select>
			<button id="social_profile_add" class="button">Add new...</button>
		</div>
		<?php
	}

	/**
	 * Get the settings option array and print one of its values
	 */
	public function contacts_callback() {
		?>
		<div class="w4p-contacts-wrapper">
			<label for="w4p_contacts_address" class="w4p-option-label"><?php esc_html_e( 'Address:', 'w4ptheme' ); ?></label>
			<input
				type="text"
				id="w4p_contacts_address"
				name="w4p_contacts_address"
				value="<?php echo ! empty( $this->options['w4p_contacts_address'] ) ? esc_attr( $this->options['w4p_contacts_address'] ) : '' ?>"
				placeholder="<?php esc_html_e( 'St George St, St Augustine, FL 32084, USA', 'w4ptheme' ); ?>"
			/>
			<hr>
			<label for="w4p_contacts_phones" class="w4p-option-label"><?php esc_html_e( 'Telephones:', 'w4ptheme' ); ?></label>
			<input
				type="text"
				id="w4p_contacts_phones"
				name="w4p_contacts_phones"
				value="<?php echo ! empty( $this->options['w4p_contacts_phones'] ) ? esc_attr( $this->options['w4p_contacts_phones'] ) : '' ?>"
				placeholder="<?php esc_html_e( '+38 (123) 123-456-7, +38 (222) 765-432-1', 'w4ptheme' ); ?>"
			/>
			<hr>
			<label for="w4p_contacts_skype" class="w4p-option-label"><?php esc_html_e( 'Skype:', 'w4ptheme' ); ?></label>
			<input
				type="text"
				id="w4p_contacts_skype"
				name="w4p_contacts_skype"
				value="<?php echo ! empty( $this->options['w4p_contacts_skype'] ) ? esc_attr( $this->options['w4p_contacts_skype'] ) : '' ?>"
				placeholder="<?php esc_html_e( 'Skype ID', 'w4ptheme' ); ?>"
			/>
		</div>
	<?php }


	/**
	 * Get the settings option array and print one of its values
	 */
	public function copyright_callback() {
		?>
		<div class="w4p-copyright-wrapper">
			<label for="w4p_copyright" class="w4p-option-label"><?php esc_html_e( 'Copyright:', 'w4ptheme' ); ?></label>
			<input
				type="text"
				id="w4p_copyright"
				name="w4p_copyright"
				value="<?php echo ! empty( $this->options['w4p_copyright'] ) ? esc_attr( $this->options['w4p_copyright'] ) : '' ?>"
				placeholder="<?php echo esc_attr( $this->get_default_copyright() ); ?>"
			/>
		</div>
	<?php }
}

if ( is_admin() ) {
	$settings_page = new W4PThemeSettingsPage();
}

function load_option_page_style() {
	wp_register_script( 'w4ptheme-options-script', get_template_directory_uri() . '/inc/js/theme_options.js', array( 'jquery' ), '1.0.0', true );
	wp_register_style( 'w4ptheme-options-style', get_template_directory_uri() . '/inc/css/theme_options.css' );
	wp_enqueue_script( 'w4ptheme-options-script' );
	wp_enqueue_style( 'w4ptheme-options-style' );
}

add_action( 'admin_enqueue_scripts', 'load_option_page_style' );