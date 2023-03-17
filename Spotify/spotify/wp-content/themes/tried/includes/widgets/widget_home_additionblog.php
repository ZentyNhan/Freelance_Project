<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_additionblog extends WP_Widget {
	function __construct() {
		parent::__construct(
			'widget_home_additionblog', 'Tried Home Addition Blog',
			array(
				'classname' => 'widget_home_additionblog',
				'description' => esc_html__('Bài viết mở rộng', ''),
				'customize_selective_refresh' => true
			)
		);
	}

	function widget($args, $instance) {
		$defaults = array(
            'blog_title' => __('Bài viết nổi bật', 'tried'), 'blog_limit' => 6, 'blog_viewmore' => '',
            'form_title' => __('Liên hệ', 'tried'), 'form_subtitle' => __('Đăng ký nhận tin', 'tried'), 'form_id' => '',
            'banner_title' => __('Giới thiệu',' tried'), 'banner_content' => '', 'banner_link' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
        wp_enqueue_style( 'tried-form-wpcf7' );
		$blog_title = $instance['blog_title'];
		$blog_limit = $instance['blog_limit'];
		$blog_viewmore = $instance['blog_viewmore'];
		$form_title = $instance['form_title'];
		$form_subtitle = $instance['form_subtitle'];
		$form_id = $instance['form_id'];
		$banner_title = $instance['banner_title'];
		$banner_content = $instance['banner_content'];
		$banner_link = $instance['banner_link'];
        $posts = get_posts(array (
            'post_type' => 'post',
            'orderby' => 'date',
            'order'=> 'DESC', 
            'post_status' => 'publish',
            'posts_per_page' => 6
        ));
		echo $args['before_widget'];
		?>
		<section id="section-<?php echo $args['widget_id']; ?>" class="section-home-additionblog">
			<div class="section-wrapper">
                <div class="col-item">
                    <div class="addblog-block">
                        <h4 class="title-highlight"><span><?php echo $blog_title; ?></span></h4>
                        <div class="addblogs">
                            <?php
                                if (!empty($posts)) :
                                    foreach ($posts as $post) :
                                        get_template_part('template-parts/blog-item/item', 'addition', array( 'id' => $post->ID ) );
                                    endforeach;
                                endif;
                            ?>
                        </div>
                        <div class="viewmore">
                            <a href="<?php echo $blog_viewmore; ?>"><?php _e('Xem thêm', 'tried'); ?></a>
                        </div>
                    </div>
                </div>
                <div class="col-item">
					<?php if (!empty($form_id)) : ?>
                        <div class="addform-block">
                            <h4 class="title-highlight"><span><?php echo $form_title; ?></span></h4>
                            <h5 class="form-subtitle"><?php echo $form_subtitle; ?></h5>
                            <div class="form-wrap">
                                <?php echo do_shortcode('[contact-form-7 id="'.$form_id.'"]'); ?>
                            </div>
                        </div>
					<?php endif; ?>
                    <div class="addbanner-block">
                        <h4 class="title-highlight"><span><?php echo $banner_title; ?></span></h4>
                        <a href="<?php echo $banner_link; ?>" title="">
                            <div class="banner"><?php echo $banner_content; ?></div>
                        </a>
                    </div>
                </div>
			</div>
		</section>
		<?php
		echo $args['after_widget'];
	}

	function update($new_instance, $old_instance) {
		$instance = array();
		$instance['blog_title'] = $new_instance['blog_title'];
		$instance['blog_limit'] = $new_instance['blog_limit'];
		$instance['blog_viewmore'] = $new_instance['blog_viewmore'];
		$instance['form_title'] = $new_instance['form_title'];
		$instance['form_subtitle'] = $new_instance['form_subtitle'];
		$instance['form_id'] = $new_instance['form_id'];
		$instance['banner_title'] = $new_instance['banner_title'];
		$instance['banner_content'] = $new_instance['banner_content'];
		$instance['banner_link'] = $new_instance['banner_link'];
		return $instance;
	}

	function form($instance) {
		$defaults = array(
            'blog_title' => __('Bài viết nổi bật', 'tried'), 'blog_limit' => 6, 'blog_viewmore' => '',
            'form_title' => __('Liên hệ', 'tried'), 'form_subtitle' => __('Đăng ký nhận tin', 'tried'), 'form_id' => '',
            'banner_title' => __('Giới thiệu',' tried'), 'banner_content' => '', 'banner_link' => ''
        );
		$instance = wp_parse_args($instance, $defaults);
        $cf7 = get_posts(array(
            'post_type'     => 'wpcf7_contact_form',
            'numberposts'   => -1
        ));
		?>
            <h5><?php echo esc_html_e('Phần bài viết', 'tried'); ?></h5>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('blog_title')); ?>"><?php esc_html_e('Tiêu đề', 'tried'); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['blog_title']); ?>" name="<?php echo esc_attr($this->get_field_name('blog_title')); ?>" id="<?php echo esc_attr($this->get_field_id('blog_title')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('blog_limit')); ?>"><?php esc_html_e('Số lượng', 'tried'); ?></label>
				<input class="widefat" type="number" value="<?php echo esc_attr($instance['blog_limit']); ?>" name="<?php echo esc_attr($this->get_field_name('blog_limit')); ?>" id="<?php echo esc_attr($this->get_field_id('blog_limit')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('blog_viewmore')); ?>"><?php esc_html_e('Xem thêm', 'tried'); ?></label>
				<input class="widefat" type="number" value="<?php echo esc_attr($instance['blog_viewmore']); ?>" name="<?php echo esc_attr($this->get_field_name('blog_viewmore')); ?>" id="<?php echo esc_attr($this->get_field_id('blog_viewmore')); ?>" />
			</p>
            <h5><?php echo esc_html_e('Phần Form', 'tried'); ?></h5>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('form_title')); ?>"><?php esc_html_e('Tiêu đề', 'tried'); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['form_title']); ?>" name="<?php echo esc_attr($this->get_field_name('form_title')); ?>" id="<?php echo esc_attr($this->get_field_id('form_title')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('form_subtitle')); ?>"><?php esc_html_e('Tiêu đề phụ', 'tried'); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['form_subtitle']); ?>" name="<?php echo esc_attr($this->get_field_name('form_subtitle')); ?>" id="<?php echo esc_attr($this->get_field_id('form_subtitle')); ?>" />
			</p>
			<?php if (!empty($cf7)) : ?>
                <p>
                    <label for="<?php echo esc_attr($this->get_field_id('form_id')); ?>"><?php esc_html_e('Form', 'tried'); ?></label>
                    <select id="<?php echo esc_attr($this->get_field_id('form_id')); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name('form_id')); ?>" style="margin-top: 15px;">
						<?php foreach ($cf7 as $it_7) : ?>
							<option value="<?php echo $it_7->ID?>" <?php selected($it_7->ID, $instance['form_id']); ?>><?php echo $it_7->post_title; ?></option>
						<?php endforeach; ?>
                    </select>
                </p>
			<?php endif; ?>
            <h5><?php echo esc_html_e('Phần Banner', 'tried'); ?></h5>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('banner_title')); ?>"><?php esc_html_e('Tiêu đề', 'tried'); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['banner_title']); ?>" name="<?php echo esc_attr($this->get_field_name('banner_title')); ?>" id="<?php echo esc_attr($this->get_field_id('banner_title')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('banner_content')); ?>"><?php esc_html_e('Nội dung', ''); ?></label>
				<textarea class="widefat" rows="3" name="<?php echo esc_attr($this->get_field_name('banner_content')); ?>" id="<?php echo esc_attr($this->get_field_id('banner_content')); ?>"><?php echo esc_attr($instance['banner_content']); ?></textarea>
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('banner_link')); ?>"><?php esc_html_e('Liên kết', 'tried'); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['banner_link']); ?>" name="<?php echo esc_attr($this->get_field_name('banner_link')); ?>" id="<?php echo esc_attr($this->get_field_id('banner_link')); ?>" />
			</p>
        <?php
	}
}
