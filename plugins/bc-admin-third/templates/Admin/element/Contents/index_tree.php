<?php
/**
 * baserCMS :  Based Website Development Project <https://basercms.net>
 * Copyright (c) baserCMS Users Community <https://basercms.net/community/>
 *
 * @copyright       Copyright (c) baserCMS Users Community
 * @link            https://basercms.net baserCMS Project
 * @package         Baser.View
 * @since           baserCMS v 4.0.0
 * @license         https://basercms.net/license/index.html
 */
/** @var BaserCore\View\BcAdminAppView $this */
?>

<?php if (!$contents->all()->isEmpty()): ?>
  <div id="ContentsTreeList">
    <?php $this->BcBaser->element('Contents/index_list_tree'); ?>
  </div>
<?php else: ?>
  <div class="tree-empty"><?php echo __d('baser', 'データが登録されていません。') ?></div>
<?php endif ?>
