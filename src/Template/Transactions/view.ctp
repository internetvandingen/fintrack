<?php ?>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($transaction->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($transaction->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Account id') ?></th>
            <td><?= $this->Number->format($transaction->account_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount') ?></th>
            <td><?= h($transaction->amount) ?></td>
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
            <th scope="row"><?= __('Ledger id') ?></th>
            <td><?= h($transaction->ledger_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td class='overflow'><?= h($transaction->description) ?></td>
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
</div>

