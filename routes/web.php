<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminDepositController;
use App\Http\Controllers\Admin\AdminInvestmentController;
use App\Http\Controllers\Admin\AdminKycController;
use App\Http\Controllers\Admin\AdminMediaController;
use App\Http\Controllers\Admin\AdminPdfController;
use App\Http\Controllers\Admin\AdminSupportController;
use App\Http\Controllers\Admin\AdminWithdrawalController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\WalletAddressController;
use App\Http\Controllers\Admin\WithdrawalAddressController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\DepositController;
use App\Http\Controllers\User\ForgotPinController;
use App\Http\Controllers\User\InvestmentController;
use App\Http\Controllers\User\KycController;
use App\Http\Controllers\User\MarketController;
use App\Http\Controllers\User\NowPaymentsController;
use App\Http\Controllers\User\PdfController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\ReferralController;
use App\Http\Controllers\User\SupportController;
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserMediaController;
use App\Http\Controllers\User\WithdrawalController;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
})->name('/');


Route::get('about-us', function () {
    return view('about');
})->name('about-us');


Route::get('meet-jarden', function () {
    return view('meet-jarden');
})->name('meet-jarden');


Route::get('contact', function () {
    return view('contact');
})->name('contact');


Route::get('privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');


Route::get('terms', function () {
    return view('terms');
})->name('terms');


// routes/web.php
// Route::get('/test-investment', function () {

//     $reference = 'INV-' . now()->format('ymdHis') . '-' . strtoupper(Str::random(5));

//     $user = auth()->user();

//     $investment = $user->investments()->create([
//         'plan_id' => 3, // Use an existing plan ID
//         'user_id' => $user->id,
//         'amount' => 1000,
//         'status' => true,
//         'profit' => 500,
//         'roi' => 1000,
//         'start_date' => now()->subDays(30),
//         'end_date' => now()->subDays(1), // Past date to make it due
//         'withdrawn' => false,
//         'due' => true,
//         'reference' => $reference,
//     ]);


//     // ✅ Create transaction record for investment debit
//     Transaction::create([
//         'user_id' => $user->id,
//         'amount' => 1000,
//         'type' => 'investment',
//         'status' => 'completed',
//         'description' => 'Investment into Basic plan',
//         'reference' => $reference,
//     ]);

//     return redirect('user/investments');
// });




Route::post('/admin/register', [UserController::class, 'createAdmin'])->name('admin.create');

Route::get('/sign-up', [UserController::class, 'showRegistrationForm'])->middleware('check.referral')
    ->name('user.register-form');

Route::post('/create-user', [UserController::class, 'createUser'])->name('user.create');


Route::get('/verify-otp/{token}', [UserController::class, 'showVerifyOtpForm'])->name('verify.otp');


Route::post('/verify-otp', [UserController::class, 'submitOtp'])->name('otp.submit');

Route::post('/resend-otp', [UserController::class, 'resendOtp'])->name('otp.resend');

