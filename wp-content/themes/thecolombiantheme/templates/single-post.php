<?php
/*
 * Template Name: Custom content builder template
 * Template Post Type: post, page
 * Description: Custom builder developed with Advanced Custom Fields Pro
 * Author: Andrei Popa 
 * Website: http://andrei123.ro
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<?php get_header(); ?>
<section id="content" <?php Avada()->layout->add_style( 'content_style' ); ?> class="customContentBuilder">
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
        <?php 

            $fusion_start_container = '[fusion_builder_container hundred_percent="no" hundred_percent_height="no" 
            hundred_percent_height_scroll="no" hundred_percent_height_center_content="yes" equal_height_columns="no" 
            menu_anchor="" hide_on_mobile="small-visibility,medium-visibility,large-visibility" status="published" 
            publish_date="" class="" id="" border_size="" border_color="" border_style="solid" margin_top="" 
            margin_bottom="0px" padding_top="" padding_right="" padding_bottom="0px" padding_left="" 
            gradient_start_color="" gradient_end_color="" gradient_start_position="0" gradient_end_position="100" 
            gradient_type="linear" radial_direction="center" linear_angle="180" background_color="" background_image="" 
            background_position="center center" background_repeat="no-repeat" fade="no" background_parallax="none" 
            enable_mobile="no" parallax_speed="0.3" background_blend_mode="none" video_mp4="" video_webm="" 
            video_ogv="" video_url="" video_aspect_ratio="16:9" video_loop="yes" video_mute="yes" video_preview_image="" 
            filter_hue="0" filter_saturation="100" filter_brightness="100" filter_contrast="100" filter_invert="0" 
            filter_sepia="0" filter_opacity="100" filter_blur="0" filter_hue_hover="0" filter_saturation_hover="100" 
            filter_brightness_hover="100" filter_contrast_hover="100" filter_invert_hover="0" filter_sepia_hover="0" 
            filter_opacity_hover="100" filter_blur_hover="0"]';
            $fusion_end_container = '[/fusion_builder_container]';

            $fusion_start_row = '[fusion_builder_row]';
            $fusion_end_row = '[/fusion_builder_row]';

            $fusion_start_column = '[fusion_builder_column type="1_1" layout="1_1" spacing="" center_content="no" link="" 
            target="_self" min_height="" hide_on_mobile="small-visibility,medium-visibility,large-visibility" class="" id="" 
            hover_type="none" border_size="0" border_color="" border_style="solid" border_position="all" box_shadow="no" 
            box_shadow_blur="0" box_shadow_spread="0" box_shadow_color="" box_shadow_style="" background_type="single" 
            gradient_start_position="0" gradient_end_position="100" gradient_type="linear" radial_direction="center" 
            linear_angle="180" background_color="" background_image="" background_image_id="" background_position="left top" 
            background_repeat="no-repeat" background_blend_mode="none" animation_type="" animation_direction="left" 
            animation_speed="0.3" animation_offset="" filter_type="regular" filter_hue="0" filter_saturation="100" 
            filter_brightness="100" filter_contrast="100" filter_invert="0" filter_sepia="0" filter_opacity="100" 
            filter_blur="0" filter_hue_hover="0" filter_saturation_hover="100" filter_brightness_hover="100" 
            filter_contrast_hover="100" filter_invert_hover="0" filter_sepia_hover="0" filter_opacity_hover="100" 
            filter_blur_hover="0" first="true" last="true"]';
            $fusion_end_column = '[/fusion_builder_column]';

            function render_gallery($images) {
                $carousel_images = '';
                foreach ($images as $image){
                    $image_id = $image['id'];
                    $image_url = esc_url($image['sizes']['thumbnail']);
                    $image_alt = $image['alt'];
                    $carousel_images .= '[fusion_image image="'.$image_url.'" image_id="'.$image_id.'" link="" 
                    linktarget="_self" alt="'.$image_alt.'" /]';
                }
                $carousel_desktop = '[fusion_images picture_size="auto" hover_type="none" autoplay="no" columns="4" 
                column_spacing="20" scroll_items="1" show_nav="no" mouse_scroll="no" border="no" lightbox="no" 
                hide_on_mobile="medium-visibility,large-visibility" class="" id=""]'.$carousel_images.'[/fusion_images]';
                $carousel_mobile = '[fusion_images picture_size="auto" hover_type="none" autoplay="no" columns="1" 
                column_spacing="0" scroll_items="1" show_nav="no" mouse_scroll="yes" border="no" lightbox="no" 
                hide_on_mobile="small-visibility" class="" id=""]'.$carousel_images.'[/fusion_images]';

                return $carousel_desktop.$carousel_mobile; 
            }

            function render_tabs($tabs) {
                $fusion_tabs_shortcode = '[fusion_tabs design="classic" layout="vertical" justified="yes" backgroundcolor="" 
                                        inactivecolor="" bordercolor="" icon="" icon_position="" icon_size="" 
                                        hide_on_mobile="small-visibility,medium-visibility,large-visibility" class="customTabs" id=""]';
                foreach( $tabs as $tab ):
                    $content = '';
                    if ($tab['tab_content']) {

                        foreach ($tab['tab_content'] as $tab_content) {
                            if ($tab_content['acf_fc_layout'] == 'text_area') {
                                $content .= $tab_content['editor'];
                            }
                            if ($tab_content['acf_fc_layout'] == 'gallery') {
                                $images = $tab_content['images'];
                                $content .= render_gallery($images);
                            }
                        }
                    }
                    $fusion_tabs_shortcode .= '[fusion_tab title="'.$tab['tab_name'].'" icon=""]'.$content.'[/fusion_tab]';
                endforeach;
                $fusion_tabs_shortcode .= '[/fusion_tabs]';

                return $fusion_tabs_shortcode;
            }

            function render_sections($content) {
                if( have_rows('sections') ) {         
                    while( have_rows('sections') ): the_row();
                        if( get_row_layout() == 'text_area' ):
                            $text_area = get_sub_field('editor');
                            $content .= $text_area;
                        endif;
                        if ( get_row_layout() == 'gallery' ) { 
                            $images = get_sub_field('images');
                            if ($images) {
                                $content .= render_gallery($images);
                            }
                        }
                        if ( get_row_layout() == 'tabs_area' ) {
                            $tabs = get_sub_field('tabs');
                            if( $tabs ) {
                                $content .= render_tabs($tabs);
                            }
                        }       
                    endwhile;
                }

                return $content;
            }
            
            $container = $fusion_start_container.$fusion_start_row;
            $content = '';

            //Build the title
            $fusion_title_shortcode = '[fusion_title title_type="text" rotation_effect="bounceIn" display_time="1200" 
            highlight_effect="circle" loop_animation="off" highlight_width="9" highlight_top_margin="0" 
            before_text="" rotation_text="" highlight_text="" after_text="" content_align="left" size="2" 
            font_size="34" animated_font_size="" line_height="" letter_spacing="" text_color="" 
            animated_text_color="" highlight_color="" style_type="default" sep_color="" 
            hide_on_mobile="small-visibility,medium-visibility,large-visibility" class="" id=""]'.get_the_title().'[/fusion_title]';
            
            $container .= $fusion_start_column.$fusion_title_shortcode.$fusion_end_column;
  
            $content .= render_sections($content);
            $container .= $fusion_start_column.$content.$fusion_end_column;
           

        //Photographs
        $photographs = get_field('photographs');
        if ($photographs) {
            $carousel_images = '';
            $photographs_title = pll__('Photographs');
            $photographs_title_shortcode = '[fusion_title title_type="text" rotation_effect="bounceIn" display_time="1200" 
            highlight_effect="circle" loop_animation="off" highlight_width="9" highlight_top_margin="0" 
            before_text="" rotation_text="" highlight_text="" after_text="" content_align="left" size="3" 
            font_size="22" animated_font_size="" line_height="" letter_spacing="" text_color="" 
            animated_text_color="" highlight_color="" style_type="default" sep_color="" 
            hide_on_mobile="small-visibility,medium-visibility,large-visibility" class="" id=""]'.$photographs_title.'[/fusion_title]';
            $container .= $fusion_start_column.$photographs_title_shortcode.$fusion_end_column;
            foreach ($photographs as $image) {
                $image_id = $image['id'];
                $image_src = esc_url($image['sizes']['medium']);
                $image_link = esc_url($image['sizes']['large']);
                $image_alt = $image['alt'];
                $carousel_images .= '[fusion_image image="'.$image_src.'" image_id="'.$image_id.'" 
                                            link="'.$image_link.'" linktarget="_self" alt="'.$image_alt.'" /]';
            }
            $carousel_desktop = '[fusion_images picture_size="auto" hover_type="zoomin" autoplay="yes" 
                                        columns="3" column_spacing="30" scroll_items="1" show_nav="no" 
                                        mouse_scroll="no" border="no" lightbox="yes" 
                                        hide_on_mobile="medium-visibility, large-visibility" class="" id="photographsDesktop"]'.$carousel_images.'[/fusion_images]';
            $carousel_mobile = '[fusion_images picture_size="auto" hover_type="zoomin" autoplay="yes" 
            columns="1" column_spacing="30" scroll_items="1" show_nav="no" 
            mouse_scroll="yes" border="no" lightbox="yes" 
            hide_on_mobile="small-visibility" class="" id="photographsMobile"]'.$carousel_images.'[/fusion_images]';

            $container .= $fusion_start_column.$carousel_desktop.$carousel_mobile.$fusion_end_column;                                         
        }
        
        $container .= $fusion_end_row.$fusion_end_container;
        echo do_shortcode($container, True);


        // Render Related Posts if enabled
        if (get_field('related_posts')) {
            avada_render_related_posts( get_post_type() );  
        }
            
        ?>
    </article>
</section>
<?php get_footer(); ?>