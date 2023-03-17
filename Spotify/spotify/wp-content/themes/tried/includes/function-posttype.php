<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'init', 'tried_posttype' );
function tried_posttype() {
  $posttypes = array(
    array('slug' => 'bao-hanh', 'name' => __( 'Bảo hành', 'trỉed' ), 'supports' => array( 'title', 'editor', 'author', 'custom-fields' )),
    // array('slug' => 'dich-vu', 'name' => __( 'Dịch Vụ', 'trỉed' ), 'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields' ), 'name_taxonomy' => __( 'Danh mục', 'trỉed' ), 'parent_item_taxonomy' => __( 'Danh mục Cha', 'trỉed' ), 'default_term' => array('name' => 'Chưa phân loại', 'slug' => 'chua-phan-loai', 'description' => ''))
  );

  foreach ( $posttypes as $posttype ) {
    register_post_type( $posttype['slug'], array(
      'label'               => $posttype['name'],
      'labels'              => array(
        'view_item'         => __( 'Chi tiết', 'tried' ),
        'search_item'       =>  __( 'Tìm kiếm', 'tried' ),
        'all_items'         => __( 'Tất cả', 'tried' ),
        'edit_item'         => __( 'Chỉnh sửa', 'tried' ),
        'update_item'       => __( 'Cập nhật', 'tried' ),
        'add_new'           => __( 'Thêm mới', 'tried' ),
        'new_item'          => __( 'Thêm mới', 'tried' ),
      ),
      'description'         => $posttype['name'],
      'supports'            => $posttype['supports'],
      'hierarchical'        => false,
      'public'              => true,
      'show_ui'             => true,
      'show_in_menu'        => true,
      'show_in_nav_menus'   => true,
      'show_in_admin_bar'   => true,
      'menu_position'       => 5,
      'can_export'          => true,
      'has_archive'         => true,
      'exclude_from_search' => false,
      'publicly_queryable'  => true,
      'capability_type'     => 'post',
      'show_in_rest'        => true
    ) );

    if ( isset( $posttype['name_taxonomy'] ) && !empty( $posttype['name_taxonomy'] ) ) {
      register_taxonomy( $posttype['slug'].'_cat', array(
        $posttype['slug']
      ), array(
        'hierarchical' => true,
        // This array of options controls the labels displayed in the WordPress Admin UI
        'labels' => array(
          'name' => $posttype['name_taxonomy'],
          'singular_name' => $posttype['name_taxonomy'],
          'search_items' =>  __( 'Tìm kiếm', 'tried' ),
          'all_items' => __( 'Tất cả', 'tried' ),
          'parent_item' => $posttype['parent_item_taxonomy'],
          'parent_item_colon' => $posttype['parent_item_taxonomy'],
          'edit_item' => __( 'Chỉnh sửa', 'tried' ),
          'update_item' => __( 'Cập nhật', 'tried' ),
          'add_new_item' => __( 'Thêm mới', 'tried' ),
          'new_item_name' => __( 'Thêm mới', 'tried' ),
          'menu_name' => $posttype['name_taxonomy']
        ),
        // Control the slugs used for this taxonomy
        'rewrite' => array(
          'slug' => $posttype['slug'].'_cat', // This controls the base slug that will display before each term
          'with_front' => false, // Don't display the category base before "/locations/"
          'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
        ),
        'default_term' => $posttype['default_term']
      ) );
    }
  }
}

// posttype
add_action( 'add_meta_boxes', 'tried_posttype_meta_boxes', 10, 2 );
function tried_posttype_meta_boxes( $post_type, $post ) {
  $metaboxs = array( 
    array( 'id' => 'bao-hanh', 'title' => __( 'Thông tin chi tiết', 'trỉed' ), 'render' => 'bao_hanh' )
  );
  
  if ( !empty( $metaboxs ) ) {
    foreach ($metaboxs as $metabox) {
      add_meta_box(
          'aw-meta-box',
          $metabox['title'],
          'render_'.$metabox['render'].'_meta_box',
          $metabox['id'],
          'normal',
          'high'
      );
    }
  }
}

