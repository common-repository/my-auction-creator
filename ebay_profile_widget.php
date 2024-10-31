<?php
class My_Auction_Widget_Profile extends WP_Widget {

	
	function __construct() {
		parent::__construct(
			'my_aucton_widget_for_profile', 
			__( 'Auction For eBay Profile', 'text_domain' ), 
			array( 'description' => __( 'My Auction Creator Widget For eBay Profile', 'text_domain' ), ) 
		);
		
		
	}
	
	public function widget( $args, $instance ) {
		
		$sellerID = $instance['profile_sellerid'];
		if($instance['profile_site']==''){
			$instance['profile_site'] = 0;
		}
		$siteid = $instance['profile_site'];
		if($instance['profile_theme']=='star_grey' || $instance['profile_theme']==''){
			$instance['profile_theme'] = 'stargrey';
		}
		if($instance['profile_theme']=='simple_details' ){
			$instance['profile_theme'] = 'simple';
		}
		$theme = $instance['profile_theme'];
		$profile_newtab = $instance['profile_newtab'];
		if($profile_newtab == "" ){
			$profile_newtab = 0;
		}
		echo $args['before_widget'];
		if ( ! empty( $instance['profile_title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['profile_title'] ). $args['after_title'];
		}
		echo __( "<iframe width='240' height='158' style='border:none' frameborder='0' scrolling='no' src='http://myauctioncreator.com/profile_build/js/SellerID/$sellerID/siteid/$siteid/theme/$theme'></iframe>
        ", 'text_domain' );
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$profile_title = ! empty( $instance['profile_title'] ) ? $instance['profile_title'] : __( 'New title', 'text_domain' );
		$profile_title=sanitize_text_field( $$profile_title );
		
		$profile_sellerid = ! empty( $instance['profile_sellerid'] ) ? $instance['profile_sellerid'] : __( 'Seller ID', 'text_domain' );
		$profile_sellerid=sanitize_text_field( $profile_sellerid );
		
		$profile_site = ! empty( $instance['profile_site'] ) ? $instance['profile_site'] : __( 'eBay Site', 'text_domain' );
		$profile_site=sanitize_text_field( $profile_site );
		
		$profile_theme = ! empty( $instance['profile_theme'] ) ? $instance['profile_theme'] : __( 'Theme', 'text_domain' );
		$profile_theme=sanitize_text_field( $profile_theme );
		
		$profile_newtab = ! empty( $instance['profile_newtab'] ) ? $instance['profile_newtab'] : __( '0', 'text_domain' );
		$profile_newtab=sanitize_text_field( $profile_newtab );
		
		?>

<p>
  <label for="<?php echo $this->get_field_id( 'profile_title' ); ?>">
    <?php _e( 'Title:' ); ?>
  </label>
  <input class="widefat" id="<?php echo $this->get_field_id( 'profile_title' ); ?>" name="<?php echo $this->get_field_name( 'profile_title' ); ?>" 
        type="text" value="<?php echo esc_attr( $profile_title ); ?>">
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'profile_sellerid' ); ?>">
    <?php _e( 'Seller ID ?' ); ?>
  </label>
  <input class="widefat" id="<?php echo $this->get_field_id( 'profile_sellerid' ); ?>" name="<?php echo $this->get_field_name( 'profile_sellerid' ); ?>" type="text" value="<?php echo esc_attr( $profile_sellerid ); ?>">
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'profile_site' ); ?>">
    <?php _e( 'eBay Site ?' ); ?>
  </label>
  <select name="<?php echo $this->get_field_name( 'profile_site' );?>" id="<?php echo $this->get_field_id( 'profile_site' ); ?>">
    <option value="0" <?php if(esc_attr( $profile_site )==0)echo "selected='selected'";?>>eBay US</option>
    <option value="3" <?php if(esc_attr( $profile_site )==3)echo "selected='selected'";?>>eBay UK</option>
    <option value="2" <?php if(esc_attr( $profile_site )==2)echo "selected='selected'";?>>eBay Canada</option>
    <option value="15" <?php if(esc_attr( $profile_site )==15)echo "selected='selected'";?>>eBay Australia</option>
    <option value="23" <?php if(esc_attr( $profile_site )==23)echo "selected='selected'";?>>eBay Belgium</option>
    <option value="77" <?php if(esc_attr( $profile_site )==77)echo "selected='selected'";?>>eBay Germany</option>
    <option value="71" <?php if(esc_attr( $profile_site )==71)echo "selected='selected'";?>>eBay France</option>
    <option value="186" <?php if(esc_attr( $profile_site )==186)echo "selected='selected'";?>>eBay Spain</option>
    <option value="16" <?php if(esc_attr( $profile_site )==16)echo "selected='selected'";?>>eBay Austria</option>
    <option value="101" <?php if(esc_attr( $profile_site )==101)echo "selected='selected'";?>>eBay Italy</option>
    <option value="146" <?php if(esc_attr( $profile_site )==146)echo "selected='selected'";?>>eBay Netherlands</option>
    <option value="205" <?php if(esc_attr( $profile_site )==205)echo "selected='selected'";?>>eBay Ireland</option>
    <option value="193" <?php if(esc_attr( $profile_site )==193)echo "selected='selected'";?>>eBay Switzerland</option>
  </select>
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'profile_theme' ); ?>">
    <?php _e( 'Theme ?' ); ?>
  </label>
  <select name="<?php echo $this->get_field_name( 'profile_theme' );?>" id="<?php echo $this->get_field_id( 'profile_theme' ); ?>">
    <option value="star_grey" <?php if(esc_attr( $profile_theme )=='star_grey')echo "selected='selected'";?>>Grey Star</option>
    <option value="badge" <?php if(esc_attr( $profile_theme )=='badge')echo "selected='selected'";?>>Rectangular Badge</option>
    <option value="simple_details" <?php if(esc_attr( $profile_theme )=='simple_details')echo "selected='selected'";?>>Simple Details</option>
  </select>
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'profile_newtab' ); ?>">
    <?php _e( 'Open link in new tab ?' ); ?>
  </label>
  <input type="radio" name="<?php echo $this->get_field_name( 'profile_newtab' ); ?>" id="<?php echo $this->get_field_id( 'profile_newtab' ); ?>" value="1" <?php if(esc_attr( $profile_newtab )=='1')echo "checked='checked'";?>>
  Yes
  <input type="radio" name="<?php echo $this->get_field_name( 'profile_newtab' ); ?>" id="<?php echo $this->get_field_id( 'profile_newtab' ); ?>" value="0" <?php if(esc_attr( $profile_newtab )=='0')echo "checked='checked'";?>>
  No </p>
<?php 
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['profile_title'] = ( ! empty( $new_instance['profile_title'] ) ) ? strip_tags( $new_instance['profile_title'] ) : '';
		$instance['profile_sellerid'] = ( ! empty( $new_instance['profile_sellerid'] ) ) ? strip_tags( $new_instance['profile_sellerid'] ) : '';
		$instance['profile_site'] = ( ! empty( $new_instance['profile_site'] ) ) ? strip_tags( $new_instance['profile_site'] ) : '';
		$instance['profile_theme'] = ( ! empty( $new_instance['profile_theme'] ) ) ? strip_tags( $new_instance['profile_theme'] ) : '';
		$instance['profile_newtab'] = ( ! empty( $new_instance['profile_newtab'] ) ) ? strip_tags( $new_instance['profile_newtab'] ) : '';
		return $instance;
	}

}
?>
