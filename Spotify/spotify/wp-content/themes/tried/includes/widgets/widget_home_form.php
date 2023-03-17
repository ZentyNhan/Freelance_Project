<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_form extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_home_form', 'Tried Home Form',
			array(
				'classname' => 'widget_home_form',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

	function widget( $args, $instance ) {
	    $defaults = array(
			'title' => '',
			'box_1_address' => '', 'box_1_phone' => '', 'box_1_email' => '',
			'box_2_address' => '', 'box_2_phone' => '', 'box_2_email' => '',
			'title_form' => 'Form báo giá',
			'id_form' => '',
			'info_1_title' => '', 'info_1_content' => '',
			'info_2_title' => '', 'info_2_content' => '',
			'info_3_title' => '', 'info_3_content' => ''
		);
        $instance = wp_parse_args($instance, $defaults);
		$title = $instance['title'];
		
		$box_1_address = $instance['box_1_address'];
		$box_1_phone = $instance['box_1_phone'];
		$box_1_email = $instance['box_1_email'];

		$box_2_address = $instance['box_2_address'];
		$box_2_phone = $instance['box_2_phone'];
		$box_2_email = $instance['box_2_email'];

		$title_form = $instance['title_form'];
		$id_form = $instance['id_form'] ;
		
		$info_1_title = $instance['info_1_title'];
		$info_1_content = $instance['info_1_content'];
		
		$info_2_title = $instance['info_2_title'];
		$info_2_content = $instance['info_2_content'];
		
		$info_3_title = $instance['info_3_title'];
		$info_3_content = $instance['info_3_content'];

		// echo $args['before_widget'];
		?>
			<section id="widget-<?php echo $args['widget_id']; ?>" class="section-home-form">
				<div class="section-outfit">
					<h3><?php echo $title; ?></h3>
				</div>
                <div class="section-wrapper margin-auto">
					<div class="form-wrapper">
						<div class="wrap mwidth-main margin-auto">
							<div class="form-block">
								<h3 class="bigtitle"><?php _e('Liên hệ chúng tôi', ''); ?></h3>
								<?php if (!empty($id_form)) : ?>
									<h3 class="title"><?php echo $title_form; ?></h3>
									<?php echo do_shortcode('[contact-form-7 id="'.$id_form.'"]'); ?>
								<?php endif; ?>
							</div>
							<div class="content-block">
								<div class="boxs">
									<?php if (!empty($box_1_address)) : ?>
										<div class="item">
											<h3 class="title">Visit The Store</h3>
											<p class="address"><?php echo $box_1_address; ?></p>
											<ul class="infos">
												<li>Phone <a href="tel:<?php echo $box_1_phone; ?>"><?php echo $box_1_phone; ?></a></li>
												<li>Email <a href="tel:<?php echo $box_1_email; ?>"><?php echo $box_1_email; ?></a></li>
											</ul>
										</div>
									<?php endif; ?>
									<?php if (!empty($box_2_address)) : ?>
										<div class="item">
											<h3 class="title">Visit The Store</h3>
											<p class="address"><?php echo $box_2_address; ?></p>
											<ul class="infos">
												<li>Phone <a href="tel:<?php echo $box_2_phone; ?>"><?php echo $box_2_phone; ?></a></li>
												<li>Email <a href="tel:<?php echo $box_2_email; ?>"><?php echo $box_2_email; ?></a></li>
											</ul>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
					<?php if (!empty($info_1_title) && !empty($info_2_title) && !empty($info_3_title)) : ?>
						<div class="info-wrapper">
							<div class="wrap mwidth-main margin-auto">
								<div class="boxs">
									<?php if (!empty($info_1_title)) : ?>
										<div class="item">
											<div class="icon">
												<i class="fab fa-accusoft"></i>
											</div>
											<div class="info">
												<h3><?php echo $info_1_title; ?></h3>
												<p><?php echo $info_1_content; ?></p>
											</div>
										</div>
									<?php endif; ?>
									<?php if (!empty($info_2_title)) : ?>
										<div class="item">
											<div class="icon">
												<i class="fab fa-affiliatetheme"></i>
											</div>
											<div class="info">
												<h3><?php echo $info_2_title; ?></h3>
												<p><?php echo $info_2_content; ?></p>
											</div>
										</div>
									<?php endif; ?>
									<?php if (!empty($info_3_title)) : ?>
										<div class="item">
											<div class="icon">
												<i class="fab fa-adn"></i>
											</div>
											<div class="info">
												<h3><?php echo $info_3_title; ?></h3>
												<p><?php echo $info_3_content; ?></p>
											</div>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					<?php endif; ?>
			    </div>
			</section>						
		<?php
		// echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
        $instance = array();

		$instance['title'] = strip_tags($new_instance['title']);

		$instance['box_1_address'] = strip_tags($new_instance['box_1_address']);
		$instance['box_1_phone'] = strip_tags($new_instance['box_1_phone']);
		$instance['box_1_email'] = strip_tags($new_instance['box_1_email']);

		$instance['box_2_address'] = strip_tags($new_instance['box_2_address']);
		$instance['box_2_phone'] = strip_tags($new_instance['box_2_phone']);
		$instance['box_2_email'] = strip_tags($new_instance['box_2_email']);

		$instance['title_form'] = strip_tags($new_instance['title_form']);
		$instance['id_form'] = !empty($new_instance['id_form']) ? $new_instance['id_form'] : '0';

		$instance['info_1_title'] = strip_tags($new_instance['info_1_title']);
		$instance['info_1_content'] = strip_tags($new_instance['info_1_content']);

		$instance['info_2_title'] = strip_tags($new_instance['info_2_title']);
		$instance['info_2_content'] = strip_tags($new_instance['info_2_content']);

		$instance['info_3_title'] = strip_tags($new_instance['info_3_title']);
		$instance['info_3_content'] = strip_tags($new_instance['info_3_content']);

		return $instance;
	}
	
	function form( $instance ) {
	    $defaults = array(
			'title' => '',
			'box_1_address' => '', 'box_1_phone' => '', 'box_1_email' => '',
			'box_2_address' => '', 'box_2_phone' => '', 'box_2_email' => '',
			'title_form' => 'Form báo giá',
			'id_form' => '',
			'info_1_title' => '', 'info_1_content' => '',
			'info_2_title' => '', 'info_2_content' => '',
			'info_3_title' => '', 'info_3_content' => ''
		);
        $instance = wp_parse_args($instance, $defaults);
        
        $cf7 = get_posts(array(
            'post_type'     => 'wpcf7_contact_form',
            'numberposts'   => -1
        ));
        ?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Tiêu đề', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
			</p>
            <h4>Thông tin liên hệ</h4>
			<p>Thông tin 1</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('box_1_address')); ?>"><?php esc_html_e('Địa chỉ', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['box_1_address']); ?>" name="<?php echo esc_attr($this->get_field_name('box_1_address')); ?>" id="<?php echo esc_attr($this->get_field_id('box_1_address')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('box_1_phone')); ?>"><?php esc_html_e('Số điện thoại', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['box_1_phone']); ?>" name="<?php echo esc_attr($this->get_field_name('box_1_phone')); ?>" id="<?php echo esc_attr($this->get_field_id('box_1_phone')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('box_1_email')); ?>"><?php esc_html_e('Email', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['box_1_email']); ?>" name="<?php echo esc_attr($this->get_field_name('box_1_email')); ?>" id="<?php echo esc_attr($this->get_field_id('box_1_email')); ?>" />
			</p>
			<p>Thông tin 2</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('box_2_address')); ?>"><?php esc_html_e('Địa chỉ', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['box_2_address']); ?>" name="<?php echo esc_attr($this->get_field_name('box_2_address')); ?>" id="<?php echo esc_attr($this->get_field_id('box_2_address')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('box_2_phone')); ?>"><?php esc_html_e('Số điện thoại', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['box_2_phone']); ?>" name="<?php echo esc_attr($this->get_field_name('box_2_phone')); ?>" id="<?php echo esc_attr($this->get_field_id('box_2_phone')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('box_2_email')); ?>"><?php esc_html_e('Email', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['box_2_email']); ?>" name="<?php echo esc_attr($this->get_field_name('box_2_email')); ?>" id="<?php echo esc_attr($this->get_field_id('box_2_email')); ?>" />
			</p>
			<h4>Form liên hệ</h4>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title_form')); ?>"><?php esc_html_e('Tiêu đề', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title_form']); ?>" name="<?php echo esc_attr($this->get_field_name('title_form')); ?>" id="<?php echo esc_attr($this->get_field_id('title_form')); ?>" />
			</p>
            <div style="margin-bottom: 5px; min-height: 25px;">
				<?php if (!empty($cf7)) : ?>
					<span style="width: 20%; float:left; line-height: 20px;"><?php _e('Form', ''); ?>:</span>
					<span style="float:left; : 70%; margin-left: 5%">
						<select id="<?php echo esc_attr($this->get_field_id('id_form')); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name('id_form')); ?>">
							<?php foreach ($cf7 as $it_7) : ?>
								<option value="<?=$it_7->ID?>" <?php selected($it_7->ID, $instance['id_form']); ?>><?=$it_7->post_title ?></option>
							<?php endforeach; ?>
						</select>
					</span>
				<?php endif; ?>
            </div>
            <h4>Thông tin banner</h4>
			<p>Banner 1</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('info_1_title')); ?>"><?php esc_html_e('Tiêu đề', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['info_1_title']); ?>" name="<?php echo esc_attr($this->get_field_name('info_1_title')); ?>" id="<?php echo esc_attr($this->get_field_id('info_1_title')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('info_1_content')); ?>"><?php esc_html_e('Nội dung', ''); ?></label>
				<textarea class="widefat" rows="8" name="<?php echo esc_attr($this->get_field_name('info_1_content')); ?>" id="<?php echo esc_attr($this->get_field_id('info_1_content')); ?>"><?php echo esc_attr($instance['info_1_content']); ?></textarea>
			</p>
			<p>Banner 2</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('info_2_title')); ?>"><?php esc_html_e('Tiêu đề', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['info_2_title']); ?>" name="<?php echo esc_attr($this->get_field_name('info_2_title')); ?>" id="<?php echo esc_attr($this->get_field_id('info_2_title')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('info_2_content')); ?>"><?php esc_html_e('Nội dung', ''); ?></label>
				<textarea class="widefat" rows="8" name="<?php echo esc_attr($this->get_field_name('info_2_content')); ?>" id="<?php echo esc_attr($this->get_field_id('info_2_content')); ?>"><?php echo esc_attr($instance['info_2_content']); ?></textarea>
			</p>
			<p>Banner 3</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('info_3_title')); ?>"><?php esc_html_e('Tiêu đề', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['info_3_title']); ?>" name="<?php echo esc_attr($this->get_field_name('info_3_title')); ?>" id="<?php echo esc_attr($this->get_field_id('info_3_title')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('info_3_content')); ?>"><?php esc_html_e('Nội dung', ''); ?></label>
				<textarea class="widefat" rows="8" name="<?php echo esc_attr($this->get_field_name('info_3_content')); ?>" id="<?php echo esc_attr($this->get_field_id('info_3_content')); ?>"><?php echo esc_attr($instance['info_3_content']); ?></textarea>
			</p>
        <?php
	}
}
