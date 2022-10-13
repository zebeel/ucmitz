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

namespace BcBlog\Test\TestCase\Service\Admin;

use BaserCore\Test\Factory\ContentFactory;
use BaserCore\Test\Factory\SiteFactory;
use BaserCore\TestSuite\BcTestCase;
use BaserCore\Utility\BcContainerTrait;
use BcBlog\Service\Admin\BlogCategoriesAdminService;
use BcBlog\Service\BlogCategoriesService;
use BcBlog\Test\Factory\BlogCategoryFactory;
use BcBlog\Test\Factory\BlogContentsFactory;
use Cake\TestSuite\IntegrationTestTrait;

/**
 * BlogCategoriesAdminServiceTest
 * @property BlogCategoriesAdminService $BlogCategoriesAdminService
 */
class BlogCategoriesAdminServiceTest extends BcTestCase
{

    /**
     * Trait
     */
    use BcContainerTrait;
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.BaserCore.Factory/Sites',
        'plugin.BaserCore.Factory/Users',
        'plugin.BaserCore.Factory/Contents',
        'plugin.BaserCore.Factory/ContentFolders',
        'plugin.BaserCore.Factory/Pages',
        'plugin.BaserCore.Factory/SiteConfigs',
        'plugin.BaserCore.Factory/SearchIndexes',
        'plugin.BcBlog.Factory/BlogContents',
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
        $this->BlogCategoriesAdminService = new BlogCategoriesAdminService();
    }

    /**
     * Tear Down
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->BlogCategoriesAdminService);
        parent::tearDown();
    }

    /**
     * test getViewVarsForIndex
     */
    public function test_getViewVarsForIndex()
    {
        $this->markTestIncomplete('このテストは、まだ実装されていません。');
    }

    /**
     * test getViewVarsForAdd
     */
    public function test_getViewVarsForAdd()
    {
        $this->markTestIncomplete('このテストは、まだ実装されていません。');
    }

    /**
     * test getViewVarsForEdit
     */
    public function test_getViewVarsForEdit()
    {
        BlogContentsFactory::make(['id' => 50, 'description' => 'test 1'])->persist();
        ContentFactory::make(
            [
                'id' => 50,
                'type' => 'BlogContent',
                'entity_id' => 50,
                'title' => 'title test',
                'site_id' => 50,
                'url' => 'archives/category'
            ]
        )->persist();
        SiteFactory::make(['id' => 50, 'use_subdomain' => 0])->persist();
        BlogCategoryFactory::make(
            ['id' => 50,
                'title' => 'title 3',
                'name' => 'name-50',
                'blog_content_id' => 1,
                'rght' => 1,
                'lft' => 4
            ]
        )->persist();

        $blogCategoriesService = new BlogCategoriesService();
        $blogCategory = $blogCategoriesService->get(50);

        $rs = $this->BlogCategoriesAdminService->getViewVarsForEdit(50, $blogCategory);
        $this->assertEquals($blogCategory, $rs['blogCategory']);
        $this->assertEquals('test 1', $rs['blogContent']['description']);
        $this->assertStringContainsString('/archives/category/name-50', $rs['publishLink']);
        $this->assertTrue(isset($rs['parents']));
    }
}
