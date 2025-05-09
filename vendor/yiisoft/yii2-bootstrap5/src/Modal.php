<?php

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

declare(strict_types=1);

namespace yii\bootstrap5;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

/**
 * Modal renders a modal window that can be toggled by clicking on a button.
 *
 * The following example will show the content enclosed between the [[begin()]]
 * and [[end()]] calls within the modal window:
 *
 * ~~~php
 * Modal::begin([
 *     'title' => 'Hello world',
 *     'toggleButton' => ['label' => 'click me'],
 * ]);
 *
 * echo 'Say hello...';
 *
 * Modal::end();
 * ~~~
 *
 * @see https://getbootstrap.com/docs/5.1/components/modal/
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @author Simon Karlen <simi.albi@outlook.com>
 */
class Modal extends Widget
{
    /**
     * The additional css class of extra large modal
     * @since 2.0.3
     */
    public const SIZE_EXTRA_LARGE = 'modal-xl';
    /**
     * The additional css class of large modal
     */
    public const SIZE_LARGE = 'modal-lg';
    /**
     * The additional css class of small modal
     */
    public const SIZE_SMALL = 'modal-sm';
    /**
     * The additional css class of default modal
     */
    public const SIZE_DEFAULT = '';

    /**
     * @var string the title content in the modal window.
     */
    public $title;
    /**
     * @var array additional title options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $titleOptions = [];
    /**
     * @var array additional header options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $headerOptions = [];
    /**
     * @var array body options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $bodyOptions = [];
    /**
     * @var string|null the footer content in the modal window.
     */
    public $footer;
    /**
     * @var array additional footer options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $footerOptions = [];
    /**
     * @var string|null the modal size. Can be [[SIZE_LARGE]] or [[SIZE_SMALL]], or empty for default.
     */
    public $size;
    /**
     * @var array|false the options for rendering the close button tag.
     * The close button is displayed in the header of the modal window. Clicking
     * on the button will hide the modal window. If this is false, no close button will be rendered.
     *
     * The following special options are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'button'.
     *
     * The rest of the options will be rendered as the HTML attributes of the button tag.
     * Please refer to the [Modal plugin help](https://getbootstrap.com/javascript/#modals)
     * for the supported HTML attributes.
     */
    public $closeButton = [];
    /**
     * @var array|false the options for rendering the toggle button tag.
     * The toggle button is used to toggle the visibility of the modal window.
     * If this property is false, no toggle button will be rendered.
     *
     * The following special options are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'button'.
     * - label: string, the label of the button. Defaults to 'Show'.
     *
     * The rest of the options will be rendered as the HTML attributes of the button tag.
     * Please refer to the [Modal plugin help](https://getbootstrap.com/javascript/#modals)
     * for the supported HTML attributes.
     */
    public $toggleButton = false;
    /**
     * @var boolean whether to center the modal vertically
     *
     * When true the modal-dialog-centered class will be added to the modal-dialog
     * @since 2.0.9
     */
    public $centerVertical = false;
    /**
     * @var boolean whether to make the modal body scrollable
     *
     * When true the modal-dialog-scrollable class will be added to the modal-dialog
     * @since 2.0.9
     */
    public $scrollable = false;
    /**
     * @var array modal dialog options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     * @since 2.0.9
     */
    public $dialogOptions = [];


    /**
     * @throws InvalidConfigException
     */
    public function init(): void
    {
        parent::init();

        $this->initOptions();

        ob_start();

        echo $this->renderToggleButton() . "\n";
        echo Html::beginTag('div', $this->options) . "\n";
        echo Html::beginTag('div', $this->dialogOptions) . "\n";
        echo Html::beginTag('div', [
            'class' => 'modal-content',
        ]) . "\n";
        echo $this->renderHeader() . "\n";
        echo $this->renderBodyBegin() . "\n";
    }

    /**
     * Renders the widget.
     */
    public function run(): string
    {
        $content = ob_get_clean();
        $content .= "\n" . $this->renderBodyEnd();
        $content .= "\n" . $this->renderFooter();
        $content .= "\n" . Html::endTag('div'); // modal-content
        $content .= "\n" . Html::endTag('div'); // modal-dialog
        $content .= "\n" . Html::endTag('div');

        $this->registerPlugin('modal');

        return $content;
    }

