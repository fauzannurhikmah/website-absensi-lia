<?php

namespace App\Exports;

use App\Models\Presence;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithMapping, WithStyles};

class AttendanceExport implements WithHeadings, FromCollection, WithMapping, WithStyles, ShouldAutoSize
{

    protected $date;
    public function __construct($date)
    {
        $this->date = $date;
    }

    public function collection()
    {
        $presences = Presence::where('date', $this->date)->with('user')->get();
        return collect($presences);
    }

    public function map($attendance): array
    {
        return [
            $attendance->user->name,
            $attendance->user->position->department,
            $attendance->user->position->position,
            $attendance->date,
            $attendance->timeIn
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }


    public function headings(): array
    {
        return [
            'Name',
            'Department',
            'Position',
            'Date',
            'Time Check In',
        ];
    }
}