function render_bao_hanh_meta_box( $post ) {
  // Info
  $info_agency = get_post_meta( $post->ID, 'info_agency', true );
  $info_datedelivery = get_post_meta( $post->ID, 'info_datedelivery', true );
  $info_datebuy = get_post_meta( $post->ID, 'info_datebuy', true );
  $info_monthinsurance = get_post_meta( $post->ID, 'info_monthinsurance', true );
  $info_status = get_post_meta( $post->ID, 'info_status', true );
  // Product
  $product_id = get_post_meta( $post->ID, 'product_id', true );
  $product_name = get_post_meta( $post->ID, 'product_name', true );
  $product_cat = get_post_meta( $post->ID, 'product_cat', true );
  // Client
  $client_name = get_post_meta( $post->ID, 'client_name', true );
  $client_address = get_post_meta( $post->ID, 'client_address', true );
  $client_email = get_post_meta( $post->ID, 'client_email', true );
  $client_phone = get_post_meta( $post->ID, 'client_phone', true );
  // Others
  $insurance_months = array( 6, 12, 18, 24, 36 );
  $insurance_status = array( 0 => __( 'Chưa duyệt', 'tried' ), 1 => __( 'Đã duyệt', 'tried' ) );
  ?>
    <fieldset>
      <legend><?php _e( 'Thông tin Bảo hành', 'tried' ); ?></legend>
      <article>
        <div class="meta-options baohanh-posttype">
          <h4><?php _e( 'Đại lý', 'tried' ); ?>:</h4>
          <div class="meta-wrapper">
            <input type="text" name="info_agency" id="baohanh-info_agency" value="<?php echo $info_agency; ?>" required/>
          </div>
        </div>
        <div class="meta-options baohanh-posttype">
          <h4><?php _e( 'Ngày giao đại lý', 'tried' ); ?>:</h4>
          <div class="meta-wrapper">
            <input type="date" name="info_datedelivery" id="baohanh-info_datedelivery" value="<?php echo $info_datedelivery; ?>" required/>
          </div>
        </div>
        <div class="meta-options baohanh-posttype">
          <h4><?php _e( 'Ngày mua', 'tried' ); ?>:</h4>
          <div class="meta-wrapper">
            <input type="date" name="info_datebuy" id="baohanh-info_datebuy" value="<?php echo $info_datebuy; ?>"/>
          </div>
        </div>
        <div class="meta-options baohanh-posttype">
          <h4><?php _e( 'Số tháng bảo hành', 'tried' ); ?>:</h4>
          <div class="meta-wrapper">
            <select name="info_monthinsurance" id="baohanh-info_monthinsurance" required>
              <option value=""><?php _e( 'Chọn tháng', 'tried' ); ?></option>
              <?php foreach ( $insurance_months as $month ) : ?>
                <option value="<?php echo $month; ?>" <?php selected( $month, $info_monthinsurance ); ?>><?php echo $month. ' '.__( 'Tháng', 'tried' ); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="meta-options baohanh-posttype">
          <h4><?php _e( 'Trạng thái', 'tried' ); ?>:</h4>
          <div class="meta-wrapper">
            <select name="info_status" id="baohanh-info_status" required>
              <?php foreach ( $insurance_status as $s => $status ) : ?>
                <option value="<?php echo $s; ?>" <?php selected( $s, $info_status ); ?>><?php echo $status; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      </article>
    </fieldset>
    <fieldset>
      <legend><?php _e( 'Thông tin Sản phẩm', 'tried' ); ?></legend>
      <article>
        <div class="meta-options baohanh-posttype">
          <h4><?php _e( 'Mã sản phẩm', 'tried' ); ?>:</h4>
          <div class="meta-wrapper">
            <input type="text" name="product_id" id="baohanh-product_id" value="<?php echo $product_id; ?>" required/>
          </div>
        </div>
        <div class="meta-options baohanh-posttype" style="display: none;">
          <h4><?php _e( 'Tên sản phẩm', 'tried' ); ?>:</h4>
          <div class="meta-wrapper">
            <input type="text" name="product_name" id="baohanh-product_name" value="<?php echo $product_name; ?>"/>
          </div>
        </div>
        <div class="meta-options baohanh-posttype">
          <h4><?php _e( 'Danh mục', 'tried' ); ?>:</h4>
          <div class="meta-wrapper">
            <input type="text" name="product_cat" id="baohanh-product_cat" value="<?php echo $product_cat; ?>"/>
          </div>
        </div>
      </article>
    </fieldset>
    <fieldset>
      <legend><?php _e( 'Thông tin Khách hàng', 'tried' ); ?></legend>
      <article>
        <div class="meta-options baohanh-posttype">
          <h4><?php _e( 'Khách hàng', 'tried' ); ?>:</h4>
          <div class="meta-wrapper">
            <input type="text" name="client_name" id="baohanh-client_name" value="<?php echo $client_name; ?>"/>
          </div>
        </div>
        <div class="meta-options baohanh-posttype">
          <h4><?php _e( 'Địa chỉ', 'tried' ); ?>:</h4>
          <div class="meta-wrapper">
            <textarea name="client_address" id="baohanh-client_address" cols="30" rows="2"><?php echo $client_address; ?></textarea>
          </div>
        </div>
        <div class="meta-options baohanh-posttype">
          <h4><?php _e( 'Email', 'tried' ); ?>:</h4>
          <div class="meta-wrapper">
            <input type="text" name="client_email" id="baohanh-client_email" value="<?php echo $client_email; ?>"/>
          </div>
        </div>
        <div class="meta-options baohanh-posttype">
          <h4><?php _e( 'Số điện thoại', 'tried' ); ?>:</h4>
          <div class="meta-wrapper">
            <input type="text" name="client_phone" id="baohanh-client_phone" value="<?php echo $client_phone; ?>"/>
          </div>
        </div>
      </article>
    </fieldset>
  <?php
}

