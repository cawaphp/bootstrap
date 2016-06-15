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

class ListGroupElement extends HtmlContainer
{
    const SUCCESS = 'list-group-item-success';
    const INFO = 'list-group-item-info';
    const WARNING = 'list-group-item-warning';
    const DANGER = 'list-group-item-danger';

    /**
     * @param string $content
     * @param string $tag
     * @param string $type
     */
    public function __construct(string $content = null, $tag = '<li>', string $type = null)
    {
        parent::__construct($tag, $content);
        $this->addClass('list-group-item');

        if ($type) {
            $this->addClass($type);
        }
    }

    /**
     * @var string
     */
    private $badge;

    /**
     * @return string
     */
    public function getBadge() : string
    {
        return $this->badge;
    }

    /**
     * @param string $badge
     *
     * @return $this
     */
    public function setBadge(string $badge) : self
    {
        $this->badge = $badge;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDisabled() : bool
    {
        return $this->hasClass('disabled');
    }

    /**
     * @param bool $disabled
     *
     * @return $this
     */
    public function setDisabled(bool $disabled = true)
    {
        if ($disabled) {
            $this->addClass('disabled');
        } else {
            $this->removeClass('disabled');
        }

        return $this;
    }

    public function render()
    {
        if ($this->badge) {
            if ($this->content) {
                $this->content = '<span class="badge">' . $this->badge . '</span> ' . $this->content;
            } else {
                $this->addFirst((new HtmlElement('<span>', $this->badge))->addClass('badge'));
            }
        }

        return parent::render();
    }
}
