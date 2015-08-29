<ul id="myTabs" class="nav nav-tabs" role="tablist" style="margin-bottom: 20px">
    <li class="active"><a href="#project" data-toggle="tab" >Home</a></li>
    <li><a href="#readme"  data-toggle="tab">Readme.md</a></li>
    <li><a id="run-only" href="#" data-toggle="tab">Run only</a></li>
</ul>
<div id="myTabContent" class="tab-content" style="padding: 10px">
    <?php if ($index->isError()): ?>
        <div class="alert alert-danger" role="alert">Url not found!!!</div>
    <?php else: ?>
        <noscript><div>
                <div class="alert alert-danger">JavaScript is Disabled</div>
        </noscript>
        <iframe class="tab-pane fade in active" id="project" style="width: 100%!important;" frameborder="0" scrolling="no">
        </iframe>
        <div class="tab-pane fade" id="readme">
            <?= $index->readmeContent() ?>
        </div>
    <?php endif; ?>
</div>