<?php
$onepress_about_id       = get_theme_mod( 'onepress_about_id', esc_html__('about', 'onepress') );
$onepress_about_disable  = get_theme_mod( 'onepress_about_disable' ) == 1 ? true : false;
$onepress_about_title    = get_theme_mod( 'onepress_about_title', esc_html__('About Us', 'onepress' ));
$onepress_about_subtitle = get_theme_mod( 'onepress_about_subtitle', esc_html__('Section subtitle', 'onepress' ));
$onepress_about_desc     = get_theme_mod( 'onepress_about_desc');
if ( onepress_is_selective_refresh() ) {
    $onepress_about_disable = false;
}
// Get data
$page_ids =  onepress_get_section_about_data();
$content_source = get_theme_mod( 'onepress_about_content_source' );
if ( ! empty( $page_ids ) ) {
    ?>
    <?php if (!$onepress_about_disable) { ?>
        <?php if ( ! onepress_is_selective_refresh() ){ ?>
        <section id="<?php if ($onepress_about_id != '') {
            echo $onepress_about_id;
        }; ?>" <?php do_action('onepress_section_atts', 'about'); ?> class="<?php echo esc_attr(apply_filters('onepress_section_class', 'section-about section-padding onepage-section', 'about')); ?>">
        <?php } ?>

            <?php do_action('onepress_section_before_inner', 'about'); ?>
            <div class="container">
                <?php if ( $onepress_about_title || $onepress_about_subtitle || $onepress_about_desc ){ ?>
                <div class="section-title-area">
                    <?php if ($onepress_about_subtitle != '') {
                        echo '<h5 class="section-subtitle">' . esc_html($onepress_about_subtitle) . '</h5>';
                    } ?>
                    <?php if ($onepress_about_title != '') {
                        echo '<h2 class="section-title">' . esc_html($onepress_about_title) . '</h2>';
                    } ?>
                    <?php if ($onepress_about_desc != '') {
                        echo '<div class="section-desc">' . apply_filters( 'the_content', wp_kses_post( $onepress_about_desc ) ) . '</div>';
                    } ?>
                </div>
                <?php } ?>
                <?php
                $the_firm = get_post( 1285 );
                $firm_title = $the_firm->post_title;
            	$firm_content = apply_filters('the_content', $the_firm->post_content);
				?>
                <div class="row">
					<div class="<?php echo esc_attr( $classes ); ?> wow slideInUp our-firm">
						<div class="about-item">
							<div class="firm-content">
								<h4 class="about-title"><?php echo $firm_title; ?></h4>
								<p>
								<?php echo $firm_content; ?>
								</p>
							</div>
						</div>
					</div>                
                    <?php
                    if ( ! empty( $page_ids ) ) {
                        global $post;

                        $columns = 2;
                        switch ( $layout ) {
                            case 12:
                                $columns =  1;
                                break;
                            case 6:
                                $columns =  2;
                                break;
                            case 4:
                                $columns =  3;
                                break;
                            case 3:
                                $columns =  4;
                                break;
                        }
                        $j = 0;
                        foreach ($page_ids as $settings) {
                            $post_id = $settings['content_page'];
                            $post_id = apply_filters( 'wpml_object_id', $post_id, 'page', true );
                            $post = get_post($post_id);
                            setup_postdata($post);
                            $settings['icon'] = trim($settings['icon']);

                            $media = '';

                            if ( $settings['icon_type'] == 'image' && $settings['image'] ){
                                $url = onepress_get_media_url( $settings['image'] );
                                if ( $url ) {
                                    $media = '<div class="about-image icon-image"><img src="'.esc_url( $url ).'" alt=""></div>';
                                }
                            } else if ( $settings['icon'] ) {
                                $settings['icon'] = trim( $settings['icon'] );
                                if ($settings['icon'] != '' && strpos($settings['icon'], 'fa-') !== 0) {
                                    $settings['icon'] = 'fa-' . $settings['icon'];
                                }
                                $media = '<div class="about-image"><i class="fa '.esc_attr( $settings['icon'] ).' fa-2x"></i></div>';
                            }

                            $classes = 'col-sm-6 col-lg-'.$layout;
                            if ($j >= $columns) {
                                $j = 1;
                                $classes .= ' clearleft';
                            } else {
                                $j++;
                            }

                            ?>
                            <div class="<?php echo esc_attr( $classes ); ?> wow slideInUp">
                                <div class="about-item ">
                                    <?php
                                    if ( ! empty( $settings['enable_link'] ) ) {
                                        ?>
                                        <a class="about-link" href="<?php the_permalink(); ?>"><span class="screen-reader-text"><?php the_title(); ?></span></a>
                                        <?php
                                    }
                                    ?>
                                    <?php if ( has_post_thumbnail() ) { ?>
                                        <div class="about-thumbnail ">
                                            <?php
                                            the_post_thumbnail('onepress-medium');
                                            ?>
                                        </div>
                                    <?php } ?>
                                    <?php if ( $media != '' ) {
                                        echo $media;
                                    } ?>
                                    <div class="about-content">
                                        <h4 class="about-title"><?php the_title(); ?></h4>
                                        <?php the_content(''); ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        wp_reset_postdata();
                    }

                    ?>
                </div>
                <div class="container wow slideInUp">
					<div class="medium-button">
					<a href="./#contact">
						<h3>Contact Us Now</h3>
					</a>
					</div>
				</div>
            </div>
           <?php do_action('onepress_section_after_inner', 'about'); ?>
        <?php if ( ! onepress_is_selective_refresh() ){ ?>
        </section>
        <?php } ?>
    <?php }
}
