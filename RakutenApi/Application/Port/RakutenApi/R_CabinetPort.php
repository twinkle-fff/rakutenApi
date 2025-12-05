<?php
namespace RakutenApi\Application\Port\RakutenApi;

use RakutenApi\Infrastructure\RakutenApi\R_CabinetApi\Dto\InsertImage\InsertImageParams;

interface R_CabinetPort{
    public function getFolders(): array;
    public function insertImage(array|InsertImageParams $imagePrams, string $imagePath):string|bool;
}
