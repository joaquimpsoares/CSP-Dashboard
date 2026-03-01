<?php

namespace Tests\Unit\Livewire;

use App\Http\Livewire\Pricing\PriceListsIndex;
use Tests\TestCase;

/**
 * Tests that the "Create price list" drawer state is managed correctly
 * by PriceListsIndex without requiring any database interaction.
 */
class PriceListsIndexDrawerTest extends TestCase
{
    public function test_create_drawer_is_closed_by_default(): void
    {
        $component = new PriceListsIndex();

        $this->assertFalse($component->showCreateDrawer);
    }

    public function test_open_create_drawer_sets_flag_to_true(): void
    {
        $component = new PriceListsIndex();

        $component->openCreateDrawer();

        $this->assertTrue($component->showCreateDrawer);
    }

    public function test_close_create_drawer_sets_flag_to_false(): void
    {
        $component = new PriceListsIndex();
        $component->showCreateDrawer = true;

        $component->closeCreateDrawer();

        $this->assertFalse($component->showCreateDrawer);
    }

    public function test_new_name_field_is_empty_by_default(): void
    {
        $component = new PriceListsIndex();

        $this->assertSame('', $component->newName);
        $this->assertSame('', $component->newCurrency);
        $this->assertSame('', $component->newMarket);
    }
}
