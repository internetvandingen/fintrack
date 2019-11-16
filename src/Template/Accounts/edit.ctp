<h1>Edit Accounts</h1>
<?php
    echo $this->Form->create($account);
    echo $this->Form->control('bank_number');
    echo $this->Form->control('name');
    echo $this->Form->control('bank_name', ['options' => ['ING'=>'ING', 'ASN'=>'ASN']]);
    echo $this->Form->button(__('Save Account'));
    echo $this->Form->end();
?>
