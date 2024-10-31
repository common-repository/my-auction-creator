<?php
class My_Auction_Widget_Ads extends WP_Widget {

	
	function __construct() {
		parent::__construct(
			'my_aucton_widget_for_ads', 
			__( 'Auction For eBay Ads', 'text_domain' ), 
			array( 'description' => __( 'My Auction Creator Widget For eBay Ads', 'text_domain' ), ) 
		);
		
		
	}
	
	public function widget( $args, $instance ) {
		
		$sellerID = $instance['ad_sellerid'];
		
		if($instance['ad_site']==''){
			$instance['ad_site'] = 0;
		}
		$siteid = $instance['ad_site'];
		$size =  $instance['ad_size'];
		
		$ad_size = explode('x', $size);
		
		$ad_color =  $instance['ad_color'];
		if($instance['blank_ad']==''){
		$instance['blank_ad'] = 0;	
		}
		if($instance['ad_userid']==''){
		$instance['ad_userid'] = 0;	
		}
		$blank_ad = $instance['blank_ad'];
		$ad_userid = $instance['ad_userid'];
		$ad_sort_order = $instance['sort_order'];
		$ad_kewword = $instance['keyword']; 
		$ad_category_id = $instance['category_id'];
		if($ad_sort_order==""){
			$ad_sort_order = "EndTimeSoonest";
		}
		if($ad_kewword==""){
			$ad_kewword = "null";
		}
		if($ad_category_id==""){
			$ad_category_id = 0;
		}
		echo $args['before_widget'];
		if ( ! empty( $instance['ad_title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['ad_title'] ). $args['after_title'];
		}
		echo __( "<iframe width='$ad_size[0]' height='$ad_size[1]' style='border:none' scrolling='1' frameborder='0' src='//www.myauctioncreator.com/item_build/iframe/SellerID/$sellerID/siteid/0/format/$size/theme/$ad_color/MaxEntries/6/carousel_auto/5/
		hide_username/$ad_userid/sortOrder/$ad_sort_order/keyword/$ad_kewword/categoryID/$ad_category_id'></iframe>", 'text_domain' );
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$ad_title = ! empty( $instance['ad_title'] ) ? $instance['ad_title'] : __( 'New title', 'text_domain' );
		$ad_title=sanitize_text_field( $ad_title );
		
		$ad_sellerid = ! empty( $instance['ad_sellerid'] ) ? $instance['ad_sellerid'] : __( 'Seller ID', 'text_domain' );
		$ad_sellerid=sanitize_text_field( $ad_sellerid );
		
		$ad_site = ! empty( $instance['ad_site'] ) ? $instance['ad_site'] : __( 'eBay Site', 'text_domain' );
		$ad_site=sanitize_text_field( $ad_site );
		
		$ad_size = ! empty( $instance['ad_size'] ) ? $instance['ad_size'] : __( '300x250', 'text_domain' );
		$ad_size=sanitize_text_field( $ad_size );
		
		$ad_color = ! empty( $instance['ad_color'] ) ? $instance['ad_color'] : __( 'green', 'text_domain' );
		$ad_color=sanitize_text_field( $ad_color );

		$blank_ad = ! empty( $instance['blank_ad'] ) ? $instance['blank_ad'] : __( 0, 'text_domain' );
		$blank_ad=sanitize_text_field( $blank_ad );
		
		$ad_userid = ! empty( $instance['ad_userid'] ) ? $instance['ad_userid'] : __( 0, 'text_domain' );
		$ad_userid=sanitize_text_field( $ad_userid );
		
		$ad_sort_order = ! empty( $instance['ad_sort_order'] ) ? $instance['ad_sort_order'] : __( '', 'text_domain' );
		$ad_sort_order=sanitize_text_field( $ad_sort_order );
		
		$ad_keyword = ! empty( $instance['ad_keyword'] ) ? $instance['ad_keyword'] : __( '', 'text_domain' );
		$ad_keyword=sanitize_text_field( $ad_keyword );
		
		$ad_category_id = ! empty( $instance['ad_category_id'] ) ? $instance['ad_category_id'] : __( '', 'text_domain' );
		$ad_category_id=sanitize_text_field( $ad_category_id );
		?>

<p>
  <label for="<?php echo $this->get_field_id( 'ad_title' ); ?>">
    <?php _e( 'Title:' ); ?>
  </label>
  <input class="widefat" id="<?php echo $this->get_field_id( 'ad_title' ); ?>" name="<?php echo $this->get_field_name( 'ad_title' ); ?>" 
        type="text" value="<?php echo esc_attr( $ad_title ); ?>">
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'ad_sellerid' ); ?>">
    <?php _e( 'Seller ID ?' ); ?>
  </label>
  <input class="widefat" id="<?php echo $this->get_field_id( 'ad_sellerid' ); ?>" name="<?php echo $this->get_field_name( 'ad_sellerid' ); ?>" type="text" value="<?php echo esc_attr( $ad_sellerid ); ?>">
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'ad_site' ); ?>">
    <?php _e( 'eBay Site ?' ); ?>
  </label>
  <select name="<?php echo $this->get_field_name( 'ad_site' );?>" id="<?php echo $this->get_field_id( 'ad_site' ); ?>">
    <option value="0" <?php if(esc_attr( $ad_site )==0)echo "selected='selected'";?>>eBay US</option>
    <option value="3" <?php if(esc_attr( $ad_site )==3)echo "selected='selected'";?>>eBay UK</option>
    <option value="2" <?php if(esc_attr( $ad_site )==2)echo "selected='selected'";?>>eBay Canada</option>
    <option value="15" <?php if(esc_attr( $ad_site )==15)echo "selected='selected'";?>>eBay Australia</option>
    <option value="23" <?php if(esc_attr( $ad_site )==23)echo "selected='selected'";?>>eBay Belgium</option>
    <option value="77" <?php if(esc_attr( $ad_site )==77)echo "selected='selected'";?>>eBay Germany</option>
    <option value="71" <?php if(esc_attr( $ad_site )==71)echo "selected='selected'";?>>eBay France</option>
    <option value="186" <?php if(esc_attr( $ad_site )==186)echo "selected='selected'";?>>eBay Spain</option>
    <option value="16" <?php if(esc_attr( $ad_site )==16)echo "selected='selected'";?>>eBay Austria</option>
    <option value="101" <?php if(esc_attr( $ad_site )==101)echo "selected='selected'";?>>eBay Italy</option>
    <option value="146" <?php if(esc_attr( $ad_site )==146)echo "selected='selected'";?>>eBay Netherlands</option>
    <option value="205" <?php if(esc_attr( $ad_site )==205)echo "selected='selected'";?>>eBay Ireland</option>
    <option value="193" <?php if(esc_attr( $ad_site )==193)echo "selected='selected'";?>>eBay Switzerland</option>
  </select>
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'ad_size' ); ?>">
    <?php _e( 'Ad size ?' ); ?>
  </label>
  <select name="<?php echo $this->get_field_name( 'ad_size' );?>" id="<?php echo $this->get_field_id( 'ad_size' ); ?>">
    <option value="300x250" <?php if(esc_attr( $ad_size )=='300x250')echo "selected='selected'";?>>Medium rectangle (300px x 250px)</option>
    <option value="336x280" <?php if(esc_attr( $ad_size )=='336x280')echo "selected='selected'";?>>Large rectangle (336px x 280px)</option>
    <option value="250x250" <?php if(esc_attr( $ad_size )=='250x250')echo "selected='selected'";?>>Square (250px x 250px)</option>
    <option value="120x600" <?php if(esc_attr( $ad_size )=='120x600')echo "selected='selected'";?>>Skyscraper (120px x 600px)</option>
    <option value="728x90" <?php if(esc_attr( $ad_size )=='728x90')echo "selected='selected'";?>>Leaderboard (728px x 90px)</option>
    <option value="160x600" <?php if(esc_attr( $ad_size )=='160x600')echo "selected='selected'";?>>Wide skyscraper (160px x 600px)</option>
  </select>
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'ad_color' ); ?>">
    <?php _e( 'Ad color ?' ); ?>
  </label>
  <select name="<?php echo $this->get_field_name( 'ad_color' );?>" id="<?php echo $this->get_field_id( 'ad_color' ); ?>">
    <option value="green" <?php if(esc_attr( $ad_color )=='green')echo "selected='selected'";?>>Green</option>
    <option value="red" <?php if(esc_attr( $ad_color )=='red')echo "selected='selected'";?>>Red</option>
    <option value="blue" <?php if(esc_attr( $ad_color )=='blue')echo "selected='selected'";?>>Blue</option>
    <option value="orange" <?php if(esc_attr( $ad_color )=='orange')echo "selected='selected'";?>>Orange</option>
    <option value="grey" <?php if(esc_attr( $ad_color )=='grey')echo "selected='selected'";?>>Grey</option>
    <option value="pink" <?php if(esc_attr( $ad_color )=='pink')echo "selected='selected'";?>>Pink</option>
  </select>
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'blank_ad' ); ?>">
    <?php _e( 'Blank ad if no listings ?' ); ?>
  </label>
  <input type="radio" name="<?php echo $this->get_field_name( 'blank_ad' ); ?>" id="<?php echo $this->get_field_id( 'blank_ad' ); ?>" value="1" <?php if(esc_attr( $blank_ad )=='1')echo "checked='checked'";?>>
  Yes
  <input type="radio" name="<?php echo $this->get_field_name( 'blank_ad' ); ?>" id="<?php echo $this->get_field_id( 'blank_ad' ); ?>" value="0" <?php if(esc_attr( $blank_ad )=='0')echo "checked='checked'";?>>
  No </p>
