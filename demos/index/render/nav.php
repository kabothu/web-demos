<?php if ($index->navWebDemos()): ?>
    <h2>Browsers</h2>
    <ul class="nav nav-pills nav-stacked"><?= $index->navWebDemos() ?></ul>
<?php endif; ?>

<?php if ($index->navConsoleDemos()): ?>
    <h2>Console</h2>
    <ul class="nav nav-pills nav-stacked"><?= $index->navConsoleDemos() ?></ul>
<?php endif; ?>