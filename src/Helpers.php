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

if( ! function_exists('test'))
{
    function test()
    {
        return 'test is working';
    }
}