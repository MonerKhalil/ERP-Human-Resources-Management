<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportEmployeesExport implements FromCollection, WithHeadings, ShouldAutoSize,WithStyles
{
    private $head,$data,$request;
    public function __construct(array $head,$data,$request)
    {
        $this->head = $head;
        $this->data = $data;
        $this->request = $request;
    }

    public function collection()
    {
        $table = [];

        foreach ($this->data as $item){
            $row = null;
            foreach ($this->head as $value){
                if (is_array($value) && isset($value['head'])){
                    $row[] = $item->{$value['relationFunc']}->{$value['key']};
                }else{
                    $row[] = $item->{$value};
                }
            }
//            if (!is_null($this->request->languages)){
            $row[] = $this->getLanguageSkillTable($item->language_skill);
//            }
            $table[] = $row;
        }

        return collect($table);
    }

    public function headings(): array
    {
        $finalHeadings = [];
        foreach ($this->head as $value){
            if (is_array($value) && isset($value['head'])){
                $finalHeadings[] = $value['head'];
            }else{
                $finalHeadings[] = $value;
            }
        }
//        if (!is_null($this->request->languages)){
        $finalHeadings[] = "languages";
//        }
        return $finalHeadings;
    }

    public function styles(Worksheet $sheet)
    {
        // تنسيق خلايا الجدول الرئيسي
        $sheet->getStyle('A1:D1')->applyFromArray([
            'font' => [
                'bold' => true
            ]
        ]);

        // تنسيق خلايا الجدول الصغير
        $sheet->getStyle('D2:D5')->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'D9D9D9',
                ],
            ],
        ]);

        // تنسيق الخطوط في الجدول الصغير
        $sheet->getStyle('D2:D5')->getFont()->setSize(8);

        // تنسيق الخلايا في الجدول الرئيسي
        $sheet->getStyle('A2:C5')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);
    }

    private function getLanguageSkillTable($languages)
    {
//        $table = [implode("|",['LanguageType','ReadSkill','WriteSkill'])];
//        foreach ($languages as $language){
//            $table [] = implode("|",[
//                $language->language->name,
//                $language->read,
//                $language->write,
//            ]);
//        }
//
//        return implode("\n",$table);
        $table = [['LanguageType','ReadSkill','WriteSkill']];
        foreach ($languages as $language){
            $table [] = [
                $language->language->name,
                $language->read,
                $language->write,
            ];
        }

        return $table;
    }
}
