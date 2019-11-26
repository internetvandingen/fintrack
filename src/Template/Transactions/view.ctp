<?php ?>
<h3><?= "Transaction details" ?></h3>
<table class="vertical-table">
    <tr>
        <th scope="row"><?= __('Account') ?></th>
        <td><?= h($transaction->account->name) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Amount') ?></th>
        <td><?= $this->Setting->formatCurrency($transaction->amount) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Counter account') ?></th>
        <td><?= h($transaction->counter_account) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Date') ?></th>
        <td><?= h($transaction->date) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Ledger') ?></th>
        <td><?= h($transaction->ledger->name) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Description') ?></th>
        <td><?= h($transaction->description) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Created') ?></th>
        <td><?= h($transaction->created) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Modified') ?></th>
        <td><?= h($transaction->modified) ?></td>
    </tr>
</table>
