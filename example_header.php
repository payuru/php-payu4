<!DOCTYPE html>
<html class="h-100" lang=ru>
<head>
    <meta charset="UTF-8">
    <title>Твои Платежи | Сервис для работы с электронными платежами</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link rel="prerender" href="https://ypnm.ru/ru/">
    <script async src="https://lib.usedesk.ru/secure.usedesk.ru/widget_163235_46456.js"></script>

    <link rel="icon" type="image/png" sizes="32x32" href="https://ypmn.ru/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="194x194" href="https://ypmn.ru/favicon-194x194.png">
    <link rel="icon" type="image/png" sizes="192x192" href="https://ypmn.ru/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://ypmn.ru/favicon-16x16.png">

    <style>
        body, html {
            height: 100%;
        }

        .main_wrappa {
            min-height: 100%;
        }

        .footer {
            clear: both;
        }

        code {
            color: darkgreen;
        }
    </style>

</head>
<body>

    <div class="container-fluid mt-2 mb-5 main_wrappa">
        <div class="row">
            <div class="col-12 mb-2">
                <a href="./">
                    <svg width="200" viewBox="0 0 767 205" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M132.075 67.5423C122.295 60.3975 96.5112 65.1971 92.7105 80.3277C88.085 98.7417 109.981 115.304 127.129 105.422C139.42 98.3386 141.855 74.6871 132.075 67.5423Z" fill="#80F3AE"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M142.457 78.8497C141.454 73.0655 139.103 68.2524 135.483 65.1343C128.054 58.7349 114.823 57.4919 102.455 61.0013C90.087 64.5109 79.9719 72.3626 77.9177 82.5695C75.4592 94.7849 78.7847 105.684 85.9615 113.09C93.1305 120.488 104.388 124.647 118.273 122.866C129.717 120.949 138.025 110.207 141.403 97.4713C143.074 91.1733 143.457 84.621 142.457 78.8497ZM146.537 98.8329C142.895 112.563 133.509 125.729 119.094 128.113L119.048 128.121L119.001 128.127C103.653 130.109 90.6383 125.547 82.1477 116.786C73.6567 108.024 69.9363 95.3094 72.7112 81.5217C75.3365 68.4773 87.7859 59.6434 101.005 55.8922C114.226 52.1408 129.605 53.0619 138.949 61.1105C143.764 65.258 146.545 71.3391 147.69 77.943C148.836 84.5598 148.378 91.8896 146.537 98.8329Z" fill="#65D988"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M149.883 109.378C156.078 90.1199 154.157 69.2182 141.207 57.7075C131.691 49.2496 114.092 46.9061 96.7643 51.4914C79.5532 56.0458 63.5153 67.2191 56.998 84.589C51.6192 98.9247 56.1483 115.788 67.0161 128.569C77.8469 141.306 94.6602 149.589 113.225 147.014C129.86 144.706 143.685 128.644 149.883 109.378ZM154.938 111.004C148.447 131.184 133.495 149.563 113.955 152.274C93.3044 155.139 74.776 145.893 62.9702 132.009C51.2016 118.169 45.7993 99.3178 52.0257 82.7234C59.3173 63.2898 77.0626 51.2113 95.4057 46.3573C113.632 41.5343 133.358 43.6258 144.735 53.738C159.957 67.2672 161.433 90.8165 154.938 111.004Z" fill="#4FC694"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M162.302 79.27C160.436 67.4414 155.986 57.6362 149.109 51.6496C134.301 38.7573 108.565 37.0346 84.6194 44.2274C60.6964 51.4136 39.9016 67.0985 34.474 87.3933C28.3321 110.358 36.6461 133.122 52.3034 149.299C67.9781 165.494 90.734 174.79 113.005 171.06C137.19 167.01 153.567 143.839 160.14 117.601C163.403 104.575 164.162 91.0581 162.302 79.27ZM165.292 118.891C158.508 145.972 141.149 171.732 113.882 176.298C89.5955 180.365 65.1552 170.214 48.4873 152.993C31.8021 135.754 22.6273 111.134 29.3434 86.0212C35.4516 63.182 58.3273 46.58 83.0916 39.1411C107.834 31.7089 135.802 33.023 152.597 47.644C160.751 54.7431 165.571 65.9077 167.548 78.4424C169.532 91.0175 168.707 105.258 165.292 118.891Z" fill="#48A992"/>
                        <path d="M198.838 69.3462C196.569 69.3462 195.752 70.1666 195.752 72.4456V76.9124C195.752 79.1914 196.569 80.0118 198.838 80.0118H214.448V130.97C214.448 133.249 215.265 134.069 217.534 134.069H222.797C225.066 134.069 225.883 133.249 225.883 130.97V80.0118H241.493C243.762 80.0118 244.579 79.1914 244.579 76.9124V72.4456C244.579 70.1666 243.762 69.3462 241.493 69.3462H198.838Z" fill="#20252E"/>
                        <path d="M282.273 99.8845C282.273 91.9537 277.19 86.8488 268.387 86.8488H246.696C244.518 86.8488 243.883 87.4869 243.883 89.6747V131.243C243.883 133.34 244.518 134.069 246.696 134.069H269.658C278.461 134.069 284.088 128.782 284.088 120.669C284.088 115.564 282.001 111.826 277.916 109.456C280.821 107.36 282.273 104.169 282.273 99.8845ZM254.411 105.628V95.7824H266.572C269.839 95.7824 271.745 97.6967 271.745 100.705C271.745 103.622 269.839 105.628 266.663 105.628H254.411ZM254.411 125.136V114.288H267.479C271.019 114.288 273.106 116.293 273.106 119.575C273.106 122.948 270.928 125.136 267.57 125.136H254.411Z" fill="#20252E"/>
                        <path d="M290.909 117.205C290.909 128.6 298.442 135.437 311.783 135.437C325.215 135.437 332.748 128.6 332.748 117.205V103.713C332.748 92.3183 325.215 85.4814 311.783 85.4814C298.442 85.4814 290.909 92.3183 290.909 103.713V117.205ZM322.22 117.205C322.22 122.674 318.408 125.865 311.783 125.865C305.158 125.865 301.437 122.674 301.437 117.205V103.713C301.437 98.1525 305.158 95.0531 311.783 95.0531C318.408 95.0531 322.22 98.1525 322.22 103.713V117.205Z" fill="#20252E"/>
                        <path d="M344.452 86.8488C342.365 86.8488 341.73 87.4869 341.73 89.5835V131.243C341.73 133.34 342.365 134.069 344.452 134.069H349.444C350.624 134.069 351.531 133.613 352.258 132.611L368.14 109.912C370.681 106.175 372.406 103.075 373.404 100.705H373.676C372.315 105.354 371.679 109.821 371.679 114.105V131.243C371.679 133.34 372.406 134.069 374.493 134.069H379.485C381.572 134.069 382.207 133.34 382.207 131.243V89.5835C382.207 87.4869 381.572 86.8488 379.485 86.8488H374.493C373.313 86.8488 372.406 87.3046 371.77 88.2162L355.706 111.097C353.528 114.288 351.804 117.387 350.624 120.304H350.352C351.622 115.746 352.258 111.279 352.258 106.995V89.5835C352.258 87.4869 351.531 86.8488 349.444 86.8488H344.452Z" fill="#20252E"/>
                        <path d="M416.72 69.3462C414.451 69.3462 413.543 70.1666 413.543 72.4456V130.97C413.543 133.249 414.451 134.069 416.72 134.069H421.893C424.162 134.069 424.978 133.249 424.978 130.97V80.0118H451.389V130.97C451.389 133.249 452.205 134.069 454.474 134.069H459.647C461.916 134.069 462.733 133.249 462.733 130.97V72.4456C462.733 70.1666 461.916 69.3462 459.647 69.3462H416.72Z" fill="#20252E"/>
                        <path d="M482.308 86.8488C480.221 86.8488 479.495 87.4869 479.495 89.5835V103.166C479.495 111.826 478.587 117.752 476.772 120.669C474.957 123.677 473.868 124.406 471.599 125.591C470.147 126.412 469.784 127.506 470.51 128.873L472.87 133.613C473.686 135.254 474.775 135.71 476.318 135.072C480.221 133.249 482.49 131.426 485.394 126.959C488.298 122.583 489.75 114.743 489.75 103.804V96.6028H503.545V131.243C503.545 133.34 504.271 134.069 506.359 134.069H511.26C513.347 134.069 514.073 133.34 514.073 131.243V89.5835C514.073 87.4869 513.347 86.8488 511.26 86.8488H482.308Z" fill="#20252E"/>
                        <path d="M522.692 94.9619C521.694 96.7851 522.238 98.1525 524.235 99.0641L527.865 100.614C529.953 101.343 530.406 101.161 531.768 99.2464C533.674 96.3293 536.85 94.8708 541.297 94.8708C547.832 94.8708 550.373 97.9702 550.373 103.896V106.448C545.2 106.175 542.296 105.992 541.66 105.992C526.867 105.992 521.058 109.821 521.058 120.669C521.058 125.683 522.511 129.42 525.415 131.79C528.319 134.252 533.583 135.437 541.297 135.437C548.558 135.437 554.003 134.616 557.633 133.066C560.175 131.973 560.901 131.061 560.901 127.87V104.26C560.901 91.7714 554.457 85.4814 541.479 85.4814C532.222 85.4814 525.959 88.6719 522.692 94.9619ZM550.373 124.68C550.373 125.318 550.01 125.683 549.375 125.956C547.196 126.412 544.201 126.685 540.299 126.685C533.674 126.685 531.768 124.68 531.768 120.578C531.768 116.567 533.946 114.652 540.48 114.652C540.753 114.652 544.02 114.835 550.373 115.108V124.68Z" fill="#20252E"/>
                        <path d="M567.485 86.8488C565.398 86.8488 564.672 87.4869 564.672 89.5835V93.7769C564.672 95.8735 565.398 96.6028 567.485 96.6028H579.375V131.243C579.375 133.34 580.101 134.069 582.188 134.069H587.089C589.176 134.069 589.902 133.34 589.902 131.243V96.6028H601.701C603.788 96.6028 604.514 95.8735 604.514 93.7769V89.5835C604.514 87.4869 603.788 86.8488 601.701 86.8488H567.485Z" fill="#20252E"/>
                        <path d="M609.31 115.929C609.31 127.87 616.026 135.437 630.184 135.437C639.714 135.437 646.248 132.52 649.788 126.685C651.149 124.589 650.786 123.13 648.698 122.127L645.522 120.395C643.344 119.21 642.346 119.393 640.893 121.489C638.806 124.68 635.267 126.321 630.184 126.321C623.559 126.321 619.838 123.13 619.838 117.205V113.832H647.246C649.969 113.832 651.33 112.556 651.33 109.912V104.351C651.33 93.3211 644.161 85.4814 630.366 85.4814C616.661 85.4814 609.31 92.4095 609.31 105.172V115.929ZM640.803 105.719H619.838V103.713C619.838 97.7879 623.559 94.415 630.366 94.415C637.263 94.415 640.803 97.7879 640.803 103.713V105.719Z" fill="#20252E"/>
                        <path d="M684.739 86.8488C682.47 86.8488 681.835 87.4869 681.835 89.6747V105.081H679.112H678.023L667.677 88.9454C666.497 87.0311 665.589 86.8488 662.231 86.8488H657.784C655.152 86.8488 654.517 87.9427 655.969 90.1305L668.403 107.998C666.497 109.365 664.682 111.553 663.139 114.743L655.152 130.696C653.972 133.158 654.335 134.069 656.967 134.069H661.596C664.772 134.069 665.408 133.705 666.406 131.517L672.033 119.393C673.394 116.384 675.754 114.926 679.203 114.926H681.835V131.152C681.835 133.34 682.47 134.069 684.739 134.069H689.367C691.636 134.069 692.362 133.34 692.362 131.152V114.926H694.904C698.443 114.926 700.803 116.384 702.073 119.393L707.7 131.517C708.699 133.705 709.425 134.069 712.601 134.069H717.139C719.771 134.069 720.134 133.158 718.954 130.696L711.058 114.743C709.334 111.462 707.61 109.183 705.704 107.998L718.137 90.1305C719.589 87.9427 718.954 86.8488 716.322 86.8488H711.875C708.517 86.8488 707.61 87.0311 706.43 88.9454L696.174 105.081H695.085H692.362V89.6747C692.362 87.4869 691.636 86.8488 689.367 86.8488H684.739Z" fill="#20252E"/>
                        <path d="M729.207 86.8488C727.12 86.8488 726.485 87.4869 726.485 89.5835V131.243C726.485 133.34 727.12 134.069 729.207 134.069H734.199C735.379 134.069 736.286 133.613 737.013 132.611L752.895 109.912C755.436 106.175 757.161 103.075 758.159 100.705H758.431C757.07 105.354 756.434 109.821 756.434 114.105V131.243C756.434 133.34 757.161 134.069 759.248 134.069H764.24C766.327 134.069 766.962 133.34 766.962 131.243V89.5835C766.962 87.4869 766.327 86.8488 764.24 86.8488H759.248C758.068 86.8488 757.16 87.3046 756.525 88.2162L740.461 111.097C738.283 114.288 736.559 117.387 735.379 120.304H735.107C736.377 115.746 737.013 111.279 737.013 106.995V89.5835C737.013 87.4869 736.286 86.8488 734.199 86.8488H729.207Z" fill="#20252E"/>
                    </svg>
                </a>

            </div>
            <div class="col-md-4 col-lg-3">
                <ol class="list-group list-group-numbered mb-5">
                    <?php
                        foreach ($examples as $key => $example) {
                            echo '
                                <li class="list-group-item"><a href="./?function='.$key.'">'. $example['name'] .'</a></li>
                            ';
                        }
                    ?>
                </ol>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a target="_blank" href="https://YPMN.ru/ru/">Наш сайт</a></li>
                    <li class="list-group-item"><a target="_blank" href="https://github.com/yourpayments/">Github</a></li>
                    <li class="list-group-item"><a target="_blank" href="https://dev.payu.ru/ru/documents/rest-api/testing/">Тестовые карты</a></li>
                    <li class="list-group-item"><a target="_blank" href="https://dev.ypmn.ru/ru/documents/kak-eto-rabotaet/">Документация</a></li>
                    <li class="list-group-item"><a target="_blank" href="https://dev.ypmn.ru/ru/faq/">Частые вопросы</a></li>
                    <li class="list-group-item"><a target="_blank" href="mailto:itsupport@ypmn.ru?subject=YPMN_Integration">itsupport@ypmn.ru</a></li>
                    <li class="list-group-item"><a target="_blank" href="https://t.me/YPMN_bot">@YPMN_bot</a></li>
                </ul>

            </div>
            <div class="col-md-8 col-lg-9">

            <?php
                if (isset($_GET['function']) && isset($examples[ $_GET['function'] ]) && isset($examples[ $_GET['function'] ]['about'])) {
                    echo \Ypmn\Std::alert([
                        'text' => $examples[ $_GET['function'] ]['about'] . '
                            <br>
                            <br>
                            <a class="btn btn-outline-success mr-3" target="_blank" href="https://github.com/yourpayments/php-api-client/blob/main/src/Examples/'. $_GET['function'] .'.php" class="alert-link">Адрес этого примера на Github</a>
                            '.( !$examples[ $_GET['function'] ]['docLink'] ? '' : '<a class="btn btn-outline-success m-3" target="_blank" href="'.$examples[ $_GET['function'] ]['docLink'].'" class="alert-link">Документация API</a>' ).'
                        ',
                    ]);
                }
