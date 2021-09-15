<?php
/**
 * baserCMS :  Based Website Development Project <https://basercms.net>
 * Copyright (c) baserCMS User Community <https://basercms.net/community/>
 *
 * @copyright     Copyright (c) baserCMS User Community
 * @link          https://basercms.net baserCMS Project
 * @since         5.0.0
 * @license       http://basercms.net/license/index.html MIT License
 */

namespace BaserCore\Service;

use Exception;
use Cake\ORM\Query;
use Nette\Utils\DateTime;
use Cake\ORM\TableRegistry;
use BaserCore\Annotation\NoTodo;
use BaserCore\Annotation\Checked;
use BaserCore\Annotation\UnitTest;
use BaserCore\Model\Entity\Content;
use Cake\Datasource\EntityInterface;
use BaserCore\Model\Table\SitesTable;
use Cake\Datasource\ConnectionManager;
use BaserCore\Utility\BcContainerTrait;
use BaserCore\Model\Table\ContentsTable;
use Cake\Datasource\Exception\RecordNotFoundException;

/**
 * Class ContentService
 * @package BaserCore\Service
 * @property ContentsTable $Contents
 */
class ContentService implements ContentServiceInterface
{

    /**
     * Trait
     */
    use BcContainerTrait;

    /**
     * Contents
     *
     * @var ContentsTable
     */
    public $Contents;

    /**
     * Sites
     *
     * @var SitesTable
     */
    public $Sites;

    public function __construct()
    {
        $this->Contents = TableRegistry::getTableLocator()->get("BaserCore.Contents");
        $this->Sites = TableRegistry::getTableLocator()->get("BaserCore.Sites");
    }


    /**
     * コンテンツを取得する
     * @param int $id
     * @return EntityInterface
     * @checked
     * @noTodo
     * @unitTest
     */
    public function get($id): EntityInterface
    {
        return $this->Contents->get($id, [
            'contain' => ['Sites'],
        ]);
    }

    /**
     * ゴミ箱のコンテンツを取得する
     * @param int $id
     * @return EntityInterface|array|null
     * @checked
     * @noTodo
     * @unitTest
     */
    public function getTrash($id)
    {
        return $this->getTrashIndex()->where(['Contents.id' => $id])->first();
    }

    /**
     * 空のQueryを返す

     * @return Query
     * @checked
     * @noTodo
     * @unitTest
     */
    public function getEmptyIndex(): Query
    {
        return $this->getIndex(['site_id' => 0]);
    }

    /**
     * getTreeIndex
     *
     * @param  array $queryParams
     * @return Query
     * @checked
     * @unitTest
     */
    public function getTreeIndex(array $queryParams): Query
    {
        // ツリーの全体確認テスト用の条件（実運用では使わない）
//        $site = $this->Contents->Sites->getRootMain();
//        if ($queryParams['site_id'] === 'all') {
//            $queryParams = ['or' => [
//                ['Sites.use_subdomain' => false],
//                ['Contents.site_id' => 1]
//            ]];
//        }
        return $this->getIndex($queryParams, 'threaded')->order(['lft']);
    }

    /**
     * テーブルインデックス用の条件を返す
     *
     * @param  array $queryParams
     * @return array
     * @checked
     * @noTodo
     * @unitTest
     */
    public function getTableConditions(array $queryParams): array
    {
        $options = [];
        $conditions['site_id'] = $queryParams['site_id'];

        if (!empty($queryParams['withTrash'])) {
            $conditions['withTrash'] = $queryParams['withTrash'];
            if ($conditions['withTrash']) {
                $options = array_merge($options, ['withDeleted']);
            }
        }

        if ($queryParams['name']) {
            $conditions['OR'] = [
                'name LIKE' => '%' . $queryParams['name'] . '%',
                'title LIKE' => '%' . $queryParams['name'] . '%'
            ];
            $conditions['name'] = $queryParams['name'];
        }
        if ($queryParams['folder_id']) {
            $Contents = $this->Contents->find('all', $options)->select(['lft', 'rght'])->where(['id' => $queryParams['folder_id']]);
            $conditions['rght <'] = $Contents->first()->rght;
            $conditions['lft >'] = $Contents->first()->lft;
        }
        if ($queryParams['author_id']) {
            $conditions['author_id'] = $queryParams['author_id'];
        }
        if ($queryParams['self_status'] !== '') {
            $conditions['self_status'] = $queryParams['self_status'];
        }
        if ($queryParams['type']) {
            $conditions['type'] = $queryParams['type'];
        }

        return $conditions;
    }

