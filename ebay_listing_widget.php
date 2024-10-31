<?php
class My_Auction_Widget extends WP_Widget {

	
	function __construct() {
		parent::__construct(
			'my_aucton_widget_for_listing', 
			__( 'Auction For eBay Listing', 'text_domain' ), 
			array( 'description' => __( 'My Auction Creator Widget For eBay Listing', 'text_domain' ), ) 
		);
		
		
	}
	
	public function widget( $args, $instance ) {
		$sellerID = $instance['listing_sellerid'];
		$siteid = $instance['listing_site']; 
		if($siteid == ""){
			$siteid = 0;
		}
		if($instance['theme']=='simple_list'){
			$instance['theme'] = 'simple';	
		}
		if($instance['theme']=='images_only'){
			$instance['theme'] = 'images';	
		}
		
		$theme = $instance['theme'];
		$carousel_width = $instance['carousel_width'];
		$MaxEntries =  $instance['maxentries'];
		$page = $instance['pages'];
		if($page == "" ){
			$page = 0;
		}
		if($carousel_width == "" ){
			$carousel_width = 100;
		}
		$show_logo = $instance['logo'];
		if($show_logo == "" ){
			$show_logo = 0;
		}
		$img_size = $instance['img_size']; 
		$new_tab = $instance['new_tab'];
		if($new_tab == "" ){
			$new_tab = 0;
		}
		$sort_order = $instance['sort_order'];
		$kewword = $instance['keyword']; 
		$category_id = $instance['category_id'];
		if($sort_order==""){
			$sort_order = "EndTimeSoonest";
		}
		if($kewword==""){
			$kewword = "null";
		}
		if($category_id==""){
			$category_id = 0;
		}
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		//echo $carousel_width;
		echo __( "<script type='text/javascript' src='//www.myauctioncreator.com/item_build/js/SellerID/$sellerID/siteid/$siteid/theme/$theme/MaxEntries/$MaxEntries/scroll/4/page/0/pagination/$page/sortOrder/$sort_order/show_logo/$show_logo/blank/$new_tab/img_size/$img_size/keyword/$kewword/categoryID/$category_id/crosoulWidth/$carousel_width'></script>
        <div id='auction-creator-items' class='auction-creator'><a href='http://www.myauctioncreator.com/'>eBay Item Widget from My Auction Creator</a>
        </div>", 'text_domain' );
		echo $args['after_widget'];
		
		
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'text_domain' );
		$title=sanitize_text_field( $title );
		
		$listing_sellerid = ! empty( $instance['listing_sellerid'] ) ? $instance['listing_sellerid'] : __( 'Seller ID', 'text_domain' );
		$listing_sellerid=sanitize_text_field( $listing_sellerid );
		
		$listing_site = ! empty( $instance['listing_site'] ) ? $instance['listing_site'] : __( 'eBay Site', 'text_domain' );
		$listing_site=sanitize_text_field( $listing_site );
		
		$theme = ! empty( $instance['theme'] ) ? $instance['theme'] : __( 'Theme', 'text_domain' );
		$theme=sanitize_text_field( $theme );
		
		$carousel_width = ! empty( $instance['carousel_width'] ) ? $instance['carousel_width'] : __( '100', 'text_domain' );
		$carousel_width=sanitize_text_field( $carousel_width );
		
		$maxentries = ! empty( $instance['maxentries'] ) ? $instance['maxentries'] : __( '6', 'text_domain' );
		$maxentries=sanitize_text_field( $maxentries );
		
		$pages = ! empty( $instance['pages'] ) ? $instance['pages'] : __( 0, 'text_domain' );
		$pages=sanitize_text_field( $pages );
		
		$logo = ! empty( $instance['logo'] ) ? $instance['logo'] : __( 0, 'text_domain' );
		$logo=sanitize_text_field( $logo );
		
		$new_tab = ! empty( $instance['new_tab'] ) ? $instance['new_tab'] : __( 0, 'text_domain' );
		$new_tab=sanitize_text_field( $new_tab );
		
		$img_size = ! empty( $instance['img_size'] ) ? $instance['img_size'] : __( '80', 'text_domain' );
		$img_size=sanitize_text_field( $img_size );
		
		$sort_order = ! empty( $instance['sort_order'] ) ? $instance['sort_order'] : __( '', 'text_domain' );
		$sort_order=sanitize_text_field( $sort_order );
		
		$keyword = ! empty( $instance['keyword'] ) ? $instance['keyword'] : __( '', 'text_domain' );
		$keyword=sanitize_text_field( $keyword );
		
		$category_id = ! empty( $instance['category_id'] ) ? $instance['category_id'] : __( '', 'text_domain' );
		$category_id=sanitize_text_field( $category_id );
		?>

<p>
  <label for="<?php echo $this->get_field_id( 'title' ); ?>">
    <?php _e( 'Title:' ); ?>
  </label>
  <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'listing_sellerid' ); ?>">
    <?php _e( 'Seller ID ?' ); ?>
  </label>
  <input class="widefat" id="<?php echo $this->get_field_id( 'listing_sellerid' ); ?>" name="<?php echo $this->get_field_name( 'listing_sellerid' ); ?>" type="text" value="<?php echo esc_attr( $listing_sellerid ); ?>">
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'listing_site' ); ?>">
    <?php _e( 'eBay Site ?' ); ?>
  </label>
  <select name="<?php echo $this->get_field_name( 'listing_site' );?>" id="<?php echo $this->get_field_id( 'listing_site' ); ?>">
    <option value="0" <?php if(esc_attr( $listing_site )==0)echo "selected='selected'";?>>eBay US</option>
    <option value="3" <?php if(esc_attr( $listing_site )==3)echo "selected='selected'";?>>eBay UK</option>
    <option value="2" <?php if(esc_attr( $listing_site )==2)echo "selected='selected'";?>>eBay Canada</option>
    <option value="15" <?php if(esc_attr( $listing_site )==15)echo "selected='selected'";?>>eBay Australia</option>
    <option value="23" <?php if(esc_attr( $listing_site )==23)echo "selected='selected'";?>>eBay Belgium</option>
    <option value="77" <?php if(esc_attr( $listing_site )==77)echo "selected='selected'";?>>eBay Germany</option>
    <option value="71" <?php if(esc_attr( $listing_site )==71)echo "selected='selected'";?>>eBay France</option>
    <option value="186" <?php if(esc_attr( $listing_site )==186)echo "selected='selected'";?>>eBay Spain</option>
    <option value="16" <?php if(esc_attr( $listing_site )==16)echo "selected='selected'";?>>eBay Austria</option>
    <option value="101" <?php if(esc_attr( $listing_site )==101)echo "selected='selected'";?>>eBay Italy</option>
    <option value="146" <?php if(esc_attr( $listing_site )==146)echo "selected='selected'";?>>eBay Netherlands</option>
    <option value="205" <?php if(esc_attr( $listing_site )==205)echo "selected='selected'";?>>eBay Ireland</option>
    <option value="193" <?php if(esc_attr( $listing_site )==193)echo "selected='selected'";?>>eBay Switzerland</option>
  </select>
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'theme' ); ?>">
    <?php _e( 'Theme ?' ); ?>
  </label>
  <select name="<?php echo $this->get_field_name( 'theme' );?>" id="<?php echo $this->get_field_id( 'theme' ); ?>">
    <option value="columns" <?php if(esc_attr( $theme )=='columns')echo "selected='selected'";?>>Column View</option>
    <option value="carousel" <?php if(esc_attr( $theme )=='carousel')echo "selected='selected'";?>>Carousel</option>
    <option value="simple_list" <?php if(esc_attr( $theme )=='simple_list')echo "selected='selected'";?>>Simple List</option>
    <option value="details" <?php if(esc_attr( $theme )=='details')echo "selected='selected'";?>>Image and Details</option>
    <option value="images_only" <?php if(esc_attr( $theme )=='images_only')echo "selected='selected'";?>>Images Only</option>
    <option value="grid" <?php if(esc_attr( $theme )=='grid')echo "selected='selected'";?>>Grid View</option>
    <option value="unstyled" <?php if(esc_attr( $theme )=='unstyled')echo "selected='selected'";?>>Unstyled (advanced)</option>
  </select>
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'carousel_width' ); ?>">
    <?php _e( 'Carousel Width ?' ); ?>
  </label>
  <input type="text" name="carousel_width" id="carousel_width" value="<?php echo esc_attr( $carousel_width ); ?>">
  px </p>
