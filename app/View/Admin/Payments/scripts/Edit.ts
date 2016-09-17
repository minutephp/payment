/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />

module Admin {
    export class PaymentEditController {
        constructor(public $scope:any, public $minute:any, public $ui:any, public $timeout:ng.ITimeoutService,
                    public gettext:angular.gettext.gettextFunction, public gettextCatalog:angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');

            let user_id = parseInt($scope.session.request.user_id || 0);
            $scope.payment = $scope.payments[0] || $scope.payments.create().attr('payment_for', this.gettext('Manual payment')).attr('user_id', user_id);
        }

        save = () => {
            this.$scope.payment.save(this.gettext('Payment saved successfully'));
        };
    }

    angular.module('paymentEditApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('paymentEditController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', PaymentEditController]);
}
