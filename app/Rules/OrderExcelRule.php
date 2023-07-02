<?php

namespace App\Rules;

use Illuminate\Http\UploadedFile;
use Illuminate\Contracts\Validation\Rule;

class OrderExcelRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $file;
    public function __construct(UploadedFile $uploadedFile)
    {
        $this->file = $uploadedFile;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $extension = strtolower($this->file->getClientOriginalExtension());
        return in_array($extension, ['csv', 'xls', 'xlsx']);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The excel file must be a file of type: xls, xlsx.';
    }
}