<p>
  <label for="<?php echo $this->get_field_id( 'maxentries' ); ?>">
    <?php _e( 'No. of item to show ?' ); ?>
  </label>
  <input type="text" name="<?php echo $this->get_field_name( 'maxentries' ); ?>" id="<?php echo $this->get_field_id( 'maxentries' ); ?>" value="<?php echo esc_attr( $maxentries ); ?>">
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'pages' ); ?>">
    <?php _e( 'Show multiple pages ?' ); ?>
  </label>
  <input type="radio" name="<?php echo $this->get_field_name( 'pages' ); ?>" id="<?php echo $this->get_field_id( 'pages' ); ?>" value="1" <?php if(esc_attr( $pages )=='1')echo "checked='checked'";?>>
  Yes
  <input type="radio" name="<?php echo $this->get_field_name( 'pages' ); ?>" id="<?php echo $this->get_field_id( 'pages' ); ?>" value="0" <?php if(esc_attr( $pages )=='0')echo "checked='checked'";?>>
  No </p>
<p>
  <label for="<?php echo $this->get_field_id( 'logo' ); ?>">
    <?php _e( 'Show eBay logo ?' ); ?>
  </label>
  <input type="radio" name="<?php echo $this->get_field_name( 'logo' ); ?>" id="<?php echo $this->get_field_id( 'logo' ); ?>" value="1" <?php if(esc_attr( $logo )=='1')echo "checked='checked'";?>>
  Yes
  <input type="radio" name="<?php echo $this->get_field_name( 'logo' ); ?>" id="<?php echo $this->get_field_id( 'logo' ); ?>" value="0" <?php if(esc_attr( $logo )=='0')echo "checked='checked'";?>>
  No </p>
