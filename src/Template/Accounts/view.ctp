<table>
    <tr>
        <th>Amount</th>
        <th>Counter bank number</th>
        <th>Date</th>
        <th>Ledger</th>
    </tr>
    <?php foreach ($transactions as $transaction): ?>
    <tr>
        <td>
            &euro; <?= $transaction->amount/100 ?>
        </td>
        <td>
            <?= $transaction->counter_account ?>
        </td>
        <td>
            <?= $transaction->date->format(DATE_RFC850) ?>
        </td>
        <td>
            <?= $transaction->ledger_id ?>
        </td>
    </tr>
    <?php endforeach; ?>

</table>