    /**
     * コンテンツ管理の一覧用のデータを取得
     * @param array $queryParams
     * @param string $type
     * @return Query
     * @checked
     * @noTodo
     * @unitTest
     */
    public function getIndex(array $queryParams=[], ?string $type="all"): Query
    {
        $options = [];
        $columns = ConnectionManager::get('default')->getSchemaCollection()->describe('contents')->columns();

        if (!empty($queryParams['withTrash'])) {
            if ($queryParams['withTrash']) {
                $options = array_merge($options, ['withDeleted']);
            }
        }
        $query = $this->Contents->find($type, $options)->contain(['Sites']);

        if (!empty($queryParams['name'])) {
            $query = $query->where(['OR' => [
                'Contents.name LIKE' => '%' . $queryParams['name'] . '%',
                'Contents.title LIKE' => '%' . $queryParams['name'] . '%'
            ]]);
            unset($queryParams['name']);
        }

        if (!empty($queryParams['title'])) {
            $query = $query->andWhere(['Contents.title LIKE' => '%' . $queryParams['title'] . '%']);
        }

        foreach($queryParams as $key => $value) {
            if (in_array($key, $columns)) {
                $query = $query->andWhere(['Contents.' . $key => $value]);
            } elseif ($key[-1] === '!' && in_array($key = mb_substr($key, 0, -1), $columns)) {
                $query = $query->andWhere(['Contents.' . $key . " IS NOT " => $value]);
            }
        }

        if (!empty($queryParams['num'])) {
            $query = $query->limit($queryParams['num']);
        }

        return $query;
    }

    /**
     * テーブル用のコンテンツ管理の一覧データを取得
     *
     * @param  array $queryParams
     * @return Query
     * @checked
     * @noTodo
     * @unitTest
     */
    public function getTableIndex(array $queryParams): Query
    {

        $conditions = [
            'open' => '1',
            'name' => '',
            'folder_id' => '',
            'type' => '',
            'self_status' => '1',
            'author_id' => '',
        ];
        if ($queryParams) {
            $queryParams = array_merge($conditions, $queryParams);
        }
        return $this->getIndex($this->getTableConditions($queryParams));
    }


    /**
     * getTrashIndex
     * @param array $queryParams
     * @param string $type
     * @return Query
     * @checked
     * @noTodo
     * @unitTest
     */
    public function getTrashIndex(array $queryParams=[], string $type="all"): Query
    {
        $queryParams = array_merge($queryParams, ['withTrash' => true]);
        return $this->getIndex($queryParams, $type)->where(['deleted_date IS NOT NULL']);
    }

    /**
     * コンテンツフォルダーのリストを取得
     * コンボボックス用
     *
     * @param int $siteId
     * @param array $options
     * @return array|bool
     * @checked

     * @unitTest
     */
    public function getContentFolderList($siteId = null, $options = [])
    {
        $options = array_merge([
            'excludeId' => null
        ], $options);

        $conditions = [
            'type' => 'ContentFolder',
            'alias_id IS NULL'
        ];

        if (!is_null($siteId)) {
            $conditions['site_id'] = $siteId;
        }
        if ($options['excludeId']) {
            $conditions['id <>'] = $options['excludeId'];
        }
        if (!empty($options['conditions'])) {
            $conditions = array_merge($conditions, $options['conditions']);
        }
        $folders = $this->Contents->find('treeList')->where([$conditions]);
        if ($folders) {
            return $this->convertTreeList($folders->all()->toArray());
        }
        return false;
    }

    /**
     * ツリー構造のデータを コンボボックスのデータ用に変換する
     * @param array $nodes
     * @return array
     * @checked
     * @noTodo
     * @unitTest
     */
    public function convertTreeList($nodes)
    {
        if (!$nodes) {
            return [];
        }
        foreach($nodes as $key => $value) {
            if (preg_match("/^([_]+)/i", $value, $matches)) {
                $value = preg_replace("/^[_]+/i", '', $value);
                $prefix = str_replace('_', '　　　', $matches[1]);
                $value = $prefix . '└' . $value;
            }
            $nodes[$key] = $value;
        }
        return $nodes;
    }

