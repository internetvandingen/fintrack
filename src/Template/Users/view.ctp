<?php ?>
<h3><?= h('User ' . $user->id) ?></h3>
<table class="vertical-table">
    <tr>
        <th scope="row"><?= __('Email') ?></th>
        <td><?= h($user->email) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Created') ?></th>
        <td><?= h($user->created) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Modified') ?></th>
        <td><?= h($user->modified) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Actions') ?></th>
        <td>
            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $id]) ?>, 
            <?= $this->Html->link(__('Delete'), ['action' => 'delete', $id]) ?>
        </td>
    </tr>
</table>
<div class="related">
    <h4><?= __('Related Accounts') ?></h4>
    <?php if (!empty($user->accounts)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th scope="col"><?= __('Bank number') ?></th>
            <th scope="col"><?= __('Balance') ?></th>
            <th scope="col"><?= __('Name') ?></th>
            <th scope="col"><?= __('Created') ?></th>
            <th scope="col"><?= __('Modified') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($user->accounts as $accounts): ?>
        <tr>
            <td><?= h($accounts->bank_number) ?></td>
            <td><?= $this->Setting->formatCurrency($accounts->balance) ?></td>
            <td><?= h($accounts->name) ?></td>
            <td><?= h($accounts->created) ?></td>
            <td><?= h($accounts->modified) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Accounts', 'action' => 'view', $accounts->id]) ?>
                <?= $this->Html->link(__('Edit'), ['controller' => 'Accounts', 'action' => 'edit', $accounts->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Accounts', 'action' => 'delete', $accounts->id], ['confirm' => __('Are you sure you want to delete?')]) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>
</div>

