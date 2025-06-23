jQuery(document).ready(function(){ 
    /**
     * remove the default value
     */
    jQuery('select[name="swaptify_property_key"] option[value=""]').remove();
    jQuery('select[name="swaptify_property_key"]').prop('disabled', true);
    jQuery('#swaptify_confirm_property_change').on('change', function(){
        if (jQuery(this).is(':checked'))
        {
            jQuery('select[name="swaptify_property_key"]').prop('disabled', false);
        }
        else
        {
            jQuery('select[name="swaptify_property_key"]').prop('disabled', true);
        } 
    });
    
    jQuery('#swaptify_config_form').on('submit', function(){
        
        const input = jQuery('<input>').attr('type', 'hidden').prop('name', 'swaptify_property_key').val(jQuery('select[name="swaptify_property_key"]').val());
        
        jQuery(this).append(input);
        
        return true;
    });
});