<?php
namespace PhpCupcakes\Helpers;  

class FormHelper
{
    /**
     * Render an input field.
     *
     * @param string $type
     * @param string $name
     * @param string $value
     * @param array $attributes
     * @return string
     */
    public static function renderInput($type, $name, $value = '', $attributes = [])
    {
        $attributesString = self::buildAttributesString($attributes);
        return "<input type=\"$type\" name=\"$name\" value=\"$value\" $attributesString>";
    }
    public static function renderText($name, $value = '', $attributes = [])
    {
        $attributesString = self::buildAttributesString($attributes);
        return "<input type=\"text\" name=\"$name\" value=\"$value\" $attributesString>";
    }
    public static function renderHidden($name, $value = '', $attributes = [])
    {
        $attributesString = self::buildAttributesString($attributes);
        return "<input type=\"hidden\" name=\"$name\" value=\"$value\" $attributesString>";
    }
    public static function renderColor($name, $value = '', $attributes = [])
    {
        $attributesString = self::buildAttributesString($attributes);
        return "<input type=\"color\" name=\"$name\" value=\"$value\" $attributesString>";
    }

    /**
     * Render a textarea.
     *
     * @param string $name
     * @param string $value
     * @param array $attributes
     * @return string
     */
    public static function renderTextarea($name, $value = '', $attributes = [])
    {
        $attributesString = self::buildAttributesString($attributes);
        return "<textarea name=\"$name\" $attributesString>$value</textarea>";
    }

    /**
     * Render a select dropdown.
     *
     * @param string $name
     * @param array $options
     * @param string $selectedValue
     * @param array $attributes
     * @return string
     */
    public static function renderSelect($name, $options, $selectedValue = '', $attributes = [])
    {
        $attributesString = self::buildAttributesString($attributes);
        $html = "<select name=\"$name\" $attributesString>";
        foreach ($options as $value => $label) {
            $selectedAttribute = ($value == $selectedValue) ? 'selected' : '';
            $html .= "<option value=\"$value\" $selectedAttribute>$label</option>";
        }
        $html .= "</select>";
        return $html;
    }

    /**
     * Render a checkbox.
     *
     * @param string $name
     * @param bool $checked
     * @param array $attributes
     * @return string
     */
    public static function renderCheckbox($name, $checked = false, $attributes = [])
    {
        $checkedAttribute = $checked ? 'checked' : '';
        $attributesString = self::buildAttributesString($attributes);
        return "<input type=\"checkbox\" name=\"$name\" value=\"1\" $checkedAttribute $attributesString>";
    }

    /**
     * Render a radio button.
     *
     * @param string $name
     * @param string $value
     * @param bool $checked
     * @param array $attributes
     * @return string
     */
    public static function renderRadio($name, $value, $checked = false, $attributes = [])
    {
        $checkedAttribute = $checked ? 'checked' : '';
        $attributesString = self::buildAttributesString($attributes);
        return "<input type=\"radio\" name=\"$name\" value=\"$value\" $checkedAttribute $attributesString>";
    }

    /**
     * Render a file input.
     *
     * @param string $name
     * @param array $attributes
     * @return string
     */
    public static function renderFileInput($name, $attributes = [])
    {
        $attributesString = self::buildAttributesString($attributes);
        return "<input type=\"file\" name=\"$name\" $attributesString>";
    }

    /**
     * Render a submit button.
     *
     * @param string $value
     * @param array $attributes
     * @return string
     */
    public static function renderSubmit($value, $name, $attributes = [])
    {
        $attributesString = self::buildAttributesString($attributes);
        return "<input type=\"submit\" value=\"$value\" name=\"$name\" $attributesString>";
    }

    /**
     * Render the opening form tag.
     *
     * @param string $action
     * @param string $method
     * @param array $attributes
     * @return string
     */
    public static function renderFormOpen($action, $method = 'post', $attributes = [])
    {
        $attributesString = self::buildAttributesString($attributes);
        return "<form action=\"$action\" method=\"$method\" $attributesString>";
    }

    /**
     * Render the closing form tag.
     *
     * @return string
     */
    public static function renderFormClose()
    {
        return "</form>";
    }

    /**
     * Build the attributes string from an array.
     *
     * @param array $attributes
     * @return string
     */
    private static function buildAttributesString($attributes)
    {
        $attributesString = '';
        foreach ($attributes as $key => $value) {
            if ($value == 'required') {
                $attributesString .= ' required';
            } else {
            $attributesString .= "$key=\"$value\" ";
            }
        }
        return trim($attributesString);
    }
}