<?php

namespace frontend\views\urls;

use common\core\entities\Shop\Razdel;
use common\core\readModels\Shop\RazdelReadRepository;
use yii\base\BaseObject;
use yii\base\InvalidParamException;
use yii\caching\Cache;
use yii\caching\TagDependency;
use yii\helpers\ArrayHelper;
use yii\web\UrlNormalizerRedirectException;
use yii\web\UrlRuleInterface;

class RazdelUrlRule extends BaseObject implements UrlRuleInterface
{
    public $prefix = 'uslugi';

    private $repository;
    private $cache;

    public function __construct(RazdelReadRepository $repository, Cache $cache, $config = [])
    {
        parent::__construct($config);
        $this->repository = $repository;
        $this->cache = $cache;
    }

    public function parseRequest($manager, $request)
    {

        if (preg_match('#^' . $this->prefix . '/(.*[a-z])$#is', $request->pathInfo, $matches)) {
            $path = $matches['1'];

            $result = $this->cache->getOrSet(['razdel_route', 'path' => $path], function () use ($path) {
                if (!$razdel = $this->repository->findBySlug($this->getPathSlug($path))) {
                    return ['id' => null, 'path' => null];
                }
                return ['id' => $razdel->id, 'path' => $this->getCategoryPath($razdel)];
            }, null, new TagDependency(['tags' => ['razdels']]));

            if (empty($result['id'])) {
                return false;
            }

            if ($path != $result['path']) {
                throw new UrlNormalizerRedirectException(['razdel/view', 'id' => $result['id']], 301);
            }

            return ['razdel/view', ['id' => $result['id']]];
        }
        return false;
    }

    public function createUrl($manager, $route, $params)
    {
        if ($route == 'razdel/view') {
            if (empty($params['id'])) {
                throw new InvalidParamException('Empty id.');
            }
            $id = $params['id'];

            $url = $this->cache->getOrSet(['razdel_route', 'id' => $id], function () use ($id) {
                if (!$razdel = $this->repository->find($id)) {
                    return null;
                }
                return $this->getCategoryPath($razdel);
            }, null, new TagDependency(['tags' => ['razdels']]));

            if (!$url) {
                throw new InvalidParamException('Undefined id.');
            }

            $url = $this->prefix . '/' . $url;
            unset($params['id']);
            if (!empty($params) && ($query = http_build_query($params)) !== '') {
                $url .= '?' . $query;
            }
            return $url;
        }
        return false;
    }

    private function getPathSlug($path): string
    {
        $chunks = explode('/', $path);
        return end($chunks);
    }

    private function getCategoryPath(Razdel $razdel): string
    {
        $chunks = ArrayHelper::getColumn($razdel->getParents()->andWhere(['>', 'depth', 0])->all(), 'slug');
        $chunks[] = $razdel->slug;
        return implode('/', $chunks);
    }
}