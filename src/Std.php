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
              <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
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
                href="' . $params['url'] . '"
                id="ypmn_button"
                rel="noindex nofollow"
                title="Оплатить"
                style="
                    max-width: 400px;
                    max-height: 150px;
                    display: inline-block;
                    justify-content: space-between;
                    background: #ffffff;
                    color: #000000;
                    border: 1px solid #000000;
                    border-radius: 5px;
                    padding: 16px;
                "
            >
            <svg xmlns="http://www.w3.org/2000/svg" 
                     width="50" 
                     height="50" 
                     viewBox="0 0 160 162"
                     style="
                         display: inline;
                         padding-right: 16px;
                         float: left;
                     "
                     ><style>
                     
                @keyframes a1_t { 0% { transform: translate(100px,43.74px) rotate(0deg); animation-timing-function: cubic-bezier(0,0,.58,1); } 16.625% { transform: translate(100px,43.74px) rotate(-15deg); } 100% { transform: translate(100px,43.74px) rotate(0deg); } }
                @keyframes a0_t { 0% { transform: scale(1,1) translate(-126.64px,-77.99px); animation-timing-function: cubic-bezier(0,0,.58,1); } 16.625% { transform: scale(1.2,1.2) translate(-126.64px,-77.99px); animation-timing-function: cubic-bezier(.42,0,1,1); } 100% { transform: scale(1,1) translate(-126.64px,-77.99px); } }
                @keyframes a3_t { 0% { transform: translate(100px,43.74px) rotate(0deg); animation-timing-function: cubic-bezier(0,0,.58,1); } 33.3% { transform: translate(100px,43.74px) rotate(-15deg); } 100% { transform: translate(100px,43.74px) rotate(0deg); } }
                @keyframes a2_t { 0% { transform: scale(1,1) translate(-126.64px,-77.99px); animation-timing-function: cubic-bezier(0,0,.58,1); } 33.3% { transform: scale(1.2,1.2) translate(-126.64px,-77.99px); animation-timing-function: cubic-bezier(.42,0,1,1); } 100% { transform: scale(1,1) translate(-126.64px,-77.99px); } }
                @keyframes a5_t { 0% { transform: translate(100px,43.74px) rotate(0deg); animation-timing-function: cubic-bezier(0,0,.58,1); } 50% { transform: translate(100px,43.74px) rotate(-15deg); } 100% { transform: translate(100px,43.74px) rotate(0deg); } }
                @keyframes a4_t { 0% { transform: scale(1,1) translate(-126.64px,-77.99px); animation-timing-function: cubic-bezier(0,0,.58,1); } 50% { transform: scale(1.15,1.15) translate(-126.64px,-77.99px); animation-timing-function: cubic-bezier(.42,0,1,1); } 100% { transform: scale(1,1) translate(-126.64px,-77.99px); } }
                @keyframes a7_t { 0% { transform: translate(100px,43.74px) rotate(0deg); animation-timing-function: cubic-bezier(0,0,.58,1); } 75% { transform: translate(100px,43.74px) rotate(-12deg); animation-timing-function: cubic-bezier(0,0,.58,1); } 100% { transform: translate(100px,43.74px) rotate(0deg); } }
                @keyframes a6_t { 0% { transform: scale(1,1) translate(-126.64px,-77.99px); animation-timing-function: cubic-bezier(0,0,.58,1); } 75% { transform: scale(1.1,1.1) translate(-126.64px,-77.99px); animation-timing-function: cubic-bezier(.42,0,1,1); } 100% { transform: scale(1,1) translate(-126.64px,-77.99px); } }
                </style><g fill="none" transform="translate(7.26,3.76)"><g style="animation: 4s linear infinite both a1_t;"><path d="M131.59 67.09c-9.79-7.14-35.57-2.34-39.37 12.79c-4.63 18.41 17.27 34.97 34.42 25.09c12.29-7.08 14.72-30.73 4.95-37.88Z" fill="#80f3ae" transform="translate(100,43.74) translate(-126.64,-77.99)" style="animation: 4s linear infinite both a0_t;"/></g><g style="animation: 4s linear infinite both a3_t;"><path fill-rule="evenodd" clip-rule="evenodd" d="M141.97 78.4c-1.01-5.78-3.36-10.6-6.98-13.72c-7.43-6.39-20.66-7.64-33.03-4.13c-12.36 3.51-22.48 11.36-24.53 21.57c-2.46 12.22 .86 23.11 8.04 30.52c7.17 7.4 18.43 11.56 32.31 9.78c11.45-1.92 19.75-12.66 23.13-25.4c1.67-6.3 2.06-12.85 1.06-18.62Zm4.08 19.98c-3.65 13.73-13.03 26.9-27.45 29.28l-0.04 .01l-0.05 .01c-15.35 1.98-28.36-2.58-36.85-11.34c-8.49-8.77-12.21-21.48-9.44-35.27c2.63-13.04 15.08-21.88 28.29-25.63c13.22-3.75 28.6-2.83 37.95 5.22c4.81 4.15 7.59 10.23 8.74 16.83c1.15 6.62 .69 13.95-1.15 20.89Z" fill="#65d988" transform="translate(100,43.74) translate(-126.64,-77.99)" style="animation: 4s linear infinite both a2_t;"/></g><g style="animation: 4s linear infinite both a5_t;"><path fill-rule="evenodd" clip-rule="evenodd" d="M149.39 108.93c6.2-19.26 4.28-40.16-8.67-51.67c-9.52-8.46-27.12-10.8-44.45-6.22c-17.21 4.56-33.25 15.73-39.76 33.1c-5.38 14.34-0.85 31.2 10.01 43.98c10.84 12.74 27.65 21.02 46.21 18.44c16.64-2.3 30.46-18.37 36.66-37.63Zm5.06 1.62c-6.5 20.18-21.45 38.56-40.99 41.28c-20.65 2.86-39.18-6.39-50.98-20.27c-11.77-13.84-17.17-32.69-10.95-49.29c7.3-19.43 25.04-31.51 43.38-36.36c18.23-4.82 37.96-2.73 49.33 7.38c15.22 13.53 16.7 37.08 10.21 57.26Z" fill="#4fc694" transform="translate(100,43.74) translate(-126.64,-77.99)" style="animation: 4s linear infinite both a4_t;"/></g><g style="animation: 4s linear infinite both a7_t;"><path fill-rule="evenodd" clip-rule="evenodd" d="M161.81 78.82c-1.86-11.83-6.31-21.63-13.19-27.62c-14.81-12.89-40.55-14.61-64.49-7.42c-23.92 7.18-44.72 22.87-50.15 43.16c-6.14 22.97 2.18 45.73 17.83 61.91c15.68 16.19 38.43 25.49 60.7 21.76c24.19-4.05 40.57-27.22 47.14-53.46c3.26-13.02 4.02-26.54 2.16-38.33Zm2.99 39.62c-6.78 27.08-24.14 52.84-51.41 57.41c-24.28 4.07-48.73-6.09-65.39-23.31c-16.69-17.23-25.86-41.86-19.15-66.97c6.11-22.84 28.99-39.44 53.75-46.88c24.74-7.43 52.71-6.12 69.51 8.5c8.15 7.1 12.97 18.27 14.95 30.8c1.98 12.58 1.16 26.82-2.26 40.45Z" fill="#48a992" transform="translate(100,43.74) translate(-126.64,-77.99)" style="animation: 4s linear infinite both a6_t;"/></g></g></svg>
                <div style="
                        
                        display: inline-block;
                        "
                <strong style="
                        display: inline-block;
                        vertical-align: center;
                        text-align: justify;
                        padding-left: 10px;
                        padding-right: 10px;
                        font-size: 14pt;
                    ">Оплатить</strong>
                ' .(isset($params['sum']) ? '<br><strong style="
                                                        font-size: 14pt;
                                                        text-align: justify;
                                                        float: left
                                                        ">'
                . number_format($params['sum'], 2, '.', ' ')
                . ' '
                . ( isset($params['currency']) ? htmlspecialchars($params['currency']) : '₽' ) .'</strong>' : '').'
        </div>  
</a>
        ';
    }
}
