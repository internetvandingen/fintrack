<?php ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Upload Transactions'), ['action' => 'upload']) ?></li>
    </ul>
</nav>
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
