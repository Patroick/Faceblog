<?php $render('partial/header', ['user' => $data['user']]);?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Mein Blog</h1>
    <?php $link('Neuer Blogeintrag', 'Blog', 'Create', cssClass: 'btn btn-primary'); ?>
</div>

<?php if (empty($data['blogEntries'])): ?>
    <div class="alert alert-info">
        <p>Sie haben noch keine Blogeinträge geschrieben.</p>
        <p><?php $link('Erstellen Sie Ihren ersten Blogeintrag', 'Blog', 'Create', cssClass: 'btn btn-primary'); ?></p>
    </div>
<?php else: ?>
    <?php foreach($data['blogEntries'] as $entry): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><?php $htmlOut($entry->getSubject()); ?></h5>
                <p class="card-text"><?php $htmlOut($entry->getContent()); ?></p>
                <small class="text-muted">Erstellt: <?php $htmlOut($entry->getCreatedAt()); ?></small>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php $render('partial/footer', []);?> 