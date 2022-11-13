<?php

/**
 * baserCMS :  Based Website Development Project <https://basercms.net>
 * Copyright (c) baserCMS Users Community <https://basercms.net/community/>
 *
 * @copyright       Copyright (c) baserCMS Users Community
 * @link            https://basercms.net baserCMS Project
 * @package         Blog.Test.Case.Controller
 * @since           baserCMS v 4.0.9
 * @license         https://basercms.net/license/index.html
 */

namespace BcBlog\Test\TestCase\Controller\Admin;

use BaserCore\Test\Scenario\InitAppScenario;
use BaserCore\TestSuite\BcTestCase;
use BcBlog\Controller\Admin\BlogPostsController;
use CakephpFixtureFactories\Scenario\ScenarioAwareTrait;

/**
 * Class BlogPostsControllerTest
 *
 * @property BlogPostsController $BlogPostsController
 */
class BlogPostsControllerTest extends BcTestCase
{

    /**
     * Trait
     */
    use ScenarioAwareTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.BaserCore.Factory/Sites',
        'plugin.BaserCore.Factory/SiteConfigs',
        'plugin.BaserCore.Factory/Users',
        'plugin.BaserCore.Factory/UsersUserGroups',
        'plugin.BaserCore.Factory/UserGroups',
        'plugin.BcBlog.Factory/BlogPosts',
    ];

    /**
     * set up
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->setFixtureTruncate();
        parent::setUp();
        $this->loadFixtureScenario(InitAppScenario::class);
    }

    /**
     * tearDown
     *
     * @return void
     */
    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * test initialize
     */
    public function testInitialize(): void
    {
        $this->BlogPostsController = new BlogPostsController($this->getRequest());
        $this->assertNotEmpty($this->BlogPostsController->BcAdminContents);
    }

    /**
     * test beforeFilter
     */
    public function testBeforeFilter()
    {
        $this->markTestIncomplete('このテストは、まだ実装されていません。');
    }

    /**
     * test index
     * [ADMIN] ブログ記事一覧表示
     */
    public function testIndex()
    {
        $this->markTestIncomplete('このテストは、まだ実装されていません。');
    }

    /**
     * test add
     * [ADMIN] ブログ記事追加処理
     */
    public function testAdd()
    {
        $this->markTestIncomplete('このテストは、まだ実装されていません。');
    }

    /**
     * test edit
     * [ADMIN] ブログ記事編集処理
     */
    public function testEdit()
    {
        $this->markTestIncomplete('このテストは、まだ実装されていません。');
    }

    /**
     * test delete
     * [ADMIN] ブログ記事削除処理
     */
    public function testDelete()
    {
        $this->markTestIncomplete('このテストは、まだ実装されていません。');
    }

    /**
     * test unpublish
     * [ADMIN] ブログ記事を非公開状態にする
     */
    public function testUnpublish()
    {
        $this->markTestIncomplete('このテストは、まだ実装されていません。');
    }

    /**
     * test publish
     * [ADMIN] ブログ記事を公開状態にする
     */
    public function testPublish()
    {
        $this->markTestIncomplete('このテストは、まだ実装されていません。');
    }

    /**
     * test copy
     * [ADMIN] コピー
     */
    public function testCopy()
    {
        $this->markTestIncomplete('このテストは、まだ実装されていません。');
    }

}
