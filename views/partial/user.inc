<?php if ($data === null): ?>
    <nav class="navbar-nav">
        <?php $link('Anmelden', 'Auth', 'Login', cssClass: 'nav-link'); ?>
        <?php $link('Registrieren', 'Auth', 'Register', cssClass: 'nav-link'); ?>
    </nav>
<?php else: ?>
    <?php $beginForm('Auth', 'Logout', method: 'post', cssClass: 'form-inline'); ?>
    <span class="navbar-text me-2"> 
        Willkommen, <strong><?php $htmlOut(isset($data['username']) ? $data['username'] : ""); ?></strong>
    </span>
    <button class="btn btn-secondary" type="submit">Abmelden</button>
    <?php $endForm(); ?>
<?php endif; ?> 