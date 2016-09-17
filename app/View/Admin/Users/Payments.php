<div class="container-fluid ng-cloak" ng-app="paymentListApp" ng-controller="paymentListController as mainCtrl" ng-init="init()">
    <div>
        <h4 class="pull-left"><span translate="">Recent payments</span></h4>
        <a class="pull-right btn btn-flat btn-default btn-sm" ng-href="/admin/payments/edit?user_id={{session.params.user_id}}" target="_top">
            <i class="fa fa-plus"></i> <span translate="">Add payment</span>
        </a>
        <div class="clearfix"></div>
    </div>

    <div class="list-group">
        <div class="list-group-item list-group-item-bar list-group-item-bar-{{payment.amount > 0 && 'success' || 'danger'}}"
             ng-repeat="payment in payments">
            <div class="pull-left">
                <h4 class="list-group-item-heading"><b>{{payment.amount | currency}}</b>: {{payment.payment_for | ucfirst}}</h4>
                <p class="list-group-item-text hidden-xs">
                    <span translate="">Created:</span> {{payment.created_at | timeAgo}}
                </p>
            </div>
            <div class="md-actions pull-right">
                <a class="btn btn-default btn-flat btn-sm" ng-href="/admin/payments/edit/{{payment.payment_id}}" target="_top"><i class="fa fa-edit"></i> <span translate="">edit..</span></a>
                <a class="btn btn-default btn-flat btn-sm" ng-click="payment.removeConfirm()"><i class="fa fa-pencil-square-o"></i> <span translate="">remove</span></a>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-md-6 col-md-push-6">
            <minute-pager class="pull-right" on="payments" no-results="{{'No payments found' | translate}}"></minute-pager>
        </div>
        <div class="col-xs-12 col-md-6 col-md-pull-6">
            <minute-search-bar on="payments" columns="amount, payment_for" label="{{'Search payment..' | translate}}"></minute-search-bar>
        </div>
    </div>
</div>
