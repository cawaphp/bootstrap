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

namespace Cawa\Bootstrap\Tables;

use Cawa\Renderer\HtmlElement;
use Cawa\Controller\ViewController;

class Table extends \Cawa\Html\Tables\Table
{
    const QUERY_SORT = 'sort';
    const QUERY_COLUMNS_VISIBLE = 'cols';

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct();
        $this->addClass([
            'table',
            'table-striped',
            'table-bordered',
            'table-hover',
        ]);
    }

    /**
     * @var callable
     */
    private $argsCallback;

    /**
     * @param callable $argsCallback
     *
     * @return $this
     */
    public function setArgsCallback(callable $argsCallback) : self
    {
        $this->argsCallback = $argsCallback;

        return $this;
    }

    /**
     * @param Column $column
     *
     * @return void
     */
    private function configureColumns(Column $column)
    {
        if ($column->isSortable()) {
            $this->sortable = true;
        }

        if ($this->argsCallback) {
            $column->setArgsCallback($this->argsCallback);

            if ($column->isHideable()) {
                $visible = call_user_func($this->argsCallback, self::QUERY_COLUMNS_VISIBLE);
                if ($visible && !in_array($column->getId(), explode('|', $visible))) {
                    $column->setVisible();
                }
            }
        }
    }

    /**
     * @var bool
     */
    private $sortable = false;

    /**
     * @return bool
     */
    public function isSortable() : bool
    {
        return $this->sortable;
    }

    /**
     * {@inheritdoc}
     */
    public function add(ViewController $element)
    {
        /* @var $element Column */
        $this->configureColumns($element);

        return parent::add($element);
    }

    /**
     * {@inheritdoc}
     */
    public function addFirst(ViewController $element)
    {
        /* @var $element Column */
        $this->configureColumns($element);

        return parent::addFirst($element);
    }

    /**
     * @var bool
     */
    private $responsive = false;

    /**
     * @return bool
     */
    public function isResponsive() : bool
    {
        return $this->responsive;
    }

    /**
     * @param bool $responsive
     *
     * @return $this
     */
    public function setResponsive(bool $responsive = true) : self
    {
        $this->responsive = $responsive;

        return $this;
    }

    /**
     * @return bool
     */
    public function isStriped() : bool
    {
        return $this->hasClass('table-striped');
    }

    /**
     * @param bool $striped
     *
     * @return $this
     */
    public function setStriped(bool $striped = true) : self
    {
        if ($striped) {
            $this->addClass('table-striped');
        } else {
            $this->removeClass('table-striped');
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isBordered() : bool
    {
        return $this->hasClass('table-bordered');
    }

    /**
     * @param bool $bordered
     *
     * @return $this
     */
    public function setBordered(bool $bordered = true) : self
    {
        if ($bordered) {
            $this->addClass('table-bordered');
        } else {
            $this->removeClass('table-bordered');
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isHover() : bool
    {
        return $this->hasClass('table-hover');
    }

    /**
     * @param bool $hover
     *
     * @return $this
     */
    public function setHover(bool $hover = true) : self
    {
        if ($hover) {
            $this->addClass('table-hover');
        } else {
            $this->removeClass('table-hover');
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isCondensed() : bool
    {
        return $this->hasClass('table-condensed');
    }

    /**
     * @param bool $condensed
     *
     * @return $this
     */
    public function setCondensed(bool $condensed = true) : self
    {
        if ($condensed) {
            $this->addClass('table-condensed');
        } else {
            $this->removeClass('table-condensed');
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        if ($this->responsive) {
            $div = new HtmlElement('<div>');
            $div->addClass('table-responsive');
            $div->setContent(parent::render());

            return $div->render();
        } else {
            return parent::render();
        }
    }
}
