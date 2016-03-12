<?php
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );


ob_start(); ?>
<div id="sit-sidebar "class="seo-image-tags sit-sidebar">
    <div>
    <h1>SEO Image Tags</h1>
    <form method="post" action="options.php">

    <?php
        // This prints out all hidden setting fields
        settings_fields( 'sit_settings_group' );
        do_settings_sections( 'sit-options-admin' );
        submit_button('Save All Options');
    ?>
    </form>
</div>
<?php ob_clean();
