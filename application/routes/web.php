<?php

//TESTING [DEV]
Route::get("test", "Test@index");
Route::post("test", "Test@index");

//HOME PAGE
Route::any('/', function () {
    return redirect('/home');
});
Route::any('home', 'Home@index')->name('home');

//LOGIN & SIGNUP
Route::get("/login", "Authenticate@logIn")->name('login');
Route::post("/login", "Authenticate@logInAction");
Route::get("/forgotpassword", "Authenticate@forgotPassword");
Route::post("/forgotpassword", "Authenticate@forgotPasswordAction");
Route::get("/signup", "Authenticate@signUp");
Route::post("/signup", "Authenticate@signUpAction");
Route::get("/resetpassword", "Authenticate@resetPassword");
Route::post("/resetpassword", "Authenticate@resetPasswordAction");

//LOGOUT
Route::any('logout', function () {
    Auth::logout();
    return redirect('/login');
});

//CLIENTS
Route::group(['prefix' => 'clients'], function () {
    Route::any("/search", "Clients@index");
    Route::post("/delete", "Clients@destroy")->middleware(['demoModeCheck']);
    Route::get("/change-category", "Clients@changeCategory");
    Route::post("/change-category", "Clients@changeCategoryUpdate");
    Route::get("/logo", "Clients@logo");
    Route::put("/logo", "Clients@updateLogo")->middleware(['demoModeCheck']);

    //dynamic load
    Route::any("/{client}/{section}", "Clients@showDynamic")
        ->where(['client' => '[0-9]+', 'section' => 'contacts|projects|files|tickets|invoices|expenses|payments|timesheets|estimates|notes']);
});
Route::any("/client/{x}/profile", "Clients@profile")->where('x', '[0-9]+');
Route::resource('clients', 'Clients');

//CONTACTS
Route::group(['prefix' => 'contacts'], function () {
    Route::any("/search", "Contacts@index");
    Route::get("/updatepreferences", "Contacts@updatePreferences");
    Route::post("/delete", "Contacts@destroy")->middleware(['demoModeCheck']);
});
Route::resource('contacts', 'Contacts');
Route::resource('users', 'Contacts');

//TEAM
Route::group(['prefix' => 'team'], function () {
    Route::any("/search", "Team@index");
    Route::get("/updatepreferences", "Team@updatePreferences");
});
Route::resource('team', 'Team');

//SETTINGS - USER
Route::group(['prefix' => 'user'], function () {
    Route::get("/avatar", "User@avatar");
    Route::put("/avatar", "User@updateAvatar")->middleware(['demoModeCheck']);
    Route::get("/notifications", "User@notifications");
    Route::put("/notifications", "User@updateNotifications");
    Route::get("/updatepassword", "User@updatePassword");
    Route::put("/updatepassword", "User@updatePasswordAction")->middleware(['demoModeCheck']);
    Route::get("/updatenotifications", "User@updateNotifications");
    Route::put("/updatenotifications", "User@updateNotificationsAction")->middleware(['demoModeCheck']);
    Route::post("/updatelanguage", "User@updateLanguage");
});

//INVOICES
Route::group(['prefix' => 'invoices'], function () {
    Route::any("/search", "Invoices@index");
    Route::post("/delete", "Invoices@destroy")->middleware(['demoModeCheck']);
    Route::get("/change-category", "Invoices@changeCategory");
    Route::post("/change-category", "Invoices@changeCategoryUpdate");
    Route::get("/add-payment", "Invoices@addPayment");
    Route::post("/add-payment", "Invoices@addPayment");
    Route::get("/{invoice}/clone", "Invoices@createClone")->where('invoice', '[0-9]+');
    Route::post("/{invoice}/clone", "Invoices@storeClone")->where('invoice', '[0-9]+');
    Route::get("/{invoice}/stop-recurring", "Invoices@stopRecurring")->where('invoice', '[0-9]+');
    Route::get("/{invoice}/attach-project", "Invoices@attachProject")->where('invoice', '[0-9]+');
    Route::post("/{invoice}/attach-project", "Invoices@attachProjectUpdate")->where('invoice', '[0-9]+');
    Route::get("/{invoice}/detach-project", "Invoices@dettachProject")->where('invoice', '[0-9]+');
    Route::get("/{invoice}/email-client", "Invoices@emailClient")->where('invoice', '[0-9]+');
    Route::get("/{invoice}/download-pdf", "Invoices@downloadPDF")->where('invoice', '[0-9]+');
    Route::get("/{invoice}/recurring-settings", "Invoices@recurringSettings")->where('invoice', '[0-9]+');
    Route::post("/{invoice}/recurring-settings", "Invoices@recurringSettingsUpdate")->where('invoice', '[0-9]+');
    Route::get("/{invoice}/edit-invoice", "Invoices@show")->where('invoice', '[0-9]+')->middleware(['invoicesMiddlewareEdit', 'invoicesMiddlewareShow']);
    Route::post("/{invoice}/edit-invoice", "Invoices@saveInvoice")->where('invoice', '[0-9]+');
    Route::get("/{invoice}/pdf", "Invoices@show")->where('invoice', '[0-9]+')->middleware(['invoicesMiddlewareShow']);
    Route::get("/{invoice}/publish", "Invoices@publishInvoice")->where('invoice', '[0-9]+')->middleware(['invoicesMiddlewareEdit', 'invoicesMiddlewareShow']);
    Route::get("/{invoice}/resend", "Invoices@resendInvoice")->where('invoice', '[0-9]+')->middleware(['invoicesMiddlewareEdit', 'invoicesMiddlewareShow']);
    Route::get("/{invoice}/stripe-payment", "Invoices@paymentStripe")->where('invoice', '[0-9]+');
    Route::get("/{invoice}/paypal-payment", "Invoices@paymentPaypal")->where('invoice', '[0-9]+');
    Route::get("/timebilling/{project}/", "Timebilling@index")->where('project', '[0-9]+');
    Route::get("/{invoice}/razorpay-payment", "Invoices@paymentRazorpay")->where('invoice', '[0-9]+');
});
Route::resource('invoices', 'Invoices');

