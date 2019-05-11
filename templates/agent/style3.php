<figure class="agent-card-3">
  <div class="profile-image">
  <?php do_action( 'rem_agent_picture', $author_id ); ?>
  <figcaption>
    <h3>
      <?php echo get_user_meta( $author_id, 'first_name', true ); ?> 
      <?php echo get_user_meta( $author_id, 'last_name', true ); ?>
    </h3>
    <h5><?php echo get_user_meta( $author_id, 'rem_user_tagline', true ); ?></h5>
    <br>
    <div class="icons">
      <?php
        $user_info = get_userdata($author_id);
        $email = $user_info->user_email;
        $phone = get_user_meta( $author_id, 'rem_mobile_url' , true );
      if ($email != '') { ?>
        <a href="mailto:<?php echo $email; ?>"><i class="fas fa-envelope"></i></a>
      <?php } ?>
      <?php
        global $rem_ob;
        $agent_fields = $rem_ob->get_agent_fields();
              foreach ($agent_fields as $field) {
                  if ((isset($field['display']) && in_array('card', $field['display']) && get_user_meta( $author_id, $field['key'] , true ) != '') || $field['key'] == 'rem_agent_url') {
                      $url = get_user_meta( $author_id, $field['key'] , true );
                      $target = '_blank';
                      if ($url != '' && $url != 'disable') { ?>
                          <a target="<?php echo $target ?>" href="<?php echo $url; ?>"><i class="<?php echo $field['icon_class']; ?>"></i></a>
                      <?php
                      } 
                  }
              } ?>
    </div>
  </figcaption>
</figure>

<style>
.agent-card-3 {
  font-family: 'Lato', Arial, sans-serif;
  position: relative;
  display: inline-block;
  overflow: hidden;
  margin: 8px;
  width: 100%;
  background-color: #ffffff;
  color: #2B2B2B;
  text-align: center;
  font-size: 16px;
  border: 1px solid #eee;
}

.agent-card-3 * {
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}

.agent-card-3 .profile-image {
  padding: 15% 10% 0;
}

.agent-card-3 .profile-image img {
  vertical-align: top;
  position: relative;
  border-radius: 50%;
  max-width: 40% !important;
}

.agent-card-3 figcaption {
  padding: 5% 10% 15%;
}

.agent-card-3 h3 {
  font-family: 'Oswald';
  text-transform: uppercase;
  font-size: 20px;
  font-weight: 400;
  line-height: 24px;
  margin: 3px 0;
}

.agent-card-3 h5 {
  font-weight: 400;
  margin: 0;
  text-transform: uppercase;
  color: #888;
  letter-spacing: 1px;
}

.agent-card-3 .icons i {
  color: #999;
  display: inline-block;
  margin-right: 5px;
  font-size: 1em;
  margin-bottom: 8px;
}

.agent-card-3 .icons i:hover {
  color: #555;
}

.agent-card-3 .icons i a {
  text-decoration: none;
}
</style>