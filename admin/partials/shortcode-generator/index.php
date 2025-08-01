<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode Generator page
 *
 * @link       swaptify.com
 * @since      1.0.0
 *
 * @package    Swaptify
 * @subpackage swaptify/admin/partials/shortcode-generator
 */
?>

<div class="wrap">
    <div id="icon-themes" class="icon32"></div>  
    <h2>Swaptify Shortcode Generator</h2>  
    <p class="content-wrapper">This interface will allow you to create Segements and Swaps, assign Swaps to Visitor Types, and assign Default Content, all from the familiar WordPress classic editor. These Segments and Swaps will be synced with your Swaptify account.
    </p>
    <?php settings_errors(); ?>
    <table class="max-width" border="1" style="width: 100%">
        <thead>
            <th>Segment Name</th>
            <th>Segment Key</th>
            <th>Shortcode</th>
            <th>Type</th>
            <th>Swaps</th>
            <th>Edit</th>
            <th>Delete</th>
        </thead>
        <tbody>
                
            <?php foreach($segments as $key => $segment): ?>
                <tr>
                    <td><a href="?page=swaptify-shortcode-generator&key=<?php echo(esc_attr($segment->key)) ?>&segment_nonce=<?php echo(esc_attr(wp_create_nonce('segment_nonce'))) ?>"><?php echo(esc_html($segment->name)) ?></a></td>
                    <td><?php echo(esc_html($key)) ?></td>
                    <td><?php echo(esc_html(Swaptify::generateDisplayShortcode($segment->type, $segment->key))) ?></td>
                    <td><?php echo(esc_html($segment->type)) ?></td>
                    <td>
                        <?php foreach($segment->swaps as $swap_key => $swap): ?>
                            <?php echo(esc_html($swap->name)) ?><br />    
                        <?php endforeach; ?>
                    </td>
                    <td><a href="?page=swaptify-shortcode-generator&key=<?php echo(esc_attr($segment->key)) ?>&segment_nonce=<?php echo(esc_attr(wp_create_nonce('segment_nonce'))) ?>">edit</a></td>
                    <td><a target="_blank" href="<?php echo(esc_url(Swaptify::$url)) ?>/segments/<?php echo(esc_attr($segment->key)) ?>/edit">delete</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <form method="POST" id="create-segment-form" action="/wp-admin/admin-post.php">
        <?php wp_nonce_field('create_segment', 'create_segment'); ?>
        <h3>Create New Segment</h3>
        <table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="segment_name">Name</label>
                    </th>
                    <td>
                        <input 
                            type="text" 
                            id="segment_name"
                            name="name" 
                            size="40"
                            required="required"
                        />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="type">Type</label>
                    </th>
                    <td>
                    <select name="type" required="required" width="40">
                        <option value="">&mdash; Select Type &mdash;</option>
                        <?php foreach($types as $type): ?>
                            <option value="<?php echo(esc_attr($type->id)) ?>"><?php echo(esc_html($type->name)) ?></option>
                        <?php endforeach; ?>
                    </select>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <input type="hidden" name="action" value="create_swaptify_segment" />
        <?php submit_button('Create New Segment'); ?>
    </form>
</div>