                <!-- Nav tabs -->
                <ul class="nav nav-tabs profile-tab" role="tablist">
                    <!--timeline-->
                    <li class="nav-item" id="first-ul-click">
                        <a class="nav-link first-ul-click tabs-menu-item <?php echo e($page['tabmenu_timeline'] ?? ''); ?>"
                            href="<?php echo e(url('clients')); ?>/<?php echo e($client->client_id); ?>" role="tab"><?php echo e(cleanLang(__('lang.activity'))); ?></a>
                    </li>
                    <!--contacts-->
                    <li class="nav-item">
                        <a class="nav-link  tabs-menu-item js-dynamic-url js-ajax-ux-request <?php echo e($page['tabmenu_contacts'] ?? ''); ?>"
                            data-toggle="tab" data-loading-class="loading-tabs" data-loading-target="embed-content-container" id="tabs-menu-contacts"
                            data-dynamic-url="<?php echo e(url('clients')); ?>/<?php echo e($client->client_id); ?>/contacts"
                            data-url="<?php echo e(url('/contacts')); ?>?contactresource_type=client&contactresource_id=<?php echo e($client->client_id); ?>&source=ext&page=1"
                            href="#clients_ajaxtab" role="tab"><?php echo e(cleanLang(__('lang.users'))); ?></a>
                    </li>
                    <!--projects-->
                    <li class="nav-item">
                        <a class="nav-link tabs-menu-item js-dynamic-url js-ajax-ux-request <?php echo e($page['tabmenu_projects'] ?? ''); ?>"
                            data-toggle="tab" data-loading-class="loading-tabs" id="tabs-menu-projects" data-loading-target="embed-content-container"
                            data-dynamic-url="<?php echo e(url('clients')); ?>/<?php echo e($client->client_id); ?>/projects"
                            data-url="<?php echo e(url('/projects')); ?>?projectresource_type=client&projectresource_id=<?php echo e($client->client_id); ?>&source=ext&page=1"
                            href="#clients_ajaxtab" role="tab"><?php echo e(cleanLang(__('lang.projects'))); ?></a>
                    </li>
                    <!--files-->
                    <li class="nav-item dropdown <?php echo e($page['tabmenu_files'] ?? ''); ?>">
                        <a class="nav-link dropdown-toggle tabs-menu-item tabs-menu-item" data-toggle="dropdown"
                            id="tabs-menu-files" href="javascript:void(0)" role="button" aria-haspopup="true"
                            aria-expanded="false">
                            <span class="hidden-xs-down"><?php echo e(cleanLang(__('lang.files'))); ?></span>
                        </a>
                        <div class="dropdown-menu" x-placement="bottom-start" id="fx-client-misc-topnave-files">
                            <!--[project file]-->
                            <a class="dropdown-item js-dynamic-url  js-ajax-ux-request <?php echo e($page['tabmenu_invoices'] ?? ''); ?>"
                                data-toggle="tab" data-loading-class="loading-tabs" data-loading-target="embed-content-container"
                                data-dynamic-url="<?php echo e(url('/client')); ?>/<?php echo e($client->client_id); ?>/project-files"
                                data-url="<?php echo e(url('/files')); ?>?fileresource_type=project&filter_file_clientid=<?php echo e($client->client_id); ?>&source=ext&page=1"
                                href="#projects_ajaxtab" role="tab"><?php echo e(cleanLang(__('lang.project_files'))); ?></a>
                            <!--[client files]-->
                            <a class="dropdown-item js-dynamic-url  js-ajax-ux-request <?php echo e($page['tabmenu_invoices'] ?? ''); ?>"
                                data-toggle="tab" data-loading-class="loading-tabs" data-loading-target="embed-content-container"
                                data-dynamic-url="<?php echo e(url('/client')); ?>/<?php echo e($client->client_id); ?>/client-files"
                                data-url="<?php echo e(url('/files')); ?>?source=ext&page=1&fileresource_id=<?php echo e($client->client_id); ?>&fileresource_type=client"
                                href="#projects_ajaxtab" role="tab"><?php echo e(cleanLang(__('lang.client_files'))); ?></a>
                        </div>
                    </li>
                    <!--tickets-->
                    <li class="nav-item">
                        <a class="nav-link  tabs-menu-item js-dynamic-url js-ajax-ux-request <?php echo e($page['tabmenu_tickets'] ?? ''); ?>"
                            id="tabs-menu-tickets" data-toggle="tab" data-loading-class="loading-tabs" data-loading-target="embed-content-container"
                            data-dynamic-url="<?php echo e(url('clients')); ?>/<?php echo e($client->client_id); ?>/tickets"
                            data-url="<?php echo e(url('/tickets')); ?>?ticketresource_type=client&ticketresource_id=<?php echo e($client->client_id); ?>&source=ext&page=1"
                            href="#clients_ajaxtab" role="tab"><?php echo e(cleanLang(__('lang.tickets'))); ?></a></li>
                    <!--contracts-->
                    <li class="nav-item hidden">
                        <a class="nav-link tabs-menu-item js-dynamic-url js-ajax-ux-request <?php echo e($page['tabmenu_projects'] ?? ''); ?>"
                            data-toggle="tab" data-loading-class="loading-tabs" id="tabs-menu-contracts" data-loading-target="embed-content-container"
                            data-dynamic-url="<?php echo e(url('clients')); ?>/<?php echo e($client->client_id); ?>/projects"
                            data-url="<?php echo e(url('/contracts')); ?>?type=client&id=<?php echo e($client->client_id); ?>&source=ext&page=1"
                            href="#clients_ajaxtab" role="tab"><?php echo e(cleanLang(__('lang.contracts'))); ?></a>
                    </li>
                    <!--billing-->
                    <li class="nav-item dropdown <?php echo e($page['tabmenu_financial'] ?? ''); ?>">
                        <a class="nav-link dropdown-toggle tabs-menu-item tabs-menu-item" data-toggle="dropdown"
                            id="tabs-menu-billing" href="javascript:void(0)" role="button" aria-haspopup="true"
                            id="tabs-menu-billing" aria-expanded="false">
                            <span class="hidden-xs-down"><?php echo e(cleanLang(__('lang.financial'))); ?></span>
                        </a>
                        <div class="dropdown-menu" x-placement="bottom-start" id="fx-client-misc-topnave-billing">
                            <!--[invoices]-->
                            <a class="dropdown-item js-dynamic-url  js-ajax-ux-request <?php echo e($page['tabmenu_invoices'] ?? ''); ?>"
                                data-toggle="tab" data-loading-class="loading-tabs" data-loading-target="embed-content-container"
                                data-dynamic-url="<?php echo e(url('/clients')); ?>/<?php echo e($client->client_id); ?>/invoices"
                                data-url="<?php echo e(url('/invoices')); ?>?source=ext&page=1&invoiceresource_id=<?php echo e($client->client_id); ?>&invoiceresource_type=client"
                                href="#projects_ajaxtab" role="tab"><?php echo e(cleanLang(__('lang.invoices'))); ?></a>
                            <!--[payments]-->
                            <a class="dropdown-item js-dynamic-url  js-ajax-ux-request <?php echo e($page['tabmenu_invoices'] ?? ''); ?>"
                                data-toggle="tab" data-loading-class="loading-tabs" data-loading-target="embed-content-container"
                                data-dynamic-url="<?php echo e(url('/clients')); ?>/<?php echo e($client->client_id); ?>/payments"
                                data-url="<?php echo e(url('/payments')); ?>?source=ext&page=1&paymentresource_id=<?php echo e($client->client_id); ?>&paymentresource_type=client"
                                href="#projects_ajaxtab" role="tab"><?php echo e(cleanLang(__('lang.payments'))); ?></a>
                            <!--[expenses]-->
                            <a class="dropdown-item js-dynamic-url  js-ajax-ux-request <?php echo e($page['tabmenu_invoices'] ?? ''); ?>"
                                data-toggle="tab" data-loading-class="loading-tabs" data-loading-target="embed-content-container"
                                data-dynamic-url="<?php echo e(url('/clients')); ?>/<?php echo e($client->client_id); ?>/expenses"
                                data-url="<?php echo e(url('/expenses')); ?>?source=ext&page=1&expenseresource_id=<?php echo e($client->client_id); ?>&expenseresource_type=client"
                                href="#projects_ajaxtab" role="tab"><?php echo e(cleanLang(__('lang.expenses'))); ?></a>
                            <!--[estimates]-->
                            <a class="dropdown-item js-dynamic-url  js-ajax-ux-request <?php echo e($page['tabmenu_invoices'] ?? ''); ?>"
                                data-toggle="tab" data-loading-class="loading-tabs" data-loading-target="embed-content-container"
                                data-dynamic-url="<?php echo e(url('/clients')); ?>/<?php echo e($client->client_id); ?>/estimates"
                                data-url="<?php echo e(url('/estimates')); ?>?source=ext&page=1&estimateresource_id=<?php echo e($client->client_id); ?>&estimateresource_type=client"
                                href="#projects_ajaxtab" role="tab"><?php echo e(cleanLang(__('lang.estimates'))); ?></a>
                            <!--[timesheets]-->
                            <a class="dropdown-item js-dynamic-url  js-ajax-ux-request <?php echo e($page['tabmenu_timesheets'] ?? ''); ?>"
                                data-toggle="tab" data-loading-class="loading-tabs" data-loading-target="embed-content-container"
                                data-dynamic-url="<?php echo e(url('/clients')); ?>/<?php echo e($client->client_id); ?>/timesheets"
                                data-url="<?php echo e(url('/timesheets')); ?>?source=ext&page=1&timesheetresource_id=<?php echo e($client->client_id); ?>&timesheetresource_type=client"
                                href="#projects_ajaxtab" role="tab"><?php echo e(cleanLang(__('lang.timesheets'))); ?></a>
                        </div>
                    </li>

                    <!--notes-->
                    <li class="nav-item">
                        <a class="nav-link notes_class tabs-menu-item js-dynamic-url js-ajax-ux-request <?php echo e($page['tabmenu_notes'] ?? ''); ?>"
                            id="tabs-menu-notes" data-toggle="tab" data-loading-class="loading-tabs" data-loading-target="embed-content-container"
                            data-dynamic-url="<?php echo e(url('clients')); ?>/<?php echo e($client->client_id); ?>/notes"
                            data-url="<?php echo e(url('/notes')); ?>?source=ext&page=1&noteresource_type=client&noteresource_id=<?php echo e($client->client_id); ?>"
                            href="#clients_ajaxtab" role="tab"><?php echo e(cleanLang(__('lang.notes'))); ?></a>
                    </li>

                    <!--goals-->
                    <li class="nav-item">
                        <a class="nav-link  tabs-menu-item js-dynamic-url js-ajax-ux-request <?php echo e($page['tabmenu_goals'] ?? ''); ?>"
                            id="tabs-menu-goals" data-toggle="tab" data-loading-class="loading-tabs" data-loading-target="embed-content-container"
                            data-dynamic-url="<?php echo e(url('clients')); ?>/<?php echo e($client->client_id); ?>/goals"
                            data-url="<?php echo e(url('/goals')); ?>?source=ext&page=1&goalresource_type=client&goalresource_id=<?php echo e($client->client_id); ?>"
                            href="#clients_ajaxtab" role="tab"><?php echo e(cleanLang(__('lang.goals'))); ?></a>
                    </li>

                    <!--tasks-->
                    <li class="nav-item">
                        <a class="nav-link  tabs-menu-item js-dynamic-url js-ajax-ux-request <?php echo e($page['tabmenu_tasks'] ?? ''); ?>"
                            id="tabs-menu-task" data-toggle="tab" data-loading-class="loading-tabs" data-loading-target="embed-content-container"
                            data-dynamic-url="<?php echo e(url('clients')); ?>/<?php echo e($client->client_id); ?>/client_tasks"
                            data-url="<?php echo e(url('/client_tasks')); ?>?source=ext&page=1&client_tasksresource_type=client&client_tasksresource_id=<?php echo e($client->client_id); ?>"
                            href="#clients_ajaxtab" role="tab"><?php echo e(cleanLang(__('lang.tasks'))); ?></a>
                    </li>

                    <!--reminder-->
                    <li class="nav-item">
                        <a class="nav-link  tabs-menu-item js-dynamic-url js-ajax-ux-request <?php echo e($page['tabmenu_reminders'] ?? ''); ?>"
                            id="tabs-menu-reminders" data-toggle="tab" data-loading-class="loading-tabs" data-loading-target="embed-content-container"
                            data-dynamic-url="<?php echo e(url('clients')); ?>/<?php echo e($client->client_id); ?>/reminders"
                            data-url="<?php echo e(url('/reminders')); ?>?source=ext&page=1&reminderresource_type=client&reminderresource_id=<?php echo e($client->client_id); ?>"
                            href="#clients_ajaxtab" role="tab"><?php echo e(cleanLang(__('lang.reminders'))); ?></a>
                    </li>

                </ul>

               <!--  <script type="text/javascript">
                    if(localStorage.getItem('login') == '1')
                    {
                        //console.log('M HERE');
                        
                        setTimeout(function(){ 
                            //console.log('note tab open');
                            $('#tabs-menu-notes').click();
                            setTimeout(function(){ 
                               // console.log('note popup open');
                                $('#commonModal').css('opacity','0');
                                $('.action-class-notes').click();
                                setTimeout(function(){ 
                                   // console.log('note popup close');
                                    $('#commonModalExtraCloseIcon').click();
                                    $('#commonModal').css('opacity','1');
                                    setTimeout(function(){ 
                                        localStorage.setItem('login','0');
                                        // $(".first-ul-click").addClass('active');
                                        // window.location.href = $(".first-ul-click").attr('href');
                                        // $(".notes_class").removeClass('active')
                                        //$('#first-ul-click a').click();
                                    }, 1600);
                                }, 1400);
                            }, 1200);
                        }, 1000);
                    }
                    else
                    {
                      //alert('Not lolpen');
                    }
                </script> --><?php /**PATH /var/www/html/application/resources/views/pages/client/components/misc/topnav.blade.php ENDPATH**/ ?>