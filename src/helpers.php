<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('db_encrypt')) {
    /**
     * Encrypt value.
     *
     * @param  mixed $value
     * @return \Illuminate\Database\Query\Expression
     */
    function db_encrypt($value)
    {
        $key = config('mysql-encrypt.key');

        if (is_null($value)) {
            return DB::raw("AES_ENCRYPT(NULL, '{$key}')");
        }

        $value = addslashes($value);

        return DB::raw("AES_ENCRYPT('{$value}', '{$key}')");
    }
}

if (!function_exists('db_decrypt')) {
    /**
     * Decrpyt value.
     *
     * @param  mixed $column
     * @return \Illuminate\Database\Query\Expression
     */
    function db_decrypt($column, $table = '')
    {
        $key = config('mysql-encrypt.key');

        if(!empty($table)){
            $table_column = $table . '.' . $column;
            return DB::raw("AES_DECRYPT({$table_column}, '{$key}') AS '{$column}'");
        }

        return DB::raw("AES_DECRYPT({$column}, '{$key}') AS '{$column}'");
    }
}


if (!function_exists('db_decrypt_string')) {
    /**
     * Decrpyt value.
     *
     * @param  string  $column
     * @param  string  $value
     * @param  string  $operator
     * @return string
     */
    function db_decrypt_string($column, $value, $operator = 'LIKE')
    {
        return 'AES_DECRYPT(' . $column . ', "' . config("mysql-encrypt.key") . '") ' . $operator . ' "' . $value . '" COLLATE utf8mb4_general_ci';
    }
}
