<?php

/*
 * This file is part of the Сáша framework.
 *
 * (c) tchiotludo <http://github.com/tchiotludo>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types = 1);

namespace Cawa\Bootstrap\Tables\ColumnRenderer;

use Cawa\Bootstrap\Components\Label as LabelComponent;
use Cawa\Html\Tables\Column;
use Cawa\Html\Tables\ColumnRenderer\AbstractRenderer;

class Label extends AbstractRenderer
{
    /**
     * @var callable
     */
    private $callable;

    /**
     * @param callable $callable
     */
    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke($content, Column $column, array $primaryValues, array $data) : string
    {
        $function = $this->callable;
        $type = $function($content, $column, $primaryValues, $data);

        if (is_bool($type)) {
            $type = $type ? LabelComponent::TYPE_SUCCESS : LabelComponent::TYPE_DANGER;
        }

        $label = new LabelComponent($content, $type);

        return $label->render();
    }
}
