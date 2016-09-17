/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var Admin;
(function (Admin) {
    var PaymentListController = (function () {
        function PaymentListController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
        }
        return PaymentListController;
    }());
    Admin.PaymentListController = PaymentListController;
    angular.module('paymentListApp', ['MinuteFramework', 'MinuteDirectives', 'MinuteFilters', 'gettext', 'angular.filter'])
        .controller('paymentListController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', PaymentListController]);
})(Admin || (Admin = {}));