add_action('save_post', 'bao_hanh_save_postdata');
function bao_hanh_save_postdata( $post_id ) {
  // Info
  if ( array_key_exists( 'info_agency', $_POST ) ) {
      update_post_meta( $post_id, 'info_agency', $_POST['info_agency'] );
  }
  if ( array_key_exists( 'info_datedelivery', $_POST ) ) {
      update_post_meta( $post_id, 'info_datedelivery', $_POST['info_datedelivery'] );
  }
  if ( array_key_exists( 'info_datebuy', $_POST ) ) {
      update_post_meta( $post_id, 'info_datebuy', $_POST['info_datebuy'] );
  }
  if ( array_key_exists( 'info_monthinsurance', $_POST ) ) {
      update_post_meta( $post_id, 'info_monthinsurance', $_POST['info_monthinsurance'] );
  }
  // Product
  if ( array_key_exists( 'product_id', $_POST ) ) {
      update_post_meta( $post_id, 'product_id', $_POST['product_id'] );
  }
  if ( array_key_exists( 'product_name', $_POST ) ) {
      update_post_meta( $post_id, 'product_name', $_POST['product_name'] );
  }
  if ( array_key_exists( 'product_cat', $_POST ) ) {
      update_post_meta( $post_id, 'product_cat', $_POST['product_cat'] );
  }
  // Client
  if ( array_key_exists( 'client_name', $_POST ) ) {
      update_post_meta( $post_id, 'client_name', $_POST['client_name'] );
  }
  if ( array_key_exists( 'client_address', $_POST ) ) {
      update_post_meta( $post_id, 'client_address', $_POST['client_address'] );
  }
  if ( array_key_exists( 'client_email', $_POST ) ) {
      update_post_meta( $post_id, 'client_email', $_POST['client_email'] );
  }
  if ( array_key_exists( 'client_phone', $_POST ) ) {
      update_post_meta( $post_id, 'client_phone', $_POST['client_phone'] );
  }
  // status
  if ( array_key_exists( 'info_status', $_POST ) ) {
    update_post_meta( $post_id, 'info_status', $_POST['info_status'] );
    if ( $_POST['info_status'] == '1' || $_POST['info_status'] == 1 ) {
      after_change_status_baohanh( $post_id );
    }
  }
}

