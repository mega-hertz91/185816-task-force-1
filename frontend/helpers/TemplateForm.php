<?php

namespace frontend\helpers;

class TemplateForm
{
    public static function getTemplateFormCategory($label, $value, $name)
    {
        return '<input class="visually-hidden checkbox__input" id="' . $value . '" type="checkbox" name="' . $name . '" value="' . $value . '">
                            <label for="' . $value . '">' . $label . '</label>';
    }
}
