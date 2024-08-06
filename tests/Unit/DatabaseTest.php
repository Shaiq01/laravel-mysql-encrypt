<?php

use DanielPardamean\MysqlEncrypt\Tests\Models\Testing;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    $schema = $this->app['db']->connection()->getSchemaBuilder();

    $schema->create('testing', function (Blueprint $table) {
        $table->increments('id');
        $table->string('value');
        $table->timestamps();
    });

    DB::statement('ALTER TABLE `testing` MODIFY COLUMN `value` VARBINARY(1024)');

    Testing::create(['value' => 'testing string']);
    Testing::create(['value' => 'hello world']);
    Testing::create(['value' => "it's me"]);
});

it('saves encrypted value to database', function () {
    $data = Testing::all()->toArray();

    expect(count($data))->toBe(3);
    expect($data[0]['value'])->toBe('testing string');
    expect($data[1]['value'])->toBe('hello world');
});

it('can query encrypted data', function () {
    $this->assertCount(1, Testing::query()->whereEncrypted('value', 'testing string')->get());
});

it('can query encrypted datas', function () {
    $query = Testing::query()->whereEncrypted('value', 'testing string')->toSql();
    expect($query)->toMatch('/(AES_DECRYPT\(([^\)]+)\))/');
});
