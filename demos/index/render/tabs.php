<ul id="myTabs" class="nav nav-tabs" role="tablist" style="margin-bottom: 20px">
    <li class="active"><a href="#main" data-toggle="tab" >Home</a></li>
    <li><a href="#readme"  data-toggle="tab">Readme.md</a></li>
    <li><a id="run-only" href="#" data-toggle="tab">Run only</a></li>
</ul>
<div id="myTabContent" class="tab-content" style="padding: 10px">
    <?php if ($index->isError()): ?>
        <div class="alert alert-danger" role="alert">Url not found!!!</div>
    <?php else: ?>
        <noscript>
                <div class="alert alert-danger">JavaScript is Disabled</div>
        </noscript>
        <div class="tab-pane fade in active" id="main">

        </div>
        <div class="tab-pane fade" id="readme">
            <?php if ($index->readmeContent() == 'file README.md not exist'): ?>
                <div class="alert alert-danger"><?= $index->readmeContent() ?></div>
            <?php else: ?>
                <?= $index->readmeContent() ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>