<?php

use App\Http\Controllers\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegistryController;
use App\Http\Controllers\ReturnsController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ChartsController;
use App\Models\Registry;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });


    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth')
        ->name('logout');
    Route::get('/products/getProducts', [ProductController::class, 'index'])->name('getProducts');
    Route::post('/products/saveProduct', [ProductController::class, 'store'])->name('saveProduct');
    Route::post('/products/saveUpdate', [ProductController::class, 'updateProduct'])->name('saveProductUpdate');
    Route::delete('products/deleteProduct/{product}', [ProductController::class, 'destroy'])->name('deleteProduct');
    Route::post('/products/changePrice', [ProductController::class, 'changePrice'])->name('changePrice');
    Route::post('/products/searchProducts', [ProductController::class, 'search'])->name('searchProduct');

    Route::post('/stocks/saveNewStock', [StockController::class, 'store'])->name('saveNewStock');
    Route::post('/stocks/transferStock', [StockController::class, 'transferStock'])->name('transferStock');
    Route::post('/stocks/approveTransfer', [StockController::class, 'approveTransfer'])->name('approveTransfer');

    Route::patch('/stocks/editStock', [StockController::class, 'updateStock'])->name('updateStock');
    Route::delete('/stocks/deleteStock/{stock}', [StockController::class, 'destroy'])->name('deleteStock');
    // for sales and product pages
    Route::get('/stocks/getStockQty', [StockController::class, 'getStockQty'])->name('getStockQty');
    
    Route::get('/stocks/getSalesStock', [StockController::class, 'getProductQty'])->name('getSalesStock');
    Route::post('/stocks/searchStock', [StockController::class, 'searchStock'])->name('searchStock');
    Route::get('/stocks/getStockHistory', [StockController::class, 'index'])->name('getStockHistory');
    Route::post('/stocks/getByDate', [StockController::class, 'getStockByDate'])->name('getByDate');
    Route::post('/stocks/getByRange', [StockController::class, 'getStockByRange'])->name('getByRange');

    Route::post('/stocks/removeStock', [StockController::class, 'removeStock'])->name('removeStock');
    Route::get('/stocks/getTransferredStock', [StockController::class, 'getTransferStocks'])->name('getTransferredStocks');
    Route::get('/stocks/getPendingTransfer', [StockController::class, 'getPendingTransfer'])->name('getPendingTransfer');
    Route::post('/stocks/approveTransfer', [StockController::class, 'approveTransfer'])->name('approveTransfer');
    Route::get('/stocks/getRemovedStock', [StockController::class, 'getRemovedStocks'])->name('getRemovedStock');
    Route::post('/stocks/searchTransferredStock', [StockController::class, 'getTransferStocks'])->name('searchTransferredStocks');
    Route::post('/stocks/searchRemovedStock', [StockController::class, 'getRemovedStocks'])->name('searchRemovedStock');


    Route::post('/orders/save', [OrderController::class, 'store'])->name('saveSalesOrder');
    Route::delete('orders/delete/{order}', [OrderController::class, 'destroy'])->name('deleteOrder');
    Route::get('/orders/show/{order}', [OrderController::class, 'show'])->name('showSales');
    Route::post('/orders/updatePayment', [OrderController::class, 'store'])->name('updatePayment');


    // for all order list
    Route::get('/orders/getSalesOrder', [OrderController::class, 'index'])->name('getSalesOrder');

    // for all order summary table
    Route::get('/orders/getOrderSummary', [OrderController::class, 'getSalesSummary'])->name('getOrderSummary');

    // for specific sales from a particlar order
    Route::post('/orders/getSales/${order}', [OrderController::class, 'getSalesByOrder'])->name('getSalesByOrder');

    // for specific periods == Orders made
    Route::post('/orders/getSalesByDay', [OrderController::class, 'getSalesByDay'])->name('getSalesByDay');
    Route::post('/orders/getSalesByDate', [OrderController::class, 'getSalesByDate'])->name('getSalesByDate');
    Route::post('/orders/getSalesByMonth', [OrderController::class, 'getSalesByMonth'])->name('getSalesByMonth');
    Route::post('/orders/getSalesByYear', [OrderController::class, 'getSalesByYear'])->name('getSalesByYear');
    Route::post('/orders/getSalesByRange', [OrderController::class, 'getSalesByRange'])->name('getSalesByDateRange');

    Route::post('/orders/search/', [OrderController::class, 'searchSales'])->name('searchSales');
    Route::post('/orders/searchSummary', [OrderController::class, 'searchSummary'])->name('searchSummary');
    Route::get('/getDates/', [OrderController::class, 'getDates'])->name('getDates');
    Route::post('/orders/deleteOrder/', [OrderController::class, 'destroy'])->name('deleteOrder');
    Route::post('/orders/getSalesByOrderNo/', [OrderController::class, 'getSalesByOrderNo'])->name('getSalesByOrderNo');
    Route::post('/transactions/getDeptors', [OrderController::class, 'getDeptors'])->name('getDeptors');

    // Debt Repayment

    Route::get('/incomes/getRepayment', [IncomeController::class, 'getAllDeptRepay'])->name('getAllDeptRepay');
    Route::post('/incomes/saveRepayment', [IncomeController::class, 'saveRepayment'])->name('saveRepayment');
    Route::post('/incomes/getRepayByDate', [IncomeController::class, 'getDeptRepayByDate'])->name('getDeptRepayByDate');
    Route::post('/incomes/getRepayByRange', [IncomeController::class, 'getDeptRepayByRange'])->name('getDeptRepayByRange');
    Route::post('/incomes/searchRepay', [IncomeController::class, 'searchDeptRepay'])->name('searchDeptRepay');
    //Employees 
    Route::get('/employees/getByCompany', [CustomerController::class, 'getEmployees'])->name('getCompanyEmployees');
    Route::post('/employees/saveUpdate', [CustomerController::class, 'updateEmployeeInfo'])->name('saveEmployeeUpdate');
    Route::post('/employees/delete', [CustomerController::class, 'deleteEmployee'])->name('deleteEmployee');


    //Order Returns 
    Route::get('/returns/getReturns', [ReturnsController::class, 'index'])->name('getProductReturn');
    Route::delete('/returns/delete/{return}', [ReturnsController::class, 'destroy'])->name('deleteProductReturn');
    Route::post('/returns/saveUpdate', [ReturnsController::class, 'saveUpdate'])->name('saveReturnUpdate');
    Route::post('/returns/save', [ReturnsController::class, 'store'])->name('saveReturn');
    Route::post('/returned/getByDate', [ReturnsController::class, 'getByDate'])->name('returnsByDate');
    Route::post('/returned/getByRange', [ReturnsController::class, 'getByRange'])->name('returnsbyRange');
    Route::post('/returned/search', [ReturnsController::class, 'search'])->name('searchReturns');
    Route::post('/returns/approveReturns', [ReturnsController::class, 'approveReturn'])->name('approveReturn');
    Route::post('/returns/getUnapproved', [ReturnsController::class, 'getUnapprovedReturns'])->name('getUnapprovedReturns');


    // Registry

    Route::post('/registry/open', [RegistryController::class, 'open_registry'])->name('open_registry');
    Route::post('/registry/close', [RegistryController::class, 'close_reg'])->name('close_registry');
    Route::post('/registry/getByDate', [RegistryController::class, 'getByDate'])->name('getByDate');
    Route::post('/registry/getByRange', [RegistryController::class, 'getByRange'])->name('getByRange');
    Route::get('/registry/getOpeningBal', [RegistryController::class, 'show'])->name('getOpeningBal');
    Route::get('/registry/getRegisters', [RegistryController::class, 'index'])->name('get_registry');
    Route::get('/registry/checkActive', [RegistryController::class, 'checkActive'])->name('checkActiveRegistry');
    Route::post('/registry/getRegistryData', [RegistryController::class, 'getRegistryData'])->name('getRegistryData');
    Route::post('/registry/saveEdit', [RegistryController::class, 'update'])->name('saveEdit');
    Route::post('/registry/searchRegistry', [RegistryController::class, 'searchRegistry'])->name('searchRegistry');

    // Income

    Route::get('/incomes/getIncomes', [IncomeController::class, 'index'])->name('incomes');
    Route::get('/incomes/getIncome/{income}', [IncomeController::class, 'show'])->name('show_income');
    Route::post('/incomes/getByDate', [IncomeController::class, 'getByDate'])->name('getByDate');
    Route::post('/incomes/getByRange', [IncomeController::class, 'getByRange'])->name('getByRange');
    Route::post('/incomes/saveIncome', [IncomeController::class, 'store'])->name('saveIncome');
    Route::post('/incomes/saveUpdate', [IncomeController::class, 'update'])->name('saveUpdate');
    Route::delete('/incomes/deleteIncome/{income}', [IncomeController::class, 'destroy'])->name('deleteIncome');
    Route::post('/incomes/searchIncome', [IncomeController::class, 'searchIncome'])->name('searchIncome');

    // Expense

    Route::get('/expenses/getExpenses', [ExpenseController::class, 'getExpensesOnly'])->name('expenses');
    Route::get('/expenses/getExpense/{expense}', [ExpenseController::class, 'show'])->name('show_expenses');
    Route::post('/expenses/getByDate', [ExpenseController::class, 'getByDate'])->name('getByDate');
    Route::post('/expenses/getByRange', [ExpenseController::class, 'getByRange'])->name('getByRange');
    Route::post('/expenses/saveExpense', [ExpenseController::class, 'store'])->name('saveExpense');
    Route::post('/expenses/saveUpdate', [ExpenseController::class, 'update'])->name('saveExpUpdate');
    Route::delete('/expenses/deleteExpense/{expense}', [ExpenseController::class, 'destroy'])->name('deleteExpenses');
    Route::post('/expenses/searchExpense', [ExpenseController::class, 'searchExpense'])->name('searchExpense');

    //For Fund Transfers

    Route::get('/expenses/getTransfers', [ExpenseController::class, 'getAllTransfer'])->name('getAllTransfer');
    Route::post('/expenses/getTransferByDate', [ExpenseController::class, 'getTransferByDate'])->name('getTransferByDate');
    Route::post('/expenses/getTransferByRange', [ExpenseController::class, 'getTransferByRange'])->name('getTransferByRange');
    Route::post('/expenses/searchTransfer', [ExpenseController::class, 'searchTransfer'])->name('searchTransfer');

    //Transactions Table

    Route::get('/transactions/getTransactions', [TransactionController::class, 'index'])->name('getCompanyTransactions');
    Route::post('/transactions/getByDate', [TransactionController::class, 'getByDate'])->name('getByDate');
    Route::post('/transactions/getByRange', [TransactionController::class, 'getByRange'])->name('getByRange');
    Route::post('/transactions/search', [TransactionController::class, 'searchTransactions'])->name('seacrchTransactions');
    Route::post('/transactions/searchByDate', [TransactionController::class, 'searchByDate'])->name('seachTransByDate');
    Route::post('/transactions/getTodayTransaction', [TransactionController::class, 'getTodayTransaction'])->name('getTodayTransaction');
    Route::post('/transactions/getTodayTransactionPerUser', [TransactionController::class, 'getTodayTransactionPerUser'])->name('getTodayTransactionPerUser');
    // Customers
    Route::get('/customers/getCustomers', [CustomerController::class, 'getByCompany'])->name('getCompanyCustomers');
    Route::delete('/customers/delete/{customer}', [CustomerController::class, 'deleteCustomer'])->name('deleteCustomer');
    Route::post('/customers/saveUpdate', [CustomerController::class, 'saveUpdate'])->name('saveUpdate');


    //Branches

    Route::get('/branches/getBranches', [BranchController::class, 'index'])->name('getBranches');
    Route::post('/branches/saveNew', [BranchController::class, 'store'])->name('saveNewBranch');
    Route::post('/branches/saveUpdate', [BranchController::class, 'update'])->name('updateBranch');
    Route::delete('/branches/delete/{branch}', [BranchController::class, 'destroy'])->name('deleteBranch');
  //  Route::post('/branches/activateBranch', [BranchController::class, 'activateBranch'])->name('activateBranch');
   

