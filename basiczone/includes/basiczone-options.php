<?php
class basiczone_options {
	
	private $sections;
	private $checkboxes;
	private $settings;
	
	public function __construct() {
		
		$this->checkboxes = array();
		$this->settings = array();
		$this->get_option();
		
		$this->sections['general']      = __( 'General Settings', 'basiczone' );
		$this->sections['advertisement']   = __( 'Advertisement', 'basiczone' );
		$this->sections['social']   = __( 'Social Integrations', 'basiczone'  );
		$this->sections['reset']        = __( 'Reset to Defaults', 'basiczone' );
		
		add_action( 'admin_menu', array( &$this, 'add_pages' ) );
		add_action( 'admin_init', array( &$this, 'register_settings' ) );
		
		if ( ! get_option( 'basiczone_options' ) )
			$this->initialize_settings();
		
	}
	
	public function add_pages() {
		
		$admin_page = add_theme_page( __( 'basiczone Options', 'basiczone' ), __( 'basiczone Options', 'basiczone' ), 'manage_options', 'basiczone-options', array( &$this, 'display_page' ) );
		
		add_action( 'admin_print_scripts-' . $admin_page, array( &$this, 'scripts' ) );
		add_action( 'admin_print_styles-' . $admin_page, array( &$this, 'styles' ) );
		
	}
	
	public function create_setting( $args = array() ) {
		
		$defaults = array(
			'id'      => 'default_field',
			'title'   => __( 'Default Field', 'basiczone' ),
			'desc'    => __( 'This is a default description.', 'basiczone' ),
			'std'     => '',
			'type'    => 'text',
			'section' => 'general',
			'choices' => array(),
			'class'   => ''
		);
			
		extract( wp_parse_args( $args, $defaults ) );
		
		$field_args = array(
			'type'      => $type,
			'id'        => $id,
			'desc'      => $desc,
			'std'       => $std,
			'choices'   => $choices,
			'label_for' => $id,
			'class'     => $class
		);
		
		if ( $type == 'checkbox' )
			$this->checkboxes[] = $id;
		
		add_settings_field( $id, $title, array( $this, 'display_setting' ), 'basiczone-options', $section, $field_args );
	}
	
	public function display_page() {
		
		echo '<div class="wrap">
	<div class="icon32" id="icon-options-general"></div>
	<h2>' . __( 'basiczone Options', 'basiczone' ) . '</h2>';
	
		if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] == true )
			echo '<div class="updated fade"><p>' . __( 'Theme options updated.', 'basiczone' ) . '</p></div>';
		
		echo '<form action="options.php" method="post">';
	
		settings_fields( 'basiczone_options' );
		echo '<div class="ui-tabs">
			<ul class="ui-tabs-nav">';
		
		foreach ( $this->sections as $section_slug => $section )
			echo '<li><a href="#' . $section_slug . '">' . $section . '</a></li>';
		
		echo '</ul>';
		do_settings_sections( $_GET['page'] );
		
		echo '</div>
		<p class="submit"><input name="Submit" type="submit" class="button-primary" value="' . __( 'Save Changes', 'basiczone' ) . '" /></p>
		
	</form>';

	echo '<script type="text/javascript">
		jQuery(document).ready(function($) {
			var sections = [];';
			
			foreach ( $this->sections as $section_slug => $section )
				echo "sections['$section'] = '$section_slug';";
			
			echo 'var wrapped = $(".wrap h3").wrap("<div class=\"ui-tabs-panel\">");
			wrapped.each(function() {
				$(this).parent().append($(this).parent().nextUntil("div.ui-tabs-panel"));
			});
			$(".ui-tabs-panel").each(function(index) {
				$(this).attr("id", sections[$(this).children("h3").text()]);
				if (index > 0)
					$(this).addClass("ui-tabs-hide");
			});
			$(".ui-tabs").tabs({
				fx: { opacity: "toggle", duration: "fast" }
			});
			
			$("input[type=text], textarea").each(function() {
				if ($(this).val() == $(this).attr("placeholder") || $(this).val() == "")
					$(this).css("color", "#999");
			});
			
			$("input[type=text], textarea").focus(function() {
				if ($(this).val() == $(this).attr("placeholder") || $(this).val() == "") {
					$(this).val("");
					$(this).css("color", "#000");
				}
			}).blur(function() {
				if ($(this).val() == "" || $(this).val() == $(this).attr("placeholder")) {
					$(this).val($(this).attr("placeholder"));
					$(this).css("color", "#999");
				}
			});
			
			$(".wrap h3, .wrap table").show();
			
			// This will make the "warning" checkbox class really stand out when checked.
			// I use it here for the Reset checkbox.
			$(".warning").change(function() {
				if ($(this).is(":checked"))
					$(this).parent().css("background", "#c00").css("color", "#fff").css("fontWeight", "bold");
				else
					$(this).parent().css("background", "none").css("color", "inherit").css("fontWeight", "normal");
			});
			
			// Browser compatibility
			if ($.browser.mozilla) 
			         $("form").attr("autocomplete", "off");
		});
	</script>
