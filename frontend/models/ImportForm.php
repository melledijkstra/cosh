<?php

namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;

class ImportForm extends Model
{

    /**
     * The uploaded file to import
     * @var UploadedFile
     */
    public $uploadedFile;

    /**
     * The imported rows
     * @var array|null
     */
    public $rows;

    public function rules()
    {
        return [
            ['uploadedFile', 'required'],
            ['uploadedFile', 'file', 'checkExtensionByMimeType' => false, 'extensions' => ['csv']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'uploadedFile' => 'Import File',
        ];
    }

    /**
     * Parse the file
     */
    public function parseFile()
    {
        $file = fopen($this->uploadedFile->tempName, 'r');
        $rows = [];
        while($row = fgetcsv($file, 0, ';')) {
            foreach ($row as $i => $data) {
                $row[$i] = utf8_encode(trim($data));
            }
            $rows[] = $row;
        }
        fclose($file);
        $this->rows = $rows;
    }

}