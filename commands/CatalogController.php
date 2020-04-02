<?php

namespace app\commands;

use app\collections\CityCollection;
use app\collections\StreetCollection;
use app\models\CityModel;
use app\models\StreetModel;
use app\repositories\city\CityRepository;
use app\repositories\street\StreetRepository;
use Yii;
use yii\base\InvalidConfigException;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;
use yii\httpclient\Client;

/**
 * This command update catalogs in DB from API.
 *
 * @author Ganzyuk Vladislav <ganzyukv@gmail.com>
 * @since 0.0.1
 */
class CatalogController extends Controller
{

    public $defaultAction = 'update-cities';

    /**
     * @var Client
     */
    private $httpClient;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->httpClient = new Client([
            'responseConfig' => [
                'format' => Client::FORMAT_JSON,
            ],
        ]);
    }

    /**
     * This command update streets in city
     * @param string $ref the city_ref for update street.
     * @return int Exit code
     * @throws InvalidConfigException
     */
    public function actionUpdateStreets($ref = null): int
    {
        $cityRepository = new CityRepository();
        $cities = $cityRepository->findAll();
        if (empty($cities)) {
            $this->stdout("No cities founded for update streets\n", Console::FG_GREEN);
            return ExitCode::OK;
        }

        foreach ($cities as $city) {
            /**
             * @var $response yii\httpclient\Response
             */
            $response = $this->httpClient->createRequest()
                ->setMethod('GET')
                ->setUrl(Yii::$app->params['updateStreetsURL'])
                ->addHeaders(['secret-token' => Yii::$app->params['secret-token']])
                ->addData(['city_ref' => $city->ref])
                ->send();

            $streetRepository = new StreetRepository();
            if ($response->isOk) {
                $streets = $response->getData();
                if(empty($streets)) {
                    continue;
                }

                $cutedArr = array_chunk($streets, 100);
                foreach ($cutedArr as $portion) {
                    $data = [];
                    foreach ($portion as $value) {
                        $attributes = ArrayHelper::merge($value, ['city_ref' => $city->ref]);
                        $data[] = new StreetModel($attributes);
                    }

                    $collection = new StreetCollection(...$data);
                    $streetRepository->upsertMany($collection);
                }

                $message = "\nCity - {$city->name} ({$city->ref}) - completed";
                $this->stdout($message, Console::FG_YELLOW);
            } else {
                $this->stdout("\nSomething went wrong\n", Console::FG_RED);
                return ExitCode::IOERR;
            }
        }
        $this->stdout("\nCities updated successful\n", Console::FG_GREEN);
        return ExitCode::OK;
    }

    /**
     * This command update all cities
     * @return int Exit code
     * @throws InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function actionUpdateCities(): int
    {
        $cityRepository = new CityRepository();
        $response = $this->httpClient->createRequest()
            ->setMethod('GET')
            ->setUrl(Yii::$app->params['updateCitiesURL'])
            ->addHeaders(['secret-token' => Yii::$app->params['secret-token']])
            ->send();

        if ($response->isOk) {
            $data = [];
            foreach ($response->getData() as $value) {
                $data[] = new CityModel($value);
            }

            $collection = new CityCollection(...$data);
            $cityRepository->upsertMany($collection);

        } else {
            $this->stdout("\nSomething went wrong\n", Console::FG_RED);
            return ExitCode::IOERR;
        }

        $this->stdout("Cities updated successful\n", Console::FG_GREEN);
        return ExitCode::OK;
    }
}
