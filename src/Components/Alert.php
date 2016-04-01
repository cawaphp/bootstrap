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

use Cawa\Core\Controller\Renderer\HtmlElement;

class Alert extends HtmlElement
{
    const SUCCESS = 'alert-success';
    const INFO = 'alert-info';
    const WARNING = 'alert-warning';
    const DANGER = 'alert-danger';

    /**
     * @param string $content
     * @param string $type
     */
    public function __construct(string $content, string $type = self::DANGER)
    {
        parent::__construct('<div>', $content);
        $this->addAttributes([
            'class' => 'alert',
            'role' => 'alert',
        ]);

        $this->addClass($type);
    }

    /**
     * @return bool
     */
    public function isDismissible() : bool
    {
        return $this->hasClass('alert-dismissible');
    }

    /**
     * @param bool $dismissible
     *
     * @return $this
     */
    public function setDismissible(bool $dismissible = true)
    {
        if ($dismissible) {
            $this->addClass('alert-dismissible');
        } else {
            $this->removeClass('alert-dismissible');
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        if ($this->isDismissible()) {
            $content = $this->getContent();
            $this->setContent(
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' .
                '<span aria-hidden="true">&times;</span></button>' .
                $content
            );
        }

        $return = parent::render();

        if (isset($content)) {
            $this->setContent($content);
        }

        return $return;
    }
}
