<?php
/**
 * Headless Redirect Theme - Page Template
 *
 * Used to render pages that are exempted from the landing page.
 * These pages load through WordPress normally instead of showing
 * the redirect landing page.
 *
 * @package Headless_Redirect
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$background_color = headless_redirect_get_option( 'background_color' );
$text_color       = headless_redirect_get_option( 'text_color' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php wp_title( '|', true, 'right' ); ?><?php bloginfo( 'name' ); ?></title>
    <?php wp_head(); ?>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen,
                         Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
            background-color: <?php echo esc_attr( $background_color ); ?>;
            color: <?php echo esc_attr( $text_color ); ?>;
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
            line-height: 1.6;
        }

        img { max-width: 100%; height: auto; }
    </style>
</head>
<body>
    <?php
    while ( have_posts() ) :
        the_post();
        ?>
        <article>
            <h1><?php the_title(); ?></h1>
            <div class="page-content">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; ?>

    <?php wp_footer(); ?>
</body>
</html>