</div>';
		
	}
	
	public function display_section() {

	}
	
	
	public function display_setting( $args = array() ) {
		
		extract( $args );
		
		$options = get_option( 'basiczone_options' );
		
		if ( ! isset( $options[$id] ) && $type != 'checkbox' )
			$options[$id] = $std;
		elseif ( ! isset( $options[$id] ) )
			$options[$id] = 0;
		
		$field_class = '';
		if ( $class != '' )
			$field_class = ' ' . $class;
		
		switch ( $type ) {
			
			case 'heading':
				echo '</td></tr><tr valign="top"><td colspan="2"><h4>' . $desc . '</h4>';
				break;
			
			case 'checkbox':
				
				echo '<input class="checkbox' . $field_class . '" type="checkbox" id="' . $id . '" name="basiczone_options[' . $id . ']" value="1" ' . checked( $options[$id], 1, false ) . ' /> <label for="' . $id . '">' . $desc . '</label>';
				
				break;
			
			case 'select':
			
					echo '<select class="select' . $field_class . '" name="basiczone_options[' . $id . ']">';

				foreach ( $choices as $value => $label )
					echo '<option value="' . esc_attr( $value ) . '"' . selected( $options[$id], $value, false ) . '>' . $label . '</option>';
				
				echo '</select>';
				
				if ( $desc != '' )
					echo '<br /><span class="description">' . $desc . '</span>';
				
				break;
			
			case 'radio':
				$i = 0;
				foreach ( $choices as $value => $label ) {
					echo '<input class="radio' . $field_class . '" type="radio" name="basiczone_options[' . $id . ']" id="' . $id . $i . '" value="' . esc_attr( $value ) . '" ' . checked( $options[$id], $value, false ) . '> <label for="' . $id . $i . '">' . $label . '</label>';
					if ( $i < count( $options ) - 1 )
						echo '<br />';
					$i++;
				}
				
				if ( $desc != '' )
					echo '<br /><span class="description">' . $desc . '</span>';
				
				break;
			
			case 'textarea':
				echo '<textarea class="' . $field_class . '" id="' . $id . '" name="basiczone_options[' . $id . ']" placeholder="' . $std . '" rows="10" cols="80">' . wp_htmledit_pre( $options[$id] ) . '</textarea>';
				
				if ( $desc != '' )
					echo '<br /><span class="description">' . $desc . '</span>';
				
				break;
			
			case 'password':
				echo '<input class="regular-text' . $field_class . '" type="password" id="' . $id . '" name="basiczone_options[' . $id . ']" value="' . esc_attr( $options[$id] ) . '" />';
				
				if ( $desc != '' )
					echo '<br /><span class="description">' . $desc . '</span>';
				
				break;
			
			case 'text':
			default:
		 		echo '<input class="regular-text' . $field_class . '" type="text" id="' . $id . '" name="basiczone_options[' . $id . ']" placeholder="' . $std . '" value="' . esc_attr( $options[$id] ) . '" />';
		 		
		 		if ( $desc != '' )
		 			echo '<br /><span class="description">' . $desc . '</span>';
		 		
		 		break;
		 	
		}
		
	}
	
	public function get_option() {
		
		/* General Settings
		===========================================*/

		$this->settings['custom_logo'] = array(
			'section' => 'general',
			'title'   => __( 'Custom Logo', 'basiczone' ),
			'desc'    => __( 'Enable Custom Logo Header?.', 'basiczone' ),
			'type'    => 'checkbox',
			'std'     => 0
		);

		$this->settings['header_logo'] = array(
			'section' => 'general',
			'title'   => __( 'Header Logo', 'basiczone' ),
			'desc'    => __( 'Enter the URL to your logo for the theme header.', 'basiczone' ),
			'type'    => 'text',
			'std'     => ''
		);
		
		$this->settings['favicon'] = array(
			'section' => 'general',
			'title'   => __( 'Favicon', 'basiczone' ),
			'desc'    => __( 'Enter the URL to your custom favicon. It should be 16x16 pixels in size.', 'basiczone' ),
			'type'    => 'text',
			'std'     => ''
		);

		$this->settings['target'] = array(
			'section' => 'general',
			'title'   => __( 'Select Target', 'basiczone' ),
			'desc'    => __( 'Select your Amazon site.', 'basiczone' ),
			'std'     => 0,
			'type'    => 'radio',
			'choices' => array(
				0 => 'Amazon.com (default)',
				1 => 'Amazon.de',
				2 => 'Amazon.co.uk',
			)
		);

		$this->settings['trackingcom'] = array(
			'section' => 'general',
			'title'   => __( 'Amazon.com tracking ID', 'basiczone' ),
			'desc'    => __( 'Enter your AMAZON.COM Tracking ID.', 'basiczone' ),
			'type'    => 'text',
			'std'     => ''
		);

		$this->settings['trackingde'] = array(
			'section' => 'general',
			'title'   => __( 'Amazon.de tracking ID', 'basiczone' ),
			'desc'    => __( 'Enter your AMAZON.DE Tracking ID.', 'basiczone' ),
			'type'    => 'text',
			'std'     => ''
		);

		$this->settings['trackingcouk'] = array(
			'section' => 'general',
			'title'   => __( 'Amazon.co.uk tracking ID', 'basiczone' ),
			'desc'    => __( 'Enter your AMAZON.CO.UK Tracking ID.', 'basiczone' ),
			'type'    => 'text',
			'std'     => ''
		);
		
		$this->settings['style'] = array(
			'section' => 'general',
			'title'   => __( 'Select Theme', 'basiczone' ),
			'desc'    => __( 'Select your Theme scheme.', 'basiczone' ),
			'std'     => 0,
			'type'    => 'radio',
			'choices' => array(
				0 => 'Red (default)',
				1 => 'Blue',
				2 => 'Green',
			)
		);
		
		$this->settings['analytics_code'] = array(
			'title'   => __( 'Analytics', 'basiczone' ),
			'desc'    => __( 'Enter any analytic code eg. Google Analytics, Histats, etc.', 'basiczone' ),
			'std'     => '',
			'type'    => 'textarea',
			'section' => 'general',
			'class'   => 'code'
		);		


		/* Advertisement
		===========================================*/

		$this->settings['ads_300'] = array(
			'section' => 'advertisement',
			'title'   => __( 'Advertisement Code 300x250', 'basiczone' ),
			'desc'    => __( 'Insert your 300x250 ads code here', 'basiczone' ),
			'type'    => 'textarea',
			'std'     => ''
		);


		$this->settings['ads_336'] = array(
			'section' => 'advertisement',
			'title'   => __( 'Advertisement Code 336x280', 'basiczone' ),
			'desc'    => __( 'Insert your 336x280 ads code here', 'basiczone' ),
			'type'    => 'textarea',
			'std'     => ''
		);

		$this->settings['ads_728'] = array(
			'section' => 'advertisement',
			'title'   => __( 'Advertisement Code 728x90', 'basiczone' ),
			'desc'    => __( 'Insert your 728x90 ads code here', 'basiczone' ),
			'type'    => 'textarea',
			'std'     => ''
		);

		$this->settings['ads_468'] = array(
			'section' => 'advertisement',
			'title'   => __( 'Advertisement Code 468x60', 'basiczone' ),
			'desc'    => __( 'Insert your 468x60 ads code here', 'basiczone' ),
			'type'    => 'textarea',
			'std'     => ''
		);

		/* Social Integration
		===========================================*/		

		$this->settings['fb_code'] = array(
			'title'   => __( 'Facebook SDK', 'basiczone'  ),
			'desc'    => __( 'Enter your Facebook SDK Javascript here to support Facebook Plugin. Required for All Facebook Plugin Features.', 'basiczone'  ),
			'std'     => '',
			'type'    => 'textarea',
			'section' => 'social',
			'class'   => 'code'
		);		

		$this->settings['fb_comment'] = array(
			'title'   => __( 'Enable Facebook Comments?', 'basiczone'  ),
			'desc'    => __( 'If you choose Yes, then facebook comment form will appear on single post', 'basiczone'  ),
			'std'     => 0,
			'type'    => 'radio',
			'section' => 'social',
			'choices' => array(
				0 => 'No (default)',
				1 => 'Yes',
			)
		);		

		$this->settings['fb_like'] = array(
			'title'   => __( 'Enable Facebook Like Box?', 'basiczone'  ),
			'desc'    => __( 'Will appear on top of sidebar, please fill URL to like below', 'basiczone'  ),
			'std'     => 0,
			'type'    => 'radio',
			'section' => 'social',
			'choices' => array(
				0 => 'No (default)',
				1 => 'Yes',
			)
		);
		
		$this->settings['fb_page'] = array(
			'section' => 'social',
			'title'   => __( 'Facebook URL', 'basiczone' ),
			'desc'    => __( 'Enter the URL of your Facebook Page to like.', 'basiczone' ),
			'type'    => 'text',
			'std'     => ''
		);

		$this->settings['soc_button'] = array(
			'title'   => __( 'Enable Social Sharing Button?', 'basiczone'  ),
			'desc'    => __( 'If you choose Yes, then social sharing button will appear on single post', 'basiczone'  ),
			'std'     => 0,
			'type'    => 'radio',
			'section' => 'social',
			'choices' => array(
				0 => 'No (default)',
				1 => 'Yes',
			)
		);		
				
		/* Reset
		===========================================*/
		
		$this->settings['reset_theme'] = array(
			'section' => 'reset',
			'title'   => __( 'Reset theme', 'basiczone' ),
			'type'    => 'checkbox',
			'std'     => 0,
			'class'   => 'warning', // Custom class for CSS
			'desc'    => __( 'Check this box and click "Save Changes" below to reset theme options to their defaults.', 'basiczone' )
		);
		
	}
	
	public function initialize_settings() {
		
		$default_settings = array();
		foreach ( $this->settings as $id => $setting ) {
			if ( $setting['type'] != 'heading' )
				$default_settings[$id] = $setting['std'];
		}
		
		update_option( 'basiczone_options', $default_settings );
		
	}
	
	public function register_settings() {
		
		register_setting( 'basiczone_options', 'basiczone_options', array ( &$this, 'validate_settings' ) );
		
		foreach ( $this->sections as $slug => $title ) {
			if ( $slug == 'about' )
				add_settings_section( $slug, $title, array( &$this, 'display_about_section' ), 'basiczone-options' );
			else
				add_settings_section( $slug, $title, array( &$this, 'display_section' ), 'basiczone-options' );
		}
		
		$this->get_option();
		
		foreach ( $this->settings as $id => $setting ) {
			$setting['id'] = $id;
			$this->create_setting( $setting );
		}
		
	}
	
	public function scripts() {
		wp_print_scripts( 'jquery-ui-tabs' );
	}
	
	public function styles() {
		wp_register_style( 'basiczone-admin', get_stylesheet_directory_uri() . '/includes/xstyles.css' );
		wp_enqueue_style( 'basiczone-admin' );
	}
	
	public function validate_settings( $input ) {
		
		if ( ! isset( $input['reset_theme'] ) ) {
			$options = get_option( 'basiczone_options' );
			
			foreach ( $this->checkboxes as $id ) {
				if ( isset( $options[$id] ) && ! isset( $input[$id] ) )
					unset( $options[$id] );
			}
			
			return $input;
		}
		return false;
		
	}
	
}

