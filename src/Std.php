<?php

namespace payuru\phpPayu4;

class Std
{
    /**
     * Переадресация пользователя
     * @param string $url
     */
    public static function redirect(string $url)
    {
        if(!headers_sent()) {
            header('Location: ' . $url);
        } else {
            echo '
                <script>window.location.replace( \''.$url.'\' )</script>
            ';
        }

        exit();
    }

    /**
     * Удалить null-значения из массива
     * @param array $array
     * @return array
     */
    public static function removeNullValues(array $array) : array
    {
        foreach ($array as $key => $entry) {
            if (is_array($entry)) {
                $array[$key] = self::removeNullValues($entry);
                if ($array[$key] === []) {
                    unset($array[$key]);
                }
            } else {
                if ($entry === null) {
                    unset($array[$key]);
                }
            }
        }

        return $array;
    }

    /**
     * Вывести кнопку оплаты
     * @param array $params
     * @return string
     * @throws PaymentException
     */
    public static function drawPayuButton(array $params): string
    {
        if (!isset($params['url'])) {
            throw new PaymentException('Передайте в метод drawPayuButton параметр url');
        }

        $allowedParams = [
            'url',
            'shadow',
            'currency',
            'sum',
            'order_id',
            'newpage',
        ];

        foreach ($params as $key=>$value) {
            if (!in_array($key, $allowedParams)) {
                throw new PaymentException('Недопустимый параметр кнопки оплаты');
            }
        }

        return '
            <a
                '.( isset($params['order_id']) ? 'data-id="' .htmlspecialchars($params['order_id']). '"' : '' ).'
                '.( isset($params['newpage']) ? 'target="_blank"' : '' ).'
                href="' . $params['url'] . '"
                id="payu_button"
                rel="noindex nofollow"
                title="Оплатить"
                style="
                    max-width: 100px;
                    display: inline-block;
                    justify-content: center;
                    text-align: center;
                    background: white;
                    color: dimgrey;
                    border: 1px solid silver;
                    border-radius: 10px;
                    padding: 10px;
                    margin-bottom: 5px;
                    text-decoration: none;
                "
            >
                <img 
                    src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjg5LjIyIiBoZWlnaHQ9IjE0NC4zMSIgdmVyc2lvbj0iMC4wIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtNDQwLjA2IC0zOTguMDgpIj4KPHBhdGggZD0ibTcwOC4wMSA0MjguMzEtMTcuMjI2LTZlLTNjLTEuODc5IDAtMy40MDIgMS41MjMtMy40MDMgMy40MDJsLTFlLTMgMi40MDNoMS4xOTVjNy43NzggMCAxMC42NzEgMS4yODMgMTAuNjcxIDguMzY4djEwLjA3Mmw4Ljc1NSAzZS0zYzEuODc5IDFlLTMgMy40MDItMS41MjEgMy40MDMtMy40bDZlLTMgLTE3LjQzOWMwLTEuODc5LTEuNTIyLTMuNDAyLTMuNC0zLjQwM20tOTQuMDE0IDI3LjA3NWMtMC43OTUtMC45OTgtMi4yOTgtMS4xMzYtMy44MDUtMS4xMzZoLTEuMTNjLTMuNzU1IDAtNS4yMjggMS4xNTgtNi4wNTkgNC43NjFsLTEwLjQzNCA0My4zN2MtMS4zMDIgNS4zMy0zLjEzMiA2LjMwNC02LjI2MyA2LjMwNC0zLjgzNCAwLTUuMzY5LTAuOTE1LTYuODk3LTYuMzI1bC0xMS44MTgtNDMuMzdjLTAuOTc4LTMuNjMyLTIuNDIxLTQuNzQtNi4xNzctNC43NGgtMS4wMDZjLTEuNTE2IDAtMy4wMjYgMC4xNC0zLjgwMSAxLjE1MS0wLjc3NiAxLjAxMi0wLjUxNCAyLjUyMy0wLjExNCA0LjAwOGwxMS45NDMgNDMuNzQ2YzIuMjQgOC4zNzIgNC45MDMgMTUuMzAyIDE0Ljg1MyAxNS4zMDIgMS44NTcgMCAzLjU3NS0wLjI1OCA1LjAwNC0wLjc0LTMuMDE4IDkuNDkxLTYuMDg4IDEzLjY3Ny0xNS4xNDEgMTQuNjA3LTEuODM3IDAuMTUzLTMuMDMxIDAuNDE2LTMuNjk2IDEuMzA4LTAuNjkxIDAuOTI1LTAuNTM0IDIuMjUtMC4yODcgMy40MzNsMC4yNDkgMS4xMjJjMC41NCAyLjU5NCAxLjQ2MSA0LjIwMiA0LjM3MyA0LjIwMiAwLjMwNiAwIDAuNjM1LTAuMDE2IDAuOTg4LTAuMDQ2IDEzLjUxOC0wLjg4NSAyMC43NjEtOC4xNjMgMjQuOTk5LTI1LjEybDE0LjQ2Mi01Ny44NDVjMC4zNDMtMS40ODQgMC41NS0yLjk5NS0wLjI0My0zLjk5Mm0tNzIuNzQyIDMzLjMyMXY4Ljc1NWMwIDcuMTM3LTIuNjQ2IDExLjI2OS0xNi4xNzIgMTEuMjY5LTguOTM2IDAtMTMuMjgtMy4yMzQtMTMuMjgtOS44ODYgMC03LjI5NSA0LjM1OC0xMC4xMzggMTUuNTQzLTEwLjEzOHptLTE2LjE3Mi0zNi4yOThjLTcuMzc0IDAtMTEuOTk1IDAuOTI1LTEzLjc0OCAxLjI3Ni0zLjEwMyAwLjY3NC00LjQwMSAxLjUyNi00LjQwMSA1LjA1NXYxLjAwNmMwIDEuMzgzIDAuMjA1IDIuMzQxIDAuNjQ0IDMuMDE1IDAuNTExIDAuNzg1IDEuMzM1IDEuMTgzIDIuNDQ5IDEuMTgzIDAuNTQzIDAgMS4xNzMtMC4wOTEgMS45MjQtMC4yNzkgMS43NzMtMC40NDMgNy40MzgtMS4zNTkgMTMuNjM1LTEuMzU5IDExLjEzIDAgMTUuNjY5IDMuMDgzIDE1LjY2OSAxMC42NHY2Ljc0NGgtMTQuMDM1Yy0xOC4wNDIgMC0yNi40NDYgNi4wODYtMjYuNDQ2IDE5LjE1NSAwIDEyLjY3NiA4LjY3OCAxOS42NTcgMjQuNDM1IDE5LjY1NyAxOC43MjUgMCAyNy4wNzUtNi4zNzIgMjcuMDc1LTIwLjY2M3YtMjQuODkzYzAtMTMuODE5LTguODk3LTIwLjUzNy0yNy4yMDEtMjAuNTM3bS0zNS4zNyA4LjM4NGMwIDEwLjQwNy0yLjY1NyAxNi4wNDctMTYuNjc1IDE2LjA0N2gtMjEuNTc4di0yNi44NTljMC0zLjcyNCAxLjM4NS01LjEwOSA1LjEwOS01LjEwOWgxNi40NjljMTAuNTYxIDAgMTYuNjc1IDIuNjA2IDE2LjY3NSAxNS45MjF6bS0xNi42NzUtMjYuNjk4aC0xOC42MDdjLTkuOTQzIDAtMTQuMzc3IDQuNDM0LTE0LjM3NyAxNC4zNzh2NjMuODY1YzAgMy44NDEgMS4yMzMgNS4wNzQgNS4wNzUgNS4wNzRoMS4yNTdjMy44NDEgMCA1LjA3NC0xLjIzMyA1LjA3NC01LjA3NHYtMjQuODQ3aDIxLjU3OGMxOS4xNTggMCAyOC4wODEtOC40ODQgMjguMDgxLTI2LjY5OCAwLTE4LjIxNS04LjkyMy0yNi42OTgtMjguMDgxLTI2LjY5OG0yMzYuNjUtMjMuNzgyLTguNjg5LTNlLTNjLTAuOTQ4LTFlLTMgLTEuNzE2LTAuNzY5LTEuNzE2LTEuNzE3bDNlLTMgLTguNzk3YzFlLTMgLTAuOTQ4IDAuNzctMS43MTUgMS43MTctMS43MTVsOC42ODkgM2UtM2MwLjk0OCAwIDEuNzE2IDAuNzY5IDEuNzE2IDEuNzE2bC0zZS0zIDguNzk3Yy0xZS0zIDAuOTQ4LTAuNzY5IDEuNzE2LTEuNzE3IDEuNzE2bTE3LjA0OCAxOC4wMDktMTIuNzk0LTVlLTNjLTEuMzk1IDAtMi41MjYtMS4xMzItMi41MjUtMi41MjdsNGUtMyAtMTIuOTUyYzFlLTMgLTEuMzk2IDEuMTMzLTIuNTI3IDIuNTI4LTIuNTI3bDEyLjc5MyA1ZS0zYzEuMzk2IDAgMi41MjcgMS4xMzIgMi41MjcgMi41MjdsLTVlLTMgMTIuOTUzYzAgMS4zOTUtMS4xMzIgMi41MjYtMi41MjggMi41MjZtLTM1Ljk2IDI0LjIyNmMtMS44NzkgMC0zLjQwMS0xLjUyMy0zLjQtMy40MDJsNWUtMyAtMTUuMDM2aC0xLjI1NGMtNy43NzggMC0xMC42NzEgMS4yODQtMTAuNjcxIDguMzY5djE2LjU3OWMtMWUtMyAwLjAzNS01ZS0zIDAuMDctNWUtMyAwLjEwNXYzLjYzNGMtMmUtMyAwLjEyNi0wLjAxIDAuMjQzLTAuMDEgMC4zNzN2MjMuMTY1YzAgMi44MjktMC41NDUgNS4wODItMS42NyA2LjgzMi0yLjEyMSAzLjI2OC02LjMyIDQuNzUzLTEzLjAzOCA0Ljc2Mi02LjcxNS05ZS0zIC0xMC45MTMtMS40OTMtMTMuMDM0LTQuNzU4LTEuMTI4LTEuNzUxLTEuNjc0LTQuMDA1LTEuNjc0LTYuODM2di0yMy4xNjVjMC0wLjEzLTdlLTMgLTAuMjQ3LTllLTMgLTAuMzczdi0zLjYzNGMwLTAuMDM1LTRlLTMgLTAuMDctNWUtMyAtMC4xMDV2LTE2LjU3OWMwLTcuMDg1LTIuODkzLTguMzY5LTEwLjY3MS04LjM2OWgtMi40NDljLTcuNzc5IDAtMTAuNjcxIDEuMjg0LTEwLjY3MSA4LjM2OXY0My44NTZjMCA3LjA1NSAxLjU5MSAxMy4wMjggNC42NjUgMTcuODQzIDUuOTM3IDkuMzMgMTcuNDM4IDE0LjI5OSAzMy43ODggMTQuMjk5IDAuMDIgMCAwLjA0LTFlLTMgMC4wNi0xZS0zIDAuMDIxIDAgMC4wNCAxZS0zIDAuMDYxIDFlLTMgMTYuMzUgMCAyNy44NTEtNC45NjkgMzMuNzg4LTE0LjI5OSAzLjA3NC00LjgxNSA0LjY2NS0xMC43ODggNC42NjUtMTcuODQzdi0zMy43ODRsLTguNDcxLTNlLTMiIGZpbGw9IiNBNkMzMDciLz4KPC9nPgo8L3N2Zz4K"
                    alt="PayU"
                    style="display: block; max-width: 100%;"
                />
                Оплатить
                '.(isset($params['sum']) ? '<br><strong>'
                    . number_format((int)$params['sum'], 0, '.', ' ')
                    . ' '
                    . ( isset($params['currency']) ? htmlspecialchars($params['currency']) : '₽' ) .'</strong>' : '').'
            </a>
        ';
    }
}