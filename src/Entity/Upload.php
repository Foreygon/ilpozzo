<?php

namespace App\Entity;

use App\Repository\UploadRepository;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: UploadRepository::class)]
class Upload
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    private ?string $fileName = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function setFileName(string $fileName): self
{
    $this->fileName = $fileName;
    
    return $this;
}

}