// Employees 

Route::get('/employees/getEmployees', [UserController::class, 'index'])->name('getEmployees');
Route::post('/employees/saveNew', [UserController::class, 'store'])->name('saveNewEmployee');
Route::post('/employees/saveUpdate', [UserController::class, 'update'])->name('updateEmployee');
Route::delete('/employees/delete/{user}', [UserController::class, 'destroy'])->name('deleteEmployee');


  //Subscriptions
    Route::get('/subscriptions/getPlans', [SubscriptionController::class, 'index'])->name('getPlans');
    Route::post('/subscriptions/renew', [SubscriptionController::class, 'renewPlan'])->name('renewPlan');
    Route::get('/subscriptions/checkSubscription/{company}', [SubscriptionController::class, 'checkSub'])->name('getCompanyCustomers');
    Route::post('/subscriptions/subscribe', [SubscriptionController::class, 'getByCompany'])->name('getCompanyCustomers');


    //Permissions
    Route::get('/permissions/create', [PermissionController::class, 'index'])->name('createPermissions');
    Route::post('/roles/saveNew', [RoleController::class, 'store'])->name('saveNewRole');
    Route::get('/roles/getCompanyRoles', [RoleController::class, 'index'])->name('getCompanyRoles');
    Route::post('/roles/saveUpdate', [RoleController::class, 'update'])->name('roleUpdate');
    Route::delete('/roles/delete/{role}', [RoleController::class, 'destroy'])->name('deleteRole');
    Route::get('/permissions/getPermissions', [PermissionController::class, 'getPermisssions'])->name('getPermisssions');


    // Admin task
    Route::get('/admin/getSubscribers', [CustomerController::class, 'getByCompany'])->name('getCompanyCustomers');
    Route::post('/admin/approveSubscription', [CustomerController::class, 'getByCompany'])->name('getCompanyCustomers');
    Route::get('/admin/getCompanies', [CustomerController::class, 'deleteCustomer'])->name('deleteCustomer');
    Route::get('/admin/agents', [CustomerController::class, 'deleteCustomer'])->name('deleteCustomer');
    Route::get('/admin/saveNewAgent', [CustomerController::class, 'deleteCustomer'])->name('deleteCustomer');
    Route::get('/admin/agents/acct_details', [CustomerController::class, 'deleteCustomer'])->name('deleteCustomer');
    Route::post('/companies/saveUpdate', [CustomerController::class, 'deleteCustomer'])->name('deleteCustomer');
    Route::delete('/companies/delete/{company}', [CustomerController::class, 'deleteCustomer'])->name('deleteCustomer');
    Route::post('/admin/deleteAgent', [CustomerController::class, 'deleteCustomer'])->name('deleteCustomer');

    Route::get('/companies/getCompany', [CompanyController::class, 'getCompany'])->name('getCompany');
    Route::post('/companies/saveNew', [CompanyController::class, 'store'])->name('newCompany');
    Route::post('/companies/updateCompany', [CompanyController::class, 'update'])->name('saveCompanyUpdate');
    Route::post('/companies/saveTheme', [CompanyController::class, 'saveTheme'])->name('saveTheme');
    Route::get('/companies/getTheme', [CompanyController::class, 'getTheme'])->name('getTheme');

// Chart Records

Route::get('/charts/getStocks', [ChartsController::class, 'getStock'])->name('getStock');
Route::get('/charts/getSales', [ChartsController::class, 'getSales'])->name('getSales');
Route::get('/charts/getIncomeExpenses', [ChartsController::class, 'getIncomeExpenses'])->name('getIncomeExpenses');
Route::get('/charts/getRevenue', [ChartsController::class, 'getRevenue'])->name('getRevenue');
Route::get('/charts/getPayments', [ChartsController::class, 'getPayments'])->name('getPayments');
Route::get('/charts/getDashInfo', [ChartsController::class, 'getDashInfo'])->name('getDashInfo');

});
