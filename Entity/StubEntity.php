<?php

namespace ScayTrase\Demo\Forms\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use ScayTrase\Demo\Forms\Form\Type\StubType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity()
 * @UniqueEntity(fields={"title"})
 */
class StubEntity implements Editable, \JsonSerializable
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
    private $title = 'New stub';

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $payload = '';

    /**
     * StubEntity constructor.
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4();
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
     * @return string
     */
    public function getPayload(): string
    {
        return $this->payload;
    }

    /**
     * @param string $payload
     */
    public function setPayload(string $payload)
    {
        $this->payload = $payload;
    }

    public function getFormClass()
    {
        return StubType::class;
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
            'title'   => $this->title,
            'payload' => $this->payload,
        ];
    }
}
