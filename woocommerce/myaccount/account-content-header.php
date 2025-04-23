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
<div class="ach-header-row"
    style="display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap">
    <div>
        <div class="ach-title-row" style="display:flex;align-items:center;gap:0.75rem;">
            <h1 class="ach-title" style="margin-bottom:0;display:inline-block;vertical-align:middle;">
                <?php echo esc_html($title); ?>
            </h1>
            <?php if (!empty($status)): ?>
                <span class="ach-status-chip"
                    style="background:<?php echo esc_attr($status_color); ?>;color:#fff;padding:0.4em 1em;border-radius:999px;font-size:1rem;font-weight:600;display:inline-block;min-width:90px;text-align:center;">
                    <?php echo esc_html($status); ?>
                </span>
            <?php endif; ?>
        </div>
        <?php if (!empty($subtitle)): ?>
            <div class="ach-subtitle" style="font-size:1.1rem;color:#666;margin-top:0.25rem;">
                <?php echo esc_html($subtitle); ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($back_url)): ?>
            <a href="<?php echo esc_url($back_url); ?>" class="ach-back-link"
                style="display:inline-flex;align-items:center;gap:0.5rem;margin-top:0.5rem;font-size:1rem;color:#666;text-decoration:none;">
                <span class="ach-back-icon" aria-hidden="true" style="font-size:1.1em;">&larr;</span>Retour
            </a>
        <?php endif; ?>
    </div>
</div>
<?php if (!empty($message)): ?>
    <div class="ach-message">
        <p class="ach-desc"><?php echo $message; ?></p>
    </div>
<?php endif; ?>