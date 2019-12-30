<h3><?= __('Edit Ledger') ?></h3>
<?php
    echo $this->Form->create($ledger);
    echo $this->Form->control('name');
    echo $this->Form->control('description');
    echo $this->Form->button(__('Submit'));
    echo $this->Form->end();
    echo $this->Html->link(__('View ledger'), ['action' => 'view', $id]);
?>
