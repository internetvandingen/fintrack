<h1>Add Article</h1>
<?php
    echo $this->Form->create($account);
    // Hard code the user for now.
    echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => 1]);
    echo $this->Form->control('bank_number');
    echo $this->Form->control('name');
    echo $this->Form->control('balance');
    echo $this->Form->button(__('Save Account'));
    echo $this->Form->end();
?>