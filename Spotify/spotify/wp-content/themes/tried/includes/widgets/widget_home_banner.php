<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_banner extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_home_banner', 'Tried Home Banner',
			array(
				'classname' => 'widget_home_banner',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array('subtitle' => '', 'title' => '', 'content' => '', 'readmore' => 'Xem thêm', 'link_readmore' => '', 'talkus' => '');
        $instance = wp_parse_args($instance, $defaults);
		$subtitle = $instance['subtitle'];
		$title = $instance['title'];
		$content = $instance['content'];
		$readmore = $instance['readmore'];
		$link_readmore = $instance['link_readmore'];
		$talkus = $instance['talkus'];
		echo $args['before_widget'];
			?>
			<section id="section-<?php echo $args['widget_id']; ?>" class="section-home-banner">
				<div class="section-wrapper margin-auto">
                	<div class="wrapper">
                        <h4 class="subtitle"><?php echo $subtitle; ?></h4>
                        <h3 class="title"><?php echo $title; ?></h3>
                        <p class="content"><?php echo $content; ?></p>
						<div class="more">
							<a href="<?php echo $link_readmore; ?>" class="readmore"><i class="far fa-shield-alt"></i><?php echo $readmore; ?></a>
							<?php if (!empty($link_readmore)) : ?>
								<a href="tel:<?php echo $talkus; ?>" class="talkus">Gọi chúng tôi: <strong><?php echo $talkus; ?></strong></a>
							<?php endif; ?>
						</div>
                    </div>
				</div>
			</section>
            <?php
		echo $args['after_widget'];
    }
	
    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['subtitle'] = ($new_instance['subtitle']);
		$instance['title'] = ($new_instance['title']);
		$instance['content'] = ($new_instance['content']);
		$instance['readmore'] = ($new_instance['readmore']);
		$instance['link_readmore'] = ($new_instance['link_readmore']);
		$instance['talkus'] = ($new_instance['talkus']);
        return $instance;
    }

    function form($instance) {
	    $defaults = array('subtitle' => '', 'title' => '', 'content' => '', 'readmore' => 'Xem thêm', 'link_readmore' => '', 'talkus' => '');
        $instance = wp_parse_args($instance, $defaults);
		?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('subtitle')); ?>"><?php esc_html_e('Tiêu đề phụ', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['subtitle']); ?>" name="<?php echo esc_attr($this->get_field_name('subtitle')); ?>" id="<?php echo esc_attr($this->get_field_id('subtitle')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Tiêu đề', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php esc_html_e('Nội dung', ''); ?></label>
				<textarea class="widefat" rows="6" name="<?php echo esc_attr($this->get_field_name('content')); ?>" id="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php echo esc_attr($instance['content']); ?></textarea>
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('readmore')); ?>"><?php esc_html_e('Xem thêm', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['readmore']); ?>" name="<?php echo esc_attr($this->get_field_name('readmore')); ?>" id="<?php echo esc_attr($this->get_field_id('readmore')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('link_readmore')); ?>"><?php esc_html_e('Link xem thêm', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['link_readmore']); ?>" name="<?php echo esc_attr($this->get_field_name('link_readmore')); ?>" id="<?php echo esc_attr($this->get_field_id('link_readmore')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('talkus')); ?>"><?php esc_html_e('Gọi chúng tôi', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['talkus']); ?>" name="<?php echo esc_attr($this->get_field_name('talkus')); ?>" id="<?php echo esc_attr($this->get_field_id('talkus')); ?>" />
			</p>
   		<?php
    }
}