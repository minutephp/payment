/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />

module Admin {
    export class PaymentListController {
        constructor(public $scope:any, public $minute:any, public $ui:any, public $timeout:ng.ITimeoutService,
                    public gettext:angular.gettext.gettextFunction, public gettextCatalog:angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
        }
    }

    angular.module('paymentListApp', ['MinuteFramework', 'MinuteDirectives', 'MinuteFilters', 'gettext', 'angular.filter'])
        .controller('paymentListController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', PaymentListController]);
}