//SUBSCRIPTIONS
Route::group(['prefix' => 'subscriptions'], function () {
    Route::any("/search", "Subscriptions@index");
    Route::post("/delete", "Subscriptions@destroy")->middleware(['demoModeCheck']);
    Route::get("/change-category", "Subscriptions@changeCategory");
    Route::post("/change-category", "Subscriptions@changeCategoryUpdate");
    Route::get("/getprices", "Subscriptions@getProductPrices");
    Route::get("/{subscription}/invoices", "Subscriptions@subscriptionInvoices")->where('subscription', '[0-9]+');
    Route::get("/{subscription}/pay", "Subscriptions@setupStripePayment")->where('subscription', '[0-9]+');
    Route::get("/{subscription}/cancel", "Subscriptions@cancelSubscription")->where('subscription', '[0-9]+')->middleware(['demoModeCheck']);;
});
Route::resource('subscriptions', 'Subscriptions');

//ESTIMATES
Route::group(['prefix' => 'estimates'], function () {
    Route::any("/search", "Estimates@index");
    Route::post("/delete", "Estimates@destroy")->middleware(['demoModeCheck']);
    Route::get("/change-category", "Estimates@changeCategory");
    Route::post("/change-category", "Estimates@changeCategoryUpdate");
    Route::get("/{estimate}/attach-project", "Estimates@attachProject")->where('estimate', '[0-9]+');
    Route::post("/{estimate}/attach-project", "Estimates@attachProjectUpdate")->where('invoice', '[0-9]+');
    Route::get("/{estimate}/detach-project", "Estimates@dettachProject")->where('estimate', '[0-9]+');
    Route::get("/{estimate}/email-client", "Estimates@emailClient")->where('estimate', '[0-9]+');
    Route::get("/{estimate}/convert-to-invoice", "Estimates@convertToInvoice")->where('estimate', '[0-9]+');
    Route::get("/{estimate}/change-status", "Estimates@changeStatus")->where('estimate', '[0-9]+');
    Route::post("/{estimate}/change-status", "Estimates@changeStatusUpdate")->where('estimate', '[0-9]+');
    Route::get("/{estimate}/edit-estimate", "Estimates@show")->where('estimate', '[0-9]+')->middleware(['estimatesMiddlewareEdit', 'estimatesMiddlewareShow']);
    Route::post("/{estimate}/edit-estimate", "Estimates@saveEstimate")->where('estimate', '[0-9]+');
    Route::get("/{estimate}/pdf", "Estimates@show")->where('estimate', '[0-9]+')->middleware(['estimatesMiddlewareShow']);
    Route::get("/{estimate}/publish", "Estimates@publishEstimate")->where('estimate', '[0-9]+')->middleware(['estimatesMiddlewareEdit', 'estimatesMiddlewareShow']);
    Route::get("/{estimate}/publish-revised", "Estimates@publishRevisedEstimate")->where('estimate', '[0-9]+')->middleware(['estimatesMiddlewareEdit', 'estimatesMiddlewareShow']);
    Route::get("/{estimate}/resend", "Estimates@resendEstimate")->where('estimate', '[0-9]+')->middleware(['estimatesMiddlewareEdit', 'estimatesMiddlewareShow']);
    Route::get("/{estimate}/accept", "Estimates@acceptEstimate")->where('estimate', '[0-9]+');
    Route::get("/{estimate}/decline", "Estimates@declineEstimate")->where('estimate', '[0-9]+');

});
Route::resource('estimates', 'Estimates');

//PAYMENTS
Route::group(['prefix' => 'payments'], function () {
    Route::any("/search", "Payments@index");
    Route::post("/delete", "Payments@destroy")->middleware(['demoModeCheck']);
    Route::get("/change-category", "Payments@changeCategory");
    Route::post("/change-category", "Payments@changeCategoryUpdate");
    Route::any("/v/{payment}", "Payments@index")->where('payment', '[0-9]+');
    Route::any("/thankyou", "Payments@thankYou");
    Route::post("/thankyou/razorpay", "Payments@thankYouRazorpay");
});
Route::resource('payments', 'Payments');

