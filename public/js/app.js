(function() {
        var stripeBilling = {
            init: function() {
                this.form = $('#payment-form');
                this.submitButton = this.form.find('input[type=submit]');

                var stripeKey = $('meta[name="publishable-key"]').attr('content');

                Stripe.setPublishableKey(stripeKey);

                this.bindEvents();
            },

            bindEvents: function() {
                this.form.on('submit', $.proxy(this.sendToken, this));
            },

            sendToken: function(event) {
                this.submitButton.val('One moment..').prop('disabled', true);

                Stripe.createToken(this.form, $.proxy(this.stripeResponseHandler, this))
                event.preventDefault();
            },

            stripeResponseHandler: function(status, response) {

                if (response.error) {
                   this.form.find('.payment-errors').show().text(response.error.message);
                   return this.submitButton.prop('disabled', false).val('Finish payment');
                }

                $('<input>', {
                   type: 'hidden',
                   name: 'stripeToken',
                   value: response.id
                }).appendTo(this.form);

                this.form[0].submit();

            }
        };

        stripeBilling.init();

        var submitAjaxRequest = function(e) {

        var form = $(this);
        var method = form.find('input[name="_method"]').val() || 'POST';
        var submitButton = form.find('input[type="submit"]');

        $.ajaxSetup({
            beforeSend:function(){
                submitButton.addClass('disabled').attr('disabled', true);
            },
            complete:function(){
                submitButton.removeClass('disabled').attr('disabled', false);
            }
        });
        $.ajax({
            type: method,
            url: form.prop('action'),
            data: form.serialize(),
            dataType: 'json',
            success: function(json) {
                var cart = $('#shopping-cart');

                cart.html(json.data);
            },
            error: function(jqXhr, json) {
                var errors = jqXhr.responseJSON;
                $.each(errors, function(key, value) {
                });
            }
        });

        // Prevent the form from submitting normally
        e.preventDefault();
    };
    $('form[data-remote]').on('submit', submitAjaxRequest);
})();

