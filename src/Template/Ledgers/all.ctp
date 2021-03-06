<?php ?>
<h3><?= __('All Ledgers') ?></h3>
<table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('name') ?></th>
            <th scope="col"><?= $this->Paginator->sort('description') ?></th>
            <th scope="col"><?= $this->Paginator->sort('balance') ?></th>
            <th scope="col"><?= $this->Paginator->sort('color') ?></th>
            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
            <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ledgers as $ledger): ?>
        <tr>
            <td><?= $this->Number->format($ledger->id) ?></td>
            <td><?= $this->Number->format($ledger->user_id) ?></td>
            <td><?= h($ledger->name) ?></td>
            <td><?= h($ledger->description) ?></td>
            <td><?= $this->Setting->formatCurrency($ledger->balance) ?></td>
            <td><?= h($ledger->color) ?></td>
            <td><?= h($ledger->created) ?></td>
            <td><?= h($ledger->modified) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $ledger->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $ledger->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $ledger->id], ['confirm' => __('Are you sure you want to delete?')]) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->first('<< ' . __('first')) ?>
        <?= $this->Paginator->prev('< ' . __('previous')) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__('next') . ' >') ?>
        <?= $this->Paginator->last(__('last') . ' >>') ?>
    </ul>
    <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
</div>
