<!doctype html>
<html lang="de" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <title>Faceblog</title>
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg bg-body-tertiary mb-3">
        <div class="container">

            <?php $link('Faceblog', 'Home', 'Index', cssClass: 'navbar-brand'); ?>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar">
                <nav class="navbar-nav me-auto">
                    <?php $link('Startseite', 'Home', 'Index', cssClass: 'nav-link'); ?>
                    <?php if ($data['user'] !== null): ?>
                        <?php $link('Mein Blog', 'Blog', 'Index', cssClass: 'nav-link'); ?>
                        <?php $link('Personen', 'People', 'Index', cssClass: 'nav-link'); ?>
                    <?php endif; ?>
                </nav>
                <?php $render('partial/user', $data['user']); ?>
            </div>
        </div>
    </nav>
    <main class="container mb-3 flex-grow-1"> 