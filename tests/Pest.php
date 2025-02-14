<?php

use Plank\LaravelSchemaEvents\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

/**
 * Get the path to a tests migration file.
 */
function migrationPath(string $path = ''): string
{
    return realpath(__DIR__).'/Migrations/'.str($path)->trim('/');
}