<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * UserGroups seed.
 */
class UserGroupsSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => '1',
                'name' => 'admins',
                'title' => 'システム管理',
                'auth_prefix' => 'admin',
                'use_move_contents' => '1',
                'modified' => '2016-08-16 19:47:07',
                'created' => '2015-06-26 20:34:07',
            ],
            [
                'id' => '2',
                'name' => 'operators',
                'title' => 'サイト運営',
                'auth_prefix' => 'admin',
                'use_move_contents' => '0',
                'modified' => NULL,
                'created' => '2015-06-26 20:34:07',
            ],
        ];

        $table = $this->table('user_groups');
        $table->insert($data)->save();
    }
}
