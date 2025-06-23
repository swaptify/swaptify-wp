<?php 

if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div class="wrap"> <!-- wrapper -->
<div>
    <a href="?page=swaptify-shortcode-generator">&lt;&lt; back</a>
</div>
<input type="hidden" id="segment_type" value="<?php echo(esc_attr($segment->type)); ?>" />

<?php 
/**
 * create a default editor to grab the tinyMCE and quicktag settings below
 */
if ($segment->type == 'text'): ?>
    <div style="display:none;">
        <?php wp_editor('', 'DEFAULTEDITOR'); ?>
    </div>
    <p class="wrap-content">
        Your Swap content may contain HTML, JavaScript (inside &lt;script&gt; tags), CSS (inside &lt;style&gt; tags), and shortcodes.
    </p>
<?php endif; ?>

<form method="POST" id="edit-swap-form" action="/wp-admin/admin-post.php">
    <?php wp_nonce_field('save_segment', 'save_segment'); ?>
    <div>
        <h3>Edit <?php echo(esc_html($segment->name)); ?></h3>
    </div>
    
    <?php if (!$segment->swaps): ?>
        <h4 style="margin: 40px 0; text-align: center;">No Swaps yet!</h4>
    <?php endif; ?>
    
    <?php foreach ($segment->swaps as $swap): ?>
        <div class="swap-div" data-swap_key="<?php echo(esc_attr($swap->key)); ?>">
            <div class="swaptify-segment-form-left">
                <label for="swap_name_<?php echo(esc_attr($swap->key)); ?>">Swap Name:</label> 
                <input 
                    type="text" 
                    name="swap_name[<?php echo(esc_attr($swap->key)); ?>]" 
                    id="swap_name_<?php echo(esc_attr($swap->key)); ?>" 
                    value="<?php echo(esc_attr($swap->name)); ?>" 
                    size="40"  
                    required="required" 
                />
                <br />
                
                <div>
                    <label for="publish-<?php echo(esc_attr($swap->key)); ?>">
                        <input 
                            type="checkbox"
                            id="publish-<?php echo(esc_attr($swap->key)); ?>"
                            name="publish[<?php echo(esc_attr($swap->key)); ?>]"
                            <?php if ($swap->published): ?>
                                checked="checked"
                            <?php endif; ?>
                        />
                        Publish
                    </label>    
                </div>
                
                <div>
                    <label for="active-<?php echo(esc_attr($swap->key)); ?>">
                        <input 
                            type="checkbox"
                            id="active-<?php echo(esc_attr($swap->key)); ?>"
                            name="active[<?php echo(esc_attr($swap->key)); ?>]"
                            <?php if ($swap->active): ?>
                                checked="checked"
                            <?php endif; ?>
                        />
                        Active
                    </label>    
                </div>
                
                <div>
                    <label for="default-<?php echo(esc_attr($swap->key)); ?>">
                        <input 
                            type="radio"
                            id="default-<?php echo(esc_attr($swap->key)); ?>"
                            name="default"
                            value="<?php echo(esc_attr($swap->key)); ?>"
                            <?php if ($swap->is_default): ?>
                                checked="checked"
                            <?php endif; ?>
                        />
                        Set as Default
                    </label>    
                </div>
                
                <?php if ($visitor_types): ?>
                <div class="visitor-types">
                    <h3>Visitor Types</h3>
                    <?php foreach ($visitor_types as $visitor_type): ?>
                        <div style="margin:5px;">
                            <label for="<?php echo(esc_attr($visitor_type->key)); ?>-<?php echo(esc_attr($swap->key)); ?>">
                                <input 
                                    type="checkbox" 
                                    id="<?php echo(esc_attr($visitor_type->key)); ?>-<?php echo(esc_attr($swap->key)); ?>"
                                    name="visitor_type[<?php echo(esc_attr($visitor_type->key)); ?>][<?php echo(esc_attr($swap->key)); ?>]"
                                    <?php 
                                        $visitorTypeKey = $visitor_type->key;
                                        if (isset($swap->visitor_types->$visitorTypeKey)): ?>
                                        checked="checked"
                                    <?php endif; ?>
                                />
                                <?php echo(esc_html($visitor_type->name)); ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="visitor-type-notice">
                <p>Visitor Types are not associated with Default Content.</p>
                </div>
                <?php endif; ?>
                <a href="javascript:void(0);" class="button delete">Delete Swap</a>
            </div>
            <div class="swaptify-segment-form-right">
                <?php if ($segment->type == 'text'): ?>
                    <?php wp_editor($swap->content, 'content-' . $swap->key); ?><br />
                <?php elseif ($segment->type == 'url'): ?>
                    <table class="form-table" role="presentation">
                        <tbody>
                            <tr>
                                <th scope="row">
                                    <label for="swap_content_<?php echo(esc_attr($swap->key)); ?>">URL</label>
                                </th>
                                <td>
                                    <input 
                                        type="text" 
                                        id="swap_content_<?php echo(esc_attr($swap->key)); ?>"
                                        name="content-<?php echo(esc_attr($swap->key)); ?>" 
                                        value="<?php echo(esc_attr($swap->content)); ?>" 
                                        size="40"
                                        required="required"
                                    />
                                    <span class="swap-preview-link" id="swap_preview_<?php echo(esc_attr($swap->key)); ?>">
                                        <a target="_blank" href="<?php echo(esc_html($swap->content)); ?>" title="Preview Link">
                                            preview 
                                            <span class="dashicons dashicons-external"></span>
                                        </a>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="swap_subcontent_<?php echo(esc_attr($swap->key)); ?>">Link Text</label>
                                </th>
                                <td>
                                    <input 
                                        type="text" 
                                        id="swap_subcontent_<?php echo(esc_attr($swap->key)); ?>"
                                        name="sub_content[<?php echo(esc_attr($swap->key)); ?>]" 
                                        value="<?php echo(esc_attr(($swap->sub_content ?? ''))); ?>" 
                                        size="40"
                                        required="required"
                                    />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                <?php elseif ($segment->type == 'image'): ?>
                    <div>
                        <img class="swap-preview-image" id="swap_image_<?php echo(esc_attr($swap->key)); ?>" src="<?php echo(esc_url($swap->content)); ?>" />
                        <span class="swap-preview-link" id="swap_preview_<?php echo(esc_attr($swap->key)); ?>">
                            <a target="_blank" href="<?php echo(esc_url($swap->content)); ?>" title="Preview Image">
                                preview 
                                <span class="dashicons dashicons-external"></span>
                            </a>
                        </span>
                    </div>
                    <table class="form-table" role="presentation">
                        <tbody>
                            <tr>
                                <th scope="row">
                                    <label for="swap_content_<?php echo(esc_attr($swap->key)); ?>">Image URL</label>
                                </th>
                                <td>
                                    <input 
                                        type="text" 
                                        id="swap_content_<?php echo(esc_attr($swap->key)); ?>"
                                        name="content-<?php echo(esc_attr($swap->key)); ?>" 
                                        value="<?php echo(esc_attr($swap->content)); ?>" 
                                        size="80"
                                        required="required"
                                    /> 
                                </td>
                                
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="swap_subcontent_<?php echo(esc_attr($swap->key)); ?>">Alt Text</label>
                                </th>
                                <td>
                                    <input 
                                        type="text" 
                                        id="swap_subcontent_<?php echo(esc_attr($swap->key)); ?>"
                                        name="sub_content[<?php echo(esc_attr($swap->key)); ?>]" 
                                        value="<?php echo(esc_attr(($swap->sub_content ?? ''))); ?>" 
                                        size="40"
                                    />
                                </td>
                            </tr>
                            <tr id="swap_sizes_div_<?php echo(esc_attr($swap->key)); ?>" style="display:none;">
                                <th scope="row">
                                    <label for="swap_sizes_<?php echo(esc_attr($swap->key)); ?>">Size</label>
                                </th>
                                <td>
                                    <select id="swap_sizes_<?php echo(esc_attr($swap->key)); ?>">
                                        
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="swaptify-media-library-edit-button" data-swap_key="<?php echo(esc_attr($swap->key)); ?>">
                        <a href="javascript:void(0);">Add from Media Library</a>
                    </div> 
                <?php endif; ?> 
                
            </div>
            <div style="clear:both;"></div>
        </div>
    <?php endforeach; ?>
    <div id="new-swaps"></div>
    <a href="javascript:void(0);" class="button" id="add-new-swap-button">Add new Swap</a>
    <?php submit_button('Save'); ?>  
    <input type="hidden" name="segment_key" value="<?php echo(esc_attr($segment->key)); ?>" />
    <input type="hidden" name="action" value="save_swaptify_segment" />
