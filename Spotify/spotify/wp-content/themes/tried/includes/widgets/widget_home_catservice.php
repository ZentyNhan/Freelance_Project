<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_catservice extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_home_catservice', 'Tried Home Cat Service',
			array(
				'classname' => 'widget_home_catservice',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array('title' => 'Danh mục dịch vụ', 'description' => '');
        $instance = wp_parse_args($instance, $defaults);
		$title = $instance['title'];
		$description = $instance['description'];
        $categories = get_terms([
            'taxonomy' => 'dich-vu_cat',
            'hide_empty' => false,
        ]);
		echo $args['before_widget'];
		?>
			<section id="section-<?php echo $args['widget_id']; ?>" class="section-home-catservice">
                <div class="pattern-layer" style="background-image: url('<?php echo get_theme_file_uri( "/assets/img/pattern-1.png" ); ?>');"></div>
				<div class="separater separater-block mwidth-main margin-auto"></div>
				<h4 class="section-title"><?php echo $args['before_title'].$title.$args['after_title']; ?></h4>
				<?php if (!empty($description)) : ?>
					<p class="section-description"><?php echo $description; ?></p>
				<?php endif; ?>
				<div class="section-wrapper margin-auto">
                    <div class="categories">
                        <?php
                            if(!empty($categories)) :
                                foreach($categories as $key => $category) :
                                    $image = get_theme_file_uri( "/assets/img/placeholder.png" );
                                    if (!empty(get_term_meta( $category->term_id, 'dich-vu_cat_image', true ))) {
                                        $image = get_term_meta( $category->term_id, 'dich-vu_cat_image', true );
                                    }
                                    $icon = 'fas fa-home';
                                    if (!empty(get_term_meta( $term->term_id, 'dich-vu_cat_icon', true ))) {
                                        $icon = get_term_meta( $term->term_id, 'dich-vu_cat_icon', true );
                                    }
                        ?>
                                    <div class="catservice-item">
                                        <div class="wrap">
                                            <div class="featured-image">
                                                <a href="<?php echo get_permalink($category->term_id); ?>" title=""><img src="<?php echo $image; ?>" alt=""></a>
                                            </div>
                                            <div class="box-contain">
                                                <h5 class="title"><i class="icon <?php echo $icon; ?>"></i><?php echo $category->name; ?></h5>
                                                <p class="content"><?php echo $category->description; ?></p>
                                            </div>
                                        </div>
                                    </div>
                        <?php 
                                endforeach;
                            endif;
                        ?>
                    </div>
				</div>
			</section>
        <?php
		echo $args['after_widget'];
    }

    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['title'] = ($new_instance['title']);
		$instance['description'] = ($new_instance['description']);
        return $instance;
    }

    function form($instance) {
	    $defaults = array('title' => 'Danh mục dịch vụ', 'description' => '');
        $instance = wp_parse_args($instance, $defaults);
		?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Tiêu đề', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('description')); ?>"><?php esc_html_e('Mô tả', ''); ?></label>
				<textarea class="widefat" rows="4" name="<?php echo esc_attr($this->get_field_name('description')); ?>" id="<?php echo esc_attr($this->get_field_id('description')); ?>"><?php echo esc_attr($instance['description']); ?></textarea>
			</p>
		<?php
    }
}
