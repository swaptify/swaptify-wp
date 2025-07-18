<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://github.com/swaptify
 * @since      1.0.0
 *
 * @package    Swaptify
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

/**
 * class for uninstalling Swaptify plugin
 * will remove all tables and options
 */
class SwaptifyUninstall
{
    /**
     * run all the uninstall methods
     *
     * @return void
     */
    public static function uninstall_swaptify()
    {
        /**
         * @todo remove swaptify config options
         *      swaptify_account_token 
         *      swaptify_property_key
         */
        static::removeSwapSegmentsTable();
        static::removePostSwapEventsTable();
        static::removePostSwapVisitorTypesTable();
        static::removeSwapDefaultContentsTable();
        static::removeSwapCookiesTable();
        delete_option('swaptify_property_key');
        delete_option('swaptify_account_token');
        delete_option('swaptify_enabled');
        delete_option('swaptify_version');
    }
    
    /**
     * remove post_swaptify_segments table
     *
     * @since 1.0.0
     * @return void
     */
    public static function removeSwapSegmentsTable()
    {
        global $wpdb;
    
        $table_name = $wpdb->prefix . "post_swaptify_segments"; 

        $sql = "DROP TABLE IF EXISTS $table_name";
        $wpdb->query($sql); // phpcs:ignore
    }
    
    /**
     * remove post_swaptify_events table
     * 
     * @since 1.0.0
     * @return void
     */
    public static function removePostSwapEventsTable()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . "post_swaptify_events"; 

        $sql = "DROP TABLE IF EXISTS $table_name";

        $wpdb->query($sql); // phpcs:ignore
    }
    
    /**
     * remove post_swaptify_visitor_types table
     * 
     * @since 1.0.0
     * @return void
     */
    public static function removePostSwapVisitorTypesTable()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . "post_swaptify_visitor_types"; 

        $sql = "DROP TABLE IF EXISTS $table_name";

        $wpdb->query($sql); // phpcs:ignore
    }

    /**
     * remove swaptify_default_contents table
     * 
     * @since 1.0.0
     * @return void
     */
    public static function removeSwapDefaultContentsTable()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . "swaptify_default_contents"; 

        $sql = "DROP TABLE IF EXISTS $table_name";

        $wpdb->query($sql); // phpcs:ignore
    }
    
    /**
     * remove swaptify_cookies table
     * 
     * @since 1.0.0
     * @return void
     */
    public static function removeSwapCookiesTable()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . "swaptify_cookies"; 

        $sql = "DROP TABLE IF EXISTS $table_name";

        $wpdb->query($sql); // phpcs:ignore
    }
}

SwaptifyUninstall::uninstall_swaptify();