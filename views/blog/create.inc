<?php $render('partial/header', ['user' => $data['user']]);?>
<h1>Neuen Blogeintrag erstellen</h1>

<?php if (isset($data['errors'])): ?>
    <?php $render('partial/errors', $data['errors']);?>
<?php endif; ?>

<?php $beginForm('Blog', 'Create', method: 'post'); ?>
    <div class="mb-3">
        <label for="subject" class="form-label">Betreff</label>
        <input type="text" class="form-control" id="subject" name="subject" value="<?php $htmlOut($data['subject'] ?? ''); ?>" required>
    </div>
    
    <div class="mb-3">
        <label for="content" class="form-label">Inhalt</label>
        <textarea class="form-control" id="content" name="content" rows="10" required><?php $htmlOut($data['content'] ?? ''); ?></textarea>
    </div>
    
    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">Blogeintrag erstellen</button>
        <?php $link('Abbrechen', 'Blog', 'Index', cssClass: 'btn btn-secondary'); ?>
    </div>
<?php $endForm(); ?>

<?php $render('partial/footer', []);?> 