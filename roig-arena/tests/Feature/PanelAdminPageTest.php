<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PanelAdminPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_panel_admin_se_renderiza_en_su_ruta(): void
    {
        $response = $this->get('/panel-admin');

        $response->assertOk();
        $response->assertSee('Panel de Control');
    }
}
