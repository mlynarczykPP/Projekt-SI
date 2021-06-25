<?php

/**
 * Tag service.
 */

namespace App\Service;

use App\Entity\Tags;
use App\Repository\TagsRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class TagService.
 */
class TagService
{
    /**
     * Tag repository.
     */
    private $tagsRepository;
    /**
     * Paginator.
     */
    private $paginator;

    /**
     * TagService constructor.
     *
     * @param TagsRepository     $tagsRepository Tag repository
     * @param PaginatorInterface $paginator      Paginator
     */
    public function __construct(TagsRepository $tagsRepository, PaginatorInterface $paginator)
    {
        $this->tagsRepository = $tagsRepository;
        $this->paginator = $paginator;
    }

    /**
     * Create paginated list.
     *
     * @param int           $page Page number
     * @param UserInterface $user User entity
     *
     * @return PaginationInterface Paginated list
     */
    public function createPaginatedList(int $page, UserInterface $user): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->tagsRepository->queryByAuthor($user),
            $page,
            TagsRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save tag.
     *
     * @param Tags $tags Tag entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Tags $tags): void
    {
        $this->tagsRepository->save($tags);
    }

    /**
     * Delete tag.
     *
     * @param Tags $tags Tag entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Tags $tags): void
    {
        $this->tagsRepository->delete($tags);
    }

    /**
     * Find tag by Id.
     *
     * @param int $id Tag Id
     *
     * @return Tags|null Tag entity
     */
    public function findOneById(int $id): ?Tags
    {
        return $this->tagsRepository->findOneById($id);
    }
}