    /**
     * コンテンツ登録
     * @param array $data
     * @return \Cake\Datasource\EntityInterface
     * @checked
     * @noTodo
     * @unitTest
     */
    public function create(array $postData)
    {
        $content = $this->Contents->newEmptyEntity();
        $content = $this->Contents->patchEntity($content, $postData, ['validate' => 'default']);
        return ($result = $this->Contents->save($content)) ? $result : $content;
    }

    /**
     * コンテンツ情報を論理削除する
     * @param int $id
     * @return bool
     * @checked
     * @noTodo
     * @unitTest
     */
    public function delete($id)
    {
        $content = $this->get($id);
        return $this->Contents->delete($content);
    }

    /**
     * コンテンツ情報を削除する
     * @param int $id
     * @return bool
     * @checked
     * @noTodo
     * @unitTest
     */
    public function hardDelete($id)
    {
        $content = $this->getTrash($id);
        if ($content->deleted_date) {
            return $this->Contents->hardDelete($content);
        }
        return false;
    }


    /**
     * 該当するコンテンツ情報をすべて論理削除する
     *
     * @param  array $conditions
     * @return int
     * @checked
     * @noTodo
     * @unitTest
     */
    public function deleteAll(array $conditions=[]): int
    {
        $conditions = array_merge(['deleted_date IS NULL'], $conditions);
        return $this->Contents->deleteAll($conditions);
    }

    /**
     * 指定日時以前の該当する論理削除されたコンテンツ情報をすべて削除する
     *
     * @param  Datetime $dateTime
     * @return int
     * @checked
     * @noTodo
     * @unitTest
     */
    public function hardDeleteAll(Datetime $dateTime): int
    {
        return $this->Contents->hardDeleteAll($dateTime);
    }

    /**
     * コンテンツを削除する（論理削除）
     *
     * ※ エイリアスの場合は直接削除
     * @param int $id
     * @return bool
     * @checked
     * @unitTest
     */
    public function treeDelete($id): bool
    {
        try {
            $content = $this->get($id);
        } catch (RecordNotFoundException $e) {
            return false;
        }

        if ($content->alias_id) {
            $result = $this->Contents->removeFromTree($content);
        } else {
            // $result = $this->Contents->softDeleteFromTree($id); TODO: キャッシュ系が有効化されてからsoftDeleteFromTreeを使用する
            $result = $this->Contents->deleteRecursive($id); // 一時措置
        }

        return $result;
    }

    /**
     * 論理削除されたコンテンツを復元する
     *
     * @param  int $id
     * @return EntityInterface|array|null $trash
     * @checked
     * @noTodo
     * @unitTest
     */
    public function restore($id)
    {
        $trash = $this->getTrash($id);
        return $this->Contents->restore($trash) ? $trash : null;
    }

    /**
     * ゴミ箱内のコンテンツをすべて元に戻す
     *
     * @param  array $queryParams
     * @return int $count
     * @checked
     * @noTodo
     * @unitTest
     */
    public function restoreAll(array $queryParams = []): int
    {
        $count = 0;
        $trash = $this->getTrashIndex($queryParams);
        foreach ($trash as $entity) {
            if ($this->Contents->restore($entity)) {
                $count++;
            }
        }
        return $count;
    }

    /**
      * コンテンツ情報を取得する
      * @return array
      */
    public function getContensInfo ()
    {
        $sites = $this->Sites->getPublishedAll();
        $contentsInfo = [];
        foreach($sites as $key => $site) {
            $contentsInfo[$key]['published'] = $this->Contents->find()
                    ->where(['site_id' => $site->id, 'status' => true])
                    ->count();
            $contentsInfo[$key]['unpublished'] = $this->Contents->find()
                    ->where(['site_id' => $site->id, 'status' => false])
                    ->count();
            $contentsInfo[$key]['total'] = $contentsInfo[$key]['published'] + $contentsInfo[$key]['unpublished'];
            $contentsInfo[$key]['display_name'] = $site->display_name;
        }
        return $contentsInfo;
    }
}
