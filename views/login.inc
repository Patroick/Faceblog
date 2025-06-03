<?php $render('partial/header', ['user' => $data['user']]);?>
<h1>Anmeldung</h1>

<?php if (isset($data['errors'])): ?>
    <?php $render('partial/errors', $data['errors']);?>
<?php endif; ?>

<?php $beginForm('User', 'LogIn', method: 'post');?>

<div class="form-group">
    <div class="mb-3">
        <label for="username">Benutzername</label>
        <input type="text" class="form-control" id="username" name="un" value="<?php $htmlOut($data['username']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="password">Passwort</label>
        <input type="password" class="form-control" id="password" name="pwd" required>
    </div>

</div>

<button class="btn btn-primary" type="submit">Anmelden</button>

<?php $endForm();?>

<?php $render('partial/footer', []);?> 