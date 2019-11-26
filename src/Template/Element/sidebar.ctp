<?php if (sizeof($links)>0): ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?php foreach($links as $link) {
            if(in_array($link[1], ['edit', 'view'])){
                echo "<li>".$this->Html->link(__($link[2]), ['controller' => $link[0], 'action' => $link[1], $link[3]])."</li>";
            } elseif ($link[1] == 'delete') {
                echo "<li>" . $this->Form->postLink(__('Delete User'), 
                                 ['action' => 'delete', $link[3]], 
                                 ['confirm' => __('Are you sure you want to delete # {0}?', $link[3])]) . "</li>";
            } else {
                echo "<li>" . $this->Html->link(__($link[2]), ['controller' => $link[0], 'action' => $link[1]]) . "</li>";
            }
        }?>
    </ul>
</nav>
<?php endif; ?>
