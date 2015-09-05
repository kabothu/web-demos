<?php /* @var $this \ilopx\demos\index\Index */

if (!count($this->dataProjectFile())){
    $this->render('error-settings');
}
else
    foreach($this->dataProjectFile() as $key => $file): ?>
        <?php if ($file['id'] == 'live'): ?>
            <div class="panel panel-default">
                <div class="panel-heading"><?= $file['name'] ?> <a href="<?= $file['url'] ?>">Run only</a></div>
                <div class="panel-body">
                    <iframe src="<?= $file['url'] ?>" id="main-frame" frameborder="0"></iframe>
                </div>
            </div>
        <?php else: ?>
            <div class="form-group">
                <?php if ($file['type'] == 'md'): ?>
                    <div class="panel panel-default">
                        <div class="panel-heading"><?= $file['name'] ?></div>
                        <div class="panel-body"><?= $file['content']; ?></div>
                    </div>
                <?php else: ?>
                    <label><?= $file['name'] ?></label>
                    <textarea class="form-control" rows="10"><?= $file['content']; ?></textarea>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>


