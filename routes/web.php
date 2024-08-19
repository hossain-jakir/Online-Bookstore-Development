<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\TagController;
use App\Http\Controllers\Backend\BookController;
use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\OrderController as BackendOrderController;
use App\Http\Controllers\Backend\PaymentController as BackendPaymentController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\ShopController;
use App\Http\Controllers\Backend\TransactionController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\Payment\PaymentController;
use App\Http\Controllers\Frontend\BookController as FrontendBookController;
use App\Http\Controllers\Frontend\HomeController as FrontendHomeController;
use App\Http\Controllers\Frontend\AuthorController as FrontendAuthorController;
use App\Http\Controllers\Frontend\ProfileController as FrontendProfileController;
use App\Http\Controllers\Frontend\CategoryController as FrontendCategoryController;
use App\Http\Controllers\Frontend\OrderController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [FrontendHomeController::class, 'index'])->name('home');
Route::get('/about-us', [FrontendHomeController::class, 'aboutUs'])->name('about-us');
Route::get('/privacy-policy', [FrontendHomeController::class, 'privacyPolicy'])->name('privacy-policy');
Route::post('/subscribe', [FrontendHomeController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/faq', [FrontendHomeController::class, 'faq'])->name('faq');
Route::get('/clear-cache', [FrontendHomeController::class, 'clearCache']);

Route::prefix('contact-us')->group(function () {
    Route::get('/', [FrontendHomeController::class, 'contactUs'])->name('contact-us');
    Route::post('/send', [FrontendHomeController::class, 'sendContactUs'])->name('contact-us.send');
});

Route::prefix('wishlist')->group(function () {
    Route::get('/', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/store', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::post('/delete/{id}', [WishlistController::class, 'delete'])->name('wishlist.delete');
    Route::post('/deleteAll', [WishlistController::class, 'deleteAll'])->name('wishlist.delete.all');
});

Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::get('/get-cart-items', [CartController::class, 'getCartItems'])->name('cart.get-cart-items');
    Route::post('/store', [CartController::class, 'store'])->name('cart.store');
    Route::post('/update-cart', [CartController::class, 'updateQuantity'])->name('update-cart');
    Route::post('/remove-cart-item', [CartController::class, 'removeItem'])->name('remove-cart-item');
    Route::post('/update-delivery-fee', [CartController::class, 'updateDeliveryFee'])->name('update-delivery-fee');
    Route::post('/apply-coupon', [CartController::class, 'applyCoupon'])->name('apply-coupon');
    Route::post('/remove-coupon', [CartController::class, 'removeCoupon'])->name('remove-coupon');
});

Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/paypal', [PaymentController::class, 'paypal'])->name('checkout.paypal');
    Route::get('/payment-with-paypal', [PaymentController::class, 'showPaymentForm'])->name('checkout.paypal.form');
    Route::get('/paypal/success', [PaymentController::class, 'paypalSuccess'])->name('checkout.paypal.success');
    Route::get('/paypal/cancel', [PaymentController::class, 'paypalCancel'])->name('checkout.paypal.cancel');
    //Due payment
    Route::get('/payment-due-with-paypal', [PaymentController::class, 'showPaymentDueForm'])->name('checkout.paypal.form.due');
    Route::post('/paypal/due', [PaymentController::class, 'paypalDuePay'])->name('checkout.paypal.due');
    Route::get('/paypal/due/success', [PaymentController::class, 'paypalDueSuccess'])->name('checkout.paypal.due.success');
});

Route::prefix('book')->group(function () {
    Route::get('book-list', [FrontendBookController::class, 'bookList'])->name('book.bookList');
    Route::get('/grid', [FrontendBookController::class, 'index'])->name('book.grid');
    Route::get('/list', [FrontendBookController::class, 'index'])->name('book.list');
    Route::get('/search', [FrontendBookController::class, 'search'])->name('book.search');
    Route::get('/', [FrontendBookController::class, 'index'])->name('book.index');
    Route::get('/{id}', [FrontendBookController::class, 'show'])->name('book.show');
});

