/*
Настройка Secure Fields, отображение полей Secure Fields, процесс получения одноразового токена
 */
function initPaymentProcessSimple() {
    console.log('function initPaymentProcessSimple');
    console.log(merchantCode);
    console.log(sessionId);

    /*
    Создание объекта Secure Fields.
    Первый аргумент (обязательный) - аутентификационные данные.
    Второй аргумент (опциональный) - пользовательские стили.
     */
    const auth = {
        merchantCode: merchantCode,
        sessionId: sessionId
    };

    const fonts = [
        {
            // src: 'https://fonts.googleapis.com/css?family=Source+Code+Pro'
        }
    ];

    const formElements = new PayUSecureFields.Init(auth, {
        fonts
    })

    console.log(formElements);

    /*
    Добавление плейсхолдеров для полей Secure Fields.
     */
    const placeholders = {
        cardNumber: '1234 1234 1234 1234',
        expDate: 'MM / YY',
        cvv: '123',
        userAgreement: 'ru'
    };

    /*
    Отображение формы после загрузки secure-fields.min.js
     */
    document.getElementById('simple-load').style.display = 'none';
    document.getElementById('simple-form').style.display = 'block';

    /*
    Отображение полей Secure Fields
     */
    const cardNumber = formElements.create('cardNumber', {
        placeholders
    });
    cardNumber.mount('#simple-card-number');

    const expiry = formElements.create('creditCardExpiry', {
        placeholders
    });
    expiry.mount('#simple-exp-date');

    const cvv = formElements.create('cvv', {
        placeholders
    });
    cvv.mount('#simple-cvv');

    const userAgreement = formElements.create('userAgreement', {
        placeholders
    });
    userAgreement.mount('#simple-user-agreement');

    /*
    Создание токена при нажатии на кнопку формы
     */
    document.getElementById('simple-payment-form').addEventListener('submit', async(event) => {
        console.log('submit');

        event.preventDefault();

        /*
        Имя картодержателя является обязательным
         */
        const additionalData = {
            holder_name: document.getElementById('simple-cardholder-name').value
        };

        try {
            /*
            Получение и обработка ответа при создании одноразового токена
             */
            console.log('cardNumber');

            const result = await PayUSecureFields.createToken(cardNumber, {additionalData});

            console.log('createToken');
            console.log(result);

            processResultSimple(result);
        } catch (err) {
            /*
            Вывод об ошибке при наличии
             */
            console.log('createTokenError - ' + err.name + ': ' + err.message);

            viewResultSimple(false, err.name, [err.message], true);
        }
    })
}

/*
Обработка ответа при создании токена
 */
function processResultSimple(result) {
    console.log('function processResultSimple');

    /*
    Вывод ошибок создания токена
     */
    if (typeof result.errors == 'object' && Object.keys(result.errors).length) {
        console.log('createToken errors');

        viewResultSimple(false, 'Tokenization failure', result.errors, true);
        return;
    }

    /*
    В случае успешного создания токена переходим к процессу оплаты
     */
    if (result.statusCode === 'SUCCESS') {
        console.log('createToken success');

        paySimple(result['token']);
    }
}

/*
Процесс оплаты
 */
function paySimple(token) {
    console.log('function paySimple');
    console.log(token);

    let oneTimeTokenPaymentResult = jsonRequest(
        '?function=oneTimeTokenPayment&json=true',
        'post',
        'token=' + encodeURIComponent(token) + '&sessionId=' + encodeURIComponent(sessionId),
        'json',
        function(data){

            /*
            Если для оплаты необходимо пройти проверку 3-D Secure, то происходит редирект на соответствующую страницу
             */
            if (data['status'] === 'SUCCESS' && data['paymentResult']['type'] === 'redirect') {
                viewRedirectSimple('Redirect to bank\'s page', true);
                window.location.href = data['paymentResult']['url'];
                return;
            }

            /*
            В случае успешной оплаты сообщаем об этом пользователю
             */
            if (data['status'] === 'SUCCESS') {
                viewResultSimple(true, 'Payment successful', [], true);
                return;
            }

            /*
            В случае ошибок по результатам оплаты выводим их
             */
            viewResultSimple(false, 'Payment failed', [data['message']], true);
        }
    );

    /*
    Если запрос не прошел, выводим информацию
     */
    if (oneTimeTokenPaymentResult === false) {
        viewResultSimple(false, 'Payment failed', ['Payment json request failure'], true);
    }
}

/*
Блоки результатов
 */
