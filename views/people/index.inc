<?php $render('partial/header', ['user' => $data['user']]);?>
<h1>Personen</h1>

<div class="mb-4">
    <?php $beginForm('People', 'Index', method: 'get', cssClass: 'd-flex gap-2'); ?>
        <input type="text" class="form-control" name="search" placeholder="Suche..." value="<?php $htmlOut($data['searchTerm']); ?>">
        <button type="submit" class="btn btn-primary">Suchen</button>
    <?php $endForm(); ?>
</div>

<?php if (!empty($data['searchTerm'])): ?>
    <?php if (empty($data['people'])): ?>
        <div class="alert alert-info">
            Keine Personen gefunden für "<?php $htmlOut($data['searchTerm']); ?>".
        </div>
    <?php else: ?>
        <p class="text-muted mb-3"><?php echo count($data['people']); ?> Personen gefunden für "<?php $htmlOut($data['searchTerm']); ?>":</p>
        
        <?php foreach($data['people'] as $person): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">
                        <?php $link($person->getDisplayName(), 'Blog', 'User', ['id' => $person->getId()]); ?>
                    </h5>
                    <p class="card-text text-muted">Mitglied seit: <?php $htmlOut($person->getCreatedAt()); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
<?php else: ?>
    <div class="alert alert-info">
        Geben Sie einen Anzeigenamen ein, um nach Personen zu suchen.
    </div>
<?php endif; ?>

<?php $render('partial/footer', []);?> 