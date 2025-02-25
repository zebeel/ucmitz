<?php
/**
 * baserCMS :  Based Website Development Project <https://basercms.net>
 * Copyright (c) NPO baser foundation <https://baserfoundation.org/>
 *
 * @copyright     Copyright (c) NPO baser foundation
 * @link          https://basercms.net baserCMS Project
 * @since         5.0.0
 * @license       https://basercms.net/license/index.html MIT License
 */

use BaserCore\View\{AppView as AppViewAlias};
use BaserCore\Model\Entity\UserGroup;

/**
 * UserGroups Add
 * @var AppViewAlias $this
 * @var UserGroup $userGroup
 */
?>

<?= $this->BcAdminForm->create($userGroup, ['novalidate' => true]) ?>

<?php $this->BcBaser->element('UserGroups/form') ?>

<div class="submit bc-align-center section bca-actions">
  <div class="bca-actions__main">
    <?= $this->BcAdminForm->button(
      __d('baser', '保存'),
      ['div' => false,
        'class' => 'button bca-btn bca-actions__item',
        'data-bca-btn-type' => 'save',
        'data-bca-btn-size' => 'lg',
        'data-bca-btn-width' => 'lg',
        'id' => 'BtnSave']
    ) ?>
  </div>
</div>

<?= $this->BcAdminForm->end() ?>
