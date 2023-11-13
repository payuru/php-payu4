/*
Загрузка SDK Secure Fields
 */
secureFieldsJs.addEventListener('load', () => {
    console.log('eventListener secureFieldsJs');
    initPaymentProcess();
    initPaymentProcessSimple();
})

document.body.appendChild(secureFieldsJs);

/*
Процесс получения одноразового токена
 */
let validationSuccess = [];
let eventsToListen = ['change', 'blur'];
let elementsTypesListened = [];

/*
Настройка Secure Fields, отображение полей Secure Fields, процесс получения одноразового токена
 */
function initPaymentProcess() {
    console.log('function initPaymentProcess');
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
        cvv: '123'
    };

    /*
    Отображение формы после загрузки secure-fields.min.js
     */
    document.getElementById('load').style.display = 'none';
    document.getElementById('form').style.display = 'flex';

    let style = {
        base: {
            fontSize: '1.5em'
        }
    };

    /*
    Отображение полей Secure Fields и подключение слушателей на поля для валидации введенных данных
     */
    const cardNumber = formElements.create('cardNumber', {
        placeholders
    });
    cardNumber.mount('#card-number');
    formValidation(cardNumber, eventsToListen, 'card-number');

    cardNumber.on('cardInfo', (event) => {
        console.log('cardInfoEvent', event)
    });

    const expiry = formElements.create('creditCardExpiry', {
        placeholders
    });
    expiry.mount('#exp-date');
    formValidation(expiry, eventsToListen, 'exp-date');

    const cvv = formElements.create('cvv', {
        placeholders
    });
    cvv.mount('#cvv');
    formValidation(cvv, eventsToListen, 'cvv');

    const userAgreement = formElements.create('userAgreement', {
        style
    });
    userAgreement.mount('#user-agreement');
    formValidation(userAgreement, eventsToListen, 'user-agreement');

    /*
    Валидация поля с именем картодержателя
     */
    cardHolderValidation();

    /*
    Создание токена при нажатии на кнопку формы
     */
    document.getElementById('payment-form').addEventListener('submit', async(event) => {
        console.log('submit');

        /*
        svg загрузки вместо кнопки после нажатия
         */
        document.getElementById('submitLoad').style.display = 'flex';
        document.getElementById('pay_button').style.display = 'none';

        event.preventDefault();

        /*
        Имя картодержателя является обязательным
         */
        const additionalData = {
            holder_name: document.getElementById('cardholder-name').value
        };

        try {
            /*
            Получение и обработка ответа при создании одноразового токена
             */
            console.log('cardNumber');

            const result = await PayUSecureFields.createToken(cardNumber, {additionalData});

            console.log('createToken');
            console.log(result);
            processResult(result);
        } catch (err) {
            /*
            Вывод об ошибке при наличии
             */
            console.log('createTokenError - ' + err.name + ': ' + err.message);
            viewResult(false, err.name, [err.message], true);
        }

        document.getElementById('submitLoad').style.display = 'none';
        document.getElementById('pay_button').style.display = 'block';
    })
}

/*
Процесс обработки результата получения токена
*/
function processResult(result) {
    console.log('function processResult');

    if (typeof result.errors == 'object' && Object.keys(result.errors).length) {
        console.log('createToken errors');
        viewResult(false, 'Tokenization failure', result.errors, true);
        return;
    }

    if (result.statusCode === 'SUCCESS') {
        console.log('createToken success');
        pay(result['token']);
    }
}

/*

*/
function pay(token) {
    console.log('function pay');
    console.log(token);

    let oneTimeTokenPaymentResult = jsonRequest(
        '?function=oneTimeTokenPayment&json=true',
        'post',
        'token=' + encodeURIComponent(token) + '&sessionId=' + encodeURIComponent(sessionId),
        'json',
        function(data){

            if (data['status'] === 'SUCCESS' && data['paymentResult']['type'] === 'redirect') {
                viewRedirect('Redirect to bank\'s page', true);
                window.location.href = data['paymentResult']['url'];
                return;
            }

            if (data['status'] === 'SUCCESS') {
                viewResult(true, 'Payment successful', [], true);
                return;
            }

            viewResult(false, 'Payment failed', [data['message']], true);
        }
    );

    if (oneTimeTokenPaymentResult === false) {
        viewResult(false, 'Payment failed', ['Payment json request failure'], true);
    }
}

