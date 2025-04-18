<?php
namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportesExport implements FromCollection, WithHeadings, WithDrawings, WithEvents
{
    use RegistersEventListeners;

    protected $data;
    protected $type;
    protected $imagenes;

    public function __construct($data, $type, $imagenes = [])
    {
        $this->data = $data;
        $this->type = $type;
        $this->imagenes = $imagenes;
    }

    public function collection()
    {
        if ($this->type === 'tabla') {
            return collect($this->data)->map(function ($reporte) {
                return [
                    $reporte->carnet ?? '',
                    $reporte->nombres ?? '',
                    $reporte->apellidos ?? '',
                    $reporte->cedula ?? '',
                    $reporte->turno ?? '',
                    $reporte->sexo ?? '',
                    $reporte->area_conocimiento ?? '',
                    $reporte->carrera ?? '',
                    $reporte->sede ?? '',
                    $reporte->tipo_miembro ?? '',
                    $reporte->ingreso ?? '',
                    $reporte->numero_locker ?? '',
                    $reporte->sala_atencion ?? '',
                    $reporte->tipo_servicio ?? '',
                    $reporte->codigo_computadora ?? '',
                    $reporte->cantidad ?? '',
                    $reporte->atendido_por ?? '',
                ];
            });
        }

        return collect([]);
    }

    public function headings(): array
    {
        if ($this->type === 'tabla') {
            return [
                'Carnet', 'Nombres', 'Apellidos', 'Cédula', 'Turno', 'Sexo',
                'Área del Conocimiento', 'Carrera', 'Sede', 'Tipo de Miembro',
                'Ingreso', 'Número de Locker', 'Sala de Atención', 'Tipo de Servicio',
                'Código Computadora', 'Cantidad', 'Atendido por',
            ];
        }

        return [];
    }

    public function drawings()
    {
        $drawings = [];
        $coordinates = [];
        $startRow = 2;
        for ($i = 0; $i < count($this->imagenes); $i++) {
            $coordinates[] = 'D' . ($startRow + ($i * 18));
        }

        foreach ($this->imagenes as $key => $path) {
            if (file_exists($path)) { // Validar que la imagen exista
                $drawing = new Drawing();
                $drawing->setName($key);
                $drawing->setDescription($key);
                $drawing->setPath($path);
                $drawing->setHeight(300); // Altura del gráfico
                $drawing->setCoordinates(array_shift($coordinates)); // Ubicación del gráfico en la hoja
                $drawings[] = $drawing;
            }
        }

        return $drawings;
    }
}