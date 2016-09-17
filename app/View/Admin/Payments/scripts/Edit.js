/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var Admin;
(function (Admin) {
    var PaymentEditController = (function () {
        function PaymentEditController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.save = function () {
                _this.$scope.payment.save(_this.gettext('Payment saved successfully'));
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            var user_id = parseInt($scope.session.request.user_id || 0);
            $scope.payment = $scope.payments[0] || $scope.payments.create().attr('payment_for', this.gettext('Manual payment')).attr('user_id', user_id);
        }
        return PaymentEditController;
    }());
    Admin.PaymentEditController = PaymentEditController;
    angular.module('paymentEditApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('paymentEditController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', PaymentEditController]);
})(Admin || (Admin = {}));