// forgot password routes
Route::controller(ForgotPasswordController::class)->group(function () {
    Route::get('/forgot-password', 'showForgotPasswordForm')->name('password.forgot');
    Route::post('/forgot-password', 'submitForgotPassword')->name('email.submit');

    Route::get('/confirm-code/{token}', 'showConfirmCodeForm')->name('confirm.code');
    Route::post('/confirm-code',  'submitResetCode')->name('password-reset-code.submit');


    Route::get('/reset-password/{token}', 'showResetPasswordForm')->name('password.reset.form');
    Route::post('/reset-password', 'submitResetPassword')->name('reset.password.submit');

    Route::post('/password-reset/resend', [ForgotPasswordController::class, 'resendOtp'])->name('password-reset.resend');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('logout', [HomeController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'userDashboard'])->name('user.dashboard');

    Route::prefix('media')->controller(UserMediaController::class)->group(function () {
        Route::get('/', 'index')->name('user.media');
    });


    // Protected investment routes (require KYC)
    Route::middleware(['kyc.verified'])->controller(InvestmentController::class)->group(function () {
        Route::get('/smart-trades', 'trades')->name('user.trades');
        Route::get('/trades', 'investmentHistory')->name('user.investment-list');
        Route::get('/packages/select/{plan:slug}', 'startInvestment')->name('user.start-investment');
        Route::get('/smart-trades/checkout', 'checkoutInvestment')->name('user.checkout-investmennt');
        Route::post('/investment/validate', 'validateInvestment')->name('user.validate-investment');
        Route::get('/smart-trades/confirm', 'confirmInvestment')->name('user.confirm-investment');
        Route::post('/smart-trades/process', 'processInvestment')->name('user.process-investment');
        Route::post('/investment/{investment}/withdraw', 'withdrawInvestment')->name('user.investment.withdraw');
    });


    // KYC ROUTES
    Route::controller(KycController::class)->group(function () {

        Route::get('/kyc', [KycController::class, 'index'])->name('user.kyc');
        Route::get('/kyc/verification', 'verification')->middleware('signed')->name('user.kyc.verification');
        Route::post('/kyc/verification/verify', 'storeVerification')->name('user.kyc.verification.store');
        Route::get('/kyc/verification/document-upload', 'documentUpload')->name('user.kyc.document-upload');
        Route::post('/kyc/verification/document-upload', 'storeDocuments')->name('user.kyc.document-upload.store');
        Route::get('/kyc/verification/review', 'review')->name('user.kyc.review');
        Route::get('/kyc/list', 'kycList')->name('user.kyc-list');

        Route::get('/kyc/status', [KycController::class, 'status'])->name('user.kyc.status');
    });



    Route::middleware(['kyc.verified'])->controller(DepositController::class)->group(function () {
        Route::get('/deposit', 'deposit')->name('user.deposit');
        Route::post('/deposit', 'store')->name('deposit.store');
        Route::get('/confirm/deposit', 'showWallet')->name('confirm.deposit');

        Route::post('user/deposit/cancel', [DepositController::class, 'cancel'])->name('cancel.deposit');


        Route::post('/process-deposit', 'processDeposit')->name('process.deposit');
        Route::get('/deposit/success', 'depositSuccess')->name('deposit.success');
        Route::get('/deposit-list', 'depositList')->name('user.deposit-list');
        Route::post('/deposit/{deposit}/cancel', 'cancelDeposit')->name('deposit.cancel');
    });


    Route::middleware(['kyc.verified'])->controller(TransactionController::class)->group(function () {
        Route::get('/transactions-audit', 'transactions')->name('user.transactions');
    });


    Route::middleware(['kyc.verified'])->controller(WithdrawalController::class)->group(function () {
        Route::get('/withdrawal', 'withdrawal')->name('user.withdrawal');
        // Route::get('security/set-pin', 'setPin')->name('user.settings.security');
        Route::get('/security/set-pin', 'setPin')->name('user.settings.security')->middleware('signed');
        Route::post('security/set-pin', 'createPin')->name('user.create-pin');
        Route::post('/withdrawal/process', 'processWithdrawal')->name('user.withdrawal.process');

        Route::post('/withdrawal/initiate', 'initiateWithdrawal')->name('user.withdrawal.initiate');
        Route::get('scheme/confirm-pin', 'confirmPin')->name('user.withdrawal.confirm-pin');
        Route::post('/withdrawal/confirm', 'confirmWithdrawal')->name('user.withdrawal.confirm');

        Route::get('/withdrawal/history', 'withdrawalHistory')->name('user.withdrawal.history');
    });

    Route::middleware(['kyc.verified'])->controller(WithdrawalController::class)->group(function () {
        Route::get('/withdrawal', 'withdrawal')->name('user.withdrawal');
        // Route::get('security/set-pin', 'setPin')->name('user.settings.security');
        Route::get('/security/set-pin', 'setPin')->name('user.settings.security')->middleware('signed');
        Route::post('security/set-pin', 'createPin')->name('user.create-pin');
        Route::post('/withdrawal/process', 'processWithdrawal')->name('user.withdrawal.process');

        Route::post('/withdrawal/initiate', 'initiateWithdrawal')->name('user.withdrawal.initiate');
        Route::get('scheme/confirm-pin', 'confirmPin')->name('user.withdrawal.confirm-pin');
        Route::post('/withdrawal/confirm', 'confirmWithdrawal')->name('user.withdrawal.confirm');

        Route::get('/withdrawal/history', 'withdrawalHistory')->name('user.withdrawal.history');
    });


    Route::middleware(['kyc.verified'])->controller(MarketController::class)->group(function () {
        Route::get('/markets/overview',  'overview')->name('markets.overview');
        Route::get('/markets/live-price',  'livePrice')->name('markets.livePrice');
    });


    Route::middleware(['kyc.verified'])->controller(ReferralController::class)->group(function () {
        Route::get('/referrals', 'index')->name('user.referrals');
        Route::get('/referrals/commissions', 'commissions')->name('user.referrals.commissions');
        Route::get('/referrals/users', 'referredUsers')->name('user.referrals.users');
    });


    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'profile')->name('user.profile');

        Route::post('/update', 'updateProfile')->name('profile.update');
        Route::post('/update-phone', 'updatePhone')->name('profile.update.phone');
        Route::post('/update-password', 'updatePassword')->name('profile.update.password');
        Route::post('/update-picture', 'updateProfilePicture')->name('profile.update.picture');
        Route::post('/delete-account', 'deleteAccount')->name('profile.delete');

        // withdrawal pin
        Route::post('/update-pin', 'updatePin')->name('profile.update.pin');
    });


    Route::middleware(['kyc.verified'])->controller(ForgotPinController::class)->group(function () {
        Route::get('/forgot-pin', 'forgotPin')->name('user.forgot.pin');
        Route::get('/verify-pin/{token}', 'showVerifyOtpForm')->name('user.verify.pin.otp');

        Route::post('/verify-pin-otp', 'verifyOtp')->name('user.verify.pin.otp.submit');

        Route::get('/reset-pin/{token}', 'showResetPinForm')->name('user.reset.pin');
        Route::post('/reset-pin', 'resetPin')->name('user.reset.pin.submit');
    });



    Route::middleware(['kyc.verified'])->controller(PdfController::class)->group(function () {
        // Route::get('/pdf', 'pdf')->name('user.pdf');
        Route::get('/pdf/{language?}', [PdfController::class, 'pdf'])->name('user.pdf')->where('language', 'english|spanish|french|russian|chinese');
    });


    Route::controller(SupportController::class)->group(function () {

        Route::get('/support/ticket', 'support')->name('user.support');


        Route::get('/support/ticket/create', 'createSupport')->name('user.create.support');
        Route::post('/tickets', 'store')->name('user.tickets.store');
        // View ticket
        Route::get('/ticket/view/{reference_id}', [SupportController::class, 'viewTicket'])->name('user.ticket.view');
        // Add message
        Route::post('/ticket/{reference_id}/message', [SupportController::class, 'addMessage'])->name('user.ticket.message');

        // Close ticket
        Route::post('/ticket/{reference_id}/close', [SupportController::class, 'closeTicket'])->name('user.ticket.close');

        Route::delete('/ticket-messages/{message}', [SupportController::class, 'deleteMessage'])->name('user.ticket.message.delete');
    });
});