</form> 

<div id="new-swap-field" style="display:none";>
    <div class="swaptify-segment-form-left">
        <label for="swap_name_">Swap Name:</label> 
        <input 
            type="text" 
            name="swap_name[]" 
            id="swap_name_" 
            value="" 
            size="40"  
            required="required" 
        />
        <br />
        
        <div>
            <label for="publish-">
                <input 
                    type="checkbox"
                    id="publish-"
                    name="publish[]"
                />
                Publish
            </label>    
        </div>
        
        <div>
            <label for="active-">
                <input 
                    type="checkbox"
                    id="active-"
                    name="active[]"
                />
                Active
            </label>    
        </div>
        
        <div>
            <label for="default-">
                <input 
                    type="radio"
                    id="default-"
                    name="default"
                    value=""
                />
                Set as Default
            </label>    
        </div>
        
        <?php if ($visitor_types): ?>
        <div class="visitor-types">
            <h3>Visitor Types</h3>
            <?php foreach ($visitor_types as $visitor_type): ?>
                <div style="margin:5px;" class="visitor_type_input" data-visitor_type_key="<?php echo(esc_attr($visitor_type->key)); ?>">
                    <label for="<?php echo(esc_attr($visitor_type->key)); ?>-">
                        <input 
                            type="checkbox" 
                            id="<?php echo(esc_attr($visitor_type->key)); ?>-"
                            name="visitor_type[<?php echo(esc_attr($visitor_type->key)); ?>][]"
                        />
                        <?php echo(esc_html($visitor_type->name)); ?>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="visitor-type-notice">
            <p>Visitor Types are not associated with Default Content.</p>
        </div>
        <?php endif; ?>
        
        <a href="javascript:void(0);" class="button remove">Remove</a>
    </div>
    <div class="swaptify-segment-form-right">
        <?php  if ($segment->type == 'text'): ?>
            <textarea></textarea>
        <?php elseif ($segment->type == 'url'): ?>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label for="swap_content_">URL</label>
                        </th>
                        <td>
                            <input 
                                type="text" 
                                id="swap_content_"
                                name="content-" 
                                value="" 
                                size="40"
                                required="required"
                            />
                            <span class="swap-preview-link" id="swap_preview_">
                                <a target="_blank" href="" title="Preview Link">
                                    preview 
                                    <span class="dashicons dashicons-external"></span>
                                </a>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="swap_subcontent_">Link Text</label>
                        </th>
                        <td>
                            <input 
                                type="text" 
                                id="swap_subcontent_"
                                name="sub_content_" 
                                value="" 
                                size="40"
                                required="required"
                            />
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php elseif ($segment->type == 'image'): ?>
            <div>
                <img class="swap-preview-image" id="swap_image_" src="" />
                <span class="swap-preview-link" id="swap_preview_">
                    <a target="_blank" href="" title="Preview Image">
                        preview 
                        <span class="dashicons dashicons-external"></span>
                    </a>
                </span>
            </div>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label for="swap_content_">Image URL</label>
                        </th>
                        <td>
                            <input 
                                type="text" 
                                id="swap_content_"
                                name="content-" 
                                value="" 
                                size="80"
                                required="required"
                            /> 
                        </td>
                        
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="swap_subcontent_">Alt Text</label>
                        </th>
                        <td>
                            <input 
                                type="text" 
                                id="swap_subcontent_"
                                name="sub_content_" 
                                value="" 
                                size="40"
                            />
                        </td>
                    </tr>
                    <tr id="swap_sizes_div_" style="display:none;">
                        <th scope="row">
                            <label for="swap_sizes_">Size</label>
                        </th>
                        <td>
                            <select id="swap_sizes_">
                                
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="swaptify-media-library-edit-button" data-swap_key="">
                <a href="javascript:void(0);">Add from Media Library</a>
            </div> 
        <?php endif; ?> 
        
    </div>
    <div style="clear:both;"></div>
</div>

<form id="delete-swap-form" action="/wp-admin/admin-post.php" method="POST" style="display:none;">
    <?php wp_nonce_field('delete_swap', 'delete_swap'); ?>
    <input type="hidden" name="swap" value="" />
    <input type="hidden" name="action" value="delete_swaptify_swap" />
</form>

<!-- end wrapper --></div> 