<?php $render('partial/header', ['user' => $data['user']]);?>
<h1>Registrierung</h1>

<?php if (isset($data['errors'])): ?>
    <?php $render('partial/errors', $data['errors']);?>
<?php endif; ?>

<?php $beginForm('User', 'Register', method: 'post'); ?>
    <div class="mb-3">
        <label for="username" class="form-label">Benutzername</label>
        <input type="text" class="form-control" id="username" name="username" value="<?php $htmlOut($data['username'] ?? ''); ?>" required>
    </div>
    
    <div class="mb-3">
        <label for="displayName" class="form-label">Anzeigename</label>
        <input type="text" class="form-control" id="displayName" name="displayName" value="<?php $htmlOut($data['displayName'] ?? ''); ?>" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Passwort</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    
    <button type="submit" class="btn btn-primary">Registrieren</button>
<?php $endForm(); ?>

<?php $render('partial/footer', []);?> 