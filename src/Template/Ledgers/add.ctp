<?php ?>
<h3>Add Ledger</h3>
<?php
    echo $this->Form->create($ledger);
    echo $this->Form->control('name');
    echo $this->Form->control('description');
    echo $this->Form->control('color');
    echo $this->Form->button(__('Submit'));
    echo $this->Form->end();
?>
