<?php

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

declare(strict_types=1);

namespace yii\bootstrap5;

use yii\base\InvalidConfigException;

/**
 * A Bootstrap 5 enhanced version of [[\yii\widgets\ActiveForm]].
 *
 * This class mainly adds the [[layout]] property to choose a Bootstrap 5 form layout.
 * So for example to render a horizontal form you would:
 *
 * ```php
 * use yii\bootstrap5\ActiveForm;
 *
 * $form = ActiveForm::begin(['layout' => 'horizontal'])
 * ```
 *
 * This will set default values for the [[ActiveField]]
 * to render horizontal form fields. In particular the [[ActiveField::template|template]]
 * is set to `{label} {beginWrapper} {input} {error} {endWrapper} {hint}` and the
 * [[ActiveField::horizontalCssClasses|horizontalCssClasses]] are set to:
 *
 * ```php
 * [
 *     'offset' => 'offset-sm-3',
 *     'label' => 'col-sm-3',
 *     'wrapper' => 'col-sm-6',
 *     'error' => '',
 *     'hint' => 'col-sm-3',
 * ]
 * ```
 *
 * To get a different column layout in horizontal mode you can modify those options
 * through [[fieldConfig]]:
 *
 * ```php
 * $form = ActiveForm::begin([
 *     'layout' => 'horizontal',
 *     'fieldConfig' => [
 *         'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
 *         'horizontalCssClasses' => [
 *             'label' => 'col-sm-4',
 *             'offset' => 'offset-sm-4',
 *             'wrapper' => 'col-sm-8',
 *             'error' => '',
 *             'hint' => '',
 *         ],
 *     ],
 * ]);
 * ```
 *
 * @see ActiveField for details on the [[fieldConfig]] options
 * @see https://getbootstrap.com/docs/5.1/components/forms/
 *
 * @author Michael Härtl <haertl.mike@gmail.com>
 * @author Simon Karlen <simi.albi@outlook.com>
 */
class ActiveForm extends \yii\widgets\ActiveForm
{
    /**
     * Default form layout
     */
    public const LAYOUT_DEFAULT = 'default';
    /**
     * Horizontal form layout
     */
    public const LAYOUT_HORIZONTAL = 'horizontal';
    /**
     * Inline form layout
     */
    public const LAYOUT_INLINE = 'inline';
    /**
     * Floating labels form layout
     */
    public const LAYOUT_FLOATING = 'floating';

    /**
     * @var string the default field class name when calling [[field()]] to create a new field.
     * @see fieldConfig
     */
    public $fieldClass = ActiveField::class;
    /**
     * @var array HTML attributes for the form tag. Default is `[]`.
     */
    public $options = [];
    /**
     * @var string the form layout. Either [[LAYOUT_DEFAULT]], [[LAYOUT_HORIZONTAL]] or [[LAYOUT_INLINE]].
     * By choosing a layout, an appropriate default field configuration is applied. This will
     * render the form fields with slightly different markup for each layout. You can
     * override these defaults through [[fieldConfig]].
     * @see ActiveField for details on Bootstrap 5 field configuration
     */
    public $layout = self::LAYOUT_DEFAULT;
    /**
     * @var string the CSS class that is added to a field container when the associated attribute has validation error.
     */
    public $errorCssClass = 'is-invalid';
    public $successCssClass = 'is-valid';
    public $errorSummaryCssClass = 'alert alert-danger';
    public $validationStateOn = self::VALIDATION_STATE_ON_INPUT;


    /**
     * @throws InvalidConfigException
     */
    public function init(): void
    {
        if (!in_array($this->layout, [self::LAYOUT_DEFAULT, self::LAYOUT_HORIZONTAL, self::LAYOUT_INLINE, self::LAYOUT_FLOATING], true)) {
            throw new InvalidConfigException('Invalid layout type: ' . $this->layout);
        }

        if ($this->layout === self::LAYOUT_INLINE) {
            Html::addCssClass($this->options, [
                'widget' => 'form-inline',
            ]);
        }
        parent::init();
    }

    /**
     * @return ActiveField|\yii\widgets\ActiveField
     */
    public function field($model, $attribute, $options = []): ActiveField
    {
        return parent::field($model, $attribute, $options);
    }
}
