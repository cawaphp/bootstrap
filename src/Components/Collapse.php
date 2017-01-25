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
            'collapsible' => true,
            'id' => null,
            'noPanelBody' => false,
            'noBody' => false,
            'titleTag' => 'h4'
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
     * @return $this|self
     */
    public function setTitle(string $title) : self
    {
        $this->data['title'] = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitleTag() : string
    {
        return $this->data['titleTag'];
    }

    /**
     * @param string $titleTag
     *
     * @return $this|self
     */
    public function setTitleTag(string $titleTag) : self
    {
        $this->data['titleTag'] = $titleTag;

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
     * @return $this|self
     */
    public function setParentId(string $parentId) : self
    {
        $this->data['parentId'] = $parentId;

        return $this;
    }

    /**
     * @return bool
     */
    public function isCollapsible() : bool
    {
        return $this->data['collapsible'];
    }

    /**
     * @param bool $isCollapsible
     *
     * @return $this|self
     */
    public function setCollapsible(bool $isCollapsible) : self
    {
        $this->data['collapsible'] = $isCollapsible;

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
     * @return $this|self
     */
    public function setCollapse(bool $collapse) : self
    {
        $this->data['collapse'] = $collapse;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getId() : string
    {
        return $this->data['id'];
    }

    /**
     * {@inheritdoc}
     */
    public function setId(string $value) : parent
    {
        $this->data['id'] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $this->setTemplatePath(null, self::class);

        if (!$this->data['id']) {
            $this->generateId();
        }

        $this->data['content'] = $this->getContent();
        if (!$this->getContent() && sizeof($this->getElements()) == 0) {
            $this->data['noBody'] = true;
        }

        if (isset($this->elements[0]) && $this->elements[0] instanceof ListGroup) {
            $this->data['noPanelBody'] = true;
        }

        return parent::render();
    }
}
