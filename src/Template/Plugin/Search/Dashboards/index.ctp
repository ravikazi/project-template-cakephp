<?php
/**
 * Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use RolesCapabilities\Access\AccessFactory;

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <div class="jumbotron">
                <h1><?= __('Dashboards') ?></h1>
                <p>
                    <?= __('There are no configured Dashboards for you.'); ?>
                <?php
                    $factory = new AccessFactory();
                    $url = [ 'controller' => $this->request->controller, 'action' => 'add'];
                    if (!$factory->hasAccess($url, $user)):
                ?>
                    <?= __('Please contact the system administrator.'); ?>
                </p>
                <?php else: ?>
                <p>
                <?= $this->Html->link(__('{0} Create Dashboard', '<i class="fa fa-plus"></i>'), $url, ['class' => 'btn btn-primary', 'escape' => false]) ?>
                <p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