<p>
  <label for="<?php echo $this->get_field_id( 'ad_userid' ); ?>">
    <?php _e( 'Hide eBay UserID ?' ); ?>
  </label>
  <input type="radio" name="<?php echo $this->get_field_name( 'ad_userid' ); ?>" id="<?php echo $this->get_field_id( 'ad_userid' ); ?>" value="1" <?php if(esc_attr( $ad_userid )=='1')echo "checked='checked'";?>>
  Yes
  <input type="radio" name="<?php echo $this->get_field_name( 'ad_userid' ); ?>" id="<?php echo $this->get_field_id( 'ad_userid' ); ?>" value="0" <?php if(esc_attr( $ad_userid )=='0')echo "checked='checked'";?>>
  No </p>
<p>
  <label for="<?php echo $this->get_field_id( 'ad_sort_order' ); ?>">
    <?php _e( 'Sort order ?' ); ?>
  </label>
  <select name="<?php echo $this->get_field_name( 'ad_sort_order' ); ?>" id="<?php echo $this->get_field_id( 'ad_sort_order' ); ?>">
    <option value="" <?php if(esc_attr( $ad_sort_order )=='')echo "selected='selected'";?>>Items Ending First</option>
    <option value="StartTimeNewest" <?php if(esc_attr( $ad_sort_order )=='StartTimeNewest')echo "selected='selected'";?>>Newly-Listed First</option>
    <option value="PricePlusShippingLowest" <?php if(esc_attr( $ad_sort_order )=='PricePlusShippingLowest')echo "selected='selected'";?>>Price + Shipping: Lowest First</option>
    <option value="PricePlusShippingHighest" <?php if(esc_attr( $ad_sort_order )=='PricePlusShippingHighest')echo "selected='selected'";?>>Price + Shipping: Highest First</option>
    <option value="BestMatch" <?php if(esc_attr( $ad_sort_order )=='BestMatch')echo "selected='selected'";?>>Best Match</option>
  </select>
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'ad_keyword' ); ?>">
    <?php _e( 'Filter by keyword ?' ); ?>
  </label>
  <input type="text" name="<?php echo $this->get_field_name( 'ad_keyword' ); ?>" id="<?php echo $this->get_field_id( 'ad_keyword' ); ?>" value="<?php echo esc_attr( $ad_keyword ); ?>">
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'ad_category_id' ); ?>">
    <?php _e( 'Filter by category ID ?' ); ?>
  </label>
  <input type="text" name="<?php echo $this->get_field_name( 'ad_category_id' ); ?>" id="<?php echo $this->get_field_id( 'ad_category_id' ); ?>" value="<?php echo esc_attr( $ad_category_id ); ?>">