Route::prefix('category')->group(function () {
    Route::get('/', [FrontendCategoryController::class, 'showAllCategories'])->name('category.index');
    Route::get('/all', [FrontendCategoryController::class, 'showAllCategories'])->name('category.all');
    Route::get('/{slug}', [FrontendBookController::class, 'showByCategory'])->name('category');
});

Route::prefix('author')->group(function () {
    Route::get('/', [FrontendAuthorController::class, 'index'])->name('author.index');
    Route::get('/all', [FrontendAuthorController::class, 'index'])->name('author.all');
    Route::get('/{id}', [FrontendBookController::class, 'showByAuthor'])->name('author.show');
});

Route::prefix('profile')->middleware(['auth'])->group(function () {
    Route::get('/', [FrontendProfileController::class, 'index'])->name('profile.index');
    Route::post('/', [FrontendProfileController::class, 'update'])->name('profile.update');
    Route::delete('/', [FrontendProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/change-password', [FrontendProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::get('address', [FrontendProfileController::class, 'address'])->name('profile.address');
    Route::post('/address', [FrontendProfileController::class, 'storeAddress'])->name('profile.address.store');
    Route::post('/profile/address/default', [FrontendProfileController::class, 'updateDefaultAddress'])->name('profile.address.default');
    Route::post('/address/delete/{id}', [FrontendProfileController::class, 'deleteAddress'])->name('profile.address.delete');
    Route::get('/orders', [OrderController::class, 'index'])->name('profile.orders');
    Route::get('/orders/{id}/{order_number}', [OrderController::class, 'show'])->name('profile.order.show');
    Route::get('/order-tracking/{id}/{order_number}', [OrderController::class, 'trackOrder'])->name('profile.order.track');
    Route::get('/order/{id}/{order_number}/invoice', [OrderController::class, 'invoice'])->name('profile.order.invoice');

});

Route::prefix('webhook')->group( function(){
    Route::post('/paddle', [PaymentController::class, 'paddleWebhook'])->name('webhook.paddle');
});

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::prefix('dashboard')->middleware(['auth', 'verified', 'role_or_permission:role,super-admin|admin'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('backend.dashboard');
    Route::get('/get-stats', [HomeController::class, 'getStats'])->name('backend.home.getStats');

    Route::prefix('to-do')->group(function () {
        Route::post('/store', [HomeController::class, 'addToDo'])->name('backend.home.addToDo');
        Route::post('/update/{toDo}', [HomeController::class, 'updateToDo'])->name('backend.home.updateToDo');
        Route::post('/update/{toDo}/status', [HomeController::class, 'toggleStatus'])->name('backend.home.updateToDo.status');
        Route::delete('/delete/{toDo}', [HomeController::class, 'deleteToDo'])->name('backend.home.deleteToDo');
    });

    Route::prefix('role')->middleware('role_or_permission:permission,view role')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('backend.role.index');
        Route::post('/store', [RoleController::class, 'store'])->name('backend.role.store');
        Route::post('/update/{id}', [RoleController::class, 'update'])->name('backend.role.update');
        Route::post('/update/user/role', [RoleController::class, 'updateUserRole'])->name('backend.role.update.user');
        Route::post('/delete/{id}', [RoleController::class, 'delete'])->name('backend.role.delete');
    });
    Route::prefix('user')->middleware('role_or_permission:permission,view user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('backend.user.index');
        Route::get('/getAllUsers', [UserController::class, 'getAllUsers'])->name('backend.user.getAllUsers');
        // Route::get('/create', [UserController::class, 'create'])->name('backend.user.create');
        // Route::post('/store', [UserController::class, 'store'])->name('backend.user.store');
        // Route::get('/edit/{id}', [UserController::class, 'edit'])->name('backend.user.edit');
        Route::get('/update/status/{id}', [UserController::class, 'updateStatus'])->name('backend.user.update.status');
        Route::get('/delete/{id}', [UserController::class, 'delete'])->name('backend.user.delete');
    });
    Route::prefix('category')->middleware('role_or_permission:permission,view category')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('backend.category.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('backend.category.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('backend.category.store');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('backend.category.edit');
        Route::post('/update/{id}', [CategoryController::class, 'update'])->name('backend.category.update');
        Route::post('/delete/{id}', [CategoryController::class, 'destroy'])->name('backend.category.delete');
    });
    Route::prefix('book')->middleware('role_or_permission:permission,view book')->group(function () {
        Route::get('/', [BookController::class, 'index'])->name('backend.book.index');
        Route::get('/list', [BookController::class, 'list'])->name('backend.book.list');
        Route::get('/create', [BookController::class, 'create'])->name('backend.book.create');
        Route::post('/store', [BookController::class, 'store'])->name('backend.book.store');
        Route::get('/edit/{id}', [BookController::class, 'edit'])->name('backend.book.edit');
        Route::post('/update/{id}', [BookController::class, 'update'])->name('backend.book.update');
        Route::post('/delete/{id}', [BookController::class, 'destroy'])->name('backend.book.delete');
    });

    Route::prefix('order')->group(function () {
        Route::get('/', [BackendOrderController::class, 'index'])->name('backend.order.index');
        Route::get('/{id}', [BackendOrderController::class, 'show'])->name('backend.order.show');
        Route::get('/edit/{id}', [BackendOrderController::class, 'edit'])->name('backend.order.edit');
        Route::put('/update/{id}', [BackendOrderController::class, 'update'])->name('backend.order.update');
        Route::delete('/delete/{id}', [BackendOrderController::class, 'destroy'])->name('backend.order.destroy');
        Route::get('/order-tracking/{id}', [BackendOrderController::class, 'trackOrder'])->name('backend.order.track');
        Route::get('/order/{id}/invoice', [BackendOrderController::class, 'invoice'])->name('backend.order.invoice');
        Route::put('orders/{id}/update-status', [BackendOrderController::class, 'updateStatus'])->name('backend.order.updateStatus');
        Route::put('order/{id}/update-items', [BackendOrderController::class, 'updateItems'])->name('backend.order.updateItems');
        Route::put('order/{id}/apply-discount', [BackendOrderController::class, 'applyDiscount'])->name('backend.order.applyDiscount');
        Route::put('/order/{id}/update-shipping-address', [BackendOrderController::class, 'updateShippingAddress'])->name('backend.order.updateShippingAddress');
        Route::put('/orders/{id}/update-delivery-fee', [BackendOrderController::class, 'updateDeliveryFee'])->name('backend.order.updateDeliveryFee');

        //refund
        Route::get('/refund/{orderId}', [BackendPaymentController::class, 'refundPayment'])->name('backend.order.refund');
    });

    Route::prefix('transaction')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('backend.transaction.index');
        Route::get('/get-transactions', [TransactionController::class, 'getTransactions'])->name('backend.transaction.getTransactions');
    });

    Route::prefix('shop')->group(function () {
        Route::get('/', [ShopController::class, 'index'])->name('backend.shop.index');
        Route::post('/', [ShopController::class, 'update'])->name('backend.shop.update');
    });

    Route::prefix('report')->group(function () {
        Route::get('sales-report/{year}/{month?}', [ReportController::class, 'salesReport'])->name('backend.report.salesReport');
        Route::get('daily-sales/{year}/{month}', [ReportController::class, 'dailySales'])->name('backend.report.dailySales');
        Route::get('monthly-sales/{year}', [ReportController::class, 'monthlySales'])->name('backend.report.monthlySales');
        Route::get('best-seller', [ReportController::class, 'bestSeller'])->name('backend.report.bestSeller');
        Route::get('best-selling-authors', [ReportController::class, 'bestSellingAuthors'])->name('backend.report.bestSellingAuthors');
    });


});


require __DIR__.'/auth.php';
