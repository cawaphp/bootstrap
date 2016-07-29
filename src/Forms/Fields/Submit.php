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

namespace Cawa\Bootstrap\Forms\Fields;

use Cawa\Bootstrap\Components\Button;
use Cawa\Renderer\Container;

class Submit extends \Cawa\Html\Forms\Fields\Submit
{
    use FieldTrait {
        FieldTrait::layout as private fieldTraitLayout;
    }

    const TYPE_DEFAULT = 'btn-default';
    const TYPE_PRIMARY = 'btn-primary';
    const TYPE_SUCCESS = 'btn-success';
    const TYPE_INFO = 'btn-info';
    const TYPE_WARNING = 'btn-warning';
    const TYPE_DANGER = 'btn-danger';

    /**
     * {@inheritdoc}
     */
    public function __construct(string $value)
    {
        parent::__construct($value);
        $this->getField()->addClass(['btn', 'btn-primary']);
        $this->addClass('form-group');
    }

    /**
     * @param string $type
     *
     * @return Submit
     */
    public function setType(string $type) : self
    {
        $reflection = new \ReflectionClass($this);
        foreach ($reflection->getConstants() as $key => $value) {
            if (strpos($key, 'TYPE_') !== false) {
                $this->getField()->removeClass($value);
            }
        }

        $this->getField()->addClass($type);

        return $this;
    }

    /**
     * @var Container
     */
    private $buttons;

    /**
     * @param Button $button
     *
     * @return $this
     */
    public function addButton(Button $button) : self
    {
        if (!$this->buttons) {
            $this->buttons = new Container();
        }

        $this->buttons->add($button);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function layout() : Container
    {
        if (!$this->buttons) {
            return self::fieldTraitLayout();
        }

        $container = self::fieldTraitLayout();
        foreach ($this->buttons->getElements() as $button) {
            $container->first()->addFirst($button);
        }

        return $container;
    }
}
