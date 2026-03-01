<?php

return [
    // Enforce that completed/finalized orders have pricing snapshots.
    // Set to false in dev if you are still migrating legacy data.
    'require_snapshot_on_completed_orders' => env('REQUIRE_SNAPSHOT_ON_COMPLETED_ORDERS', true),
];
