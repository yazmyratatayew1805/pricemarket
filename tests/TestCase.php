<?php

namespace Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Schema;
use Tests\Domain\TestClasses\HasBlueprint;
use Throwable;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected array $modelsToMigrate = [
    ];

    protected function setUp(): void
    {
        parent::setUp();

        collect($this->modelsToMigrate)
            ->map(fn (string $modelClass) => new $modelClass)
            ->reject(fn (Model $model) => Schema::hasTable($model->getTable()))
            ->each(function (Model | HasBlueprint $model): void {
                Schema::create($model->getTable(), function (Blueprint $table) use ($model): void {
                    $model->getBlueprint($table);
                });
            });
    }

    protected function assertExceptionThrown(callable $callable, string $expectedExceptionClass): void
    {
        try {
            $callable();

            $this->assertTrue(false, "Expected exception `{$expectedExceptionClass}` was not thrown.");
        } catch (Throwable $exception) {
            if (! $exception instanceof $expectedExceptionClass) {
                throw $exception;
            }

            $this->assertInstanceOf($expectedExceptionClass, $exception);
        }
    }
}