function formValidation(object, listeners, containerId) {
    console.log('function formValidation');

    let elementType = object['elementType'];

    elementsTypesListened.push(elementType);

    validationSuccess[elementType] = false;

    if (elementType === 'userAgreement') {
        validationSuccess[elementType] = true;
    }

    let container = document.getElementById(containerId);
    let validationContainer = document.getElementById(containerId + '-validation');

    listeners.forEach( function(listener) {

        object.on(listener, (event) => {
            console.log('listener');
            console.log(object);
            console.log(event);

            if (event['statusCode'] === 'SUCCESS' && event['empty'] === false) {
                console.log('SUCCESS');

                container.classList.remove( 'is-invalid');
                validationContainer.innerHTML = '';

                validationSuccess[elementType] = true;
            } else {
                console.log('ERROR');

                console.log(event['errors']);

                container.classList.add('is-invalid');
                validationContainer.innerHTML = '';

                validationSuccess[elementType] = false;

                for (const key in event['errors']) {
                    let error = event['errors'][key];
                    validationContainer.innerHTML += error + '<br/>';
                    console.log(error);
                }

                if (event['empty'] === true && elementType === 'cvv') {
                    validationContainer.innerHTML += 'CVV is mandatory field<br/>';
                }
            }

            changeButtonAbility();
        })

    });
}

function cardHolderValidation() {
    console.log('function cardHolderValidation');

    let cardHolderEventsToListen= eventsToListen;
    cardHolderEventsToListen.push('input');

    let elementType = 'cardHolder';

    elementsTypesListened.push(elementType);

    validationSuccess[elementType] = false;

    let container = document.getElementById('cardholder-name');
    let validationContainer = document.getElementById('cardholder-name-validation');

    cardHolderEventsToListen.forEach( function(listener) {
        console.log('listener');
        console.log('cardHolder');
        console.log(listener);

        let cardHolderInput = document.getElementById('cardholder-name');

        cardHolderInput.addEventListener(listener, () => {

            if (cardHolderInput.value !== '') {
                console.log('SUCCESS');

                container.classList.remove( 'is-invalid');
                validationContainer.innerHTML = '';

                validationSuccess[elementType] = true;
            } else {
                console.log('ERROR');

                container.classList.add('is-invalid');
                validationContainer.innerHTML = 'Holder\'s name is mandatory field';

                validationSuccess[elementType] = false;
            }

            changeButtonAbility();
        })
    })
}

function changeButtonAbility() {
    console.log('function changeButtonAbility');

    console.log(elementsTypesListened);

    for (const key in elementsTypesListened) {
        let elementType = elementsTypesListened[key];

        console.log(elementType);
        console.log(validationSuccess[elementType]);

        if (validationSuccess[elementType] === false) {
            console.log('disable button');
            document.getElementById('pay_button').disabled = true;
            return;
        }

    }

    console.log('enable button');
    document.getElementById('pay_button').disabled = false;
}

function jsonRequest(url, method, requestData, responseType, successCallback) {
    console.log('function jsonRequest: ' + url);

    let xhr = new XMLHttpRequest();
    xhr.open(method, url, false);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    let jsonRequestResult = false;

    xhr.onload = function() {
        let status = xhr.status;

        if (status === 200) {
            console.log('jsonRequest success');
            console.log(xhr.response);

            successCallback(JSON.parse(xhr.response));
            jsonRequestResult = true;
        } else {
            console.log('jsonRequest error');
            console.log('Error ' + xhr.status + ': ' + xhr.statusText);

            viewResult(false, 'Request Error', [], true);
        }
    };

    xhr.ontimeout = (e) => {
        console.log('jsonRequest timeout error');
        viewResult(false, 'Request Error', [], true);
    };

    console.log(requestData);

    xhr.send(requestData);

    console.log(jsonRequestResult);

    return jsonRequestResult;
}

/*
Отображение результата получения одноразового токена и оплаты
*/