//ITEMS
Route::group(['prefix' => 'items'], function () {
    Route::any("/search", "Items@index");
    Route::post("/delete", "Items@destroy")->middleware(['demoModeCheck']);
    Route::get("/change-category", "Items@changeCategory");
    Route::post("/change-category", "Items@changeCategoryUpdate");
});
Route::resource('items', 'Items');

//PRODUCTS (same as items above)
Route::group(['prefix' => 'products'], function () {
    Route::any("/search", "Items@index");
    Route::post("/delete", "Items@destroy")->middleware(['demoModeCheck']);
    Route::get("/change-category", "Items@changeCategory");
    Route::post("/change-category", "Items@changeCategoryUpdate");
});
Route::resource('products', 'Items');

//EXPENSES
Route::group(['prefix' => 'expenses'], function () {
    Route::any("/search", "Expenses@index");
    Route::get("/attachments/download/{uniqueid}", "Expenses@downloadAttachment");
    Route::delete("/attachments/{uniqueid}", "Expenses@deleteAttachment")->middleware(['demoModeCheck']);
    Route::post("/delete", "Expenses@destroy")->middleware(['demoModeCheck']);
    Route::get("/{expense}/attach-dettach", "Expenses@attachDettach")->where('invoice', '[0-9]+');
    Route::post("/{expense}/attach-dettach", "Expenses@attachDettachUpdate")->where('invoice', '[0-9]+');
    Route::get("/change-category", "Expenses@changeCategory");
    Route::post("/change-category", "Expenses@changeCategoryUpdate");
    Route::get("/{expense}/create-new-invoice", "Expenses@createNewInvoice")->where('expense', '[0-9]+');
    Route::post("/{expense}/create-new-invoice", "Expenses@createNewInvoice")->where('expense', '[0-9]+');
    Route::get("/{expense}/add-to-invoice", "Expenses@addToInvoice")->where('expense', '[0-9]+');
    Route::post("/{expense}/add-to-invoice", "Expenses@addToInvoice")->where('expense', '[0-9]+');
    Route::any("/v/{expense}", "Expenses@index")->where('expense', '[0-9]+');

});
Route::resource('expenses', 'Expenses');

//PROJECTS & PROJECT
Route::group(['prefix' => 'projects'], function () {
    Route::any("/search", "Projects@index");
    Route::post("/delete", "Projects@destroy")->middleware(['demoModeCheck']);
    Route::get("/change-category", "Projects@changeCategory");
    Route::post("/change-category", "Projects@changeCategoryUpdate");
    Route::get("/{project}/change-status", "Projects@changeStatus")->where('project', '[0-9]+');
    Route::post("/{project}/change-status", "Projects@changeStatusUpdate")->where('project', '[0-9]+');
    Route::get("/{project}/project-details", "Projects@details")->where('project', '[0-9]+');
    Route::post("/{project}/project-details", "Projects@updateDescription")->where('project', '[0-9]+');
    Route::put("/{project}/stop-all-timers", "Projects@stopAllTimers")->where('project', '[0-9]+');
    Route::put("/{project}/archive", "Projects@archive")->where('project', '[0-9]+');
    Route::put("/{project}/activate", "Projects@activate")->where('project', '[0-9]+');

    //dynamic load
    Route::any("/{project}/{section}", "Projects@showDynamic")
        ->where(['project' => '[0-9]+', 'section' => 'details|comments|files|tasks|invoices|payments|timesheets|expenses|estimates|milestones|tickets|notes']);
});
Route::resource('projects', 'Projects');

