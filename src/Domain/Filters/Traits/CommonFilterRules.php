<?php declare(strict_types=1);

namespace App\Domain\Filters\Traits;

use Alksily\Support\Str;
use Ramsey\Uuid\Uuid;
use Slim\App;

trait CommonFilterRules
{
    private static $salt = 'Ld8.2Ej5-$Cic5[dS';

    /**
     * Задает полю значение UUID
     *
     * @return \Closure
     */
    public function LeadUUID()
    {
        return function (&$data, $field) {
            $value = &$data[$field];
            $value = \Ramsey\Uuid\Uuid::uuid5(Uuid::NAMESPACE_OID, static::$salt . microtime(true));

            return true;
        };
    }

    /**
     * Проверяет значение поля UUID
     *
     * @param bool $orNULL или значение Null
     *
     * @return \Closure
     */
    public function CheckUUID($orNULL = true)
    {
        return function (&$data, $field) use ($orNULL) {
            $value = &$data[$field];

            if (Uuid::isValid((string) $value) === false && $orNULL) {
                $value = Uuid::NIL;
            }

            return true;
        };
    }

    /**
     * Хеширует пароль
     *
     * @return \Closure
     */
    public function ValidPassword()
    {
        return function (&$data, $field) {
            $value = &$data[$field];

            /** @var App $app */
            $app = $GLOBALS['app'];

            $secret = $app->getContainer()->get('secret');
            $value = crypta_hash($value, $secret['salt']);

            return true;
        };
    }

    /**
     * Делит строку по правилу
     *
     * @param string $delimiter
     * @param null   $limit
     *
     * @return \Closure
     */
    public function StrSplit($delimiter = '/[\r\n]/', $limit = null)
    {
        return function (&$data, $field) use ($delimiter, $limit) {
            $value = &$data[$field];
            $value = preg_replace($delimiter, '|x|', trim($value));
            $value = explode('|x|', $value);

            return true;
        };
    }

    /**
     * Генерирует адрес
     *
     * @return \Closure
     */
    public function ValidAddress()
    {
        return function (&$data, $field) {
            $value = &$data[$field];

            if (!$value) {
                switch (true) {
                    case !empty($data['title']):
                        $value = mb_strtolower($data['title']);
                        $value = Str::translate($value);
                        $value = preg_replace('/[^a-z0-9\s]/', '', $value);
                        $value = preg_replace('/\s/', '-', trim($value));

                        break;

                    default:
                        $value = Uuid::uuid4();

                        break;
                }
            }

            return true;
        };
    }

    /**
     * Проверяет поле meta для сущностей
     *
     * @return \Closure
     */
    public function ValidMeta()
    {
        return function (&$data, $field) {
            $buf = [
                'title' => '',
                'description' => '',
                'keywords' => '',
            ];
            $value = &$data[$field];

            if (!is_array($value)) {
                $value = $buf;

                return true;
            }

            if (isset($value['title'])) {
                $buf['title'] = $value['title'];
            }
            if (isset($value['description'])) {
                $buf['description'] = $value['description'];
            }
            if (isset($value['keywords'])) {
                $buf['keywords'] = $value['keywords'];
            }

            $value = $buf;

            return true;
        };
    }

    /**
     * Устанавливает текущую дату
     *
     * @return \Closure
     */
    public function ValidDate(bool $force = false)
    {
        return function (&$data, $field) use ($force) {
            $value = &$data[$field];

            switch (true) {
                case $value && is_string($value):
                    $value = new \DateTime($value);

                    break;

                case $force === true:
                default:
                    $value = new \DateTime('now');

                    break;
            }

            return true;
        };
    }
}
