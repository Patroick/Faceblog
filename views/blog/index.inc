<?php $render('partial/header', ['user' => $data['user']]);?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Mein Blog</h1>
    <?php $link('Neuer Blogeintrag', 'Blog', 'Create', cssClass: 'btn btn-primary'); ?>
</div>

<?php if (empty($data['blogEntries'])): ?>
    <div class="alert alert-info">
        <p>Sie haben noch keine Blogeinträge geschrieben.</p>
        <p><?php $link('Erstellen Sie Ihren ersten Blogeintrag', 'Blog', 'Create', cssClass: 'btn btn-primary'); ?></p>
    </div>
<?php else: ?>
    <?php foreach($data['blogEntries'] as $entryData): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><?php $htmlOut($entryData['entry']->getSubject()); ?></h5>
                <p class="card-text"><?php $htmlOut($entryData['entry']->getContent()); ?></p>
                
                <?php if (!empty($entryData['likedBy'])): ?>
                    <div class="mb-2">
                        <small class="text-muted">
                            <?php 
                            $likers = $entryData['likedBy'];
                            $count = count($likers);
                            $displayCount = min(5, $count);
                            $names = [];
                            for ($i = 0; $i < $displayCount; $i++) {
                                $names[] = $likers[$i]->getDisplayName();
                            }
                            
                            if ($count <= 5): 
                                echo implode(', ', $names) . ' gefällt das';
                            else:
                                echo implode(', ', $names) . ' und +' . ($count - 5) . ' gefällt das';
                            endif;
                            ?>
                        </small>
                    </div>
                <?php endif; ?>
                
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">Erstellt: <?php $htmlOut($entryData['entry']->getCreatedAt()); ?></small>
                    <div class="d-flex align-items-center gap-2">
                        <?php $beginForm('Blog', 'ToggleLike', method: 'post', cssClass: 'd-inline'); ?>
                            <input type="hidden" name="id" value="<?php echo $entryData['entry']->getId(); ?>">
                            <input type="hidden" name="returnUrl" value="<?php $htmlOut($data['returnUrl']); ?>">
                            <button type="submit" class="btn btn-sm <?php echo $entryData['userLiked'] ? 'btn-danger' : 'btn-outline-primary'; ?>">
                                <?php echo $entryData['userLiked'] ? 'Like entfernen' : 'Like'; ?>
                            </button>
                        <?php $endForm(); ?>
                        <span class="text-muted"><?php echo $entryData['likeCount']; ?> Likes</span>
                        <?php $beginForm('Blog', 'Delete', method: 'post', cssClass: 'd-inline'); ?>
                            <input type="hidden" name="id" value="<?php echo $entryData['entry']->getId(); ?>">
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Blogeintrag wirklich löschen?')">Löschen</button>
                        <?php $endForm(); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php $render('partial/footer', []);?> 