<div class="content-wrapper ng-cloak" ng-app="paymentEditApp" ng-controller="paymentEditController as mainCtrl" ng-init="init()">
    <div class="admin-content" minute-hot-keys="{'ctrl+s':mainCtrl.save}">
        <section class="content-header">
            <h1>
                <span translate="" ng-show="!payment.payment_id">Create new</span>
                <span translate="" ng-show="!!payment.payment_id">Edit</span>
                <span translate="">payment</span>
            </h1>

            <ol class="breadcrumb">
                <li><a href="" ng-href="/admin"><i class="fa fa-dashboard"></i> <span translate="">Admin</span></a></li>
                <li><a href="" ng-href="/admin/payments"><i class="fa fa-payment"></i> <span translate="">Payments</span></a></li>
                <li class="active"><i class="fa fa-edit"></i> <span translate="">Edit payment</span></li>
            </ol>
        </section>

        <section class="content">
            <form class="form-horizontal" name="paymentForm" ng-submit="mainCtrl.save()">
                <div class="box box-{{paymentForm.$valid && 'success' || 'danger'}}">
                    <div class="box-header with-border">
                        <span translate="" ng-show="!payment.payment_id">New payment</span>
                        <span ng-show="!!payment.payment_id"><span translate="">Edit payment</span></span>
                    </div>

                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="user_id"><span translate="">User Id:</span></label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="user_id" placeholder="Enter User Id" ng-model="payment.user_id" ng-required="true">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="amount"><span translate="">Amount:</span></label>
                            <div class="col-sm-10">
                                <input type="number" step="0.01" class="form-control" id="amount" placeholder="Enter Amount" ng-model="payment.amount" ng-required="true">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="payment_for"><span translate="">Payment for:</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="payment_for" placeholder="Enter Payment for" ng-model="payment.payment_for" ng-required="false">
                            </div>
                        </div>

                    </div>

                    <div class="box-footer with-border">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-flat btn-primary">
                                    <span translate="" ng-show="!payment.payment_id">Create</span>
                                    <span translate="" ng-show="!!payment.payment_id">Update</span>
                                    <span translate="">payment</span>
                                    <i class="fa fa-fw fa-angle-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>
