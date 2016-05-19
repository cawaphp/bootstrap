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

namespace Cawa\Bootstrap\Forms;

use Cawa\Bootstrap\Components\TabContainer;
use Cawa\Controller\ViewController;
use Cawa\Html\Forms\Fields\AbstractField;

class TabGroup extends Group
{
    /**
     * {@inheritdoc}
     */
    public function __construct(string $label = null)
    {
        parent::__construct($label);
        $this->tabContainer = new TabContainer();
    }

    /**
     * @var TabContainer
     */
    private $tabContainer;

    /**
     * Call by Form on populateValue
     *
     * @return array|AbstractField[]
     */
    public function getFields() : array
    {
        $return = [];
        foreach ($this->tabContainer->getTabs() as $tab) {
            $return = array_merge($return, $tab->getElements());
        };

        return $return;
    }

    /**
     * {@inheritdoc}
     */
    public function add(ViewController ...$elements)
    {
        $this->tabContainer->add(...$elements);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addFirst(ViewController ...$elements)
    {
        $this->tabContainer->add(...$elements);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function renderBootstrapProperties()
    {
        $this->applyContainerSizeTrait($this->getFields());

        if ($this->getGridSize()) {
            $render = $this->wrap();
        } else {
            $render = parent::render();
        }

        return $render;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $this->setField($this->tabContainer);

        return parent::render();
    }
}