Route::middleware(['auth', 'isAdmin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');

    Route::get('/users', [AdminController::class, 'userList'])->name('admin.users');
    Route::post('/users/{user}/ban', [AdminController::class, 'banUser'])->name('admin.users.ban');
    Route::post('/users/{user}/unban', [AdminController::class, 'unbanUser'])->name('admin.users.unban');
    Route::delete('/users/{user}/delete', [AdminController::class, 'deleteUser'])->name('admin.users.delete');


    Route::get('/user/{user}', [AdminController::class, 'show'])->name('admin.users.show');
    Route::post('/user/{user}/fund-wallet', [AdminController::class, 'fundWallet'])->name('admin.users.fund-wallet');
    Route::post('/user/{user}/deduct-wallet', [AdminController::class, 'deductWallet'])->name('admin.users.deduct-wallet');

    Route::post('/users/{user}/wallet-activate', [AdminController::class, 'activateWallet'])->name('admin.users.wallet.activate');
    Route::post('/users/{user}/wallet-deactivate', [AdminController::class, 'deactivateWallet'])->name('admin.users.wallet.deactivate');


    Route::controller(DashboardController::class)->group(function () {
        Route::get('/transaction-audits', 'transactions')->name('admin.transactions.audits');
    });

    Route::controller(PlanController::class)->group(function () {
        Route::get('/plans', 'index')->name('plans.index');
        Route::get('/plans/create', 'create')->name('plans.create');
        Route::post('/plans', 'store')->name('plans.store');
        Route::get('/plans/{plan}/edit', 'edit')->name('plans.edit');
        Route::put('/plans/{plan}/update', 'update')->name('plans.update');
        Route::delete('/plans/{id}/delete', 'delete')->name('plans.delete');
    });

    Route::controller(WalletAddressController::class)->group(function () {
        Route::get('/wallet-address', 'index')->name('wallets.index');
        Route::get('/wallet-address/create', 'create')->name('wallets.create');
        Route::post('/store-wallet', 'store')->name('wallets.store');
        Route::delete('/wallets/{wallet}', [WalletAddressController::class, 'destroy'])->name('wallets.destroy');
        Route::get('/wallets/{wallet:slug}/edit', [WalletAddressController::class, 'edit'])->name('wallets.edit');
        Route::patch('/wallets/{wallet:slug}', [WalletAddressController::class, 'update'])->name('wallets.update');
    });



    Route::controller(WithdrawalAddressController::class)->group(function () {
        Route::get('/withdrawal-address', 'index')->name('withdrawals.wallet.index');
        Route::get('/withdrawal-address/create', 'create')->name('withdrawals.wallet.create');
        Route::post('/withdrawal-address', 'storeWallet')->name('withdrawals.wallet.store');

        Route::delete('/withdrawal-address/{id}', 'destroy')->name('withdrawals.wallet.destroy');

        Route::get('/withdrawal-address/{id}/edit', 'edit')->name('withdrawal.wallets.edit');
        Route::patch('/withdrawal-address/{id}', 'update')->name('withdrawals.wallet.update');
    });

    Route::controller(AdminDepositController::class)->group(function () {
        Route::get('/deposits/transactions',  'allTransactions')->name('admin.deposits.transactions');
        Route::post('/deposits/{transaction}/approve',  'approveDeposit')->name('deposit.approve');
        Route::post('/deposits/{transaction}/reject', 'rejectDeposit')->name('deposit.reject');
    });


    Route::controller(AdminWithdrawalController::class)->group(function () {
        Route::get('/withdrawals',  'allWithdrawals')->name('admin.withdrawals');
        Route::post('/withdrawals/{id}/approve', 'approveWithdrawal')->name('admin.withdrawals.approve');
        Route::post('/withdrawals/{id}/reject', 'rejectWithdrawal')->name('admin.withdrawals.reject');
    });

    Route::controller(AdminInvestmentController::class)->group(function () {
        Route::get('/investments', 'index')->name('admin.investments.index');
        Route::get('/investments/{investment}', 'show')->name('admin.investments.show');
        Route::post('/investments/{investment}/cancel',  'cancel')->name('admin.investments.cancel');
    });


    Route::prefix('media')->controller(AdminMediaController::class)->group(function () {

        Route::get('/', 'index')->name('admin.media.list');

        Route::get('/add-video', 'addVideo')->name('admin.add-video');
        Route::post('/store-video', 'storeVideo')->name('admin.store-video');

        Route::get('/edit-video/{reference}/{language}', 'edit')->name('admin.edit-video');
        Route::put('/update-video/{reference}/{language}', 'updateVideo')->name('admin.update-video');

        Route::delete('/delete-video/{reference}/{language}', 'destroy')->name('admin.delete-video');
    });


    Route::prefix('pdf')->controller(AdminPdfController::class)->group(function () {
        Route::get('/', 'index')->name('admin.pdf.list');

        Route::get('/add-pdf', 'addPdf')->name('admin.add-pdf');

        Route::post('/store-pdf', 'storePdf')->name('admin.store-pdf');

        Route::get('/edit-pdf/{reference}/{language}', 'edit')->name('admin.edit-pdf');
        Route::put('/update-pdf/{reference}/{language}', 'updatePdf')->name('admin.update-pdf');
        Route::delete('/delete-pdf/{reference}/{language}', 'destroy')->name('admin.delete-pdf');
    });


    // Admin KYC Routes
    Route::prefix('kyc')->controller(AdminKycController::class)->group(function () {
        Route::get('/', 'index')->name('admin.kyc');
        Route::get('/{id}', 'show')->name('admin.kyc.show');
        Route::post('/{id}/approve', 'approve')->name('admin.kyc.approve');
        Route::post('/{id}/reject', 'reject')->name('admin.kyc.reject');
    });


    // admin support
    Route::controller(AdminSupportController::class)->group(function () {

        Route::get('/support/tickets', 'support')->name('admin.support.tickets');
        // View ticket
        Route::get('/ticket/view/{reference_id}', 'viewTicket')->name('admin.ticket.view');

        // Add message
        Route::post('/ticket/{reference_id}/message', 'addMessage')->name('admin.ticket.message');
        // Close ticket
        Route::post('/ticket/{reference_id}/close', 'closeTicket')->name('admin.ticket.close');
    });
});
