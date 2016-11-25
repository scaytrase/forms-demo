<?php

namespace ScayTrase\Demo\Forms\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use ScayTrase\Demo\Forms\Form\Type\RelatedType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity()
 * @UniqueEntity(fields={"title"})
 */
class RelatedEntity implements Editable, \JsonSerializable
{
    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(type="guid")
     */
    private $id;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $title = 'New Related';
    /**
     * @var StubEntity
     * @ORM\ManyToOne(targetEntity="ScayTrase\Demo\Forms\Entity\StubEntity")
     */
    private $stub;

    /**
     * RelatedEntity constructor.
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    public function getFormClass()
    {
        return RelatedType::class;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return StubEntity|null
     */
    public function getStub()
    {
        return $this->stub;
    }

    /**
     * @param StubEntity $stub
     */
    public function setStub(StubEntity $stub)
    {
        $this->stub = $stub;
    }

    public static function create()
    {
        return new static();
    }

    public function __toString()
    {
        return $this->title;
    }

    /** {@inheritdoc} */
    public function jsonSerialize()
    {
        return [
            'title' => $this->title,
            'stub'  => $this->stub ? $this->stub->getId() : null,
        ];
    }
}
