<?php

namespace common\behaviors;

use Yii;
use yii\base\Behavior;
use yii\base\InvalidParamException;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class FileUploader extends Behavior{
    /**
     * Аттрибут файла
     * @var string
     */
    public $attribute;

    /**
     * Аттрибут поля для сохранения файла
     * @var string
     */
    public $attributeField;

    /**
     * Полный путь к файлу
     * @var string
     */
    public $path;

    /**
     * URL к файлу
     * @var string
     */
    public $urlPath;

    /**
     * Имя файла для сохранения
     * @var string
     */
    public $name;

    /**
     * Расширение сохраняемого файла
     * @var string
     */
    public $extension;

    /**
     * @inheritdoc
     */
    public function attach($owner)
    {
        parent::attach($owner);
        if (empty($this->attribute) || is_string($this->attribute) === false){
            throw new InvalidParamException('Не указан "attribute".');
        }elseif (empty($this->path) || is_string($this->path) === false){
            throw new InvalidParamException('Не указан "path".');
        }elseif (empty($this->urlPath) || is_string($this->urlPath) === false){
            throw new InvalidParamException('Не указан "urlPath".');
        }

        $this->path = Yii::getAlias($this->path);
        $this->urlPath = Yii::getAlias($this->urlPath);
        if (is_dir($this->path) === false){
            FileHelper::createDirectory($this->path, 0777);
        }
    }

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }

    /**
     * Получаем путь к файлу
     * @return null|string
     */
    public function getFilePath()
    {
        $path = $this->path . $this->owner->{$this->attributeField};
        if (file_exists($path)){
            return $path;
        }
        return null;
    }

    /**
     * Получаем URL к файлу
     * @return null|string
     */
    public function getFileUrl()
    {
        $path = $this->path . $this->owner->{$this->attributeField};
        if (is_file($path)){
            return $this->urlPath . $this->owner->{$this->attributeField};
        }
        return null;
    }

    /**
     * Удаляем файл
     */
    public function deleteFile()
    {
        if (is_file($this->getFilePath())){
            unlink($this->getFilePath());
        }
    }

    /**
     * @param $event
     */
    public function beforeSave($event)
    {
        $file = UploadedFile::getInstance($this->owner, $this->attribute);
        if ($file !== null){
            $name = ($this->name ? $this->name : $file->name)
                . '.'
                . ($this->extension ? $this->extension : $file->extension);
            if ($file->saveAs($this->path . $name) && $this->attributeField){
                $this->deleteFile();
                $this->owner->{$this->attributeField} = $name;
            }
        }
    }

    /**
     * @param $event
     */
    public function beforeDelete($event)
    {
        $this->deleteFile();
    }
}