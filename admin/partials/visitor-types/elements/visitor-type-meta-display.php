<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Form field for showing visitor types when editing a page
 *
 * @link       swaptify.com
 * @since      1.0.0
 *
 * @package    Swaptify
 * @subpackage swaptify/admin/partials/visitor-types/elements
 */
?>
<?php wp_nonce_field('meta_page_visitor_types', 'meta_page_visitor_types'); ?>
<select name="swaptify_visitor_type">
    <option value="">&mdash; Select Visitor Type &mdash;</option>
    <?php foreach ($visitor_types as $key => $object): ?>   
        <option 
            value="<?php echo(esc_attr($key)) ?>"
            <?php if ($selected == $key): ?>
                selected="selected"
            <?php endif; ?>
        >
            <?php echo(esc_html($object->name)) ?>
        </option>
    <?php endforeach; ?>
</select>