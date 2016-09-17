/// <reference path="../../../../../../../public/static/bower_components/minute/_all.d.ts" />

module Admin {
    export class PaymentListController {
        constructor(public $scope:any, public $minute:any, public $ui:any, public $timeout:ng.ITimeoutService,
                    public gettext:angular.gettext.gettextFunction, public gettextCatalog:angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
        }

        actions = (item) => {
            let gettext = this.gettext;
            let actions = [
                {'text': gettext('Edit..'), 'icon': 'fa-edit', 'hint': gettext('Edit payment'), 'href': '/admin/payments/edit/' + item.payment_id},
                {'text': gettext('Remove'), 'icon': 'fa-trash', 'hint': gettext('Delete this payment'), 'click': 'item.removeConfirm("Removed")'},
            ];

            this.$ui.bottomSheet(actions, gettext('Actions for: ') + item.name, this.$scope, {item: item, ctrl: this});
        };

        clone = (payment) => {
            let gettext = this.gettext;
            this.$ui.prompt(gettext('Enter new slug'), gettext('/new-slug')).then(function (slug) {
                payment.clone().attr('slug', slug).save(gettext('Payment duplicated')).then(function (copy) {
                    angular.forEach(payment.contents, (content) => copy.item.contents.cloneItem(content).save());
                });
            });
        }
    }

    angular.module('paymentListApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('paymentListController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', PaymentListController]);
}
