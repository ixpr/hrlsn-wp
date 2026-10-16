<?php 
$headingLine1 = HRLSN_OPTIONS['hrlsn_field_heading_line_1'];
$headingLine2 = HRLSN_OPTIONS['hrlsn_field_heading_line_2'];
$textLine1Item1 = HRLSN_OPTIONS['hrlsn_field_text_line_1_item_1'];
$textLine1Item2 = HRLSN_OPTIONS['hrlsn_field_text_line_1_item_2'];
$textLine1Item3 = HRLSN_OPTIONS['hrlsn_field_text_line_1_item_3'];
$textLine1Item4 = HRLSN_OPTIONS['hrlsn_field_text_line_1_item_4'];
$textLine2Item1 = HRLSN_OPTIONS['hrlsn_field_text_line_2_item_1'];
$textLine2Item2 = HRLSN_OPTIONS['hrlsn_field_text_line_2_item_2'];
$textLine2Item2Link = HRLSN_OPTIONS['hrlsn_field_text_line_2_item_2_link'];

$banners = [];

$args = array(
    'post_type' => 'mp-banners',
	'posts_per_page' => 2,
	'orderby' => 'date',
    'order' => 'ASC'
);

$query = new WP_Query( $args );

if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post();
        $banners[get_the_ID()]['video'] = get_post_meta( get_the_ID(), 'banners_video_file', 1 );
        $banners[get_the_ID()]['image'] = get_the_post_thumbnail_url( get_the_ID(), 'full' );
        $banners[get_the_ID()]['thumbnail'] = get_the_post_thumbnail( get_the_ID(), 'full' );
	}
}

wp_reset_postdata();
?>
<div class="h-slider">
    <div class="h-slider__title"><span><?php echo $headingLine1; ?></span> <br><br> <span><?php echo $headingLine2; ?></span></div>
    <div class="h-slider__videos">
        <?php foreach ($banners as $value) { ?>
            <div class="h-slider__videos__item">
                <?php if (isset($value['video']) && $value['video']) { ?>
                    <video loop autoplay muted playsinline src="<?php echo $value['video']; ?>" poster="<?php echo $value['image']; ?>"></video>
                <?php } else { ?>
                    <?php echo $value['thumbnail']; ?>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
    <div class="h-slider__line h-slider__line--top">
        <span><?php echo $textLine1Item1; ?></span>
        <span class="outline"><i><?php echo $textLine1Item2; ?></i></span>
        <span><?php echo $textLine1Item3; ?></span>
        <span><?php echo $textLine1Item4; ?></span>
    </div>
    <div class="h-slider__line h-slider__line--bottom">
        <span><?php echo $textLine2Item1; ?></span>
        <span><a class="forward-link" href="<?php echo $textLine2Item2Link; ?>"><?php echo $textLine2Item2; ?></a></span>
    </div>
</div>