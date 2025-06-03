<div class="alert alert-danger">
    <p>Please correct the following and try again:</p>
    <ul>
        <?php foreach ($data as $error): ?>
            <li><?php $htmlOut($error); ?></li>
        <?php endforeach; ?>
    </ul>
</div> 