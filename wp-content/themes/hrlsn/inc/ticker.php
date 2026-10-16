<?php
$singleTicker = '';

$args = array(
    'post_type' => 'ticker',
	'posts_per_page' => 20,
	'orderby' => 'date',
    'order' => 'ASC'
);

$query = new WP_Query( $args );

if ( $query->have_posts() ) {
    $singleTicker .= '<div class="h-ticker__block">';
	while ( $query->have_posts() ) {
		$query->the_post();
        $singleTicker .= '<div class="h-ticker__block__item">' . strip_tags(get_the_content(), '<p><a>') . '</div>';
	}
    $singleTicker .= '</div>';
}

wp_reset_postdata();
?>

<div class="h-ticker">
    <div class="h-ticker__wrapper">
        <?php echo $singleTicker; ?>
        <?php echo $singleTicker; ?>
    </div>
</div>