<?php
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://acrosswp.com
 * @since      1.0.0
 *
 * @package    Media_Features_For_BuddyBoss
 * @subpackage Media_Features_For_BuddyBoss/admin/partials
 */

/**
 * Setup Compatibility integration admin tab class.
 *
 * @since BuddyBoss 1.0.0
 */
class Media_Features_For_BuddyBoss_Admin_Integration_Tab extends BP_Admin_Integration_tab {

	public function initialize() {
		$this->tab_order       = 60;
	}
	

	public function is_active() {
		return true;
	}

	public function pp_is_addon_field_enabled( $default = 1 ) {
		return (bool) get_option( 'media-features-for-buddyboss-pp-field', $default );
	}

	public function cp_is_addon_field_enabled( $default = 1 ) {
		return (bool) get_option( 'media-features-for-buddyboss-cp-field', $default );
	}

	public function vo_is_addon_field_enabled( $default = 1 ) {
		return (bool) get_option( 'media-features-for-buddyboss-vo-field', $default );
	}

	public function pp_settings_callback_field() {
		?>
        <input name="media-features-for-buddyboss-pp-field"
               id="media-features-for-buddyboss-pp-field"
               type="checkbox"
               value="1"
			<?php checked( $this->pp_is_addon_field_enabled() ); ?>
        />
        <label for="media-features-for-buddyboss-pp-field">
			<?php _e( 'Enable this option', 'media-features-for-buddyboss' ); ?>
        </label>
		<?php
	}

	public function cp_settings_callback_field() {
		?>
        <input name="media-features-for-buddyboss-cp-field"
               id="media-features-for-buddyboss-cp-field"
               type="checkbox"
               value="1"
			<?php checked( $this->cp_is_addon_field_enabled() ); ?>
        />
        <label for="media-features-for-buddyboss-cp-field">
			<?php _e( 'Enable this option', 'media-features-for-buddyboss' ); ?>
        </label>
		<?php
	}

	public function vo_settings_callback_field() {
		?>
        <input name="media-features-for-buddyboss-vo-field"
               id="memedia-features-for-buddyboss-vo-field"
               type="checkbox"
               value="1"
			<?php checked( $this->vo_is_addon_field_enabled() ); ?>
        />
        <label for="media-features-for-buddyboss-vo-field">
			<?php _e( 'Enable this option', 'media-features-for-buddyboss' ); ?>
        </label>
		<?php
	}

	public function get_settings_fields() {
		$fields = array();

		$fields['media-features-for-buddyboss_settings_section'] = array(

			'media-features-for-buddyboss-pp-field' => array(
				'title'             => __( 'Allow user to set Profile Picture', 'media-features-for-buddyboss' ),
				'callback'          => array( $this, 'pp_settings_callback_field' ),
				'sanitize_callback' => 'absint',
				'args'              => array(),
			),
			'media-features-for-buddyboss-cp-field' => array(
				'title'             => __( 'Allow user to set Cover Photo', 'media-features-for-buddyboss' ),
				'callback'          => array( $this, 'cp_settings_callback_field' ),
				'sanitize_callback' => 'absint',
				'args'              => array(),
			),
			'media-features-for-buddyboss-vo-field' => array(
				'title'             => __( 'Allow user to View the Original Image', 'media-features-for-buddyboss' ),
				'callback'          => array( $this, 'vo_settings_callback_field' ),
				'sanitize_callback' => 'absint',
				'args'              => array(),
			),
		);

		return $fields;
	}

    /**
     * Add the setting fields for the add-on
     */
    public function get_settings_fields_for_section( $section_id ) {
        // Bail if section is empty
		if ( empty( $section_id ) ) {
			return false;
		}

		$fields = $this->get_settings_fields();
		return isset( $fields[ $section_id ] ) ? $fields[ $section_id ] : false;
    }

    /**
     * Add the setting fields for the add-on
     */
    public function get_settings_sections() {
        return array(
			'media-features-for-buddyboss_settings_section' => array(
				'page'  => 'media-features-for-buddyboss',
				'title' => __( 'Media Features For BuddyBoss Settings', 'media-features-for-buddyboss' ),
			),
		);
    }

	/**
	 * Register setting fields
	 */
	public function register_fields() {

		$sections = $this->get_settings_sections();

		foreach ( (array) $sections as $section_id => $section ) {

			// Only add section and fields if section has fields
			$fields = $this->get_settings_fields_for_section( $section_id );

			if ( empty( $fields ) ) {
				continue;
			}

			$section_title    = ! empty( $section['title'] ) ? $section['title'] : '';
			$section_callback = ! empty( $section['callback'] ) ? $section['callback'] : false;

			// Add the section
			$this->add_section( $section_id, $section_title, $section_callback );

			// Loop through fields for this section
			foreach ( (array) $fields as $field_id => $field ) {

				$field['args'] = isset( $field['args'] ) ? $field['args'] : array();

				if ( ! empty( $field['callback'] ) && ! empty( $field['title'] ) ) {
					$sanitize_callback = isset( $field['sanitize_callback'] ) ? $field['sanitize_callback'] : [];
					$this->add_field( $field_id, $field['title'], $field['callback'], $sanitize_callback, $field['args'] );
				}
			}
		}
	}
}