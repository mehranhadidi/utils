<?php
/**
 * get authenticated user based on token passed
 */
if( ! function_exists('user'))
{
    function user()
    {
        return \Request::get('authenticated_user');
    }
}

/**
 * Return a JSON response with a custom message & validation errors.
 */
if( ! function_exists('validationError'))
{
    function validationError($errors, $message = null)
    {
        return response()->json([
            'message' => $message ?: trans('response.validation_error'),
            'errors'  => $errors,
        ], 422);
    }
}