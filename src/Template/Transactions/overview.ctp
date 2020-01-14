<?php
echo $this->Html->script('jquery.min');
echo $this->Html->script('overview.js');
echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js');
?>

<h3><?= __('Overview') ?></h3>
<canvas id="canvas" style="width:100%;"></canvas>

<br>

<table id="month" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th scope="col"><?= __('Ledger') ?></th>
            <th scope="col"><?= __('January') ?></th>
            <th scope="col"><?= __('February') ?></th>
            <th scope="col"><?= __('March') ?></th>
            <th scope="col"><?= __('April') ?></th>
            <th scope="col"><?= __('May') ?></th>
            <th scope="col"><?= __('June') ?></th>
            <th scope="col"><?= __('July') ?></th>
            <th scope="col"><?= __('August') ?></th>
            <th scope="col"><?= __('September') ?></th>
            <th scope="col"><?= __('October') ?></th>
            <th scope="col"><?= __('November') ?></th>
            <th scope="col"><?= __('December') ?></th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
