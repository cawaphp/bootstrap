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

namespace Cawa\Bootstrap\Tables;

use Cawa\Net\Uri;
use Cawa\Renderer\HtmlElement;

class Column extends \Cawa\Html\Tables\Column
{
    const QUERY_SORT = 'sort';

    /**
     * {@inheritdoc}
     */
    public function __construct($id, $name = null)
    {
        parent::__construct($id, $name);

        $this->argsCallback =  function (self $caller, string $sort = null) {
            if ($sort) {
                return Uri::parse()->addQuery(self::QUERY_SORT, $sort)->get();
            } else {
                return Uri::parse()->getQuery(self::QUERY_SORT);
            }
        };
    }

    /**
     * @var string
     */
    private $argsCallback = 'sort';

    /**
     * @param callable $argsCallback
     *
     * @return $this|self
     */
    public function setArgsCallback(callable $argsCallback) : self
    {
        $this->argsCallback = $argsCallback;

        return $this;
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
     * @param bool $sortable
     *
     * @return $this|self
     */
    public function setSortable(bool $sortable = true) : self
    {
        $this->sortable = $sortable;

        return $this;
    }

    /**
     * if true: sort ASC, if false: sort DESC, if null: no sort
     *
     * @var bool
     */
    private $defaultSort;

    /**
     * @return bool
     */
    public function isDefaultSort()
    {
        return $this->defaultSort;
    }

    /**
     * @param bool $defaultSort
     *
     * @return $this|self
     */
    public function setDefaultSort(bool $defaultSort = null) : self
    {
        $this->defaultSort = $defaultSort;

        return $this;
    }

    /**
     * @param string $sortString
     *
     * @return array
     */
    public static function getSort(string $sortString) : array
    {
        $explode = explode('-', $sortString);

        $currentOrder = array_pop($explode);
        $currentCols = implode('-', $explode);

        return [$currentCols, $currentOrder == 'A' ? 1 : -1];
    }

    /**
     * @var string
     */
    private $icon;

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     *
     * @return $this|self
     */
    public function setIcon(string $icon) : self
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $clone = clone $this;

        return $clone->renderClone();
    }

    /**
     * @return string
     */
    private function renderClone() : string
    {
        $currentSort = call_user_func($this->argsCallback, $this);
        $currentOrder = $currentCols = $href = null;

        if ($currentSort) {
            list($currentCols, $currentOrder) = self::getSort($currentSort);
        }

        if ($this->isSortable()) {
            $sortIcon = (new HtmlElement('<i>'))
                ->addClass('sort');

            /* @var string $href */
            if (is_null($currentSort) || $currentCols != $this->getId()) {
                $sortIcon->addClass(['fa', 'fa-sort']);
                $href = call_user_func($this->argsCallback, $this, $this->getId() . '-A');
            } elseif ($currentCols == $this->getId() && $currentOrder > 0) {
                $sortIcon->addClass(['fa', 'fa-sort-desc']);
                $href = call_user_func($this->argsCallback, $this, $this->getId() . '-D');
            } elseif ($currentCols == $this->getId()) {
                $sortIcon->addClass(['fa', 'fa-sort-asc']);
                $href = call_user_func($this->argsCallback, $this, $this->getId() . '-A');
            }

            $icon = null;
            if ($this->icon) {
                $icon = (new HtmlElement('<i>'))
                    ->addClass('icon')
                    ->addClass($this->icon)
                    ->render();
            }

            $finalContent = ($icon ? $icon . ' ' : '') .
                $this->getContent() .
                ' ' . $sortIcon->render();

            $this->setContent(
                (new HtmlElement('<a>'))
                    ->addAttribute('href', $href)
                    ->setContent($finalContent)
                    ->render()
            );
        }

        return parent::render();
    }
}
