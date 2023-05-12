<?php

namespace Ypmn;

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
     * @param array $params
     * @return string
     */
    public static function alert(array $params)
    {
        return '        
            <div class="alert alert-' . ($params['type'] ?? 'info') . '" role="alert">
              ' .  $params['text'] . '
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        ';
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
    public static function drawYpmnButton(array $params): string
    {
        if (!isset($params['url'])) {
            throw new PaymentException('Передайте в метод drawYpmnButton параметр url');
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
                id="ypmn_button"
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
                /*<img 
                    src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjg5LjIyIiBoZWlnaHQ9IjE0NC4zMSIgdmVyc2lvbj0iMC4wIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtNDQwLjA2IC0zOTguMDgpIj4KPHBhdGggZD0ibTcwOC4wMSA0MjguMzEtMTcuMjI2LTZlLTNjLTEuODc5IDAtMy40MDIgMS41MjMtMy40MDMgMy40MDJsLTFlLTMgMi40MDNoMS4xOTVjNy43NzggMCAxMC42NzEgMS4yODMgMTAuNjcxIDguMzY4djEwLjA3Mmw4Ljc1NSAzZS0zYzEuODc5IDFlLTMgMy40MDItMS41MjEgMy40MDMtMy40bDZlLTMgLTE3LjQzOWMwLTEuODc5LTEuNTIyLTMuNDAyLTMuNC0zLjQwM20tOTQuMDE0IDI3LjA3NWMtMC43OTUtMC45OTgtMi4yOTgtMS4xMzYtMy44MDUtMS4xMzZoLTEuMTNjLTMuNzU1IDAtNS4yMjggMS4xNTgtNi4wNTkgNC43NjFsLTEwLjQzNCA0My4zN2MtMS4zMDIgNS4zMy0zLjEzMiA2LjMwNC02LjI2MyA2LjMwNC0zLjgzNCAwLTUuMzY5LTAuOTE1LTYuODk3LTYuMzI1bC0xMS44MTgtNDMuMzdjLTAuOTc4LTMuNjMyLTIuNDIxLTQuNzQtNi4xNzctNC43NGgtMS4wMDZjLTEuNTE2IDAtMy4wMjYgMC4xNC0zLjgwMSAxLjE1MS0wLjc3NiAxLjAxMi0wLjUxNCAyLjUyMy0wLjExNCA0LjAwOGwxMS45NDMgNDMuNzQ2YzIuMjQgOC4zNzIgNC45MDMgMTUuMzAyIDE0Ljg1MyAxNS4zMDIgMS44NTcgMCAzLjU3NS0wLjI1OCA1LjAwNC0wLjc0LTMuMDE4IDkuNDkxLTYuMDg4IDEzLjY3Ny0xNS4xNDEgMTQuNjA3LTEuODM3IDAuMTUzLTMuMDMxIDAuNDE2LTMuNjk2IDEuMzA4LTAuNjkxIDAuOTI1LTAuNTM0IDIuMjUtMC4yODcgMy40MzNsMC4yNDkgMS4xMjJjMC41NCAyLjU5NCAxLjQ2MSA0LjIwMiA0LjM3MyA0LjIwMiAwLjMwNiAwIDAuNjM1LTAuMDE2IDAuOTg4LTAuMDQ2IDEzLjUxOC0wLjg4NSAyMC43NjEtOC4xNjMgMjQuOTk5LTI1LjEybDE0LjQ2Mi01Ny44NDVjMC4zNDMtMS40ODQgMC41NS0yLjk5NS0wLjI0My0zLjk5Mm0tNzIuNzQyIDMzLjMyMXY4Ljc1NWMwIDcuMTM3LTIuNjQ2IDExLjI2OS0xNi4xNzIgMTEuMjY5LTguOTM2IDAtMTMuMjgtMy4yMzQtMTMuMjgtOS44ODYgMC03LjI5NSA0LjM1OC0xMC4xMzggMTUuNTQzLTEwLjEzOHptLTE2LjE3Mi0zNi4yOThjLTcuMzc0IDAtMTEuOTk1IDAuOTI1LTEzLjc0OCAxLjI3Ni0zLjEwMyAwLjY3NC00LjQwMSAxLjUyNi00LjQwMSA1LjA1NXYxLjAwNmMwIDEuMzgzIDAuMjA1IDIuMzQxIDAuNjQ0IDMuMDE1IDAuNTExIDAuNzg1IDEuMzM1IDEuMTgzIDIuNDQ5IDEuMTgzIDAuNTQzIDAgMS4xNzMtMC4wOTEgMS45MjQtMC4yNzkgMS43NzMtMC40NDMgNy40MzgtMS4zNTkgMTMuNjM1LTEuMzU5IDExLjEzIDAgMTUuNjY5IDMuMDgzIDE1LjY2OSAxMC42NHY2Ljc0NGgtMTQuMDM1Yy0xOC4wNDIgMC0yNi40NDYgNi4wODYtMjYuNDQ2IDE5LjE1NSAwIDEyLjY3NiA4LjY3OCAxOS42NTcgMjQuNDM1IDE5LjY1NyAxOC43MjUgMCAyNy4wNzUtNi4zNzIgMjcuMDc1LTIwLjY2M3YtMjQuODkzYzAtMTMuODE5LTguODk3LTIwLjUzNy0yNy4yMDEtMjAuNTM3bS0zNS4zNyA4LjM4NGMwIDEwLjQwNy0yLjY1NyAxNi4wNDctMTYuNjc1IDE2LjA0N2gtMjEuNTc4di0yNi44NTljMC0zLjcyNCAxLjM4NS01LjEwOSA1LjEwOS01LjEwOWgxNi40NjljMTAuNTYxIDAgMTYuNjc1IDIuNjA2IDE2LjY3NSAxNS45MjF6bS0xNi42NzUtMjYuNjk4aC0xOC42MDdjLTkuOTQzIDAtMTQuMzc3IDQuNDM0LTE0LjM3NyAxNC4zNzh2NjMuODY1YzAgMy44NDEgMS4yMzMgNS4wNzQgNS4wNzUgNS4wNzRoMS4yNTdjMy44NDEgMCA1LjA3NC0xLjIzMyA1LjA3NC01LjA3NHYtMjQuODQ3aDIxLjU3OGMxOS4xNTggMCAyOC4wODEtOC40ODQgMjguMDgxLTI2LjY5OCAwLTE4LjIxNS04LjkyMy0yNi42OTgtMjguMDgxLTI2LjY5OG0yMzYuNjUtMjMuNzgyLTguNjg5LTNlLTNjLTAuOTQ4LTFlLTMgLTEuNzE2LTAuNzY5LTEuNzE2LTEuNzE3bDNlLTMgLTguNzk3YzFlLTMgLTAuOTQ4IDAuNzctMS43MTUgMS43MTctMS43MTVsOC42ODkgM2UtM2MwLjk0OCAwIDEuNzE2IDAuNzY5IDEuNzE2IDEuNzE2bC0zZS0zIDguNzk3Yy0xZS0zIDAuOTQ4LTAuNzY5IDEuNzE2LTEuNzE3IDEuNzE2bTE3LjA0OCAxOC4wMDktMTIuNzk0LTVlLTNjLTEuMzk1IDAtMi41MjYtMS4xMzItMi41MjUtMi41MjdsNGUtMyAtMTIuOTUyYzFlLTMgLTEuMzk2IDEuMTMzLTIuNTI3IDIuNTI4LTIuNTI3bDEyLjc5MyA1ZS0zYzEuMzk2IDAgMi41MjcgMS4xMzIgMi41MjcgMi41MjdsLTVlLTMgMTIuOTUzYzAgMS4zOTUtMS4xMzIgMi41MjYtMi41MjggMi41MjZtLTM1Ljk2IDI0LjIyNmMtMS44NzkgMC0zLjQwMS0xLjUyMy0zLjQtMy40MDJsNWUtMyAtMTUuMDM2aC0xLjI1NGMtNy43NzggMC0xMC42NzEgMS4yODQtMTAuNjcxIDguMzY5djE2LjU3OWMtMWUtMyAwLjAzNS01ZS0zIDAuMDctNWUtMyAwLjEwNXYzLjYzNGMtMmUtMyAwLjEyNi0wLjAxIDAuMjQzLTAuMDEgMC4zNzN2MjMuMTY1YzAgMi44MjktMC41NDUgNS4wODItMS42NyA2LjgzMi0yLjEyMSAzLjI2OC02LjMyIDQuNzUzLTEzLjAzOCA0Ljc2Mi02LjcxNS05ZS0zIC0xMC45MTMtMS40OTMtMTMuMDM0LTQuNzU4LTEuMTI4LTEuNzUxLTEuNjc0LTQuMDA1LTEuNjc0LTYuODM2di0yMy4xNjVjMC0wLjEzLTdlLTMgLTAuMjQ3LTllLTMgLTAuMzczdi0zLjYzNGMwLTAuMDM1LTRlLTMgLTAuMDctNWUtMyAtMC4xMDV2LTE2LjU3OWMwLTcuMDg1LTIuODkzLTguMzY5LTEwLjY3MS04LjM2OWgtMi40NDljLTcuNzc5IDAtMTAuNjcxIDEuMjg0LTEwLjY3MSA4LjM2OXY0My44NTZjMCA3LjA1NSAxLjU5MSAxMy4wMjggNC42NjUgMTcuODQzIDUuOTM3IDkuMzMgMTcuNDM4IDE0LjI5OSAzMy43ODggMTQuMjk5IDAuMDIgMCAwLjA0LTFlLTMgMC4wNi0xZS0zIDAuMDIxIDAgMC4wNCAxZS0zIDAuMDYxIDFlLTMgMTYuMzUgMCAyNy44NTEtNC45NjkgMzMuNzg4LTE0LjI5OSAzLjA3NC00LjgxNSA0LjY2NS0xMC43ODggNC42NjUtMTcuODQzdi0zMy43ODRsLTguNDcxLTNlLTMiIGZpbGw9IiNBNkMzMDciLz4KPC9nPgo8L3N2Zz4K"
                    alt="Ypmn"
                    style="display: block; max-width: 100%;"
                />*/
                <svg xmlns="http://www.w3.org/2000/svg" width="160" height="162" viewBox="0 0 160 162"><style>
                    @keyframes a1_t { 0% { transform: translate(100px,43.74px) rotate(0deg); animation-timing-function: cubic-bezier(0,0,.58,1); } 16.625% { transform: translate(100px,43.74px) rotate(-15deg); } 100% { transform: translate(100px,43.74px) rotate(0deg); } }
                    @keyframes a0_t { 0% { transform: scale(1,1) translate(-126.64px,-77.99px); animation-timing-function: cubic-bezier(0,0,.58,1); } 16.625% { transform: scale(1.2,1.2) translate(-126.64px,-77.99px); animation-timing-function: cubic-bezier(.42,0,1,1); } 100% { transform: scale(1,1) translate(-126.64px,-77.99px); } }
                    @keyframes a3_t { 0% { transform: translate(100px,43.74px) rotate(0deg); animation-timing-function: cubic-bezier(0,0,.58,1); } 33.3% { transform: translate(100px,43.74px) rotate(-15deg); } 100% { transform: translate(100px,43.74px) rotate(0deg); } }
                    @keyframes a2_t { 0% { transform: scale(1,1) translate(-126.64px,-77.99px); animation-timing-function: cubic-bezier(0,0,.58,1); } 33.3% { transform: scale(1.2,1.2) translate(-126.64px,-77.99px); animation-timing-function: cubic-bezier(.42,0,1,1); } 100% { transform: scale(1,1) translate(-126.64px,-77.99px); } }
                    @keyframes a5_t { 0% { transform: translate(100px,43.74px) rotate(0deg); animation-timing-function: cubic-bezier(0,0,.58,1); } 50% { transform: translate(100px,43.74px) rotate(-15deg); } 100% { transform: translate(100px,43.74px) rotate(0deg); } }
                    @keyframes a4_t { 0% { transform: scale(1,1) translate(-126.64px,-77.99px); animation-timing-function: cubic-bezier(0,0,.58,1); } 50% { transform: scale(1.15,1.15) translate(-126.64px,-77.99px); animation-timing-function: cubic-bezier(.42,0,1,1); } 100% { transform: scale(1,1) translate(-126.64px,-77.99px); } }
                    @keyframes a7_t { 0% { transform: translate(100px,43.74px) rotate(0deg); animation-timing-function: cubic-bezier(0,0,.58,1); } 75% { transform: translate(100px,43.74px) rotate(-12deg); animation-timing-function: cubic-bezier(0,0,.58,1); } 100% { transform: translate(100px,43.74px) rotate(0deg); } }
                    @keyframes a6_t { 0% { transform: scale(1,1) translate(-126.64px,-77.99px); animation-timing-function: cubic-bezier(0,0,.58,1); } 75% { transform: scale(1.1,1.1) translate(-126.64px,-77.99px); animation-timing-function: cubic-bezier(.42,0,1,1); } 100% { transform: scale(1,1) translate(-126.64px,-77.99px); } }
                    </style><g fill="none" transform="translate(7.26,3.76)"><g style="animation: 4s linear infinite both a1_t;">
                    <path d="M131.59 67.09c-9.79-7.14-35.57-2.34-39.37 12.79c-4.63 18.41 17.27 34.97 34.42 25.09c12.29-7.08 14.72-30.73 4.95-37.88Z" fill="#80f3ae" transform="translate(100,43.74) translate(-126.64,-77.99)" style="animation: 4s linear infinite both a0_t;"/></g><g style="animation: 4s linear infinite both a3_t;">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M141.97 78.4c-1.01-5.78-3.36-10.6-6.98-13.72c-7.43-6.39-20.66-7.64-33.03-4.13c-12.36 3.51-22.48 11.36-24.53 21.57c-2.46 12.22 .86 23.11 8.04 30.52c7.17 7.4 18.43 11.56 32.31 9.78c11.45-1.92 19.75-12.66 23.13-25.4c1.67-6.3 2.06-12.85 1.06-18.62Zm4.08 19.98c-3.65 13.73-13.03 26.9-27.45 29.28l-0.04 .01l-0.05 .01c-15.35 1.98-28.36-2.58-36.85-11.34c-8.49-8.77-12.21-21.48-9.44-35.27c2.63-13.04 15.08-21.88 28.29-25.63c13.22-3.75 28.6-2.83 37.95 5.22c4.81 4.15 7.59 10.23 8.74 16.83c1.15 6.62 .69 13.95-1.15 20.89Z" fill="#65d988" transform="translate(100,43.74) translate(-126.64,-77.99)" style="animation: 4s linear infinite both a2_t;"/></g><g style="animation: 4s linear infinite both a5_t;">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M149.39 108.93c6.2-19.26 4.28-40.16-8.67-51.67c-9.52-8.46-27.12-10.8-44.45-6.22c-17.21 4.56-33.25 15.73-39.76 33.1c-5.38 14.34-0.85 31.2 10.01 43.98c10.84 12.74 27.65 21.02 46.21 18.44c16.64-2.3 30.46-18.37 36.66-37.63Zm5.06 1.62c-6.5 20.18-21.45 38.56-40.99 41.28c-20.65 2.86-39.18-6.39-50.98-20.27c-11.77-13.84-17.17-32.69-10.95-49.29c7.3-19.43 25.04-31.51 43.38-36.36c18.23-4.82 37.96-2.73 49.33 7.38c15.22 13.53 16.7 37.08 10.21 57.26Z" fill="#4fc694" transform="translate(100,43.74) translate(-126.64,-77.99)" style="animation: 4s linear infinite both a4_t;"/></g><g style="animation: 4s linear infinite both a7_t;">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M161.81 78.82c-1.86-11.83-6.31-21.63-13.19-27.62c-14.81-12.89-40.55-14.61-64.49-7.42c-23.92 7.18-44.72 22.87-50.15 43.16c-6.14 22.97 2.18 45.73 17.83 61.91c15.68 16.19 38.43 25.49 60.7 21.76c24.19-4.05 40.57-27.22 47.14-53.46c3.26-13.02 4.02-26.54 2.16-38.33Zm2.99 39.62c-6.78 27.08-24.14 52.84-51.41 57.41c-24.28 4.07-48.73-6.09-65.39-23.31c-16.69-17.23-25.86-41.86-19.15-66.97c6.11-22.84 28.99-39.44 53.75-46.88c24.74-7.43 52.71-6.12 69.51 8.5c8.15 7.1 12.97 18.27 14.95 30.8c1.98 12.58 1.16 26.82-2.26 40.45Z" fill="#48a992" transform="translate(100,43.74) translate(-126.64,-77.99)" style="animation: 4s linear infinite both a6_t;"/></g></g>
                </svg>
                Оплатить
                '.(isset($params['sum']) ? '<br><strong>'
                    . number_format($params['sum'], 2, '.', ' ')
                    . ' '
                    . ( isset($params['currency']) ? htmlspecialchars($params['currency']) : '₽' ) .'</strong>' : '').'
            </a>
        ';
    }
}
