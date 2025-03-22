<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/swaptify
 * @since      1.0.0
 *
 * @package    Swaptify
 * @subpackage Swaptify/admin/partials
 */

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
<h2>Swaptify Overview</h2>  
    <nav class="nav-tab-wrapper">
    <?php foreach ($tabs as $tab): ?>
        <a href="?page=swaptify&tab=<?php echo(esc_attr($tab['url'])) ?>" class="nav-tab <?php echo(esc_attr($tab['active'] ? 'nav-tab-active' : '')) ?>"><?php echo(esc_html($tab['name'])) ?></a>
    <?php endforeach; ?>
    </nav>
    <div class="tab-content">
        <?php include_once($path); ?>
    </div>
</div>