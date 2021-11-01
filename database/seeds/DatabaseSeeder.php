<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TipoPacienteSeeder::class);
        $this->call(CasaMedicaSeeder::class);
        $this->call(CategoriaMedicamentoSeeder::class);
        $this->call(PersonaSinAccesoSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MedicamentoSeeder::class);
        $this->call(ProveedorSeeder::class);
        $this->call(PacienteSeeder::class);
        //$this->call(AdministrativoSeeder::class);
        $this->call(LoteSeeder::class);
        $this->call(IngresoMedicamentoSeeder::class);
        $this->call(SalidaMedicamentoSeeder::class);
        $this->call(DetalleIngresoSeeder::class);
        $this->call(DetalleSalidaSeeder::class);
    }
}
