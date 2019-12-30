<?php 
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= $this->Html->link(__('Accounts'),['controller' => 'Accounts', 'action' => 'index']) ?></li>
        <li>
            <?= $this->Html->link(__('New'),['controller' => 'Accounts', 'action' => 'add'])?>
        </li>
        <li class="heading"><?= $this->Html->link(__('Ledgers'),['controller' => 'Ledgers', 'action' => 'index'])?></li>
        <li>
            <?= $this->Html->link(__('New'),['controller' => 'Ledgers', 'action' => 'add'])?>
        </li>
        <li class="heading"><?= $this->Html->link(__('Transactions'),['controller' => 'Transactions', 'action' => 'index'])?></li>
        <li>
            <?= $this->Html->link(__('New'),['controller' => 'Transactions', 'action' => 'add'])?>
            <?= $this->Html->link(__('Upload'),['controller' => 'Transactions', 'action' => 'upload'])?>
            <?= $this->Html->link(__('Assign'),['controller' => 'Transactions', 'action' => 'assign'])?>
        </li>
    </ul>
</nav>
