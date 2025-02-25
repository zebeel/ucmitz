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


namespace BaserCore\Service;

use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use BaserCore\Utility\BcUtil;
use BaserCore\Model\Entity\Site;
use Cake\Datasource\EntityInterface;
use BaserCore\Utility\BcContainerTrait;
use BaserCore\Model\Table\ContentsTable;
use Cake\Database\Expression\QueryExpression;
use BaserCore\Model\Table\ContentFoldersTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use BaserCore\Annotation\Note;
use BaserCore\Annotation\NoTodo;
use BaserCore\Annotation\Checked;
use BaserCore\Annotation\UnitTest;

/**
 * Class ContentFoldersService
 * @package BaserCore\Service
 * @property ContentFoldersTable $ContentFolders
 */
class ContentFoldersService implements ContentFoldersServiceInterface
{

    /**
     * Trait
     */
    use BcContainerTrait;

    /**
     * ContentFolders Table
     * @var ContentFoldersTable
     */
    public $ContentFolders;

    /**
     * ContentFolders Table
     * @var ContentsTable
     */
    public $Contents;

    /**
     * ContentFoldersService constructor.
     */
    public function __construct()
    {
        $this->ContentFolders = TableRegistry::getTableLocator()->get('BaserCore.ContentFolders');
        $this->Contents = TableRegistry::getTableLocator()->get('BaserCore.Contents');
    }

    /**
     * 新しいデータの初期値を取得する
     * @return EntityInterface
     * @checked
     * @noTodo
     * @unitTest
     */
    public function getNew(): EntityInterface
    {
        return $this->ContentFolders->newEntity([]);
    }

    /**
     * リストを取得する
     * @return array
     * @checked
     * @noTodo
     * @unitTest
     */
    public function getList(): array
    {
        return $this->ContentFolders->find('list', [
            'keyField' => 'id',
            'valueField' => 'content.title'
        ])->contain(['Contents'])->toArray();
    }

    /**
     * コンテンツフォルダーを取得する
     * @param int $id
     * @return EntityInterface
     * @checked
     * @noTodo
     * @unitTest
     */
    public function get($id): EntityInterface
    {
        return $this->ContentFolders->get($id, ['contain' => ['Contents' => ['Sites']]]);
    }

    /**
     * コンテンツフォルダーをゴミ箱から取得する
     * @param int $id
     * @return EntityInterface
     * @throws RecordNotFoundException
     * @checked
     * @noTodo
     * @unitTest
     */
    public function getTrash($id)
    {
        $contentFolder = $this->ContentFolders->findById($id)->contain('Contents', function (Query $q) {
            return $q->applyOptions(['withDeleted'])->contain(['Sites'])->where(['Contents.deleted_date IS NOT NULL']);
        })->firstOrFail();
        if (isset($contentFolder->content)) {
            return $contentFolder;
        } else {
            throw new RecordNotFoundException('Record not found in table "contents"');
        }
    }

    /**
     * コンテンツフォルダー一覧用のデータを取得
     * @param array $queryParams
     * @return Query
     * @checked
     * @noTodo
     * @unitTest
     */
    public function getIndex(array $queryParams=[]): Query
    {
        $query = $this->ContentFolders->find('all')->contain('Contents');
        if (!empty($queryParams['limit'])) {
            $query->limit($queryParams['limit']);
        }
        if (!empty($queryParams['folder_template'])) {
            $query->where(['folder_template LIKE' => '%' . $queryParams['folder_template'] . '%']);
        }
        if (!empty($queryParams['page_template'])) {
            $query->where(['page_template LIKE' => '%' . $queryParams['page_template'] . '%']);
        }
        return $query;
    }

    /**
     * コンテンツフォルダー登録
     * @param array $data
     * @param array $options
     * @return \Cake\Datasource\EntityInterface
     * @throws \Cake\ORM\Exception\PersistenceFailedException
     * @checked
     * @noTodo
     * @unitTest
     */
    public function create(array $postData, $options=[]): ?EntityInterface
    {
        $contentFolder = $this->ContentFolders->newEmptyEntity();
        $contentFolder = $this->ContentFolders->patchEntity($contentFolder, $postData, $options);
        return $this->ContentFolders->saveOrFail($contentFolder);
    }

