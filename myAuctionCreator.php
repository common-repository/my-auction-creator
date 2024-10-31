<?php
/*
Plugin Name: My Auction Creator
Plugin URI: http://www.myauctioncreator.com/wordpress-plugin
Description: This plugin makes it easier to display your eBay information on your WordPress site using My Auction Creator.You will notice an options added to the edit page/post screen below the content editor.
Version: 1.0.0
Author: Suyog Computech Pvt Ltd
Author URI: http://www.suyogcomputech.com/
License: GPL2
*/

/*Registering My Auction Creator Widgets*/
function register_myauction_widget() {
    register_widget( 'My_Auction_Widget' );
	register_widget( 'My_Auction_Widget_Ads' );
	register_widget( 'My_Auction_Widget_Profile' );
	register_widget( 'My_Auction_Widget_Feedback' );
	wp_register_style('custom', plugins_url('css/style.css',__FILE__ ));
wp_enqueue_style('custom');
}
add_action( 'widgets_init', 'register_myauction_widget' );
require_once 'ebay_listing_widget.php';
require_once 'ebay_ads_widget.php';
require_once 'ebay_profile_widget.php';
require_once 'ebay_feedback_widget.php';
class myAuctionCreator{
	function __construct()
	{
		register_activation_hook( __FILE__, array($this,'my_auction_creator_activation' ));
		add_action( 'add_meta_boxes', array($this,'my_auction_creator_custom_field' ));
		add_action( 'save_post', array($this,'my_auction_creator_form_save' ));
		
		/*Shortcodes for eBay listings,ads,profile and feedback*/
		add_shortcode('myauctioncreator_listing' , array( $this,'ebay_listing' )); 
		add_shortcode('myauctioncreator_ads' , array( $this,'ebay_ads' )); 
		add_shortcode('myauctioncreator_profile' , array( $this,'ebay_profile' )); 
		add_shortcode('myauctioncreator_feedback' , array( $this,'ebay_feedback' )); 
	}
	/*For Plugin Activation and version */
	function my_auction_creator_activation() 
	{
		global $wpdb;
		global $version;
		$version = "1.0";
	}
	
	/*Add custom fields*/
	function my_auction_creator_custom_field()
	{	foreach(array('post','page') as $custom_field){
			add_meta_box( 'new-add-field',  'My Auction Creator', array($this, 'my_auction_creator_field_form'), $custom_field, 'normal', 'high' );
			}
	}
	
