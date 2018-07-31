<?php
namespace RecBundle\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileManager {

    public function uploadFile(UploadedFile $file,$uploaddir) {

        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($uploaddir,$fileName);

        return $fileName;
    }

    public function handleImg($entImg,$pathUrl,$oldFilename) {
        if (!is_null($entImg->getImg())) {
            /** @var UploadedFile $file */
            $file = $entImg->getImg();
            $fileName = $this->uploadFile($file, $pathUrl);
            $entImg->setImg($fileName);
        } else
            $entImg->setImg($oldFilename);
    }

}