<p>
  <label for="<?php echo $this->get_field_id( 'new_tab' ); ?>">
    <?php _e( 'Open link in new tab ?' ); ?>
  </label>
  <input type="radio" name="<?php echo $this->get_field_name( 'new_tab' ); ?>" id="<?php echo $this->get_field_id( 'new_tab' ); ?>" value="1" <?php if(esc_attr( $new_tab )=='1')echo "checked='checked'";?>>
  Yes
  <input type="radio" name="<?php echo $this->get_field_name( 'new_tab' ); ?>" id="<?php echo $this->get_field_id( 'new_tab' ); ?>" value="0" <?php if(esc_attr( $new_tab )=='0')echo "checked='checked'";?>>
  No </p>
<p>
  <label for="<?php echo $this->get_field_id( 'img_size' ); ?>">
    <?php _e( 'Image size ?' ); ?>
  </label>
  <input type="text" name="<?php echo $this->get_field_name( 'img_size' ); ?>" id="<?php echo $this->get_field_id( 'img_size' ); ?>" value="<?php echo esc_attr( $img_size ); ?>">
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'sort_order' ); ?>">
    <?php _e( 'Sort order ?' ); ?>
  </label>
  <select name="<?php echo $this->get_field_name( 'sort_order' ); ?>" id="<?php echo $this->get_field_id( 'sort_order' ); ?>">
    <option value="" <?php if(esc_attr( $sort_order )=='')echo "selected='selected'";?>>Items Ending First</option>
    <option value="StartTimeNewest" <?php if(esc_attr( $sort_order )=='StartTimeNewest')echo "selected='selected'";?>>Newly-Listed First</option>
    <option value="PricePlusShippingLowest" <?php if(esc_attr( $sort_order )=='PricePlusShippingLowest')echo "selected='selected'";?>>Price + Shipping: Lowest First</option>
    <option value="PricePlusShippingHighest" <?php if(esc_attr( $sort_order )=='PricePlusShippingHighest')echo "selected='selected'";?>>Price + Shipping: Highest First</option>
    <option value="BestMatch" <?php if(esc_attr( $sort_order )=='BestMatch')echo "selected='selected'";?>>Best Match</option>
  </select>
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'keyword' ); ?>">
    <?php _e( 'Filter by keyword ?' ); ?>
  </label>
  <input type="text" name="<?php echo $this->get_field_name( 'keyword' ); ?>" id="<?php echo $this->get_field_id( 'keyword' ); ?>" value="<?php echo esc_attr( $keyword ); ?>">
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'category_id' ); ?>">
    <?php _e( 'Filter by category ID ?' ); ?>
  </label>
  <input type="text" name="<?php echo $this->get_field_name( 'category_id' ); ?>" id="<?php echo $this->get_field_id( 'category_id' ); ?>" value="<?php echo esc_attr( $category_id ); ?>">
</p>
<?php 
	}

	public function update( $new_instance, $old_instance ) {
		//print_r($new_instance); 
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['listing_sellerid'] = ( ! empty( $new_instance['listing_sellerid'] ) ) ? strip_tags( $new_instance['listing_sellerid'] ) : '';
		$instance['listing_site'] = ( ! empty( $new_instance['listing_site'] ) ) ? strip_tags( $new_instance['listing_site'] ) : '';
		$instance['theme'] = ( ! empty( $new_instance['theme'] ) ) ? strip_tags( $new_instance['theme'] ) : '';
		$instance['carousel_width'] = ( ! empty( $new_instance['carousel_width'] ) ) ? strip_tags( $new_instance['carousel_width'] ) : '';
		$instance['maxentries'] = ( ! empty( $new_instance['maxentries'] ) ) ? strip_tags( $new_instance['maxentries'] ) : '';
		$instance['pages'] = ( ! empty( $new_instance['pages'] ) ) ? strip_tags( $new_instance['pages'] ) : '';
		$instance['logo'] = ( ! empty( $new_instance['logo'] ) ) ? strip_tags( $new_instance['logo'] ) : '';
		$instance['new_tab'] = ( ! empty( $new_instance['new_tab'] ) ) ? strip_tags( $new_instance['new_tab'] ) : '';
		$instance['img_size'] = ( ! empty( $new_instance['img_size'] ) ) ? strip_tags( $new_instance['img_size'] ) : '';
		$instance['sort_order'] = ( ! empty( $new_instance['sort_order'] ) ) ? strip_tags( $new_instance['sort_order'] ) : '';
		$instance['keyword'] = ( ! empty( $new_instance['keyword'] ) ) ? strip_tags( $new_instance['keyword'] ) : '';
		$instance['category_id'] = ( ! empty( $new_instance['category_id'] ) ) ? strip_tags( $new_instance['category_id'] ) : '';
		

		return $instance;
	}

}
?>
