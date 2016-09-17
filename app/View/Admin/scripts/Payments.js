/// <reference path="../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var Admin;
(function (Admin) {
    var PaymentListController = (function () {
        function PaymentListController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.actions = function (item) {
                var gettext = _this.gettext;
                var actions = [
                    { 'text': gettext('Edit..'), 'icon': 'fa-edit', 'hint': gettext('Edit payment'), 'href': '/admin/payments/edit/' + item.payment_id },
                    { 'text': gettext('Remove'), 'icon': 'fa-trash', 'hint': gettext('Delete this payment'), 'click': 'item.removeConfirm("Removed")' },
                ];
                _this.$ui.bottomSheet(actions, gettext('Actions for: ') + item.name, _this.$scope, { item: item, ctrl: _this });
            };
            this.clone = function (payment) {
                var gettext = _this.gettext;
                _this.$ui.prompt(gettext('Enter new slug'), gettext('/new-slug')).then(function (slug) {
                    payment.clone().attr('slug', slug).save(gettext('Payment duplicated')).then(function (copy) {
                        angular.forEach(payment.contents, function (content) { return copy.item.contents.cloneItem(content).save(); });
                    });
                });
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
        }
        return PaymentListController;
    }());
    Admin.PaymentListController = PaymentListController;
    angular.module('paymentListApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('paymentListController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', PaymentListController]);
})(Admin || (Admin = {}));
