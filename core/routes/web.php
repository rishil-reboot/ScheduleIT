<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\FrontendController;
use App\Http\Controllers\Admin\FormBuilderController;
use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\ForgetController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\SummernoteController;
use App\Http\Controllers\User\SummernoteController as UserSummernoteController;
use App\Http\Controllers\Admin\InboxwebmailController;
use App\Http\Controllers\Front\TransactionController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Front\ConvertImageToPDFController;
use App\Http\Controllers\Admin\ConvertImageToPDFController as AdminConvertImageToPDFController;
use App\Http\Controllers\Front\MetaViewerController;
use App\Http\Controllers\Admin\MetaViewerController as AdminMetaViewerController;
use App\Http\Controllers\Payment\PaypalController;
use App\Http\Controllers\Payment\StripeController;
use App\Http\Controllers\Payment\PaystackController;
use App\Http\Controllers\Payment\PaytmController;
use App\Http\Controllers\Payment\FlutterWaveController;
use App\Http\Controllers\Payment\InstamojoController;
use App\Http\Controllers\Payment\MollieController;
use App\Http\Controllers\Payment\RazorpayController;
use App\Http\Controllers\Payment\MercadopagoController;
use App\Http\Controllers\Payment\PayumoneyController;
use App\Http\Controllers\Payment\OfflineController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Front\ReviewController;
use App\Http\Controllers\Payment\Product\PaymentController as ProductPaymentController;
use App\Http\Controllers\Payment\Product\StripeController as ProductStripeController;
use App\Http\Controllers\Payment\Product\OfflineController as ProductOfflineController;
use App\Http\Controllers\Payment\Product\FlutterWaveController as ProductFlutterWaveController;
use App\Http\Controllers\Payment\Product\PaystackController as ProductPaystackController;
use App\Http\Controllers\Payment\Product\RazorpayController as ProductRazorpayController;
use App\Http\Controllers\Payment\Product\InstamojoController as ProductInstamojoController;
use App\Http\Controllers\Payment\Product\PaytmController as ProductPaytmController;
use App\Http\Controllers\Payment\Product\MollieController as ProductMollieController;
use App\Http\Controllers\Payment\Product\MercadopagoController as ProductMercadopagoController;
use App\Http\Controllers\Payment\Product\PayumoneyController as ProductPayumoneyController;
use App\Http\Controllers\User\LoginController as UserLoginController;
use App\Http\Controllers\User\RegisterController;
use App\Http\Controllers\User\ForgotController;
use App\Http\Controllers\User\QrcodeController;
use App\Http\Controllers\Admin\QrcodeController as AdminQrcodeController;
use App\Http\Controllers\User\LoginSecurityController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\TicketController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Front\ChatController;
use App\Http\Controllers\Admin\ChatController as AdminChatController;
use App\Http\Controllers\Front\BookingController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Front\BuyCreditController;
use App\Http\Controllers\Front\ReservationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TwilioCreditController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\BasicController;
use App\Http\Controllers\Admin\EmailController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Admin\SocialController;
use App\Http\Controllers\Admin\ScreenRecorderController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\HerosectionController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\IntrosectionController;
use App\Http\Controllers\Admin\ServicesectionController;
use App\Http\Controllers\Admin\ApproachController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Admin\CtaController;
use App\Http\Controllers\Admin\PortfoliosectionController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\AdvertisementController;
use App\Http\Controllers\Admin\BlogsectionController;
use App\Http\Controllers\Admin\EducationSectionController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\MenuBuilderController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\CustomerFaqController;
use App\Http\Controllers\Admin\FaqCategoryController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\FooterController;
use App\Http\Controllers\Admin\UlinkController;
use App\Http\Controllers\Admin\ScategoryController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ProductCategory;
use App\Http\Controllers\Admin\ProductSubCategory;
use App\Http\Controllers\Admin\ShopSettingController;
use App\Http\Controllers\Admin\ProductOrderController;
use App\Http\Controllers\Admin\ProductTemplateController;
use App\Http\Controllers\Admin\RegisterUserController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\PortfolioCategoryController;
use App\Http\Controllers\Admin\JcategoryController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\BcategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ArchiveController;
use App\Http\Controllers\Admin\EducationBlogCategoryController;
use App\Http\Controllers\Admin\EducationTagController;
use App\Http\Controllers\Admin\EducationBlogController;
use App\Http\Controllers\Admin\RssFeedsController;
use App\Http\Controllers\Admin\SitemapController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\QuoteController;
use App\Http\Controllers\Admin\GatewayController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\CacheController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\StepsSectionController;
use App\Http\Controllers\Admin\FreeAppSectionController;
use App\Http\Controllers\Admin\TechnicianController;
use App\Http\Controllers\Admin\CompanyController;

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

