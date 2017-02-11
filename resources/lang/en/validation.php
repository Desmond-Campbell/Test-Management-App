<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ___( 'The :attribute must be accepted.' ),
    'active_url'           => ___( 'The :attribute is not a valid URL.' ),
    'after'                => ___( 'The :attribute must be a date after :date.' ),
    'after_or_equal'       => ___( 'The :attribute must be a date after or equal to :date.' ),
    'alpha'                => ___( 'The :attribute may only contain letters.' ),
    'alpha_dash'           => ___( 'The :attribute may only contain letters, numbers, and dashes.' ),
    'alpha_num'            => ___( 'The :attribute may only contain letters and numbers.' ),
    'array'                => ___( 'The :attribute must be an array.' ),
    'before'               => ___( 'The :attribute must be a date before :date.' ),
    'before_or_equal'      => ___( 'The :attribute must be a date before or equal to :date.' ),
    'between'              => [
        'numeric' => ___( 'The :attribute must be between :min and :max.' ),
        'file'    => ___( 'The :attribute must be between :min and :max kilobytes.' ),
        'string'  => ___( 'The :attribute must be between :min and :max characters.' ),
        'array'   => ___( 'The :attribute must have between :min and :max items.' ),
    ],
    'boolean'              => ___( 'The :attribute field must be true or false.' ),
    'confirmed'            => ___( 'The :attribute confirmation does not match.' ),
    'date'                 => ___( 'The :attribute is not a valid date.' ),
    'date_format'          => ___( 'The :attribute does not match the format :format.' ),
    'different'            => ___( 'The :attribute and :other must be different.' ),
    'digits'               => ___( 'The :attribute must be :digits digits.' ),
    'digits_between'       => ___( 'The :attribute must be between :min and :max digits.' ),
    'dimensions'           => ___( 'The :attribute has invalid image dimensions.' ),
    'distinct'             => ___( 'The :attribute field has a duplicate value.' ),
    'email'                => ___( 'The :attribute must be a valid email address.' ),
    'exists'               => ___( 'The selected :attribute is invalid.' ),
    'file'                 => ___( 'The :attribute must be a file.' ),
    'filled'               => ___( 'The :attribute field is required.' ),
    'image'                => ___( 'The :attribute must be an image.' ),
    'in'                   => ___( 'The selected :attribute is invalid.' ),
    'in_array'             => ___( 'The :attribute field does not exist in :other.' ),
    'integer'              => ___( 'The :attribute must be an integer.' ),
    'ip'                   => ___( 'The :attribute must be a valid IP address.' ),
    'json'                 => ___( 'The :attribute must be a valid JSON string.' ),
    'max'                  => [
        'numeric' => ___( 'The :attribute may not be greater than :max.' ),
        'file'    => ___( 'The :attribute may not be greater than :max kilobytes.' ),
        'string'  => ___( 'The :attribute may not be greater than :max characters.' ),
        'array'   => ___( 'The :attribute may not have more than :max items.' ),
    ],
    'mimes'                => ___( 'The :attribute must be a file of type: :values.' ),
    'mimetypes'            => ___( 'The :attribute must be a file of type: :values.' ),
    'min'                  => [
        'numeric' => ___( 'The :attribute must be at least :min.' ),
        'file'    => ___( 'The :attribute must be at least :min kilobytes.' ),
        'string'  => ___( 'The :attribute must be at least :min characters.' ),
        'array'   => ___( 'The :attribute must have at least :min items.' ),
    ],
    'not_in'               => ___( 'The selected :attribute is invalid.' ),
    'numeric'              => ___( 'The :attribute must be a number.' ),
    'present'              => ___( 'The :attribute field must be present.' ),
    'regex'                => ___( 'The :attribute format is invalid.' ),
    'required'             => ___( 'The :attribute field is required.' ),
    'required_if'          => ___( 'The :attribute field is required when :other is :value.' ),
    'required_unless'      => ___( 'The :attribute field is required unless :other is in :values.' ),
    'required_with'        => ___( 'The :attribute field is required when :values is present.' ),
    'required_with_all'    => ___( 'The :attribute field is required when :values is present.' ),
    'required_without'     => ___( 'The :attribute field is required when :values is not present.' ),
    'required_without_all' => ___( 'The :attribute field is required when none of :values are present.' ),
    'same'                 => ___( 'The :attribute and :other must match.' ),
    'size'                 => [
        'numeric' => ___( 'The :attribute must be :size.' ),
        'file'    => ___( 'The :attribute must be :size kilobytes.' ),
        'string'  => ___( 'The :attribute must be :size characters.' ),
        'array'   => ___( 'The :attribute must contain :size items.' ),
    ],
    'string'               => ___( 'The :attribute must be a string.' ),
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => ___( 'The :attribute has already been taken.' ),
    'uploaded'             => ___( 'The :attribute failed to upload.' ),
    'url'                  => ___( 'The :attribute format is invalid.' ),

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
