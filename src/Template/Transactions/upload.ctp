<?php echo $this->Html->script('jquery.min'); ?>
<?= $this->Html->script('papaparse.min'); ?>
<?= $this->Html->script('csv'); ?>
<?= $this->Html->css('transactions'); ?>

<?php ?>
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
  <form class="form-inline">
    <div class="form-group">
      <label for="files">Upload a CSV formatted file:</label>
      <input type="file" id="files"  class="form-control" accept=".csv" required />
    </div>
    <div class="form-group">
      <button type="submit" id="submit-file" class="btn btn-primary">Upload File</button>
    </div>
  </form>

  <h1>Add Transactions</h1>
<?php
    echo $this->Form->create();
    echo '<div id="parsed_csv_list"></div>';
    echo $this->Form->control('account_id', ['options'=>$accounts]);
    echo $this->Form->control('bank', ['options'=>['ING'=>'ING', 'ASN'=>'ASN']]);
    echo $this->Form->button(__('Save Transactions'));
    echo $this->Form->end();
?>
</div>
