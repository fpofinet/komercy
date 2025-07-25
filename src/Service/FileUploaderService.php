<?php
namespace App\Service;

use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FileUploaderService{
    // /**
    //  * Summary of targetDirectory
    //  * @var string
    //  */
    //private string $targetDirectory;

    /**
     * Summary of __construct
     * @param string $targetDirectory
     */
    public function __construct(private string $targetDirectory) {

    }
    /**
     * Summary of upload
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @return string
     */
    public function upload(UploadedFile $file): string
    {
        $uniqueFilename = uniqid('img_', true) . '.' . $file->guessExtension();
        try {
            $file->move($this->getTargetDirectory(), $uniqueFilename);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
            throw new Exception($e->getMessage());
        }
        return $uniqueFilename;
    }

    /**
     * Summary of delete
     * @param string $relativePath
     * @return bool
     */
    public function delete(string $relativePath): bool
    {
        $filename = basename($relativePath);
        $absolutePath = realpath($this->getTargetDirectory() . DIRECTORY_SEPARATOR . $filename);

        if (!$absolutePath || !file_exists($absolutePath)) {
            return false;
        }

        $targetDir = realpath($this->getTargetDirectory());
        if (strpos($absolutePath, $targetDir) !== 0) {
            return false; // Sécurité : tentative d'accès à un fichier hors du dossier
        }

        return unlink($absolutePath);
    }

    /**
     * Summary of getTargetDirectory
     * @return string
     */
    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    } 
}