<?php ?>
<div class="ledgers form large-9 medium-8 columns content">
    <?= $this->Form->create($ledger) ?>
    <fieldset>
        <legend><?= __('Add new Ledger') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('description');
            echo $this->Form->control('balance');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

