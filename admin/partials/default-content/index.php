<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Default content page
 *
 * @link       swaptify.com
 * @since      1.0.0
 *
 * @package    Swaptify
 * @subpackage swaptify/admin/partials/default-content
 */
?>
<div class="wrap">
                <div id="icon-themes" class="icon32"></div>  
                <h2>Swaptify Default Content</h2>  
                <p class="content-wrapper">Within each Segment, you must select one Swap to serve as the default content. This default content will be stored in your WordPress database and served when Swaptify is disabled, rate limited, or otherwise unable to connect. The list below shows all of your current default content inside of your WordPress database. After making updates to your Segments and Swaps, please use this tool to refresh your default content inside WordPress.
                </p>
                <?php settings_errors(); ?>
                
                <?php if ($items): ?>
                    <table border="1" cellpadding="20">
                        <thead>
                            <tr>
                                <th>Segment Name</th>
                                <th>Segment Key</th>
                                <th>Swap Name</th>
                                <th>Swap Key</th>
                                <th>Content</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td><?php echo(esc_html($item->segment_name)); ?></td>
                                    <td><?php echo(esc_html($item->segment_key)); ?></td>
                                    <td><?php echo(esc_html($item->swap_name)); ?></td>
                                    <td><?php echo(esc_html($item->swap_key)); ?></td>
                                    <td>
                                        <?php if ($item->type == 'image'): ?>
                                            <img src="<?php echo(esc_url($item->content)); ?>" style="width: 200px;" alt="<?php echo(esc_attr(($item->sub_content ?? ''))); ?>" title="<?php echo(esc_attr(($item->sub_content ?? ''))); ?>" />
                                        <?php elseif ($item->type == 'url'): ?>
                                            <a href="<?php echo(esc_url($item->content)); ?>" target="_blank"><?php echo(esc_html($item->sub_content)); ?></a> (<?php echo(esc_html($item->content)); ?>)
                                        <?php else: ?>
                                            <?php echo(esc_html($item->content)); ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div> There is no default content</div>
                <?php endif; ?>

                <form method="POST" action="/wp-admin/admin-post.php">
                    <?php wp_nonce_field('default_content', 'default_content'); ?>
                    <?php 
                        settings_fields('swaptify_default_content');
                        do_settings_sections('swaptify_default_content'); 
                    ?>             
                    <?php submit_button('Update Default Content'); ?>  
                </form> 
</div>