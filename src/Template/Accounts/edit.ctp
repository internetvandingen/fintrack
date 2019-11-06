<h1>Edit Accounts</h1>
<?php
    echo $this->Form->create($account);
    echo $this->Form->control('user_id', ['type' => 'hidden']);
    echo $this->Form->control('name');
    echo $this->Form->button(__('Save Account'));
    echo $this->Form->end();
?>