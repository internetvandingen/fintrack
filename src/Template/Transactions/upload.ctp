<?php echo $this->Html->script('jquery.min'); ?>
<?= $this->Html->script('papaparse.min'); ?>
<?= $this->Html->script('csv'); ?>
<?= $this->Html->css('transactions'); ?>

<form class="form-inline">
  <div class="form-group">
    <label for="files">Upload a CSV formatted file:</label>
    <input type="file" id="files"  class="form-control" accept=".csv" required />
  </div>
  <div class="form-group">
    <button type="submit" id="submit-file" class="btn btn-primary">Load file</button>
  </div>
</form>

<h3>Add Transactions</h3>
<?php
    echo $this->Form->create();
    echo '<div id="parsed_csv_list"></div>';
    echo $this->Form->control('account_id', ['options'=>$accounts]);
    echo $this->Form->control('bank', ['options'=>['ING'=>'ING', 'ASN'=>'ASN']]);
    echo $this->Form->button(__('Save Transactions'));
    echo $this->Form->end();
?>
