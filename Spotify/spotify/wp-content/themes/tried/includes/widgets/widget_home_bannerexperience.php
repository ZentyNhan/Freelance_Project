<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_bannerexperience extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_home_bannerexperience', 'Tried Home Banner Experience',
			array(
				'classname' => 'widget_home_bannerexperience',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array('title' => '', 'content' => '');
        $instance = wp_parse_args($instance, $defaults);
		$title = $instance['title'];
		$content = $instance['content'];
		$skills = get_field('skills','widget_'.$args['widget_id']);
		$image = get_field('image','widget_'.$args['widget_id']);
        if (empty($image)) {
            $image = get_theme_file_uri( "/assets/img/placeholder.png" );
        }
		echo $args['before_widget'];
			?>
			<section id="section-<?php echo $args['widget_id']; ?>" class="section-home-bannerexperience">
				<div class="section-wrapper margin-auto">
                	<div class="skill-block">
                        <div class="inner-box">
                            <h3 class="title"><?php echo $title; ?></h3>
                            <p class="content"><?php echo $content; ?></p>
                            <div class="skills">
                                <?php if (!empty($skills['skill_1']['name'])) :?>
                                    <div class="skill-item">
                                        <div class="header">
                                            <h5 class="name"><?php echo $skills['skill_1']['name']; ?></h5>
                                            <span class="percentage"><?php echo $skills['skill_1']['percentage']; ?>%</span>
                                        </div>
                                        <div class="bar">
                                            <div class="process" data-width="<?php echo $skills['skill_1']['percentage']; ?>" style="width: <?php echo $skills['skill_1']['percentage']; ?>%;"></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($skills['skill_2']['name'])) :?>
                                    <div class="skill-item">
                                        <div class="header">
                                            <h5 class="name"><?php echo $skills['skill_2']['name']; ?></h5>
                                            <span class="percentage"><?php echo $skills['skill_2']['percentage']; ?>%</span>
                                        </div>
                                        <div class="bar">
                                            <div class="process" data-width="<?php echo $skills['skill_2']['percentage']; ?>" style="width: <?php echo $skills['skill_2']['percentage']; ?>%;"></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($skills['skill_3']['name'])) :?>
                                    <div class="skill-item">
                                        <div class="header">
                                            <h5 class="name"><?php echo $skills['skill_3']['name']; ?></h5>
                                            <span class="percentage"><?php echo $skills['skill_3']['percentage']; ?>%</span>
                                        </div>
                                        <div class="bar">
                                            <div class="process" data-width="<?php echo $skills['skill_3']['percentage']; ?>" style="width: <?php echo $skills['skill_3']['percentage']; ?>%;"></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="icons-box">
                            <span class="far fa-broadcast-tower"></span>
                            <span class="fas fa-fingerprint"></span>
                            <span class="fas fa-key"></span>
                        </div>
                    </div>
                    <div class="image-block">
                        <img src="<?php echo $image; ?>" alt="">
                    </div>
				</div>
			</section>
            <?php
		echo $args['after_widget'];
    }
	
    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['title'] = ($new_instance['title']);
		$instance['content'] = ($new_instance['content']);
        return $instance;
    }

    function form($instance) {
	    $defaults = array('title' => '', 'content' => '');
        $instance = wp_parse_args($instance, $defaults);
		?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Tiêu đề', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php esc_html_e('Nội dung', ''); ?></label>
				<textarea class="widefat" rows="6" name="<?php echo esc_attr($this->get_field_name('content')); ?>" id="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php echo esc_attr($instance['content']); ?></textarea>
			</p>
   		<?php
    }
}