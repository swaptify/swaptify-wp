<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Form field for showing page view events when editing a page
 *
 * @link       swaptify.com
 * @since      1.0.0
 *
 * @package    Swaptify
 * @subpackage swaptify/admin/partials/events/elements
 */
?>
<?php wp_nonce_field('meta_page_events', 'meta_page_events'); ?>
<?php foreach ($events as $key => $object): ?>   
    <?php $swaptify_event_id = 'swap-' . $key; ?>
    <div>
        <label for="<?php echo(esc_attr($swaptify_event_id)); ?>">
            <input 
                id="<?php echo(esc_attr($swaptify_event_id)); ?>" 
                type="checkbox" 
                name="swaptify_events[]" 
                value="<?php echo(esc_attr($key)); ?>" 
                <?php echo((isset($object->checked) && $object->checked) ? 'checked="checked"':''); ?> 
            />
            <?php echo(esc_html($object->name)); ?>
        </label>
    </div>
<?php endforeach;
