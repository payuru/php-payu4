<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/3.0.0/jquery.payment.min.js" integrity="sha512-vBu5d4hztWcpvKmp+qUS8afvWUMjTd59Z7ci0j6YnKu83yy6Xh/VxtgZqIteIFaK3gMYDm0AnOp3pEF4z6afMw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<style>
    .padding{

        padding: 5rem !important;
    }
    .form-control:focus {
        box-shadow: 10px 0px 0px 0px #ffffff !important;
        border-color: #4ca746;
    }
</style>
<script>
    $(function($) {
        $('[data-numeric]').payment('restrictNumeric');
        $('.cc-number').payment('formatCardNumber');
        $.fn.toggleInputError = function(erred) {
            this.parent('.form-group').toggleClass('has-error', erred);
            return this;
        };
        $('form').submit(function(e) {
            e.preventDefault();
            var cardType = $.payment.cardType($('.cc-number').val());
            $('.cc-number').toggleInputError(!$.payment.validateCardNumber($('.cc-number').val()));
            $('.cc-brand').text(cardType);
            $('.validation').removeClass('text-danger text-success');
            $('.validation').addClass($('.has-error').length ? 'text-danger' : 'text-success');
        });
    });
</script>

<form method="post">
    <div class="padding">
        <div class="row">
            <div class="container-fluid d-flex justify-content-center">
                <div class="col-sm-8 col-md-6">
                    <div class="card">
                        <div class="card-header">

                            <div class="row">
                                <div class="col-md-6">
                                    <span>Выплата</span>
                                </div>
                                <div class="col-md-6 text-right" style="margin-top: -5px;">
                                    <img src="https://img.icons8.com/color/36/000000/visa.png">
                                    <img src="https://img.icons8.com/color/36/000000/mastercard.png">
                                    <img src="https://img.icons8.com/color/36/000000/mir.png">
                                </div>
                            </div>

                        </div>
                        <div class="card-body" style="min-height: 250px">
                            <div class="form-group">
                                <label for="cc-number" class="control-label">Номер Карты</label>
                                <input name="cc-number" id="cc-number" type="tel" class="input-lg form-control cc-number" autocomplete="cc-number" placeholder="&bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull;" required>
                            </div>


                            <div class="form-group">
                                <label for="numeric" class="control-label">Имя и Фамилия Получателя</label>
                                <input name="reciever-name" type="text" class="input-lg form-control">
                            </div>

                            <div class="form-group">
                                <br>
                                <br>
                                <input value="Выплатить" type="submit" class="btn btn-success btn-lg form-control" style="font-size: .8rem;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
