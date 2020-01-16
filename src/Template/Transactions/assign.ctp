<?php
echo $this->Html->script('jquery.min');
echo $this->Html->script('jquery.sortElements');
echo $this->Html->script('assign');
?>

<h2>Assign Transactions to Ledgers</h2>
<?php
      // stage 1: see overview of accounts and a count of how many unassigned transactions they have
      // stage 2: show a list of transactions that have unassigned ledgers
      // stage 3: POST request of changed ledgers
  // build select tag
  $names = [];
  $max_value = -1;
  $max_index = 0;
  foreach ($accounts as $account){
      $unassigned_transactions = sizeof($account['transactions']);
      if ( $unassigned_transactions > $max_value ){
          $max_value = $unassigned_transactions;
          $max_index = $account['id'];
      }
      $names[$account['id']] = $account['name'] . " - " . $unassigned_transactions . " unassigned";
  }
  echo $this->Form->control('account_id', ['options'=>$names, 'default'=>$max_index]);
  // build table for each account, hidden on default
  echo $this->Form->create();
?>
  <h3><?= __('Unassigned Transactions') ?></h3>
  <?php foreach ($accounts as $account): ?>
      <table cellpadding="0" cellspacing="0" class="hidden" data-account="<?= $account['id'] ?>">
              <tr>
                  <th scope="col" class="sortable"><?= h('Amount') ?></th>
                  <th scope="col" class="sortable"><?= h('Counter account') ?></th>
                  <th scope="col" class="sortable"><?= h('Date') ?></th>
                  <th scope="col"><?= h('Ledger') ?></th>
                  <th scope="col" class="sortable"><?= h('Description') ?></th>
              </tr>
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
