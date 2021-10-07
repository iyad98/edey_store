<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\File;

class CheckFileRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $required;
    public function __construct($required)
    {
        $this->required = $required;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {


        try {
            $file = File::mimeType($value);
            $index = strpos($file, '/');
            $type = substr($file, 0, $index);
            return strtolower(trim($type)) == 'image' || $file == "application/pdf";
        }catch (\Exception $e) {
            return !$this->required;
        }catch (\Error $e) {
            return !$this->required;
        }

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.file_must_image_pdf');
    }
}