//TASKS
Route::group(['prefix' => 'tasks'], function () {
    Route::any("/search", "Tasks@index");
    Route::any("/timer/{id}/start", "Tasks@timerStart")->where('id', '[0-9]+');
    Route::any("/timer/{id}/stop", "Tasks@timerStop")->where('id', '[0-9]+');
    Route::any("/timer/{id}/stopall", "Tasks@timerStopAll")->where('id', '[0-9]+');
    Route::post("/delete", "Tasks@destroy")->middleware(['demoModeCheck']);
    Route::post("/{task}/toggle-status", "Tasks@toggleStatus")->where('task', '[0-9]+');
    Route::post("/{task}/update-description", "Tasks@updateDescription")->where('task', '[0-9]+');
    Route::post("/{task}/attach-files", "Tasks@attachFiles")->where('task', '[0-9]+');
    Route::delete("/delete-attachment/{uniqueid}", "Tasks@deleteAttachment")->middleware(['demoModeCheck']);
    Route::get("/download-attachment/{uniqueid}", "Tasks@downloadAttachment");
    Route::post("/{task}/post-comment", "Tasks@storeComment")->where('task', '[0-9]+');
    Route::delete("/delete-comment/{commentid}", "Tasks@deleteComment")->where('commentid', '[0-9]+');
    Route::post("/{task}/update-title", "Tasks@updateTitle")->where('task', '[0-9]+');
    Route::post("/{task}/add-checklist", "Tasks@storeChecklist")->where('task', '[0-9]+');
    Route::post("/update-checklist/{checklistid}", "Tasks@updateChecklist")->where('checklistid', '[0-9]+');
    Route::delete("/delete-checklist/{checklistid}", "Tasks@deleteChecklist")->where('checklistid', '[0-9]+');
    Route::post("/toggle-checklist-status/{checklistid}", "Tasks@toggleChecklistStatus")->where('checklistid', '[0-9]+');
    Route::post("/{task}/update-start-date", "Tasks@updateStartDate")->where('task', '[0-9]+');
    Route::post("/{task}/update-due-date", "Tasks@updateDueDate")->where('task', '[0-9]+');
    Route::post("/{task}/update-status", "Tasks@updateStatus")->where('task', '[0-9]+');
    Route::post("/{task}/update-priority", "Tasks@updatePriority")->where('task', '[0-9]+');
    Route::post("/{task}/update-visibility", "Tasks@updateVisibility")->where('task', '[0-9]+');
    Route::post("/{task}/update-milestone", "Tasks@updateMilestone")->where('task', '[0-9]+');
    Route::post("/{task}/update-assigned", "Tasks@updateAssigned")->where('task', '[0-9]+');
    Route::post("/update-position", "Tasks@updatePosition");
    Route::any("/v/{task}/{slug}", "Tasks@index")->where('task', '[0-9]+');
    Route::post("/{task}/update-custom", "Tasks@updateCustomFields")->where('task', '[0-9]+');
    Route::put("/{task}/archive", "tasks@archive")->where('task', '[0-9]+');
    Route::put("/{task}/activate", "tasks@activate")->where('task', '[0-9]+');

});
Route::resource('tasks', 'Tasks');

//LEADS & LEAD
Route::group(['prefix' => 'leads'], function () {
    Route::any("/search", "Leads@index");
    Route::any("/{lead}/details", "Leads@details")->where('lead', '[0-9]+');
    Route::post("/delete", "Leads@destroy")->middleware(['demoModeCheck']);
    Route::get("/change-category", "Leads@changeCategory");
    Route::post("/change-category", "Leads@changeCategoryUpdate");
    Route::get("/{lead}/change-status", "Leads@changeStatus")->where('lead', '[0-9]+');
    Route::post("/{lead}/change-status", "Leads@changeStatusUpdate")->where('lead', '[0-9]+');
    Route::post("/{lead}/update-description", "Leads@updateDescription")->where('lead', '[0-9]+');
    Route::post("/{lead}/attach-files", "Leads@attachFiles")->where('lead', '[0-9]+');
    Route::delete("/delete-attachment/{uniqueid}", "Leads@deleteAttachment");
    Route::get("/download-attachment/{uniqueid}", "Leads@downloadAttachment");
    Route::post("/{lead}/update-title", "Leads@updateTitle")->where('lead', '[0-9]+');
    Route::post("/{lead}/post-comment", "Leads@storeComment")->where('lead', '[0-9]+');
    Route::delete("/delete-comment/{commentid}", "Leads@deleteComment")->where('commentid', '[0-9]+');
    Route::post("/{lead}/add-checklist", "Leads@storeChecklist")->where('lead', '[0-9]+');
    Route::post("/update-checklist/{checklistid}", "Leads@updateChecklist")->where('checklistid', '[0-9]+');
    Route::delete("/delete-checklist/{checklistid}", "Leads@deleteChecklist")->where('checklistid', '[0-9]+');
    Route::post("/toggle-checklist-status/{checklistid}", "Leads@toggleChecklistStatus")->where('checklistid', '[0-9]+');
    Route::post("/{lead}/update-date-added", "Leads@updateDateAdded")->where('lead', '[0-9]+');
    Route::post("/{lead}/update-name", "Leads@updateName")->where('lead', '[0-9]+');
    Route::post("/{lead}/update-value", "Leads@updateValue")->where('lead', '[0-9]+');
    Route::post("/{lead}/update-status", "Leads@updateStatus")->where('lead', '[0-9]+');
    Route::post("/{lead}/update-category", "Leads@updateCategory")->where('lead', '[0-9]+');
    Route::post("/{lead}/update-contacted", "Leads@updateContacted")->where('lead', '[0-9]+');
    Route::post("/{lead}/update-phone", "Leads@updatePhone")->where('lead', '[0-9]+');
    Route::post("/{lead}/update-email", "Leads@updateEmail")->where('lead', '[0-9]+');
    Route::post("/{lead}/update-source", "Leads@updateSource")->where('lead', '[0-9]+');
    Route::post("/{lead}/update-organisation", "Leads@updateOrganisation")->where('lead', '[0-9]+');
    Route::post("/{lead}/update-assigned", "Leads@updateAssigned")->where('lead', '[0-9]+');
    Route::post("/update-position", "Leads@updatePosition");
    Route::post("/{lead}/convert-lead", "Leads@convertLead")->where('lead', '[0-9]+');
    Route::any("/v/{lead}/{slug}", "Leads@index")->where('lead', '[0-9]+');
    Route::post("/{lead}/update-custom", "Leads@updateCustomFields")->where('lead', '[0-9]+');
    Route::put("/{lead}/archive", "leads@archive")->where('lead', '[0-9]+');
    Route::put("/{lead}/activate", "leads@activate")->where('lead', '[0-9]+');

});
Route::resource('leads', 'Leads');

