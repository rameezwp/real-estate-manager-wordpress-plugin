<?php
	$first_name = get_user_meta( $author_id, 'first_name', true );
	$last_name = get_user_meta( $author_id, 'last_name', true );
	$tagline = get_user_meta( $author_id, 'rem_user_tagline', true );
?>
<div class="agent-box-card grey">
	<div class="image-content">
		<div class="rem-profile-image">
			<?php do_action( 'rem_agent_picture', $author_id ); ?>
		</div>						
	</div>
	<div class="info-agent">
		<?php if (!is_author()) { ?>
			<span class="name">
				<?php echo rem_wpml_translate($first_name, 'Author', 'first_name_'.$author_id); ?>
				<?php echo rem_wpml_translate($last_name, 'Author', 'last_name_'.$author_id); ?>
			</span>
		<?php } ?>
		<?php if ($tagline != '') { ?>
			<div class="text text-center">
				<?php echo rem_wpml_translate($tagline, 'Author', 'tagline_'.$author_id); ?>
			</div>
		<?php } ?>
		<?php do_action( 'rem_contact_social_icons', $author_id ); ?>
	</div>
</div>