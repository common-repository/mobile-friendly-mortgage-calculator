<?php

/*
 Plugin Name:  Mobile Friendly Mortgage Calculator
 Plugin URI:   https://mortgage-advice-online.org/mortgage-calculator-widget
 Description:  Mortgage Calculator with Extra Payments
 Version:      1.0
 Author:       Mortgage Calculator
 Author URI:   https://mortgage-advice-online.org
 */

class Maocalc_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'maocalc_widget', // Base ID
			esc_html__( 'Mobile Friendly Mortgage Calculator', 'maocalc_text_domain' ), // Name
			array( 'description' => esc_html__( 'Mortgage Calculator with Extra Payments', 'maocalc_text_domain' ), ) // Args
		);
	}
	
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		
		$theme              = empty( $instance['theme'] ) ? 'theme1': $instance['theme'];
		$labels_location    = empty( $instance['labels-location'] ) ? 'vertical1': $instance['labels-location'];
		$width              = empty( $instance['width'] ) ? 'mcw-wrap_250' : $instance['width'];
		$popup              = empty( $instance['popup'] ) ? 'doughnutPopup' : $instance['popup'];
		$showPopup          = $instance['popup'] !== 'none' ? 'true' : 'false';
		
		
						
		wp_enqueue_script( 'tether', maocalc_resolve_url('tether.min.js' ), null, '1.4.4', true );
		wp_enqueue_script( 'select', maocalc_resolve_url('select.min.js' ), null, '1.1.1', true );
		wp_enqueue_script( 'vex',    maocalc_resolve_url('vex.js' ), null, '4.1.0', true );
		wp_enqueue_script( 'chart',  maocalc_resolve_url('chart.js' ), null, '2.7.2', true );
		
		echo "<div id='mcwWidget'></div>";
		
		echo "<script type=\"text/javascript\">\r\n";
		
		echo "var maoCalc={};
		  maoCalc.settings={'theme':'$theme',
							'view':'$labels_location',
							'responsive':'$width',
							'font':'Open Sans, Helvetica, Arial, sans-serif',
							'border':true,
							'boxShadow':'0px 0px 55px 6px rgba(150, 150, 150, 0.2)',
							'fieldColor':'#fff',
							'textColor':'#334356',
							'borderColor':'#dde2e5',
							'currency':'$',
							'currencySide':'left',
							'popup': $showPopup,
							'popupView':'$popup',
							'style':true,
							'widgetTotalInterest':true,
							'widgetTotalPrincipal':true,
							'monthlyPayment':'Monthly Payment',
							'totalPrincipalPaid':'Total Principal',
							'totalInterestPaid':'Total Interest',
							'totalPayments':'Total Payments',
							'years':'years',
							'title':{'enabled':true,'color':'#334356','label':'Mortgage Calculator'},
							'homePrice':{'label':'Home Price','value':'350,000'},
							'downPayment':{'enabled':true,'label':'Down Payment','value':'52,000'},
							'interestRate':{'label':'Interest Rate','value':'4.05'},
							'mortgageTerm':{'label':'Mortgage Term','value':'30'},
							'pmi':{'enabled':true,'label':'PMI','value':'1,881.24'},
							'taxes':{'enabled':true,'label':'Taxes','value':'4,375'},
							'insurance':{'enabled':true,'label':'Insuranse','value':'1,225'},
							'hoa':{'enabled':true,'label':'HOA','value':'0'},
							'extra':{'enabled':true,'labelAdd':'Add extra payments','labelRemove':'Remove extra payments','labelToMonthy':'To monthly','labelYearly':'Extra yearly'},
							'startDate':{'enabled':true,'label':'Start date'},
							'monthsArr':['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
							'button':{'color':'#fff','bg':'#09f','label':'Calculate'}};";
		echo "</script>\r\n";
		wp_enqueue_script( 'maocalc-widget-script', maocalc_resolve_url('mao-calc-widget.js'), null, '0.1', true );
				
		echo $args['after_widget'];
	}	

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
	    
		?>
		<p>
		
		<label for="<?php echo esc_attr( $this->get_field_id( 'theme' ) ); ?>"><?php esc_attr_e( 'Theme:', 'maocalc_text_domain' ); ?></label>		
        <select id="<?php echo $this->get_field_id('theme'); ?>" name="<?php echo $this->get_field_name('theme'); ?>" class="widefat" style="width:100%;">
            <option <?php selected( $instance['theme'], 'theme1'); ?> value="theme1">Theme 1</option>
            <option <?php selected( $instance['theme'], 'theme3'); ?> value="theme3">Theme 2</option> 
            <option <?php selected( $instance['theme'], 'theme4'); ?> value="theme4">Theme 3</option>
            <option <?php selected( $instance['theme'], 'theme5'); ?> value="theme5">Theme 4</option>   
        </select>		
		</p>
		
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'labels-location' ) ); ?>"><?php esc_attr_e( 'Labels location:', 'maocalc_text_domain' ); ?></label>
        <select id="<?php echo $this->get_field_id('labels-location'); ?>" name="<?php echo $this->get_field_name('labels-location'); ?>" class="widefat" style="width:100%;">
            <option <?php selected( $instance['labels-location'], 'vertical1'); ?> value="vertical1">Left</option>
            <option <?php selected( $instance['labels-location'], 'vertical2'); ?> value="vertical2">Top</option> 
        </select>		
		</p>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>"><?php esc_attr_e( 'Width:', 'maocalc_text_domain' ); ?></label>
        <select id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" class="widefat" style="width:100%;">
            <option <?php selected( $instance['width'], 'mcw-wrap_250'); ?> value="mcw-wrap_250">250px</option>
            <option <?php selected( $instance['width'], 'mcw-wrap_200'); ?> value="mcw-wrap_200">200px</option>
            <option <?php selected( $instance['width'], 'mcw-wrap_responsive'); ?> value="mcw-wrap_responsive">Responsive</option> 
        </select>		
		</p>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'popup' ) ); ?>"><?php esc_attr_e( 'Popup:', 'maocalc_text_domain' ); ?></label>
        <select id="<?php echo $this->get_field_id('popup'); ?>" name="<?php echo $this->get_field_name('popup'); ?>" class="widefat" style="width:100%;">
            <option <?php selected( $instance['popup'], 'doughnutPopup'); ?> value="doughnutPopup">Pie chart</option>
            <option <?php selected( $instance['popup'], 'barPopup'); ?> value="barPopup">Bar chart</option>
            <option <?php selected( $instance['popup'], 'none'); ?> value="none">None</option>
        </select>		
		</p>
		
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title']            = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['theme']            = ( ! empty( $new_instance['theme'] ) ) ? sanitize_text_field( $new_instance['theme'] ) : '';
		$instance['labels-location']  = ( ! empty( $new_instance['labels-location'] ) ) ? sanitize_text_field( $new_instance['labels-location'] ) : '';
		$instance['width']            = ( ! empty( $new_instance['width'] ) ) ? sanitize_text_field( $new_instance['width'] ) : '';
		$instance['popup']            = ( ! empty( $new_instance['popup'] ) ) ? sanitize_text_field( $new_instance['popup'] ) : '';
		
		return $instance;
	}
} 

function register_maocalc_widget() {
    register_widget( 'maocalc_widget' );
}

add_action( 'widgets_init', 'register_maocalc_widget' );


function maocalc_resolve_url($url, $lang = 'en') {
    return plugins_url($lang."/".$url, __FILE__);
}