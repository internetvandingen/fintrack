<h3><?= __('Edit account') ?></h3>
<?php
    echo $this->Form->create($account);
    echo $this->Form->control('bank_number');
    echo $this->Form->control('name');
    echo $this->Form->control('bank_name', ['options' => ['ING'=>'ING', 'ASN'=>'ASN']]);
    echo $this->Form->button(__('Save Account'));
    echo $this->Form->end();
    echo $this->Html->link(__('View account'), ['action' => 'view', $id]);
?>
