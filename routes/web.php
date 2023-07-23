<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Clear Cache facade value:
Route::get('/clear', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('config:cache');
    return '<h1>Cache value cleared</h1>';
});

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
	Route::get('/dashboard', 'HomeController@dashboard');
});

Route::group(['middleware' => ['auth', 'active']], function() {
	Route::get('/', 'HomeController@index');
	Route::get('/dashboard-filter/{start_date}/{end_date}', 'HomeController@dashboardFilter');

	Route::get('language_switch/{locale}', 'LanguageController@switchLanguage');

	Route::resource('deposits', 'BankDepositController');
    Route::resource('withdraws', 'WithDrawController');

	Route::get('role/permission/{id}', 'RoleController@permission')->name('role.permission');
	Route::post('role/set_permission', 'RoleController@setPermission')->name('role.setPermission');
	Route::resource('role', 'RoleController');

	Route::post('importunit', 'UnitController@importUnit')->name('unit.import');
	Route::post('unit/deletebyselection', 'UnitController@deleteBySelection');
	Route::get('unit/lims_unit_search', 'UnitController@limsUnitSearch')->name('unit.search');
	Route::resource('unit', 'UnitController');

	Route::post('category/import', 'CategoryController@import')->name('category.import');
	Route::post('category/deletebyselection', 'CategoryController@deleteBySelection');
	Route::post('category/category-data', 'CategoryController@categoryData');
	Route::resource('category', 'CategoryController');

    Route::post('categories/deletebyselection','ServiceCategoryController@deleteBySelection');
    Route::resource('categories','ServiceCategoryController');

	Route::post('importbrand', 'BrandController@importBrand')->name('brand.import');
	Route::post('brand/deletebyselection', 'BrandController@deleteBySelection');
	Route::get('brand/lims_brand_search', 'BrandController@limsBrandSearch')->name('brand.search');
	Route::resource('brand', 'BrandController');

	Route::post('importsupplier', 'SupplierController@importSupplier')->name('supplier.import');
	Route::post('supplier/deletebyselection', 'SupplierController@deleteBySelection');
	Route::get('supplier/lims_supplier_search', 'SupplierController@limsSupplierSearch')->name('supplier.search');
	Route::resource('supplier', 'SupplierController');

	Route::post('importwarehouse', 'WarehouseController@importWarehouse')->name('warehouse.import');
	Route::post('warehouse/deletebyselection', 'WarehouseController@deleteBySelection');
	Route::get('warehouse/lims_warehouse_search', 'WarehouseController@limsWarehouseSearch')->name('warehouse.search');
	Route::resource('warehouse', 'WarehouseController');

	Route::post('importtax', 'TaxController@importTax')->name('tax.import');
	Route::post('tax/deletebyselection', 'TaxController@deleteBySelection');
	Route::get('tax/lims_tax_search', 'TaxController@limsTaxSearch')->name('tax.search');
	Route::resource('tax', 'TaxController');

    Route::get('purchase_contract/master/print_alternate/{id}','PurchaseContractController@printMasterAlternate')->name('master.alternate');
    Route::get('purchase_contract/master/print/{id}','PurchaseContractController@printMaster')->name('master.print');
    Route::get('purchases/master/{id}', 'PurchaseContractController@purchaseMasterView')->name('master.view');
    Route::get('purchase_contract/filter', 'PurchaseContractController@getFiltering');
    Route::post('purchase_contract/filter', 'PurchaseContractController@filtering')->name('contract.filtering');
    Route::get('purchase_contract/print/{id}','PurchaseContractController@print');
    Route::get('purchase_contract/proforma_invoice/{id}','PurchaseContractController@proforma_invoice')->name('proforma.invoice');
    Route::resource('purchase_contract', 'PurchaseContractController');

    Route::get('purchase_order/duplicate/{id}', 'PurchaseOrderController@duplicateOrder')->name('purchase_order.duplicate');
    Route::get('purchase_order/filter', 'PurchaseOrderController@getFiltering');
    Route::post('purchase_order/filter', 'PurchaseOrderController@filtering')->name('order.filtering');
    Route::get('purchase_order/print/{id}', 'PurchaseOrderController@printOrder');
    Route::resource('purchase_order', 'PurchaseOrderController');

    Route::resource('payment_term', 'PaymentTermController');
    Route::resource('treams', 'TrimmingController');

    Route::get('cost_breakdowns/filter', 'CostBreakdownController@getFiltering');
    Route::post('cost_breakdowns/filter', 'CostBreakdownController@filtering')->name('breakdown.filtering');
    Route::resource('cost_breakdowns', 'CostBreakdownController');

    Route::get('cost_sheet/duplicate/{id}', 'CostSheetController@duplicateCost')->name('cost_sheet.duplicate');
    Route::get('cost_sheet/filter', 'CostSheetController@getFiltering');
    Route::post('cost_sheet/filter', 'CostSheetController@filtering')->name('cost.filtering');
    Route::get('cost_sheet/print/{id}', 'CostSheetController@printCostSheet');
    Route::resource('cost_sheet', 'CostSheetController');

    Route::get('proforma_invoice/invoice/{id}', 'ProformaInvoiceController@proformaInvoice')->name('invoice.proforma');
    Route::get('proforma_invoice/filter', 'ProformaInvoiceController@getFiltering');
    Route::post('proforma_invoice/filter', 'ProformaInvoiceController@filtering')->name('invoice.filtering');
    Route::get('proforma_invoice/print/{id}','ProformaInvoiceController@print');
    Route::resource('proforma_invoice', 'ProformaInvoiceController');


    Route::post('invoice/store', 'VendorController@invoiceToStore')->name('invoice_to.store');
    Route::get('invoice_to', 'VendorController@invoiceList')->name('invoice.list');
    Route::get('invoice_to/{id}','VendorController@invoiceEdit');
    Route::put('invoice_to/update/{id}','VendorController@invoice_toUpdate')->name('invoice.update');
    Route::get('invoice/delete/{id}','VendorController@invoiceDelete')->name('invoiceTo.delete');
    Route::post('ship/store', 'VendorController@shipToStore')->name('ship_to.store');

    Route::get('ship_to', 'VendorController@shipList')->name('ship.list');
    Route::get('ship_to/{id}','VendorController@shipEdit');
    Route::put('ship_to/update/{id}','VendorController@ship_toUpdate')->name('ship.update');
    Route::get('ship/delete/{id}','VendorController@shipDelete')->name('shipTo.delete');

    Route::get('applicant', 'VendorController@applicantList')->name('applicant.list');
    Route::post('applicant/store','VendorController@applicantStore')->name('applicant.store');
    Route::get('applicant/{id}','VendorController@applicantEdit');
    Route::put('applicant/update/{id}','VendorController@applicantUpdate')->name('applicant.update');
    Route::get('applicant/delete/{id}','VendorController@applicantDelete')->name('applicant.delete');

    Route::get('notify_party', 'VendorController@notifyList')->name('notify.list');
    Route::post('notify_party/store','VendorController@notifyStore')->name('notify.store');
    Route::get('notify_party/{id}','VendorController@notifyEdit');
    Route::put('notify_party/update/{id}','VendorController@notifyUpdate')->name('notify.update');
    Route::get('notify_party/delete/{id}','VendorController@notifyDelete')->name('notify.delete');

    Route::resource('vendors', 'VendorController');

    Route::resource('banks', 'BankController');
    Route::resource('bank_branches', 'BankBranchController');
    Route::get('get_branches/{id}','BankAccountController@getBranch');
    Route::resource('bank_accounts', 'BankAccountController');
    Route::resource('incomes','IncomeController');
    Route::resource('income_source','IncomeSourceController');

	//Route::get('products/getbarcode', 'ProductController@getBarcode');
	Route::post('products/product-data', 'ProductController@productData');
	Route::get('products/gencode', 'ProductController@generateCode');
	Route::get('products/search', 'ProductController@search');
	Route::get('products/saleunit/{id}', 'ProductController@saleUnit');
	Route::get('products/getdata/{id}', 'ProductController@getData');
	Route::get('products/product_warehouse/{id}', 'ProductController@productWarehouseData');
	Route::post('importproduct', 'ProductController@importProduct')->name('product.import');
	Route::post('exportproduct', 'ProductController@exportProduct')->name('product.export');
	Route::get('products/print_barcode','ProductController@printBarcode')->name('product.printBarcode');

	Route::get('products/lims_product_search', 'ProductController@limsProductSearch')->name('product.search');
	Route::post('products/deletebyselection', 'ProductController@deleteBySelection');
	Route::post('products/update', 'ProductController@updateProduct');
	Route::resource('products', 'ProductController');

    Route::put('services/sale/update/{id}','ServiceController@serviceSaleUpdate')->name('service.sale.update');
    Route::get('services/sale/edit/{id}','ServiceController@saleEdit')->name('service.sale.edit');
    Route::post('service/sale/sendmail','ServiceController@sendMmail')->name('service.sale.sendmail');
    Route::post('services/deletebyselection','ServiceController@deleteBySelection');
    Route::get('service/gen_invoice/{id}', 'ServiceController@genInvoice')->name('service.invoice');
    Route::post('service/delivery/store','ServiceController@deliveryStore')->name('service.delivery.store');
    Route::get('service/sale/service/delivery/{id}','ServiceController@serviceDelivary');
    Route::post('service/sale/delete_payment','ServiceController@servicePaymentDelete')->name('service.sale.delete-payment');
    Route::get('service/sale/servigetPaymentce/{id}','ServiceController@getPayment');
    Route::post('service/sale/payment','ServiceController@duePayment')->name('service-sale.add-payment');
    Route::get('service/sale/get_sale/{id}','ServiceController@getSaleData');
    Route::get('service/sale/service_sale/{id}','ServiceController@saleView');
    Route::get('service/sale/list','ServiceController@serviceSaleList')->name('service.sale.list');
    Route::post('service/sale/store','ServiceController@serviceSaleStore')->name('service.sale.store');
    Route::get('services/sale','ServiceController@serviceSaleCreate')->name('service.sale');
    Route::get('services/sale/service_search_sale', 'ServiceController@serviceSearchSale')->name('search.sale');
    Route::get('services/service_search_sale', 'ServiceController@serviceSearchSale')->name('service.search.sale');
    Route::get('services/service_search', 'ServiceController@serviceSearch')->name('service.search');
    Route::get('services/print_qrcode','ServiceController@printQRcode')->name('service.printQRrcode');
    Route::get('services/generatecode','ServiceController@generateCode');

    Route::get('customer/service/delivery/{id}','ServiceController@serviceDelivary');
    Route::get('customer/service_sale/{id}','ServiceController@saleView');
    Route::get('customer/get_sale/{id}','ServiceController@getSaleData');
    Route::get('customer/servigetPaymentce/{id}','ServiceController@getPayment');
    Route::get('customer/delivery/create/{id}', 'DeliveryController@create');
    Route::get('customer/sales/getpayment/{id}', 'SaleController@getPayment');
    Route::get('customer/product_sale/{id}','SaleController@saleView');
    Route::resource('services', 'ServiceController');

    Route::post('service_delivery/update','ServiceDelivaryController@updateDelivery')->name('service_delivery.updateDelivey');
    Route::resource('service_delivery','ServiceDelivaryController');

	Route::post('importcustomer_group', 'CustomerGroupController@importCustomerGroup')->name('customer_group.import');
	Route::post('customer_group/deletebyselection', 'CustomerGroupController@deleteBySelection');
	Route::get('customer_group/lims_customer_group_search', 'CustomerGroupController@limsCustomerGroupSearch')->name('customer_group.search');
	Route::resource('customer_group', 'CustomerGroupController');

    Route::get('customer/filter','CustomerController@filterCustomerGet');
    Route::get('customer/getCustomer/{id}','CustomerController@getCustomer');
	Route::post('customer/filter', 'CustomerController@filterCustomer')->name('customer.filter');
    Route::post('importcustomer', 'CustomerController@importCustomer')->name('customer.import');
	Route::get('customer/getDeposit/{id}', 'CustomerController@getDeposit');
	Route::post('customer/add_deposit', 'CustomerController@addDeposit')->name('customer.addDeposit');
    Route::post('customer/add_reminder', 'CustomerController@addReminder')->name('customer.addReminder');
	Route::post('customer/update_deposit', 'CustomerController@updateDeposit')->name('customer.updateDeposit');
	Route::post('customer/deleteDeposit', 'CustomerController@deleteDeposit')->name('customer.deleteDeposit');
	Route::post('customer/deletebyselection', 'CustomerController@deleteBySelection');
	Route::get('customer/lims_customer_search', 'CustomerController@limsCustomerSearch')->name('customer.search');
    Route::post('customer/add_comment', 'CustomerController@addComment')->name('customer.addComment');
	Route::resource('customer', 'CustomerController');

    Route::post('comment/deletebyselection','CommentController@deleteBySelection');
    Route::post('comment/update/store', 'CommentController@updateComment')->name('commentUpdate.store');
    Route::resource('comment', 'CommentController');

	Route::post('importbiller', 'BillerController@importBiller')->name('biller.import');
	Route::post('biller/deletebyselection', 'BillerController@deleteBySelection');
	Route::get('biller/lims_biller_search', 'BillerController@limsBillerSearch')->name('biller.search');
	Route::resource('biller', 'BillerController');

	Route::post('sales/sale-data', 'SaleController@saleData');
	Route::post('sales/sendmail', 'SaleController@sendMail')->name('sale.sendmail');
	Route::get('sales/sale_by_csv', 'SaleController@saleByCsv');
	Route::get('sales/product_sale/{id}','SaleController@productSaleData');
	Route::post('importsale', 'SaleController@importSale')->name('sale.import');
	Route::get('pos', 'SaleController@posSale')->name('sale.pos');
	Route::get('sales/lims_sale_search', 'SaleController@limsSaleSearch')->name('sale.search');
	Route::get('sales/lims_product_search', 'SaleController@limsProductSearch')->name('product_sale.search');
	Route::get('sales/getcustomergroup/{id}', 'SaleController@getCustomerGroup')->name('sale.getcustomergroup');
	Route::get('sales/getproduct/{id}', 'SaleController@getProduct')->name('sale.getproduct');
	Route::get('sales/getproduct/{category_id}/{brand_id}', 'SaleController@getProductByFilter');
	Route::get('sales/getfeatured', 'SaleController@getFeatured');
	Route::get('sales/get_gift_card', 'SaleController@getGiftCard');
	Route::get('sales/paypalSuccess', 'SaleController@paypalSuccess');
	Route::get('sales/paypalPaymentSuccess/{id}', 'SaleController@paypalPaymentSuccess');
	Route::get('sales/gen_invoice/{id}', 'SaleController@genInvoice')->name('sale.invoice');
	Route::post('sales/add_payment', 'SaleController@addPayment')->name('sale.add-payment');
	Route::get('sales/getpayment/{id}', 'SaleController@getPayment')->name('sale.get-payment');
	Route::post('sales/updatepayment', 'SaleController@updatePayment')->name('sale.update-payment');
	Route::post('sales/deletepayment', 'SaleController@deletePayment')->name('sale.delete-payment');
	Route::get('sales/{id}/create', 'SaleController@createSale');
	Route::post('sales/deletebyselection', 'SaleController@deleteBySelection');
	Route::get('sales/print-last-reciept', 'SaleController@printLastReciept')->name('sales.printLastReciept');
	Route::get('sales/today-sale', 'SaleController@todaySale');
	Route::get('sales/today-profit/{warehouse_id}', 'SaleController@todayProfit');
	Route::resource('sales', 'SaleController');

	Route::get('delivery', 'DeliveryController@index')->name('delivery.index');
	Route::get('delivery/product_delivery/{id}','DeliveryController@productDeliveryData');
	Route::get('delivery/create/{id}', 'DeliveryController@create');
	Route::post('delivery/store', 'DeliveryController@store')->name('delivery.store');
	Route::post('delivery/sendmail', 'DeliveryController@sendMail')->name('delivery.sendMail');
	Route::get('delivery/{id}/edit', 'DeliveryController@edit');
	Route::post('delivery/update', 'DeliveryController@update')->name('delivery.update');
	Route::post('delivery/deletebyselection', 'DeliveryController@deleteBySelection');
	Route::post('delivery/delete/{id}', 'DeliveryController@delete')->name('delivery.delete');

	Route::get('quotations/product_quotation/{id}','QuotationController@productQuotationData');
	Route::get('quotations/lims_product_search', 'QuotationController@limsProductSearch')->name('product_quotation.search');
	Route::get('quotations/getcustomergroup/{id}', 'QuotationController@getCustomerGroup')->name('quotation.getcustomergroup');
	Route::get('quotations/getproduct/{id}', 'QuotationController@getProduct')->name('quotation.getproduct');
	Route::get('quotations/{id}/create_sale', 'QuotationController@createSale')->name('quotation.create_sale');
	Route::get('quotations/{id}/create_purchase', 'QuotationController@createPurchase')->name('quotation.create_purchase');
	Route::post('quotations/sendmail', 'QuotationController@sendMail')->name('quotation.sendmail');
	Route::post('quotations/deletebyselection', 'QuotationController@deleteBySelection');
	Route::resource('quotations', 'QuotationController');


	Route::post('purchases/purchase-data', 'PurchaseController@purchaseData');
	Route::get('purchases/product_purchase/{id}','PurchaseController@productPurchaseData');
	Route::get('purchases/lims_product_search', 'PurchaseController@limsProductSearch')->name('product_purchase.search');
	Route::post('purchases/add_payment', 'PurchaseController@addPayment')->name('purchase.add-payment');
	Route::get('purchases/getpayment/{id}', 'PurchaseController@getPayment')->name('purchase.get-payment');
	Route::post('purchases/updatepayment', 'PurchaseController@updatePayment')->name('purchase.update-payment');
	Route::post('purchases/deletepayment', 'PurchaseController@deletePayment')->name('purchase.delete-payment');
	Route::get('purchases/purchase_by_csv', 'PurchaseController@purchaseByCsv');
	Route::post('importpurchase', 'PurchaseController@importPurchase')->name('purchase.import');
	Route::post('purchases/deletebyselection', 'PurchaseController@deleteBySelection');
	Route::resource('purchases', 'PurchaseController');

	Route::get('transfers/product_transfer/{id}','TransferController@productTransferData');
	Route::get('transfers/transfer_by_csv', 'TransferController@transferByCsv');
	Route::post('importtransfer', 'TransferController@importTransfer')->name('transfer.import');
	Route::get('transfers/getproduct/{id}', 'TransferController@getProduct')->name('transfer.getproduct');
	Route::get('transfers/lims_product_search', 'TransferController@limsProductSearch')->name('product_transfer.search');
	Route::post('transfers/deletebyselection', 'TransferController@deleteBySelection');
	Route::resource('transfers', 'TransferController');

	Route::get('qty_adjustment/getproduct/{id}', 'AdjustmentController@getProduct')->name('adjustment.getproduct');
	Route::get('qty_adjustment/lims_product_search', 'AdjustmentController@limsProductSearch')->name('product_adjustment.search');
	Route::post('qty_adjustment/deletebyselection', 'AdjustmentController@deleteBySelection');
	Route::resource('qty_adjustment', 'AdjustmentController');

	Route::get('return-sale/getcustomergroup/{id}', 'ReturnController@getCustomerGroup')->name('return-sale.getcustomergroup');
	Route::post('return-sale/sendmail', 'ReturnController@sendMail')->name('return-sale.sendmail');
	Route::get('return-sale/getproduct/{id}', 'ReturnController@getProduct')->name('return-sale.getproduct');
	Route::get('return-sale/lims_product_search', 'ReturnController@limsProductSearch')->name('product_return-sale.search');
	Route::get('return-sale/product_return/{id}','ReturnController@productReturnData');
	Route::post('return-sale/deletebyselection', 'ReturnController@deleteBySelection');
	Route::resource('return-sale', 'ReturnController');

	Route::get('return-purchase/getcustomergroup/{id}', 'ReturnPurchaseController@getCustomerGroup')->name('return-purchase.getcustomergroup');
	Route::post('return-purchase/sendmail', 'ReturnPurchaseController@sendMail')->name('return-purchase.sendmail');
	Route::get('return-purchase/getproduct/{id}', 'ReturnPurchaseController@getProduct')->name('return-purchase.getproduct');
	Route::get('return-purchase/lims_product_search', 'ReturnPurchaseController@limsProductSearch')->name('product_return-purchase.search');
	Route::get('return-purchase/product_return/{id}','ReturnPurchaseController@productReturnData');
	Route::post('return-purchase/deletebyselection', 'ReturnPurchaseController@deleteBySelection');
	Route::resource('return-purchase', 'ReturnPurchaseController');

	Route::get('report/product_quantity_alert', 'ReportController@productQuantityAlert')->name('report.qtyAlert');
	Route::get('report/warehouse_stock', 'ReportController@warehouseStock')->name('report.warehouseStock');
	Route::post('report/warehouse_stock', 'ReportController@warehouseStockById')->name('report.warehouseStock');
	Route::get('report/daily_sale/{year}/{month}', 'ReportController@dailySale');
	Route::post('report/daily_sale/{year}/{month}', 'ReportController@dailySaleByWarehouse')->name('report.dailySaleByWarehouse');
	Route::get('report/monthly_sale/{year}', 'ReportController@monthlySale');
	Route::post('report/monthly_sale/{year}', 'ReportController@monthlySaleByWarehouse')->name('report.monthlySaleByWarehouse');
	Route::get('report/daily_purchase/{year}/{month}', 'ReportController@dailyPurchase');
	Route::post('report/daily_purchase/{year}/{month}', 'ReportController@dailyPurchaseByWarehouse')->name('report.dailyPurchaseByWarehouse');
	Route::get('report/monthly_purchase/{year}', 'ReportController@monthlyPurchase');
	Route::post('report/monthly_purchase/{year}', 'ReportController@monthlyPurchaseByWarehouse')->name('report.monthlyPurchaseByWarehouse');
	Route::get('report/best_seller', 'ReportController@bestSeller');
	Route::post('report/best_seller', 'ReportController@bestSellerByWarehouse')->name('report.bestSellerByWarehouse');
	Route::post('report/profit_loss', 'ReportController@profitLoss')->name('report.profitLoss');
	Route::post('report/product_report', 'ReportController@productReport')->name('report.product');
	Route::post('report/purchase', 'ReportController@purchaseReport')->name('report.purchase');
	Route::post('report/sale_report', 'ReportController@saleReport')->name('report.sale');
	Route::post('report/payment_report_by_date', 'ReportController@paymentReportByDate')->name('report.paymentByDate');
	Route::post('report/warehouse_report', 'ReportController@warehouseReport')->name('report.warehouse');
	Route::post('report/user_report', 'ReportController@userReport')->name('report.user');
	Route::post('report/customer_report', 'ReportController@customerReport')->name('report.customer');
	Route::post('report/supplier', 'ReportController@supplierReport')->name('report.supplier');
	Route::post('report/due_report_by_date', 'ReportController@dueReportByDate')->name('report.dueByDate');

	Route::get('user/profile/{id}', 'UserController@profile')->name('user.profile');
	Route::put('user/update_profile/{id}', 'UserController@profileUpdate')->name('user.profileUpdate');
	Route::put('user/changepass/{id}', 'UserController@changePassword')->name('user.password');
	Route::get('user/genpass', 'UserController@generatePassword');
	Route::post('user/deletebyselection', 'UserController@deleteBySelection');
	Route::resource('user','UserController');

	Route::get('setting/general_setting', 'SettingController@generalSetting')->name('setting.general');
	Route::post('setting/general_setting_store', 'SettingController@generalSettingStore')->name('setting.generalStore');
	Route::get('backup', 'SettingController@backup')->name('setting.backup');
	Route::get('setting/general_setting/change-theme/{theme}', 'SettingController@changeTheme');
	Route::get('setting/mail_setting', 'SettingController@mailSetting')->name('setting.mail');
	Route::get('setting/sms_setting', 'SettingController@smsSetting')->name('setting.sms');
	Route::get('setting/createsms', 'SettingController@createSms')->name('setting.createSms');
	Route::post('setting/sendsms', 'SettingController@sendSms')->name('setting.sendSms');
	Route::get('setting/hrm_setting', 'SettingController@hrmSetting')->name('setting.hrm');
	Route::post('setting/hrm_setting_store', 'SettingController@hrmSettingStore')->name('setting.hrmStore');
	Route::post('setting/mail_setting_store', 'SettingController@mailSettingStore')->name('setting.mailStore');
	Route::post('setting/sms_setting_store', 'SettingController@smsSettingStore')->name('setting.smsStore');
	Route::get('setting/pos_setting', 'SettingController@posSetting')->name('setting.pos');
	Route::post('setting/pos_setting_store', 'SettingController@posSettingStore')->name('setting.posStore');
	Route::get('setting/empty-database', 'SettingController@emptyDatabase')->name('setting.emptyDatabase');
    Route::resource('salary-sheet-settings', 'SalarySheetSettingsController');

	Route::get('expense_categories/gencode', 'ExpenseCategoryController@generateCode');
	Route::post('expense_categories/import', 'ExpenseCategoryController@import')->name('expense_category.import');
	Route::post('expense_categories/deletebyselection', 'ExpenseCategoryController@deleteBySelection');
	Route::resource('expense_categories', 'ExpenseCategoryController');

	Route::post('expenses/deletebyselection', 'ExpenseController@deleteBySelection');
    Route::get('expenses/filter', 'ExpenseController@expenseFilterGet');
    Route::post('expenses/filter', 'ExpenseController@expenseFilter')->name('expense.filter');
	Route::resource('expenses', 'ExpenseController');
	Route::resource('cost-budget', 'CostBudgetController');

	Route::get('gift_cards/gencode', 'GiftCardController@generateCode');
	Route::post('gift_cards/recharge/{id}', 'GiftCardController@recharge')->name('gift_cards.recharge');
	Route::post('gift_cards/deletebyselection', 'GiftCardController@deleteBySelection');
	Route::resource('gift_cards', 'GiftCardController');

	Route::get('coupons/gencode', 'CouponController@generateCode');
	Route::post('coupons/deletebyselection', 'CouponController@deleteBySelection');
	Route::resource('coupons', 'CouponController');
	//accounting routes
	Route::get('accounts/account-statement/print','AccountsController@print_statement');
	Route::get('accounts/make-default/{id}', 'AccountsController@makeDefault');
	Route::get('accounts/balancesheet', 'AccountsController@balanceSheet')->name('accounts.balancesheet');
    Route::get('accounts/account-statement', 'AccountsController@accountStatementGet');
	Route::post('accounts/account-statement', 'AccountsController@accountStatement')->name('accounts.statement');
	Route::resource('accounts', 'AccountsController');
	Route::resource('money-transfers', 'MoneyTransferController');
	//HRM routes
	Route::post('departments/deletebyselection', 'DepartmentController@deleteBySelection');
	Route::resource('departments', 'DepartmentController');

    //Export section
    Route::post('exports/deletebyselection', 'ExportController@deleteBySelection');
    Route::get('export/filter', 'ExportController@getFiltering');
    Route::post('export/filter', 'ExportController@filtering')->name('export.filtering');
    Route::resource('export', 'ExportController');

	Route::post('employees/salary-increment', 'EmployeeController@salaryIncrement')->name('employees.salary-increment');
	Route::post('employees/deletebyselection', 'EmployeeController@deleteBySelection');
	Route::post('employees/leave-job/{id}', 'EmployeeController@leaveJob')->name('employees.leave-job');
	Route::post('employees/cancel-leave-job/{id}', 'EmployeeController@cancelLeaveJob')->name('employees.cancel-leave-job');
	Route::resource('employees', 'EmployeeController');

	Route::get('payroll/filter', 'PayrollController@payrollFilterGet');
    Route::post('payroll/filter', 'PayrollController@payrollFilter')->name('payroll.filter');
	Route::post('payroll/deletebyselection', 'PayrollController@deleteBySelection');
	Route::resource('payroll', 'PayrollController');

	Route::post('attendance/deletebyselection', 'AttendanceController@deleteBySelection');
	Route::resource('attendance', 'AttendanceController');

	Route::resource('stock-count', 'StockCountController');
	Route::post('stock-count/finalize', 'StockCountController@finalize')->name('stock-count.finalize');
	Route::get('stock-count/stockdif/{id}', 'StockCountController@stockDif');
	Route::get('stock-count/{id}/qty_adjustment', 'StockCountController@qtyAdjustment')->name('stock-count.adjustment');

	Route::post('holidays/deletebyselection', 'HolidayController@deleteBySelection');
	Route::get('approve-holiday/{id}', 'HolidayController@approveHoliday')->name('approveHoliday');
	Route::get('holidays/my-holiday/{year}/{month}', 'HolidayController@myHoliday')->name('myHoliday');
	Route::resource('holidays', 'HolidayController');

	Route::get('cash-register', 'CashRegisterController@index')->name('cashRegister.index');
	Route::get('cash-register/check-availability/{warehouse_id}', 'CashRegisterController@checkAvailability')->name('cashRegister.checkAvailability');
	Route::post('cash-register/store', 'CashRegisterController@store')->name('cashRegister.store');
	Route::get('cash-register/getDetails/{id}', 'CashRegisterController@getDetails');
	Route::get('cash-register/showDetails/{warehouse_id}', 'CashRegisterController@showDetails');
	Route::post('cash-register/close', 'CashRegisterController@close')->name('cashRegister.close');

	Route::post('notifications/store', 'NotificationController@store')->name('notifications.store');
	Route::get('notifications/mark-as-read', 'NotificationController@markAsRead');

	Route::resource('currency', 'CurrencyController');

	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('my-transactions/{year}/{month}', 'HomeController@myTransaction');

    Route::post('reminder/deletebyselection','ReminderController@deleteBySelection');
    Route::post('reminder/update','ReminderController@updateReminder')->name('reminderUpdate');
    Route::get('reminder/state/complete/{id}', 'ReminderController@statusComplete')->name('status.complete');
    Route::get('reminder/state/incomplete/{id}', 'ReminderController@statusIncomplete')->name('status.incomplete');
    Route::resource('reminder', 'ReminderController');
    Route::post('interest/deletebyselection','InterestController@deleteBySelection');
    Route::resource('interest', 'InterestController');
    Route::resource('forwarding-letter', 'ForwardingLetterController');
    Route::get('get-export', 'ForwardingLetterController@getExport')->name('get-export');
    Route::get('salary-sheet', 'SalarySheetController@index')->name('salary-sheet-index');
    Route::get('salary-sheet-create', 'SalarySheetController@salarySheetCreate')->name('salary-sheet-create');
    Route::post('salary-sheet-generate', 'SalarySheetController@salarySheetGenerate')->name('salary-sheet.generate');
    Route::post('salary-sheet-confirm', 'SalarySheetController@salarySheetConfirm')->name('salary-sheet.confirm');
    Route::get('salary-sheet/show/{id}', 'SalarySheetController@show')->name('salary-sheet-show');
    Route::delete('salary-sheet/delete/{id}', 'SalarySheetController@destroy')->name('salary-sheet-destroy');
	Route::resource('bill-exchange','BillExchangeController');
    Route::get('all.bank.branches', 'ForwardingLetterController@AllBranches')->name('all.bank.branches');
	Route::resource('commercial-invoice','CommercialInvoiceController');


});

