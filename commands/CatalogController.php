<?php

namespace app\commands;

use app\models\CityModel;
use app\models\StreetModel;
use Yii;
use yii\base\InvalidConfigException;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\Exception;
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
     * @throws Exception
     * @throws InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function actionUpdateStreets($ref = null): int
    {

        $cities = CityModel::find()->all();
        if (empty($cities)) {
            $this->stdout("No cities founded for update streets\n", Console::FG_GREEN);
            return ExitCode::OK;
        }

        foreach ($cities as $city) {

            $response = $this->httpClient->createRequest()
                ->setMethod('GET')
                ->setUrl(Yii::$app->params['updateStreetsURL'])
                ->addHeaders(['secret-token' => Yii::$app->params['secret-token']])
                ->addData(['city_ref' => $city->ref])
                ->send();

            if ($response->isOk) {
                $data = [];
                foreach ($response->getData() as $value) {
                    $data[] = [$value['ref'], $value['name'], $city->ref];
                }
                $db = Yii::$app->db;
                $sql = $db->queryBuilder->batchInsert(StreetModel::tableName(), ['ref', 'name', 'city_ref'], $data);
                $db->createCommand($sql . ' ON DUPLICATE KEY UPDATE name = VALUES(name) , city_ref = VALUES(city_ref)')
                    ->execute();
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
     * @throws Exception
     */
    public function actionUpdateCities(): int
    {
        Yii::$app->params['updateCitiesURL'];

        $response = $this->httpClient->createRequest()
            ->setMethod('GET')
            ->setUrl(Yii::$app->params['updateCitiesURL'])
            ->addHeaders(['secret-token' => Yii::$app->params['secret-token']])
            ->send();

        if ($response->isOk) {
            $data = [];
            foreach ($response->getData() as $value) {
                $data[] = [$value['ref'], $value['name']];
            }

            $db = Yii::$app->db;
            $sql = $db->queryBuilder->batchInsert(CityModel::tableName(), ['ref', 'name'], $data);
            $db->createCommand($sql . ' ON DUPLICATE KEY UPDATE name = VALUES(name)')
                ->execute();

        } else {
            $this->stdout("\nSomething went wrong\n", Console::FG_RED);
            return ExitCode::IOERR;
        }

        $this->stdout("Cities updated successful\n", Console::FG_GREEN);
        return ExitCode::OK;
    }
}
