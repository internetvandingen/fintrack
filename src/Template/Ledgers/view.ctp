<?php ?>
<div class="ledgers index large-9 medium-8 columns content">
    <h3><?= __('Ledgers') ?></h3>
        <?= $this->Number->format($ledger->id) ?></td>
        <?= $this->Number->format($ledger->user_id) ?></td>
        <?= h($ledger->name) ?></td>
        <?= h($ledger->description) ?></td>
        <?= $this->Number->currency($ledger->balance/100, 'euro') ?></td>
        <?= h($ledger->created) ?></td>
        <?= h($ledger->modified) ?></td>
    </div>
</div>
