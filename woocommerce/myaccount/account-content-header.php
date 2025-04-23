<?php
if (!isset($title))
    $title = '';
if (!isset($message))
    $message = '';
if (!isset($subtitle))
    $subtitle = '';
if (!isset($status))
    $status = '';
if (!isset($status_color))
    $status_color = '';
if (!isset($back_url))
    $back_url = '';
?>
<div class="ach-header-row">
    <div>
        <div class="ach-title-row">
            <h1 class="ach-title">
                <?php echo esc_html($title); ?>
            </h1>
            <?php if (!empty($status)): ?>
                <span class="ach-status-chip" <?php if (!empty($status_color)): ?>
                        style="background:<?php echo esc_attr($status_color); ?>;" <?php endif; ?>>
                    <?php echo esc_html($status); ?>
                </span>
            <?php endif; ?>
        </div>
        <?php if (!empty($subtitle)): ?>
            <div class="ach-subtitle">
                <?php echo esc_html($subtitle); ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($back_url)): ?>
            <a href="<?php echo esc_url($back_url); ?>" class="ach-back-link">
                <span class="ach-back-icon" aria-hidden="true">&larr;</span>Retour
            </a>
        <?php endif; ?>
    </div>
</div>
<?php if (!empty($message)): ?>
    <div class="ach-message">
        <p class="ach-desc"><?php echo $message; ?></p>
    </div>
<?php endif; ?>