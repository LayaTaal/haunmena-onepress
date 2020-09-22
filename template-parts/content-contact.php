<?php
$onepress_contact_id            = get_theme_mod( 'onepress_contact_id', esc_html__('contact', 'onepress') );
$onepress_contact_disable       = get_theme_mod( 'onepress_contact_disable' ) == 1 ?  true : false;
$onepress_contact_title         = get_theme_mod( 'onepress_contact_title', esc_html__('Get in touch', 'onepress' ));
$onepress_contact_subtitle      = get_theme_mod( 'onepress_contact_subtitle', esc_html__('Section subtitle', 'onepress' ));
$onepress_contact_cf7           = get_theme_mod( 'onepress_contact_cf7' );
$onepress_contact_cf7_disable   = get_theme_mod( 'onepress_contact_cf7_disable' );
$onepress_contact_text          = get_theme_mod( 'onepress_contact_text' );
$onepress_contact_address_title = get_theme_mod( 'onepress_contact_address_title' );
$onepress_contact_address       = get_theme_mod( 'onepress_contact_address' );
$onepress_contact_phone         = get_theme_mod( 'onepress_contact_phone' );
$onepress_contact_email         = get_theme_mod( 'onepress_contact_email' );
$onepress_contact_fax           = get_theme_mod( 'onepress_contact_fax' );

if ( onepress_is_selective_refresh() ) {
    $onepress_contact_disable = false;
}

if ( $onepress_contact_cf7 || $onepress_contact_text || $onepress_contact_address_title || $onepress_contact_phone || $onepress_contact_email || $onepress_contact_fax ) {
    $desc = get_theme_mod( 'onepress_contact_desc' );
    ?>
    <?php if (!$onepress_contact_disable) : ?>
        <?php if ( ! onepress_is_selective_refresh() ){ ?>
        <section id="<?php if ($onepress_contact_id != '') echo $onepress_contact_id; ?>" <?php do_action('onepress_section_atts', 'counter'); ?>
                 class="<?php echo esc_attr(apply_filters('onepress_section_class', 'section-contact section-padding  section-meta onepage-section', 'contact')); ?>">
        <?php } ?>
            <?php do_action('onepress_section_before_inner', 'contact'); ?>
            <div class="container">
                <?php if ( $onepress_contact_title || $onepress_contact_subtitle || $desc ){ ?>
                <div class="section-title-area">
                    <?php if ($onepress_contact_subtitle != '') echo '<h5 class="section-subtitle">' . esc_html($onepress_contact_subtitle) . '</h5>'; ?>
                    <?php if ($onepress_contact_title != '') echo '<h2 class="section-title">' . esc_html($onepress_contact_title) . '</h2>'; ?>
                    <div class="section-desc">If you have any questions or need legal advise, please contact us today for a free consultation.</div>
                </div>
                <?php } ?>
                <div class="row haunmena">
                    <?php if ($onepress_contact_cf7_disable != '1') : ?>
                        <?php if (isset($onepress_contact_cf7) && $onepress_contact_cf7 != '') { ?>
                            <div class="contact-form wow slideInUp">
                                <?php echo do_shortcode(wp_kses_post($onepress_contact_cf7)); ?>
                            </div>
                        <?php } else { ?>
                            <div class="contact-form wow slideInUp">
                                <br>
                                <small>
                                    <i><?php printf(esc_html__('You can install %1$s plugin and go to Customizer &rarr; Section: Contact &rarr; Section Content to show a working contact form here.', 'onepress'), '<a href="' . esc_url('https://wordpress.org/plugins/contact-form-7/', 'onepress') . '" target="_blank">Contact Form 7</a>'); ?></i>
                                </small>
                            </div>
                        <?php } ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php do_action('onepress_section_after_inner', 'contact'); ?>
        <?php if ( ! onepress_is_selective_refresh() ){ ?>
        </section>
        <?php } ?>
    <?php endif;
}
