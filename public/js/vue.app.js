var Resource = require('vue-resource');

new Vue({

    el: '#products',

    submitted: false,

    methods: {
        updateCart: function(e) {
            e.preventDefault();

            var item = this;

            this.$http.post('/cart', function() {

            });

            this.submitted = true;
        }
    }

});