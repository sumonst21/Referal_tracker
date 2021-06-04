<!-- Invoice - Due-->
<div class="col-lg-3 col-md-6">
    <div class="card">
        <div class="card-body p-l-15 p-r-15">
            <div class="d-flex p-10 no-block">
                <span class="align-slef-center card-3">
                    <h2 class="m-b-0">{{ runtimeMoneyFormat($payload['invoices']['due']) }}</h2>
                    <h6 class="text-warning m-b-0">{{ cleanLang(__('lang.invoices')) }} - <br>{{ cleanLang(__('lang.due')) }}</h6>
                </span>
                <div class="align-self-center display-6 ml-auto bg-warning"><i class="mdi mdi-account-card-details text-white icon-lg"></i></div>
            </div>
        </div>
        <div class="progress">
            <div class="progress-bar bg-warning w-100 h-px-3" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                aria-valuemax="100"></div>
        </div>
    </div>
</div>