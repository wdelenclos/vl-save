<?php
if (!defined('ABSPATH')) {
    exit();
}
?>
<div class="pt-form-wrapper">
    <form action="<?php echo admin_url(); ?>options-general.php?page=<?php echo PTCore::$PAGE_SETTINGS; ?>" method="post" name="<?php echo PTCore::$PAGE_SETTINGS; ?>" class="pt-form">
        <?php
        wp_nonce_field('pt_form');
        $postTypes = get_post_types(array(), 'names');
        ?>
        <table class="wp-list-table widefat plugins pt-options-table">
            <tbody>
                <tr>
                    <th class="pt-settings-heading" colspan="2"><?php _e('Post Thumbnail settings', 'post-thumbnail'); ?></th>
                </tr>
                <tr>
                    <th class="pt-option-desc"><?php _e('Add thumbnails on these post types', 'post-thumbnail'); ?></th>
                    <td>
                        <?php
                        foreach ($postTypes as $postType) {
                            $postType = sanitize_text_field($postType);
                            if (post_type_exists($postType) && post_type_supports($postType, 'thumbnail')) {
                                ?>
                                <div class="pt-posttypes">
                                    <input id="type-<?php echo $postType; ?>" type="checkbox" name="postTypes[]" value="<?php echo $postType; ?>" <?php checked(in_array($postType, $this->postTypes)); ?>/>
                                    <label for="type-<?php echo $postType; ?>"><?php echo $postType; ?></label>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th class="pt-option-desc">
                        <label for="pt-thumbnail-width"><?php _e('Thumbnail width', 'post-thumbnail'); ?></label>
                        <p><i><?php _e('leave blank or set 0 for auto width', 'post-thumbnail'); ?></i></p>
                    </th>
                    <td><input id="pt-thumbnail-width" type="number" name="thumbWidth" value="<?php echo absint($this->thumbWidth); ?>" /> px</td>
                </tr>
                <tr>
                    <th class="pt-option-desc">
                        <label for="pt-thumbnail-height"><?php _e('Thumbnail height', 'post-thumbnail'); ?></label>
                        <p><i><?php _e('leave blank or set 0 for auto height', 'post-thumbnail'); ?></i></p>
                    </th>
                    <td><input id="pt-thumbnail-height" type="number" name="thumbHeight" value="<?php echo absint($this->thumbHeight); ?>" /> px</td>
                </tr>
                <tr>
                    <th class="pt-option-desc"><label for="pt-thumbnail-default"><?php _e('Default image if no thumbnail available', 'post-thumbnail'); ?></label></th>
                    <td>
                        <input id="pt-thumbnail-default" type="text" name="thumbDefault" value="<?php echo esc_url($this->thumbDefault); ?>" />
                        <input id="defaultThumbnail" type="button" class="button button-secondary" value="<?php _e('Add image', 'post-thumbnail'); ?>" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" class="button button-primary pt-submit" value="<?php _e('Save', 'post-thumbnail'); ?>" name="pt_submit"/>                        
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>