<?php
defined('ABSPATH') || exit;

$current_form = '';
if (isset($_GET['form'])) :
    $current_form = $_GET['form'];
endif;
?>

<form method="get" class="form-search-box">
    <div>
        <a href="<?php echo add_query_arg(array('form' => 'general')); ?>" class="button-secondary action"><?php _e('Cơ bản', ''); ?></a>
        <a href="<?php echo add_query_arg(array('form' => 'advanced')); ?>" class="button-secondary action disabled" disabled><?php _e('Nâng cao', ''); ?></a>
        <a href="<?php echo add_query_arg(array('form' => 'new')); ?>" class="button-secondary action disabled" disabled><?php _e('Widget', ''); ?></a>
        <input type="button" value="API" id="api-field" class="button-primary action" disabled>
    </div>
    <input type="hidden" name="page" value="tried-settings">
    <p class="search-box">
        <label for="search-input" class="screen-reader-text"><?php _e('Search', ''); ?>:</label>
        <input id="search-input" type="text" name="s" value="">
        <input type="submit" class="button" value="Search">
    </p>
</form>
<?php
    switch ($current_form):
        case 'general':
    ?>
        <ul class="subsubsub">
            <li class="all"><a href="" class="current" aria-current="page">All <span class="count">(9)</span></a> |</li>
            <li class="publish"><a href="">Published <span class="count">(8)</span></a> |</li>
            <li class="draft"><a href="">Draft <span class="count">(1)</span></a></li>
        </ul>
        <form method="get" class="form-general-box">
            <?php wp_nonce_field('tried-admin-general-form'); ?>
            <label for="search-input" class="screen-reader-text"><?php _e('Search', ''); ?>:</label>
            <input id="search-input" type="text" name="s" value="">
            <input type="submit" class="button" value="Search">
        </form>
    <?php
        break;

    default:
    ?>  
        <form method="get">

        </form>
    <?php
        break;
    endswitch;
?>