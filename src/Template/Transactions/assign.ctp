<?php
echo $this->Html->script('jquery.min');
echo $this->Html->script('assign');
?>

<h2>Assign Transactions to Ledgers</h2>
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
                      <td><?= $this->Setting->formatCurrency($transaction->amount) ?></td>
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
