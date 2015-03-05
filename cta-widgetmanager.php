<?php
/**
 * Plugin Name: OrbitCarrot CTA Widget Manager
 * Plugin URI: http://orbitcarrot.com/cta-manager-wordpress-plugin/
 * Description: Create CTA widgets easily.
 * Version: 1.0
 * Author: OrbitCarrot
 * Author URI: http://orbitcarrot.com/
 */
/* Are you sure you want to be in here? Do you have magic developer powers? If not move along... */

/* WIDGET CTA CODE */

function ocarrot_styles_with_the_lot()
{
    wp_register_style( 'custom-style', plugins_url( '/css/styles.css', __FILE__ ), array(), '20120208', 'all' );
    wp_enqueue_style( 'custom-style' );
}
add_action( 'wp_enqueue_scripts', 'ocarrot_styles_with_the_lot' );


if (!class_exists('WidgetCta')):
    class WidgetCta extends WP_Widget
    {
        
        function WidgetCta()
        {
            // Instantiate the parent object
            parent::__construct('cta', __('OrbitCarrot Call To Action'), array(
                'description' => __('A CTA button widget which shows a CTA sidebar widget.')
            ));
        }
        
        
        function form($instance)
        {
            
            if ($instance) {
                $title      = ($instance['title']) ? esc_attr($instance['title']) : '';
                $text       = ($instance['text']) ? esc_attr($instance['text']) : '';
                $link       = ($instance['link']) ? esc_attr($instance['link']) : '';
                $background = ($instance['background']) ? esc_attr($instance['background']) : '';
            }
?>
			
<p>
  <label for="<?php echo $this->get_field_id('title');?>">
    <?php _e('Title:'); ?>
  </label>
  <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php
            echo $this->get_field_name('title');?>" value="<?php echo $title;?>" />
</p>

<p>
  <label for="<?php echo $this->get_field_id('text'); ?>">
    <?php _e('Text:'); ?>
  </label>
  <input type="text" class="widefat" id="<?php
            echo $this->get_field_id('text'); ?>" name="<?php
            echo $this->get_field_name('text'); ?>" value="<?php
            echo $text; ?>" />
</p>

<p>
  <label for="<?php
            echo $this->get_field_id('link'); ?>">
    <?php
            _e('Link:');
?>
  </label>
  <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php
            echo $this->get_field_name('link'); ?>" type="text" value="<?php
            echo $link; ?>" />
</p>

<p>
  <label for="<?php echo $this->get_field_id('background'); ?>">
    <?php _e('Background:'); ?>
  </label>
  <select id="<?php
            echo $this->get_field_id('background'); ?>" name="<?php
            echo $this->get_field_name('background'); ?>">
    <?php
            $backgrounds = array(
                'Red' => 'Red',
                'Blue' => 'Blue',
                'Green' => 'Green',
                'Purple' => 'Purple',
                'Royal Red' => 'Royal Red',
                'Royal Blue' => 'Royal Blue',
                'Unstyled' => 'Unstyled'
            );
            foreach ($backgrounds as $key => $bg):
                $selected = ($key == $background) ? ' selected="selected"' : '';
                echo '<option' . $selected . ' value="' . $key . '">' . $bg . '</option>';
            endforeach; ?>
  	</select>
</p>


<?php }
        
        function update($new_instance, $old_instance){
            
            $instance               = $old_instance;
            $instance['title']      = strip_tags($new_instance['title']);
            $instance['text']       = $new_instance['text'];
            $instance['background'] = strip_tags($new_instance['background']);
            $instance['link']       = strip_tags($new_instance['link']);
            return $instance;}
        
        
        function widget($args, $instance){
            
            $widget_title = apply_filters('widget_title', $instance['title']);
            $widget_text  = apply_filters('widget_text', $instance['text']);
            $link         = ($instance['link']) ? $instance['link'] : '#';
            
            $images = array(
                'Red' => array(
                    'src' => 'css/img/redbutton.png',
                    'name' => 'red'
                ),
                'Blue' => array(
                    'src' => 'css/img/bluebutton.png',
                    'name' => 'blue'
                ),
                'Green' => array(
                    'src' => 'css/img/greenbutton.jpg',
                    'name' => 'green'
                ),
                'Purple' => array(
                    'src' => 'css/img/purplebutton.jpg',
                    'name' => 'purple'
                ),
                'Royal Red' => array(
                    'src' => 'css/img/royalredbutton.jpg',
                    'name' => 'royalred'
                ),
                'Royal Blue' => array(
                    'src' => 'css/img/royalbluebutton.jpg',
                    'name' => 'royalblue'
                ),
                'Unstyled' => array(
                    'src' => 'css/img/unstyled.png'
                )
            );
            
            $base  = trailingslashit(get_template_directory_uri()) . 'images';
            $image = (array_key_exists($instance['background'], $images)) ? $instance['background'] : 'Red';
            echo $args['before_widget'];
            
?>
				
				
	<div class="panel" id="<?php
            echo $images[$image]['name']; ?>" style=" width: 320px!important; height: 140px!important; background:url(<?php echo $images[$image]['src']; ?>) <?php echo $images[$image]['position']; ?> no-repeat;"> <a href="<?php echo $link; ?>">
  	<h3 class="ctatitle"> <?php
            echo $widget_title;?></h3>
  	<h6 class="ctatext"><?php
            echo $widget_text;?></h6></a> 
  	</div>



  
<?php
            echo $args['after_widget'];
        }
    }
    
    function init_orbitcarrot_widgets()
    {
        register_widget('WidgetCta');
    }
    add_action('widgets_init', 'init_orbitcarrot_widgets');
endif;



?>