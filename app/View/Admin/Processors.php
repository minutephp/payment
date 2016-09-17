<div class="content-wrapper ng-cloak" ng-app="processorEditApp" ng-controller="processorEditController as mainCtrl" ng-init="init()">
    <div class="admin-content">
        <section class="content-header">
            <h1>
                <span translate="">Setup payment processors</span>
            </h1>

            <ol class="breadcrumb">
                <li><a href="" ng-href="/admin"><i class="fa fa-dashboard"></i> <span translate="">Admin</span></a></li>
                <li><a href="" ng-href="/admin/processors"><i class="fa fa-processor"></i> <span translate="">Payment Processors</span></a></li>
            </ol>
        </section>

        <section class="content">
            <minute-event name="import.providers.list" as="data.providers"></minute-event>

            <form class="form-horizontal" name="processorForm" ng-submit="mainCtrl.save()">
                <div class="box box-{{processorForm.$valid && 'success' || 'danger'}}">
                    <div class="box-body">
                        <div class="alert alert-info alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <i class="fa fa-info"></i> <span translate="">You can find more payments processors on the</span> <a ng-href="/admin/plugins"><span translate="">plugins page</span></a>.
                        </div>

                        <div class="tabs-panel">
                            <ul class="nav nav-tabs">
                                <li ng-class="{active: provider === data.tabs.selectedProvider}" ng-repeat="provider in data.providers"
                                    ng-init="data.tabs.selectedProvider = data.tabs.selectedProvider || provider">
                                    <a href="" ng-click="data.tabs.selectedProvider = provider">{{provider.name}}</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade in active" ng-repeat="provider in data.providers" ng-if="provider === data.tabs.selectedProvider">
                                    <h3><span translate="">Setup</span> {{provider.name}}</h3>

                                    <div class="form-group" ng-repeat="(key, value) in provider.fields">
                                        <label class="col-sm-3 control-label" for="field"><span translate="">{{value.label || key}}:</span></label>
                                        <div class="col-sm-9">
                                            <input type="{{value.type || 'text'}}" class="form-control" id="field" placeholder="{{value.hint || ('Enter ' + key)}}" ng-model="settings[provider.name][key]">
                                            <p class="help-block" ng-show="!!value.hint"><span translate="">{{value.hint}}</span></p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" ng-model="settings[provider.name].enabled"> <span translate="">Processor Enabled</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="box-footer with-border">
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-primary"><span translate="">Save changes</span> <i class="fa fa-fw fa-angle-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>
