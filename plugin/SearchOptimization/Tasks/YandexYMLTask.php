<?php declare(strict_types=1);

namespace Plugin\SearchOptimization\Tasks;

use App\Domain\AbstractTask;
use App\Domain\Service\Catalog\CategoryService;
use App\Domain\Service\Catalog\ProductService;
use Illuminate\Support\Collection;

include_once PLUGIN_DIR . '/SearchOptimization/helper.php';

class YandexYMLTask extends AbstractTask
{
    public const TITLE = 'Generate Yandex YML';

    public function execute(array $params = []): \App\Domain\Entities\Task
    {
        $default = [
            // nothing
        ];
        $params = array_merge($default, $params);

        return parent::execute($params);
    }

    protected function action(array $args = []): void
    {
        $categoryService = $this->container->get(\App\Domain\Service\Catalog\CategoryService::class);
        $productService = $this->container->get(\App\Domain\Service\Catalog\ProductService::class);

        $template = $this->parameter('SearchOptimizationPlugin_yml_txt', '');
        $data = [
            'shop_title' => $this->parameter('SearchOptimizationPlugin_shop_title', ''),
            'company_title' => $this->parameter('SearchOptimizationPlugin_company_title', ''),
            'site_address' => rtrim($this->parameter('common_homepage', ''), '/'),
            'catalog_address' => '/' . $this->parameter('catalog_address', 'catalog'),
            'email' => $this->parameter('mail_from', ''),
            'shop_id' => $this->parameter('SearchOptimizationPlugin_shop_id', ''),
            'currency' => $this->parameter('SearchOptimizationPlugin_currency', ''),
            'delivery_cost' => $this->parameter('SearchOptimizationPlugin_delivery_cost', ''),
            'delivery_days' => $this->parameter('SearchOptimizationPlugin_delivery_days', ''),
            'categories' => $categoryService->read(['status' => \App\Domain\Types\Catalog\CategoryStatusType::STATUS_WORK]),
            'products' => $productService->read(['status' => \App\Domain\Types\Catalog\ProductStatusType::STATUS_WORK]),
        ];
        $data['categories'] = collect($this->prepareCategory($data['categories']->sortBy('title')));
        $data['products'] = $this->prepareProduct($data['products']);

        $renderer = $this->container->get('view');
        file_put_contents(XML_DIR . '/yml.xml', $renderer->fetchFromString(trim($template) ? $template : DEFAULT_YANDEX_YML, $data));

        $this->container->get(\App\Application\PubSub::class)->publish('task:seo:yml');
        $this->setStatusDone();
    }

    protected $indexCategory = 0;

    protected function prepareCategory(Collection $categories, $parent = \Ramsey\Uuid\Uuid::NIL)
    {
        $result = [];

        foreach ($categories->where('parent', $parent) as $model) {
            /** @var \App\Domain\Entities\Catalog\Category $model */
            $item = $model->toArray();
            $item['parent'] = $categories->firstWhere('uuid', $parent)->buf ?? null;
            $item['description'] = str_replace('&nbsp;', '', strip_tags($model->getDescription()));
            $model->buf = $item['id'] = $item['buf'] = ++$this->indexCategory;

            $result[] = $item;
            $result = array_merge($result, $this->prepareCategory($categories, $model->getUuid()));
        }

        return $result;
    }

    protected $indexProduct = 0;

    protected function prepareProduct(Collection $products)
    {
        $result = [];

        foreach ($products as $model) {
            /** @var \App\Domain\Entities\Catalog\Product $model */
            $item = $model->toArray();
            $item['description'] = str_replace('&nbsp;', '', strip_tags($model->getDescription()));
            $model->buf = $item['id'] = $item['buf'] = ++$this->indexProduct;

            $result[] = $item;
        }

        return $result;
    }
}