	/*Saving form data into database*/
	function my_auction_creator_form_save( $id )
	{
		
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	
		if( !isset( $_POST[ 'auction_field' ] ) || !wp_verify_nonce( $_POST[ 'auction_field' ], 'save_quote_meta' ) ) return;
	
	
	 /*Saving eBay listing form data*/	
	 $item_listing = array( "userid" => $_POST[ "item_user_id" ], "siteid" => $_POST[ "itemSiteid" ],"theme" => $_POST[ "itemTheme" ],      "carousel_width" => $_POST[ "carousel_width" ], "entries" => $_POST[ "itemMaxEntries" ], "multiple_page" => $_POST[ "item_page" ], "logo"=> $_POST["item_show_logo"], "new_tab" => $_POST[ "item_blank" ], "img_size" => $_POST[ "item_imgSize" ], "sortOrder" => $_POST[ "itemSortOrder" ], "keyword"=>$_POST[" itemKeyword" ], "categoryId" => $_POST[ "itemCategoryId" ]);
	
	 /*Saving eBay ads form data*/
	  $ads = array( "ad_userid" => $_POST[ "adSellerID" ], "ad_siteid" => $_POST[ "ads_Site_Id" ], "ad_size" => $_POST[ "adFormat" ], "ad_color" =>$_POST [ "adTheme" ], "scroll" => $_POST[ "ad_Carousel_auto" ], "blank_id" => $_POST[ "ad_blank_noitems" ], "hide_id" => $_POST[ "ad_hide_username" ], "ad_sortOrder" => $_POST[ "ad_Sort_Order" ], "ad_keyword" => $_POST[ "Ad_Keyword" ], "ad_categoryId" => $_POST[ "Ad_Category_Id" ]);
	
	 /*Saving eBay profile form data*/
	  $profile = array( "profile_userid" => $_POST[ "profile_UserID" ], "profile_siteid" => $_POST[ "profileSiteid" ], "profile_theme" => $_POST[     "profileTheme" ], "profile_newtab" => $_POST[ "profile_blank" ]);
	
	 /*Saving eBay feedback form data*/
	  $feedback = array( "feedback_userid" => $_POST[ "feedback_UserID" ], "feedback_siteid" =>$_POST[ "FeedbackSite_id" ], "Feedback_theme" =>$_POST[ "FeedbackTheme" ], "FeedbackEntries" => $_POST[ "FeedbackLimit" ], "Feedback_type" => $_POST[ "FeedbackType" ], "Feedback_blank_id" => $_POST[      "feedback_blank"]);
	
	
	/*Update all data*/
		foreach( $item_listing as $k => $v){
		$v = sanitize_text_field( $v );
		update_post_meta( $id, $k,$v );		
		                         }
								 
		foreach( $ads as $key => $val){
		$val = sanitize_text_field( $val );
		update_post_meta( $id, $key,$val );
		                         }	
								 
		foreach( $profile as $pkey => $pval){
		$pval = sanitize_text_field( $pval );
		update_post_meta( $id, $pkey,$pval );
		                         }							 					 
	
	    foreach( $feedback as $fkey=>$fval){
		$fval = sanitize_text_field( $fval );
		update_post_meta( $id, $fkey,$fval );
		                         }	
	}		

/*Get form field data*/
	function my_auction_creator_field_form($post){
		$userid_listing = get_post_meta( $post->ID, 'userid', true );
		$siteid_listing = get_post_meta( $post->ID, 'siteid', true );
		$theme_listing = get_post_meta( $post->ID, 'theme', true );
		$carousel_width_listing = get_post_meta( $post->ID, 'carousel_width', true );
		$entries_listing = get_post_meta( $post->ID, 'entries', true );
		$multiple_page_listing = get_post_meta( $post->ID, 'multiple_page', true );
		$logo_listing = get_post_meta( $post->ID, 'logo', true );
		$newtab_listing =get_post_meta( $post->ID, 'new_tab', true );
		$img_size_listing = get_post_meta( $post->ID, 'img_size', true );
		$sortOrder_listing = get_post_meta( $post->ID, 'sortOrder', true );
		$keyword_listing = get_post_meta( $post->ID, 'keyword', true );
		$categoryId_listing = get_post_meta( $post->ID, 'categoryId', true );
		if($carousel_width_listing == "" ){
			$carousel_width_listing = 100;
		}
		
		
		$userid_ad 	  =	 get_post_meta  ( $post->ID, 'ad_userid', true );
		$siteid_ad 	  =	 get_post_meta  ( $post->ID, 'ad_siteid', true );
		$size_ad   	  =	 get_post_meta  ( $post->ID, 'ad_size', true );
		$color_ad  	  =	 get_post_meta  ( $post->ID, 'ad_color', true );
		$scroll_ad 	  =	 get_post_meta  ( $post->ID, 'scroll', true );
		$blank_id_ad  =  get_post_meta  ( $post->ID, 'blank_id', true );
		$hide_id_ad	  =  get_post_meta  ( $post->ID, 'hide_id', true );
		$sortorder_ad =  get_post_meta  ( $post->ID, 'ad_sortOrder', true );
		$keyword_ad   =  get_post_meta  ( $post->ID, 'ad_keyword', true );
		$categoryId_a =  get_post_meta  ( $post->ID, 'ad_categoryId', true );
		
		
		$userid_profile = get_post_meta ( $post->ID, 'profile_userid', true );
		$siteid_profile = get_post_meta ( $post->ID, 'profile_siteid', true );
		$theme_profile  = get_post_meta ( $post->ID, 'profile_theme', true );
		$newtab_profile = get_post_meta ( $post->ID, 'profile_newtab', true );
		
		
		$userid_feedback	=	get_post_meta  ( $post->ID, 'feedback_userid', true );
		$siteid_feedback	=	get_post_meta  ( $post->ID, 'feedback_siteid', true );
		$theme_feedback		=	get_post_meta  ( $post->ID, 'Feedback_theme', true );
		$entries_feedback	=	get_post_meta  ( $post->ID, 'FeedbackEntries', true );
		$type_feedback		=	get_post_meta  ( $post->ID, 'Feedback_type', true );
		$blankid_feedback	=	get_post_meta  ( $post->ID, 'Feedback_blank_id', true );
		
		wp_nonce_field( 'save_quote_meta', 'auction_field' );
		?>
<script src="http://code.jquery.com/jquery-latest.min.js"
        type="text/javascript"></script>
<script>

/*Codes to show hide of My Auction creator tabs*/
function fun1()
{
$("#soft").css("background-color","white");
$("#soft").css("color","black");
$("#inds").css("background-color","#F9F9F9");
$("#inds").css("color","black");
$("#sys").css("background-color","#F9F9F9");
$("#sys").css("color","black");
$("#abc").css("background-color","#F9F9F9");
$("#abc").css("color","black");
$("#softpart").show();
$("#indspart").hide();
$("#abcpart").hide();
$("#syspart").hide();
}

function fun2()
{
$("#soft").css("background-color","#F9F9F9");
$("#soft").css("color","black");
$("#inds").css("background-color","white");
$("#inds").css("color","black");
$("#sys").css("background-color","#F9F9F9");
$("#sys").css("color","black");
$("#abc").css("background-color","#F9F9F9");
$("#abc").css("color","black");
$("#softpart").hide();
$("#abcpart").hide();
$("#indspart").show();
$("#syspart").hide();
}

function fun3()
{
$("#soft").css("background-color","#F9F9F9");
$("#soft").css("color","black");
$("#inds").css("background-color","#F9F9F9");
$("#inds").css("color","black");
$("#sys").css("background-color","white");
$("#sys").css("color","black");
$("#abc").css("background-color","#F9F9F9");
$("#abc").css("color","black");
$("#softpart").hide();
$("#indspart").hide();
$("#abcpart").hide();
$("#syspart").show();
}

function fun4()
{
$("#soft").css("background-color","#F9F9F9");
$("#soft").css("color","black");
$("#inds").css("background-color","#F9F9F9");
$("#inds").css("color","black");
$("#sys").css("background-color","F9F9F9");
$("#sys").css("color","black");
$("#abc").css("background-color","white");
$("#abc").css("color","black");
$("#softpart").hide();
$("#indspart").hide();
$("#syspart").hide();
$("#abcpart").show();
}

</script>

<!--Style for the My Auction Creator Boxes-->
<style>
#softpart {
	font: 14px 'Open Sans', sans-serif;
	font-weight: normal;
	line-height: 12px;
	color: black;
}
#indspart {
	font: 14px 'Open Sans', sans-serif;
	font-weight: normal;
	line-height: 12px;
	color: black;
}
#syspart {
	font: 14px 'Open Sans', sans-serif;
	font-weight: normal;
	line-height: 12px;
	color: black;
}
#abcpart {
	font: 14px 'Open Sans', sans-serif;
	font-weight: normal;
	line-height: 12px;
	color: black;
}
#soft {
background-color:white color:black;
	cursor: pointer;
}
#inds {
	background-color: #F9F9F9;
	color: black;
	cursor: pointer;
}
#sys {
	background-color: #F9F9F9;
	color: black;
	cursor: pointer;
}
#abc {
	background-color: #F9F9F9;
	color: black;
	cursor: pointer;
}
</style>
<!-- Creating My Auction Creator boxes showing under content editor -->
<table bgcolor="white">
  <tr>
    <th align="center" id="soft"  onclick="fun1()">Your eBay Listing</th>
    <th align="center" id="inds"  onclick="fun2()">Your eBay Ads</th>
    <th align="center" id="sys"   onclick="fun3()">Your eBay Profile</th>
    <th align="center" id="abc"   onclick="fun4()">Your eBay Feedback</th>
  </tr>
  <tr id='softpart'>
  
  <!-- My Auction Creator box for eBay Listing -->
    <td colspan="3"><h2>Your eBay Listing</h2>
    <p>Add this shortcode within your content editor to specify where the items will appear: <b>[myauctioncreator_listing]</b></p>
      <table border=0 width=600>
        <tr>
          <td><label for= "item_SellerID" class= "control-label">eBay user ID <a onclick="return false;" href="#" title="This is your eBay ID (username) that is associated to your eBay account. This is the username you are known by on eBay and appears on your listings." class="tip">?</a></label></td>
          <td><input type= "text" name= "item_user_id" id="item_user_id"  value="<?php echo $userid_listing; ?>"></td>
        </tr>
        <tr>
          <td><label for= "item_siteid" class= "control-label">eBay site <a onclick="return false;" href="#" title="This is usually where your items are listed. Which site you choose will determine which site you link to and what currency is displayed." class="tip">?</a></label></td>
          <td><select name="itemSiteid" id="siteid">
              <option value="0" <?php if(  $siteid_listing==0   ){ echo "selected='selected'";} ?>>eBay US</option>
              <option value="3"<?php if(   $siteid_listing==3   ){ echo "selected='selected'";} ?>>eBay UK</option>
              <option value="2"<?php if(   $siteid_listing==2   ){ echo "selected='selected'";} ?>>eBay Canada</option>
              <option value="15"<?php if(  $siteid_listing==15  ){ echo "selected='selected'";} ?>>eBay Australia</option>
              <option value="23"<?php if(  $siteid_listing==23  ){ echo "selected='selected'";} ?>>eBay Belgium</option>
              <option value="77"<?php if(  $siteid_listing==77  ){ echo "selected='selected'";} ?>>eBay Germany</option>
              <option value="71"<?php if(  $siteid_listing==71  ){ echo "selected='selected'";} ?>>eBay France</option>
              <option value="186"<?php if( $siteid_listing==186 ){ echo "selected='selected'";} ?>>eBay Spain</option>
              <option value="16"<?php if(  $siteid_listing==16  ){ echo "selected='selected'";} ?>>eBay Austria</option>
              <option value="101"<?php if( $siteid_listing==101 ){ echo "selected='selected'";} ?>>eBay Italy</option>
              <option value="146"<?php if( $siteid_listing==146 ){ echo "selected='selected'";} ?>>eBay Netherlands</option>
              <option value="205"<?php if( $siteid_listing==205 ){ echo "selected='selected'";} ?>>eBay Ireland</option>
              <option value="193"<?php if( $siteid_listing==193 ){ echo "selected='selected'";} ?>>eBay Switzerland</option>
            </select></td>
        </tr>
        <tr>
          <td><label for= "item_theme" class= "control-label">Theme <a onclick="return false;" href="#" title="Your items will display differently on your site depending on which theme you choose. You can also control how your listings appear using custom CSS rules, go to the 'Help / FAQ' page for more details." class="tip">?</a></label></td>
          <td><select name  =  "itemTheme" id="theme">
              <option value = "columns" <?php if( $theme_listing=='columns'){ echo "selected='selected'";} ?>>Column View</option>
              <option value = "carousel" <?php if( $theme_listing=='carousel'){ echo "selected='selected'";} ?>>Carousel</option>
              <option value = "simple_list" <?php if( $theme_listing=='simple_list'){ echo "selected='selected'";} ?>>Simple List</option>
              <option value = "details" <?php if( $theme_listing=='details'){ echo "selected='selected'";} ?>>Image and Details</option>
              <option value = "images_only" <?php if( $theme_listing=='images_only'){ echo "selected='selected'";} ?>>Images Only</option>
              <option value = "grid" <?php if( $theme_listing=='grid'){ echo "selected='selected'";} ?>>Grid View</option>
              <option value = "unstyled" <?php if( $theme_listing=='unstyled'){ echo "selected='selected'";} ?>>Unstyled (advanced)</option>
            </select></td>
        </tr>
        <tr>
          <td><label for= "carousel_width" class= "control-label">Carousel Width <a onclick="return false;" href="#" title="" class="tip">?</a></label></td>
          <td><input type= "text" name= "carousel_width" id= "carousel_width" value= "<?php echo $carousel_width_listing; ?>">px
            <br></td>
        </tr>
        <tr>
          <td><label for= "item_MaxEntries" class= "control-label">Number of items to show <a onclick="return false;" href="#" title="This is the number of items you want display per page, the maximum value is 100. You can display multiple pages of items using the 'Show multiple pages?' option below." class="tip">?</a></label></td>
          <td><input type= "text" name= "itemMaxEntries" id= "item_MaxEntries" value= "<?php echo $entries_listing;?>">
            <br></td>
        <tr>
        <tr>
          <td><label for= "item_page" class= "control-label">Show multiple pages? <a onclick="return false;" href="#" title="If you enable this option and have more items listed than the value for the 'Number of items to show' option above then users can paginate between multiple pages of items." class="tip">?</a></label></td>
          <td><input type= "radio" name= "item_page" id= "item_pagey" value= "1" <?php if($multiple_page_listing==1){ echo "checked";} ?>>
            Yes <br>
            <br>
            <input type= "radio"   name= "item_page"   id= "item_pagen"value= "0" <?php if($multiple_page_listing==0){ echo "checked";} ?> >
            No <br>
            <br></td>
        </tr>
        <tr>
          <td><label for= "item_show_logo" class= "control-label">Show eBay Logo? <a onclick="return false;" href="#" title="This option specifies if you want to display the eBay logo with your listings." class="tip">?</a></label></td>
          <td><input type= "radio" name= "item_show_logo" id= "item_show_logoy" value= "1" <?php if($logo_listing==1){ echo "checked";} ?>>
            Yes <br>
            <br>
            <input type= "radio" name= "item_show_logo" id= "item_show_logoyn" value= "0"<?php if($logo_listing==0){ echo "checked";} ?> >
            No <br></td>
        </tr>
        <tr>
          <td><label for= "item_blank" class= "control-label">Open links in new tab? <a onclick="return false;" href="#" title="Enabling this option will open item links in a new browser tab." class="tip">?</a></label></td>
          <td><input type="radio" name= "item_blank" id= "item_blank_y" value= "1" <?php if($newtab_listing==1){ echo "checked";} ?>>
            Yes<br>
            <br>
            <input type= "radio" checked= "checked" id= "item_blank_n" value= "0" name="item_blank"<?php if($newtab_listing==0){ echo "checked";} ?>>
            No<br></td>
        </tr>
        <tr>
          <td><label for= "item_img_size" class= "control-label">Image Size <a onclick="return false;" href="#" title="Specify in pixels the maximum image size. Depending on the image ratio, the image width or height will not exceed this size. This value should be numeric only, 'px' not needed (if blank defaults to 64)" class="tip">?</a></label></td>
          <td><input type="text" name= "item_imgSize" id= "item_img_size" value= "<?php echo $img_size_listing;?>"></td>
        </tr>
        <tr>
          <td><label for= "item_sortOrder" class= "control-label">Sort order <a onclick="return false;" href="#" title="This option adjusts the order of the items shown." class= "tip">?</a></label></td>
          <td><select name= "itemSortOrder" id="sortOrder">
              <option value= "" <?php if($sortOrder_listing==''){ echo "selected='selected'";} ?>>Items Ending First</option>
              <option value= "StartTimeNewest" <?php if($sortOrder_listing== 'StartTimeNewest'){ echo "selected='selected'";} ?>>Newly-Listed First</option>
              <option value= "PricePlusShippingLowest"<?php if($sortOrder_listing== 'PricePlusShippingLowest' ){ echo "selected='selected'";} ?>>Price + Shipping: Lowest First</option>
              <option value= "PricePlusShippingHighest"<?php if($sortOrder_listing== 'PricePlusShippingHighest' ){ echo "selected='selected'";} ?>>Price + Shipping: Highest First</option>
              <option value= "BestMatch"<?php if($sortOrder_listing=='BestMatch'){ echo "selected='selected'"; } ?>>Best Match</option>
            </select></td>
        </tr>
        <tr>
          <td><label for= "item_keyword" class= "control-label">Filter by keyword <a onclick= "return false;" href="#" title= "By specifying a keyword, only items which contain that keyword in their title will be displayed. Keywords can contain multiple words and up to 5 keywords may be specified. Keywords are separated with a colon (:) and this acts as an OR operator. For example the keywords “red:dark blue:black” will display all items with either “red” or “dark blue” or “black” in their title." class="tip">?</a></label></td>
          <td><input type= "text" name= "itemKeyword" id= "item_keyword" value= "<?php echo $keyword_listing;?>"></td>
        </tr>
        <tr>
          <td><label for= "item_categoryId" class= "control-label">Filter by category ID <a onclick="return false;" href="#" title="By specifying an eBay category ID only items which are listed in this category will be displayed. You can specify up to 3 different category IDs by separating with a colon (:) for example 123:456:789 See the Help/FAQ page for help on obtaining category IDs." class="tip">?</a></label></td>
          <td><input type= "text" name= "itemCategoryId" id= "item_categoryId" value="<?php echo $categoryId_listing;?>"></td>
        </tr>
      </table></td>
  </tr>
  <tr id='indspart' style="display:none">
  
  <!-- My Auction Creator box for eBay Ads -->
    <td colspan="3"><h2>Your eBay Ads</h2>
    <p>Add this shortcode within your content editor to specify where the ad will appear: <b>[myauctioncreator_ads]</b></p>
      <table border=0 width=600>
        <tr>
          <td><label for= "ad_SellerID" class="control-label">eBay user ID <a onclick="return false;" href="#" title="This is your eBay ID (username) that is associated to your eBay account. This is the username you are known by on eBay and appears on your listings." class="tip">?</a></label></td>
          <td><input name= "adSellerID" id="SellerID" value="<?php echo $userid_ad;?>" type="text"></td>
        </tr>
        <tr>
          <td><label for= "ad_siteid" class="control-label">eBay site <a onclick="return false;" href="#" title="This is usually where your items are listed. Which site you choose will determine which site you link to and what currency is displayed." class="tip">?</a></label></td>
          <td><select id="siteid" name="ads_Site_Id">
              <option value= "0" <?php if($siteid_ad==0){ echo "selected='selected'";} ?>>eBay US</option>
              <option value= "3"<?php if($siteid_ad==3){ echo "selected='selected'";} ?>>eBay UK</option>
              <option value= "2"<?php if($siteid_ad==2){ echo "selected='selected'";} ?>>eBay Canada</option>
              <option value= "15"<?php if($siteid_ad==15){ echo "selected='selected'";} ?>>eBay Australia</option>
              <option value= "23"<?php if($siteid_ad==23){ echo "selected='selected'";} ?>>eBay Belgium</option>
              <option value= "77"<?php if($siteid_ad==77){ echo "selected='selected'";} ?>>eBay Germany</option>
              <option value= "71"<?php if($siteid_ad==71){ echo "selected='selected'";} ?>>eBay France</option>
              <option value= "186"<?php if($siteid_ad==186){ echo "selected='selected'";} ?>>eBay Spain</option>
              <option value= "16"<?php if($siteid_ad==16){ echo "selected='selected'";} ?>>eBay Austria</option>
              <option value= "101"<?php if($siteid_ad==101){ echo "selected='selected'";} ?>>eBay Italy</option>
              <option value= "146"<?php if($siteid_ad==146){ echo "selected='selected'";} ?>>eBay Netherlands</option>
              <option value= "205"<?php if($siteid_ad==205){ echo "selected='selected'";} ?>>eBay Ireland</option>
              <option value= "193"<?php if($siteid_ad==193){ echo "selected='selected'";} ?>>eBay Switzerland</option>
            </select></td>
        </tr>
        <tr>
          <td><label for="ad_format" class="control-label">Ad size <a onclick="return false;" href="#" title="Choose from the following list of standard ad sizes." class="tip">?</a></label></td>
          <td><select id="format" name="adFormat">
              <option value= "300x250" <?php if($size_ad=='300x250'){ echo "selected='selected'";} ?>>Medium rectangle (300px x 250px)</option>
              <option value= "336x280" <?php if($size_ad=='336x280'){ echo "selected='selected'";} ?>>Large rectangle (336px x 280px)</option>
              <option value= "250x250" <?php if($size_ad=='250x250'){ echo "selected='selected'";} ?>>Square (250px x 250px)</option>
              <option value= "120x600" <?php if($size_ad=='120x600'){ echo "selected='selected'";} ?>>Skyscraper (120px x 600px)</option>
              <option value= "728x90"  <?php if($size_ad=='728x90') { echo "selected='selected'";} ?>>Leaderboard (728px x 90px)</option>
              <option value= "160x600" <?php if($size_ad=='160x600'){ echo "selected='selected'";} ?>>Wide skyscraper (160px x 600px)</option>
            </select></td>
        </tr>
        <tr>
          <td><label for="ad_theme" class="control-label">Ad colour <a onclick="return false;" href="#" title="Specifying a colour will change how the ad appears in order to better integrate with your site." class="tip">?</a></label></td>
          <td><select id="theme" name="adTheme">
              <option value= "green"  <?php if($color_ad=='green') { echo "selected='selected'";} ?>>Green</option>
              <option value= "red"    <?php if($color_ad=='red')   { echo "selected='selected'";} ?>>Red</option>
              <option value= "blue"   <?php if($color_ad=='blue')  { echo "selected='selected'";} ?>>Blue</option>
              <option value= "orange" <?php if($color_ad=='orange'){ echo "selected='selected'";} ?>>Orange</option>
              <option value= "grey"   <?php if($color_ad=='grey')  { echo "selected='selected'";} ?>>Grey</option>
              <option value= "pink"   <?php if($color_ad=='pink')  { echo "selected='selected'";} ?>>Pink</option>
            </select></td>
        <tr>
        <tr>
          <td><label for="ad_carousel_auto" class="control-label">Auto scroll? <a onclick="return false;" href="#" title="This option specifies how often, in seconds the ad should auto scroll. If set to 0 auto scroll is disabled." class="tip">?</a></label></td>
          <td><input type="text" value="<?php if($scroll_ad!=''){echo $scroll_ad;}else{echo 5;}?>" id="carousel_auto" name="ad_Carousel_auto"></td>
        </tr>
        <tr>
          <td><label for="ad_blank_noitems" class="control-label">Blank ad if no listings? <a onclick="return false;" href="#" title="This option enables you to show nothing in the ad space if you do not have any active listings." class="tip">?</a></label></td>
          <td><input type="radio" name="ad_blank_noitems" value="1" <?php if($blank_id_ad==1){ echo "checked";} ?>>
            Yes <br>
            <br>
            <input type="radio" name="ad_blank_noitems" value="0" <?php if($blank_id_ad==0){ echo "checked";} ?>>
            No <br>
            <br></td>
        </tr>
        <tr>
          <td><label for="ad_hide_username" class="control-label">Hide eBay User ID? <a onclick="return false;" href="#" title="This option hides your eBay username and instead displays 'Our items on eBay' next to your feedback score." class="tip">?</a></label></td>
          <td><input type="radio" name="ad_hide_username" value="1"<?php  if($hide_id_ad==1){ echo "checked";} ?>>
            Yes <br>
            <br>
            <input type="radio" name="ad_hide_username" value="0" <?php if($hide_id_ad==0){ echo "checked";} ?>>
            No <br>
            <br></td>
        </tr>
        <tr>
          <td><label for="ad_sortOrder" class="control-label">Sort order <a onclick="return false;" href="#" title="This option adjusts the order of the items shown." class="tip">?</a></label></td>
          <td><select id="sortOrder" name="ad_Sort_Order">
              <option value="" <?php if($sortorder_ad=='green') { echo "selected='selected'";} ?>>Items Ending First</option>
              <option value="StartTimeNewest"<?php if($sortorder_ad=='StartTimeNewest') { echo "selected='selected'";} ?>>Newly-Listed First</option>
              <option value="PricePlusShippingLowest"<?php if($sortorder_ad=='PricePlusShippingLowest') { echo "selected='selected'";} ?>>Price + Shipping: Lowest First</option>
              <option value="PricePlusShippingHighest"<?php if($sortorder_ad=='PricePlusShippingHighest') { echo "selected='selected'";} ?>>Price + Shipping: Highest First</option>
              <option value="BestMatch"<?php if($sortorder_ad=='BestMatch') { echo "selected='selected'";} ?>>Best Match</option>
            </select></td>
        </tr>
        <tr>
          <td><label for="adeyword" class="control-label">Filter by keyword <a onclick="return false;" href="#" title="By specifying a keyword, only items which contain that keyword in their title will be displayed. Keywords can contain multiple words and up to 5 keywords may be specified. Keywords are separated with a colon (:) and this acts as an OR operator. For example the keywords “red:dark blue:black” will display all items with either “red” or “dark blue” or “black” in their title." class="tip">?</a></label></td>
          <td><input type="text" id="keyword" name="Ad_Keyword" value="<?php echo $keyword_ad; ?>"></td>
        </tr>
        <tr>
          <td><label for="ad_categoryId" class="control-label">Filter by category ID <a onclick="return false;" href="#" title="By specifying an eBay category ID only items which are listed in this category will be displayed. You can specify up to 3 different category IDs by separating with a colon (:) for example 123:456:789 See the Help/FAQ page for help on obtaining category IDs." class="tip">?</a></label></td>
          <td><input type="text" id="categoryId" name="Ad_Category_Id" value="<?php echo $categoryId_ad;?>"></td>
        </tr>
      </table></td>
  </tr>
  <tr id='syspart' style="display:none">
  
  <!-- My Auction Creator box for eBay Profile -->
    <td colspan="3"><h2>Your eBay Profile</h2>
    <p>Add this shortcode within your content editor to specify where the profile will appear: <b>[myauctioncreator_profile]</b></p>
      <table border=0 width=600>
        <tr>
          <td><label for="profile_UserID" class="control-label">eBay user ID <a onclick="return false;" href="#" title="This is your eBay ID (username) that is associated to your eBay account. This is the username you are known by on eBay and appears on your listings." class="tip">?</a></label></td>
          <td><input type="text" name="profile_UserID" value="<?php echo $userid_profile;?>"></td>
        </tr>
        <tr>
          <td><label for="profile_siteid" class="control-label">eBay site <a onclick="return false;" href="#" title="This is the site where your eBay account is registered. Although selecting any site will link your badge to your feedback profile, selecting your 'home' site will ensure your current items are also displayed." class="tip">?</a></label></td>
          <td><select name="profileSiteid" id="siteid">
              <option value="0"  <?php if($siteid_profile==0)  { echo "selected='selected'";} ?>>eBay US</option>
              <option value="3"  <?php if($siteid_profile==3)  { echo "selected='selected'";} ?>>eBay UK</option>
              <option value="2"  <?php if($siteid_profile==2)  { echo "selected='selected'";} ?>>eBay Canada</option>
              <option value="15" <?php if($siteid_profile==15) { echo "selected='selected'";} ?>>eBay Australia</option>
              <option value="23" <?php if($siteid_profile==23) { echo "selected='selected'";} ?>>eBay Belgium</option>
              <option value="77" <?php if($siteid_profile==77) { echo "selected='selected'";} ?>>eBay Germany</option>
              <option value="71" <?php if($siteid_profile==71) { echo "selected='selected'";} ?>>eBay France</option>
              <option value="186"<?php if($siteid_profile==186){ echo "selected='selected'";} ?>>eBay Spain</option>
              <option value="16" <?php if($siteid_profile==16) { echo "selected='selected'";} ?>>eBay Austria</option>
              <option value="101"<?php if($siteid_profile==101){ echo "selected='selected'";} ?>>eBay Italy</option>
              <option value="146"<?php if($siteid_profile==146){ echo "selected='selected'";} ?>>eBay Netherlands</option>
              <option value="205"<?php if($siteid_profile==205){ echo "selected='selected'";} ?>>eBay Ireland</option>
              <option value="193"<?php if($siteid_profile==193){ echo "selected='selected'";} ?>>eBay Switzerland</option>
            </select></td>
        </tr>
        <tr>
          <td><label for="profile_theme" class="control-label">Theme <a onclick="return false;" href="#" title="Your profile information will display differently on your site depending on which theme you choose." class="tip">?</a></label></td>
          <td><select id="theme" name="profileTheme">
              <option  value="star_grey"  <?php if($theme_profile=='star_grey'){ echo "selected='selected'";} ?>>Grey Star</option>
              <option value="badge"       <?php if($theme_profile=='badge'){ echo "selected='selected'";} ?>>Rectangular Badge</option>
              <option value="simple_details" <?php if($theme_profile=='simple_details'){ echo "selected='selected'";} ?>>Simple Details</option>
            </select></td>
        </tr>
        <tr>
          <td><label for="profile_blank" class="control-label">Open links in new tab? <a onclick="return false;" href="#" title="Enabling this option will open the link to your profile in a new browser tab." class="tip">?</a></label></td>
          <td><input type="radio" value="1" name="profile_blank" <?php if($newtab_profile=='1'){ echo "checked";} ?>>
            Yes<br>
            <br>
            <input type="radio" value="0" name="profile_blank" <?php if($newtab_profile=='0'){ echo "checked";} ?>>
            No<br></td>
        </tr>
      </table></td>
  </tr>
  <tr id='abcpart' style="display:none">
  
  <!-- My Auction Creator box for eBay Feedback-->
    <td colspan="3"><h2>Your eBay Feedback</h2>
    <p>Add this shortcode within your editor to specify where the feedback will appear:<b>[myauctioncreator_feedback]</b></p>
      <table border=0 width=600>
        <tr>
          <td><label for="feedback_UserID" class="control-label">eBay user ID <a onclick="return false;" href="#" title="This is your eBay ID (username) that is associated to your eBay account. This is the username you are known by on eBay and appears on your listings." class="tip">?</a></label></td>
          <td><input type="text" name="feedback_UserID" value="<?php echo $userid_feedback;?>"></td>
        </tr>
        <tr>
          <td><label for="feedback_siteid" class="control-label">eBay site <a onclick="return false;" href="#" title="This is the site where your eBay account is registered. Although selecting any site will link your badge to your feedback profile, selecting your 'home' site will ensure your current items are also displayed." class="tip">?</a></label></td>
          <td><select name="FeedbackSite_id" id="siteid">
              <option value="0" <?php if($siteid_feedback==0){ echo "selected='selected'";} ?>>eBay US</option>
              <option value="3" <?php if($siteid_feedback==3){ echo "selected='selected'";} ?>>eBay UK</option>
              <option value="2" <?php if($siteid_feedback==2){ echo "selected='selected'";} ?>>eBay Canada</option>
              <option value="15"<?php if($siteid_feedback==15){ echo "selected='selected'";} ?>>eBay Australia</option>
              <option value="23"<?php if($siteid_feedback==23){ echo "selected='selected'";} ?>>eBay Belgium</option>
              <option value="77"<?php if($siteid_feedback==77){ echo "selected='selected'";} ?>>eBay Germany</option>
              <option value="71"<?php if($siteid_feedback==71){ echo "selected='selected'";} ?>>eBay France</option>
              <option value="186"<?php if($siteid_feedback==186){ echo "selected='selected'";} ?>>eBay Spain</option>
              <option value="16"<?php if($siteid_feedback==16){ echo "selected='selected'";} ?>>eBay Austria</option>
              <option value="101"<?php if($siteid_feedback==101){ echo "selected='selected'";} ?>>eBay Italy</option>
              <option value="146"<?php if($siteid_feedback==146){ echo "selected='selected'";} ?>>eBay Netherlands</option>
              <option value="205"<?php if($siteid_feedback==205){ echo "selected='selected'";} ?>>eBay Ireland</option>
              <option value="193"<?php if($siteid_feedback==293){ echo "selected='selected'";} ?>>eBay Switzerland</option>
            </select></td>
        </tr>
        <tr>
          <td><label for="feedback_theme" class="control-label">Theme <a onclick="return false;" href="#" title="Your feedback will display differently on your site depending on which theme you choose." class="tip">?</a></label></td>
          <td><select id="theme" name="FeedbackTheme">
              <option value="profile_table" <?php if($theme_feedback=='profile_table'){ echo "selected='selected'";} ?>>Profile table</option>
              <option value="table" <?php if($theme_feedback=='table'){ echo "selected='selected'";} ?>>Basic table</option>
            </select></td>
        </tr>
        <tr>
          <td><label for="feedback_limit" class="control-label">Entries to show (1-25) <a onclick="return false;" href="#" title="This number determines how many feedback entries will be displayed." class="tip">?</a></label></td>
          <td><input type="text" value="<?php if($entries_feedback!=''){echo $entries_feedback;}else{ echo 5;}?>" id="limit" name="FeedbackLimit"></td>
        </tr>
        <tr>
          <td><label for="feedback_type" class="control-label">Feedback type <a onclick="return false;" href="#" title="Determines the type of feedback entries displayed." class="tip">?</a></label></td>
          <td><select id="type" name="FeedbackType">
              <option value="FeedbackReceived" <?php if($type_feedback=='FeedbackReceived'){ echo "selected='selected'";} ?>>All feedback received</option>
              <option value="FeedbackLeft"<?php if($type_feedback=='FeedbackLeft'){ echo "selected='selected'";} ?>>All feedback left for others</option>
              <option value="FeedbackReceivedAsBuyer"<?php if($type_feedback=='FeedbackReceivedAsBuyer'){ echo "selected='selected'";} ?>>Feedback received as a buyer</option>
              <option value="FeedbackReceivedAsSeller"<?php if($type_feedback=='FeedbackReceivedAsSeller'){ echo "selected='selected'";} ?>>Feedback received as a seller</option>
            </select></td>
        </tr>
        <tr>
          <td><label for="feedback_blank" class="control-label">Open links in new tab? <a onclick="return false;" href="#" title="Enabling this option will open item links in a new browser tab." class="tip">?</a></label></td>
          <td><input type="radio" id="tab" name="feedback_blank" value="1" <?php if($blankid_feedback=='1'){ echo "checked";} ?>>
            Yes <br>
            <br>
            <input type="radio" name="feedback_blank" value="0" <?php if($blankid_feedback=='0'){ echo "checked";} ?>>
            No <br></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
	}
	
	/*Get all the given data for eBay listing*/
	function ebay_listing(){
		ob_start();
		global $wpdb;
		$userid_listing  = get_post_meta( get_the_ID(), 'userid', true );
		$siteid_listing  = get_post_meta( get_the_ID(), 'siteid', true );
		$theme_listing   = get_post_meta( get_the_ID(), 'theme', true );
		$carousel_width_listing   = get_post_meta( get_the_ID(), 'carousel_width', true );
		//echo $theme_listing;exit;
		$entries_listing = get_post_meta( get_the_ID(), 'entries', true );
		$multiple_page_listing = get_post_meta( get_the_ID(), 'multiple_page', true );
		if($multiple_page_listing == "" ){
			$multiple_page_listing = 0;
		} 
		if($carousel_width_listing == "" ){
			$carousel_width_listing = 100;
		}
		$logo_listing = get_post_meta( get_the_ID(), 'logo', true );
		if($logo_listing == "" ){
			$logo_listing = 0;
		}
		$newtab_listing=get_post_meta( get_the_ID(), 'new_tab', true );
		if($newtab_listing == "" ){
			$newtab_listing = 0;
		}
		$img_size_listing = get_post_meta( get_the_ID(), 'img_size', true );
		$sortOrder_listing = get_post_meta( get_the_ID(), 'sortOrder', true );
		$keyword_listing = get_post_meta( get_the_ID(), 'keyword', true );
		$categoryId_listing = get_post_meta( get_the_ID(), 'categoryId', true );
		if($sortOrder_listing==""){
			$sortOrder_listing = "EndTimeSoonest";
		}
		if($keyword_listing==""){
			$keyword_listing = "null";
		}
		if($categoryId_listing==""){
			$categoryId_listing = 0;
		}
		?>
<script type="text/javascript" src="//www.myauctioncreator.com/item_build/js/SellerID/<?php echo $userid_listing; ?>/siteid/<?php echo $siteid_listing; ?>/theme/<?php if($theme_listing=='simple_list'){$theme_listing='simple';}if($theme_listing=='images_only'){$theme_listing='images';}echo $theme_listing; ?>/MaxEntries/<?php echo $entries_listing; ?>/scroll/4/page/0/pagination/<?php echo $multiple_page_listing;?>/sortOrder/<?php echo $sortOrder_listing;?>/show_logo/<?php echo $logo_listing;?>/blank/<?php echo $newtab_listing;?>/img_size/<?php echo $img_size_listing;?>/keyword/<?php echo $keyword_listing;?>/categoryID/<?php echo $categoryId_listing;?>/crosoulWidth/<?php echo $carousel_width_listing;?>"></script>
        <div id="auction-creator-items" class="auction-creator"><a href="http://www.myauctioncreator.com/">eBay Item Widget from My Auction Creator</a>
        </div>
        
<?php return ob_get_clean();
		}
		
		/*Get all the given data for eBay Ads*/
		function ebay_ads(){
			ob_start();
		global $wpdb;
		$userid_ad=get_post_meta( get_the_ID(), 'ad_userid', true );
		$siteid_ad=get_post_meta( get_the_ID(), 'ad_siteid', true );
		$size_ad  =get_post_meta( get_the_ID(), 'ad_size', true );
		$color_ad =get_post_meta( get_the_ID(), 'ad_color', true );
		$scroll_ad=get_post_meta( get_the_ID(), 'scroll', true );
		$blank_id_ad=get_post_meta( get_the_ID(), 'blank_id', true );
		$hide_id_ad=get_post_meta( get_the_ID(), 'hide_id', true );
		$sortorder_ad=get_post_meta( get_the_ID(), 'ad_sortOrder', true );
		$keyword_ad=get_post_meta( get_the_ID(), 'ad_keyword', true );
		$categoryId_ad=get_post_meta( get_the_ID(), 'ad_categoryId', true );
		if($sortorder_ad==""){
			$sortorder_ad = "EndTimeSoonest";
		}
		if($keyword_ad==""){
			$keyword_ad = "null";
		}
		if($categoryId_ad==""){
			$categoryId_ad = 0;
		}
		$exformat = explode('x',$size_ad);	
		if($exformat[0]==300 &&  $exformat[1]==250)	{
			$class="med";
		}
		if($exformat[0]==336 &&  $exformat[1]==280)	{
			$class="large";
		}
		if($exformat[0]==250 &&  $exformat[1]==250)	{
			$class="square";
		}
		if($exformat[0]==120 &&  $exformat[1]==600)	{
			$class="sky";
		}
		if($exformat[0]==728 &&  $exformat[1]==90)	{
			$class="leader";
		}
		if($exformat[0]==160 &&  $exformat[1]==600)	{
			$class="wide";
		}
		
		?>
<iframe class="<?php echo $class;?>" width="<?php echo $exformat[0];?>" height="<?php echo $exformat[1] ;?>" style="border:none; height:100%;" frameborder="0" scrolling="no" src="http://www.myauctioncreator.com/item_build/iframe/SellerID/<?php echo $userid_ad;?>/siteid/<?php echo $siteid_ad;?>/format/<?php echo $size_ad;?>/theme/<?php echo $color_ad;?>/MaxEntries/6/carousel_auto/<?php echo $scroll_ad;?>/hide_username/<?php echo $hide_id_ad;?>/sortOrder/<?php echo $sortorder_ad;?>/keyword/<?php echo $keyword_ad;?>/categoryID/<?php echo $categoryId_ad;?>"></iframe>
        
<?php return ob_get_clean();
		}
	 
	/*Get all the given data for eBay Profile*/
	 function ebay_profile(){
		 ob_start();
		global $wpdb;
		$userid_profile =get_post_meta( get_the_ID(),  'profile_userid', true );
		$siteid_profile =get_post_meta( get_the_ID(),  'profile_siteid', true );
		$theme_profile  =get_post_meta( get_the_ID(), 'profile_theme', true );
	    $newtab_profile =get_post_meta( get_the_ID(), 'profile_newtab', true );
		if($theme_profile=='star_grey'){
			$theme_profile  ="stargrey";
			$profile_class="stargrey";
			
			}
			if($theme_profile=='simple_details'){
			$theme_profile  ="simple";
			}
			
		?>
<iframe class="<?php echo $profile_class;?>"width="240" height="158" style="border:none" frameborder="0" scrolling="no" src="http://myauctioncreator.com/profile_build/js/
SellerID/<?php echo $userid_profile;?>/siteid/<?php echo $siteid_profile;?>/theme/<?php echo $theme_profile;?>"></iframe>
        
<?php return ob_get_clean();
		}
		
		/*Get all the given data for eBay Feedback*/
		 function ebay_feedback(){
		ob_start();	 
		global $wpdb;
		$userid_feedback=get_post_meta( get_the_ID(), 'feedback_userid', true );
		$siteid_feedback=get_post_meta( get_the_ID(), 'feedback_siteid', true );
		$theme_feedback=get_post_meta( get_the_ID(), 'Feedback_theme', true );
		$entries_feedback=get_post_meta( get_the_ID(), 'FeedbackEntries', true );
		$type_feedback=get_post_meta( get_the_ID(), 'Feedback_type', true );
		$blankid_feedback=get_post_meta( get_the_ID(), 'Feedback_blank_id', true );
				
		if($theme_feedback=='profile_table'){
			$theme_feedback  ="profiletable";
			}
		
		?>
 <script type="text/javascript" src="//www.myauctioncreator.com/feedback_build/js/SellerID/<?php echo $userid_feedback;?>/siteid/<?php echo $siteid_feedback;?>/limit/<?php echo $entries_feedback;?>/type/<?php echo $type_feedback;?>/theme/<?php echo $theme_feedback;?>/blank/<?php echo $blankid_feedback;?>"></script>
<div id="auction-creator-feedback" class="auction-creator"><a href="http://www.myauctioncreator.com/">eBay Feedback by My Auction Creator</a></div>
        

<?php return ob_get_clean();
		}
	}
	


new myAuctionCreator();
