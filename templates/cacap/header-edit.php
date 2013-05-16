<?php $h = cacap_html_gen() ?>

	<?php bp_get_template_part( 'cacap/header-top' ) ?>
	<?php bp_get_template_part( 'cacap/bp-profile-fields-edit' ) ?>

<?php foreach ( cacap_user_widget_instances( array( 'context' => 'header', ) ) as $widget_instance ) : ?>
	<div class="cacap-row cacap-widget-edit">
		<?php /* @todo abstract this stuff */ ?>
		<div class="cacap-widget-title">
			<?php $id = 'cacap-edit-' . $field->get_field_id(); ?>
			<?php $h->label( $id, $field->get_field_name() ) ?>
		</div>

		<div class="cacap-widget-content">
			<?php if ( 'textarea' == $field->get_field_type() ) : ?>
				<?php $h->textarea( $id, array( 'id' => $id ), $field->get_value() ) ?>
				<?php $h->textarea_close() ?>
			<?php else : ?>
				<?php $h->input( $field->get_field_type(), 'cacap-edit-' . $field->get_field_id(), $field->get_value(), array( 'id' => $id ) ) ?>
			<?php endif; ?>
		</div>
	</div>
<?php endforeach; ?>