</p>
<?php 
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['ad_title'] = ( ! empty( $new_instance['ad_title'] ) ) ? strip_tags( $new_instance['ad_title'] ) : '';
		$instance['ad_sellerid'] = ( ! empty( $new_instance['ad_sellerid'] ) ) ? strip_tags( $new_instance['ad_sellerid'] ) : '';
		$instance['ad_site'] = ( ! empty( $new_instance['ad_site'] ) ) ? strip_tags( $new_instance['ad_site'] ) : '';
		$instance['ad_size'] = ( ! empty( $new_instance['ad_size'] ) ) ? strip_tags( $new_instance['ad_size'] ) : '';
		$instance['ad_color'] = ( ! empty( $new_instance['ad_color'] ) ) ? strip_tags( $new_instance['ad_color'] ) : '';
		$instance['blank_ad'] = ( ! empty( $new_instance['blank_ad'] ) ) ? strip_tags( $new_instance['blank_ad'] ) : '';
		$instance['ad_userid'] = ( ! empty( $new_instance['ad_userid'] ) ) ? strip_tags( $new_instance['ad_userid'] ) : '';
		$instance['ad_sort_order'] = ( ! empty( $new_instance['ad_sort_order'] ) ) ? strip_tags( $new_instance['ad_sort_order'] ) : '';
		$instance['ad_keyword'] = ( ! empty( $new_instance['ad_keyword'] ) ) ? strip_tags( $new_instance['ad_keyword'] ) : '';
		$instance['ad_category_id'] = ( ! empty( $new_instance['ad_category_id'] ) ) ? strip_tags( $new_instance['ad_category_id'] ) : '';
		

		return $instance;
	}

}
?>
