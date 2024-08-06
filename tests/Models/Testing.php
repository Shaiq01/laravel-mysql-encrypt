<?php

namespace DanielPardamean\MysqlEncrypt\Tests\Models;

use DanielPardamean\MysqlEncrypt\Traits\Encryptable;
use Illuminate\Database\Eloquent\Model;

class Testing extends Model
{
    use Encryptable;

    protected $table = 'testing';

    protected $guarded = [];

    protected $encryptable = [ // <-- 2. Include columns to be encrypted
        'value',
    ];
}
