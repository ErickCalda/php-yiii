<?php

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

declare(strict_types=1);

namespace yii\bootstrap5;

use Throwable;

/**
 * ButtonToolbar Combines sets of button groups into button toolbars for more complex components.
 * Use utility classes as needed to space out groups, buttons, and more.
 *
 * For example,
 *
 * ```php
 * // a button toolbar with items configuration
 * echo ButtonToolbar::widget([
 *     'buttonGroups' => [
 *         [
 *             'buttons' => [
 *                 ['label' => '1', 'options' => ['class' => ['btn-secondary']]],
 *                 ['label' => '2', 'options' => ['class' => ['btn-secondary']]],
 *                 ['label' => '3', 'options' => ['class' => ['btn-secondary']]],
 *                 ['label' => '4', 'options' => ['class' => ['btn-secondary']]]
 *             ],
 *              'class' => ['mr-2']
 *         ],
 *         [
 *             'buttons' => [
 *                 ['label' => '5', 'options' => ['class' => ['btn-secondary']]],
 *                 ['label' => '6', 'options' => ['class' => ['btn-secondary']]],
 *                 ['label' => '7', 'options' => ['class' => ['btn-secondary']]]
 *             ],
 *             'class' => ['mr-2']
 *         ],
 *         [
 *             'buttons' => [
 *                 ['label' => '8', 'options' => ['class' => ['btn-secondary']]]
 *             ]
 *         ]
 *     ]
 * ]);
 * ```
 *
 * Pressing on the button should be handled via JavaScript. See the following for details:
 *
 * @see https://getbootstrap.com/docs/5.1/components/buttons/
 * @see https://getbootstrap.com/docs/5.1/components/button-group/#button-toolbar
 *
 * @author Simon Karlen <simi.albi@outlook.com>
 */
class ButtonToolbar extends Widget
{
    /**
     * @var array list of buttons groups. Each array element represents a single group
     * which can be specified as a string or an array of the following structure:
     *
     * - buttons: array list of buttons. Either as array or string representation
     * - options: array optional, the HTML attributes of the button group.
     * - encodeLabels: bool whether to HTML-encode the button labels.
     */
    public $buttonGroups = [];


    public function init(): void
    {
        parent::init();
        Html::addCssClass($this->options, [
            'widget' => 'btn-toolbar',
        ]);
        if (!isset($this->options['role'])) {
            $this->options['role'] = 'toolbar';
        }
    }

    /**
     * @throws Throwable
     */
    public function run(): string
    {
        BootstrapAsset::register($this->getView());

        return Html::tag('div', $this->renderButtonGroups(), $this->options);
    }

    /**
     * Generates the button groups that compound the toolbar as specified on [[buttonGroups]].
     * @return string the rendering result.
     * @throws Throwable
     */
    protected function renderButtonGroups(): string
    {
        $buttonGroups = [];
        foreach ($this->buttonGroups as $group) {
            if (is_array($group)) {
                $group['view'] = $this->getView();

                if (!isset($group['buttons'])) {
                    continue;
                }

                $buttonGroups[] = ButtonGroup::widget($group);
            } else {
                $buttonGroups[] = $group;
            }
        }

        return implode("\n", $buttonGroups);
    }
}
