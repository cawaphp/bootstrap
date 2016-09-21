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

use Cawa\Net\Uri;
use Cawa\Renderer\HtmlContainer;
use Cawa\Renderer\HtmlElement;

class Pagination extends HtmlElement
{
    const QUERY_PAGE = 'page';

    const SIZE_LARGE = 'pagination-lg';
    const SIZE_SMALL = 'pagination-sm';

    /**
     * @param int $page
     * @param callable $argsCallback
     */
    public function __construct(int $page, callable $argsCallback = null)
    {
        parent::__construct('<nav>');

        $this->page = $page;

        if ($argsCallback) {
            $this->argsCallback = $argsCallback;
        } else {
            $this->argsCallback = function (self $caller, int $page = null) {
                if ($page) {
                    return Uri::parse()->addQuery(self::QUERY_PAGE, (string) $page)->get();
                } else {
                    return (int) Uri::parse()->getQuery(self::QUERY_PAGE);
                }
            };
        }

        $this->current = call_user_func($this->argsCallback, $this) ?: 1;

        $this->ul = new HtmlContainer('<ul>');
        $this->ul->addClass('pagination');
    }

    /**
     * @var HtmlContainer
     */
    private $ul;

    /**
     * @param string $size
     *
     * @return $this
     */
    public function setSize(string $size) : self
    {
        $this->ul->addClass($size);

        return $this;
    }

    /**
     * @var callable
     */
    private $argsCallback;

    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $current = 1;

    /**
     * @var int
     */
    private $maxItem = 4;

    /**
     * @return int
     */
    public function getMaxItem(): int
    {
        return $this->maxItem;
    }

    /**
     * @param int $maxItem
     *
     * @return Pagination
     */
    public function setMaxItem(int $maxItem): Pagination
    {
        if ($maxItem % 2 !== 0) {
            throw new \InvalidArgumentException(sprintf("Invalid maxItem '%s', must be multiple of 2"));
        }

        $this->maxItem = $maxItem;

        return $this;
    }

    /**
     * @param int $page
     * @param string $display
     *
     * @return HtmlElement
     */
    private function getLi(int $page, string $display = null) : HtmlElement
    {
        $li = new HtmlElement('<li>');
        $url = call_user_func($this->argsCallback, $this, $page);

        if ($page == $this->current) {
            $li->addClass($display ? 'disabled' : 'active');
        }

        if ($this->current == $page) {
            $li->setContent('<span href="' . $url . '">' . ($display ?: $page) . '</span>');
        } else {
            $li->setContent('<a href="' . $url . '">' . ($display ?: $page) . '</a>');
        }

        if ($this->current - 1 == $page) {
            $li->addAttribute('rel', 'prev');
        }

        if ($this->current + 1 == $page) {
            $li->addAttribute('rel', 'next');
        }

        return $li;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $this->ul->clear();

        $this->ul->add($this->getLi(max(1, $this->current-1), '&laquo;')->addClass('prev'));

        $min = 1;
        $max = $this->page;

        if ($this->page > $this->maxItem) {
            $min = max(1, $this->current - ($this->maxItem/2));
            $max = min($this->page, $this->current + ($this->maxItem/2));
        }

        if ($min - 1 >= 1) {
            $this->ul->add($this->getLi($min + 1, '...'));
        }

        for ($i=$min; $i<=$max; $i++) {
            $this->ul->add($this->getLi($i));
        }

        if ($max + 1 < $this->page) {
            $this->ul->add($this->getLi($max + 1, '...'));
        }

        $this->ul->add($this->getLi(min($this->page, $this->current+1), '&raquo;')->addClass('next'));

        $this->setContent($this->ul->render());

        return parent::render();
    }
}
