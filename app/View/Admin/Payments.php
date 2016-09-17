<div class="content-wrapper ng-cloak" ng-app="paymentListApp" ng-controller="paymentListController as mainCtrl" ng-init="init()">
    <div class="admin-content">
        <section class="content-header">
            <h1><span translate="">List of payments</span> <small><span translate="">(verified transactions only)</span></small></h1>

            <ol class="breadcrumb">
                <li><a href="" ng-href="/admin"><i class="fa fa-dashboard"></i> <span translate="">Admin</span></a></li>
                <li class="active"><i class="fa fa-payment"></i> <span translate="">Payment list</span></li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <span translate="">All payments</span>
                    </h3>

                    <div class="box-tools">
                        <a class="btn btn-sm btn-primary btn-flat" ng-href="/admin/payments/edit">
                            <i class="fa fa-plus-circle"></i> <span translate="">Insert a payment manually</span>
                        </a>
                    </div>
                </div>

                <div class="box-body">
                    <div class="list-group">
                        <div class="list-group-item list-group-item-bar list-group-item-bar-{{payment.amount > 0 && 'success text-success' || 'danger text-danger'}}"
                             ng-repeat="payment in payments" ng-click-container="mainCtrl.actions(payment)">
                            <div class="pull-left">
                                <h4 class="list-group-item-heading"><b>{{payment.amount | currency }}</b> <small>({{payment.payment_for | ucfirst}})</small></h4>
                                <p class="list-group-item-text hidden-xs">
                                    <span translate="">Created by:</span>
                                    <a ng-href="/admin/users/details/{{payment.user_id}}#/payments" target="_blank">{{payment.user.first_name || payment.user.email || 'Anonymous'}}</a>
                                    {{payment.created_at | timeAgo}}
                                </p>
                                <p class="list-group-item-text hidden-xs" ng-show="!!payment.log.payment_log_id">
                                    <span translate="">Transaction Id: </span> {{payment.log.transaction_id}}.
                                    <span translate="">Subscription Id: </span> {{payment.log.subscription_id}}.
                                    <span translate="">Payment status: </span> {{payment.log.status}}.
                                </p>
                            </div>
                            <div class="md-actions pull-right">
                                <a class="btn btn-default btn-flat btn-sm" ng-href="/admin/payments/edit/{{payment.payment_id}}">
                                    <i class="fa fa-pencil-square-o"></i> <span translate="">Edit..</span>
                                </a>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <div class="row">
                        <div class="col-xs-12 col-md-6 col-md-push-6">
                            <minute-pager class="pull-right" on="payments" no-results="{{'No payments found' | translate}}"></minute-pager>
                        </div>
                        <div class="col-xs-12 col-md-6 col-md-pull-6">
                            <minute-search-bar on="payments" columns="payment_for, amount, user.first_name, user.last_name, user.email, log.transaction_id, log.subscription_id"
                                               label="{{'Search payment..' | translate}}"></minute-search-bar>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
