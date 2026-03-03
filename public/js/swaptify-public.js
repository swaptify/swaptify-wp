let swaptifySwaps = null;

let swaptifyConnecting = {
    swaps: false,
    visitor_type: false,
    event: false,
};

SwaptifyWP = {
    visitor_type: function(keyOrName, refreshSwaps = false) {
        
        if (swaptifyConnecting.visitor_type) {
            return;
        }
        
        swaptifyConnecting.visitor_type = true;
        
        const url = swaptify_ajax.swaptify_ajax_url;
        
        if (refreshSwaps) {
            SwaptifyWP.blur();
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
            
            swaptifyConnecting.visitor_type = false;
            
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
        if (swaptifyConnecting.event) {
            return;
        }
        
        swaptifyConnecting.event = true;
        
        const url = swaptify_ajax.swaptify_ajax_url;
        
        let id = jQuery('#swaptify_id').val();
        
        if (refreshSwaps) {
            SwaptifyWP.blur();
        }
        
        jQuery.post(url, {
            action: 'swaptify_event',
            key: key,
            swaptify_wp_nonce: swaptify_ajax.nonce,
            refresh_swaps: refreshSwaps,
            id: id,
            url: window.location.href
        }, function(response) {
            swaptifyConnecting.event = false;
            
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
        
        if (swaptifyConnecting.swaps) {
            return;
        }
        
        SwaptifyWP.blur();
        
        swaptifyConnecting.swaps = true;
        
        const url = swaptify_ajax.swaptify_ajax_url;
        
        let id = jQuery('#swaptify_id').val();
        
        jQuery.post(url, {
            action: 'swaptify_get_swaps',
            id: id,
            url: window.location.href,
            swaptify_wp_nonce: swaptify_ajax.nonce
        }, function(response) {
            swaptifyConnecting.swaps = false;
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
                    var div = jQuery('<div>').addClass('swaptify-inner-content');
                    var img = jQuery('<img>');
                    
                    img.attr('src', swaptifySwaps.data[segmentKey]);
                    img.attr('title', swaptifySwaps.subdata[segmentKey]);
                    
                    div.append(img);
                    
                    segment.empty();
                    segment.html(div);
                }
                else if (type == 'url')
                {
                    var div = jQuery('<div>');
                    var anchor = jQuery('<a>');
                    
                    anchor.attr('href', swaptifySwaps.data[segmentKey]);
                    anchor.text(swaptifySwaps.subdata[segmentKey]);
                    
                    div.append(anchor);
                    
                    segment.empty();
                    segment.append(div);
                }
                else 
                {
                    var div = jQuery('<div>').addClass('swaptify-inner-content');
                    div.html(swaptifySwaps.data[segmentKey]);
                    
                    segment.empty();
                    segment.append(div);
                }
                
                segment.removeClass('swaptify-blur');
                segment.addClass('swaptify-unblur');
            }
        }
    },
    clean_swaps: function() {
        jQuery('.swaptify-render-segment').find('.swaptify-render-swap:not(:visible)').remove();
    },
    grant_consent: function(refreshSwaps = false) {
        
        if (refreshSwaps) {
            SwaptifyWP.blur();
        }
        
        const url = swaptify_ajax.swaptify_ajax_url;
        
        jQuery.post(
            url, 
            {
                action: 'swaptify_grant_consent',
                swaptify_wp_nonce: swaptify_ajax.nonce,
                url: window.location.href
            }, 
            function(response) {
                if (refreshSwaps) {
                    if (response.success) {
                        SwaptifyWP.get_swaps();
                    } else {
                        SwaptifyWP.unblur();
                    }
                }
            },
            'json'
        );
    },
    revoke_consent: function(refreshSwaps = false) {
        
        if (refreshSwaps) {
            SwaptifyWP.blur();
        }
            
        const url = swaptify_ajax.swaptify_ajax_url;
        
        jQuery.post(
            url, 
            {
                action: 'swaptify_revoke_consent',
                swaptify_wp_nonce: swaptify_ajax.nonce,
                url: window.location.href
            }, 
            function(response) {
                if (refreshSwaps) {
                    if (response.success) {
                        SwaptifyWP.get_swaps();
                    } else {
                        SwaptifyWP.unblur();
                    }
                }
            },
            'json'
        );
    },
    blur: function() {
        jQuery('.swaptify-render-segment').removeClass('swaptify-unblur');
        jQuery('.swaptify-render-segment').addClass('swaptify-blur');
    },
    unblur: function() {
        jQuery('.swaptify-render-segment').removeClass('swaptify-blur');
        jQuery('.swaptify-render-segment').addClass('swaptify-unblur');
    }
}