const resultBlock = '\n' +
    '<div class="result" id="result">\n' +
    '    <div class="icon" id="icon">\n' +
    '    </div>\n' +
    '    <h3 class="title" id="title"></h3>\n' +
    '    <p class="message" id="message"></p>\n' +
    '    <a class="reset" id="reset" href="">\n' +
    '        <svg width="32px" height="32px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"\n' +
    '             xmlns:xlink="http://www.w3.org/1999/xlink">\n' +
    '            <path fill="#3A9D86"\n' +
    '                  d="M15,7.05492878 C10.5000495,7.55237307 7,11.3674463 7,16 C7,20.9705627 11.0294373,25 16,25 C20.9705627,25 25,20.9705627 25,16 C25,15.3627484 24.4834055,14.8461538 23.8461538,14.8461538 C23.2089022,14.8461538 22.6923077,15.3627484 22.6923077,16 C22.6923077,19.6960595 19.6960595,22.6923077 16,22.6923077 C12.3039405,22.6923077 9.30769231,19.6960595 9.30769231,16 C9.30769231,12.3039405 12.3039405,9.30769231 16,9.30769231 L16,12.0841673 C16,12.1800431 16.0275652,12.2738974 16.0794108,12.354546 C16.2287368,12.5868311 16.5380938,12.6540826 16.7703788,12.5047565 L22.3457501,8.92058924 L22.3457501,8.92058924 C22.4060014,8.88185624 22.4572275,8.83063012 22.4959605,8.7703788 C22.6452866,8.53809377 22.5780351,8.22873685 22.3457501,8.07941076 L22.3457501,8.07941076 L16.7703788,4.49524351 C16.6897301,4.44339794 16.5958758,4.41583275 16.5,4.41583275 C16.2238576,4.41583275 16,4.63969037 16,4.91583275 L16,7 L15,7 L15,7.05492878 Z M16,32 C7.163444,32 0,24.836556 0,16 C0,7.163444 7.163444,0 16,0 C24.836556,0 32,7.163444 32,16 C32,24.836556 24.836556,32 16,32 Z"></path>\n' +
    '        </svg>\n' +
    '    </a>\n' +
    '</div>';

const successIcon = '\n' +
    '        <svg width="84px" height="84px" viewBox="0 0 84 84" version="1.1" xmlns="http://www.w3.org/2000/svg"\n' +
    '             xmlns:xlink="http://www.w3.org/1999/xlink">\n' +
    '            <circle class="border" cx="42" cy="42" r="40" stroke-linecap="round" stroke-width="4" stroke="#3A9D86"\n' +
    '                    fill="none"></circle>\n' +
    '            <path class="checkmark" stroke-linecap="round" stroke-linejoin="round"\n' +
    '                  d="M23.375 42.5488281 36.8840688 56.0578969 64.891932 28.0500338" stroke-width="4" stroke="#83E8AB"\n' +
    '                  fill="none"></path>\n' +
    '        </svg>';

const failureIcon = '\n' +
    '        <svg fill="#ff0000" width="84px" height="84px" viewBox="0 -8 528 528" xmlns="http://www.w3.org/2000/svg" stroke="#ff0000">\n' +
    '            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>\n' +
    '            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>\n' +
    '            <g id="SVGRepo_iconCarrier">\n' +
    '                <title>fail</title>\n' +
    '                <path d="M264 456Q210 456 164 429 118 402 91 356 64 310 64 256 64 202 91 156 118 110 164 83 210 56 264 56 318 56 364 83 410 110 437 156 464 202 464 256 464 310 437 356 410 402 364 429 318 456 264 456ZM264 288L328 352 360 320 296 256 360 192 328 160 264 224 200 160 168 192 232 256 168 320 200 352 264 288Z"></path>\n' +
    '            </g>\n' +
    '        </svg>';

function viewResult(success, title, messages, hideForm = false) {
    console.log('function viewResult');
    console.log(success);
    console.log(title);
    console.log(messages);

    document.getElementById('bootstrap-tab-pane').innerHTML += resultBlock;

    if (success === true) {
        document.getElementById('icon').innerHTML = successIcon;
    } else {
        document.getElementById('icon').innerHTML = failureIcon;
        document.getElementById('reset').style.display = 'block';
    }

    document.getElementById('title').innerHTML = title;

    let div = document.getElementById('message');
    for (const key in messages) {
        div.innerHTML += '<span class="json">' + messages[key] + '</span>';
    }

    if (hideForm === true) {
        document.getElementById('form').style.display = 'none';
    }
    document.getElementById('load').style.display = 'none';
    document.getElementById('result').style.display = 'flex';
}

function viewRedirect(title, hideForm = false) {
    console.log('function viewRedirect');
    console.log(title);

    document.getElementById('bootstrap-tab-pane').innerHTML += resultBlock;

    document.getElementById('title').innerHTML = title;

    if (hideForm === true) {
        document.getElementById('form').style.display = 'none';
    }
    document.getElementById('load').style.display = 'none';
    document.getElementById('result').style.display = 'flex';
}
