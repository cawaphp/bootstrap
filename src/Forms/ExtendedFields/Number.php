<?php

/*
 * This file is part of the Сáша framework.
 *
 * (c) tchiotludo <http://github.com/tchiotludo>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Cawa\Bootstrap\Forms\ExtendedFields;

use Cawa\Bootstrap\Components\Button;

class Number extends \Cawa\Bootstrap\Forms\Fields\Number
{
    /**
     * {@inheritdoc}
     */
    public function __construct(string $name, string $label = null, string $type = null, string $size = null)
    {
        parent::__construct($name, $label);

        $this->addClass('cawa-fields-number');

        $this
            ->addInputGroup(
                (new Button('&nbsp;<i class="fa fa-minus"></i>&nbsp;', $type ?: Button::TYPE_DEFAULT, $size))
                    ->addAttribute('data-action', '-'),
                true)
            ->addInputGroup(
                (new Button('&nbsp;<i class="fa fa-plus"></i>&nbsp;', $type ?: Button::TYPE_DEFAULT, $size))
                    ->addAttribute('data-action', '+'),
                false)
        ;
    }
}
