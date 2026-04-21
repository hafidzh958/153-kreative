<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\MissionController as AdminMissionController;
use App\Http\Controllers\Admin\ProcessController as AdminProcessController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\AboutController as AdminAboutController;
use App\Http\Controllers\Admin\FinanceController as AdminFinanceController;

Route::get('/', fn() => view('user.intro'));
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio');
Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
use App\Models\AboutSetting;
use App\Models\Mission;
use App\Models\Process;

Route::get('/about', function () {
    $about = AboutSetting::firstOrNew(['id' => 1]);
    $missions = Mission::orderBy('order')->get();
    $processes = Process::orderBy('order')->get();
    return view('user.about', compact('about', 'missions', 'processes'));
})->name('about');

// Admin Auth Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [\App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [\App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login.submit');
    Route::post('logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');
});

// Admin Protected Routes
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.home.index');
    })->name('dashboard.redirect');

    Route::get('home', [AdminHomeController::class, 'index'])->name('home.index');
    Route::put('home', [AdminHomeController::class, 'update'])->name('home.update');

    // Finance Dashboard - Overview
    Route::get('finance', [AdminFinanceController::class, 'index'])->name('finance.index');
    Route::get('finance/api/stats', [AdminFinanceController::class, 'apiStats'])->name('finance.api.stats');

    // Finance - Invoices
    Route::get('finance/invoices', [\App\Http\Controllers\Admin\Finance\InvoiceController::class, 'index'])->name('finance.invoices.index');
    Route::get('finance/invoices/export', [\App\Http\Controllers\Admin\Finance\InvoiceController::class, 'exportExcel'])->name('finance.invoices.export');
    Route::get('finance/invoices/create', [\App\Http\Controllers\Admin\Finance\InvoiceController::class, 'create'])->name('finance.invoices.create');
    Route::post('finance/invoices', [\App\Http\Controllers\Admin\Finance\InvoiceController::class, 'store'])->name('finance.invoices.store');
    Route::get('finance/invoices/{invoice}', [\App\Http\Controllers\Admin\Finance\InvoiceController::class, 'show'])->name('finance.invoices.show');
    Route::get('finance/invoices/{invoice}/edit', [\App\Http\Controllers\Admin\Finance\InvoiceController::class, 'edit'])->name('finance.invoices.edit');
    Route::get('finance/invoices/{invoice}/pdf', [\App\Http\Controllers\Admin\Finance\InvoiceController::class, 'pdf'])->name('finance.invoices.pdf');
    Route::put('finance/invoices/{invoice}', [\App\Http\Controllers\Admin\Finance\InvoiceController::class, 'update'])->name('finance.invoices.update');
    Route::patch('finance/invoices/{invoice}/status', [\App\Http\Controllers\Admin\Finance\InvoiceController::class, 'updateStatus'])->name('finance.invoices.status');
    Route::delete('finance/invoices/{invoice}', [\App\Http\Controllers\Admin\Finance\InvoiceController::class, 'destroy'])->name('finance.invoices.destroy');

    // Finance - Quotations
    Route::get('finance/quotations', [\App\Http\Controllers\Admin\Finance\QuotationController::class, 'index'])->name('finance.quotations.index');
    Route::get('finance/quotations/export', [\App\Http\Controllers\Admin\Finance\QuotationController::class, 'exportExcel'])->name('finance.quotations.export');
    Route::post('finance/quotations', [\App\Http\Controllers\Admin\Finance\QuotationController::class, 'store'])->name('finance.quotations.store');
    Route::put('finance/quotations/{quotation}', [\App\Http\Controllers\Admin\Finance\QuotationController::class, 'update'])->name('finance.quotations.update');
    Route::patch('finance/quotations/{quotation}/status', [\App\Http\Controllers\Admin\Finance\QuotationController::class, 'updateStatus'])->name('finance.quotations.status');
    Route::post('finance/quotations/{quotation}/convert', [\App\Http\Controllers\Admin\Finance\QuotationController::class, 'convert'])->name('finance.quotations.convert');
    Route::get('finance/quotations/{quotation}/pdf', [\App\Http\Controllers\Admin\Finance\QuotationController::class, 'pdf'])->name('finance.quotations.pdf');
    Route::delete('finance/quotations/{quotation}', [\App\Http\Controllers\Admin\Finance\QuotationController::class, 'destroy'])->name('finance.quotations.destroy');

    // Finance - Purchase Orders
    Route::get('finance/purchase-orders', [\App\Http\Controllers\Admin\Finance\PurchaseOrderController::class, 'index'])->name('finance.purchase-orders.index');
    Route::post('finance/purchase-orders', [\App\Http\Controllers\Admin\Finance\PurchaseOrderController::class, 'store'])->name('finance.purchase-orders.store');
    Route::put('finance/purchase-orders/{purchaseOrder}', [\App\Http\Controllers\Admin\Finance\PurchaseOrderController::class, 'update'])->name('finance.purchase-orders.update');
    Route::post('finance/purchase-orders/{purchaseOrder}/approve', [\App\Http\Controllers\Admin\Finance\PurchaseOrderController::class, 'approve'])->name('finance.purchase-orders.approve');
    Route::post('finance/purchase-orders/{purchaseOrder}/reject', [\App\Http\Controllers\Admin\Finance\PurchaseOrderController::class, 'reject'])->name('finance.purchase-orders.reject');
    Route::patch('finance/purchase-orders/{purchaseOrder}/payment', [\App\Http\Controllers\Admin\Finance\PurchaseOrderController::class, 'updatePayment'])->name('finance.purchase-orders.payment');
    Route::delete('finance/purchase-orders/{purchaseOrder}', [\App\Http\Controllers\Admin\Finance\PurchaseOrderController::class, 'destroy'])->name('finance.purchase-orders.destroy');

    // Finance - Expenses
    Route::get('finance/expenses', [\App\Http\Controllers\Admin\Finance\ExpenseController::class, 'index'])->name('finance.expenses.index');
    Route::get('finance/expenses/export', [\App\Http\Controllers\Admin\Finance\ExpenseController::class, 'exportExcel'])->name('finance.expenses.export');
    Route::post('finance/expenses', [\App\Http\Controllers\Admin\Finance\ExpenseController::class, 'store'])->name('finance.expenses.store');
    Route::put('finance/expenses/{expense}', [\App\Http\Controllers\Admin\Finance\ExpenseController::class, 'update'])->name('finance.expenses.update');
    Route::delete('finance/expenses/{expense}', [\App\Http\Controllers\Admin\Finance\ExpenseController::class, 'destroy'])->name('finance.expenses.destroy');

    // Finance - Budgets
    Route::get('finance/budgets', [\App\Http\Controllers\Admin\Finance\BudgetController::class, 'index'])->name('finance.budgets.index');
    Route::post('finance/budgets', [\App\Http\Controllers\Admin\Finance\BudgetController::class, 'store'])->name('finance.budgets.store');
    Route::put('finance/budgets/{budget}', [\App\Http\Controllers\Admin\Finance\BudgetController::class, 'update'])->name('finance.budgets.update');
    Route::delete('finance/budgets/{budget}', [\App\Http\Controllers\Admin\Finance\BudgetController::class, 'destroy'])->name('finance.budgets.destroy');

    // Finance - Projects
    Route::get('finance/projects', [\App\Http\Controllers\Admin\Finance\ProjectController::class, 'index'])->name('finance.projects.index');
    Route::post('finance/projects', [\App\Http\Controllers\Admin\Finance\ProjectController::class, 'store'])->name('finance.projects.store');
    Route::put('finance/projects/{project}', [\App\Http\Controllers\Admin\Finance\ProjectController::class, 'update'])->name('finance.projects.update');
    Route::delete('finance/projects/{project}', [\App\Http\Controllers\Admin\Finance\ProjectController::class, 'destroy'])->name('finance.projects.destroy');

    // Finance - Bank & Kas
    Route::get('finance/bank', [\App\Http\Controllers\Admin\Finance\BankController::class, 'index'])->name('finance.bank.index');
    Route::post('finance/bank/accounts', [\App\Http\Controllers\Admin\Finance\BankController::class, 'storeAccount'])->name('finance.bank.accounts.store');
    Route::put('finance/bank/accounts/{bankAccount}', [\App\Http\Controllers\Admin\Finance\BankController::class, 'updateAccount'])->name('finance.bank.accounts.update');
    Route::delete('finance/bank/accounts/{bankAccount}', [\App\Http\Controllers\Admin\Finance\BankController::class, 'destroyAccount'])->name('finance.bank.accounts.destroy');
    Route::post('finance/bank/mutations', [\App\Http\Controllers\Admin\Finance\BankController::class, 'storeMutation'])->name('finance.bank.mutations.store');
    Route::delete('finance/bank/mutations/{mutation}', [\App\Http\Controllers\Admin\Finance\BankController::class, 'destroyMutation'])->name('finance.bank.mutations.destroy');

    // Finance - Incomes
    Route::get('finance/incomes', [\App\Http\Controllers\Admin\Finance\IncomeController::class, 'index'])->name('finance.incomes.index');
    Route::get('finance/incomes/export', [\App\Http\Controllers\Admin\Finance\IncomeController::class, 'exportExcel'])->name('finance.incomes.export');
    Route::post('finance/incomes', [\App\Http\Controllers\Admin\Finance\IncomeController::class, 'store'])->name('finance.incomes.store');
    Route::delete('finance/incomes/{income}', [\App\Http\Controllers\Admin\Finance\IncomeController::class, 'destroy'])->name('finance.incomes.destroy');

    // Finance - Commissions
    Route::get('finance/commissions', [\App\Http\Controllers\Admin\Finance\CommissionController::class, 'index'])->name('finance.commissions.index');
    Route::post('finance/commissions', [\App\Http\Controllers\Admin\Finance\CommissionController::class, 'store'])->name('finance.commissions.store');
    Route::put('finance/commissions/{commission}', [\App\Http\Controllers\Admin\Finance\CommissionController::class, 'update'])->name('finance.commissions.update');
    Route::post('finance/commissions/{commission}/approve', [\App\Http\Controllers\Admin\Finance\CommissionController::class, 'approve'])->name('finance.commissions.approve');
    Route::post('finance/commissions/{commission}/pay', [\App\Http\Controllers\Admin\Finance\CommissionController::class, 'pay'])->name('finance.commissions.pay');
    Route::delete('finance/commissions/{commission}', [\App\Http\Controllers\Admin\Finance\CommissionController::class, 'destroy'])->name('finance.commissions.destroy');


    // Home Services CRUD
    Route::post('home/services', [AdminHomeController::class, 'storeService'])->name('home.services.store');
    Route::put('home/services/{id}', [AdminHomeController::class, 'updateService'])->name('home.services.update');
    Route::delete('home/services/{id}', [AdminHomeController::class, 'deleteService'])->name('home.services.destroy');
    Route::post('home/services/reorder', [AdminHomeController::class, 'reorderService'])->name('home.services.reorder');

    // Home Projects CRUD
    Route::post('home/projects', [AdminHomeController::class, 'storeProject'])->name('home.projects.store');
    Route::put('home/projects/{id}', [AdminHomeController::class, 'updateProject'])->name('home.projects.update');
    Route::delete('home/projects/{id}', [AdminHomeController::class, 'deleteProject'])->name('home.projects.destroy');
    Route::post('home/projects/reorder', [AdminHomeController::class, 'reorderProject'])->name('home.projects.reorder');

    // About Page Management
    Route::get('about', [AdminAboutController::class, 'index'])->name('about.index');
    Route::put('about', [AdminAboutController::class, 'update'])->name('about.update');

    // Portfolio Categories
    Route::get('portfolio/categories', [\App\Http\Controllers\Admin\PortfolioCategoryController::class, 'index'])->name('portfolio.categories.index');
    Route::post('portfolio/categories', [\App\Http\Controllers\Admin\PortfolioCategoryController::class, 'store'])->name('portfolio.categories.store');
    Route::put('portfolio/categories/{id}', [\App\Http\Controllers\Admin\PortfolioCategoryController::class, 'update'])->name('portfolio.categories.update');
    Route::delete('portfolio/categories/{id}', [\App\Http\Controllers\Admin\PortfolioCategoryController::class, 'destroy'])->name('portfolio.categories.destroy');

    // Portfolio
    Route::get('portfolio', [AdminPortfolioController::class, 'index'])->name('portfolio.index');
    Route::post('portfolio', [AdminPortfolioController::class, 'store'])->name('portfolio.store');
    Route::post('portfolio/reorder', [AdminPortfolioController::class, 'reorder'])->name('portfolio.reorder');
    Route::put('portfolio/settings', [AdminPortfolioController::class, 'updateSettings'])->name('portfolio.settings.update');
    Route::put('portfolio/{id}', [AdminPortfolioController::class, 'update'])->name('portfolio.update');
    Route::delete('portfolio/{id}', [AdminPortfolioController::class, 'destroy'])->name('portfolio.destroy');
    // Services Management
    Route::get('services', [AdminServiceController::class, 'index'])->name('services.index');
    Route::post('services', [AdminServiceController::class, 'store'])->name('services.store');
    Route::post('services/reorder', [AdminServiceController::class, 'reorder'])->name('services.reorder');
    Route::put('services/settings', [AdminServiceController::class, 'updateSettings'])->name('services.settings.update');
    Route::put('services/{service}', [AdminServiceController::class, 'update'])->name('services.update');
    Route::delete('services/{service}', [AdminServiceController::class, 'destroy'])->name('services.destroy');

    // Service Features CRUD
    Route::post('services/{service}/features', [AdminServiceController::class, 'storeFeature'])->name('services.features.store');
    Route::put('services/features/{feature}', [AdminServiceController::class, 'updateFeature'])->name('services.features.update');
    Route::delete('services/features/{feature}', [AdminServiceController::class, 'destroyFeature'])->name('services.features.destroy');

    Route::resource('missions', AdminMissionController::class);
    Route::resource('processes', AdminProcessController::class);

    // Clients (Mitra)
    Route::resource('clients', \App\Http\Controllers\Admin\ClientController::class);
    // Testimonials (Review)
    Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class);

    // Contact Page Management
    Route::get('contact', [AdminContactController::class, 'index'])->name('contact.index');
    Route::put('contact', [AdminContactController::class, 'update'])->name('contact.update');
    Route::resource('settings', AdminSettingController::class)->only(['index', 'update']);
});