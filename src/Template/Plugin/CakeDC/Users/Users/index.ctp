<section class="content-header">
    <h1>Users
        <small>
            <?= $this->Html->link(
                '<i class="fa fa-plus"></i>',
                ['plugin' => 'CakeDC/Users', 'controller' => 'Users', 'action' => 'add'],
                ['escape' => false]
            ); ?>
        </small>
    </h1>
</section>
<section class="content">
    <div class="box">
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover table-condensed table-vertical-align">
                <thead>
                    <tr>
                <th><?= $this->Paginator->sort('username') ?></th>
                <th><?= $this->Paginator->sort('email') ?></th>
                <th><?= $this->Paginator->sort('first_name') ?></th>
                <th><?= $this->Paginator->sort('last_name') ?></th>
                <th class="actions"><?= __d('Users', 'Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($Users as $user): ?>
                    <tr>
                        <td><?= h($user->username) ?></td>
                        <td><?= h($user->email) ?></td>
                        <td><?= h($user->first_name) ?></td>
                        <td><?= h($user->last_name) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(
                                '<i class="fa fa-eye"></i>',
                                ['plugin' => 'CakeDC/Users', 'controller' => 'Users', 'action' => 'view', $user->id],
                                ['title' => __('View'), 'class' => 'btn btn-default btn-sm', 'escape' => false]
                            ); ?>
                            <?= $this->Html->link(
                                '<i class="fa fa-pencil"></i>',
                                ['plugin' => 'CakeDC/Users', 'controller' => 'Users', 'action' => 'edit', $user->id],
                                ['title' => __('Edit'), 'class' => 'btn btn-default btn-sm', 'escape' => false]
                            ); ?>
                            <?= $this->Form->postLink(
                                '<i class="fa fa-trash"></i>',
                                ['plugin' => 'CakeDC/Users', 'controller' => 'Users', 'action' => 'delete', $user->id],
                                [
                                    'confirm' => __('Are you sure you want to delete # {0}?', $user->id),
                                    'title' => __('Delete'),
                                    'class' => 'btn btn-default btn-sm',
                                    'escape' => false
                                ]
                            ) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="box-footer">
            <div class="paginator">
                <ul class="pagination pagination-sm no-margin pull-right">
                    <?= $this->Paginator->prev('&laquo;', ['escape' => false]) ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next('&raquo;', ['escape' => false]) ?>
                </ul>
            </div>
        </div>
    </div>
</section>