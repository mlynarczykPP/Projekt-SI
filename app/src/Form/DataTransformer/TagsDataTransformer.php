<?php

/**
 * Tags data transformer.
 */

namespace App\Form\DataTransformer;

use App\Entity\Tags;
use App\Repository\TagsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class TagsDataTransformer.
 */
class TagsDataTransformer implements DataTransformerInterface
{
    /**
     * Tag repository.
     *
     * @var TagsRepository
     */
    private $repository;

    /**
     * TagsDataTransformer constructor.
     *
     * @param TagsRepository $repository Tag repository
     */
    public function __construct(TagsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Transform array of tags to string of names.
     *
     * @param Collection $tags Tags entity collection
     *
     * @return string Result
     */
    public function transform($tags): string
    {
        if (null == $tags) {
            return '';
        }

        $tagNames = [];
        foreach ($tags as $tag) {
            $tagNames[] = $tag->getName();
        }

        return implode(',', $tagNames);
    }

    /**
     * Transform string of tag names into array of Tag entities.
     *
     * @param string $value String of tag names
     *
     * @return array Result
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function reverseTransform($value): array
    {
        $tagName = explode(',', $value);
        $tags = [];
        foreach ($tagName as $tagName) {
            if ('' !== trim($tagName)) {
                $tag = $this->repository->findOneByName(strtolower($tagName));
                if (null == $tag) {
                    $tag = new Tags();
                    $tag->setName($tagName);
                    $this->repository->save($tag);
                }
                $tags[] = $tag;
            }
        }

        return $tags;
    }
}
