<?php /* Template Name: Mainpage Template */ ?>
<?php get_header();

$content = get_the_content(); 
$content_arr = preg_split('/<hr[^>]*>/', $content);
?>
    <main class="container">
        <?php echo get_template_part('inc/random'); ?>

        <article class="mp-manifest">
            <?php the_title( '<h3>', '</h3>' ); ?>
            <div class="mp-manifest__wrapper">
                <div class="mp-manifest__left">
                    <?php echo strip_tags($content_arr[0], '<p><a><br>'); ?>
                </div>
                <div class="mp-manifest__right">
                    <?php echo strip_tags($content_arr[1], '<p><a><br>'); ?>
                </div>
            </div>
        </article>
    </main>
<?php
get_footer(); ?>