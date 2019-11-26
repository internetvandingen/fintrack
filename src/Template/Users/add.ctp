<h3><?= __('Add User') ?></h3>
<?php
    echo $this->Form->create($user);
    echo $this->Form->control('email');
    echo $this->Form->control('password');
    echo $this->Form->button(__('Submit'));
    echo $this->Form->end();
?>

