<?php

use DanielPardamean\MysqlEncrypt\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(DatabaseMigrations::class)->in( __DIR__ );
uses(TestCase::class)->in( __DIR__ );
