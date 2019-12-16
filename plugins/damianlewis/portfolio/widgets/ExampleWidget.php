<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Widgets;

use Backend\Classes\WidgetBase;

class ExampleWidget extends WidgetBase
{
    protected $defaultAlias = 'exampleWidget';

    public function render()
    {
        $this->vars['value'] = 'Example widget';

        return $this->makePartial('example_widget');
    }

    public function onButtonClick()
    {
        $this->vars['value'] = 'Button clicked';

        return [
            '#widgetReplace' => $this->makePartial('button_clicked')
        ];
    }
}
