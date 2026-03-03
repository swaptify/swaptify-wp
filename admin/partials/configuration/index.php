<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Configuration page
 *
 * @link       swaptify.com
 * @since      1.0.0
 *
 * @package    Swaptify
 * @subpackage swaptify/admin/partials/configuration
 */
?>
<div class="wrap">
    <div id="icon-themes" class="icon32"></div>  
    <h2>Swaptify Settings</h2>  
    <?php settings_errors(); ?> 
    
    <p>Connect your Swaptify Account by adding your API Access Token and selecting a property.</p>
    <p>You can find your API Access Token <a href="<?php echo(esc_url(Swaptify::$url)); ?>/account/api" target="_blank">here</a>.</p>
    <p>You can turn Swaptify off at any time by setting "Enabled" to "No". All Segments will show Default Content.</p>
    
    <form method="POST" action="options.php" id="swaptify_config_form">
        <?php wp_nonce_field('save_config', 'save_config'); ?>
        <?php 
            settings_fields('swaptify_configuration_settings');
            do_settings_sections('swaptify_configuration_settings'); 
        ?>    
        <?php if ($propertySet): ?>  
            <h3>Property Settings</h3>
            <p>To update your settings, <a href="<?php echo(esc_url(Swaptify::$url)); ?>/properties/<?php echo($setProperty->key); ?>/edit" target="_blank">click here</a></p>
            
            <p><strong>Filter Unverified Data: </strong><?php echo($setProperty->filter_unverified_data ? 'Yes' : 'No'); ?></p>
            <p><strong>No Rule Display Setting: </strong><?php echo($setProperty->no_rule_display_setting); ?></p>
            <p><strong>Visitor Session Expiration (Minutes): </strong><?php echo($setProperty->session_expiration_minutes); ?></p>
            
            <p><strong>Consent Mode On: </strong><?php echo($setProperty->consent_required ? 'Yes' : 'No'); ?></p>
            
            <?php if ($setProperty->consent_required): ?>
                <h4>Consent Scripts</h4>
                <p>Grant Consent</p>
                <pre>
        &lt;script&gt;
            SwaptifyWP.grant_consent();
        &lt;/script&gt;
                </pre>
                
                <p>Grant Consent and retrigger swaps</p>
                <pre>
        &lt;script&gt;
            SwaptifyWP.grant_consent(true);
        &lt;/script&gt;
                </pre>
                
                <p>Revoke Consent</p>
                <pre>
        &lt;script&gt;
            SwaptifyWP.revoke_consent();
        &lt;/script&gt;
                </pre>
                
                <p>Revoke Consent and retrigger swaps</p>
                <pre>
        &lt;script&gt;
            SwaptifyWP.revoke_consent(true);
        &lt;/script&gt;
                </pre>

            <?php endif; ?>
            
            <div>
                <label for="swaptify_confirm_property_change">
                    <input type="checkbox" id="swaptify_confirm_property_change"/> 
                    Confirm changing property? Changing the property will have adverse affects due on any existing swaptify data 
                </label>
            </div>
        <?php endif; ?>
        <?php submit_button(); ?>  
    </form>           
</div>