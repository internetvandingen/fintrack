<?php ?>
<h3><?= __('Account details') ?></h3>
<table class="vertical-table">
    <tr>
        <th scope="row"><?= __('Name') ?></th>
        <td><?= h($account->name) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Balance') ?></th>
        <td><?= $this->Setting->formatCurrency($account->balance) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Bank number') ?></th>
        <td><?= h($account->bank_number) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Created') ?></th>
        <td><?= h($account->created) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Modified') ?></th>
        <td><?= h($account->modified) ?></td>
    </tr>
</table>

<div class="related">
    <h4><?= __('Related Transactions') ?></h4>
    <?php if (!empty($transactions)): ?>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('account_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('counter_account') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ledger_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('description') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $transaction): ?>
            <tr>
                <td><?= h($transaction->account->bank_number) ?></td>
                <td><?= $this->Setting->formatCurrency($transaction->amount) ?></td>
                <td><?= h($transaction->counter_account) ?></td>
                <td><?= h($transaction->date) ?></td>
                <td><?= h($transaction->ledger->name) ?></td>
                <td class='overflow'><?= h($transaction->description) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Transactions', 'action' => 'view', $transaction->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Transactions', 'action' => 'edit', $transaction->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), 
                                              ['controller' => 'Transactions', 'action' => 'delete', $transaction->id], 
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
    <?php endif; ?>
</div>
