<?php

namespace App\Support;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * "Excel View" of the reports: letter-head rows, then a bordered table.
 */
class Excel
{
    public static function download(string $title, array $columns, array $rows): StreamedResponse
    {
        $columns = $columns ?: ['No data found.'];
        $book = new Spreadsheet;
        $sheet = $book->getActiveSheet()->setTitle(substr(preg_replace('/[^A-Za-z0-9 ]/', '', $title), 0, 31));
        $last = chr(ord('A') + count($columns) - 1);

        foreach ([config('organization.name'), config('organization.address'), 'Phone: '.config('organization.phone').' | Email: '.config('organization.email'), $title] as $i => $line) {
            $row = $i + 1;
            $sheet->mergeCells("A$row:$last$row")->setCellValue("A$row", $line);
            $sheet->getStyle("A$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A4')->getFont()->setBold(true)->setSize(13);

        $sheet->fromArray($columns, null, 'A6');
        // Text is written as plain strings so user data like "=HYPERLINK(...)" never becomes a formula.
        foreach (array_values($rows) as $r => $row) {
            foreach (array_values($row) as $c => $value) {
                $cell = Coordinate::stringFromColumnIndex($c + 1).($r + 7);
                is_int($value) || is_float($value)
                    ? $sheet->setCellValue($cell, $value)
                    : $sheet->setCellValueExplicit($cell, (string) $value, DataType::TYPE_STRING);
            }
        }
        $end = 6 + count($rows);
        $sheet->getStyle("A6:{$last}6")->getFont()->setBold(true);
        $sheet->getStyle("A6:$last$end")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        foreach (range('A', $last) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return new StreamedResponse(fn () => (new Xlsx($book))->save('php://output'), 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="'.$title.'.xlsx"',
        ]);
    }
}
