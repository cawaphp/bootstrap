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
use Cawa\Net\Uri;

class Column extends \Cawa\Html\Tables\Column
{
    const QUERY_SORT = 'sort';

    /**
     * {@inheritdoc}
     */
    public function __construct($id, $name)
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
     * @return $this
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
     * @return $this
     */
    public function setSortable(bool $sortable = true) : self
    {
        $this->sortable = $sortable;

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
            $icon = new HtmlElement('<i>');
            if (is_null($currentSort) || $currentCols != $this->getId()) {
                $icon->addClass(['fa', 'fa-sort']);
                $href = call_user_func($this->argsCallback, $this, $this->getId() . '-A');
            } elseif ($currentCols == $this->getId() && $currentOrder > 0) {
                $icon->addClass(['fa', 'fa-sort-desc']);
                $href = call_user_func($this->argsCallback, $this, $this->getId() . '-D');
            } elseif ($currentCols == $this->getId()) {
                $icon->addClass(['fa', 'fa-sort-asc']);
                $href = call_user_func($this->argsCallback, $this, $this->getId() . '-A');
            }

            $this->setContent(
                HtmlElement::create('<a>')
                    ->addAttribute('href', $href)
                    ->setContent($this->getContent() . ' ' . $icon->render())
                    ->render()
            );
        }

        return parent::render();
    }
}
