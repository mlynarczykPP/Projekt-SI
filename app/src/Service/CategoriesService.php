<?php
/**
 * Category service.
 */

namespace App\Service;

use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class CategoryService.
 */
class CategoriesService
{
    /**
     * Category repository.
     *
     * @var CategoriesRepository
     */
    private CategoriesRepository $categoriesRepository;

    /**
     * Paginator.
     *
     * @var PaginatorInterface
     */
    private PaginatorInterface $paginator;

    /**
     * CategoryService constructor.
     *
     * @param CategoriesRepository $categoriesRepository Category repository
     * @param PaginatorInterface $paginator            Paginator
     */
    public function __construct(CategoriesRepository $categoriesRepository, PaginatorInterface $paginator)
    {
        $this->categoriesRepository = $categoriesRepository;
        $this->paginator = $paginator;
    }

    /**
     * Create paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface Paginated list
     */
    public function createPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->categoriesRepository->queryAll(),
            $page,
            CategoriesRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Find category by Id.
     *
     * @param int $id Category Id
     *
     * @return Categories|null Category entity
     */
    public function findOneById(int $id): ?Categories
    {
        return $this->categoriesRepository->findOneById($id);
    }

    /**
     * Save category.
     *
     * @param Categories $categories Category entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Categories $categories): void
    {
        $this->categoriesRepository->save($categories);
    }

    /**
     * Delete category.
     *
     * @param Categories $categories Category entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Categories $categories): void
    {
        $this->categoriesRepository->delete($categories);
    }
}