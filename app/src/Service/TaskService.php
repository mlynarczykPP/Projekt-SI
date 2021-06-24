<?php

/**
 * Task service.
 */

namespace App\Service;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class TaskService.
 */
class TaskService
{
    /**
     * Task repository.
     */
    private $taskRepository;
    /**
     * Paginator.
     */
    private $paginator;

    /**
     * TaskService constructor.
     *
     * @param TaskRepository     $taskRepository    Task repository
     * @param PaginatorInterface $paginator         Paginator
     * @param CategoriesService  $categoriesService Category service
     * @param TagService         $tagService        Tag service
     */
    public function __construct(TaskRepository $taskRepository, PaginatorInterface $paginator, CategoriesService $categoriesService, TagService $tagService)
    {
        $this->taskRepository = $taskRepository;
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

        return $this->paginator->paginate($this->taskRepository->queryByAuthor($user, $filters), $page, TaskRepository::PAGINATOR_ITEMS_PER_PAGE);
    }

    /**
     * Save task.
     *
     * @param Task $task Task entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Task $task): void
    {
        $this->taskRepository->save($task);
    }

    /**
     * Delete task.
     *
     * @param Task $task Task entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Task $task): void
    {
        $this->taskRepository->delete($task);
    }

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
     * Prepare filters for the tasks list.
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
