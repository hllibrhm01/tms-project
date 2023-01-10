<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class Existed implements Rule
{

    /**
     * Target table name.
     *
     * @var int
     */
    protected $tableName;

    /**
     * Create a new rule instance.
     *
     * @param string $tableName
     *
     * @return void
     */
    public function __construct($tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $valueArray = array_map('trim', explode(',', $value));

        $numberOfExistedIds = DB::table($this->tableName)->whereIn('id', $valueArray)->count();

        if(count($valueArray) !== $numberOfExistedIds) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('Invalid permission id.');
    }
}
