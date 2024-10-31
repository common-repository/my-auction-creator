<?php
class My_Auction_Widget_Feedback extends WP_Widget {

	
	function __construct() {
		parent::__construct(
			'my_aucton_widget_for_feedback', 
			__( 'Auction For eBay Feedback', 'text_domain' ), 
			array( 'description' => __( 'My Auction Creator Widget For eBay Feedback', 'text_domain' ), ) 
		);
		
		
	}
	
	public function widget( $args, $instance ) {
		
		$sellerID = $instance['feedback_sellerid'];
		if($instance['feedback_site']==''){
			$instance['feedback_site'] = 0;
		}
		$siteid = $instance['feedback_site'];
		if($instance['feedback_theme']=='profile_table' || $instance['feedback_theme']==''){
			$instance['feedback_theme'] = 'profiletable';
		}
		if($instance['feedback_maxentries']=='' || $instance['feedback_maxentries']==0){
			$instance['feedback_maxentries'] = 5;
		}
		$theme = $instance['feedback_theme'];
		$feedback_maxentries = $instance['feedback_maxentries'];
		$feedback_type = $instance['feedback_type'];
		if($instance['feedback_newtab']==''){
			$instance['feedback_newtab'] = 0;
		}
		$feedback_newtab = $instance['feedback_newtab'];
		if($feedback_newtab == "" ){
			$feedback_newtab = 0;
		}
		echo $args['before_widget'];
		if ( ! empty( $instance['feedback_title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['feedback_title'] ). $args['after_title'];
		}
		echo __( "<script type='text/javascript' src='//www.myauctioncreator.com/feedback_build/js/SellerID/$sellerID/siteid/$siteid/limit/$feedback_maxentries/type/$feedback_type/theme/$theme/blank/$feedback_newtab'></script>
<div id='auction-creator-feedback' class='auction-creator'><a href='http://www.myauctioncreator.com/'>eBay Feedback by My Auction Creator</a></div>
        ", 'text_domain' );
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$feedback_title = ! empty( $instance['feedback_title'] ) ? $instance['feedback_title'] : __( 'New title', 'text_domain' );
		$feedback_title=sanitize_text_field( $feedback_title );
		
		$feedback_sellerid = ! empty( $instance['feedback_sellerid'] ) ? $instance['feedback_sellerid'] : __( 'Seller ID', 'text_domain' );
		$feedback_sellerid=sanitize_text_field( $feedback_sellerid );
		
		$feedback_site = ! empty( $instance['feedback_site'] ) ? $instance['feedback_site'] : __( 'eBay Site', 'text_domain' );
		$feedback_site=sanitize_text_field( $feedback_site );
		
		$feedback_theme = ! empty( $instance['feedback_theme'] ) ? $instance['feedback_theme'] : __( 'Theme', 'text_domain' );
		$feedback_theme=sanitize_text_field( $feedback_theme );
		
		$feedback_maxentries = ! empty( $instance['feedback_maxentries'] ) ? $instance['feedback_maxentries'] : __( '5', 'text_domain' );
		$feedback_maxentries=sanitize_text_field( $feedback_maxentries );
		
		$feedback_type = ! empty( $instance['feedback_type'] ) ? $instance['feedback_type'] : __( 'FeedbackReceived', 'text_domain' );
		$feedback_type=sanitize_text_field( $feedback_type );
		
		$feedback_newtab = ! empty( $instance['feedback_newtab'] ) ? $instance['feedback_newtab'] : __( '0', 'text_domain' );
		$feedback_newtab=sanitize_text_field( $feedback_newtab );
		
		?>

<p>
  <label for="<?php echo $this->get_field_id( 'feedback_title' ); ?>">
    <?php _e( 'Title:' ); ?>
  </label>
  <input class="widefat" id="<?php echo $this->get_field_id( 'feedback_title' ); ?>" name="<?php echo $this->get_field_name( 'feedback_title' ); ?>" 
        type="text" value="<?php echo esc_attr( $feedback_title ); ?>">
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'feedback_sellerid' ); ?>">
    <?php _e( 'Seller ID ?' ); ?>
  </label>
  <input class="widefat" id="<?php echo $this->get_field_id( 'feedback_sellerid' ); ?>" name="<?php echo $this->get_field_name( 'feedback_sellerid' ); ?>" type="text" value="<?php echo esc_attr( $feedback_sellerid ); ?>">
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'feedback_site' ); ?>">
    <?php _e( 'eBay Site ?' ); ?>
  </label>
  <select name="<?php echo $this->get_field_name( 'feedback_site' );?>" id="<?php echo $this->get_field_id( 'feedback_site' ); ?>">
    <option value="0" <?php  if(esc_attr( $feedback_site )==0)echo   "selected='selected'";?>>eBay US</option>
    <option value="3" <?php  if(esc_attr( $feedback_site )==3)echo   "selected='selected'";?>>eBay UK</option>
    <option value="2" <?php  if(esc_attr( $feedback_site )==2)echo   "selected='selected'";?>>eBay Canada</option>
    <option value="15" <?php if(esc_attr( $feedback_site )==15)echo  "selected='selected'";?>>eBay Australia</option>
    <option value="23" <?php if(esc_attr( $feedback_site )==23)echo  "selected='selected'";?>>eBay Belgium</option>
    <option value="77" <?php if(esc_attr( $feedback_site )==77)echo  "selected='selected'";?>>eBay Germany</option>
    <option value="71" <?php if(esc_attr( $feedback_site )==71)echo  "selected='selected'";?>>eBay France</option>
    <option value="186"<?php if(esc_attr( $feedback_site )==186)echo "selected='selected'";?>>eBay Spain</option>
    <option value="16" <?php if(esc_attr( $feedback_site )==16)echo  "selected='selected'";?>>eBay Austria</option>
    <option value="101"<?php if(esc_attr( $feedback_site )==101)echo "selected='selected'";?>>eBay Italy</option>
    <option value="146"<?php if(esc_attr( $feedback_site )==146)echo "selected='selected'";?>>eBay Netherlands</option>
    <option value="205"<?php if(esc_attr( $feedback_site )==205)echo "selected='selected'";?>>eBay Ireland</option>
    <option value="193"<?php if(esc_attr( $feedback_site )==193)echo "selected='selected'";?>>eBay Switzerland</option>
  </select>
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'feedback_theme' ); ?>">
    <?php _e( 'Theme ?' ); ?>
  </label>
  <select id="<?php echo $this->get_field_id( 'feedback_theme' ); ?>" name="<?php echo $this->get_field_name( 'feedback_theme' );?>">
    <option <?php if(esc_attr( $feedback_theme )=='profile_table')echo "selected='selected'";?> value="profile_table">Profile table</option>
    <option value="table" <?php if(esc_attr( $feedback_theme )=='table')echo "selected='selected'";?>>Basic table</option>
  </select>
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'feedback_maxentries' ); ?>">
    <?php _e( 'Entries to show ?' ); ?>
  </label>
  <input type="text" value="<?php echo esc_attr( $feedback_maxentries );?>" id="<?php echo $this->get_field_id( 'feedback_maxentries' ); ?>" name="<?php echo $this->get_field_id( 'feedback_maxentries' ); ?>">
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'feedback_type' ); ?>">
    <?php _e( 'Feedback type ?' ); ?>
  </label>
  <select id="<?php echo $this->get_field_id( 'feedback_type' ); ?>" name="<?php echo $this->get_field_name( 'feedback_type' );?>">
    <option value="FeedbackReceived" <?php if(esc_attr( $feedback_type )=='FeedbackReceived')echo "selected='selected'";?>>All feedback received</option>
    <option value="FeedbackLeft" <?php if(esc_attr( $feedback_type )=='FeedbackLeft')echo "selected='selected'";?>>All feedback left for others</option>
    <option value="FeedbackReceivedAsBuyer" <?php if(esc_attr( $feedback_type )=='FeedbackReceivedAsBuyer')echo "selected='selected'";?>>Feedback received as a buyer</option>
    <option value="FeedbackReceivedAsSeller" <?php if(esc_attr( $feedback_type )=='FeedbackReceivedAsSeller')echo "selected='selected'";?>>Feedback received as a seller</option>
  </select>
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'feedback_newtab' ); ?>">
    <?php _e( 'Open link in new tab ?' ); ?>
  </label>
  <input type="radio" name="<?php echo $this->get_field_name( 'feedback_newtab' ); ?>" id="<?php echo $this->get_field_id( 'feedback_newtab' ); ?>" value="1" <?php if(esc_attr( $feedback_newtab )=='1')echo "checked='checked'";?>>
  Yes
  <input type="radio" name="<?php echo $this->get_field_name( 'feedback_newtab' ); ?>" id="<?php echo $this->get_field_id( 'feedback_newtab' ); ?>" value="0" <?php if(esc_attr( $feedback_newtab )=='0')echo "checked='checked'";?>>
  No </p>
<?php 
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['feedback_title'] = ( ! empty( $new_instance['feedback_title'] ) ) ? strip_tags( $new_instance['feedback_title'] ) : '';
		$instance['feedback_sellerid'] = ( ! empty( $new_instance['feedback_sellerid'] ) ) ? strip_tags( $new_instance['feedback_sellerid'] ) : '';
		$instance['feedback_site'] = ( ! empty( $new_instance['feedback_site'] ) ) ? strip_tags( $new_instance['feedback_site'] ) : '';
		$instance['feedback_theme'] = ( ! empty( $new_instance['feedback_theme'] ) ) ? strip_tags( $new_instance['feedback_theme'] ) : '';
		$instance['feedback_maxentries'] = ( ! empty( $new_instance['feedback_maxentries'] ) ) ? strip_tags( $new_instance['feedback_maxentries'] ) : '';
		$instance['feedback_type'] = ( ! empty( $new_instance['feedback_type'] ) ) ? strip_tags( $new_instance['feedback_type'] ) : '';
		$instance['feedback_newtab'] = ( ! empty( $new_instance['feedback_newtab'] ) ) ? strip_tags( $new_instance['feedback_newtab'] ) : '';
		
		return $instance;
	}

}
?>