function after_change_status_baohanh( $post_id ) {
    /*
      0 => Chưa duyệt
      1 => Đã duyệt
    */
    $info_status = get_post_meta( $post_id, 'info_status', true );
    if( $info_status == '1' ) {
      $seri = get_post( $post_id )->post_title;
      // Info
      $info_agency = get_post_meta( $post_id, 'info_agency', true );
      $info_datedelivery = get_post_meta( $post_id, 'info_datedelivery', true );
      $info_datebuy = get_post_meta( $post_id, 'info_datebuy', true );
      $info_monthinsurance = get_post_meta( $post_id, 'info_monthinsurance', true );
      // Product
      $product_id = get_post_meta( $post_id, 'product_id', true );
      // $product_name = get_post_meta( $post_id, 'product_name', true );
      $product_cat = get_post_meta( $post_id, 'product_cat', true );
      // Client
      $client_name = get_post_meta( $post_id, 'client_name', true );
      $client_address = get_post_meta( $post_id, 'client_address', true );
      $client_email = get_post_meta( $post_id, 'client_email', true );
      $client_phone = get_post_meta( $post_id, 'client_phone', true );
      // send mail notification to client
      if ( validate_string_to_email( $client_email ) ) {
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $mailto = $client_email;
        $subject = 'Yêu cầu duyệt Phiếu Bảo Hành Điện Tử #'.$seri;
        $content = template_mailto_client_notifi_update_baohanh( array(
          'seri' => $seri,
          'info_agency' => $info_agency,
          'info_datedelivery' => $info_datedelivery,
          'info_monthinsurance' => $info_monthinsurance,
          'info_datebuy' => $info_datebuy,
          'product_id' => $product_id,
          // 'product_name' => $product_name,
          'product_cat' => $product_cat,
          'client_name' => $client_name,
          'client_address' => $client_address,
          'client_email' => $client_email,
          'client_phone' => $client_phone
        ) );
        //Here put your Validation and send mail
        wp_mail( $mailto, $subject, $content, $headers );
      }
  }
}

