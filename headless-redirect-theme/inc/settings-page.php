<?php
/**
 * Headless Redirect Theme - Settings Page
 *
 * Renders the admin settings form under Appearance → Headless Redirect.
 *
 * @package Headless_Redirect
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$options  = get_option( 'headless_redirect_options', array() );
$defaults = headless_redirect_defaults();
$opts     = wp_parse_args( $options, $defaults );
?>
<div class="wrap">
    <h1><?php esc_html_e( 'Headless Redirect Settings', 'headless-redirect' ); ?></h1>
    <p><?php esc_html_e( 'Configure the landing page visitors see when they hit the WordPress frontend.', 'headless-redirect' ); ?></p>

    <form method="post" action="options.php">
        <?php settings_fields( 'headless_redirect_group' ); ?>

        <!-- ── Core Settings ───────────────────────────────── -->
        <h2><?php esc_html_e( 'Core Settings', 'headless-redirect' ); ?></h2>
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="hr_frontend_url"><?php esc_html_e( 'Frontend Site URL', 'headless-redirect' ); ?></label>
                </th>
                <td>
                    <input type="url" id="hr_frontend_url" name="headless_redirect_options[frontend_url]"
                           value="<?php echo esc_attr( $opts['frontend_url'] ); ?>" class="regular-text" />
                    <p class="description"><?php esc_html_e( 'The URL of your Next.js (or other) frontend site. No trailing slash.', 'headless-redirect' ); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="hr_logo_image"><?php esc_html_e( 'Logo / Hero Image', 'headless-redirect' ); ?></label>
                </th>
                <td>
                    <input type="hidden" id="hr_logo_image" name="headless_redirect_options[logo_image]"
                           value="<?php echo esc_attr( $opts['logo_image'] ); ?>" />
                    <div id="hr-image-preview" style="margin-bottom:10px;">
                        <?php if ( ! empty( $opts['logo_image'] ) ) : ?>
                            <img src="<?php echo esc_url( $opts['logo_image'] ); ?>" style="max-width:300px;height:auto;" />
                        <?php endif; ?>
                    </div>
                    <button type="button" class="button" id="hr-upload-btn"><?php esc_html_e( 'Upload Image', 'headless-redirect' ); ?></button>
                    <button type="button" class="button" id="hr-remove-btn" style="<?php echo empty( $opts['logo_image'] ) ? 'display:none;' : ''; ?>"><?php esc_html_e( 'Remove Image', 'headless-redirect' ); ?></button>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="hr_page_title"><?php esc_html_e( 'Page Title', 'headless-redirect' ); ?></label>
                </th>
                <td>
                    <input type="text" id="hr_page_title" name="headless_redirect_options[page_title]"
                           value="<?php echo esc_attr( $opts['page_title'] ); ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="hr_description"><?php esc_html_e( 'Description / Message', 'headless-redirect' ); ?></label>
                </th>
                <td>
                    <textarea id="hr_description" name="headless_redirect_options[description]" rows="3"
                              class="large-text"><?php echo esc_textarea( $opts['description'] ); ?></textarea>
                </td>
            </tr>
        </table>

        <!-- ── Button Settings ─────────────────────────────── -->
        <h2><?php esc_html_e( 'Button Settings', 'headless-redirect' ); ?></h2>
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="hr_button_text"><?php esc_html_e( 'Button Text', 'headless-redirect' ); ?></label>
                </th>
                <td>
                    <input type="text" id="hr_button_text" name="headless_redirect_options[button_text]"
                           value="<?php echo esc_attr( $opts['button_text'] ); ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="hr_button_color"><?php esc_html_e( 'Button Color', 'headless-redirect' ); ?></label>
                </th>
                <td>
                    <input type="text" id="hr_button_color" name="headless_redirect_options[button_color]"
                           value="<?php echo esc_attr( $opts['button_color'] ); ?>" class="hr-color-picker" />
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="hr_button_text_color"><?php esc_html_e( 'Button Text Color', 'headless-redirect' ); ?></label>
                </th>
                <td>
                    <input type="text" id="hr_button_text_color" name="headless_redirect_options[button_text_color]"
                           value="<?php echo esc_attr( $opts['button_text_color'] ); ?>" class="hr-color-picker" />
                </td>
            </tr>
        </table>

        <!-- ── Behavior Settings ───────────────────────────── -->
        <h2><?php esc_html_e( 'Behavior Settings', 'headless-redirect' ); ?></h2>
        <table class="form-table">
            <tr>
                <th scope="row"><?php esc_html_e( 'Preserve URL Path', 'headless-redirect' ); ?></th>
                <td>
                    <label>
                        <input type="checkbox" name="headless_redirect_options[preserve_path]" value="1"
                               <?php checked( $opts['preserve_path'] ); ?> />
                        <?php esc_html_e( 'Map the current path to the frontend (e.g. /about/ → frontend/about/)', 'headless-redirect' ); ?>
                    </label>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="hr_auto_redirect"><?php esc_html_e( 'Auto-redirect (seconds)', 'headless-redirect' ); ?></label>
                </th>
                <td>
                    <input type="number" id="hr_auto_redirect" name="headless_redirect_options[auto_redirect]"
                           value="<?php echo esc_attr( $opts['auto_redirect'] ); ?>" min="0" max="60" step="1" class="small-text" />
                    <p class="description"><?php esc_html_e( 'Set to 0 to disable. Otherwise, visitors will be redirected after this many seconds.', 'headless-redirect' ); ?></p>
                </td>
            </tr>
        </table>

        <!-- ── Page Exemption Settings ───────────────────── -->
        <h2><?php esc_html_e( 'Page Exemption', 'headless-redirect' ); ?></h2>
        <p class="description"><?php esc_html_e( 'Select pages that should NOT show the landing page and instead load normally through WordPress.', 'headless-redirect' ); ?></p>
        <table class="form-table">
            <tr>
                <th scope="row"><?php esc_html_e( 'Exempted Pages', 'headless-redirect' ); ?></th>
                <td>
                    <?php
                    $exempted_pages = is_array( $opts['exempted_pages'] ) ? $opts['exempted_pages'] : array();
                    $all_pages      = get_pages( array(
                        'sort_column' => 'post_title',
                        'sort_order'  => 'ASC',
                        'post_status' => 'publish',
                    ) );
                    if ( ! empty( $all_pages ) ) :
                    ?>
                    <div style="max-height:300px;overflow-y:auto;border:1px solid #ccc;padding:10px;background:#fff;border-radius:4px;">
                        <?php foreach ( $all_pages as $page ) : ?>
                            <label style="display:block;margin-bottom:6px;cursor:pointer;">
                                <input type="checkbox"
                                       name="headless_redirect_options[exempted_pages][]"
                                       value="<?php echo esc_attr( $page->ID ); ?>"
                                       <?php checked( in_array( (int) $page->ID, array_map( 'intval', $exempted_pages ), true ) ); ?> />
                                <?php echo esc_html( $page->post_title ); ?>
                                <span style="color:#999;font-size:12px;">(<?php echo esc_html( get_permalink( $page->ID ) ); ?>)</span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <p class="description"><?php esc_html_e( 'Checked pages will bypass the landing page and render through WordPress normally.', 'headless-redirect' ); ?></p>
                    <?php else : ?>
                        <p class="description"><?php esc_html_e( 'No published pages found.', 'headless-redirect' ); ?></p>
                    <?php endif; ?>
                </td>
            </tr>
        </table>

        <!-- ── Style Settings ──────────────────────────────── -->
        <h2><?php esc_html_e( 'Style Settings', 'headless-redirect' ); ?></h2>
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="hr_background_color"><?php esc_html_e( 'Background Color', 'headless-redirect' ); ?></label>
                </th>
                <td>
                    <input type="text" id="hr_background_color" name="headless_redirect_options[background_color]"
                           value="<?php echo esc_attr( $opts['background_color'] ); ?>" class="hr-color-picker" />
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="hr_text_color"><?php esc_html_e( 'Text Color', 'headless-redirect' ); ?></label>
                </th>
                <td>
                    <input type="text" id="hr_text_color" name="headless_redirect_options[text_color]"
                           value="<?php echo esc_attr( $opts['text_color'] ); ?>" class="hr-color-picker" />
                </td>
            </tr>
        </table>

        <?php submit_button(); ?>
    </form>
</div>

<!-- Admin JS for media uploader & color pickers -->
<script>
jQuery(document).ready(function ($) {
    // ── Color Pickers ──
    $('.hr-color-picker').wpColorPicker();

    // ── Media Uploader ──
    var frame;
    $('#hr-upload-btn').on('click', function (e) {
        e.preventDefault();
        if (frame) { frame.open(); return; }
        frame = wp.media({
            title: '<?php echo esc_js( __( 'Select or Upload Image', 'headless-redirect' ) ); ?>',
            button: { text: '<?php echo esc_js( __( 'Use this image', 'headless-redirect' ) ); ?>' },
            multiple: false
        });
        frame.on('select', function () {
            var attachment = frame.state().get('selection').first().toJSON();
            $('#hr_logo_image').val(attachment.url);
            $('#hr-image-preview').html('<img src="' + attachment.url + '" style="max-width:300px;height:auto;" />');
            $('#hr-remove-btn').show();
        });
        frame.open();
    });

    $('#hr-remove-btn').on('click', function (e) {
        e.preventDefault();
        $('#hr_logo_image').val('');
        $('#hr-image-preview').html('');
        $(this).hide();
    });
});
</script>
