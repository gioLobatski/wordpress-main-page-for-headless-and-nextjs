<?php
/**
 * Headless Redirect Theme - Landing Page
 *
 * This is the single template that renders for every frontend URL.
 * It shows a branded landing page with a button to the real frontend.
 *
 * @package Headless_Redirect
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ── Gather settings ──
$frontend_url      = untrailingslashit( headless_redirect_get_option( 'frontend_url' ) );
$logo_image        = headless_redirect_get_option( 'logo_image' );
$page_title        = headless_redirect_get_option( 'page_title' );
$description       = headless_redirect_get_option( 'description' );
$button_text       = headless_redirect_get_option( 'button_text' );
$button_color      = headless_redirect_get_option( 'button_color' );
$button_text_color = headless_redirect_get_option( 'button_text_color' );
$preserve_path     = headless_redirect_get_option( 'preserve_path' );
$auto_redirect     = (int) headless_redirect_get_option( 'auto_redirect' );
$background_color  = headless_redirect_get_option( 'background_color' );
$text_color        = headless_redirect_get_option( 'text_color' );

// ── Build the target URL (preserve path if enabled) ──
$request_path = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '/';
$target_url   = $preserve_path ? $frontend_url . $request_path : $frontend_url;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />
    <title><?php echo esc_html( $page_title ); ?></title>
    <style>
        /* ── Reset ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen,
                         Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
            background-color: <?php echo esc_attr( $background_color ); ?>;
            color: <?php echo esc_attr( $text_color ); ?>;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            text-align: center;
            padding: 2rem;
        }

        .hr-container {
            max-width: 600px;
            width: 100%;
        }

        .hr-logo {
            max-width: 280px;
            height: auto;
            margin-bottom: 2rem;
        }

        .hr-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.3;
        }

        .hr-description {
            font-size: 1.125rem;
            line-height: 1.6;
            margin-bottom: 2rem;
            opacity: 0.85;
        }

        .hr-button {
            display: inline-block;
            padding: 0.875rem 2.5rem;
            font-size: 1.0625rem;
            font-weight: 600;
            text-decoration: none;
            border-radius: 6px;
            transition: opacity 0.2s ease, transform 0.2s ease;
            background-color: <?php echo esc_attr( $button_color ); ?>;
            color: <?php echo esc_attr( $button_text_color ); ?>;
        }

        .hr-button:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .hr-button:active {
            transform: translateY(0);
        }

        .hr-countdown {
            margin-top: 1.5rem;
            font-size: 0.875rem;
            opacity: 0.6;
        }

        @media (max-width: 480px) {
            .hr-title { font-size: 1.5rem; }
            .hr-description { font-size: 1rem; }
            .hr-logo { max-width: 200px; }
        }
    </style>
</head>
<body>
    <div class="hr-container">

        <?php if ( ! empty( $logo_image ) ) : ?>
            <img class="hr-logo" src="<?php echo esc_url( $logo_image ); ?>"
                 alt="<?php echo esc_attr( $page_title ); ?>" />
        <?php endif; ?>

        <?php if ( ! empty( $page_title ) ) : ?>
            <h1 class="hr-title"><?php echo esc_html( $page_title ); ?></h1>
        <?php endif; ?>

        <?php if ( ! empty( $description ) ) : ?>
            <p class="hr-description"><?php echo esc_html( $description ); ?></p>
        <?php endif; ?>

        <a class="hr-button" href="<?php echo esc_url( $target_url ); ?>">
            <?php echo esc_html( $button_text ); ?>
        </a>

        <?php if ( $auto_redirect > 0 ) : ?>
            <p class="hr-countdown">
                <?php
                /* translators: %s is replaced by a <span> with the countdown number */
                printf(
                    esc_html__( 'Redirecting in %s seconds…', 'headless-redirect' ),
                    '<span id="hr-timer">' . esc_html( $auto_redirect ) . '</span>'
                );
                ?>
            </p>
            <script>
                (function () {
                    var seconds  = <?php echo (int) $auto_redirect; ?>;
                    var target   = <?php echo wp_json_encode( esc_url( $target_url ) ); ?>;
                    var timerEl  = document.getElementById('hr-timer');
                    var interval = setInterval(function () {
                        seconds--;
                        if (timerEl) timerEl.textContent = seconds;
                        if (seconds <= 0) {
                            clearInterval(interval);
                            window.location.href = target;
                        }
                    }, 1000);
                })();
            </script>
        <?php endif; ?>

    </div>
</body>
</html>
