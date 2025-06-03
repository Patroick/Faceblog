<?php $render('partial/header', ['user' => $data['user']]);?>

<?php if ($data['blogUser'] === null): ?>
    <div class="alert alert-danger">
        Benutzer nicht gefunden.
    </div>
<?php else: ?>
    <h1>Blog von <?php $htmlOut($data['blogUser']->getDisplayName()); ?></h1>
    
    <?php if (empty($data['blogEntries'])): ?>
        <div class="alert alert-info">
            Dieser Benutzer hat noch keine Blogeinträge geschrieben.
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
                            <?php if ($data['user'] !== null): ?>
                                <?php $beginForm('Blog', 'ToggleLike', method: 'post', cssClass: 'd-inline'); ?>
                                    <input type="hidden" name="id" value="<?php echo $entryData['entry']->getId(); ?>">
                                    <input type="hidden" name="returnUrl" value="<?php $htmlOut($data['returnUrl']); ?>">
                                    <button type="submit" class="btn btn-sm <?php echo $entryData['userLiked'] ? 'btn-danger' : 'btn-outline-primary'; ?>">
                                        <?php echo $entryData['userLiked'] ? 'Like entfernen' : 'Like'; ?>
                                    </button>
                                <?php $endForm(); ?>
                            <?php endif; ?>
                            <span class="text-muted"><?php echo $entryData['likeCount']; ?> Likes</span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endif; ?>

<?php $render('partial/footer', []);?> 