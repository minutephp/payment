/// <reference path="../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var Admin;
(function (Admin) {
    var ProcessorEditController = (function () {
        function ProcessorEditController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.save = function () {
                _this.$scope.config.save(_this.gettext('Processors updated successfully'));
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.data = { processors: [], tabs: {} };
            $scope.config = $scope.configs[0] || $scope.configs.create().attr('type', 'processors').attr('data_json', {});
            $scope.settings = $scope.config.attr('data_json');
            $scope.settings.links = angular.isArray($scope.settings.links) ? $scope.settings.links : [{}];
        }
        return ProcessorEditController;
    }());
    Admin.ProcessorEditController = ProcessorEditController;
    angular.module('processorEditApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('processorEditController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', ProcessorEditController]);
})(Admin || (Admin = {}));
