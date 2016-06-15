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

use Cawa\Controller\ViewDataTrait;
use Cawa\Renderer\PhtmlHtmlContainer;

class Collapse extends PhtmlHtmlContainer
{
    const TYPE_DEFAULT = 'panel-default';
    const TYPE_PRIMARY = 'panel-primary';
    const TYPE_SUCCESS = 'panel-success';
    const TYPE_INFO = 'panel-info';
    const TYPE_WARNING = 'panel-warning';
    const TYPE_DANGER = 'panel-danger';

    use ViewDataTrait;

    /**
     * @param string $title
     * @param string $content
     * @param string $type
     */
    public function __construct(string $title = null, string $content = null, string $type = self::TYPE_DEFAULT)
    {
        $this->data = [
            'collapse' => true,
            'id' => null,
            'noPanelBody' => false,
        ];

        parent::__construct('<div>');
        $this->addClass(['panel', $type]);

        if ($title !== null) {
            $this->setTitle($title);
        }

        if ($content !== null) {
            $this->setContent($content);
        }
    }

    /**
     * @return string
     */
    public function getTitle() : string
    {
        return $this->data['title'];
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title) : self
    {
        $this->data['title'] = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getParentId() : string
    {
        return $this->data['parentId'];
    }

    /**
     * @param string $parentId
     *
     * @return $this
     */
    public function setParentId(string $parentId) : self
    {
        $this->data['parentId'] = $parentId;

        return $this;
    }

    /**
     * @return bool
     */
    public function isCollapse() : bool
    {
        return $this->data['collapse'];
    }

    /**
     * @param bool $collapse
     *
     * @return $this
     */
    public function setCollapse(bool $collapse) : self
    {
        $this->data['collapse'] = $collapse;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getId() : string
    {
        return $this->data['id'];
    }

    /**
     * @inheritdoc
     */
    public function setId(string $value) : parent
    {
        $this->data['id'] = $value;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function render()
    {
        if (!$this->data['id']) {
            $this->generateId();
        }
        $this->data['content'] = $this->getContent();
        if (isset($this->elements[0]) && $this->elements[0] instanceof ListGroup) {
            $this->data['noPanelBody'] = true;
        }

        return parent::render();
    }
}
