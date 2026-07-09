<?php $pager->setSurroundCount(2) ?>

<nav aria-label="Page navigation">
    <ul class="pagination">
    <?php if ($pager->hasPrevious()) : ?>
        <li>
            <a href="javascript:void(0);" aria-label="<?= lang('Pager.first') ?>" class="pagination-link"  data-page="<?= $pager->getFirst() ?>">
                <span aria-hidden="true"><?= lang('Pager.first') ?></span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0);" aria-label="<?= lang('Pager.previous') ?>" class="pagination-link"  data-page="<?= $pager->getPrevious() ?>">
                <span aria-hidden="true"><?= lang('Pager.previous') ?></span>
            </a>
        </li>
    <?php endif ?>

  <?php foreach ($pager->links() as $link):
  
  
  
  ?>
    <li <?= $link['active'] ? 'class="active"' : '' ?>>
        <a href="javascript:void(0);" class="pagination-link" data-page="<?= $link['uri'] ?>">
            <?= $link['title'] ?>
        </a>
    </li>
<?php endforeach ?>


    <?php if ($pager->hasNext()) : ?>
        <li>
            <a href="javascript:void(0);" aria-label="<?= lang('Pager.next') ?>" class="pagination-link"  data-page="<?= $pager->getNext() ?>">
                <span aria-hidden="true"><?= lang('Pager.next') ?></span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0);"  aria-label="<?= lang('Pager.last') ?>" class="pagination-link"  data-page="<?= $pager->getLast() ?>">
                <span aria-hidden="true"><?= lang('Pager.last') ?></span>
            </a>
        </li>
    <?php endif ?>
    </ul>
</nav>