$theme_options = new basiczone_options();

function generator() {
	$cr = get_template_directory_uri() . '/images/bse.png';
	$as = get_template_directory_uri() . '/images/assoc.png';
	$pt = get_template_directory_uri() . '/images/partner.png';
	$com = basiczone_option( 'trackingcom' );
	$de = basiczone_option( 'trackingde' );
	$couk = basiczone_option( 'trackingcouk' );

	echo '<div id="site-generator">
			<ul>';

	if (basiczone_option( 'target' ) =='0') {
		echo '<li class="wp"><a href="' . esc_url( __( 'http://www.amazon.com/?_encoding=UTF8&tag=' . $com . '&linkCode=ur2&camp=1789&creative=390957', 'basiczone' ) ) . '" rel="nofollow"><img src="'.$as.'" alt="Amazon Associates" title="Amazon Associates"  width="175" height="29" /></a></li>';
	} elseif (basiczone_option( 'target' ) =='1') {
		echo '<li class="wp"><a href="' . esc_url( __( 'http://www.amazon.de/?_encoding=UTF8&site-redirect=de&tag=' . $de . '&linkCode=ur2&camp=1638&creative=19454', 'basiczone' ) ) . '" rel="nofollow"><img src="'.$pt.'" alt="Amazon PartnerNet" title="Amazon PartnerNet"  width="175" height="25" /></a></li>';
	} else {
		echo '<li class="wp"><a href="' . esc_url( __( 'http://www.amazon.co.uk/?_encoding=UTF8&tag=' . $couk . '&linkCode=ur2&camp=1634&creative=19450', 'basiczone' ) ) . '" rel="nofollow"><img src="'.$as.'" alt="Amazon Associates" title="Amazon Associates"  width="175" height="29" /></a></li>';
	}			
		echo '<li class="cr"><a href="' . esc_url( __( 'http://themestore.info/', 'basiczone' ) ) . '">
<img src="'.$cr.'" alt="Amazon Store Wordpress Theme" title="Amazon Store Wordpress Theme" width="74" height="29" /></a></li>
			</ul>
		</div>

				<div class="clear"></div>
		<div class="disclosure">		
		<p>' . __( 'The brand, logo and product names are trademarks of their respective companies. If we create a link to a product in a review, sometimes we may get paid a commission if a visitor to our site purchases the product. For more details, please see our Disclosure Policy.', 'basiczone' ) . '</p>
		</div>
		</footer>';
}

?>