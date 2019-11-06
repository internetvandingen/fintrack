<h1>Accounts</h1>
<?= $this->Html->link('Add Account', ['action' => 'add']) ?>
<table>
    <tr>
        <th>Name</th>
        <th>Bank number</th>
        <th>Balance</th>
        <th>Action</th>
    </tr>

    <?php foreach ($accounts as $account): ?>
    <tr>
        <td>
            <?= $account->name ?>
        </td>
        <td>
            <?= $this->Html->link($account->bank_number, ['action' => 'view', $account->id]) ?>
        </td>
        <td>
            &euro; <?= $account->balance/100 ?>
        </td>
        <td>
            <?= $this->Html->link('Edit', ['action' => 'edit', $account->id]) ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
