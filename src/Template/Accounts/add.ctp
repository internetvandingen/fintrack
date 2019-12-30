<h3>Add Account</h3>
<fieldset>
<?php
    echo $this->Form->create($account);
    echo $this->Form->control('bank_number');
    echo $this->Form->control('bank_name', ['options' => ['ING'=>'ING', 'ASN'=>'ASN']]);
    echo $this->Form->control('name');
    echo $this->Form->control('balance');
    echo $this->Form->button(__('Save Account'));
    echo $this->Form->end();
?>
</fieldset>
