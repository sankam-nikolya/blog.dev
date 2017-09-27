<?php

namespace app\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\FormatConverter;
use yii\base\InvalidParamException;

/**
 * Extended DateTimePicker, allows to set different formats for sending and displaying value
 *
 * Usage:
 * <?= $form->field($model, 'created_from')->widget(\sankam\core\widgets\DateTimePicker::classname()) ?>
 *
 * Class DateTimePicker
 * @package sankam\core\widgets
 */
class DateTimePicker extends \kartik\datetime\DateTimePicker
{
    public $saveDateFormat = 'php:Y-m-d H:i';
    public $removeButtonSelector = '.kv-date-remove';

    public $showDateFormat = 'php:d.m.Y H:i';

    private $savedValueInputID = '';
    private $attributeValue = null;


    public function __construct($config = [])
    {
        $defaultOptions = [
            'type' => static::TYPE_COMPONENT_APPEND,
            'convertFormat' => true,
            'options' => [
                'autocomplete' => 'off'
            ],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => $this->showDateFormat,
                'pickerPosition' => 'top-left',
                'todayHighlight' => true
            ],
        ];
        $config = array_replace_recursive($defaultOptions, $config);

        parent::__construct($config);
    }

    /**
     * Initialize
     */
    public function init()
    {
        if ($this->hasModel()) {
            $model = $this->model;
            $attribute = $this->attribute;
            $value = $model->$attribute;

            $this->model = null;
            $this->attribute = null;
            $this->name = Html::getInputName($model, $attribute);
            $this->attributeValue = $value;

            if ($value) {
                try {
                    $this->value = Yii::$app->formatter->asDateTime($value, $this->pluginOptions['format']);
                } catch (InvalidParamException $e) {
                    $this->value = null;
                }
            }
        }

        return parent::init();
    }

    /**
     * Registering Assets
     */
    public function registerAssets()
    {
        $format = $this->saveDateFormat;
        $format = strncmp($format, 'php:', 4) === 0
            ? substr($format, 4)
            : FormatConverter::convertDateIcuToPhp($format, $type);
        $saveDateFormatJs = static::convertDateFormat($format);

        $this->savedValueInputID = $this->options['id'].'-saved-value';

        $this->pluginOptions['linkField'] = $this->savedValueInputID;
        $this->pluginOptions['linkFormat'] = $saveDateFormatJs;

        return parent::registerAssets();
    }

    /**
     * @param string $input
     * @return string
     */
    protected function parseMarkup($input)
    {
        $res = parent::parseMarkup($input);

        $res .= $this->renderSavedValueInput();
        $this->registerScript();

        return $res;
    }

    /**
     * @return string
     */
    protected function renderSavedValueInput()
    {
        $value = $this->attributeValue;

        if ($value !== null && $value !== '') {
            // format value according to saveDateFormat
            try {
                $value = Yii::$app->formatter->asDateTime($value, $this->saveDateFormat);
            } catch(InvalidParamException $e) {
                // ignore exception and keep original value if it is not a valid date
            }
        }

        $options = $this->options;
        $options['id'] = $this->savedValueInputID;
        $options['value'] = $value;

        // render hidden input
        if ($this->hasModel()) {
            $contents = Html::activeHiddenInput($this->model, $this->attribute, $options);
        } else {
            $contents = Html::hiddenInput($this->name, $value, $options);
        }

        return $contents;
    }

    /**
     * Registering Script
     */
    protected function registerScript()
    {
        $containerID = $this->options['id'] . '-datetime';

        if ($this->removeButtonSelector) {
            $script = "
                $('#{$containerID}').find('{$this->removeButtonSelector}').on('click', function(e) {
                    $('#{$containerID}').find('input').val('').trigger('change');
                    $('#{$containerID}').data('datetimepicker').reset();

                    $('#{$containerID}').trigger('changeDate', {
                        type: 'changeDate',
                        date: null,
                    });
                });

                $('#{$containerID}').trigger('changeDate', {
                    type: 'changeDate',
                    date: null,
                });
            ";

            $view = $this->getView();
            $view->registerJs($script);
        }
    }
}