<?php ?>
<h3><?= __('Ledger details') ?></h3>
<table class="vertical-table">
    <tr>
        <th scope="row"><?= __('Name') ?></th>
        <td><?= h($ledger->name) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Balance') ?></th>
        <td><?= $this->Setting->formatCurrency($ledger->balance) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Description') ?></th>
        <td><?= h($ledger->description) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Created') ?></th>
        <td><?= h($ledger->created) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Modified') ?></th>
        <td><?= h($ledger->modified) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Actions') ?></th>
        <td>
            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $id]) ?>, 
            <?= $this->Html->link(__('Delete'), ['action' => 'delete', $id]) ?>
        </td>
    </tr>
</table>