//TICKETS
Route::group(['prefix' => 'tickets'], function () {
    Route::any("/search", "Tickets@index");
    Route::get("/{x}/editdetails", "Tickets@editDetails")->where('x', '[0-9]+');
    Route::get("/{ticket}/reply", "Tickets@reply")->where('x', '[0-9]+');
    Route::post("/{ticket}/postreply", "Tickets@storeReply")->where('x', '[0-9]+');
    Route::post("/delete", "Tickets@destroy")->middleware(['demoModeCheck']);
    Route::get("/change-category", "Tickets@changeCategory");
    Route::post("/change-category", "Tickets@changeCategoryUpdate");
    Route::get("/attachments/download/{uniqueid}", "Tickets@downloadAttachment");
});
Route::resource('tickets', 'Tickets');

//REPORTS
Route::group(['prefix' => 'reports'], function () {
    Route::any("/", "Reports@index");
    Route::any("/search", "Reports@index");
});

//TIMELINE
Route::group(['prefix' => 'timeline'], function () {
    Route::any("/client", "Timeline@clientTimeline");
    Route::any("/project", "Timeline@projectTimeline");
});

//TIMESHEETS
Route::group(['prefix' => 'timesheets'], function () {
    Route::any("/my", "Timesheets@index");
    Route::any("/", "Timesheets@index");
    Route::any("/search", "Timesheets@index");
    Route::post("/delete", "Timesheets@destroy")->middleware(['demoModeCheck']);
});
Route::resource('timesheets', 'Timesheets');

//FILES
Route::group(['prefix' => 'files'], function () {
    Route::any("/search", "Files@index");
    Route::get("/getimage", "Files@showImage");
    Route::get("/download", "Files@download");
    Route::post("/delete", "Files@destroy")->middleware(['demoModeCheck']);
});
Route::resource('files', 'Files');

//NOTES
Route::group(['prefix' => 'notes'], function () {
    Route::any("/search", "Notes@index");
    Route::post("/delete", "Notes@destroy")->middleware(['demoModeCheck']);
});
Route::resource('notes', 'Notes');

//COMMENTS
Route::group(['prefix' => 'comments'], function () {
    Route::any("/search", "Comments@index");
    Route::post("/delete", "Comments@destroy")->middleware(['demoModeCheck']);
});
Route::resource('comments', 'Comments');

//AUTOCOMPLETE AJAX FEED
Route::group(['prefix' => 'feed'], function () {
    Route::get("/", "Feed@index");
    Route::get("/company_names", "Feed@companyNames");
    Route::get("/contacts", "Feed@contactNames");
    Route::get("/email", "Feed@emailAddress");
    Route::get("/tags", "Feed@tags");
    Route::get("/leads", "Feed@leads");
    Route::get("/projects", "Feed@projects");
    Route::get("/projectassigned", "Feed@projectAssignedUsers");
});

//PROJECTS & PROJECT
Route::group(['prefix' => 'feed'], function () {
    Route::any("/team", "Team@index"); //[TODO]  auth middleware
});

//MILESTONES
Route::group(['prefix' => 'milestones'], function () {
    Route::any("/search", "Milestones@index");
    Route::post("/update-positions", "Milestones@updatePositions");
});
Route::resource('milestones', 'Milestones');

//CATEGORIES
Route::group(['prefix' => 'categories'], function () {
    Route::any("/", "Categories@index");
});
Route::resource('categories', 'Categories');

//FILEUPLOAD
Route::post("/fileupload", "Fileupload@save");

//AVATAR FILEUPLOAD
Route::post("/avatarupload", "Fileupload@saveAvatar");

//CLIENT LOGO FILEUPLOAD
Route::post("/uploadlogo", "Fileupload@saveLogo");

//APP LOGO FILEUPLOAD
Route::post("/upload-app-logo", "Fileupload@saveAppLogo");

//TINYMCE IMAGE FILEUPLOAD
Route::post("/upload-tinymce-image", "Fileupload@saveTinyMCEImage");

//TAGS - GENERAL
Route::group(['prefix' => 'tags'], function () {
    Route::any("/search", "Tags@index");
});
Route::resource('tags', 'Tags');

//KNOWLEDGEBASE - CATEGORIES
Route::group(['prefix' => 'knowledgebase'], function () {
    //category
    Route::get("/", "KBCategories@index");
});
Route::resource('knowledgebase', 'KBCategories');

