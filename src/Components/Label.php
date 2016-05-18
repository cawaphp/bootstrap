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
    const default = 'label-default';
    const PRIMARY = 'label-primary';
    const SUCCESS = 'label-success';
    const INFO = 'label-info';
    const WARNING = 'label-warning';
    const DANGER = 'label-danger';

    /**
     * @param string $content
     * @param string $type
     */
    public function __construct(string $content, string $type = self::default)
    {
        parent::__construct('<span>', $content);
        $this->addAttributes([
            'class' => 'label',
        ]);

        $this->addClass($type);
}
}
