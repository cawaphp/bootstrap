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

namespace Cawa\Bootstrap\Components;

use Cawa\Controller\ViewController;
use Cawa\Renderer\HtmlContainer;

class CollapseContainer extends HtmlContainer
{
    const INITIAL_SHOW_ALL = 'ALL';
    const INITIAL_SHOW_FIRST = 'FIRST';
    const INITIAL_SHOW_NONE = 'NONE';

    /**
     *
     */
    public function __construct()
    {
        parent::__construct('<div>');
        $this->addClass('cawa-collapse panel-group')
            ->addAttributes([
                'role' => 'tablist',
                'aria-multiselectable' => 'true',
            ]);
    }

    /**
     * @var string
     */
    private $initialShow;

    /**
     * @return string
     */
    public function getInitialShow() : string
    {
        return $this->initialShow;
    }

    /**
     * @param string $initialShow
     *
     * @return $this|self
     */
    public function setInitialShow(string $initialShow) : self
    {
        $this->initialShow = $initialShow;

        return $this;
    }

    /**
     * @var bool
     */
    private $isAccordion = true;

    /**
     * @return bool
     */
    public function isIsAccordion() : bool
    {
        return $this->isAccordion;
    }

    /**
     * @param bool $isAccordion
     *
     * @return $this|self
     */
    public function setIsAccordion(bool $isAccordion) : self
    {
        $this->isAccordion = $isAccordion;

        return $this;
    }

    /**
     * @var bool
     */
    private $isCollapsible = true;

    /**
     * @return bool
     */
    public function isCollapsible() : bool
    {
        return $this->isCollapsible;
    }

    /**
     * @param bool $isCollapsible
     *
     * @return $this|self
     */
    public function setCollapsible(bool $isCollapsible) : self
    {
        $this->isCollapsible = $isCollapsible;

        return $this;
    }

    /**
     * @return bool
     */
    public function isCollapseIcon() : bool
    {
        return $this->hasClass('collapse-icon');
    }

    /**
     * @param bool $collapseIcon
     *
     * @return $this|self
     */
    public function setCollapseIcon(bool $collapseIcon = true) : self
    {
        if ($collapseIcon) {
            $this->addClass('collapse-icon');
        } else {
            $this->removeClass('collapse-icon');
        }

        return $this;
    }

    /**
     * @param Collapse $collapse
     * @param bool $first
     *
     * @return Collapse
     */
    private function handleDisplay(Collapse $collapse, bool $first = false) : Collapse
    {
        $collapse->setCollapsible($this->isCollapsible());

        if ($first || (sizeof($this->elements) == 0 && $this->initialShow == self::INITIAL_SHOW_FIRST)) {
            $collapse->setCollapse(false);
        }

        if ($this->initialShow == self::INITIAL_SHOW_ALL) {
            $collapse->setCollapse(false);
        }

        if ($first) {
            /** @var Collapse $element */
            foreach ($this->elements as $element) {
                $element->setCollapse(false);
            }
        }

        if ($this->isAccordion) {
            if (!$this->getId()) {
                $this->generateId();
            }

            $collapse->setParentId($this->getId());
        }

        return $collapse;
    }

    /**
     * {@inheritdoc}
     */
    public function add(ViewController ...$elements)
    {
        foreach ($elements as $element) {
            /* @noinspection PhpParamsInspection */
            parent::add($this->handleDisplay($element));
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addFirst(ViewController ...$elements)
    {
        foreach ($elements as $element) {
            /* @noinspection PhpParamsInspection */
            parent::addFirst($this->handleDisplay($element, true));
        }

        return $this;
    }
}
