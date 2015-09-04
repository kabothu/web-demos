<?php
/* @var $this \ilopx\demos\index\Index */

?>
<ul id="myTabs" class="nav nav-tabs" role="tablist">
    <?php foreach($this->dataProjectFile() as $key => $file): ?>
        <li<?= $key == 0 ? ' class="active"' : '' ?>><a href="#tab<?= $key ?>" data-toggle="tab"><?= $file['name'] ?></a></li>
    <?php endforeach; ?>

</ul>
<div id="myTabContent" class="tab-content">
    <noscript>
        <div class="alert alert-danger">JavaScript is Disabled</div>
    </noscript>
    <?php foreach($this->dataProjectFile() as $key => $file): ?>
        <div class="tab-pane fade <?= $key == 0 ? ' in active' : '' ?>" id="tab<?= $key ?>">
            <!---
            <?= $file['content']; ?>
            -->
        </div>
    <?php endforeach; ?>
</div>


<?php return; ?>

<li class="active"><a href="#main" data-toggle="tab" >Home</a></li>
<li><a href="#readme"  data-toggle="tab">Readme.md</a></li>
<li><a id="run-only" href="#" data-toggle="tab">Run only</a></li>


<div class="tab-pane fade in active" id="main">
</div>




