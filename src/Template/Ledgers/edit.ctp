<?php ?>
<div class="ledgers form large-9 medium-8 columns content">
    <?= $this->Form->create($ledger) ?>
    <fieldset>
        <legend><?= __('Edit Ledger') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('description');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
