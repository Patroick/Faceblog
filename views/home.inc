<?php
$render('partial/header', $data);
?>

<div class="row">
    <div class="col-12">
        <h1 class="text-center mb-4">Willkommen bei Faceblog</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card text-center">
            <div class="card-body">
                <h2 class="card-title"><?php $htmlOut($data['statistics']->userCount); ?></h2>
                <p class="card-text">Registrierte Benutzer</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card text-center">
            <div class="card-body">
                <h2 class="card-title"><?php $htmlOut($data['statistics']->totalBlogEntries); ?></h2>
                <p class="card-text">Blogeinträge gesamt</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card text-center">
            <div class="card-body">
                <h2 class="card-title"><?php $htmlOut($data['statistics']->recentBlogEntries); ?></h2>
                <p class="card-text">Neue Einträge (24h)</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card text-center">
            <div class="card-body">
                <h2 class="card-title">
                    <?php $htmlOut($data['statistics']->formattedLastPostDate); ?>
                </h2>
                <p class="card-text">Letzter Beitrag</p>
            </div>
        </div>
    </div>
</div>

<?php $render('partial/footer', []); ?> 