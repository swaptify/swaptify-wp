let swaptifySwaps = null;
let swaptifyConnecting = false;

SwaptifyWP = {
    visitor_type: function(keyOrName, refreshSwaps = false) {
        
        if (swaptifyConnecting) {
            return;
        }
        
        swaptifyConnecting = true;
        
        const url = swaptify_ajax.swaptify_ajax_url;
        
        if (refreshSwaps) {
            jQuery('.swaptify-render-segment').removeClass('swaptify-unblur');
            jQuery('.swaptify-render-segment').addClass('swaptify-blur');
        }
        
        let id = jQuery('#swaptify_id').val();
        
        jQuery.post(url, {
            action: 'swaptify_visitor_type',
            key: keyOrName,
            swaptify_wp_nonce: swaptify_ajax.nonce,
            refresh_swaps: refreshSwaps,
            id: id,
            url: window.location.href
        }, function(response) {
            
            swaptifyConnecting = false;
            
            if (response.visitor_types) 
            {
                jQuery('body').removeClass(function (index, className) {
                    let pattern = '\\b' + swaptify.slug_prefix + '\\S+';
                    let regex = new RegExp(pattern, 'g');
                    
                    return (className.match (regex) || []).join(' ');
                });
                
                for (var i = 0; i < response.visitor_types.length; i++)
                {
                    jQuery('body').addClass(swaptify.slug_prefix + response.visitor_types[i].slug);
                }
            }
            
            if (refreshSwaps) {
                if (response.swaps) {   
                    swaptifySwaps = response.swaps;
                }
                
                jQuery(document).ready(function(){
                    SwaptifyWP.render_swaps(); 
                    SwaptifyWP.clean_swaps();
                });
            }
        },
        'json');
    },    
    event: function(key, refreshSwaps = false) {
        if (swaptifyConnecting) {
            return;
        }
        
        swaptifyConnecting = true;
        
        const url = swaptify_ajax.swaptify_ajax_url;
        
        let id = jQuery('#swaptify_id').val();
        
        if (refreshSwaps) {
            jQuery('.swaptify-render-segment').removeClass('swaptify-unblur');
            jQuery('.swaptify-render-segment').addClass('swaptify-blur');
        }
        
        jQuery.post(url, {
            action: 'swaptify_event',
            key: key,
            swaptify_wp_nonce: swaptify_ajax.nonce,
            refresh_swaps: refreshSwaps,
            id: id,
            url: window.location.href
        }, function(response) {
            swaptifyConnecting = false;
            
            if (refreshSwaps) {
                
                if (response.swaps) {
                    swaptifySwaps = response.swaps;
                }
                
                jQuery(document).ready(function(){
                    SwaptifyWP.render_swaps(); 
                    SwaptifyWP.clean_swaps();
                });
            }
        },
        'json');
    },
    get_swaps: function() {
        
        if (jQuery('body').hasClass('preview') || swaptify.preview)
        {
            SwaptifyWP.clean_swaps();
            return;
        }
        
        if (swaptifyConnecting) {
            return;
        }
        
        swaptifyConnecting = true;
        
        const url = swaptify_ajax.swaptify_ajax_url;
        
        let id = jQuery('#swaptify_id').val();
        
        jQuery.post(url, {
            action: 'swaptify_get_swaps',
            id: id,
            url: window.location.href,
            swaptify_wp_nonce: swaptify_ajax.nonce
        }, function(response) {
            swaptifyConnecting = false;
            if (response.swaps)
            {
                swaptifySwaps = response.swaps;
                
                if (response.visitor_types) 
                {
                    jQuery('body').removeClass(function (index, className) {
                        let pattern = '\\b' + swaptify.slug_prefix + '\\S+';
                        let regex = new RegExp(pattern, 'g');
                        
                        return (className.match (regex) || []).join(' ');
                    });
                    
                    for (var i = 0; i < response.visitor_types.length; i++)
                    {
                        jQuery('body').addClass(swaptify.slug_prefix + response.visitor_types[i].slug);
                    }
                }
            }
            
            jQuery(document).ready(function(){
                SwaptifyWP.render_swaps(); 
                SwaptifyWP.clean_swaps();
            });
        },
        'json');
        
    },
    render_swaps: function() {
        if (swaptifySwaps)
        {
            for (const segmentKey in swaptifySwaps.keys) 
            {
                var segment = jQuery('[data-swaptify_segment=' + segmentKey + ']');
                var type = swaptifySwaps.types[segmentKey];
                
                if (type == 'image')
                {
                    var img = jQuery('<img>');
                    img.attr('src', swaptifySwaps.data[segmentKey]);
                    img.attr('title', swaptifySwaps.subdata[segmentKey]);
                    segment.html('<div class="swaptify-inner-content">' + img + '</div>');
                }
                else if (type == 'url')
                {
                    var anchor = jQuery('<a>');
                    anchor.attr('href', swaptifySwaps.data[segmentKey]);
                    anchor.html(swaptifySwaps.subdata[segmentKey]);
                    segment.html('<div class="swaptify-inner-content">' + anchor + '</div>');
                }
                else 
                {
                    segment.html('<div class="swaptify-inner-content">' + swaptifySwaps.data[segmentKey] + '</div>');
                }
                segment.removeClass('swaptify-blur');
                segment.addClass('swaptify-unblur');
            }
        }
    },
    clean_swaps: function() {
        jQuery('.swaptify-render-segment').find('.swaptify-render-swap:not(:visible)').remove();
    }
}