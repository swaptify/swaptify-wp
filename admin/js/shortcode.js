const updatePreview = (element, isNew) => {
    let type = jQuery('#segment_type').val();
    
    let previewPrefix = '#swap_preview_';
    let imagePrefix = '#swap_image_';
    
    if (isNew)
    {
        previewPrefix = '#new_swap_preview_';
        imagePrefix = '#new_swap_image_';
    }
    
    
    let name = element.attr('name');
    let key = null;
    
    if (name)
    {
        key = name.split('-')[1];
    }
    
    let value = element.val();
    if (key && jQuery(previewPrefix + key).length)
    {
        jQuery(previewPrefix + key).find('a').attr('href', value);
        if (type == 'image')
        {
            jQuery(imagePrefix + key).attr('src', value);
        }
    }
}

let submit = false;

const beforeUnloadHandler = (event) => {
    // Recommended
    event.preventDefault();

    // Included for legacy support, e.g. Chrome/Edge < 119
    event.returnValue = true;
};


let newSwapId = 1;

jQuery(function(){
    
    jQuery('#add-new-swap-button').on('click', function(e){
        
        let type = jQuery('#segment_type').val();
        e.preventDefault();
        
        let div = jQuery('<div>').addClass('swap-div').html(jQuery('#new-swap-field').html());
        
        /**
         * general inputs
         */
        div.find('.swaptify-segment-form-left label[for="swap_name_"]').attr('for', 'new_swap_name_' + newSwapId);
        div.find('.swaptify-segment-form-left input[name="swap_name[]"]')
            .attr('name', 'new_swap_name[' + newSwapId + ']')
            .attr('id', 'new_swap_name_' + newSwapId);
        
        div.find('.swaptify-segment-form-left label[for="publish-"]').attr('for', 'new_publish_' + newSwapId);
        div.find('.swaptify-segment-form-left input[name="publish[]"]')
            .attr('name', 'new_publish[' + newSwapId + ']')
            .attr('id', 'new_publish_' + newSwapId)
            .prop('checked', 'checked');
        
        div.find('.swaptify-segment-form-left label[for="active-"]').attr('for', 'new_active_' + newSwapId);
        div.find('.swaptify-segment-form-left input[name="active[]"]')
            .attr('name', 'new_active[' + newSwapId + ']')
            .attr('id', 'new_active_' + newSwapId)
            .prop('checked', 'checked');
        
        div.find('.swaptify-segment-form-left label[for="default-"]').attr('for', 'new_default_' + newSwapId);
        div.find('.swaptify-segment-form-left input[id="default-"]').attr('id', 'new_default_' + newSwapId).val(newSwapId);
        
        div.find('.visitor_type_input').each(function(){
            let input = jQuery(this);
            let key = jQuery(this).data('visitor_type_key');
            input.find('label').attr('for', key + '-new_swap_' + newSwapId);
            input.find('input')
                .attr('id', key + '-new_swap_' + newSwapId)
                .attr('name', 'new_visitor_type[' + key + '][' + newSwapId+ ']');
        });
        
        div.find('.swaptify-segment-form-right label[for="swap_content_"]').attr('for', 'new_swap_content_' + newSwapId);
        div.find('.swaptify-segment-form-right input[name="content-"]')
            .attr('name', 'new_content-' + newSwapId)
            .attr('id', 'new_swap_content_' + newSwapId)
            .on('change', function(){
                updatePreview(jQuery(this), true);
            })
            .on('keyup', function(){
                updatePreview(jQuery(this), true);
            });
            
        div.find('textarea').attr({
            id: 'new_content-' + newSwapId,
            name: 'new_content-' + newSwapId,
            rows: 20
        }).addClass('wp-editor-area');
        
        div.find('.swaptify-segment-form-right label[for="swap_subcontent_"]').attr('for', 'new_swap_subcontent_' + newSwapId);
        div.find('.swaptify-segment-form-right input[name="sub_content_"]')
            .attr('name', 'new_sub_content[' + newSwapId + ']')
            .attr('id', 'new_swap_subcontent_' + newSwapId);
        
        div.find('.swap-preview-image')
            .attr('id', 'new_swap_image_' + newSwapId)
            .attr('src', swaptify_image_path.swaptify_image_path + 'images/image.jpg');
            
        div.find('.swap-preview-link').attr('id', 'new_swap_preview_' + newSwapId);
        div.find('#swap_sizes_div_').attr('id', 'new_swap_sizes_div_' + newSwapId);
        
        div.find('.swaptify-media-library-edit-button').data('new_swap_key', newSwapId);
        
        div.find('.remove').on('click', function(){
            if (confirm('Are you sure you want to remove this Swap?'))
            {
                jQuery(this).closest('.swap-div').remove();
            }
        });
        
        jQuery('#new-swaps').append(div);
        
        if (div.find('textarea').length)
        {
            let content_id = 'new_content-' + newSwapId;
            
            let tinyMCESettings = tinyMCEPreInit.mceInit['DEFAULTEDITOR'];
            tinyMCESettings.selector = '#' + content_id;
            tinyMCESettings.body_class = content_id;
            tinyMCESettings.elementpath = true;
            
            let quickTagSettings = tinyMCEPreInit.qtInit['DEFAULTEDITOR'];
            quickTagSettings.id = content_id;
            
            wp.editor.initialize(content_id, {
                tinymce: tinyMCESettings, 
                quicktags: quickTagSettings, 
                mediaButtons: true
            });    
        }
        
        jQuery('#new_swap_name_' + newSwapId).focus();
        
        newSwapId++;
        
        window.addEventListener("beforeunload", beforeUnloadHandler);
    });
    
    jQuery('form').find('.delete').on('click', function(){
            if (confirm('Are you sure you want to delete this Swap? This cannot be undone'))
            {
                let form = jQuery('#delete-swap-form');
                let swap_key = jQuery(this).closest('.swap-div').data('swap_key');
                form.find('input[name="swap"]').val(swap_key);
                form.submit();
            }
        });
    
    jQuery('input, textarea, select').on('change', function(){
        window.addEventListener("beforeunload", beforeUnloadHandler);
    });
    
    jQuery('input, textarea').on('keyup', function(){
        window.addEventListener("beforeunload", beforeUnloadHandler);
    });
    
    
    jQuery('#edit-swap-form').on('submit', function(){
        window.removeEventListener("beforeunload", beforeUnloadHandler);
    });
    
    jQuery('input[name^="content-"]').on('change', function(){
        updatePreview(jQuery(this), false);
    });
    
    jQuery('input[name^="content-"]').on('keyup', function(){
        updatePreview(jQuery(this), false);
    });
    
    jQuery(document).on('click','.swaptify-media-library-edit-button > a', function(e) 
    {
        jQuery('[id^=swap_sizes_div_]').hide();
        jQuery('[id^=new_swap_sizes_div_]').hide();
        
        let  swap_key = jQuery(this).closest('.swaptify-media-library-edit-button').data('swap_key');
        let new_swap = false;
        
        if (!swap_key)
        {
            swap_key = jQuery(this).closest('.swaptify-media-library-edit-button').data('new_swap_key');
            if (swap_key)
            {
                new_swap = true;
            }
        }
        
        
        let imagePrefix = '#swap_image_';
        let previewPrefix = '#swap_preview_';
        let contentPrefix = '#swap_content_';
        let subcontentPrefix = '#swap_subcontent_';
        let sizesPrefix = '#swap_sizes_div_';
        
        if (new_swap)
        {
            imagePrefix = '#new_swap_image_';
            previewPrefix = '#new_swap_preview_';
            contentPrefix = '#new_swap_content_';
            subcontentPrefix = '#new_swap_subcontent_';
            sizesPrefix = '#new_swap_sizes_div_';
        }
        
        let frame;
        
        e.preventDefault();
        // If the upload object has already been created, reopen the dialog
        if (frame) 
        {
            frame.open();
            return;
        }
        
        // Extend the wp.media object
        frame = wp.media.frames.file_frame = wp.media({
            title: 'Select media',
            button: {
                text: 'Select media'
            }, 
            multiple: false 
        });

        // When a file is selected, grab the URL and set it as the text field's value
        frame.on('select', function() {
            let selection = frame.state().get('selection');
            selection.map(function(attachment)
            {
                // new-swap-name
                // new-swap-content
                // new-swap-sub_content
                let attachmentObject = attachment.toJSON();
                
                let element = jQuery('#swap-form-inputs-div');
                
                if (attachmentObject.sizes.thumbnail)
                {
                    jQuery(imagePrefix + swap_key).attr({'src': attachmentObject.sizes.thumbnail.url});
                }
                
                const value = attachmentObject.sizes.full.url;
                
                jQuery(contentPrefix + swap_key).val(value);
                jQuery(subcontentPrefix + swap_key).val(attachmentObject.title);
                jQuery(contentPrefix + swap_key).trigger('change');
                
                
                let select = jQuery(sizesPrefix + swap_key + ' select');
                select.empty();
                
                for (const size of Object.keys(attachmentObject.sizes))
                {
                    const option = jQuery('<option>').val(attachmentObject.sizes[size].url).html(size);
                    
                    if (attachmentObject.sizes[size].url == value)
                    {
                        option.attr('selected', 'selected');
                    }
                    
                    select.append(option);   
                }
                
                
                select.off('change');
                select.on('change', function(){
                    jQuery(contentPrefix + swap_key).val(jQuery(this).val());
                    jQuery(contentPrefix + swap_key).trigger('change');
                });
                
                jQuery(sizesPrefix + swap_key).show();
                
            });
        });
        
        // Open the upload dialog
        frame.open();
    }); 

    //control visitor type visibility based on default selection
    jQuery('#add-new-swap-button').click(function(){ //first swap force to default
        if (jQuery('.swap-div').length === 1) {
            jQuery('.swap-div').addClass('default');
            jQuery('.swap-div label[for*="default"] > input').prop("checked", true);
        }
    });
    
    jQuery('label[for*="default"] > input:checked').closest('.swap-div').addClass('default'); //hide visitor types for current default

    jQuery('#edit-swap-form').on('click', 'label[for*="default"]', function(){ //allow default switching
        jQuery('label[for*="default"] > input').closest('.swap-div').removeClass('default');
        jQuery('label[for*="default"] > input:checked').closest('.swap-div').addClass('default');
    });
});