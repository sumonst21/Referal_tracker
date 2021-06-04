        <!--HEADER-->
        <div>
            <span class="pull-left">
                <h3><b><?php echo e(cleanLang(__('lang.invoice'))); ?></b>
                    <!--recurring icon-->
                    <?php if(auth()->user()->is_team): ?>
                    <i class="sl-icon-refresh text-danger cursor-pointer <?php echo e(runtimeVisibility('invoice-recurring-icon', $bill->bill_recurring)); ?>"
                        data-toggle="tooltip" id="invoice-recurring-icon" title="<?php echo e(cleanLang(__('lang.recurring_invoice'))); ?>"></i>
                    <!--child invoice-->
                    <?php if($bill->bill_recurring_child == 'yes'): ?>
                    <a href="<?php echo e(url('invoices/'.$bill->bill_recurring_parent_id)); ?>">
                        <i class="ti-back-right text-success" data-toggle="tooltip" data-html="true"
                            title="<?php echo e(cleanLang(__('lang.invoice_automatically_created_from_recurring'))); ?> <br>(#<?php echo e(runtimeInvoiceIdFormat($bill->bill_recurring_parent_id)); ?>)"></i>
                    </a>
                    <?php endif; ?>
                    <?php endif; ?>
                </h3>
                <span>
                    <h5>#<?php echo e($bill->formatted_bill_invoiceid); ?></h5>
                </span>
            </span>
            <!--status-->
            <span class="pull-right">
                <!--draft-->
                <span class="js-invoice-statuses <?php echo e(runtimeInvoiceStatus('draft', $bill->bill_status)); ?>"
                    id="invoice-status-draft">
                    <h1 class="text-uppercase <?php echo e(runtimeInvoiceStatusColors('draft', 'text')); ?> muted"><?php echo e(cleanLang(__('lang.draft'))); ?></h1>
                </span>
                <!--due-->
                <span class="js-invoice-statuses <?php echo e(runtimeInvoiceStatus('due', $bill->bill_status)); ?>"
                    id="invoice-status-due">
                    <h1 class="text-uppercase <?php echo e(runtimeInvoiceStatusColors('due', 'text')); ?>"><?php echo e(cleanLang(__('lang.due'))); ?></h1>
                </span>
                <!--overdue-->
                <span class="js-invoice-statuses <?php echo e(runtimeInvoiceStatus('overdue', $bill->bill_status)); ?>"
                    id="invoice-status-overdue">
                    <h1 class="text-uppercase <?php echo e(runtimeInvoiceStatusColors('overdue', 'text')); ?>"><?php echo e(cleanLang(__('lang.overdue'))); ?></h1>
                </span>
                <!--paid-->
                <span class="js-invoice-statuses <?php echo e(runtimeInvoiceStatus('paid', $bill->bill_status)); ?>"
                    id="invoice-status-paid">
                    <h1 class="text-uppercase <?php echo e(runtimeInvoiceStatusColors('paid', 'text')); ?>"><?php echo e(cleanLang(__('lang.paid'))); ?></h1>
                </span>
            </span>
        </div><?php /**PATH /var/www/html/application/resources/views/pages/bill/components/elements/invoice/header-web.blade.php ENDPATH**/ ?>