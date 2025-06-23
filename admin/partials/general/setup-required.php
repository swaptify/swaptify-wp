<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Page for when setup is not complete when access any other page than setup(configuration)
 *
 * @link       swaptify.com
 * @since      1.0.0
 *
 * @package    Swaptify
 * @subpackage swaptify/admin/partials/general
 */
?>
<div class="wrap">
    <div id="icon-themes" class="icon32"></div>  
    Swaptify setup is required. <a href="<?php echo(esc_url(get_admin_url() . 'admin.php?page=swaptify-configuration')); ?>">Click here</a> to continue.
</div>