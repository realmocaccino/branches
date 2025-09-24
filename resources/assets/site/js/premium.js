var premium = {

    auxiliaries: {
        stripe: {
            instance: null,
            elements: null,
            component: null
        }
    },

    elements: {
        container: '#premium-checkout',
        form: '#premium-checkout-form',
        cardContainer: '#premium-checkout-card',
        button: '#premium-checkout-submit',
        buttonText: '#premium-checkout-submit-text',
        spinner: '#premium-checkout-spinner',
        errorMessageContainer: '#premium-checkout-errorMessage',
        planIdInput: '#premium-checkout-planId',
        keyInput: '#premium-checkout-key'
    },

    start: function() {
        if($(premium.elements.container).length) premium.createCardComponent();
    },

    createCardComponent: function() {
        loading.show('fast', null, premium.elements.form);
	    premium.auxiliaries.stripe.instance = Stripe(document.querySelector(premium.elements.keyInput).value);

        fetch('/premium/ajax/paymentIntent', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            },
            body: JSON.stringify({
                'planId': document.querySelector(premium.elements.planIdInput).value
            })
        })
        .then(function(result) {
            return result.json();
        })
        .then(function(data) {
            premium.auxiliaries.stripe.elements = premium.auxiliaries.stripe.instance.elements({
                clientSecret: data.clientSecret
            });
            premium.auxiliaries.stripe.component = premium.auxiliaries.stripe.elements.create('payment');
            premium.auxiliaries.stripe.component.mount(premium.elements.cardContainer);
            premium.auxiliaries.stripe.component.on('ready', function(event) {
                loading.hide();
            });
            premium.auxiliaries.stripe.component.on('change', function(event) {
                premium.showError(event.error ? event.error.message : '');
            });

            var form = document.querySelector(premium.elements.form);
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                
                premium.payWithCard(data.planId);
            });
        });
	},

    payWithCard: function(planId) {
        premium.loading(true);
        
        premium.auxiliaries.stripe.instance.confirmPayment({
            elements: premium.auxiliaries.stripe.elements,
            redirect: 'if_required'
        }).then(function(result) {
            if (result.error) {
                premium.showError(result.error.message);
            } else {
                switch(result.paymentIntent.status) {
                    case 'succeeded':
                        premium.orderComplete(planId, result.paymentIntent.id);
                    break;
                    case 'processing':
                        premium.showError("Payment processing. We'll update you when payment is received.");
                    break;
                    case 'requires_payment_method':
                        premium.showError('Payment failed. Please try another payment method.');
                        break;
                    default:
                        premium.showError('Something went wrong.');
                    break;
                }
            }
        });
    },

    orderComplete: function(planId, token) {
        premium.subscribe(planId, token);
        premium.loading(false);
        document.querySelector(premium.elements.button).disabled = true;
        dialog.close(function() {
            alert.create('success', 'Você se tornou um usuário premium', false);
        });
    },

    showError: function(errorMsgText) {
        premium.loading(false);
        
        var errorMsg = document.querySelector(premium.elements.errorMessageContainer);
        errorMsg.textContent = errorMsgText;
        setTimeout(function() {
            errorMsg.textContent = '';
        }, 4000);
    },

    loading: function(isLoading) {
        if (isLoading) {
            document.querySelector(premium.elements.button).disabled = true;
            document.querySelector(premium.elements.spinner).classList.remove('hidden');
            document.querySelector(premium.elements.buttonText).classList.add('hidden');
        } else {
            document.querySelector(premium.elements.button).disabled = false;
            document.querySelector(premium.elements.spinner).classList.add('hidden');
            document.querySelector(premium.elements.buttonText).classList.remove('hidden');
        }
    },
    
    subscribe: function(planId, token) {
        fetch('/premium/ajax/subscribe', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            },
            body: JSON.stringify({
                'planId': planId,
                'token': token
            })
        })
        .then(function(result) {})
        .then(function(data) {});
    }
    
};