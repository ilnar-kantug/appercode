<?php

namespace App\UseCases;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class XmlService
{
    const INDEX = 0;

    public function createDoc($users)
    {
        if (empty($users)){
            throw new \Exception('Cant create XML - users[] are empty');
        }

        $outputFileName = storage_path('xml/users'.time().'.xlsx');

        $xml =  new Spreadsheet();

        $this->setSheetTitles($xml);

        $this->setDataToSheet($xml, $users);

        $this->saveSheet($xml, $outputFileName);

        return $outputFileName;
    }

    private function saveSheet($xml, $outputFileName)
    {
        $writer = IOFactory::createWriter($xml, 'Xlsx');
        $writer->save($outputFileName);
    }

    private function setSheetTitles($xml)
    {
        $xml->setActiveSheetIndex(self::INDEX)->setCellValue('A1', 'ID');
        $xml->setActiveSheetIndex(self::INDEX)->setCellValue('B1', 'Логин');
        $xml->setActiveSheetIndex(self::INDEX)->setCellValue('C1', 'Роль');
        $xml->setActiveSheetIndex(self::INDEX)->setCellValue('D1', 'Имя');
        $xml->setActiveSheetIndex(self::INDEX)->setCellValue('E1', 'Фамилия');
        $xml->setActiveSheetIndex(self::INDEX)->setCellValue('F1', 'Должность');
    }

    private function setDataToSheet($xml, $users)
    {
        $i = 2;
        foreach ($users as $user){
            $xml->setActiveSheetIndex(self::INDEX)->setCellValue('A'.($i), $user['id']);
            $xml->setActiveSheetIndex(self::INDEX)->setCellValue('B'.($i), $user['username']);
            $xml->setActiveSheetIndex(self::INDEX)->setCellValue('C'.($i), $user['roleId']);
            !isset($user['firstName']) ?: $xml->setActiveSheetIndex(self::INDEX)->setCellValue('D'.($i), $user['firstName']);
            !isset($user['lastName']) ?: $xml->setActiveSheetIndex(self::INDEX)->setCellValue('E'.($i), $user['lastName']);
            !isset($user['position']) ?: $xml->setActiveSheetIndex(self::INDEX)->setCellValue('F'.($i), $user['position']);
            $i++;
        }
    }
}
