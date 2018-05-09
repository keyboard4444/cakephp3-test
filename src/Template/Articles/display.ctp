<h1>Articles Display</h1>


<div><?php 

//use Cake\Routing\Router;
//echo Router::url(['controller' => 'Articles', 'action' => 'display']);

//echo Router::url(['controller' => 'Articles', 'action' => 'view', 'id' => 15]);
echo $this->Html->link("HUPLA", ['controller' => 'Articles', 'action' => 'view', 'id' => 15]);

?></div>


<table>
    <tr>
        <th>Title</th>
        <th>Created</th>
    </tr>

    <!-- Here is where we iterate through our $articles query object, printing out article info -->

    <?php foreach ($articles as $article): ?>
    <tr>
        <td>
            <?= $this->Html->link($article->title, ['action' => 'view', $article->slug]) ?>
        </td>
        <td>
            <?= $article->created->format(DATE_RFC850) ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>