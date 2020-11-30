<?php
declare(strict_types = 1);

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @ORM\Table(name="articles")
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Type(type="string", message="Field `title` should be a string")
     * @NotBlank(message="Field `title` should be not blank")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Type(type="string", message="Field `description` should be a string")
     * @NotBlank(message="Field `description` should be not blank")
     */
    private $description;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $tags;
    
    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    
    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }
    
    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
    
    /**
     * @param string|null $description
     *
     * @return $this
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
    
    /**
     * @return string
     */
    public function getTags(): ?string
    {
        return $this->tags;
    }
    
    /**
     * @param string $tags
     */
    public function setTags(string $tags): void
    {
        $this->tags = $tags;
    }
    
    /**
     * @param string $tagName
     */
    public function addTag(string $tagName): void
    {
        $currentTags = json_decode($this->getTags(), true);

        if (null === $currentTags || !in_array($tagName, $currentTags)) {
            $currentTags[] = $tagName;
            $this->setTags(json_encode($currentTags));
        }
    }
    
    /**
     * @param string $tagName
     */
    public function removeTag(string $tagName): void
    {
        $currentTags = json_decode($this->getTags(), true);
    
        $indexToRemove = array_search($tagName, $currentTags, true);
        unset($currentTags[$indexToRemove]);

        if (is_integer($indexToRemove)) {
            unset($currentTags[$indexToRemove]);
            $this->setTags(json_encode($currentTags));
        }
    }
}