//KNOWLEDGEBASE - ARTICLES
Route::group(['prefix' => 'kb'], function () {
    //category
    Route::any("/search", "Knowledgebase@index");
    //pretty url domain.com/kb/12/some-category-title
    Route::any("/articles/{slug}", "Knowledgebase@index");
    Route::any("/article/{slug}", "Knowledgebase@show");
});
Route::resource('kb', 'Knowledgebase');

//SETTINGS - HOME
Route::group(['prefix' => 'settings'], function () {
    Route::get("/", "Settings\Home@index");
});

//SETTINGS - SYSTEM
Route::group(['prefix' => 'settings/system'], function () {
    Route::get("/clearcache", "Settings\System@clearLaravelCache");
});

//SETTINGS - GENERAL
Route::group(['prefix' => 'settings/general'], function () {
    Route::get("/", "Settings\General@index");
    Route::put("/", "Settings\General@update")->middleware(['demoModeCheck']);
});

//SETTINGS - COMPANY
Route::group(['prefix' => 'settings/company'], function () {
    Route::get("/", "Settings\Company@index");
    Route::put("/", "Settings\Company@update")->middleware(['demoModeCheck']);
});

//SETTINGS - CURRENCY
Route::group(['prefix' => 'settings/currency'], function () {
    Route::get("/", "Settings\Currency@index");
    Route::put("/", "Settings\Currency@update")->middleware(['demoModeCheck']);
});

//SETTINGS - THEME
Route::group(['prefix' => 'settings/theme'], function () {
    Route::get("/", "Settings\Theme@index");
    Route::put("/", "Settings\Theme@update")->middleware(['demoModeCheck']);
});

//SETTINGS - CLIENT
Route::group(['prefix' => 'settings/clients'], function () {
    Route::get("/", "Settings\Clients@index");
    Route::put("/", "Settings\Clients@update")->middleware(['demoModeCheck']);
});

//SETTINGS - TAGS
Route::group(['prefix' => 'settings/tags'], function () {
    Route::get("/", "Settings\Tags@index");
    Route::put("/", "Settings\Tags@update")->middleware(['demoModeCheck']);
});

//SETTINGS - PROJECT
Route::group(['prefix' => 'settings/projects'], function () {
    Route::get("/general", "Settings\Projects@general");
    Route::put("/general", "Settings\Projects@updateGeneral")->middleware(['demoModeCheck']);
    Route::get("/client", "Settings\Projects@clientPermissions");
    Route::put("/client", "Settings\Projects@updateClientPermissions")->middleware(['demoModeCheck']);
    Route::get("/staff", "Settings\Projects@staffPermissions");
    Route::put("/staff", "Settings\Projects@updateStaffPermissions")->middleware(['demoModeCheck']);
});

//SETTINGS - INVOICES
Route::group(['prefix' => 'settings/invoices'], function () {
    Route::get("/", "Settings\Invoices@index");
    Route::put("/", "Settings\Invoices@update")->middleware(['demoModeCheck']);
});

//SETTINGS - SUBSCRIPTIONS
Route::group(['prefix' => 'settings/subscriptions'], function () {
    Route::get("/", "Settings\Subscriptions@index");
    Route::put("/", "Settings\Subscriptions@update")->middleware(['demoModeCheck']);
});

//SETTINGS - UNITS
Route::group(['prefix' => 'settings/units'], function () {
    Route::get("/", "Settings\Units@index");
    Route::put("/", "Settings\Units@update")->middleware(['demoModeCheck']);
});
Route::resource('settings/units', 'Settings\Units');

//SETTINGS - TAX RATES
Route::group(['prefix' => 'settings/taxrates'], function () {
    Route::get("/", "Settings\Taxrates@index");
    Route::put("/", "Settings\Taxrates@update")->middleware(['demoModeCheck']);
});
Route::resource('settings/taxrates', 'Settings\Taxrates');

//SETTINGS - ESTIMATES
Route::group(['prefix' => 'settings/estimates'], function () {
    Route::get("/", "Settings\Estimates@index");
    Route::put("/", "Settings\Estimates@update")->middleware(['demoModeCheck']);
});

//SETTINGS - EXPENSES
Route::group(['prefix' => 'settings/expenses'], function () {
    Route::get("/", "Settings\Expenses@index");
    Route::put("/", "Settings\Expenses@update")->middleware(['demoModeCheck']);
});

//SETTINGS - STRIPE
Route::group(['prefix' => 'settings/stripe'], function () {
    Route::get("/", "Settings\Stripe@index")->middleware(['demoModeCheck']);
    Route::put("/", "Settings\Stripe@update")->middleware(['demoModeCheck']);
});

//SETTINGS - RAZORPAY
Route::group(['prefix' => 'settings/razorpay'], function () {
    Route::get("/", "Settings\Razorpay@index")->middleware(['demoModeCheck']);
    Route::put("/", "Settings\Razorpay@update")->middleware(['demoModeCheck']);
});

//SETTINGS - PAYPAL
Route::group(['prefix' => 'settings/paypal'], function () {
    Route::get("/", "Settings\Paypal@index")->middleware(['demoModeCheck']);
    Route::put("/", "Settings\Paypal@update")->middleware(['demoModeCheck']);
});

