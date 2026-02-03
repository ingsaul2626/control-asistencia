<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empleado; // Importante para que funcione

class EmpleadoSeeder extends Seeder
{
    public function run(): void
    {
        $trabajadores = [
            ['cedula' => '11.478.405', 'nombre_apellido' => 'GERARDO LOPEZ', 'tipo_trabajador' => 'ADM/FIJO', 'seccion' => 'DIRECCION'],
            ['cedula' => '10.476.650', 'nombre_apellido' => 'ZULLY REYES', 'tipo_trabajador' => 'ADM/FIJO', 'seccion' => 'SALA TECNICA'],
            ['cedula' => '20.615.118', 'nombre_apellido' => 'EDWARD COLINA', 'tipo_trabajador' => 'ADM/CONT', 'seccion' => 'SALA TECNICA'],
            ['cedula' => '20.615.421', 'nombre_apellido' => 'HILDEMARO CHIRINOS', 'tipo_trabajador' => 'ADM/CONT', 'seccion' => 'SALA TECNICA'],
            ['cedula' => '20.616.550', 'nombre_apellido' => 'NAZARETH DAVILA', 'tipo_trabajador' => 'ADM/CONT', 'seccion' => 'SALA TECNICA'],
            ['cedula' => '24.341.200', 'nombre_apellido' => 'MARIA G. NAVA', 'tipo_trabajador' => 'ADM/CONT', 'seccion' => 'SALA TECNICA'],
            ['cedula' => '21.140.400', 'nombre_apellido' => 'FRANCYS RIOS', 'tipo_trabajador' => 'ADM/CONT', 'seccion' => 'INSPECCION DE OBRAS'],
            ['cedula' => '25.100.320', 'nombre_apellido' => 'MARIA B. LOPEZ', 'tipo_trabajador' => 'ADM/CONT', 'seccion' => 'INSPECCION DE OBRAS'],
            ['cedula' => '18.445.900', 'nombre_apellido' => 'RAFAEL BARRIOS', 'tipo_trabajador' => 'ADM/FIJO', 'seccion' => 'INSPECCION DE OBRAS'],
            ['cedula' => '22.333.111', 'nombre_apellido' => 'JESUS ACOSTA', 'tipo_trabajador' => 'ADM/CONT', 'seccion' => 'MANTENIMIENTO'],
            ['cedula' => '19.888.222', 'nombre_apellido' => 'ANA PEREZ', 'tipo_trabajador' => 'ADM/FIJO', 'seccion' => 'SECRETARIA'],
            ['cedula' => '26.444.555', 'nombre_apellido' => 'CARLOS RIVAS', 'tipo_trabajador' => 'ADM/CONT', 'seccion' => 'SALA TECNICA'],
            ['cedula' => '27.555.666', 'nombre_apellido' => 'LAURA GOMEZ', 'tipo_trabajador' => 'ADM/FIJO', 'seccion' => 'DIRECCION'],
        ];

        foreach ($trabajadores as $t) {
            Empleado::updateOrCreate(['cedula' => $t['cedula']], $t);
        }
    }
}
