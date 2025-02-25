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

namespace BaserCore\Annotation;

/**
 * Class UnitTest
 * @package BaserCore\Annotation
 * @Annotation
 */
final class Note
{
    /**
     * Name
     * @var string
     */
    public $name = 'note';

    public $value = '';

}
