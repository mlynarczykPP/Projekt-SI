<?php

/**
 * Note service.
 */

namespace App\Service;

use App\Entity\Note;
use App\Repository\NoteRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class NoteService.
 */
class NoteService
{
    /**
     * Note repository.
     *
     * @var NoteRepository
     */
    private $noteRepository;
    /**
     * Paginator.
     *
     * @var PaginatorInterface
     */
    private $paginator;
    /**
     * Category service.
     *
     * @var CategoriesService
     */
    private $categoriesService;
    /**
     * Tag service.
     *
     * @var TagService
     */
    private $tagService;

    /**
     * NoteService constructor.
     *
     * @param NoteRepository     $noteRepository    Note repository
     * @param PaginatorInterface $paginator         Paginator
     * @param CategoriesService  $categoriesService Category service
     * @param TagService         $tagService        Tag service
     */
    public function __construct(NoteRepository $noteRepository, PaginatorInterface $paginator, CategoriesService $categoriesService, TagService $tagService)
    {
        $this->noteRepository = $noteRepository;
        $this->paginator = $paginator;
        $this->categoriesService = $categoriesService;
        $this->tagService = $tagService;
    }

    /**
     * Create paginated list.
     *
     * @param int           $page    Page number
     * @param UserInterface $user    User entity
     * @param array         $filters Filters array
     *
     * @return PaginationInterface Paginated list
     */
    public function createPaginatedList(int $page, UserInterface $user, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate($this->noteRepository->queryByAuthor($user, $filters), $page, NoteRepository::PAGINATOR_ITEMS_PER_PAGE);
    }

    /**
     * Save note.
     *
     * @param Note $note Note entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Note $note): void
    {
        $this->noteRepository->save($note);
    }

    /**
     * Delete note.
     *
     * @param Note $note Note entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Note $note): void
    {
        $this->noteRepository->delete($note);
    }

    /**
     * Prepare filters for the notes list.
     *
     * @param array $filters Raw filters from request
     *
     * @return array Result array of filters
     */
    private function prepareFilters(array $filters): array
    {
        $resultFilters = [];
        if (isset($filters['categories_id']) && is_numeric($filters['categories_id'])) {
            $categories = $this->categoriesService->findOneById($filters['categories_id']);
            if (null !== $categories) {
                $resultFilters['categories'] = $categories;
            }
        }

        if (isset($filters['tags_id']) && is_numeric($filters['tags_id'])) {
            $tags = $this->tagService->findOneById($filters['tags_id']);
            if (null !== $tags) {
                $resultFilters['tags'] = $tags;
            }
        }

        return $resultFilters;
    }
}
