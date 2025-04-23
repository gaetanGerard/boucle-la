<?php
// account-content-header.php
if (!isset($title))
    $title = '';
if (!isset($message))
    $message = '';
?>
<h1 class="ach-title"><?php echo esc_html($title); ?></h1>
<div class="ach-message">
    <?php if (!empty($message)): ?>
        <p class="ach-desc"><?php echo $message; ?></p>
    <?php endif; ?>
</div>