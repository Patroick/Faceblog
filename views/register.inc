<?php $render('partial/header', ['user' => $data['user']]);?>
<h1>Registration</h1>

<div class="alert alert-info">
    <p>Registration functionality will be implemented soon.</p>
    <p>For now, please use the existing test users in the database.</p>
</div>

<div class="text-center">
    <?php $link('Back to Login', 'User', 'LogIn', cssClass: 'btn btn-primary'); ?>
</div>

<?php $render('partial/footer', []);?> 