<?php

namespace common\bootstrap;

use common\core\cart\Cart;
use common\core\cart\cost\calculator\DynamicCost;
use common\core\cart\cost\calculator\SimpleCost;
use common\core\cart\storage\HybridStorage;
use common\core\dispatchers\AsyncEventDispatcher;
use common\core\dispatchers\DeferredEventDispatcher;
use common\core\dispatchers\EventDispatcher;
use common\core\dispatchers\SimpleEventDispatcher;
use common\core\entities\Shop\Product\events\ProductAppearedInStock;
use common\core\entities\User\events\UserSignUpConfirmed;
use common\core\entities\User\events\UserSignUpRequested;
use common\core\jobs\AsyncEventJobHandler;
use common\core\listeners\Shop\Category\CategoryPersistenceListener;
use common\core\listeners\Shop\Product\ProductAppearedInStockListener;
use common\core\listeners\Shop\Product\ProductSearchPersistListener;
use common\core\listeners\Shop\Product\ProductSearchRemoveListener;
use common\core\listeners\User\UserSignupConfirmedListener;
use common\core\listeners\User\UserSignupRequestedListener;
use common\core\repositories\events\EntityPersisted;
use common\core\repositories\events\EntityRemoved;
use common\core\services\newsletter\MailChimp;
use common\core\services\newsletter\Newsletter;
use common\core\services\sms\LoggedSender;
use common\core\services\sms\SmsRu;
use common\core\services\sms\SmsSender;
use common\core\services\yandex\ShopInfo;
use common\core\services\yandex\YandexMarket;
use common\core\useCases\ContactService;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Yii;
use yii\base\BootstrapInterface;
use yii\base\ErrorHandler;
use yii\caching\Cache;
use yii\di\Container;
use yii\di\Instance;
use yii\mail\MailerInterface;
use yii\rbac\ManagerInterface;
use zhuravljov\yii\queue\Queue;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $container = Yii::$container;


    }
}