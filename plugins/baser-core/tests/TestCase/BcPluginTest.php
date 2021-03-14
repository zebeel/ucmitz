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

namespace BaserCore\Test\TestCase\Model\Table;

use BaserCore\BcPlugin;
use BaserCore\Model\Table\PluginsTable;
use BaserCore\TestSuite\BcTestCase;
use Cake\Core\App;
use Cake\Filesystem\Folder;

/**
 * Class BcPluginTest
 * @package BaserCore\Test\TestCase
 * @property BcPlugin $BcPlugin
 */
class BcPluginTest extends BcTestCase
{

    /**
     * @var BcPlugin
     */
    public $BcPlugin;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'plugin.BaserCore.Plugins',
    ];

    /**
     * Set Up
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->BcPlugin = new BcPlugin(['name' => 'BcBlog']);
    }

    /**
     * Tear Down
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->BcPlugin);
        parent::tearDown();
    }

    public function testRoutes()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testInstall()
    {
        $this->BcPlugin->install();
        $plugin = $this->getTableLocator()->get('Plugins')->find()->where(['name' => 'BcBlog'])->first();
        $this->assertEquals(1, $plugin->priority);
    }

    public function testUninstall()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}