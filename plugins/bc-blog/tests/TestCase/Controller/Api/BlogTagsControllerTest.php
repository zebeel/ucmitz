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

namespace BcBlog\Test\TestCase\Controller\Api;

use BaserCore\Service\DblogsServiceInterface;
use BaserCore\Test\Scenario\InitAppScenario;
use BaserCore\TestSuite\BcTestCase;
use BcBlog\Controller\Api\BlogTagsController;
use BcBlog\Test\Factory\BlogTagFactory;
use Cake\Core\Configure;
use CakephpFixtureFactories\Scenario\ScenarioAwareTrait;
use Cake\TestSuite\IntegrationTestTrait;

/**
 * Class BlogTagsControllerTest
 * @property BlogTagsController $BlogTagsController
 */
class BlogTagsControllerTest extends BcTestCase
{

    /**
     * ScenarioAwareTrait
     */
    use ScenarioAwareTrait;
    use IntegrationTestTrait;

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
        'plugin.BcBlog.Factory/BlogTags',
    ];

    /**
     * Access Token
     * @var string
     */
    public $accessToken = null;

    /**
     * Refresh Token
     * @var null
     */
    public $refreshToken = null;

    /**
     * set up
     */
    public function setUp(): void
    {
        $this->setFixtureTruncate();
        parent::setUp();
        $this->loadFixtureScenario(InitAppScenario::class);
        $token = $this->apiLoginAdmin(1);
        $this->accessToken = $token['access_token'];
        $this->refreshToken = $token['refresh_token'];
    }

    /**
     * Tear Down
     *
     * @return void
     */
    public function tearDown(): void
    {
        Configure::clear();
        parent::tearDown();
    }

    /**
     * test add
     */
    public function testAdd()
    {
        // ブログタグ名
        $data = [
            'name' => 'test tag add',
        ];
        // ブログタグ登録コール
        $this->post('/baser/api/bc-blog/blog_tags/add.json?token=' . $this->accessToken, $data);
        $this->assertResponseOk();
        $result = json_decode((string)$this->_response->getBody());
        $this->assertEquals('ブログタグ「test tag add」を追加しました。', $result->message);
        $this->assertEquals(1, $result->blogTag->id);
        $this->assertEquals('test tag add', $result->blogTag->name);
        $this->assertNotEmpty($result->blogTag->created);
        $this->assertNotEmpty($result->blogTag->modified);

        // error
        // 同じブログタグを登録
        $this->post('/baser/api/bc-blog/blog_tags/add.json?token=' . $this->accessToken, $data);
        $this->assertResponseCode(400);
        $result = json_decode((string)$this->_response->getBody());
        $this->assertEquals('入力エラーです。内容を修正してください。', $result->message);
    }

    /**
     * test batch
     */
    public function testBatch()
    {
        // delete以外のHTTPメソッドには500エラーを返す
        $this->post('/baser/api/bc-blog/blog_tags/batch.json?token=' . $this->accessToken, ['batch' => 'test']);
        $this->assertResponseCode(500);

        // データを作成する
        BlogTagFactory::make(['id' => 1, 'name' => 'tag1'])->persist();
        BlogTagFactory::make(['id' => 2, 'name' => 'tag2'])->persist();

        $data = [
            'batch' => 'delete',
            'batch_targets' => [1, 2],
        ];
        $this->post('/baser/api/bc-blog/blog_tags/batch.json?token=' . $this->accessToken, $data);
        // バッチの実行が成功
        $this->assertResponseOk();
        $result = json_decode((string)$this->_response->getBody());
        // レスポンスのメッセージを確認する
        $this->assertEquals('一括処理が完了しました。', $result->message);
        // DBログに保存するかどうか確認する
        $dbLogService = $this->getService(DblogsServiceInterface::class);
        $dbLog = $dbLogService->getDblogs(1)->toArray()[0];
        $this->assertEquals('ブログタグ「tag1」、「tag2」を 削除 しました。', $dbLog->message);
        $this->assertEquals(1, $dbLog->id);
        $this->assertEquals('BlogTags', $dbLog->controller);
        $this->assertEquals('batch', $dbLog->action);
    }

}