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

use Cawa\Bootstrap\Forms\Fields\Textarea;
use Cawa\Renderer\Container;
use Cawa\Renderer\WidgetOption;

class Ckeditor extends Textarea
{
    /**
     * @var WidgetOption
     */
    private $widgetOptions;

    /**
     * {@inheritdoc}
     */
    public function __construct(string $name, string $label = null)
    {
        $this->widgetOptions = new WidgetOption();

        parent::__construct($name, $label);
        $this->getField()->addClass('cawa-fields-ckeditor');
    }

    const ENTER_P = 1;
    const ENTER_BR = 2;
    const ENTER_DIV = 3;

    /**
     * @param int $mode
     *
     * @return $this|self|parent
     */
    public function setEnterMode(int $mode = null) : parent
    {
        $this->widgetOptions->addData('plugin', ['enterMode' => $mode]);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function layout() : Container
    {
        $container = parent::layout();
        if ($this->widgetOptions->count()) {
            $instance = $this->getFieldContainer($container);
            $instance->add($this->widgetOptions);
        }

        return $container;
    }
}
