<?php

namespace App\Application;

use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Ramsey\Uuid\Uuid;
use Slim\Http\Uri;

class TwigExtension extends \Twig\Extension\AbstractExtension
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var \Slim\Interfaces\RouterInterface
     */
    protected $router;

    /**
     * @var string|\Slim\Http\Uri
     */
    protected $uri;

    public function __construct(ContainerInterface $container, $uri)
    {
        $this->container = $container;
        $this->entityManager = $container->get(\Doctrine\ORM\EntityManager::class);
        $this->router = $container->get('router');
        $this->uri = $uri;
    }

    public function getName()
    {
        return '0x12f';
    }

    public function getFilters()
    {
        return [
            new \Twig\TwigFilter('count', [$this, 'count']),
            new \Twig\TwigFilter('df', [$this, 'df']),
        ];
    }

    public function getFunctions()
    {
        return [
            // slim functions
            new \Twig\TwigFunction('path_for', [$this, 'pathFor']),
            new \Twig\TwigFunction('full_url_for', [$this, 'fullUrlFor']),
            new \Twig\TwigFunction('base_url', [$this, 'baseUrl']),
            new \Twig\TwigFunction('is_current_path', [$this, 'isCurrentPath']),
            new \Twig\TwigFunction('current_path', [$this, 'currentPath']),

            // 0x12f functions
            new \Twig\TwigFunction('form', [$this, 'form'], ['is_safe' => ['html']]),
            new \Twig\TwigFunction('reference', [$this, 'reference']),
            new \Twig\TwigFunction('parameter', [$this, 'parameter']),
            new \Twig\TwigFunction('pre', [$this, 'pre']),
            new \Twig\TwigFunction('count', [$this, 'count']),
            new \Twig\TwigFunction('df', [$this, 'df']),
            new \Twig\TwigFunction('collect', [$this, 'collect']),
            new \Twig\TwigFunction('non_page_path', [$this, 'non_page_path']),
            new \Twig\TwigFunction('current_page_number', [$this, 'current_page_number']),
            new \Twig\TwigFunction('is_current_page_number', [$this, 'is_current_page_number']),
            new \Twig\TwigFunction('pushstream_channel', [$this, 'pushstream_channel']),

            // publication functions
            new \Twig\TwigFunction('files', [$this, 'files']),

            // publication functions
            new \Twig\TwigFunction('publication', [$this, 'publication']),
            new \Twig\TwigFunction('publication_category', [$this, 'publication_category']),

            // guestbook functions
            new \Twig\TwigFunction('guestbook', [$this, 'guestbook']),

            // catalog functions
            new \Twig\TwigFunction('catalog_category', [$this, 'catalog_category']),
            new \Twig\TwigFunction('catalog_breadcrumb', [$this, 'catalog_breadcrumb']),
            new \Twig\TwigFunction('catalog_product', [$this, 'catalog_product']),
            new \Twig\TwigFunction('catalog_product_view', [$this, 'catalog_product_view']),
            new \Twig\TwigFunction('catalog_order', [$this, 'catalog_order']),

            // trademaster
            new \Twig\TwigFunction('tm_api', [$this, 'tm_api']),

            // other
            new \Twig\TwigFunction('task', [$this, 'task']),
            new \Twig\TwigFunction('notification', [$this, 'notification']),
        ];
    }

    /*
     * slim functions
     */

    public function pathFor($name, $data = [], $queryParams = [])
    {
        return $this->router->pathFor($name, $data, $queryParams);
    }

    /**
     * Similar to pathFor but returns a fully qualified URL
     *
     * @param string $name The name of the route
     * @param array  $data Route placeholders
     * @param array  $queryParams
     *
     * @return string fully qualified URL
     */
    public function fullUrlFor($name, $data = [], $queryParams = [])
    {
        $path = $this->pathFor($name, $data, $queryParams);

        /** @var Uri $uri */
        if (is_string($this->uri)) {
            $uri = Uri::createFromString($this->uri);
        } else {
            $uri = $this->uri;
        }

        $scheme = $uri->getScheme();
        $authority = $uri->getAuthority();

        $host = ($scheme ? $scheme . ':' : '')
            . ($authority ? '//' . $authority : '');

        return $host . $path;
    }

    public function baseUrl()
    {
        if (is_string($this->uri)) {
            return $this->uri;
        }
        if (method_exists($this->uri, 'getBaseUrl')) {
            return $this->uri->getBaseUrl();
        }
    }

    public function isCurrentPath($name, $data = [])
    {
        return $this->router->pathFor($name, $data) === $this->uri->getBasePath() . '/' . ltrim($this->uri->getPath(), '/');
    }

    /**
     * Returns current path on given URI.
     *
     * @param bool $withQueryString
     *
     * @return string
     */
    public function currentPath($withQueryString = false)
    {
        if (is_string($this->uri)) {
            return $this->uri;
        }

        $path = $this->uri->getBasePath() . '/' . ltrim($this->uri->getPath(), '/');

        if ($withQueryString && '' !== $query = $this->uri->getQuery()) {
            $path .= '?' . $query;
        }

        return $path;
    }

    /**
     * Set the base url
     *
     * @param string|\Slim\Http\Uri $baseUrl
     *
     * @return void
     */
    public function setBaseUrl($baseUrl)
    {
        $this->uri = $baseUrl;
    }

    /*
     * 0x12f functions
     */

    public function form($type, $name, $args = [])
    {
        return form($type, $name, $args);
    }

    // todo посмотреть на это решение еще
    public function reference($reference, $value = null)
    {
        try {
            $reference = constant(str_replace('/', '\\', $reference));

            switch ($value) {
                case null:
                    return $reference;
                    break;

                default:
                    return $reference[$value];
            }

        } catch (\Exception $e) {
            /* todo nothing */
        }

        return $value;
    }

    // возвращает значение параметра
    public function parameter($key = null, $default = null)
    {
        return $this->container->get('parameter')->get($key, $default);
    }

    /**
     * Debug function
     * @param mixed ...$args
     */
    public function pre(...$args)
    {
        call_user_func_array('pre', $args);
    }

    public function count($obj)
    {
        return is_countable($obj) ? count($obj) : false;
    }

    /**
     * Date format function
     * @param \DateTime|string $obj
     * @param string $default
     * @return string
     */
    public function df($obj = 'now', $default = 'j-m-Y, H:i')
    {
        $format = $this->parameter('common_date_format', $default);

        if (is_string($obj) || is_numeric($obj)) {
            return date($format, strtotime($obj));
        }

        return $obj->format($format);
    }

    public function collect(array $array = [])
    {
        return collect($array);
    }

    public function non_page_path()
    {
        $path = $this->uri->getBasePath() . '/' . ltrim($this->uri->getPath(), '/');
        $path = explode('/', $path);

        if (($key = count($path) - 1) && ($buf = $path[$key]) && ctype_digit($buf)) {
            unset($path[$key]);
        }

        return implode('/', $path);
    }

    public function current_page_number()
    {
        $page = 0;
        $path = explode('/', ltrim($this->uri->getPath(), '/'));

        if (($key = count($path) - 1) && ($buf = $path[$key]) && ctype_digit($buf)) {
            $page = $path[$key];
        }

        return $page;
    }

    public function is_current_page_number($number)
    {
        return $this->current_page_number() == $number;
    }

    public function pushstream_channel($user_uuid)
    {
        return $this->container->get('pushstream')->getChannel($user_uuid);
    }

    /*
     * files functions
     */

    // получает файлы по параметрам
    public function files($data = [])
    {
        \RunTracy\Helpers\Profiler\Profiler::start('twig:fn:files', $data);

        $default = [
            'uuid' => '',
            'item' => '',
            'item_uuid' => '',
        ];
        $data = array_merge($default, $data);
        $criteria = [];

        if ($data['uuid']) {
            if (!is_a($data['item_uuid'], \Alksily\Entity\Collection::class) && !is_array($data['uuid'])) $data['uuid'] = [$data['uuid']];

            foreach ($data['uuid'] as $value) {
                if (\Ramsey\Uuid\Uuid::isValid($value) === true) {
                    $criteria['uuid'][] = $value;
                }
            }
        }

        if ($data['item']) {
            $criteria['item'] = $data['item'];
        }

        if ($data['item_uuid']) {
            if (!is_a($data['item_uuid'], Collection::class) && !is_array($data['item_uuid'])) $data['item_uuid'] = [$data['item_uuid']];

            foreach ($data['item_uuid'] as $value) {
                if (\Ramsey\Uuid\Uuid::isValid($value) === true) {
                    $criteria['item_uuid'][] = $value;
                }
            }
        }

        /** @var \Doctrine\Common\Persistence\ObjectRepository|\Doctrine\ORM\EntityRepository $repository */
        $repository = $this->entityManager->getRepository(\App\Domain\Entities\File::class);
        $result = collect($repository->findBy($criteria));

        \RunTracy\Helpers\Profiler\Profiler::finish('twig:fn:files', $data);

        return $result;
    }

    /*
     * publication functions
     */

    // получение списка категорий публикаций
    public function publication_category($limit = null)
    {
        \RunTracy\Helpers\Profiler\Profiler::start('twig:fn:publication_category');

        static $buf;

        if (!$buf) {
            /** @var \Doctrine\Common\Persistence\ObjectRepository|\Doctrine\ORM\EntityRepository $repository */
            $repository = $this->entityManager->getRepository(\App\Domain\Entities\Publication\Category::class);

            $buf = collect($repository->findAll());
        }

        \RunTracy\Helpers\Profiler\Profiler::finish('twig:fn:publication_category');

        return $buf;
    }

    // получение списка публикаций
    public function publication($category = null, $order = [], $limit = 10, $offset = null)
    {
        \RunTracy\Helpers\Profiler\Profiler::start('twig:fn:publication');

        static $buf;

        $criteria = [];

        if ($category) {
            switch (true) {
                case \Ramsey\Uuid\Uuid::isValid($category) === true:
                    $criteria['uuid'] = $category;
                    break;

                default:
                    $criteria['address'] = $category;
                    break;
            }
        }

        $key = json_encode($criteria, JSON_UNESCAPED_UNICODE).$limit.$offset;

        if (!isset($buf[$key])) {
            /** @var \Doctrine\Common\Persistence\ObjectRepository|\Doctrine\ORM\EntityRepository $repository */
            $repository = $this->entityManager->getRepository(\App\Domain\Entities\Publication::class);

            $buf[$key] = $limit > 1 ? collect($repository->findBy($criteria, $order, $limit, $offset)) : $repository->findOneBy($criteria, $order);
        }

        \RunTracy\Helpers\Profiler\Profiler::finish('twig:fn:publication');

        return $buf[$key];
    }

    /*
     * guestbook functions
     */

    // получение списка записей в гостевой книге
    public function guestbook($order = [], $limit = 10, $offset = null)
    {
        \RunTracy\Helpers\Profiler\Profiler::start('twig:fn:guestbook');

        static $buf;

        $key = json_encode($order, JSON_UNESCAPED_UNICODE).$limit.$offset;

        if (!$buf) {
            /** @var \Doctrine\Common\Persistence\ObjectRepository|\Doctrine\ORM\EntityRepository $repository */
            $repository = $this->entityManager->getRepository(\App\Domain\Entities\GuestBook::class);

            // get list of comments and obfuscate email address
            $buf[$key] = collect(
                $limit > 1
                    ? $repository->findBy(['status' => \App\Domain\Types\GuestBookStatusType::STATUS_WORK], $order, $limit, $offset)
                    : $repository->findOneBy([], $order)
            )->map(
                function ($el) {
                    if ($el->email) {
                        $em = explode('@', $el->email);
                        $name = implode(array_slice($em, 0, count($em) - 1), '@');
                        $len = floor(strlen($name) / 2);

                        $el->email = substr($name, 0, $len) . str_repeat('*', $len) . '@' . end($em);
                    }

                    return $el;
                }
            );
        }

        \RunTracy\Helpers\Profiler\Profiler::finish('twig:fn:guestbook');

        return $buf[$key];
    }

    /*
     * catalog functions
     */

    // получение списка категорий товаров
    public function catalog_category()
    {
        \RunTracy\Helpers\Profiler\Profiler::start('twig:fn:catalog_category');

        static $buf;

        if (!$buf) {
            /** @var \Doctrine\Common\Persistence\ObjectRepository|\Doctrine\ORM\EntityRepository $repository */
            $repository = $this->entityManager->getRepository(\App\Domain\Entities\Catalog\Category::class);

            $buf = collect($repository->findAll());
        }

        \RunTracy\Helpers\Profiler\Profiler::finish('twig:fn:catalog_category');

        return $buf;
    }

    // вернет список родительских категорий
    public function catalog_breadcrumb(\App\Domain\Entities\Catalog\Category $category = null)
    {
        \RunTracy\Helpers\Profiler\Profiler::start('twig:fn:catalog_breadcrumb');

        $categories = $this->catalog_category();
        $breadcrumb = [];

        if (!is_null($category)) {
            $breadcrumb[] = $category;

            while($category->parent->toString() != Uuid::NIL) {
                /**
                 * @var \App\Domain\Entities\Catalog\Category $category;
                 */
                $category = $categories->firstWhere('uuid', $category->parent);
                $breadcrumb[] = $category;
            }
        }

        $result = collect($breadcrumb)->reverse();

        \RunTracy\Helpers\Profiler\Profiler::start('twig:fn:catalog_breadcrumb');

        return $result;
    }

    // получение списка товаров
    public function catalog_product($category = null, $order = [], $limit = 10, $offset = null)
    {
        \RunTracy\Helpers\Profiler\Profiler::start('twig:fn:catalog_product');

        static $buf;

        $criteria = [
            'status' => \App\Domain\Types\Catalog\ProductStatusType::STATUS_WORK,
        ];

        if ($category) {
            if (!is_array($category)) $category = [$category];

            foreach ($category as $value) {
                switch (true) {
                    case \Ramsey\Uuid\Uuid::isValid($value) === true:
                        $criteria['category'][] = $value;
                        break;

                    default:
                        $criteria['address'][] = $value;
                        break;
                }
            }
        }

        $key = json_encode($criteria, JSON_UNESCAPED_UNICODE).$limit.$offset;

        if (!isset($buf[$key])) {
            /** @var \Doctrine\Common\Persistence\ObjectRepository|\Doctrine\ORM\EntityRepository $repository */
            $repository = $this->entityManager->getRepository(\App\Domain\Entities\Catalog\Product::class);

            $buf[$key] = $limit > 1 ? collect($repository->findBy($criteria, $order, $limit, $offset)) : $repository->findOneBy($criteria, $order);
        }

        \RunTracy\Helpers\Profiler\Profiler::finish('twig:fn:catalog_product');

        return $buf[$key];
    }

    // сохраняет переданный в аргумент uuid товара, если null возвращает список товаров
    public function catalog_product_view(\Ramsey\Uuid\UuidInterface $uuid = null, $limit = 10)
    {
        $list = $_SESSION['catalog_product_view'] ?? [];

        switch (true) {
            case is_null($uuid) === true:
                return $list;

            case Uuid::isValid($uuid) === true:
                $list[] = $uuid->toString();
                $list = array_unique($list);

                // shift first element
                if (count($list) > $limit) {
                    $list = array_slice($list, 0 - $limit, $limit);
                }

                $_SESSION['catalog_product_view'] = $list;
        }
    }

    // получение заказа
    public function catalog_order($unique)
    {
        \RunTracy\Helpers\Profiler\Profiler::start('twig:fn:catalog_order');

        static $buf;

        $criteria = [];

        switch (true) {
            case \Ramsey\Uuid\Uuid::isValid($unique) === true:
                $criteria['uuid'] = $unique;
                break;

            default:
                $criteria['serial'] = $unique;
                break;
        }

        $key = json_encode($criteria, JSON_UNESCAPED_UNICODE);

        if (!isset($buf[$key])) {
            /** @var \Doctrine\Common\Persistence\ObjectRepository|\Doctrine\ORM\EntityRepository $repository */
            $repository = $this->entityManager->getRepository(\App\Domain\Entities\Catalog\Order::class);

            $buf[$key] = collect($repository->findOneBy($criteria));
        }

        \RunTracy\Helpers\Profiler\Profiler::finish('twig:fn:catalog_order');

        return $buf[$key];
    }

    /*
     * trademaster functions
     */

    // tm api
    public function tm_api($endpoint, array $params = [], $method = 'GET')
    {
        \RunTracy\Helpers\Profiler\Profiler::start('twig:fn:tm_api');

        /** @var \App\Application\TradeMaster $trademaster */
        $trademaster = $this->container->get('trademaster');
        $result = $trademaster->api([
            'endpoint' => $endpoint,
            'params' => $params,
            'method' => $method,
        ]);

        \RunTracy\Helpers\Profiler\Profiler::finish('twig:fn:tm_api');

        return $result;
    }

    /*
     * other functions
     */

    public function task($limit = 30)
    {
        \RunTracy\Helpers\Profiler\Profiler::start('twig:fn:task');

        /** @var \App\Application\TradeMaster $trademaster */

        $qb = $this->entityManager->createQueryBuilder();
        $query = $qb->select('t')
            ->from(\App\Domain\Entities\Task::class, 't')
            ->orderBy('t.date', 'DESC')
            ->setMaxResults($limit);

        $result = collect($query->getQuery()->getResult());
        $result->map(function ($obj) {
            $obj->action = str_replace('App\Domain\Tasks\\', '', $obj->action);
        });

        \RunTracy\Helpers\Profiler\Profiler::finish('twig:fn:task');

        return $result;
    }

    public function notification($user = null, $limit = 30)
    {
        \RunTracy\Helpers\Profiler\Profiler::start('twig:fn:notification');

        $qb = $this->entityManager->createQueryBuilder();
        $query = $qb->select('n')
            ->from(\App\Domain\Entities\Notification::class, 'n')
            ->where('n.user_uuid IS NULL' . ($user ? ' OR n.user_uuid = :uuid' : ''))
            ->andWhere('n.date > :period')
            ->orderBy('n.date', 'DESC')
            ->setMaxResults($limit)
            ->setParameter('uuid', $user)
            ->setParameter('period',
                date(
                    \App\Domain\References\Date::DATETIME,
                    time() - ($this->parameter('notification_period', \App\Domain\References\Date::HOUR) * 24)
                )
            );

        $result = collect($query->getQuery()->getResult());

        \RunTracy\Helpers\Profiler\Profiler::finish('twig:fn:notification');

        return $result;
    }
}