//SETTINGS - BANK
Route::group(['prefix' => 'settings/bank'], function () {
    Route::get("/", "Settings\Bank@index");
    Route::put("/", "Settings\Bank@update")->middleware(['demoModeCheck']);
});

//SETTINGS - LEADS
Route::group(['prefix' => 'settings/leads'], function () {
    Route::get("/general", "Settings\Leads@general");
    Route::put("/general", "Settings\Leads@updateGeneral");
    Route::get("/statuses", "Settings\Leads@statuses");
    Route::put("/statuses", "Settings\Leads@updateStatuses")->middleware(['demoModeCheck']);
    Route::get("/statuses/{id}/edit", "Settings\Leads@editStatus")->where('lead', '[0-9]+');
    Route::put("/statuses/{id}", "Settings\Leads@updateStatus")->where('lead', '[0-9]+')->middleware(['demoModeCheck']);
    Route::get("/statuses/create", "Settings\Leads@createStatus");
    Route::post("/statuses/create", "Settings\Leads@storeStatus");
    Route::get("/move/{id}", "Settings\Leads@move")->where('id', '[0-9]+');
    Route::put("/move/{id}", "Settings\Leads@updateMove")->where('id', '[0-9]+');
    Route::delete("/statuses/{id}", "Settings\Leads@destroyStatus")->where('id', '[0-9]+')->middleware(['demoModeCheck']);
    Route::post("/update-stage-positions", "Settings\Leads@updateStagePositions");
});

//SETTINGS - MILESTONES
Route::group(['prefix' => 'settings/milestones'], function () {
    Route::get("/settings", "Settings\Milestones@index");
    Route::put("/settings", "Settings\Milestones@update")->middleware(['demoModeCheck']);
    Route::get("/default", "Settings\Milestones@categories");
    Route::get("/create", "Settings\Milestones@create");
    Route::post("/create", "Settings\Milestones@storeCategory")->middleware(['demoModeCheck']);
    Route::get("/{id}/edit", "Settings\Milestones@editCategory")->where('id', '[0-9]+');
    Route::put("/{id}", "Settings\Milestones@updateCategory")->where('id', '[0-9]+')->middleware(['demoModeCheck']);
    Route::post("/update-positions", "Settings\Milestones@updateCategoryPositions");
    Route::delete("/{id}", "Settings\Milestones@destroy")->where('id', '[0-9]+')->middleware(['demoModeCheck']);
});

//SETTINGS - knowledgebase
Route::group(['prefix' => 'settings/knowledgebase'], function () {
    Route::get("/settings", "Settings\Knowledgebase@index");
    Route::put("/settings", "Settings\Knowledgebase@update")->middleware(['demoModeCheck']);
    Route::get("/default", "Settings\Knowledgebase@categories");
    Route::get("/create", "Settings\Knowledgebase@create");
    Route::post("/create", "Settings\Knowledgebase@storeCategory")->middleware(['demoModeCheck']);
    Route::get("/{id}/edit", "Settings\Knowledgebase@editCategory")->where('id', '[0-9]+');
    Route::put("/{id}", "Settings\Knowledgebase@updateCategory")->where('id', '[0-9]+')->middleware(['demoModeCheck']);
    Route::post("/update-positions", "Settings\Knowledgebase@updateCategoryPositions");
    Route::delete("/{id}", "Settings\Knowledgebase@destroy")->where('id', '[0-9]+')->middleware(['demoModeCheck']);
});

//SETTINGS - LEAD SOURCES
Route::group(['prefix' => 'settings/sources'], function () {
    Route::get("/", "Settings\Sources@index");
    Route::put("/", "Settings\Sources@update")->middleware(['demoModeCheck']);
});
Route::resource('settings/sources', 'Settings\Sources');

//SETTINGS - TASKS
Route::group(['prefix' => 'settings/tasks'], function () {
    Route::get("/", "Settings\Tasks@index");
    Route::put("/", "Settings\Tasks@update")->middleware(['demoModeCheck']);
});

//SETTINGS - EMAIL
Route::group(['prefix' => 'settings/email'], function () {
    Route::get("/general", "Settings\Email@general");
    Route::put("/general", "Settings\Email@updateGeneral")->middleware(['demoModeCheck']);
    Route::get("/smtp", "Settings\Email@smtp")->middleware(['demoModeCheck']);
    Route::put("/smtp", "Settings\Email@updateSMTP")->middleware(['demoModeCheck']);
    Route::get("/templates", "Settings\Emailtemplates@index");
    Route::get("/templates/{id}", "Settings\Emailtemplates@show")->where('id', '[0-9]+');
    Route::post("/templates/{id}", "Settings\Emailtemplates@update")->where('id', '[0-9]+')->middleware(['demoModeCheck']);
    Route::get("/testemail", "Settings\Email@testEmail")->middleware(['demoModeCheck']);
    Route::post("/testemail", "Settings\Email@testEmailAction")->middleware(['demoModeCheck']);
});

