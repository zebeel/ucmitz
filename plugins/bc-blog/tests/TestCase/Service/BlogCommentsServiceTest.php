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

namespace BcBlog\Test\TestCase\Service;

use BaserCore\TestSuite\BcTestCase;
use BcBlog\Service\BlogCommentsService;
use BcBlog\Test\Scenario\BlogCommentsServiceScenario;
use CakephpFixtureFactories\Scenario\ScenarioAwareTrait;

/**
 * BlogCommentsServiceTest
 * @property BlogCommentsService $BlogCommentsService
 */
class BlogCommentsServiceTest extends BcTestCase
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
        'plugin.BcBlog.Factory/BlogPosts',
        'plugin.BcBlog.Factory/BlogComments',
    ];

    /**
     * Set Up
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->setFixtureTruncate();
        parent::setUp();
        $this->BlogCommentsService = new BlogCommentsService();
    }

    /**
     * Tear Down
     *
     * @return void
     */
    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * test __construct
     */
    public function test__construct()
    {
        $this->markTestIncomplete('このテストは、まだ実装されていません。');
    }

    /**
     * test getIndex
     */
    public function testGetIndex()
    {
        $this->markTestIncomplete('このテストは、まだ実装されていません。');
    }

    /**
     * test get
     */
    public function testGet()
    {
        $this->markTestIncomplete('このテストは、まだ実装されていません。');
    }

    /**
     * test publish
     */
    public function testPublish()
    {
        $this->markTestIncomplete('このテストは、まだ実装されていません。');
    }

    /**
     * test unpublish
     */
    public function testUnpublish()
    {
        $this->markTestIncomplete('このテストは、まだ実装されていません。');
    }

    /**
     * test delete
     */
    public function testDelete()
    {
        $this->markTestIncomplete('このテストは、まだ実装されていません。');
    }

    /**
     * test batch
     */
    public function testBatch()
    {
        $this->loadFixtureScenario(BlogCommentsServiceScenario::class);
        $ids = [1, 2, 3];

        // 一括でブログコメントを非公開するテスト
        $result = $this->BlogCommentsService->batch('unpublish', $ids);
        $this->assertTrue($result);
        foreach ($ids as $id) {
            $comment = $this->BlogCommentsService->get($id);
            $this->assertFalse($comment['status']);
        }

        // 一括でブログコメントを公開するテスト
        $result = $this->BlogCommentsService->batch('publish', $ids);
        $this->assertTrue($result);
        foreach ($ids as $id) {
            $comment = $this->BlogCommentsService->get($id);
            $this->assertTrue($comment['status']);
        }

        // 一括でブログコメントを削除するテスト
        $count = $this->BlogCommentsService->getIndex(['blog_post_id' => 1])->count();
        $result = $this->BlogCommentsService->batch('delete', $ids);
        $this->assertTrue($result);
        $this->assertEquals($count - 3, $this->BlogCommentsService->getIndex(['blog_post_id' => 1])->count());
    }

}
