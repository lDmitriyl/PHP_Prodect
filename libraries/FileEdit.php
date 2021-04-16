<?php


namespace libraries;


class FileEdit
{

    protected $imgArr = [];
    protected $directory;
    protected $uniqueFile = true;

    public function addFile($directory = ''){

        $directory = trim($directory, ' /');

        $directory .= '/';

        $this->setDirectory($directory);

        foreach ($_FILES as $key => $file){

                if($file['name']){

                    $res_name = $this->createFile($file);

                    if($res_name) $this->imgArr[$key] = $directory . $res_name;

                }

        }

        return $this->getFiles();

    }

    protected function createFile($file){

        $fileNameArr = explode('.', $file['name']);
        $ext = $fileNameArr[count($fileNameArr) - 1];
        unset($fileNameArr[count($fileNameArr) - 1]);

        $fileName = implode('.', $fileNameArr);

        $fileName = $this->checkFile($fileName, $ext);

        $fileFullName = $this->directory . $fileName;

        if($this->uploadFile($file['tmp_name'], $fileFullName))
            return $fileName;

        return false;

    }

    protected function uploadFile($tmpName, $dest){

        if(move_uploaded_file($tmpName, $dest)) return true;

        return false;

    }

    protected function checkFile($fileName, $ext, $fileLastName = ''){

            if(!file_exists($this->directory . $fileName . $fileLastName . '.' . $ext) || !$this->uniqueFile)
                return $fileName . $fileLastName . '.' . $ext;

            return $this->checkFile($fileName, $ext, '_' . hash('crc32', time(). mt_rand(1, 1000)));

    }

    public function setUniqueFile($value){

        $this->uniqueFile = $value ? true : false;

    }

    public function setDirectory($directory){

        $this->directory = $_SERVER['DOCUMENT_ROOT'] . PATH . UPLOAD_DIR . $directory;

        if(!file_exists($this->directory)) mkdir($this->directory, 0777, true);

    }

    public function getFiles(){

        return $this->imgArr;

    }


}