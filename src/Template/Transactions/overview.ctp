<?php
echo $this->Html->script('jquery.min');
echo $this->Html->script('overview.js');
echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js');
?>

<h3><?= __('Overview') ?></h3>
<canvas id="canvas" style="width:100%;"></canvas>


<?php /*
<table cellpadding="0" cellspacing="0" class="week">
    <thead>
        <tr>
            <th scope="col"><?= __('Week') ?></th>
            <th scope="col"><?= __('Amount') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($weekly as $week): ?>
        <tr>
            <td><?= h($week['week']) ?></td>
            <td><?= $this->Setting->formatCurrency($week['amount']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
*/ ?>
