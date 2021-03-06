<?php

/**
 * The Title widget is read-only, for legacy data
 *
 * Called titlewidget to avoid name clashes
 *
 * It'll only be shown for users who do not have Positions filled in
 */
class CACAP_Widget_Title extends CACAP_Widget {
	public function __construct() {
		parent::init( array(
			'name' => __( 'Title', 'cacap' ),
			'slug' => 'titlewidget',
			'allow_new' => false,
			'allow_edit' => false,
		) );
	}

	/**
	 * Save widget instance for a given user
	 *
	 * Overriding the parent method because we need to save in a field
	 * named differently, to avoid name clashes and validation issues in BP
	 *
	 * @param array $args
	 * @return array See CACAP_Widget_Instance::format_instance() for format
	 */
	public function save_instance_for_user( $args = array() ) {
		$r = wp_parse_args( $args, array(
			'key' => '',
			'user_id' => 0,
			'title' => $this->name,
			'content' => '',
		) );

		if ( ! $r['user_id'] ) {
			return false;
		}

		if ( ! $r['title'] ) {
			$r['title'] = $this->name;
		}

		// Lame - autocreate field if it doesn't exist
		$field_id = xprofile_get_field_id_from_name( 'Title Widget' );
		if ( ! $field_id ) {
			$field_id = xprofile_insert_field( array(
				'field_group_id' => 1,
				'type' => 'textbox',
				'name' => 'Title Widget',
			) );
		}

		if ( xprofile_set_field_data( $field_id, absint( $r['user_id'] ), $r['content'] ) ) {
			return CACAP_Widget_Instance::format_instance( array(
				'user_id' => $r['user_id'],
				'key' => $r['title'],
				'value' => $r['content'],
				'widget_type' => $this->slug,
			) );
		} else {
			// phooey
		}
	}

	public function get_instance_for_user( $args = array() ) {
		$r = wp_parse_args( $args, array(
			'user_id' => 0,
			'key' => null,
		) );

		return xprofile_get_field_data( 'Title Widget', absint( $r['user_id'] ) );
	}


}
