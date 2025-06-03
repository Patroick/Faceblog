<?php $render('partial/header', ['user' => $data['user']]);?>

<?php if ($data['blogUser'] === null): ?>
    <div class="alert alert-danger">
        Benutzer nicht gefunden.
    </div>
<?php else: ?>
    <h1>Blog von <?php $htmlOut($data['blogUser']->getDisplayName()); ?></h1>
    
    <?php if (empty($data['blogEntries'])): ?>
        <div class="alert alert-info">
            Dieser Benutzer hat noch keine Blogeinträge geschrieben.
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
<?php endif; ?>

<?php $render('partial/footer', []);?> 