Route::group(['middleware' => ['xssSanitizer']], function () {
  Route::get('/backup', [FrontendController::class, 'backup']);

  /*=======================================================
******************** Front Routes **********************
=======================================================*/

  Route::group(['middleware' => 'setlang'], function () {

    Route::get('/form-builder/{slug}', [FormBuilderController::class, 'getFormBuilder']);
    Route::post('/form-builder-submit', [FormBuilderController::class, 'postFormBuilder']);


    Route::get('/', [FrontendController::class, 'index'])->name('front.index');
    //frontend Route imagToPdf and Metaviewer
    Route::post('/convert-image-to-pdf', [ConvertImageToPDFController::class, 'convertImageToPdf'])->name('front.convertImageToPdf');
    Route::post('/get-download-file', [ConvertImageToPDFController::class, 'getDownloadFile'])->name('front.get-download-file');
    Route::post('/remove-file-from-server', [ConvertImageToPDFController::class, 'removeFileFromServer'])->name('front.removeFileFromServer');
    Route::post('/get-metadata-preview', [MetaViewerController::class, 'getMetaDataPreview'])->name('front.getMetaDataPreview');
    Route::post('/remove-metadata-file-from-server', [MetaViewerController::class, 'removeFileFromServer'])->name('front.removeMetaFileFromServer');


    Route::get('/clients', [FrontendController::class, 'clients'])->name('front.client');
    Route::get('/clients/{slug}', [FrontendController::class, 'clientDetail'])->name('front.clientDetail');
    Route::get('/partners', [FrontendController::class, 'partners'])->name('front.partners');
    Route::get('/partners/{slug}', [FrontendController::class, 'partnerDetail'])->name('front.partnerDetail');

    Route::get('/testimonial', [FrontendController::class, 'testimonial'])->name('front.testimonial');
    Route::get('/services', [FrontendController::class, 'services'])->name('front.services');
    Route::get('/services/{slug}/category', [FrontendController::class, 'serviceCategory'])->name('front.serviceCategory');
    Route::get('/service/{slug}', [FrontendController::class, 'servicedetails'])->name('front.servicedetails');
    Route::get('/packages', [FrontendController::class, 'packages'])->name('front.packages');
    Route::get('/portfolios', [FrontendController::class, 'portfolios'])->name('front.portfolios');
    Route::get('/portfolio/{slug}', [FrontendController::class, 'portfoliodetails'])->name('front.portfoliodetails');
    Route::get('/portfolio/{slug}/category', [FrontendController::class, 'portfolios'])->name('front.portfoliocategory');

    Route::get('/blogs', [FrontendController::class, 'blogs'])->name('front.blogs');
    Route::get('/blogs/{categorySlug}/category', [FrontendController::class, 'blogCategory'])->name('front.blogCategory');
    Route::get('/blog-details/{slug}', [FrontendController::class, 'blogdetails'])->name('front.blogdetails');
    Route::get('/blogs/{year}/{month}', [FrontendController::class, 'getBlogYearMonthWise'])->name('front.getBlogYearMonthWise');

    Route::get('/rss', [FrontendController::class, 'rss'])->name('front.rss');
    Route::get('/rss/category/{id}', [FrontendController::class, 'rcatpost'])->name('front.rcatpost');
    Route::get('/rss-details/{slug}/{id}', [FrontendController::class, 'rssdetails'])->name('front.rssdetails');

    Route::get('/contact', [FrontendController::class, 'contact'])->name('front.contact');
    Route::post('/sendmail', [FrontendController::class, 'sendmail'])->name('front.sendmail');
    Route::post('/subscribe', [FrontendController::class, 'subscribe'])->name('front.subscribe');
    Route::get('/quote', [FrontendController::class, 'quote'])->name('front.quote');
    Route::post('/sendquote', [FrontendController::class, 'sendquote'])->name('front.sendquote');


    Route::get('/checkout/payment/{slug1}/{slug2}', [FrontendController::class, 'loadpayment'])->name('front.load.payment');


    Route::get('/package-order/{id}', [FrontendController::class, 'packageorder'])->name('front.packageorder.index');
    Route::post('/package-order', [FrontendController::class, 'submitorder'])->name('front.packageorder.submit');
    Route::get('/order-confirmation/{packageid}/{packageOrderId}', [FrontendController::class, 'orderConfirmation'])->name('front.packageorder.confirmation');
    Route::get('/payment/{packageid}/cancle', [FrontendController::class, 'paycancle'])->name('front.payment.cancle');
    //Paypal Routes
    Route::post('/paypal/submit', [PaypalController::class, 'store'])->name('front.paypal.submit');
    Route::get('/paypal/{packageid}/notify', [PaypalController::class, 'notify'])->name('front.paypal.notify');
    //Stripe Routes
    Route::post('/stripe/submit', [StripeController::class, 'store'])->name('front.stripe.submit');
    //Paystack Routes
    Route::post('/paystack/submit', [PaystackController::class, 'store'])->name('front.paystack.submit');
    //PayTM Routes
    Route::post('/paytm/submit', [PaytmController::class, 'store'])->name('front.paytm.submit');
    Route::post('/paytm/notify', [PaytmController::class, 'notify'])->name('front.paytm.notify');
    //Flutterwave Routes
    Route::post('/flutterwave/submit', [FlutterWaveController::class, 'store'])->name('front.flutterwave.submit');
    Route::post('/flutterwave/notify', [FlutterWaveController::class, 'notify'])->name('front.flutterwave.notify');
    //Instamojo Routes
    Route::post('/instamojo/submit', [InstamojoController::class, 'store'])->name('front.instamojo.submit');
    Route::get('/instamojo/notify', [InstamojoController::class, 'notify'])->name('front.instamojo.notify');
    //Mollie Routes
    Route::post('/mollie/submit', [MollieController::class, 'store'])->name('front.mollie.submit');
    Route::get('/mollie/notify', [MollieController::class, 'notify'])->name('front.mollie.notify');
    // RazorPay
    Route::post('razorpay/submit', [RazorpayController::class, 'store'])->name('front.razorpay.submit');
    Route::post('razorpay/notify', [RazorpayController::class, 'notify'])->name('front.razorpay.notify');
    // Mercado Pago
    Route::post('mercadopago/submit', [MercadopagoController::class, 'store'])->name('front.mercadopago.submit');
    Route::post('mercadopago/notify', [MercadopagoController::class, 'notify'])->name('front.mercadopago.notify');
    // Payu
    Route::post('/payumoney/submit', [PayumoneyController::class, 'store'])->name('front.payumoney.submit');
    Route::post('/payumoney/notify', [PayumoneyController::class, 'notify'])->name('front.payumoney.notify');
    //Offline Routes
    Route::post('/offline/{oid}/submit', [OfflineController::class, 'store'])->name('front.offline.submit');


    // Team route
    Route::get('/team', [FrontendController::class, 'team'])->name('front.team');
    Route::get('/team/{slug}', [FrontendController::class, 'dynamicMemberPage'])->name('front.dynamicMemberPage');

    Route::get('/career', [FrontendController::class, 'career'])->name('front.career');
    Route::get('/career-details/{slug}/{id}', [FrontendController::class, 'careerdetails'])->name('front.careerdetails');
    Route::get('/calendar', [FrontendController::class, 'calendar'])->name('front.calendar');
    Route::get('/calendar/all-event', [FrontendController::class, 'downloadCalenderAllEvent'])->name('front.downloadCalenderAllEvent');
    Route::get('/calendar/{slug}', [FrontendController::class, 'getSingleCalendar'])->name('front.getSingleCalendar');
    Route::get('/calendar/{slug}/download', [FrontendController::class, 'downloadCalender'])->name('front.downloadCalender');
    Route::get('/gallery', [FrontendController::class, 'gallery'])->name('front.gallery');
    Route::get('/faq', [FrontendController::class, 'faq'])->name('front.faq');
    // Dynamic Page Routes
    Route::get('/changelanguage/{lang}', [FrontendController::class, 'changeLanguage'])->name('changeLanguage');

    // Product
    Route::get('/product', [ProductController::class, 'product'])->name('front.product');
    Route::get('/product/{slug}', [ProductController::class, 'productDetails'])->name('front.product.details');
    Route::get('/cart', [ProductController::class, 'cart'])->name('front.cart');
    Route::get('/add-to-cart/{id}', [ProductController::class, 'addToCart'])->name('add.cart');
    Route::post('/cart/update', [ProductController::class, 'updatecart'])->name('cart.update');
    Route::get('/cart/item/remove/{id}', [ProductController::class, 'cartitemremove'])->name('cart.item.remove');
    Route::get('/checkout', [ProductController::class, 'checkout'])->name('front.checkout');
    Route::get('/checkout/{slug}', [ProductController::class, 'Prdouctcheckout'])->name('front.product.checkout');

    // review
    Route::post('product/review/submit', [ReviewController::class, 'reviewsubmit'])->name('product.review.submit');

    // review end

    // CHECKOUT SECTION
    Route::get('/product/payment/return', [ProductPaymentController::class, 'payreturn'])->name('product.payment.return');
    Route::get('/product/payment/cancle', [ProductPaymentController::class, 'paycancle'])->name('product.payment.cancle');
    Route::get('/product/payment/notify', [ProductPaymentController::class, 'notify'])->name('product.payment.notify');
    // paypal routes
    Route::post('/product/paypal/submit', [ProductPaymentController::class, 'store'])->name('product.paypal.submit');
    // stripe routes
    Route::post('/product/stripe/submit', [ProductStripeController::class, 'store'])->name('product.stripe.submit');
    Route::post('/product/offline/{gatewayid}/submit', [ProductOfflineController::class, 'store'])->name('product.offline.submit');
    //Flutterwave Routes
    Route::post('/product/flutterwave/submit', [ProductFlutterWaveController::class, 'store'])->name('product.flutterwave.submit');
    Route::post('/product/flutterwave/notify', [ProductFlutterWaveController::class, 'notify'])->name('product.flutterwave.notify');
    //Paystack Routes
    Route::post('/product/paystack/submit', [ProductPaystackController::class, 'store'])->name('product.paystack.submit');
    // RazorPay
    Route::post('/product/razorpay/submit', [ProductRazorpayController::class, 'store'])->name('product.razorpay.submit');
    Route::post('/product/razorpay/notify', [ProductRazorpayController::class, 'notify'])->name('product.razorpay.notify');
    //Instamojo Routes
    Route::post('/product/instamojo/submit', [ProductInstamojoController::class, 'store'])->name('product.instamojo.submit');
    Route::get('/product/instamojo/notify', [ProductInstamojoController::class, 'notify'])->name('product.instamojo.notify');
    //PayTM Routes
    Route::post('/product/paytm/submit', [ProductPaytmController::class, 'store'])->name('product.paytm.submit');
    Route::post('/product/paytm/notify', [ProductPaytmController::class, 'notify'])->name('product.paytm.notify');
    //Mollie Routes
    Route::post('/product/mollie/submit', [ProductMollieController::class, 'store'])->name('product.mollie.submit');
    Route::get('/product/mollie/notify', [ProductMollieController::class, 'notify'])->name('product.mollie.notify');
    // Mercado Pago
    Route::post('/product/mercadopago/submit', [ProductMercadopagoController::class, 'store'])->name('product.mercadopago.submit');
    Route::post('/product/mercadopago/notify', [ProductMercadopagoController::class, 'notify'])->name('product.mercadopago.notify');
    // PayUmoney
    Route::post('/product/payumoney/submit', [ProductPayumoneyController::class, 'store'])->name('product.payumoney.submit');
    Route::post('/product/payumoney/notify', [ProductPayumoneyController::class, 'notify'])->name('product.payumoney.notify');
    // CHECKOUT SECTION ENDS

    // Product

  });
  Route::group(['middleware' => ['web', 'setlang']], function () {

    Route::get('/login/otp', [UserLoginController::class, 'showOtpLoginForm'])->name('user.login.otp');
    Route::post('/send-otp', [UserLoginController::class, 'sendOtpTwilio'])->name('user.login.sendOtpTwilio');
    Route::post('/verify-otp', [UserLoginController::class, 'verifyMOtp'])->name('user.login.verifyMOtp');
    Route::get('/login/resend', [UserLoginController::class, 'resendOtp'])->name('user.login.resendOtp');
    Route::get('/login', [UserLoginController::class, 'showLoginForm'])->name('user.login');
    Route::post('/login', [UserLoginController::class, 'login'])->name('user.login.submit');
    Route::get('/login/verify', [UserLoginController::class, 'verifyOtp'])->name('user.login.verifyOtp');
    Route::post('/login/verify-and-login', [UserLoginController::class, 'verifyAndLogin'])->name('user.login.verifyAndLogin');
    Route::get('/register', [RegisterController::class, 'registerPage'])->name('user-register');
    Route::post('/register/submit', [RegisterController::class, 'register'])->name('user-register-submit');
    Route::get('/register/verify/{token}', [RegisterController::class, 'token'])->name('user-register-token');
    Route::get('/forgot', [ForgotController::class, 'showforgotform'])->name('user-forgot');
    Route::post('/forgot', [ForgotController::class, 'forgot'])->name('user-forgot-submit');
  });

  Route::group(['prefix' => 'user', 'middleware' => ['auth', 'userstatus', 'setlang']], function () {
    // Summernote image upload
    Route::post('/summernote/upload', [UserSummernoteController::class, 'upload'])->name('user.summernote.upload');

    Route::get('/qr-code-generator', [QrcodeController::class, 'qrCodeGenerator'])->name('qr-code-generator');
    Route::post('/save-qr-code-generator', [QrcodeController::class, 'saveQrCodeGenerator'])->name('save-qr-code-generator');

    Route::group(['prefix' => '2fa'], function () {
      Route::get('/', [LoginSecurityController::class, 'show2faForm'])->name('show2faForm');
      Route::post('/generateSecret', [LoginSecurityController::class, 'generate2faSecret'])->name('generate2faSecret');
      Route::post('/enable2fa', [LoginSecurityController::class, 'enable2fa'])->name('enable2fa');
      Route::post('/disable2fa', [LoginSecurityController::class, 'disable2fa'])->name('disable2fa');

      // 2fa middleware
      Route::post('/2faVerify', function () {
        return redirect(URL()->previous());
      })->name('2faVerify')->middleware('2fa');
    });

    Route::get('/dashboard', [UserController::class, 'index'])->name('user-dashboard');
    Route::get('/reset', [UserController::class, 'resetform'])->name('user-reset');
    Route::post('/reset', [UserController::class, 'reset'])->name('user-reset-submit');
    Route::get('/profile', [UserController::class, 'profile'])->name('user-profile');
    Route::post('/profile', [UserController::class, 'profileupdate'])->name('user-profile-update');
    Route::get('/logout', [UserLoginController::class, 'logout'])->name('user-logout');
    Route::get('/shipping/details', [UserController::class, 'shippingdetails'])->name('shpping-details');
    Route::post('/shipping/details/update', [UserController::class, 'shippingupdate'])->name('user-shipping-update');
    Route::get('/billing/details', [UserController::class, 'billingdetails'])->name('billing-details');
    Route::post('/billing/details/update', [UserController::class, 'billingupdate'])->name('billing-update');
    Route::get('/orders', [OrderController::class, 'index'])->name('user-orders');
    Route::get('/order/{id}', [OrderController::class, 'orderdetails'])->name('user-orders-details');
    Route::get('/tickets', [TicketController::class, 'index'])->name('user-tickets');
    Route::get('/ticket/create', [TicketController::class, 'create'])->name('user-ticket-create');
    Route::get('/ticket/messages/{id}', [TicketController::class, 'messages'])->name('user-ticket-messages');
    Route::post('/ticket/store/', [TicketController::class, 'ticketstore'])->name('user.ticket.store');
    Route::post('/ticket/reply/{id}', [TicketController::class, 'ticketreply'])->name('user.ticket.reply');
    Route::post('/zip-file/upload', [TicketController::class, 'zip_upload'])->name('zip.upload');

    #chat
    Route::get('chat/show', [ChatController::class, 'show'])->name('user-chat-show');
    Route::post('chat/store', [ChatController::class, 'store'])->name('user-chat-store');
    Route::get('chat', [ChatController::class, 'index'])->name('user-get-chat');

    #booking
    Route::any('booking', [BookingController::class, 'index'])->name('front.booking.search');
    Route::get('booking/export', [BookingController::class, 'export'])->name('front.booking.export');
    Route::post('booking/store', [BookingController::class, 'store'])->name('front.booking.store');

    #buy credit
    Route::get('credit', [BuyCreditController::class, 'index'])->name('front.credit.index');


    #transaction
    Route::any('transaction', [TransactionController::class, 'index'])->name('front.transaction.search');
    Route::get('transaction/export', [TransactionController::class, 'export'])->name('front.transaction.export');

    #reservation
    Route::get('reservation/{id}/{day}', [ReservationController::class, 'getSpots'])->name('front.reservation.getSpots');
    Route::get('getServices', [ReservationController::class, 'getServices'])->name('front.reservation.getServices');
    Route::resource('reservation', ReservationController::class);
  });





  /*=======================================================
******************** Admin Routes **********************
=======================================================*/

  Route::group(['prefix' => 'admin', 'middleware' => 'guest:admin'], function () {
    Route::get('/', [AdminLoginController::class, 'login'])->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'authenticate'])->name('admin.auth');

    Route::get('/mail-form', [ForgetController::class, 'mailForm'])->name('admin.forget.form');
    Route::post('/sendmail', [ForgetController::class, 'sendmail'])->name('admin.forget.mail');
  });


  Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin', 'checkstatus']], function () {

    // RTL check
    Route::get('/rtlcheck/{langid}', [LanguageController::class, 'rtlcheck'])->name('admin.rtlcheck');

    // Summernote image upload
    Route::post('/summernote/upload', [SummernoteController::class, 'upload'])->name('admin.summernote.upload');

    // Admin logout Route
    Route::get('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

    Route::group(['middleware' => 'checkpermission:Dashboard'], function () {
      // Admin Dashboard Routes
      Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    });


    // Admin QR code generator
    Route::get('/qr-code-generator', [AdminQrcodeController::class, 'qrCodeGenerator'])->name('admin.qr-code-generator');
    Route::post('/save-qr-code-generator', [AdminQrcodeController::class, 'saveQrCodeGenerator'])->name('admin.save-qr-code-generator');

    //  Admin Twilio Credit
    Route::get('/twilio-credit', [TwilioCreditController::class, 'edit'])->name('admin.twilio-credit');
    Route::post('/twilio-credit/update', [TwilioCreditController::class, 'update'])->name('admin.twilio.update');
    Route::post('/twilio-credit/sendTestUpdate', [TwilioCreditController::class, 'sendTestUpdate'])->name('admin.twilio.sendTestUpdate');
    Route::post('/twilio-credit/verifyTextUpdate', [TwilioCreditController::class, 'verifyTextUpdate'])->name('admin.twilio.verifyTextUpdate');

    // Admin Profile Routes
    Route::get('/changePassword', [ProfileController::class, 'changePass'])->name('admin.changePass');
    Route::post('/profile/updatePassword', [ProfileController::class, 'updatePassword'])->name('admin.updatePassword');
    Route::get('/profile/edit', [ProfileController::class, 'editProfile'])->name('admin.editProfile');
    Route::post('/propic/update', [ProfileController::class, 'updatePropic'])->name('admin.propic.update');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('admin.updateProfile');


    Route::group(['middleware' => 'checkpermission:Basic Settings'], function () {
      // Admin Favicon Routes
      Route::get('/favicon', [BasicController::class, 'favicon'])->name('admin.favicon');
      Route::post('/favicon/{langid}/post', [BasicController::class, 'updatefav'])->name('admin.favicon.update');


      // Admin Logo Routes
      Route::get('/logo', [BasicController::class, 'logo'])->name('admin.logo');
      Route::post('/logo/{langid}/post', [BasicController::class, 'updatelogo'])->name('admin.logo.update');


      // Admin Scripts Routes
      Route::get('/feature/settings', [BasicController::class, 'featuresettings'])->name('admin.featuresettings');
      Route::post('/feature/settings/update', [BasicController::class, 'updatefeatrue'])->name('admin.featuresettings.update');



      // Admin Theme Version Setting Routes
      Route::get('/themeversion', [BasicController::class, 'themeversion'])->name('admin.themeversion');
      Route::post('/themeversion/post', [BasicController::class, 'updatethemeversion'])->name('admin.themeversion.update');


      // Admin Home Version Setting Routes
      Route::get('/homeversion', [BasicController::class, 'homeversion'])->name('admin.homeversion');
      Route::post('/homeversion/{langid}/post', [BasicController::class, 'updatehomeversion'])->name('admin.homeversion.update');


      // Admin Basic Information Routes
      Route::get('/basicinfo', [BasicController::class, 'basicinfo'])->name('admin.basicinfo');
      Route::post('/basicinfo/{langid}/post', [BasicController::class, 'updatebasicinfo'])->name('admin.basicinfo.update');


      // Admin Email Settings Routes
      Route::get('/mail-from-admin', [EmailController::class, 'mailFromAdmin'])->name('admin.mailFromAdmin');
      Route::post('/mail-from-admin/update', [EmailController::class, 'updateMailFromAdmin'])->name('admin.mailfromadmin.update');
      Route::get('/mail-to-admin', [EmailController::class, 'mailToAdmin'])->name('admin.mailToAdmin');
      Route::post('/mail-to-admin/update', [EmailController::class, 'updateMailToAdmin'])->name('admin.mailtoadmin.update');
      Route::post('/mail-from-admin/sendTestUpdate', [EmailController::class, 'sendTestUpdate'])->name('admin.mailfromadmin.sendTestUpdate');

      Route::get('/mail-from-admin/template/{id}/preview', [EmailTemplateController::class, 'preview'])->name('admin.email-template.template.preview');
      Route::post('/mail-from-admin/template/upload', [EmailTemplateController::class, 'upload'])->name('admin.email-template.template.upload');
      Route::post('/mail-from-admin/templateblog/{id}/uploadUpdate', [EmailTemplateController::class, 'uploadUpdate'])->name('admin.email-template.template.uploadUpdate');

      Route::get('/mail-from-admin/template/create', [EmailTemplateController::class, 'create'])->name('admin.email-template.template.create');
      Route::post('/mail-from-admin/template/store', [EmailTemplateController::class, 'store'])->name('admin.email-template.template.store');
      Route::get('/mail-from-admin/template/{id}/edit', [EmailTemplateController::class, 'edit'])->name('admin.email-template.template.edit');
      Route::post('/mail-from-admin/template/update', [EmailTemplateController::class, 'update'])->name('admin.email-template.template.update');
      Route::post('/mail-from-admin/template/delete', [EmailTemplateController::class, 'delete'])->name('admin.email-template.template.delete');
      Route::post('/mail-from-admin/template/bulk-delete', [EmailTemplateController::class, 'bulkDelete'])->name('admin.email-template.template.bulk.delete');
      Route::post('/mail-from-admin/template/update-footer-section', [EmailTemplateController::class, 'updateFooterSection'])->name('admin.email-template.template.update-footer-section');



      // Admin Support Routes
      Route::post('/support/post', [BasicController::class, 'updatesupport'])->name('admin.support.update');

      // Admin Breadcrumb Routes
      Route::get('/breadcrumb', [BasicController::class, 'breadcrumb'])->name('admin.breadcrumb');
      Route::post('/breadcrumb/{langid}/update', [BasicController::class, 'updatebreadcrumb'])->name('admin.breadcrumb.update');
      Route::post('/breadcrumb/{langid}/updateSetting', [BasicController::class, 'updateBreadcrumbSetting'])->name('admin.breadcrumb.updateBreadcrumbSetting');
      Route::post('/breadcrumb/deletemedia', [BasicController::class, 'deletemedia'])->name('admin.breadcrumb.deletemedia');


      // Admin Page Heading Routes
      Route::get('/heading', [BasicController::class, 'heading'])->name('admin.heading');
      Route::post('/heading/{langid}/update', [BasicController::class, 'updateheading'])->name('admin.heading.update');


      // Admin Scripts Routes
      Route::get('/script', [BasicController::class, 'script'])->name('admin.script');
      Route::post('/script/update', [BasicController::class, 'updatescript'])->name('admin.script.update');

      // Admin Social Routes
      Route::get('/social', [SocialController::class, 'index'])->name('admin.social.index');
      Route::post('/social/store', [SocialController::class, 'store'])->name('admin.social.store');
      Route::get('/social/{id}/edit', [SocialController::class, 'edit'])->name('admin.social.edit');
      Route::post('/social/update', [SocialController::class, 'update'])->name('admin.social.update');
      Route::post('/social/delete', [SocialController::class, 'delete'])->name('admin.social.delete');

      // Admin SEO Information Routes
      Route::get('/seo', [BasicController::class, 'seo'])->name('admin.seo');
      Route::post('/seo/{langid}/update', [BasicController::class, 'updateseo'])->name('admin.seo.update');

      // Admin Image To PDF Routes
      Route::get('/imagetopdf', [AdminConvertImageToPDFController::class, 'imageToPdf'])->name('admin.imagetopdf');
      Route::post('/imagetopdf/update', [AdminConvertImageToPDFController::class, 'convertImageToPdf'])->name('admin.imagetopdf.update');
      Route::post('/imagetopdf/get-download-file', [AdminConvertImageToPDFController::class, 'getDownloadFile'])->name('admin.imagetopdf.get-download-file');
      Route::post('/imagetopdf/remove-file-from-server', [AdminConvertImageToPDFController::class, 'removeFileFromServer'])->name('admin.imagetopdf.remove-file-from-server');

      // Admin Meta data viewr Routes
      Route::get('/metadata-viewer', [AdminMetaViewerController::class, 'index'])->name('admin.metadata-viewer');
      Route::post('/metadata-viewer/get-preview', [AdminMetaViewerController::class, 'getPreview'])->name('admin.metadata-viewer.get-preview');
      Route::post('/remove-metadata-file-from-server', [AdminMetaViewerController::class, 'removeFileFromServer'])->name('admin.metadata-viewer.remove-meta-file-from-server');

      // Admin Screen Recorder Routes

      Route::get('/screen-recorder', [ScreenRecorderController::class, 'index'])->name('admin.screen-recorder.index');
      Route::post('/save', [ScreenRecorderController::class, 'save'])->name('admin.screen-recorder.save');
      Route::get('/play/{filename}', [ScreenRecorderController::class, 'play'])->name('admin.screen-recorder.play');
      Route::get('/admin/screen-recorder/edit/{id}', [ScreenRecorderController::class, 'edit'])->name('admin.screen-recorder.edit');
      Route::put('/admin/screen-recorder/update/{id}', [ScreenRecorderController::class, 'update'])->name('admin.screen-recorder.update');
      Route::delete('/admin/screen-recorder/{id}', [ScreenRecorderController::class, 'delete'])->name('admin.screen-recorder.delete');
      Route::post('/admin/screen-recorder/delete', [ScreenRecorderController::class, 'delete'])->name('admin.screen-recorder.delete');

      Route::post('/admin/screen-recorder/bulk-delete', [ScreenRecorderController::class, 'bulkDelete'])->name('admin.screen-recorder.bulkdelete');

      // Admin Maintanance Mode Routes
      Route::get('/maintainance', [BasicController::class, 'maintainance'])->name('admin.maintainance');
      Route::post('/maintainance/update', [BasicController::class, 'updatemaintainance'])->name('admin.maintainance.update');
      Route::post('/maintainance/upload', [BasicController::class, 'uploadmaintainance'])->name('admin.maintainance.upload');


      // Admin Offer Banner Routes
      Route::get('/announcement', [BasicController::class, 'announcement'])->name('admin.announcement');
      Route::post('/announcement/{langid}/update', [BasicController::class, 'updateannouncement'])->name('admin.announcement.update');
      Route::post('/announcement/{langid}/upload', [BasicController::class, 'uploadannouncement'])->name('admin.announcement.upload');


      // Admin Section Customization Routes
      Route::get('/sections', [BasicController::class, 'sections'])->name('admin.sections.index');
      Route::post('/sections/update', [BasicController::class, 'updatesections'])->name('admin.sections.update');


      // Admin Cookie Alert Routes
      Route::get('/cookie-alert', [BasicController::class, 'cookiealert'])->name('admin.cookie.alert');
      Route::post('/cookie-alert/{langid}/update', [BasicController::class, 'updatecookie'])->name('admin.cookie.update');
    });

    Route::group(['middleware' => 'checkpermission:Subscribers'], function () {
      // Admin Subscriber Routes
      Route::get('/subscribers', [SubscriberController::class, 'index'])->name('admin.subscriber.index');
      Route::get('/subscribers/{id}/edit', [SubscriberController::class, 'edit'])->name('admin.subscriber.edit');
      Route::post('/subscribers/update', [SubscriberController::class, 'update'])->name('admin.subscriber.update');
      Route::get('/mailsubscriber', [SubscriberController::class, 'mailsubscriber'])->name('admin.mailsubscriber');

      Route::post('/subscribers/bulk-delete', [SubscriberController::class, 'bulkDelete'])->name('admin.subscriber.bulk.delete');

      Route::post('/subscribers/sendmail', [SubscriberController::class, 'subscsendmail'])->name('admin.subscribers.sendmail');
      Route::post('/subscribers/import', [SubscriberController::class, 'import'])->name('admin.subscribers.import');
      Route::post('/subscribers/export', [SubscriberController::class, 'export'])->name('admin.subscribers.export');
    });


    Route::group(['middleware' => 'checkpermission:Home Page'], function () {
      // Admin Hero Section (Static Version) Routes
      Route::get('/herosection/static', [HerosectionController::class, 'static'])->name('admin.herosection.static');
      Route::post('/herosection/{langid}/upload', [HerosectionController::class, 'upload'])->name('admin.herosection.upload');
      Route::post('/herosection/{langid}/update', [HerosectionController::class, 'update'])->name('admin.herosection.update');


      // Admin Hero Section (Slider Version) Routes
      Route::get('/herosection/sliders', [SliderController::class, 'index'])->name('admin.slider.index');
      Route::post('/herosection/slider/store', [SliderController::class, 'store'])->name('admin.slider.store');
      Route::post('/herosection/sliderupload', [SliderController::class, 'upload'])->name('admin.slider.upload');
      Route::get('/herosection/slider/{id}/edit', [SliderController::class, 'edit'])->name('admin.slider.edit');
      Route::post('/herosection/sliderupdate', [SliderController::class, 'update'])->name('admin.slider.update');
      Route::post('/herosection/slider/{id}/uploadUpdate', [SliderController::class, 'uploadUpdate'])->name('admin.slider.uploadUpdate');
      Route::post('/herosection/slider/delete', [SliderController::class, 'delete'])->name('admin.slider.delete');


      // Admin Hero Section (Video Version) Routes
      Route::get('/herosection/video', [HerosectionController::class, 'video'])->name('admin.herosection.video');
      Route::post('/herosection/video/{langid}/update', [HerosectionController::class, 'videoupdate'])->name('admin.herosection.video.update');


      // Admin Hero Section (Parallax Version) Routes
      Route::get('/herosection/parallax', [HerosectionController::class, 'parallax'])->name('admin.herosection.parallax');
      Route::post('/herosection/parallax/update', [HerosectionController::class, 'parallaxupdate'])->name('admin.herosection.parallax.update');



      // Admin Partner Routes
      Route::get('/partners', [PartnerController::class, 'index'])->name('admin.partner.index');
      Route::post('/partner/store', [PartnerController::class, 'store'])->name('admin.partner.store');
      Route::post('/partner/upload', [PartnerController::class, 'upload'])->name('admin.partner.upload');
      Route::get('/partner/{id}/edit', [PartnerController::class, 'edit'])->name('admin.partner.edit');
      Route::post('/partner/update', [PartnerController::class, 'update'])->name('admin.partner.update');
      Route::post('/partner/{id}/uploadUpdate', [PartnerController::class, 'uploadUpdate'])->name('admin.partner.uploadUpdate');
      Route::post('/partner/delete', [PartnerController::class, 'delete'])->name('admin.partner.delete');
      Route::post('/partner/update-section-store', [PartnerController::class, 'updateSection'])->name('admin.partner.updateSection');
      Route::get('/partner/{langid}/getProduct', [PartnerController::class, 'getProduct'])->name('admin.blog.getProduct');



      // Admin Client Routes
      Route::get('/clients', [ClientController::class, 'index'])->name('admin.client.index');
      Route::post('/client/store', [ClientController::class, 'store'])->name('admin.client.store');
      Route::post('/client/upload', [ClientController::class, 'upload'])->name('admin.client.upload');
      Route::get('/client/{id}/edit', [ClientController::class, 'edit'])->name('admin.client.edit');
      Route::post('/client/update', [ClientController::class, 'update'])->name('admin.client.update');
      Route::post('/client/{id}/uploadUpdate', [ClientController::class, 'uploadUpdate'])->name('admin.client.uploadUpdate');
      Route::post('/client/delete', [ClientController::class, 'delete'])->name('admin.client.delete');
      Route::post('/client/update-section-store', [ClientController::class, 'updateSection'])->name('admin.client.updateSection');


      // Admin Feature Routes
      Route::get('/features', [FeatureController::class, 'index'])->name('admin.feature.index');
      Route::post('/feature/store', [FeatureController::class, 'store'])->name('admin.feature.store');
      Route::get('/feature/{id}/edit', [FeatureController::class, 'edit'])->name('admin.feature.edit');
      Route::post('/feature/update', [FeatureController::class, 'update'])->name('admin.feature.update');
      Route::post('/feature/delete', [FeatureController::class, 'delete'])->name('admin.feature.delete');

      // Admin Intro Section Routes
      Route::get('/introsection', [IntrosectionController::class, 'index'])->name('admin.introsection.index');
      Route::post('/introsection/{langid}/upload', [IntrosectionController::class, 'upload'])->name('admin.introsection.upload');
      Route::post('/introsection/{langid}/upload2', [IntrosectionController::class, 'upload2'])->name('admin.introsection.upload2');
      Route::post('/introsection/{langid}/update', [IntrosectionController::class, 'update'])->name('admin.introsection.update');

      // Admin About Intro Routes
      Route::post('/aboutintro/upload', [IntrosectionController::class, 'uploadAboutintro'])->name('admin.aboutintro.upload');
      Route::get('/aboutintro/create', [IntrosectionController::class, 'createAboutintro'])->name('admin.aboutintro.create');
      Route::post('/aboutintro/store', [IntrosectionController::class, 'storeAboutintro'])->name('admin.aboutintro.store');
      Route::get('/aboutintro/{id}/edit', [IntrosectionController::class, 'editAboutintro'])->name('admin.aboutintro.edit');
      Route::post('/aboutintro/update', [IntrosectionController::class, 'updateAboutintro'])->name('admin.aboutintro.update');
      Route::post('/aboutintro/{id}/uploadUpdate', [IntrosectionController::class, 'uploadUpdateAboutintro'])->name('admin.aboutintro.uploadUpdate');
      Route::post('/aboutintro/delete', [IntrosectionController::class, 'deleteAboutintro'])->name('admin.aboutintro.delete');
      Route::post('/aboutintro/feature', [IntrosectionController::class, 'featureAboutintro'])->name('admin.aboutintro.feature');


      // Admin Service Section Routes
      Route::get('/servicesection', [ServicesectionController::class, 'index'])->name('admin.servicesection.index');
      Route::post('/servicesection/{langid}/update', [ServicesectionController::class, 'update'])->name('admin.servicesection.update');

      // Admin Approach Section Routes
      Route::get('/approach', [ApproachController::class, 'index'])->name('admin.approach.index');

      Route::post('/approach/upload', [ApproachController::class, 'upload'])->name('admin.approach.point.upload');
      Route::post('/approach/{id}/updateUpload', [ApproachController::class, 'updateUpload'])->name('admin.approach.point.updateUpload');

      Route::post('/approach/uploadShape', [ApproachController::class, 'uploadShape'])->name('admin.approach.point.uploadShape');
      Route::post('/approach/{id}/updateUploadShape', [ApproachController::class, 'updateUploadShape'])->name('admin.approach.point.updateUploadShape');

      Route::post('/approach/store', [ApproachController::class, 'store'])->name('admin.approach.point.store');
      Route::get('/approach/{id}/pointedit', [ApproachController::class, 'pointedit'])->name('admin.approach.point.edit');
      Route::post('/approach/{langid}/update', [ApproachController::class, 'update'])->name('admin.approach.update');
      Route::post('/approach/pointupdate', [ApproachController::class, 'pointupdate'])->name('admin.approach.point.update');
      Route::post('/approach/pointdelete', [ApproachController::class, 'pointdelete'])->name('admin.approach.pointdelete');


      // Admin Statistic Section Routes
      Route::get('/statistics', [StatisticsController::class, 'index'])->name('admin.statistics.index');
      Route::post('/statistics/{langid}/upload', [StatisticsController::class, 'upload'])->name('admin.statistics.upload');
      Route::post('/statistics/store', [StatisticsController::class, 'store'])->name('admin.statistics.store');
      Route::get('/statistics/{id}/edit', [StatisticsController::class, 'edit'])->name('admin.statistics.edit');
      Route::post('/statistics/update', [StatisticsController::class, 'update'])->name('admin.statistics.update');
      Route::post('/statistics/delete', [StatisticsController::class, 'delete'])->name('admin.statistics.delete');


      // Admin Call to Action Section Routes
      Route::get('/cta', [CtaController::class, 'index'])->name('admin.cta.index');
      Route::post('/cta/{langid}/upload', [CtaController::class, 'upload'])->name('admin.cta.upload');
      Route::post('/cta/{langid}/update', [CtaController::class, 'update'])->name('admin.cta.update');

      // Admin Portfolio Section Routes
      Route::get('/portfoliosection', [PortfoliosectionController::class, 'index'])->name('admin.portfoliosection.index');
      Route::post('/portfoliosection/{langid}/update', [PortfoliosectionController::class, 'update'])->name('admin.portfoliosection.update');

      // Admin Testimonial Routes
      Route::get('/testimonials', [TestimonialController::class, 'index'])->name('admin.testimonial.index');
      Route::get('/testimonial/create', [TestimonialController::class, 'create'])->name('admin.testimonial.create');
      Route::post('/testimonial/upload', [TestimonialController::class, 'upload'])->name('admin.testimonial.upload');
      Route::post('/testimonial/store', [TestimonialController::class, 'store'])->name('admin.testimonial.store');
      Route::get('/testimonial/{id}/edit', [TestimonialController::class, 'edit'])->name('admin.testimonial.edit');
      Route::post('/testimonial/update', [TestimonialController::class, 'update'])->name('admin.testimonial.update');
      Route::post('/testimonial/{id}/uploadUpdate', [TestimonialController::class, 'uploadUpdate'])->name('admin.testimonial.uploadUpdate');
      Route::post('/testimonial/delete', [TestimonialController::class, 'delete'])->name('admin.testimonial.delete');
      Route::post('/testimonialtext/{langid}/update', [TestimonialController::class, 'textupdate'])->name('admin.testimonialtext.update');

      // Admin Advertisement Routes
      Route::get('/advertisement', [AdvertisementController::class, 'index'])->name('admin.advertisement.index');
      Route::get('/advertisement/create', [AdvertisementController::class, 'create'])->name('admin.advertisement.create');
      Route::post('/advertisement/upload', [AdvertisementController::class, 'upload'])->name('admin.advertisement.upload');
      Route::post('/advertisement/store', [AdvertisementController::class, 'store'])->name('admin.advertisement.store');
      Route::get('/advertisement/{id}/edit', [AdvertisementController::class, 'edit'])->name('admin.advertisement.edit');
      Route::post('/advertisement/update', [AdvertisementController::class, 'update'])->name('admin.advertisement.update');
      Route::post('/advertisement/{id}/uploadUpdate', [AdvertisementController::class, 'uploadUpdate'])->name('admin.advertisement.uploadUpdate');
      Route::post('/advertisement/delete', [AdvertisementController::class, 'delete'])->name('admin.advertisement.delete');
      Route::post('/advertisement/feature', [AdvertisementController::class, 'feature'])->name('admin.advertisement.feature');

      // Admin Blog Section Routes
      Route::get('/blogsection', [BlogsectionController::class, 'index'])->name('admin.blogsection.index');
      Route::post('/blogsection/{langid}/update', [BlogsectionController::class, 'update'])->name('admin.blogsection.update');

      // Admin Education Section Routes
      Route::get('/educationsection', [EducationSectionController::class, 'index'])->name('admin.educationsection.index');
      Route::post('/educationsection/{langid}/update', [EducationSectionController::class, 'update'])->name('admin.educationsection.update');

    //   Steps section routes
      Route::get('/stepsection', [StepsSectionController::class, 'index'])->name('admin.stepsection.index');
      Route::post('/stepsection/store', [StepsSectionController::class, 'store'])->name('admin.stepsection.store');
      Route::post('/stepsection/upload', [StepsSectionController::class, 'upload'])->name('admin.stepsection.upload');
      Route::post('/stepsection/delete', [StepsSectionController::class, 'destroy'])->name('admin.stepsection.destroy');
      Route::get('/stepsection/{id}/edit', [StepsSectionController::class, 'edit'])->name('admin.stepsection.edit');
      Route::post('/stepsection/update', [StepsSectionController::class, 'update'])->name('admin.stepsection.update');
      Route::post('/stepsection/{id}/uploadUpdate', [StepsSectionController::class, 'uploadUpdate'])->name('admin.stepsection.uploadUpdate');

    //   free app section routes
    Route::get('/appsection', [FreeAppSectionController::class, 'index'])->name('admin.appsection.index');
    Route::get('/appsection/create', [FreeAppSectionController::class, 'create'])->name('admin.appsection.create');
    Route::post('/appsection/store', [FreeAppSectionController::class, 'store'])->name('admin.appsection.store');
    Route::post('/appsection/sliderstore', [FreeAppSectionController::class, 'sliderstore'])->name('admin.appsection.sliderstore');
    Route::get('/appsection/{id}/edit', [FreeAppSectionController::class, 'edit'])->name('admin.appsection.edit');
    Route::post('/appsection/delete', [FreeAppSectionController::class, 'destroy'])->name('admin.appsection.delete');
    Route::post('/appsection/update', [FreeAppSectionController::class, 'update'])->name('admin.appsection.update');
    Route::get('/appsection/sliderupdate', [FreeAppSectionController::class, 'sliderupdate'])->name('admin.appsection.sliderupdate');
    Route::get('/appsection/{id}/images', [FreeAppSectionController::class, 'images'])->name('admin.appsection.images');
    Route::post('/appsection/sliderrmv', [FreeAppSectionController::class, 'sliderrmv'])->name('admin.appsection.sliderrmv');
    Route::post('/appsection/bulk-delete', [FreeAppSectionController::class, 'bulkDelete'])->name('admin.appsection.bulk.delete');



      // Admin Member Routes
      Route::get('/members', [MemberController::class, 'index'])->name('admin.member.index');
      Route::post('/members/get-preview', [MemberController::class, 'getPreview'])->name('admin.member.get-preview');
      Route::post('/team/{langid}/upload', [MemberController::class, 'teamUpload'])->name('admin.team.upload');
      Route::post('/member/upload', [MemberController::class, 'upload'])->name('admin.member.upload');
      Route::get('/member/create', [MemberController::class, 'create'])->name('admin.member.create');
      Route::post('/member/store', [MemberController::class, 'store'])->name('admin.member.store');
      Route::get('/member/{id}/edit', [MemberController::class, 'edit'])->name('admin.member.edit');
      Route::post('/member/update', [MemberController::class, 'update'])->name('admin.member.update');
      Route::post('/member/{id}/uploadUpdate', [MemberController::class, 'uploadUpdate'])->name('admin.member.uploadUpdate');
      Route::post('/member/delete', [MemberController::class, 'delete'])->name('admin.member.delete');
      Route::post('/teamtext/{langid}/update', [MemberController::class, 'textupdate'])->name('admin.teamtext.update');
      Route::post('/member/feature', [MemberController::class, 'feature'])->name('admin.member.feature');

      // Admin Package Background Routes
      Route::get('/package/background', [PackageController::class, 'background'])->name('admin.package.background');
      Route::post('/package/{langid}/background-upload', [PackageController::class, 'uploadBackground'])->name('admin.package.background.upload');
    });

    Route::group(['middleware' => 'checkpermission:Menu Builder'], function () {

      Route::get('/menu-builder', [MenuBuilderController::class, 'index'])->name('admin.menu_builder.index');
      Route::post('/menu-builder/update', [MenuBuilderController::class, 'update'])->name('admin.menu_builder.update');
      Route::get('/top-menu-builder', [MenuBuilderController::class, 'topIndex'])->name('admin.top_menu_builder.index');
      Route::post('/top-menu-builder/update', [MenuBuilderController::class, 'topUpdate'])->name('admin.top_menu_builder.update');
    });



    // Admin FAQ Routes
    Route::get('/faqs', [FaqController::class, 'index'])->name('admin.faq.index');
    Route::post('/faq/upload', [FaqController::class, 'upload'])->name('admin.faq.upload');
    Route::post('/faq/{id}/uploadUpdate', [FaqController::class, 'uploadUpdate'])->name('admin.faq.uploadUpdate');
    Route::get('/faq/create', [FaqController::class, 'create'])->name('admin.faq.create');
    Route::post('/faq/store', [FaqController::class, 'store'])->name('admin.faq.store');
    Route::get('/faq/{id}/edit', [FaqController::class, 'edit'])->name('admin.faq.edit');
    Route::post('/faq/update', [FaqController::class, 'update'])->name('admin.faq.update');
    Route::post('/faq/delete', [FaqController::class, 'delete'])->name('admin.faq.delete');
    Route::post('/faq/bulk-delete', [FaqController::class, 'bulkDelete'])->name('admin.faq.bulk.delete');
    Route::post('/faq/feature', [FaqController::class, 'feature'])->name('admin.faq.feature');

    // Admin Customer FAQ Routes
    Route::get('/customer-faqs', [CustomerFaqController::class, 'index'])->name('admin.customer-faq.index');
    Route::post('/customer-faq/upload', [CustomerFaqController::class, 'upload'])->name('admin.customer-faq.upload');
    Route::post('/customer-faq/{id}/uploadUpdate', [CustomerFaqController::class, 'uploadUpdate'])->name('admin.customer-faq.uploadUpdate');
    Route::get('/customer-faq/create', [CustomerFaqController::class, 'create'])->name('admin.customer-faq.create');
    Route::post('/customer-faq/store', [CustomerFaqController::class, 'store'])->name('admin.customer-faq.store');
    Route::get('/customer-faq/{id}/edit', [CustomerFaqController::class, 'edit'])->name('admin.customer-faq.edit');
    Route::post('/customer-faq/update', [CustomerFaqController::class, 'update'])->name('admin.customer-faq.update');
    Route::post('/customer-faq/delete', [CustomerFaqController::class, 'delete'])->name('admin.customer-faq.delete');
    Route::post('/customer-faq/bulk-delete', [CustomerFaqController::class, 'bulkDelete'])->name('admin.customer-faq.bulk.delete');
    Route::get('/customer-faq/{langid}/getcats', [CustomerFaqController::class, 'getcats'])->name('admin.customer-faq.getcats');
    Route::post('/customer-faq/feature', [CustomerFaqController::class, 'feature'])->name('admin.customer-faq.feature');

    Route::get('/faq-category', [FaqCategoryController::class, 'index'])->name('admin.faq-category.index');
    Route::post('/faq-category/upload', [FaqCategoryController::class, 'upload'])->name('admin.faq-category.upload');
    Route::post('/faq-category/store', [FaqCategoryController::class, 'store'])->name('admin.faq-category.store');
    Route::get('/faq-category/{id}/edit', [FaqCategoryController::class, 'edit'])->name('admin.faq-category.edit');
    Route::post('/faq-category/update', [FaqCategoryController::class, 'update'])->name('admin.faq-category.update');
    Route::post('/faq-category/{id}/uploadUpdate', [FaqCategoryController::class, 'uploadUpdate'])->name('admin.faq-category.uploadUpdate');
    Route::post('/faq-category/delete', [FaqCategoryController::class, 'delete'])->name('admin.faq-category.delete');
    Route::post('/faq-category/bulk-delete', [FaqCategoryController::class, 'bulkDelete'])->name('admin.faq-category.bulk.delete');
    Route::post('/faq-category/feature', [FaqCategoryController::class, 'feature'])->name('admin.faq-category.feature');

    Route::group(['middleware' => 'checkpermission:Pages'], function () {
      // Menu Manager Routes
      Route::get('/pages', [PageController::class, 'index'])->name('admin.page.index');
      Route::get('/page/create', [PageController::class, 'create'])->name('admin.page.create');
      Route::post('/page/store', [PageController::class, 'store'])->name('admin.page.store');
      Route::get('/page/{menuID}/edit', [PageController::class, 'edit'])->name('admin.page.edit');
      Route::post('/page/update', [PageController::class, 'update'])->name('admin.page.update');
      Route::post('/page/delete', [PageController::class, 'delete'])->name('admin.page.delete');
      Route::post('/page/bulk-delete', [PageController::class, 'bulkDelete'])->name('admin.page.bulk.delete');
      Route::post('/page/{id}/uploadUpdate', [PageController::class, 'uploadUpdate'])->name('admin.page.uploadUpdate');
    });

    Route::group(['middleware' => 'checkpermission:FormBuilder'], function () {
      // Menu Manager Routes
      Route::get('/form_builder', [FormBuilderController::class, 'index'])->name('admin.form_builder.index');
      Route::get('/form_builder/create', [FormBuilderController::class, 'create'])->name('admin.form_builder.create');
      Route::post('/form_builder/store', [FormBuilderController::class, 'store'])->name('admin.form_builder.store');
      Route::get('/form_builder/{menuID}/formdata', [FormBuilderController::class, 'formData'])->name('admin.form_builder.form.data');
      Route::get('/form_builder/{menuID}/edit', [FormBuilderController::class, 'edit'])->name('admin.form_builder.edit');
      Route::get('/form_builder/{menuID}/view', [FormBuilderController::class, 'view'])->name('admin.form_builder.view');
      Route::delete('/form_builder/delete/{menuID}', [FormBuilderController::class, 'deleteFormData'])->name('admin.form_builder.deleteFormData');
      Route::post('/form_builder/update', [FormBuilderController::class, 'update'])->name('admin.form_builder.update');
      Route::post('/form_builder/delete', [FormBuilderController::class, 'delete'])->name('admin.form_builder.delete');
      Route::post('/form_builder/bulk-delete', [FormBuilderController::class, 'bulkDelete'])->name('admin.form_builder.bulk.delete');
    });


    Route::group(['middleware' => 'checkpermission:Footer'], function () {

      // Admin  Routes
      Route::get('/powered-by', [FooterController::class, 'poweredBy'])->name('admin.powered-by.index');
      Route::post('/powered-by/{langid}/upload', [FooterController::class, 'poweredByUpload'])->name('admin.powered-by.poweredByUpload');
      Route::post('/powered-by/{langid}/update', [FooterController::class, 'poweredByUpdate'])->name('admin.powered-by.poweredByUpdate');

      // Admin Footer Logo Text Routes
      Route::get('/footers', [FooterController::class, 'index'])->name('admin.footer.index');
      Route::post('/footer/{langid}/upload', [FooterController::class, 'upload'])->name('admin.footer.upload');
      Route::post('/footer/{langid}/update', [FooterController::class, 'update'])->name('admin.footer.update');

      // Admin Ulink Routes
      Route::get('/ulinks', [UlinkController::class, 'index'])->name('admin.ulink.index');
      Route::get('/ulink/create', [UlinkController::class, 'create'])->name('admin.ulink.create');
      Route::post('/ulink/store', [UlinkController::class, 'store'])->name('admin.ulink.store');
      Route::get('/ulink/{id}/edit', [UlinkController::class, 'edit'])->name('admin.ulink.edit');
      Route::post('/ulink/update', [UlinkController::class, 'update'])->name('admin.ulink.update');
      Route::post('/ulink/delete', [UlinkController::class, 'delete'])->name('admin.ulink.delete');
    });

    Route::group(['middleware' => 'checkpermission:Service Page'], function () {
      // Admin Service Category Routes
      Route::get('/scategorys', [ScategoryController::class, 'index'])->name('admin.scategory.index');
      Route::post('/scategory/upload', [ScategoryController::class, 'upload'])->name('admin.scategory.upload');
      Route::post('/scategory/store', [ScategoryController::class, 'store'])->name('admin.scategory.store');
      Route::get('/scategory/{id}/edit', [ScategoryController::class, 'edit'])->name('admin.scategory.edit');
      Route::post('/scategory/update', [ScategoryController::class, 'update'])->name('admin.scategory.update');
      Route::post('/scategory/{id}/uploadUpdate', [ScategoryController::class, 'uploadUpdate'])->name('admin.scategory.uploadUpdate');
      Route::post('/scategory/delete', [ScategoryController::class, 'delete'])->name('admin.scategory.delete');
      Route::post('/scategory/bulk-delete', [ScategoryController::class, 'bulkDelete'])->name('admin.scategory.bulk.delete');
      Route::post('/scategory/feature', [ScategoryController::class, 'feature'])->name('admin.scategory.feature');

      // Admin Services Routes
      Route::get('/services', [ServiceController::class, 'index'])->name('admin.service.index');
      Route::post('/service/upload', [ServiceController::class, 'upload'])->name('admin.service.upload');
      Route::post('/service/{id}/uploadUpdate', [ServiceController::class, 'uploadUpdate'])->name('admin.service.uploadUpdate');
      Route::post('/service/store', [ServiceController::class, 'store'])->name('admin.service.store');
      Route::get('/service/{id}/edit', [ServiceController::class, 'edit'])->name('admin.service.edit');
      Route::post('/service/update', [ServiceController::class, 'update'])->name('admin.service.update');
      Route::post('/service/delete', [ServiceController::class, 'delete'])->name('admin.service.delete');
      Route::post('/service/bulk-delete', [ServiceController::class, 'bulkDelete'])->name('admin.service.bulk.delete');
      Route::get('/service/{langid}/getcats', [ServiceController::class, 'getcats'])->name('admin.service.getcats');
      Route::post('/service/feature', [ServiceController::class, 'feature'])->name('admin.service.feature');
    });

    Route::group(['middleware' => 'checkpermission:Product Management'], function () {

      // Category route

      Route::get('/category', [ProductCategory::class, 'index'])->name('admin.category.index');
      Route::post('/category/store', [ProductCategory::class, 'store'])->name('admin.category.store');
      Route::get('/category/{id}/edit', [ProductCategory::class, 'edit'])->name('admin.category.edit');
      Route::post('/category/update', [ProductCategory::class, 'update'])->name('admin.category.update');
      Route::post('/category/delete', [ProductCategory::class, 'delete'])->name('admin.category.delete');

      Route::post('/category/bulk-delete', [ProductCategory::class, 'bulkDelete'])->name('admin.pcategory.bulk.delete');

      // Sub category routes

      Route::get('/sub-category', [ProductSubCategory::class, 'index'])->name('admin.sub-category.index');
      Route::post('/sub-category/store', [ProductSubCategory::class, 'store'])->name('admin.sub-category.store');
      Route::get('/sub-category/{id}/edit', [ProductSubCategory::class, 'edit'])->name('admin.sub-category.edit');
      Route::post('/sub-category/update', [ProductSubCategory::class, 'update'])->name('admin.sub-category.update');
      Route::post('/sub-category/delete', [ProductSubCategory::class, 'delete'])->name('admin.sub-category.delete');
      Route::any('/sub-category/{id}/getcats', [ProductSubCategory::class, 'getcats'])->name('admin.sub-category.getcats');
      Route::post('/sub-category/bulk-delete', [ProductSubCategory::class, 'bulkDelete'])->name('admin.sub-category.bulk.delete');


      Route::get('/shipping', [ShopSettingController::class, 'index'])->name('admin.shipping.index');
      Route::post('/shipping/store', [ShopSettingController::class, 'store'])->name('admin.shipping.store');
      Route::get('/shipping/{id}/edit', [ShopSettingController::class, 'edit'])->name('admin.shipping.edit');
      Route::post('/shipping/update', [ShopSettingController::class, 'update'])->name('admin.shipping.update');
      Route::post('/shipping/delete', [ShopSettingController::class, 'delete'])->name('admin.shipping.delete');


      Route::get('/product', [AdminProductController::class, 'index'])->name('admin.product.index');
      Route::get('/product/create', [AdminProductController::class, 'create'])->name('admin.product.create');
      Route::post('/product/store', [AdminProductController::class, 'store'])->name('admin.product.store');
      Route::get('/product/{id}/edit', [AdminProductController::class, 'edit'])->name('admin.product.edit');
      Route::post('/product/update', [AdminProductController::class, 'update'])->name('admin.product.update');
      Route::post('/product/delete', [AdminProductController::class, 'delete'])->name('admin.product.delete');
      Route::get('/product/populer/tags/', [AdminProductController::class, 'populerTag'])->name('admin.product.tags');
      Route::post('/product/populer/tags/update', [AdminProductController::class, 'populerTagupdate'])->name('admin.popular-tag.update');
      Route::post('/product/feature', [AdminProductController::class, 'feature'])->name('admin.product.feature');


      Route::post('/product/sliderstore', [AdminProductController::class, 'sliderstore'])->name('admin.product.sliderstore');
      Route::post('/product/sliderrmv', [AdminProductController::class, 'sliderrmv'])->name('admin.product.sliderrmv');
      Route::post('/product/upload', [AdminProductController::class, 'upload'])->name('admin.product.upload');
      Route::get('product/{id}/getcategory', [AdminProductController::class, 'getCategory'])->name('admin.product.getcategory');

      Route::post('product/getsubcategory', [AdminProductController::class, 'getSubcategory'])->name('admin.product.getSubcategory');

      Route::post('/product/delete', [AdminProductController::class, 'delete'])->name('admin.product.delete');
      Route::post('/product/bulk-delete', [AdminProductController::class, 'bulkDelete'])->name('admin.product.bulk.delete');
      Route::post('/product/sliderupdate', [AdminProductController::class, 'sliderupdate'])->name('admin.product.sliderupdate');
      Route::post('/product/{id}/uploadUpdate', [AdminProductController::class, 'uploadUpdate'])->name('admin.product.uploadUpdate');
      Route::post('/product/update', [AdminProductController::class, 'update'])->name('admin.product.update');
      Route::get('/product/{id}/images', [AdminProductController::class, 'images'])->name('admin.product.images');



      // Product Order
      Route::get('/product/all/orders', [ProductOrderController::class, 'all'])->name('admin.all.product.orders');
      Route::get('/product/pending/orders', [ProductOrderController::class, 'pending'])->name('admin.pending.product.orders');
      Route::get('/product/processing/orders', [ProductOrderController::class, 'processing'])->name('admin.processing.product.orders');
      Route::get('/product/completed/orders', [ProductOrderController::class, 'completed'])->name('admin.completed.product.orders');
      Route::get('/product/rejected/orders', [ProductOrderController::class, 'rejected'])->name('admin.rejected.product.orders');
      Route::post('/product/orders/status', [ProductOrderController::class, 'status'])->name('admin.product.orders.status');
      Route::get('/product/orders/detais/{id}', [ProductOrderController::class, 'details'])->name('admin.product.details');
      Route::post('/product/order/delete', [ProductOrderController::class, 'orderDelete'])->name('admin.product.order.delete');
      Route::post('/product/order/bulk-delete', [ProductOrderController::class, 'bulkOrderDelete'])->name('admin.product.order.bulk.delete');
      // Product Order end


      // Admin Testimonial Routes
      Route::get('/product-template', [ProductTemplateController::class, 'index'])->name('admin.product-template.index');
      Route::get('/product-template/create', [ProductTemplateController::class, 'create'])->name('admin.product-template.create');
      Route::post('/product-template/upload', [ProductTemplateController::class, 'upload'])->name('admin.product-template.upload');
      Route::post('/product-template/store', [ProductTemplateController::class, 'store'])->name('admin.product-template.store');
      Route::get('/product-template/{id}/edit', [ProductTemplateController::class, 'edit'])->name('admin.product-template.edit');
      Route::post('/product-template/update', [ProductTemplateController::class, 'update'])->name('admin.product-template.update');
      Route::post('/product-template/{id}/uploadUpdate', [ProductTemplateController::class, 'uploadUpdate'])->name('admin.product-template.uploadUpdate');
      Route::post('/product-template/delete', [ProductTemplateController::class, 'delete'])->name('admin.product-template.delete');
    });

    // Register User start
    Route::get('register/users', [RegisterUserController::class, 'index'])->name('admin.register.user');
    Route::get('register/users/create', [RegisterUserController::class, 'create'])->name('admin.register.user.create');
    Route::post('register/users/store', [RegisterUserController::class, 'store'])->name('admin.register.user.store');
    Route::get('register/users/{id}/edit', [RegisterUserController::class, 'edit'])->name('admin.register.user.edit');
    Route::post('register/users/update', [RegisterUserController::class, 'update'])->name('admin.register.user.update');
    Route::post('register/users/ban', [RegisterUserController::class, 'userban'])->name('register.user.ban');
    Route::get('register/user/details/{id}', [RegisterUserController::class, 'view'])->name('register.user.view');
    Route::post('/register/user/import', [RegisterUserController::class, 'import'])->name('register.user.import');
    Route::post('/register/user/export', [RegisterUserController::class, 'export'])->name('register.user.export');
    Route::post('/register/user/updateCredit', [RegisterUserController::class, 'updateCredit'])->name('register.user.updateCredit');
    Route::post('/register/user/updateDefaultCredit', [RegisterUserController::class, 'updateDefaultCredit'])->name('register.user.updateDefaultCredit');

    //Register User end



    Route::group(['middleware' => 'checkpermission:Portfolio Management'], function () {
      // Admin Portfolio Routes
      Route::get('/portfolios', [PortfolioController::class, 'index'])->name('admin.portfolio.index');
      Route::get('/portfolio/create', [PortfolioController::class, 'create'])->name('admin.portfolio.create');
      Route::post('/portfolio/sliderstore', [PortfolioController::class, 'sliderstore'])->name('admin.portfolio.sliderstore');
      Route::post('/portfolio/sliderrmv', [PortfolioController::class, 'sliderrmv'])->name('admin.portfolio.sliderrmv');
      Route::post('/portfolio/upload', [PortfolioController::class, 'upload'])->name('admin.portfolio.upload');
      Route::post('/portfolio/store', [PortfolioController::class, 'store'])->name('admin.portfolio.store');
      Route::get('/portfolio/{id}/edit', [PortfolioController::class, 'edit'])->name('admin.portfolio.edit');
      Route::get('/portfolio/{id}/images', [PortfolioController::class, 'images'])->name('admin.portfolio.images');
      Route::post('/portfolio/sliderupdate', [PortfolioController::class, 'sliderupdate'])->name('admin.portfolio.sliderupdate');
      Route::post('/portfolio/{id}/uploadUpdate', [PortfolioController::class, 'uploadUpdate'])->name('admin.portfolio.uploadUpdate');
      Route::post('/portfolio/update', [PortfolioController::class, 'update'])->name('admin.portfolio.update');
      Route::post('/portfolio/delete', [PortfolioController::class, 'delete'])->name('admin.portfolio.delete');
      Route::post('/portfolio/bulk-delete', [PortfolioController::class, 'bulkDelete'])->name('admin.portfolio.bulk.delete');
      Route::get('portfolio/{id}/getservices', [PortfolioController::class, 'getservices'])->name('admin.portfolio.getservices');
      Route::post('/portfolio/feature', [PortfolioController::class, 'feature'])->name('admin.portfolio.feature');

      // Portfolio Category

      Route::get('/portfolio-category', [PortfolioCategoryController::class, 'index'])->name('admin.portfolio-category.index');
      Route::post('/portfolio-category/store', [PortfolioCategoryController::class, 'store'])->name('admin.portfolio-category.store');
      Route::post('/portfolio-category/update', [PortfolioCategoryController::class, 'update'])->name('admin.portfolio-category.update');
      Route::post('/portfolio-category/delete', [PortfolioCategoryController::class, 'delete'])->name('admin.portfolio-category.delete');
      Route::post('/portfolio-category/bulk-delete', [PortfolioCategoryController::class, 'bulkDelete'])->name('admin.portfolio-category.bulk.delete');

      Route::get('/portfolio-category/{langid}/getcats', [PortfolioCategoryController::class, 'getcats'])->name('admin.portfolio-category.getcats');
    });



    Route::group(['middleware' => 'checkpermission:Career Page'], function () {
      // Admin Job Category Routes
      Route::get('/jcategorys', [JcategoryController::class, 'index'])->name('admin.jcategory.index');
      Route::post('/jcategory/store', [JcategoryController::class, 'store'])->name('admin.jcategory.store');
      Route::get('/jcategory/{id}/edit', [JcategoryController::class, 'edit'])->name('admin.jcategory.edit');
      Route::post('/jcategory/update', [JcategoryController::class, 'update'])->name('admin.jcategory.update');
      Route::post('/jcategory/delete', [JcategoryController::class, 'delete'])->name('admin.jcategory.delete');
      Route::post('/jcategory/bulk-delete', [JcategoryController::class, 'bulkDelete'])->name('admin.jcategory.bulk.delete');

      // Admin Jobs Routes
      Route::get('/jobs', [JobController::class, 'index'])->name('admin.job.index');
      Route::get('/job/create', [JobController::class, 'create'])->name('admin.job.create');
      Route::post('/job/store', [JobController::class, 'store'])->name('admin.job.store');
      Route::get('/job/{id}/edit', [JobController::class, 'edit'])->name('admin.job.edit');
      Route::post('/job/update', [JobController::class, 'update'])->name('admin.job.update');
      Route::post('/job/delete', [JobController::class, 'delete'])->name('admin.job.delete');
      Route::post('/job/bulk-delete', [JobController::class, 'bulkDelete'])->name('admin.job.bulk.delete');
      Route::get('/job/{langid}/getcats', [JobController::class, 'getcats'])->name('admin.job.getcats');
    });

    // Admin Event Calendar Routes
    Route::group(['middleware' => 'checkpermission:Event Calendar'], function () {

      Route::get('/calendars', [CalendarController::class, 'index'])->name('admin.calendar.index');
      Route::post('/calendar/repeat-interval-type/change', [CalendarController::class, 'changeRepeatIntervalType'])->name('admin.calendar.changeRepeatIntervalType');
      Route::post('/calendar/end-action-type/change', [CalendarController::class, 'changeEndActionType'])->name('admin.calendar.changeEndActionType');
      Route::get('/calendar/create', [CalendarController::class, 'create'])->name('admin.calendar.create');
      Route::post('/calendar/store', [CalendarController::class, 'store'])->name('admin.calendar.store');
      Route::get('/calendar/{id}/edit', [CalendarController::class, 'edit'])->name('admin.calendar.edit');
      Route::post('/calendar/update', [CalendarController::class, 'update'])->name('admin.calendar.update');
      Route::post('/calendar/delete', [CalendarController::class, 'delete'])->name('admin.calendar.delete');
      Route::post('/calendar/bulk-delete', [CalendarController::class, 'bulkDelete'])->name('admin.calendar.bulk.delete');
      Route::post('/calendar/add-event-to-calendar', [CalendarController::class, 'addEventToCalendar'])->name('admin.calendar.bulk.addEventToCalendar');


      Route::get('/community-calendar', [CalendarController::class, 'indexCommunityCalendar'])->name('admin.communityCalendar.index');
      Route::get('/community-calendar', [CalendarController::class, 'indexCommunityCalendar'])->name('admin.communityCalendar.index');
      Route::get('/community-calendar/{id}/showCommunityCalendar', [CalendarController::class, 'showCommunityCalendar'])->name('admin.communityCalendar.show');
      Route::post('/community-calendar/store', [CalendarController::class, 'storeCommunityCalendar'])->name('admin.communityCalendar.store');
      Route::get('/community-calendar/{id}/edit', [CalendarController::class, 'editCommunityCalendar'])->name('admin.communityCalendar.edit');
      Route::post('/community-calendar/update', [CalendarController::class, 'updateCommunityCalendar'])->name('admin.communityCalendar.update');
      Route::post('/community-calendar/delete', [CalendarController::class, 'deleteCommunityCalendar'])->name('admin.communityCalendar.delete');
      Route::post('/community-calendar/bulk-delete', [CalendarController::class, 'bulkDeleteCommunityCalendar'])->name('admin.communityCalendar.bulk.delete');
      Route::get('/community-calendar/{id}/export', [CalendarController::class, 'exportCommunityCalendar'])->name('admin.communityCalendar.exportCommunityCalendar');

      // Calendar settings
      Route::get('/calendar-settings', [CalendarController::class, 'calendarSetting'])->name('admin.calendarSetting.index');
      Route::post('/calendar-settings/update', [CalendarController::class, 'updateCalendarSetting'])->name('admin.calendarSetting.update');
    });



    Route::group(['middleware' => 'checkpermission:Gallery Management'], function () {
      // Admin Gallery Routes
      Route::get('/gallery', [GalleryController::class, 'index'])->name('admin.gallery.index');
      Route::post('/gallery/upload', [GalleryController::class, 'upload'])->name('admin.gallery.upload');
      Route::post('/gallery/store', [GalleryController::class, 'store'])->name('admin.gallery.store');
      Route::post('/gallery/{id}/deleteDocFile', [GalleryController::class, 'deleteDocFile'])->name('admin.gallery.deleteDocFile');
      Route::get('/gallery/{id}/edit', [GalleryController::class, 'edit'])->name('admin.gallery.edit');
      Route::post('/gallery/update', [GalleryController::class, 'update'])->name('admin.gallery.update');
      Route::post('/gallery/{id}/uploadUpdate', [GalleryController::class, 'uploadUpdate'])->name('admin.gallery.uploadUpdate');
      Route::post('/gallery/delete', [GalleryController::class, 'delete'])->name('admin.gallery.delete');
      Route::post('/gallery/bulk-delete', [GalleryController::class, 'bulkDelete'])->name('admin.gallery.bulk.delete');
      Route::post('/gallery/{id}/deleteAudioFile', [GalleryController::class, 'deleteAudioFile'])->name('admin.gallery.deleteAudioFile');
    });

    Route::group(['middleware' => 'checkpermission:Blogs'], function () {
      // Admin Blog Category Routes
      Route::get('/bcategorys', [BcategoryController::class, 'index'])->name('admin.bcategory.index');
      Route::post('/bcategory/store', [BcategoryController::class, 'store'])->name('admin.bcategory.store');
      Route::post('/bcategory/update', [BcategoryController::class, 'update'])->name('admin.bcategory.update');
      Route::post('/bcategory/delete', [BcategoryController::class, 'delete'])->name('admin.bcategory.delete');
      Route::post('/bcategory/bulk-delete', [BcategoryController::class, 'bulkDelete'])->name('admin.bcategory.bulk.delete');



      // Admin Blog Routes
      Route::get('/blogs', [BlogController::class, 'index'])->name('admin.blog.index');
      Route::post('/blog/upload', [BlogController::class, 'upload'])->name('admin.blog.upload');
      Route::post('/blog/store', [BlogController::class, 'store'])->name('admin.blog.store');
      Route::get('/blog/{id}/edit', [BlogController::class, 'edit'])->name('admin.blog.edit');
      Route::post('/blog/update', [BlogController::class, 'update'])->name('admin.blog.update');
      Route::post('/blog/{id}/uploadUpdate', [BlogController::class, 'uploadUpdate'])->name('admin.blog.uploadUpdate');
      Route::post('/blog/delete', [BlogController::class, 'delete'])->name('admin.blog.delete');
      Route::post('/blog/bulk-delete', [BlogController::class, 'bulkDelete'])->name('admin.blog.bulk.delete');
      Route::get('/blog/{langid}/getcats', [BlogController::class, 'getcats'])->name('admin.blog.getcats');


      // Admin Blog Archive Routes
      Route::get('/archives', [ArchiveController::class, 'index'])->name('admin.archive.index');
      Route::post('/archive/store', [ArchiveController::class, 'store'])->name('admin.archive.store');
      Route::post('/archive/update', [ArchiveController::class, 'update'])->name('admin.archive.update');
      Route::post('/archive/delete', [ArchiveController::class, 'delete'])->name('admin.archive.delete');
    });

    // Admin Eduation Article Category Routes
    Route::get('/education-category', [EducationBlogCategoryController::class, 'index'])->name('admin.educationCategory.index');
    Route::post('/education-category/store', [EducationBlogCategoryController::class, 'store'])->name('admin.educationCategory.store');
    Route::post('/education-category/update', [EducationBlogCategoryController::class, 'update'])->name('admin.educationCategory.update');
    Route::post('/education-category/delete', [EducationBlogCategoryController::class, 'delete'])->name('admin.educationCategory.delete');
    Route::post('/education-category/bulk-delete', [EducationBlogCategoryController::class, 'bulkDelete'])->name('admin.educationCategory.bulk.delete');

    // Admin Eduation Article Tag Routes
    Route::get('/education-tags', [EducationTagController::class, 'index'])->name('admin.educationTags.index');
    Route::post('/education-tags/store', [EducationTagController::class, 'store'])->name('admin.educationTags.store');
    Route::post('/education-tags/update', [EducationTagController::class, 'update'])->name('admin.educationTags.update');
    Route::post('/education-tags/delete', [EducationTagController::class, 'delete'])->name('admin.educationTags.delete');
    Route::post('/education-tags/bulk-delete', [EducationTagController::class, 'bulkDelete'])->name('admin.educationTags.bulk.delete');

    // Admin Eduation Article Blog Routes
    Route::get('/education-blog', [EducationBlogController::class, 'index'])->name('admin.educationBlog.index');
    Route::post('/education-blog/upload', [EducationBlogController::class, 'upload'])->name('admin.educationBlog.upload');
    Route::post('/education-blog/store', [EducationBlogController::class, 'store'])->name('admin.educationBlog.store');
    Route::get('/education-blog/{id}/edit', [EducationBlogController::class, 'edit'])->name('admin.educationBlog.edit');
    Route::post('/education-blog/update', [EducationBlogController::class, 'update'])->name('admin.educationBlog.update');
    Route::post('/education-blog/{id}/uploadUpdate', [EducationBlogController::class, 'uploadUpdate'])->name('admin.educationBlog.uploadUpdate');
    Route::post('/education-blog/delete', [EducationBlogController::class, 'delete'])->name('admin.educationBlog.delete');
    Route::post('/education-blog/bulk-delete', [EducationBlogController::class, 'bulkDelete'])->name('admin.educationBlog.bulk.delete');
    Route::get('/education-blog/{langid}/getcats', [EducationBlogController::class, 'getcats'])->name('admin.educationBlog.getcats');
    Route::post('/education-blog/get-tags-dropdown', [EducationBlogController::class, 'getTagsDropdown'])->name('admin.educationBlog.getTagsDropdown');


    Route::group(['middleware' => 'checkpermission:RSS Feeds'], function () {
      // Admin RSS feed Routes
      Route::get('/rss', [RssFeedsController::class, 'index'])->name('admin.rss.index');
      Route::get('/rss/feeds', [RssFeedsController::class, 'feed'])->name('admin.rss.feed');
      Route::get('/rss/create', [RssFeedsController::class, 'create'])->name('admin.rss.create');
      Route::post('/rss', [RssFeedsController::class, 'store'])->name('admin.rss.store');
      Route::get('/rss/edit/{id}', [RssFeedsController::class, 'edit'])->name('admin.rss.edit');
      Route::post('/rss/update', [RssFeedsController::class, 'update'])->name('admin.rss.update');
      Route::post('/rss/delete', [RssFeedsController::class, 'rssdelete'])->name('admin.rssfeed.delete');
      Route::post('/rss/feed/delete', [RssFeedsController::class, 'delete'])->name('admin.rss.delete');
      Route::post('/rss-posts/bulk/delete', [RssFeedsController::class, 'bulkDelete'])->name('admin.rss.bulk.delete');

      Route::get('rss-feed/update/{id}', [RssFeedsController::class, 'feedUpdate'])->name('admin.rss.feedUpdate');
      Route::get('rss-feed/cronJobUpdate', [RssFeedsController::class, 'cronJobUpdate'])->name('rss.cronJobUpdate');
    });


    Route::group(['middleware' => 'checkpermission:Sitemap'], function () {

      Route::get('/sitemap', [SitemapController::class, 'index'])->name('admin.sitemap.index');
      Route::post('/sitemap/store', [SitemapController::class, 'store'])->name('admin.sitemap.store');
      Route::get('/sitemap/{id}/update', [SitemapController::class, 'update'])->name('admin.sitemap.update');
      Route::post('/sitemap/{id}/delete', [SitemapController::class, 'delete'])->name('admin.sitemap.delete');
      Route::post('/sitemap/download', [SitemapController::class, 'download'])->name('admin.sitemap.download');
    });


    Route::group(['middleware' => 'checkpermission:Contact Page'], function () {
      // Admin Contact Routes
      Route::get('/contact', [ContactController::class, 'index'])->name('admin.contact.index');
      Route::post('/contact/{langid}/post', [ContactController::class, 'update'])->name('admin.contact.update');

      Route::post('/contact-why-choose-us/store', [ContactController::class, 'whystore'])->name('admin.contact.whystore');
      Route::post('/contact-why-choose-us/update', [ContactController::class, 'whyupdate'])->name('admin.contact.whyupdate');
      Route::post('/contact-why-choose-us/delete', [ContactController::class, 'whydelete'])->name('admin.contact.whydelete');
      Route::post('/contact-why-choose-us/bulk-delete', [ContactController::class, 'whybulk'])->name('admin.contact.whybulk.delete');
    });


    Route::group(['middleware' => 'checkpermission:Tickets'], function () {
      // Admin Support Ticket Routes
      Route::get('/all/tickets', [AdminTicketController::class, 'all'])->name('admin.tickets.all');
      Route::get('/pending/tickets', [AdminTicketController::class, 'pending'])->name('admin.tickets.pending');
      Route::get('/open/tickets', [AdminTicketController::class, 'open'])->name('admin.tickets.open');
      Route::get('/closed/tickets', [AdminTicketController::class, 'closed'])->name('admin.tickets.closed');
      Route::get('/ticket/messages/{id}', [AdminTicketController::class, 'messages'])->name('admin.ticket.messages');
      Route::post('/zip-file/upload/', [AdminTicketController::class, 'zip_file_upload'])->name('admin.zip_file.upload');
      Route::post('/ticket/reply/{id}', [AdminTicketController::class, 'ticketReply'])->name('admin.ticket.reply');
      Route::get('/ticket/close/{id}', [AdminTicketController::class, 'ticketclose'])->name('admin.ticket.close');
      Route::post('/ticket/assign/staff', [AdminTicketController::class, 'ticketAssign'])->name('ticket.assign.staff');
    });


    Route::group(['middleware' => 'checkpermission:Package Management'], function () {

      // Admin Package Form Builder Routes
      Route::get('/package/form', [PackageController::class, 'form'])->name('admin.package.form');
      Route::post('/package/form/store', [PackageController::class, 'formstore'])->name('admin.package.form.store');
      Route::post('/package/inputDelete', [PackageController::class, 'inputDelete'])->name('admin.package.inputDelete');
      Route::get('/package/{id}/inputEdit', [PackageController::class, 'inputEdit'])->name('admin.package.inputEdit');
      Route::get('/package/{id}/options', [PackageController::class, 'options'])->name('admin.package.options');
      Route::post('/package/inputUpdate', [PackageController::class, 'inputUpdate'])->name('admin.package.inputUpdate');
      Route::post('/package/feature', [PackageController::class, 'feature'])->name('admin.package.feature');



      // Admin Packages Routes
      Route::get('/packages', [PackageController::class, 'index'])->name('admin.package.index');
      Route::post('/package/upload', [PackageController::class, 'upload'])->name('admin.package.upload');
      Route::post('/package/store', [PackageController::class, 'store'])->name('admin.package.store');
      Route::get('/package/{id}/edit', [PackageController::class, 'edit'])->name('admin.package.edit');
      Route::post('/package/update', [PackageController::class, 'update'])->name('admin.package.update');
      Route::post('/package/{id}/uploadUpdate', [PackageController::class, 'uploadUpdate'])->name('admin.package.uploadUpdate');
      Route::post('/package/delete', [PackageController::class, 'delete'])->name('admin.package.delete');
      Route::post('/package/bulk-delete', [PackageController::class, 'bulkDelete'])->name('admin.package.bulk.delete');
      Route::get('/all/orders', [PackageController::class, 'all'])->name('admin.all.orders');
      Route::get('/pending/orders', [PackageController::class, 'pending'])->name('admin.pending.orders');
      Route::get('/processing/orders', [PackageController::class, 'processing'])->name('admin.processing.orders');
      Route::get('/completed/orders', [PackageController::class, 'completed'])->name('admin.completed.orders');
      Route::get('/rejected/orders', [PackageController::class, 'rejected'])->name('admin.rejected.orders');
      Route::post('/orders/status', [PackageController::class, 'status'])->name('admin.orders.status');
      Route::post('/orders/mail', [PackageController::class, 'mail'])->name('admin.orders.mail');
      Route::post('/package/order/delete', [PackageController::class, 'orderDelete'])->name('admin.package.order.delete');
      Route::post('/order/bulk-delete', [PackageController::class, 'bulkOrderDelete'])->name('admin.order.bulk.delete');

      Route::post('/packages/update-section-store', [PackageController::class, 'updateSection'])->name('admin.packages.updateSection');
    });



    Route::group(['middleware' => 'checkpermission:Quote Management'], function () {

      // Admin Quote Form Builder Routes
      Route::get('/quote/nav-menu', [QuoteController::class, 'navMenu'])->name('admin.quote.navMenu');
      Route::post('/quote/nav-menu/{langid}/update', [QuoteController::class, 'updateNavMenu'])->name('admin.quote.navMenu.update');

      Route::get('/quote/form', [QuoteController::class, 'form'])->name('admin.quote.form');
      Route::post('/quote/form/store', [QuoteController::class, 'formstore'])->name('admin.quote.form.store');
      Route::post('/quote/inputDelete', [QuoteController::class, 'inputDelete'])->name('admin.quote.inputDelete');
      Route::get('/quote/{id}/inputEdit', [QuoteController::class, 'inputEdit'])->name('admin.quote.inputEdit');
      Route::get('/quote/{id}/options', [QuoteController::class, 'options'])->name('admin.quote.options');
      Route::post('/quote/inputUpdate', [QuoteController::class, 'inputUpdate'])->name('admin.quote.inputUpdate');
      Route::post('/quote/delete', [QuoteController::class, 'delete'])->name('admin.quote.delete');
      Route::post('/quote/bulk-delete', [QuoteController::class, 'bulkDelete'])->name('admin.quote.bulk.delete');


      // Admin Quote Routes
      Route::get('/all/quotes', [QuoteController::class, 'all'])->name('admin.all.quotes');
      Route::get('/pending/quotes', [QuoteController::class, 'pending'])->name('admin.pending.quotes');
      Route::get('/processing/quotes', [QuoteController::class, 'processing'])->name('admin.processing.quotes');
      Route::get('/completed/quotes', [QuoteController::class, 'completed'])->name('admin.completed.quotes');
      Route::get('/rejected/quotes', [QuoteController::class, 'rejected'])->name('admin.rejected.quotes');
      Route::post('/quotes/status', [QuoteController::class, 'status'])->name('admin.quotes.status');
      Route::post('/quote/mail', [QuoteController::class, 'mail'])->name('admin.quotes.mail');
    });



    //   Route::group(['middleware' => 'checkpermission:Role Management'], function() {
    // Admin Roles Routes
    Route::get('/gateways', [GatewayController::class, 'index'])->name('admin.gateway.index');
    Route::post('/stripe/update', [GatewayController::class, 'stripeUpdate'])->name('admin.stripe.update');
    Route::post('/paypal/update', [GatewayController::class, 'paypalUpdate'])->name('admin.paypal.update');
    Route::post('/paystack/update', [GatewayController::class, 'paystackUpdate'])->name('admin.paystack.update');
    Route::post('/paytm/update', [GatewayController::class, 'paytmUpdate'])->name('admin.paytm.update');
    Route::post('/flutterwave/update', [GatewayController::class, 'flutterwaveUpdate'])->name('admin.flutterwave.update');
    Route::post('/instamojo/update', [GatewayController::class, 'instamojoUpdate'])->name('admin.instamojo.update');
    Route::post('/mollie/update', [GatewayController::class, 'mollieUpdate'])->name('admin.mollie.update');
    Route::post('/razorpay/update', [GatewayController::class, 'razorpayUpdate'])->name('admin.razorpay.update');
    Route::post('/mercadopago/update', [GatewayController::class, 'mercadopagoUpdate'])->name('admin.mercadopago.update');
    Route::post('/payumoney/update', [GatewayController::class, 'payumoneyUpdate'])->name('admin.payumoney.update');
    Route::get('/offline/gateways', [GatewayController::class, 'offline'])->name('admin.gateway.offline');
    Route::post('/offline/gateway/store', [GatewayController::class, 'store'])->name('admin.gateway.offline.store');
    Route::post('/offline/gateway/update', [GatewayController::class, 'update'])->name('admin.gateway.offline.update');
    Route::post('/offline/status', [GatewayController::class, 'status'])->name('admin.offline.status');
    Route::post('/offline/gateway/delete', [GatewayController::class, 'delete'])->name('admin.offline.gateway.delete');



    Route::group(['middleware' => 'checkpermission:Role Management'], function () {
      // Admin Roles Routes
      Route::get('/roles', [RoleController::class, 'index'])->name('admin.role.index');
      Route::post('/role/store', [RoleController::class, 'store'])->name('admin.role.store');
      Route::post('/role/update', [RoleController::class, 'update'])->name('admin.role.update');
      Route::post('/role/delete', [RoleController::class, 'delete'])->name('admin.role.delete');
      Route::get('role/{id}/permissions/manage', [RoleController::class, 'managePermissions'])->name('admin.role.permissions.manage');
      Route::post('role/permissions/update', [RoleController::class, 'updatePermissions'])->name('admin.role.permissions.update');
    });



    Route::group(['middleware' => 'checkpermission:Users Management'], function () {
      // Admin Users Routes
      Route::get('/users', [AdminUserController::class, 'index'])->name('admin.user.index');
      Route::post('/user/upload', [AdminUserController::class, 'upload'])->name('admin.user.upload');
      Route::post('/user/store', [AdminUserController::class, 'store'])->name('admin.user.store');
      Route::get('/user/{id}/edit', [AdminUserController::class, 'edit'])->name('admin.user.edit');
      Route::post('/user/update', [AdminUserController::class, 'update'])->name('admin.user.update');
      Route::post('/user/{id}/uploadUpdate', [AdminUserController::class, 'uploadUpdate'])->name('admin.user.uploadUpdate');
      Route::post('/user/delete', [AdminUserController::class, 'delete'])->name('admin.user.delete');
      //technicians
    });

    Route::group(['middleware' => 'checkpermission:Technicians Management'], function () {
    Route::get('/technicians', [TechnicianController::class, 'index'])->name('admin.technician.index');
    Route::post('/technician/store', [TechnicianController::class, 'store'])->name('admin.technician.store');
    Route::get('/technician/edit/{id}', [TechnicianController::class, 'edit'])->name('admin.technician.edit');
    Route::post('/technician/update', [TechnicianController::class, 'update'])->name('admin.technician.update');
    Route::post('/technician/delete', [TechnicianController::class, 'destroy'])->name('admin.technician.delete');
    });

    Route::group(['middleware' => 'checkpermission:Customers Management'], function () {
        Route::get('/customers', [CompanyController::class, 'index'])->name('admin.customers.index');
        Route::post('/customers/store', [CompanyController::class, 'store'])->name('admin.customers.store');
        Route::get('/customers/delete', [CompanyController::class, 'destroy'])->name('admin.customers.delete');
        // Route::post('/technician/update', [TechnicianController::class, 'update'])->name('admin.technician.update');
        // Route::post('/technician/delete', [TechnicianController::class, 'destroy'])->name('admin.technician.delete');
        });



    Route::group(['middleware' => 'checkpermission:Language Management'], function () {
      // Admin Language Routes
      Route::get('/languages', [LanguageController::class, 'index'])->name('admin.language.index');
      Route::get('/language/{id}/edit', [LanguageController::class, 'edit'])->name('admin.language.edit');
      Route::get('/language/{id}/edit/keyword', [LanguageController::class, 'editKeyword'])->name('admin.language.editKeyword');
      Route::post('/language/store', [LanguageController::class, 'store'])->name('admin.language.store');
      Route::post('/language/upload', [LanguageController::class, 'upload'])->name('admin.language.upload');
      Route::post('/language/{id}/uploadUpdate', [LanguageController::class, 'uploadUpdate'])->name('admin.language.uploadUpdate');
      Route::post('/language/{id}/default', [LanguageController::class, 'default'])->name('admin.language.default');
      Route::post('/language/{id}/delete', [LanguageController::class, 'delete'])->name('admin.language.delete');
      Route::post('/language/update', [LanguageController::class, 'update'])->name('admin.language.update');
      Route::post('/language/{id}/update/keyword', [LanguageController::class, 'updateKeyword'])->name('admin.language.updateKeyword');
    });


    Route::group(['middleware' => 'checkpermission:Backup'], function () {
      // Admin Backup Routes
      Route::get('/backup', [BackupController::class, 'index'])->name('admin.backup.index');
      Route::post('/backup/store', [BackupController::class, 'store'])->name('admin.backup.store');
      Route::post('/backup/{id}/delete', [BackupController::class, 'delete'])->name('admin.backup.delete');
      Route::post('/backup/download', [BackupController::class, 'download'])->name('admin.backup.download');
    });


    // Admin Cache Clear Routes
    Route::get('/cache-clear', [CacheController::class, 'clear'])->name('admin.cache.clear');


    #Services Management
    Route::get('booking-services/ServicesData', [ServicesController::class, 'getServicesData'])->name('admin.booking-services.getServicesData');
    Route::post('booking-services/changeStatus', [ServicesController::class, 'changeServiceStatus'])->name('admin.booking-services.changeServiceStatus');
    Route::resource('booking-services', ServicesController::class);

    #currency management
    Route::get('currency/CurrencyData', [CurrencyController::class, 'getCurrencyData'])->name('admin.currency.getCurrencyData');
    Route::post('currency/changeStatus', [CurrencyController::class, 'changeCurrencyStatus'])->name('admin.currency.changeCurrencyStatus');
    Route::resource('currency', CurrencyController::class);

    #chat Management
    Route::get('chatboard/history/{id}', [AdminChatController::class, 'history'])->name('admin.chatboard.history');
    Route::get('chatboard/{id}', [AdminChatController::class, 'index'])->name('admin.chatboard.showhistory');
    Route::post('chatboard/store', [AdminChatController::class, 'store']);
    Route::post('chatboard/notificationCount', [AdminChatController::class, 'getNotificationCount'])
      ->name('admin.chatboard.getNotificationCount');
    Route::resource('chatboard', AdminChatController::class);

    #Booking Management
    Route::get('booking/setting', [AdminBookingController::class, 'setting'])->name('admin.booking.setting');
    Route::post('booking/updateSettings', [AdminBookingController::class, 'updateSettings'])->name('admin.booking.updateSettings');

    Route::get('booking/email-setting', [AdminBookingController::class, 'emailSetting'])->name('admin.booking.emailSetting');
    Route::post('booking/updateEmailSettings', [AdminBookingController::class, 'updateEmailSettings'])->name('admin.booking.updateEmailSettings');
    Route::get('booking/run-booking-spot-endtime', [AdminBookingController::class, 'runBookingSpotCronJob'])->name('admin.booking.runBookingSpotCronJob');

    Route::get('booking/export', [AdminBookingController::class, 'export'])->name('admin.booking.export');
    Route::any('booking/search', [AdminBookingController::class, 'index'])->name('admin.booking.search');
    Route::post('booking/changeStatus', [AdminBookingController::class, 'changeBookingStatus'])->name('admin.booking.changeBookingStatus');
    Route::resource('booking', AdminBookingController::class);

    Route::get('my-booking', [AdminBookingController::class, 'myBooking'])->name('admin.booking.myBooking');
    Route::any('my-booking/search', [AdminBookingController::class, 'myBooking'])->name('admin.mybooking.search');

    Route::resource('users.booking', AdminBookingController::class);

    #Transaction Management
    Route::get('transaction/export', [AdminTransactionController::class, 'export']);
    Route::any('transaction/search', array('uses' => [AdminTransactionController::class, 'index'], 'as' => 'admin.transaction.search'));
    Route::resource('transaction', AdminTransactionController::class);

    Route::resource('users.transaction', AdminTransactionController::class);

    // Email Inbox route

    //Inboxwebmail
    Route::get('inboxwebmails', [InboxwebmailController::class, 'index'])->name('admin.inboxwebmails');
    Route::get('add-new/inboxwebmail', [InboxwebmailController::class, 'inboxwebmailAdd'])->name('admin.inboxwebmail.add');
    Route::post('add-new/inboxwebmail', [InboxwebmailController::class, 'inboxwebmailPost'])->name('admin.inboxwebmail.post');
    Route::get('inboxwebmail/edit/{id}', [InboxwebmailController::class, 'inboxwebmailEdit'])->name('admin.inboxwebmail.edit');
    Route::get('inboxwebmail/delete/{id}', [InboxwebmailController::class, 'inboxwebmailDelete'])->name('admin.inboxwebmail.delete');
    Route::post('inboxwebmail/update/{id}', [InboxwebmailController::class, 'inboxwebmailUpdate'])->name('admin.inboxwebmail.update');
    Route::post('inboxwebmail/labels/{id}', [InboxwebmailController::class, 'inboxwebmailLabels'])->name('admin.inboxwebmail.labels');
    Route::post('inboxwebmail/label/delete', [InboxwebmailController::class, 'inboxwebmailLabelDelete'])->name('admin.inboxwebmail.label.delete');
    Route::get('inboxwebmail/view/{uid}', [InboxwebmailController::class, 'inboxwebmailView'])->name('admin.inboxwebmail.view');
    Route::post('inboxwebmail/view/{uid}', [InboxwebmailController::class, 'inboxwebmailView'])->name('admin.inboxwebmail.view');
    Route::get('inboxwebmail/compose/{uid}', [InboxwebmailController::class, 'inboxwebmailCompose'])->name('admin.inboxwebmail.compose');
    Route::get('inboxwebmail/refdata/{uid}', [InboxwebmailController::class, 'inboxwebmailRefdata'])->name('admin.inboxwebmail.refdata');
    Route::post('inboxwebmail/composesend/{uid}', [InboxwebmailController::class, 'inboxwebmailComposesend'])->name('admin.inboxwebmail.composesend');
  });

  Route::get('/{slug}', [FrontendController::class, 'dynamicPage'])->name('front.dynamicPage');
});
