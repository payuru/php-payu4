<link href="assets/css/secureFields.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<script>
    /*
    Аутентификационные данные для получения одноразового токена
     */
    let merchantCode = '<?= $merchantCode ?>';
    let sessionId = '<?= $sessionId ?>';

    /*
    Включение вывода отладочной информации в консоль
     */
    let debugMode = true;

    if (debugMode === true) {
        console.log = function() {}
    }

    const secureFieldsJs = document.createElement('script');
    <?php if ($sandboxMode) { ?>
        secureFieldsJs.src = 'https://sandbox.ypmn.ru/js/secure-fields/_sb/secure-fields.min.js';
    <?php } else { ?>
        secureFieldsJs.src = 'https://secure.ypmn.ru/js/secure-fields/secure-fields.min.js';
    <?php } ?>
</script>

<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="simple-tab" data-bs-toggle="tab" data-bs-target="#simple-tab-pane" type="button" role="tab" aria-controls="simple-tab-pane" aria-selected="true">Простая форма</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="bootstrap-tab" data-bs-toggle="tab" data-bs-target="#bootstrap-tab-pane" type="button" role="tab" aria-controls="bootstrap-tab-pane" aria-selected="false">Расширенная форма</button>
    </li>
</ul>

<div class="tab-content" id="myTabContent">

<!--  Простая форма  -->
    <div class="tab-pane fade show active" id="simple-tab-pane" role="tabpanel" aria-labelledby="simple-tab" tabindex="0">

        <p>Форма без использования bootstrap стилей, валидации введенных данных на стороне формы.</p>

        <p>Пример javascript для формы см. по <a href="assets/js/secureFieldsSimple.js">ссылке</a>.</p>

        <div id="simple-load">
            <svg width="200" height="200" viewBox="0 0 38 38" xmlns="http://www.w3.org/2000/svg" stroke="#3A9D86">
                <g fill="none" fill-rule="evenodd">
                    <g transform="translate(1 1)" stroke-width="2">
                        <circle stroke-opacity=".5" cx="18" cy="18" r="18"/>
                        <path d="M36 18c0-9.94-8.06-18-18-18">
                            <animateTransform
                                    attributeName="transform"
                                    type="rotate"
                                    from="0 18 18"
                                    to="360 18 18"
                                    dur="2s"
                                    repeatCount="indefinite"/>
                        </path>
                    </g>
                </g>
            </svg>
        </div>

        <div id="simple-form">

            <form id="simple-payment-form">

                <label>Card Number</label>
                <div id="simple-card-number"></div>

                <br/>

                <label>Exp. date</label>
                <div id="simple-exp-date"></div>

                <br/>

                <label>Cvv</label>
                <div id="simple-cvv"></div>

                <br/>

                <label for="simple-cardholder-name">Name</label>
                <input type="text" placeholder="John Doe" id="simple-cardholder-name" required>

                <br/><br/>

                <div id="simple-user-agreement"></div>

                <br/>

                <button type="submit" id="simple-pay_button">Pay</button>
            </form>

        </div>

    </div>

<!--  Bootstrap форма  -->
    <div class="tab-pane fade" id="bootstrap-tab-pane" role="tabpanel" aria-labelledby="bootstrap-tab" tabindex="0">

        <p>Форма с использованием bootstrap стилей, валидацией введенных данных на стороне формы в реальном времени.</p>

        <p>Пример javascript для формы см. по <a href="assets/js/secureFields.js">ссылке</a>.</p>

        <div id="load" class="load">
            <svg width="200" height="200" viewBox="0 0 38 38" xmlns="http://www.w3.org/2000/svg" stroke="#3A9D86">
                <g fill="none" fill-rule="evenodd">
                    <g transform="translate(1 1)" stroke-width="2">
                        <circle stroke-opacity=".5" cx="18" cy="18" r="18"/>
                        <path d="M36 18c0-9.94-8.06-18-18-18">
                            <animateTransform
                                    attributeName="transform"
                                    type="rotate"
                                    from="0 18 18"
                                    to="360 18 18"
                                    dur="2s"
                                    repeatCount="indefinite"/>
                        </path>
                    </g>
                </g>
            </svg>
        </div>

        <div class="form" id="form">
            <form id="payment-form">
                <div class="input-group mb-3 has-validation">
                    <span class="input-group-text left-column-input" id="basic-addon2">Card Number</span>
                    <div id="card-number" class="form-control secret-field" aria-describedby="basic-addon2"></div>
                    <div id="card-number-validation" class="invalid-feedback"></div>
                </div>
                <div class="row rowDateAndCVV">
                    <div class="col">
                        <div class="input-group mb-3 has-validation">
                            <span class="input-group-text left-column-input" id="basic-addon3">Exp. date</span>
                            <div id="exp-date" class="form-control secret-field" aria-describedby="basic-addon3"></div>
                            <div id="exp-date-validation" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group mb-3 has-validation">
                            <span class="input-group-text right-column-input" id="basic-addon4">CVV</span>
                            <div id="cvv" class="form-control secret-field" aria-describedby="basic-addon4"></div>
                            <div id="cvv-validation" class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3 has-validation">
                    <span class="input-group-text left-column-input" id="basic-addon1">Name</span>
                    <input type="text" class="form-control" placeholder="John Doe" aria-label="John Doe" aria-describedby="basic-addon1" id="cardholder-name">
                    <div id="cardholder-name-validation" class="invalid-feedback"></div>
                </div>
                <div class="form-check mb-3 has-validation no-padding-left">
                    <div id="user-agreement" class="form-control secret-field" aria-describedby="basic-addon2"></div>
                    <div id="user-agreement-validation" class="invalid-feedback"></div>
                </div>

                <div id="submitLoad">
                    <svg width="24" height="24" viewBox="0 0 38 38" xmlns="http://www.w3.org/2000/svg" stroke="#fff">
                        <g fill="none" fill-rule="evenodd">
                            <g transform="translate(1 1)" stroke-width="2">
                                <circle stroke-opacity=".5" cx="18" cy="18" r="18"/>
                                <path d="M36 18c0-9.94-8.06-18-18-18">
                                    <animateTransform
                                            attributeName="transform"
                                            type="rotate"
                                            from="0 18 18"
                                            to="360 18 18"
                                            dur="1s"
                                            repeatCount="indefinite"/>
                                </path>
                            </g>
                        </g>
                    </svg>
                </div>
                <button type="submit" id="pay_button" class="btn btn-primary" disabled>Pay</button>
            </form>
        </div>

    </div>
</div>

<script src="assets/js/secureFieldsSimple.js"></script>
<script src="assets/js/secureFields.js"></script>