    /**
     * Renders the header HTML markup of the modal
     * @return string the rendering result
     */
    protected function renderHeader(): string
    {
        $button = $this->renderCloseButton();
        if (isset($this->title)) {
            Html::addCssClass($this->titleOptions, [
                'widget' => 'modal-title',
            ]);
            $header = Html::tag('h5', $this->title, $this->titleOptions);
        } else {
            $header = '';
        }

        if ($button !== null) {
            $header .= "\n" . $button;
        } elseif ($header === '') {
            return '';
        }
        Html::addCssClass($this->headerOptions, [
            'widget' => 'modal-header',
        ]);

        return Html::tag('div', "\n" . $header . "\n", $this->headerOptions);
    }

    /**
     * Renders the opening tag of the modal body.
     * @return string the rendering result
     */
    protected function renderBodyBegin(): string
    {
        Html::addCssClass($this->bodyOptions, [
            'widget' => 'modal-body',
        ]);

        return Html::beginTag('div', $this->bodyOptions);
    }

    /**
     * Renders the closing tag of the modal body.
     * @return string the rendering result
     */
    protected function renderBodyEnd(): string
    {
        return Html::endTag('div');
    }

    /**
     * Renders the HTML markup for the footer of the modal
     * @return string|null the rendering result
     */
    protected function renderFooter(): ?string
    {
        if (isset($this->footer)) {
            Html::addCssClass($this->footerOptions, [
                'widget' => 'modal-footer',
            ]);

            return Html::tag('div', "\n" . $this->footer . "\n", $this->footerOptions);
        } else {
            return null;
        }
    }

    /**
     * Renders the toggle button.
     * @return string|null the rendering result
     */
    protected function renderToggleButton(): ?string
    {
        if (($toggleButton = $this->toggleButton) !== false) {
            $tag = ArrayHelper::remove($toggleButton, 'tag', 'button');
            $label = ArrayHelper::remove($toggleButton, 'label', 'Show');

            return Html::tag($tag, $label, $toggleButton);
        } else {
            return null;
        }
    }

    /**
     * Renders the close button.
     * @return string|null the rendering result
     */
    protected function renderCloseButton(): ?string
    {
        if (($closeButton = $this->closeButton) !== false) {
            $tag = ArrayHelper::remove($closeButton, 'tag', 'button');
            $label = ArrayHelper::remove($closeButton, 'label', '');
            if ($tag === 'button' && !isset($closeButton['type'])) {
                $closeButton['type'] = 'button';
            }

            return Html::tag($tag, $label, $closeButton);
        } else {
            return null;
        }
    }

    /**
     * Initializes the widget options.
     * This method sets the default values for various options.
     */
    protected function initOptions(): void
    {
        $this->options = array_merge([
            'tabindex' => -1,
            'aria-hidden' => 'true',
        ], $this->options);
        Html::addCssClass($this->options, [
            'widget' => 'modal fade',
        ]);

        if (!empty($this->clientOptions)) {
            $this->clientOptions = array_merge([
                'show' => false,
            ], $this->clientOptions);
        }

        $this->titleOptions = array_merge([
            'id' => $this->options['id'] . '-label',
        ], $this->titleOptions);
        if (!isset($this->options['aria']['label'], $this->options['aria']['labelledby']) && isset($this->title)) {
            $this->options['aria']['labelledby'] = $this->titleOptions['id'];
        }

        if ($this->closeButton !== false) {
            $this->closeButton = array_merge([
                'class' => [
                    'widget' => 'btn-close',
                ],
                'data' => [
                    'bs-dismiss' => 'modal',
                ],
                'aria' => [
                    'label' => Yii::t('yii/bootstrap5', 'Close'),
                ],
            ], $this->closeButton);
        }

        if ($this->toggleButton !== false) {
            $this->toggleButton = array_merge([
                'data' => [
                    'bs-toggle' => 'modal',
                ],
                'type' => 'button',
            ], $this->toggleButton);
            if (!isset($this->toggleButton['data']['bs-target']) && !isset($this->toggleButton['href'])) {
                $this->toggleButton['data']['bs-target'] = '#' . $this->options['id'];
            }
        }

        Html::addCssClass($this->dialogOptions, [
            'widget' => 'modal-dialog',
        ]);
        if (isset($this->size)) {
            Html::addCssClass($this->dialogOptions, [
                'size' => $this->size,
            ]);
        }
        if ($this->centerVertical) {
            Html::addCssClass($this->dialogOptions, [
                'align' => 'modal-dialog-centered',
            ]);
        }
        if ($this->scrollable) {
            Html::addCssClass($this->dialogOptions, [
                'scroll' => 'modal-dialog-scrollable',
            ]);
        }
    }
}
