<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        // This repo defaults tests to sqlite :memory:, but php-sqlite is not always installed on dev hosts.
        // Skip Feature tests (DB-heavy) when sqlite PDO driver is unavailable.
        if (env('DB_CONNECTION') === 'sqlite' && !in_array('sqlite', \PDO::getAvailableDrivers(), true)) {
            $ref = new \ReflectionClass($this);
            $file = (string) $ref->getFileName();
            if (str_contains($file, DIRECTORY_SEPARATOR . 'Feature' . DIRECTORY_SEPARATOR)) {
                $this->markTestSkipped('PDO sqlite driver not available on this host; skipping Feature tests.');
                return;
            }
        }

        parent::setUp();
    }
}
