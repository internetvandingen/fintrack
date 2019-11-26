<?php ?>
<h3><?= __('All Transactions') ?></h3>
<table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('account_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('amount') ?></th>
            <th scope="col"><?= $this->Paginator->sort('counter_account') ?></th>
            <th scope="col"><?= $this->Paginator->sort('date') ?></th>
            <th scope="col"><?= $this->Paginator->sort('ledger_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('description') ?></th>
            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
            <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($transactions as $transaction): ?>
        <tr>
            <td><?= $this->Number->format($transaction->id) ?></td>
            <td><?= $this->Number->format($transaction->account_id) ?></td>
            <td><?= $this->Setting->formatCurrency($transaction->amount) ?></td>
            <td><?= h($transaction->counter_account) ?></td>
            <td><?= h($transaction->date) ?></td>
            <td><?= $this->Number->format($transaction->ledger_id) ?></td>
            <td class='overflow'><?= h($transaction->description) ?></td>
            <td><?= h($transaction->created) ?></td>
            <td><?= h($transaction->modified) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $transaction->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $transaction->id]) ?>
                <?= $this->Form->postLink(__('Delete'), 
                                          ['action' => 'delete', $transaction->id], 
                                          ['confirm' => __('Are you sure you want to delete?')]) ?>
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