const resultBlockSimple = '\n' +
    '<div class="result" id="simple-result">\n' +
    '    <div class="icon" id="simple-icon">\n' +
    '    </div>\n' +
    '    <h3 class="title" id="simple-title"></h3>\n' +
    '    <p class="message" id="simple-message"></p>\n' +
    '    <a class="reset" id="simple-reset" href="">\n' +
    '        <svg width="32px" height="32px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"\n' +
    '             xmlns:xlink="http://www.w3.org/1999/xlink">\n' +
    '            <path fill="#3A9D86"\n' +
    '                  d="M15,7.05492878 C10.5000495,7.55237307 7,11.3674463 7,16 C7,20.9705627 11.0294373,25 16,25 C20.9705627,25 25,20.9705627 25,16 C25,15.3627484 24.4834055,14.8461538 23.8461538,14.8461538 C23.2089022,14.8461538 22.6923077,15.3627484 22.6923077,16 C22.6923077,19.6960595 19.6960595,22.6923077 16,22.6923077 C12.3039405,22.6923077 9.30769231,19.6960595 9.30769231,16 C9.30769231,12.3039405 12.3039405,9.30769231 16,9.30769231 L16,12.0841673 C16,12.1800431 16.0275652,12.2738974 16.0794108,12.354546 C16.2287368,12.5868311 16.5380938,12.6540826 16.7703788,12.5047565 L22.3457501,8.92058924 L22.3457501,8.92058924 C22.4060014,8.88185624 22.4572275,8.83063012 22.4959605,8.7703788 C22.6452866,8.53809377 22.5780351,8.22873685 22.3457501,8.07941076 L22.3457501,8.07941076 L16.7703788,4.49524351 C16.6897301,4.44339794 16.5958758,4.41583275 16.5,4.41583275 C16.2238576,4.41583275 16,4.63969037 16,4.91583275 L16,7 L15,7 L15,7.05492878 Z M16,32 C7.163444,32 0,24.836556 0,16 C0,7.163444 7.163444,0 16,0 C24.836556,0 32,7.163444 32,16 C32,24.836556 24.836556,32 16,32 Z"></path>\n' +
    '        </svg>\n' +
    '    </a>\n' +
    '</div>';

const successIconSimple = '\n' +
    '        <svg width="84px" height="84px" viewBox="0 0 84 84" version="1.1" xmlns="http://www.w3.org/2000/svg"\n' +
    '             xmlns:xlink="http://www.w3.org/1999/xlink">\n' +
    '            <circle class="border" cx="42" cy="42" r="40" stroke-linecap="round" stroke-width="4" stroke="#3A9D86"\n' +
    '                    fill="none"></circle>\n' +
    '            <path class="checkmark" stroke-linecap="round" stroke-linejoin="round"\n' +
    '                  d="M23.375 42.5488281 36.8840688 56.0578969 64.891932 28.0500338" stroke-width="4" stroke="#83E8AB"\n' +
    '                  fill="none"></path>\n' +
    '        </svg>';

const failureIconSimple = '\n' +
    '        <svg fill="#ff0000" width="84px" height="84px" viewBox="0 -8 528 528" xmlns="http://www.w3.org/2000/svg" stroke="#ff0000">\n' +
    '            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>\n' +
    '            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>\n' +
    '            <g id="SVGRepo_iconCarrier">\n' +
    '                <title>fail</title>\n' +
    '                <path d="M264 456Q210 456 164 429 118 402 91 356 64 310 64 256 64 202 91 156 118 110 164 83 210 56 264 56 318 56 364 83 410 110 437 156 464 202 464 256 464 310 437 356 410 402 364 429 318 456 264 456ZM264 288L328 352 360 320 296 256 360 192 328 160 264 224 200 160 168 192 232 256 168 320 200 352 264 288Z"></path>\n' +
    '            </g>\n' +
    '        </svg>';

/*
Вывод результата
 */
function viewResultSimple(success, title, messages, hideForm = false) {
    document.getElementById('simple-tab-pane').innerHTML += resultBlockSimple;

    if (success === true) {
        document.getElementById('simple-icon').innerHTML = successIconSimple;
    } else {
        document.getElementById('simple-icon').innerHTML = failureIconSimple;
        document.getElementById('simple-reset').style.display = 'block';
    }

    document.getElementById('simple-title').innerHTML = title;

    let div = document.getElementById('simple-message');
    for (const key in messages) {
        div.innerHTML += '<span class="json">' + messages[key] + '</span>';
    }

    if (hideForm === true) {
        document.getElementById('simple-form').style.display = 'none';
    }
    document.getElementById('simple-load').style.display = 'none';
    document.getElementById('simple-result').style.display = 'flex';
}

/*
Вывод информации о редиректе на проверку 3-D Secure
 */
function viewRedirectSimple(title, hideForm = false) {
    document.getElementById('simple-tab-pane').innerHTML += resultBlockSimple;

    document.getElementById('simple-title').innerHTML = title;

    if (hideForm === true) {
        document.getElementById('simple-form').style.display = 'none';
    }
    document.getElementById('simple-load').style.display = 'none';
    document.getElementById('simple-result').style.display = 'flex';
}
