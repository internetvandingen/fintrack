<?php
echo $this->Html->script('jquery.min');
echo $this->Html->script('assign');
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List transactions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New transaction'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('Upload transactions'), ['action' => 'upload']) ?></li>
        <li><?= $this->Html->link(__('Assign ledgers'), ['action' => 'assign']) ?></li>
    </ul>
</nav>
<div class="transactions index large-9 medium-8 columns content">
  <h1>Assign Transactions to Ledgers</h1>
  <?php
        // stage 1: see overview of accounts and a count of how many unassigned transactions they have
        // stage 2: show a list of transactions that have unassigned ledgers
        // stage 3: POST request of changed ledgers
    // build select tag
    $names = [];
    foreach ($accounts as $account){
        $names[$account['id']] = $account['name'] . " - " . sizeof($account['transactions']) . " unassigned";
    }
    echo $this->Form->control('account_id', ['options'=>$names]);
    // build table for each account, hidden on default
    echo $this->Form->create();
  ?>
    <h3><?= __('Unassigned Transactions') ?></h3>
    <?php foreach ($accounts as $account): ?>
        <table cellpadding="0" cellspacing="0" class="hidden" data-account="<?= $account['id'] ?>">
            <thead>
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('amount') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('counter_account') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('date') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('ledger_id') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('description') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($account['transactions'] as $key=>$transaction): ?>
                    <tr>
                        <td><?= $this->Number->currency($transaction->amount/100, 'euro') ?></td>
                        <td><?= h($transaction->counter_account) ?></td>
                        <td><?= h($transaction->date) ?></td>
                        <td>
                            <?= $this->Form->hidden($transaction->account_id . "." . $key . ".id", ['value'=>$transaction['id']]); ?>
                            <?= $this->Form->select($transaction->account_id . "." . $key . ".ledger_id", ['options'=>$ledger_options]); ?></td>
                        <td class='overflow'><?= h($transaction->description) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endforeach; ?>
<?php
    echo $this->Form->button(__('Assign'));
    echo $this->Form->end();
  ?>
</div>
