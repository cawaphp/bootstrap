<?php

/*
 * This file is part of the Сáша framework.
 *
 * (c) tchiotludo <http://github.com/tchiotludo>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types=1);

namespace Cawa\Bootstrap\Components;

use Cawa\Renderer\HtmlElement;

class Label extends HtmlElement
{
    const TYPE_DEFAULT = 'label-default';
    const TYPE_PRIMARY = 'label-primary';
    const TYPE_SUCCESS = 'label-success';
    const TYPE_INFO = 'label-info';
    const TYPE_WARNING = 'label-warning';
    const TYPE_DANGER = 'label-danger';

    /**
     * @param string $content
     * @param string $type
     */
    public function __construct(string $content, string $type = self::TYPE_DEFAULT)
    {
        parent::__construct('<span>', $content);
        $this->addAttributes([
            'class' => 'label',
        ]);

        $this->addClass($type);
    }
}
