<?php 

// Go into a prefixed route.
echo $this->Html->link(
    'Manage articles',
    ['prefix' => 'manager', 'controller' => 'Articles', 'action' => 'add']
);

// Leave a prefix
echo $this->Html->link(
    'View Post',
    ['prefix' => false, 'controller' => 'Articles', 'action' => 'view', 5]
);

?>