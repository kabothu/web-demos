
<?php
/* @var $this \ilopx\demos\index\Index */

if ($this->dataNavWeb()): ?>
    <h2>Browsers</h2>
    <ul class="nav nav-pills nav-stacked" role="ajax">
        <?php foreach($this->dataNavWeb() as $key => $item): ?>
        <li><a href="/demos/web/<?= $item ?>"><?= $item ?></a></li>
        <?php endforeach ;?>
    </ul>
<?php endif; ?>

<?php if ($this->dataNavConsole()): ?>
<h2>Console</h2>
<ul class="nav nav-pills nav-stacked">
    <?php foreach($this->dataNavConsole() as $key => $item): ?>
        <li><code><?= $item ?></code></li>
    <?php endforeach ;?>
</ul>
<?php endif; ?>

