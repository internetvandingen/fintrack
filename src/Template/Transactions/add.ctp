<?php ?>

<div class="transactions index large-9 medium-8 columns content">
  <h1>Add Transaction</h1>
  <?php
    echo $this->Form->create($transaction);
    echo $this->Form->control('account_id', ['options'=>$transaction->account_options]);
    echo $this->Form->control('amount');
    echo $this->Form->control('counter_account');
    echo $this->Form->control('date');
    echo $this->Form->control('ledger_id', ['options'=>$transaction->ledger_options]);
    echo $this->Form->control('description');
    echo $this->Form->button(__('Save Transaction'));
    echo $this->Form->end();
  ?>
</div>