//SETTINGS - UPDATES
Route::group(['prefix' => 'settings/updates'], function () {
    Route::get("/", "Settings\Updates@index");
    Route::post("/check", "Settings\Updates@checkUpdates");
});

//SETTINGS - ROLES
Route::group(['prefix' => 'settings/roles'], function () {
    Route::get("/", "Settings\Roles@index");
    Route::put("/", "Settings\Roles@update")->middleware(['demoModeCheck']);
});
Route::resource('settings/roles', 'Settings\Roles');
Route::post("/settings/roles", "Settings\Roles@Store")->middleware(['demoModeCheck']);

//SETTINGS - CLIENTS
Route::group(['prefix' => 'settings/clients'], function () {
    Route::get("/", "Settings\Clients@index");
    Route::put("/", "Settings\Clients@update")->middleware(['demoModeCheck']);
});

//SETTINGS - TICKETS
Route::group(['prefix' => 'settings/tickets'], function () {
    Route::get("/", "Settings\Tickets@index");
    Route::put("/", "Settings\Tickets@update")->middleware(['demoModeCheck']);
});

//SETTINGS - LOGO
Route::group(['prefix' => 'settings/logos'], function () {
    Route::get("/", "Settings\Logos@index");
    Route::get("/uploadlogo", "Settings\Logos@logo");
    Route::put("/uploadlogo", "Settings\Logos@updateLogo")->middleware(['demoModeCheck']);
});

//SETTINGS - DYNAMIC URLS's
Route::group(['prefix' => 'app/settings'], function () {
    Route::get("/{any}", "Settings\Dynamic@showDynamic")->where(['any' => '.*']);
});
Route::get("app/categories", "Settings\Dynamic@showDynamic");
Route::get("app/tags", "Settings\Dynamic@showDynamic");

//SETTINGS - CRONJOBS
Route::get("/settings/cronjobs", "Settings\Cronjobs@index");

//SETTINGS - TASKS
Route::group(['prefix' => 'settings/subscriptions'], function () {
    Route::get("/plans", "Settings\Subscriptions@plans");
    Route::get("/plans/create", "Settings\Subscriptions@createPlan");
    Route::post("/plans", "Settings\Subscriptions@storePlan")->middleware(['demoModeCheck']);
    Route::put("/plans", "Settings\Subscriptions@updatePlan")->middleware(['demoModeCheck']);
});



//SETTINGS - CUSTOMFIELDS
Route::group(['prefix' => 'settings/customfields'], function () {
    Route::get("/clients", "Settings\Customfields@showClient");
    Route::put("/clients", "Settings\Customfields@updateClient")->middleware(['demoModeCheck']);
    Route::get("/projects", "Settings\Customfields@showProject");
    Route::put("/projects", "Settings\Customfields@updateProject")->middleware(['demoModeCheck']);
    Route::get("/leads", "Settings\Customfields@showLead");
    Route::put("/leads", "Settings\Customfields@updateLead")->middleware(['demoModeCheck']);
    Route::get("/tasks", "Settings\Customfields@showTask");
    Route::put("/tasks", "Settings\Customfields@updateTask")->middleware(['demoModeCheck']);
});

//EVENTS - TIMELINE
Route::group(['prefix' => 'events'], function () {
    Route::get("/topnav", "Events@topNavEvents");
    Route::get("/{id}/mark-read-my-event", "Events@markMyEventRead")->where('id', '[0-9]+');
    Route::get("/mark-allread-my-events", "Events@markAllMyEventRead");
});

//WEBHOOKS & IPN API
Route::group(['prefix' => 'api'], function () {
    Route::any("/stripe/webhooks", "API\Stripe\Webhooks@index");
    Route::any("/paypal/ipn", "API\Paypal\Ipn@index");
});

//POLLING
Route::group(['prefix' => 'polling'], function () {
    Route::get("/general", "Polling@generalPoll");
    Route::post("/timers", "Polling@timersPoll");
});

//SETUP GROUP (with group route name 'setup'
Route::group(['prefix' => 'setup', 'as' => 'setup'], function () {
    //requirements
    Route::get("/requirements", "Setup\Setup@checkRequirements");
    //server phpinfo()
    Route::get("/serverinfo", "Setup\Setup@serverInfo");
    //database
    Route::get("/database", "Setup\Setup@showDatabase");
    Route::post("/database", "Setup\Setup@updateDatabase");
    //settings
    Route::get("/settings", "Setup\Setup@showSettings");
    Route::post("/settings", "Setup\Setup@updateSettings");
    //admin user
    Route::get("/adminuser", "Setup\Setup@showUser");
    Route::post("/adminuser", "Setup\Setup@updateUser");
    //load first page -put this as last item
    Route::any("/", "Setup\Setup@index");
});

//UPDATING MODALS
Route::group(['prefix' => 'updating'], function () {
    //version 1.01 - January 2021
    Route::get("/update-currency-settings", "Updating\Action@showUpdatingCurrencySetting");
    Route::put("/update-currency-settings", "Updating\Action@updateUpdatingCurrencySetting");
});
