<?php
$onepress_team_id       = get_theme_mod( 'onepress_team_id', esc_html__('team', 'onepress') );
$onepress_team_disable  = get_theme_mod( 'onepress_team_disable' ) ==  1 ? true : false;
$onepress_team_title    = get_theme_mod( 'onepress_team_title', esc_html__('Our Team', 'onepress' ));
$onepress_team_subtitle = get_theme_mod( 'onepress_team_subtitle', esc_html__('Section subtitle', 'onepress' ));
$layout = intval( get_theme_mod( 'onepress_team_layout', 3 ) );
if ( $layout <= 0 ){
    $layout = 3;
}
$user_ids = onepress_get_section_team_data();
if ( onepress_is_selective_refresh() ) {
    $onepress_team_disable = false;
}
if ( ! empty( $user_ids ) ) {
    $desc = get_theme_mod( 'onepress_team_desc' );
    ?>
    <?php if ( ! $onepress_team_disable ) : ?>
        <?php if ( ! onepress_is_selective_refresh() ){ ?>
        <section id="<?php if ($onepress_team_id != '') echo $onepress_team_id; ?>" <?php do_action('onepress_section_atts', 'team'); ?>
                 class="<?php echo esc_attr(apply_filters('onepress_section_class', 'section-team section-padding section-meta onepage-section', 'team')); ?>">
        <?php } ?>
            <?php do_action('onepress_section_before_inner', 'team'); ?>
            <div class="container">
                <?php if ( $onepress_team_title || $onepress_team_subtitle || $desc ){ ?>
                <div class="section-title-area">
                    <?php if ($onepress_team_subtitle != '') echo '<h5 class="section-subtitle">' . esc_html($onepress_team_subtitle) . '</h5>'; ?>
                    <?php if ($onepress_team_title != '') echo '<h2 class="section-title">' . esc_html($onepress_team_title) . '</h2>'; ?>
                    <?php if ( $desc ) {
                        echo '<div class="section-desc">' . apply_filters( 'the_content', wp_kses_post( $desc ) ) . '</div>';
                    } ?>
                </div>
                <?php } ?>
                <div class="team-members row team-layout-<?php echo intval( 12 / $layout  ); ?>">
                    <?php
                    if ( ! empty( $user_ids ) ) {
                        $n = 0;
                        $thumbnails = array(
	                        get_stylesheet_directory_uri() . '/img/Ryan-cropped.png',
	                        get_stylesheet_directory_uri() . '/img/Doug-cropped.png'
                        );

                        foreach ( $user_ids as $member ) {
                            $member = wp_parse_args( $member, array(
                                'user_id'  =>array(),
                            ));

                            $link = isset( $member['link'] ) ?  $member['link'] : '';
                            $user_id = wp_parse_args( $member['user_id'],array(
                                'id' => '',
                             ) );
                             
                            $image_attributes = wp_get_attachment_image_src( $user_id['id'], 'onepress-small' );
                            if ( $image_attributes ) {
                                $image = $thumbnails[$n];
                                $data = get_post( $user_id['id'] );
                                $n ++ ;
                                ?>
                            <div class="col-sm-6 col-lg- wow slideInUp">
                                <div class="team-member">
                                	<a href="<?php echo $link ?>">
                                	<div class="member-title">
										<div class="member-thumb">
											<?php if ( $link ) { ?>
		
											<?php } ?>
											<img src="<?php echo esc_url( $image ); ?>" alt="">
											<?php if ( $link ) { ?>
											<?php } ?>
											<?php do_action( 'onepress_section_team_member_media', $member ); ?>
										</div>
										<div class="member-info">
											<h5 class="member-name"><?php echo esc_html( $data->post_title ); ?></h5>
										</div>
                                    </div>
                                	</a>
									<div class="member-details">
										<span class="member-position"><?php echo esc_html( $data->post_content ); ?></span>
										<?php 
										$postid = url_to_postid( $link );
										$post = get_post( $postid );
										setup_postdata($post);
										the_content('');
										wp_reset_postdata();
										?>
										<div class="member-bullets">
											<?php
											$post = get_post( $member['practice_area'] );
											setup_postdata($post);
											$email = isset( $member['email'] ) ?  $member['email'] : '';
											$award_1 = isset( $member['award_1'] ) ?  $member['award_1'] : '';
											?>
											<div class="member-practice">
											<ul>
												<li>
												<h4>Practice Areas</h4>
												</li>
												<li>
												<a href="<?php the_permalink()?>"><?php the_title(); ?></a>
												</li>
											</ul>
											</div>
											<div class="member-awards">
											<ul>
												<li>
												<h4>Recognition</h4>
												</li>
												<li>
												<?php echo $award_1; ?>
												</li>
											</ul>
											</div>
											<div class="member-articles">
											<?php 
												wp_reset_postdata();

												if ($data->post_title == 'Ryan Haun') {
													$nicename = 'ryanhaun';
												} else {
													$nicename = 'dougmena';
												}

												// The Query
												$the_query = new WP_Query( array( 'posts_per_page' => '3', 
																				  'author_name' => $nicename, ) );

												// The Loop
												if ( $the_query->have_posts() ) { ?>
													<ul>
														<li>
														<h4>Latest Articles</h4>
														</li>
													<?php
													while ( $the_query->have_posts() ) {
														$the_query->the_post(); ?>
														<li><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></li>
													<?php
													}
													echo '</ul></div>';
													/* Restore original Post Data */
													wp_reset_postdata();
												} else {
													// no posts found
												}
											?>
										</div>
	                                </div>
									<div class="container">
										<div class="medium-button wow slideInUp">
											<a href="<?php echo $link; ?>">
											<h3>Read More</h3>
											</a>
										</div>
									</div>  
								</div> 
                            </div>
                                <?php
                            }

                        } // end foreach
                        
                        wp_reset_postdata();
                    }

                    ?>
                </div>
            </div>
            <?php do_action('onepress_section_after_inner', 'team'); ?>
        <?php if ( ! onepress_is_selective_refresh() ){ ?>
        </section>
        <?php } ?>
    <?php endif;
}
