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

use Cake\Utility\Inflector;
use BaserCore\Utility\BcUtil;
use BaserCore\View\BcAdminAppView;

/**
 * [ADMIN] 統合コンテンツ一覧
 * @var BcAdminAppView $this
 * @var bool $editInIndexDisabled
 */

switch($this->request->getParam('action')) {
  case 'index':
      $this->BcAdmin->setTitle(__d('baser', 'コンテンツ一覧'));
      $this->BcAdmin->setSearch('contents_index');
      break;
  case 'trash_index':
      $this->BcAdmin->setTitle(__d('baser', 'ゴミ箱'));
      break;
}

$this->BcAdmin->setHelp('contents_index');

$editInIndexDisabled = false;
$this->BcBaser->js(['vendor/jquery.jstree-3.3.8/jstree.min'], false);
$currentUser = BcUtil::loginUser();
$isUseMoveContents = false;

foreach ($currentUser->user_groups as $group) {
  if ($isUseMoveContents = $group->use_move_contents) break;
}

$this->BcBaser->i18nScript([
  'confirmMessage1' => __d('baser', 'コンテンツをゴミ箱に移動してもよろしいですか？'),
  'confirmMessage2' => __d('baser', "選択したデータを全てゴミ箱に移動します。よろしいですか？\n※ エイリアスは直接削除します。"),
  'infoMessage1' => __d('baser', 'ターゲットと同じフォルダにコピー「%s」を作成しました。一覧に表示されていない場合は検索してください。'),
  'bcTreeCheck' => __d('baser', '確認'),
  'bcTreePublish' => __d('baser', '公開'),
  'bcTreeUnpublish' => __d('baser', '非公開'),
  'bcTreeManage' => __d('baser', '管理'),
  'bcTreeRename' => __d('baser', '名称変更'),
  'bcTreeEdit' => __d('baser', '編集'),
  'bcTreeCopy' => __d('baser', 'コピー'),
  'bcTreeDelete' => __d('baser', '削除'),
  'bcTreeToTrash' => __d('baser', 'ゴミ箱に入れる'),
  'bcTreeEmptyTrash' => __d('baser', 'ゴミ箱を空にする'),
  'bcTreeConfirmMessage1' => __d('baser', "ゴミ箱にある項目を完全に消去してもよろしいですか？\nこの操作は取り消せません。"),
  'bcTreeConfirmToTrash' => __d('baser', 'コンテンツをゴミ箱に移動してもよろしいですか？'),
  'bcTreeConfirmDeleteAlias' => __d('baser', "エイリアスを削除してもよろしいですか？\nエイリアスはゴミ箱に入らず完全に削除されます。"),
  'bcTreeAlertMessage1' => __d('baser', 'エイリアスの元コンテンツを先に戻してください。'),
  'bcTreeAlertMessage2' => __d('baser', 'ゴミ箱を空にする事に失敗しました。'),
  'bcTreeAlertMessage3' => __d('baser', 'ゴミ箱から戻す事に失敗しました。'),
  'bcTreeAlertMessage4' => __d('baser', 'ゴミ箱に移動しようとして失敗しました。'),
  'bcTreeAlertMessage5' => __d('baser', '名称変更に失敗しました。'),
  'bcTreeAlertMessage6' => __d('baser', '追加に失敗しました。'),
  'bcTreeInfoMessage1' => __d('baser', 'ゴミ箱は空です'),
  'bcTreeInfoMessage2' => __d('baser', 'ゴミ箱より戻しました。一覧に遷移しますのでしばらくお待ち下さい。'),
  'bcTreeCopyTitle' => __d('baser', '%s のコピー'),
  'bcTreeAliasTitle' => __d('baser', '%s のエイリアス'),
  'bcTreeUnNamedTitle' => __d('baser', '名称未設定'),
  'bcTreeNewTitle' => __d('baser', '新しい %s'),

]);
$this->BcBaser->js('admin/contents/index.bundle', false, [
  'id' => 'AdminContentsIndexScript',
  'data-isAdmin' => BcUtil::isAdminUser(),
  'data-isUseMoveContents' => $isUseMoveContents,
  'data-adminPrefix' => BcUtil::getAdminPrefix(),
  'data-baserCorePrefix' => Inflector::underscore(BcUtil::getBaserCorePrefix()),
  'data-editInIndexDisabled' => $editInIndexDisabled
]);
$this->BcBaser->css('../js/vendor/jquery.jstree-3.3.8/themes/proton/style.min', false);
echo $this->BcAdminForm->control('BcManageContent', ['type' => 'hidden', 'value' => $this->BcContents->getJsonItems()]);
?>


<script type="text/javascript">
</script>
<div id="AlertMessage" class="message" style="display:none"></div>
<div id="MessageBox" style="display:none">
  <div id="flashMessage" class="notice-message"></div>
</div>
<?php $this->BcBaser->element('Contents/index_view_setting') ?>
<div id="DataList" class="bca-data-list">
    <?php $this->BcBaser->element("Contents/${template}"); ?>
</div>