function template_mailto_client_notifi_update_baohanh( $args = array() ) {
  ob_start();
  ?>
  <!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
    <head>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="x-apple-disable-message-reformatting"> 
    <title></title>
    <meta name="robots" content="noindex, follow">
    </head>
    <body width="100%" style="margin: 0; padding: 0 !important; background-color: #ccc;">
        <div style="max-width: 600px; margin: 0 auto;" class="email-container">
            <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
                <tbody>
                    <tr>
                        <td style="background: rgba(0,0,0,.8);text-align:center;padding:2.5em;">
                            <div class="heading-section" style="color: #000; font-size: 28px; margin-top: 0; line-height: 1.4;color: rgba(255,255,255,.8);">
                            <span style="margin-bottom: 0; display: inline-block; font-size: 13px; text-transform: uppercase; letter-spacing: 2px; color: rgba(255,255,255,.4);border-bottom: 2px solid #f3a333; padding-bottom: 5px;">Welcome</span>
                            <h2 style="color: #fff;line-height: 1; padding-bottom: 0;font-size: 28px;">Phiếu Bảo Hành Điện Tử TOMATE</h2>
                            <p style="color: rgba(255,255,255,.8); font-size: 15px;font-weight: 400; line-height: 27px;">Đây là một phiếu bảo hành điện tử dùng để thực hiện việc bảo hành <br>các sản phẩm do <a href="tomate.com.vn" style="color: #f3a333;">Tomate.com.vn</a> cung cấp và phân phối.</p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td valign="middle" style="position: relative; background-color: #41ca56; background-image: url(images/bg_1.jpg); background-size: cover; height: 100%; padding-top: 40px; padding-bottom: 40px;">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div style="color: rgba(255,255,255,.8); padding: 0 3em;">
                                                <h2 style="color: #ffffff; font-size: 30px; margin-bottom: 20px;text-align: center;margin-top: 0;">Seri #1412</h2>
                                                <div style="background: #ffffff; color: #000;">
                                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="padding: 5px 10px; width: 30%;border-bottom: 1px dashed #ccc;">
                                                                    <h3 style="margin: 0; font-size: 14px; font-weight: 600; line-height: 27px;">Mã sản phẩm:</h3>
                                                                </td>
                                                                <td style="padding: 5px 10px; width: 70%;border-bottom: 1px dashed #ccc;"><?php echo !empty($args['product_id'])?$args['product_id']:'-'; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding: 5px 10px; width: 30%;border-bottom: 1px dashed #ccc;">
                                                                    <h3 style="margin: 0; font-size: 14px; font-weight: 600; line-height: 27px;">Danh mục:</h3>
                                                                </td>
                                                                <td style="padding: 5px 10px; width: 70%;border-bottom: 1px dashed #ccc;"><?php echo !empty($args['product_cat'])?$args['product_cat']:'-'; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding: 5px 10px; width: 30%;border-bottom: 1px dashed #ccc;">
                                                                    <h3 style="margin: 0; font-size: 14px; font-weight: 600; line-height: 27px;">Số tháng BH:</h3>
                                                                </td>
                                                                <td style="padding: 5px 10px; width: 70%;border-bottom: 1px dashed #ccc;"><?php echo !empty($args['info_monthinsurance'])?$args['info_monthinsurance']:'-'; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding: 5px 10px; width: 30%;border-bottom: 1px dashed #ccc;">
                                                                    <h3 style="margin: 0; font-size: 14px; font-weight: 600; line-height: 27px;">Tên đại lý:</h3>
                                                                </td>
                                                                <td style="padding: 5px 10px; width: 70%;border-bottom: 1px dashed #ccc;"><?php echo !empty($args['info_agency'])?$args['info_agency']:'-'; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding: 5px 10px; width: 30%;border-bottom: 1px dashed #ccc;">
                                                                    <h3 style="margin: 0; font-size: 14px; font-weight: 600; line-height: 27px;">Ngày giao đại lý:</h3>
                                                                </td>
                                                                <td style="padding: 5px 10px; width: 70%;border-bottom: 1px dashed #ccc;"><?php echo !empty($args['info_datedelivery'])?date("d-m-Y", strtotime($args['info_datedelivery'])):'-'; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding: 5px 10px; width: 30%;border-bottom: 1px dashed #ccc;">
                                                                    <h3 style="margin: 0; font-size: 14px; font-weight: 600; line-height: 27px;">Ngày mua:</h3>
                                                                </td>
                                                                <td style="padding: 5px 10px; width: 70%;border-bottom: 1px dashed #ccc;"><?php echo !empty($args['info_datebuy'])?date("d-m-Y", strtotime($args['info_datebuy'])):'-'; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding: 5px 10px; width: 30%;border-bottom: 1px dashed #ccc;">
                                                                    <h3 style="margin: 0; font-size: 14px; font-weight: 600; line-height: 27px;">Tên khách hàng:</h3>
                                                                </td>
                                                                <td style="padding: 5px 10px; width: 70%;border-bottom: 1px dashed #ccc;"><?php echo !empty($args['client_name'])?$args['client_name']:'-'; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding: 5px 10px; width: 30%;border-bottom: 1px dashed #ccc;">
                                                                    <h3 style="margin: 0; font-size: 14px; font-weight: 600; line-height: 27px;">Địa chỉ:</h3>
                                                                </td>
                                                                <td style="padding: 5px 10px; width: 70%;border-bottom: 1px dashed #ccc;"><?php echo !empty($args['client_address'])?$args['client_address']:'-'; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding: 5px 10px; width: 30%;border-bottom: 1px dashed #ccc;">
                                                                    <h3 style="margin: 0; font-size: 14px; font-weight: 600; line-height: 27px;">Email:</h3>
                                                                </td>
                                                                <td style="padding: 5px 10px; width: 70%;border-bottom: 1px dashed #ccc;"><?php echo !empty($args['client_email'])?$args['client_email']:'-'; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding: 5px 10px; width: 30%;border-bottom: 1px dashed #ccc;">
                                                                    <h3 style="margin: 0; font-size: 14px; font-weight: 600; line-height: 27px;">Điện thoại:</h3>
                                                                </td>
                                                                <td style="padding: 5px 10px; width: 70%;border-bottom: 1px dashed #ccc;"><?php echo !empty($args['client_phone'])?$args['client_phone']:'-'; ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div style="text-align: center;">
                                                    <p>Trên đây là các thông tin về <strong>Phiếu Bảo Hành Điện Tử</strong>, nếu có quý khách có yêu cầu xin vui lòng liên hệ <a href="tel:1900558884" style="color: #de0b0b; font-weight: 600;">1900 55 88 84</a> hoặc tra cứu thông tin tại Website của chúng tôi.</p>
                                                    <p><a href="#" style="padding: 10px 15px; border-radius: 30px; background: #f3a333; color: #ffffff;">Tra cứu thông tin tại đây!</a></p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="background: #fff; color: #000; padding: 1em 2.5em; text-align: center;">
                            <h1 style="margin: 0;"><a href="#" style="color: #000; font-size: 12px; font-weight: 600; text-transform: uppercase; font-family: 'Montserrat', sans-serif;">Bản quyền thuộc © 2020 TOMATE., Ltd.</a></h1>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>
  <?php
  $result = ob_get_contents();
  ob_end_clean();
  return $result;
}