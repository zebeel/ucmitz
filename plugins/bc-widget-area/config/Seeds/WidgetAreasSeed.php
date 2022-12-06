<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * WidgetAreas seed.
 */
class WidgetAreasSeed extends AbstractSeed
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
                'id' => 1,
                'name' => '標準サイドバー',
                'widgets' => 'YTo0OntpOjA7YToxOntzOjc6IldpZGdldDEiO2E6OTp7czoyOiJpZCI7czoxOiIxIjtzOjQ6InR5cGUiO3M6MTI6IuODhuOCreOCueODiCI7czo3OiJlbGVtZW50IjtzOjQ6InRleHQiO3M6NjoicGx1Z2luIjtzOjA6IiI7czo0OiJzb3J0IjtpOjQ7czo0OiJuYW1lIjtzOjk6IuODquODs+OCryI7czo0OiJ0ZXh0IjtzOjQ0MDoiPHAgc3R5bGU9Im1hcmdpbi1ib3R0b206MjBweDt0ZXh0LWFsaWduOiBjZW50ZXIiPiA8YSBocmVmPSJodHRwOi8vYmFzZXJjbXMubmV0IiB0YXJnZXQ9Il9ibGFuayI+PGltZyBzcmM9Imh0dHA6Ly9iYXNlcmNtcy5uZXQvaW1nL2Jucl9iYXNlcmNtcy5qcGciIGFsdD0i44Kz44O844Od44Os44O844OI44K144Kk44OI44Gr44Gh44KH44GG44Gp44GE44GEQ01T44CBYmFzZXJDTVMiLz48L2E+PC9wPjxwIGNsYXNzPSJjdXN0b21pemUtbmF2aSBjb3JuZXIxMCI+PHNtYWxsPuOBk+OBrumDqOWIhuOBr+OAgeeuoeeQhueUu+mdouOBriBb6Kit5a6aXSDihpIgW+ODpuODvOODhuOCo+ODquODhuOCo10g4oaSIFvjgqbjgqPjgrjjgqfjg4Pjg4jjgqjjg6rjgqJdIOKGkiBb5qiZ5rqW44K144Kk44OJ44OQ44O8XSDjgojjgornt6jpm4bjgafjgY3jgb7jgZnjgII8L3NtYWxsPjwvcD4iO3M6OToidXNlX3RpdGxlIjtzOjE6IjEiO3M6Njoic3RhdHVzIjtzOjE6IjEiO319aToxO2E6MTp7czo3OiJXaWRnZXQyIjthOjg6e3M6MjoiaWQiO3M6MToiMiI7czo0OiJ0eXBlIjtzOjE4OiLjgrXjgqTjg4jlhoXmpJzntKIiO3M6NzoiZWxlbWVudCI7czo2OiJzZWFyY2giO3M6NjoicGx1Z2luIjtzOjA6IiI7czo0OiJzb3J0IjtpOjM7czo0OiJuYW1lIjtzOjE4OiLjgrXjgqTjg4jlhoXmpJzntKIiO3M6OToidXNlX3RpdGxlIjtzOjE6IjEiO3M6Njoic3RhdHVzIjtzOjE6IjEiO319aToyO2E6MTp7czo3OiJXaWRnZXQzIjthOjk6e3M6MjoiaWQiO3M6MToiMyI7czo0OiJ0eXBlIjtzOjMzOiLjg63jg7zjgqvjg6vjg4rjg5PjgrLjg7zjgrfjg6fjg7MiO3M6NzoiZWxlbWVudCI7czoxMDoibG9jYWxfbmF2aSI7czo2OiJwbHVnaW4iO3M6MDoiIjtzOjQ6InNvcnQiO2k6MjtzOjQ6Im5hbWUiO3M6MzQ6IuODreODvOOCq+ODq+ODiuODk+OCsuODvOOCt+ODp+ODszEiO3M6NToiY2FjaGUiO3M6MToiMSI7czo5OiJ1c2VfdGl0bGUiO3M6MToiMSI7czo2OiJzdGF0dXMiO3M6MToiMSI7fX1pOjM7YToxOntzOjc6IldpZGdldDQiO2E6OTp7czoyOiJpZCI7czoxOiI0IjtzOjQ6InR5cGUiO3M6MTI6IuODhuOCreOCueODiCI7czo3OiJlbGVtZW50IjtzOjQ6InRleHQiO3M6NjoicGx1Z2luIjtzOjA6IiI7czo0OiJzb3J0IjtpOjE7czo0OiJuYW1lIjtzOjEzOiLjg4bjgq3jgrnjg4gyIjtzOjQ6InRleHQiO3M6MjQ6IuOBguOBguOBguOBguOBguOBguOBguOBgiI7czo5OiJ1c2VfdGl0bGUiO3M6MToiMSI7czo2OiJzdGF0dXMiO3M6MToiMSI7fX19',
                'modified' => '2020-12-14 14:34:10',
                'created' => '2015-06-26 20:34:07',
            ],
            [
                'id' => 2,
                'name' => 'ブログサイドバー',
                'widgets' => 'YTo2OntpOjA7YToxOntzOjc6IldpZGdldDEiO2E6OTp7czoyOiJpZCI7czoxOiIxIjtzOjQ6InR5cGUiO3M6MjQ6IuODluODreOCsOOCq+ODrOODs+ODgOODvCI7czo3OiJlbGVtZW50IjtzOjEzOiJibG9nX2NhbGVuZGFyIjtzOjY6InBsdWdpbiI7czo0OiJCbG9nIjtzOjQ6InNvcnQiO2k6MTtzOjQ6Im5hbWUiO3M6MjQ6IuODluODreOCsOOCq+ODrOODs+ODgOODvCI7czoxNToiYmxvZ19jb250ZW50X2lkIjtzOjE6IjEiO3M6OToidXNlX3RpdGxlIjtzOjE6IjAiO3M6Njoic3RhdHVzIjtzOjE6IjEiO319aToxO2E6MTp7czo3OiJXaWRnZXQyIjthOjEwOntzOjI6ImlkIjtzOjE6IjIiO3M6NDoidHlwZSI7czozMDoi44OW44Ot44Kw44Kr44OG44K044Oq44O85LiA6KanIjtzOjc6ImVsZW1lbnQiO3M6MjI6ImJsb2dfY2F0ZWdvcnlfYXJjaGl2ZXMiO3M6NjoicGx1Z2luIjtzOjQ6IkJsb2ciO3M6NDoic29ydCI7aToyO3M6NDoibmFtZSI7czoyMToi44Kr44OG44K044Oq44O85LiA6KanIjtzOjU6ImNvdW50IjtzOjE6IjEiO3M6MTU6ImJsb2dfY29udGVudF9pZCI7czoxOiIxIjtzOjk6InVzZV90aXRsZSI7czoxOiIxIjtzOjY6InN0YXR1cyI7czoxOiIxIjt9fWk6MjthOjE6e3M6NzoiV2lkZ2V0MyI7YToxMTp7czoyOiJpZCI7czoxOiIzIjtzOjQ6InR5cGUiO3M6Mjc6IuaciOWIpeOCouODvOOCq+OCpOODluS4gOimpyI7czo3OiJlbGVtZW50IjtzOjIxOiJibG9nX21vbnRobHlfYXJjaGl2ZXMiO3M6NjoicGx1Z2luIjtzOjQ6IkJsb2ciO3M6NDoic29ydCI7aTo1O3M6NDoibmFtZSI7czoyNzoi5pyI5Yil44Ki44O844Kr44Kk44OW5LiA6KanIjtzOjU6ImNvdW50IjtzOjI6IjEyIjtzOjEwOiJ2aWV3X2NvdW50IjtzOjE6IjEiO3M6MTU6ImJsb2dfY29udGVudF9pZCI7czoxOiIxIjtzOjk6InVzZV90aXRsZSI7czoxOiIxIjtzOjY6InN0YXR1cyI7czoxOiIxIjt9fWk6MzthOjE6e3M6NzoiV2lkZ2V0NCI7YToxMDp7czoyOiJpZCI7czoxOiI0IjtzOjQ6InR5cGUiO3M6MTU6IuacgOi/keOBruaKleeovyI7czo3OiJlbGVtZW50IjtzOjE5OiJibG9nX3JlY2VudF9lbnRyaWVzIjtzOjY6InBsdWdpbiI7czo0OiJCbG9nIjtzOjQ6InNvcnQiO2k6MztzOjQ6Im5hbWUiO3M6MTU6IuacgOi/keOBruaKleeovyI7czo1OiJjb3VudCI7czoxOiI1IjtzOjE1OiJibG9nX2NvbnRlbnRfaWQiO3M6MToiMSI7czo5OiJ1c2VfdGl0bGUiO3M6MToiMSI7czo2OiJzdGF0dXMiO3M6MToiMSI7fX1pOjQ7YToxOntzOjc6IldpZGdldDUiO2E6MTA6e3M6MjoiaWQiO3M6MToiNSI7czo0OiJ0eXBlIjtzOjI0OiLjg5bjg63jgrDmipXnqL/ogIXkuIDopqciO3M6NzoiZWxlbWVudCI7czoyMDoiYmxvZ19hdXRob3JfYXJjaGl2ZXMiO3M6NjoicGx1Z2luIjtzOjQ6IkJsb2ciO3M6NDoic29ydCI7aTo0O3M6NDoibmFtZSI7czoyNDoi44OW44Ot44Kw5oqV56i/6ICF5LiA6KanIjtzOjEwOiJ2aWV3X2NvdW50IjtzOjE6IjAiO3M6MTU6ImJsb2dfY29udGVudF9pZCI7czoxOiIxIjtzOjk6InVzZV90aXRsZSI7czoxOiIxIjtzOjY6InN0YXR1cyI7czoxOiIxIjt9fWk6NTthOjE6e3M6NzoiV2lkZ2V0NiI7YToxMTp7czoyOiJpZCI7czoxOiI2IjtzOjQ6InR5cGUiO3M6Mjc6IuW5tOWIpeOCouODvOOCq+OCpOODluS4gOimpyI7czo3OiJlbGVtZW50IjtzOjIwOiJibG9nX3llYXJseV9hcmNoaXZlcyI7czo2OiJwbHVnaW4iO3M6NDoiQmxvZyI7czo0OiJzb3J0IjtpOjY7czo0OiJuYW1lIjtzOjI3OiLlubTliKXjgqLjg7zjgqvjgqTjg5bkuIDopqciO3M6NToibGltaXQiO3M6MDoiIjtzOjEwOiJ2aWV3X2NvdW50IjtzOjE6IjAiO3M6MTU6ImJsb2dfY29udGVudF9pZCI7czoxOiIxIjtzOjk6InVzZV90aXRsZSI7czoxOiIxIjtzOjY6InN0YXR1cyI7czoxOiIxIjt9fX0=',
                'modified' => '2020-09-14 20:16:49',
                'created' => '2015-06-26 20:34:07',
            ],
        ];

        $table = $this->table('widget_areas');
        $table->insert($data)->save();
    }
}