    /**
     * コンテンツフォルダーを削除する
     * @param int $id
     * @return bool
     * @checked
     * @unitTest
     * @noTodo
     */
    public function delete($id): bool
    {
        $ContentFolder = $this->get($id);
        return $this->ContentFolders->delete($ContentFolder);
    }

    /**
     * コンテンツフォルダー情報を更新する
     * @param EntityInterface $target
     * @param array $contentFolderData
     * @param array $options
     * @return EntityInterface
     * @throws \Cake\ORM\Exception\PersistenceFailedException
     * @checked
     * @noTodo
     * @unitTest
     */
    public function update(EntityInterface $target, array $contentFolderData, $options = []): ?EntityInterface
    {
        $options = array_merge(['associated' => ['Contents' => ['validate' => 'default']]], $options);
        $contentFolder = $this->ContentFolders->patchEntity($target, $contentFolderData, $options);
        return $this->ContentFolders->saveOrFail($contentFolder, ['atomic' => false]);
    }

    /**
     * フォルダのテンプレートリストを取得する
     *
     * @param int $contentId
     * @param array|string $plugins
     * @return array
     * @checked
     * @noTodo
     * @unitTest
     */
    public function getFolderTemplateList($contentId, $plugins)
    {
        $folderTemplates = BcUtil::getTemplateList('ContentFolders', $plugins);

        if ($contentId != 1) {
            $parentTemplate = $this->getParentTemplate($contentId, 'folder');
            $searchKey = array_search($parentTemplate, $folderTemplates);
            if ($searchKey !== false) {
                unset($folderTemplates[$searchKey]);
            }
            $folderTemplates = ['' => sprintf(__d('baser', '親フォルダの設定に従う（%s）'), $parentTemplate)] + $folderTemplates;
        }
        return $folderTemplates;
    }

    /**
     * 親のテンプレートを取得する
     *
     * @param int $id
     * @param string $type folder|page
     * @return string $parentTemplate
     * @checked
     * @noTodo
     * @unitTest
     */
    public function getParentTemplate($id, $type)
    {
        $contents = $this->Contents->find('path', ['for' => $id])->all()->toArray();
        $contents = array_reverse($contents);
        unset($contents[0]);
        // 配列の場合一番上のものからコンテンツフォルダーを取得する
        $content = is_array($contents) ? array_shift($contents) : $contents;
        if ($content) {
            $contentFolder = $this->ContentFolders->find()->where(function (QueryExpression $exp, Query $query) use($content) {
                return $query->newExpr()->eq('Contents.id', $content->id);
            })->leftJoinWith('Contents')->first();
            if($contentFolder) $template = $contentFolder->{$type . '_template'};
        }
        $parentTemplate = !empty($template) ? $template : 'default';
        return $parentTemplate;
    }

    /**
     * サイトルートフォルダを保存
     *
     * @param Site|EntityInterface $site
     * @param bool $isUpdateChildrenUrl 子のコンテンツのURLを一括更新するかどうか
     * @return false|EntityInterface
     * @throws RecordNotFoundException
     * @checked
     * @noTodo
     * @unitTest
     */
    public function saveSiteRoot($site, $isUpdateChildrenUrl = false)
    {
        if ($site->id === 1) return false;
        if ($site->isNew()) {
            $data = [
                'folder_template' => 'default',
                'content' => [
                    'layout_template' => 'default',
                    'site_id' => $site->id,
                    'name' => ($site->alias) ? $site->alias : $site->name,
                    'parent_id' => 1,
                    'title' => $site->title,
                    'self_status' => $site->status,
                    'site_root' => true,
                ]
            ];
            $contentFolder = $this->create($data);
        } else {
            $contentFolder = $this->ContentFolders->find()->where(['Contents.site_id' => $site->id, 'Contents.site_root' => true])->contain(['Contents'])->first();
            if (is_null($contentFolder)) throw new RecordNotFoundException('Record not found in table "content_folders"');
            $data = [
                'content' => [
                    'id' => $contentFolder->content->id,
                    'name' => ($site->alias) ? $site->alias : $site->name,
                    'title' => $site->title,
                    'self_status' => $site->status,
                    'parent_id' => $contentFolder->content->parent_id
                ]
            ];
            $contentFolder = $this->update($contentFolder, $data);
            if ($isUpdateChildrenUrl) {
                $this->Contents->updateChildrenUrl($contentFolder->content->id);
            }
        }
        return $contentFolder;
    }
}
