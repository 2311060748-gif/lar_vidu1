<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\GHNController;
use App\Http\Controllers\User\MomoController;
use App\Http\Controllers\User\ChatController as UserChatController;
use App\Http\Controllers\Admin\ChatController as AdminChatController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\MovieBookingController;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| Form Đặt Vé Xem Phim (Movie Ticket Booking Form)
|--------------------------------------------------------------------------
*/
Route::get('/movie-booking', [MovieBookingController::class, 'showForm'])->name('movie.booking');
Route::post('/movie-booking', [MovieBookingController::class, 'processBooking'])->name('movie.booking.submit');
Route::get('/dat-ve', [MovieBookingController::class, 'showForm']);
Route::post('/dat-ve', [MovieBookingController::class, 'processBooking']);

/*
|--------------------------------------------------------------------------
| Xac thuc (Authentication)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/email/verify', [AuthController::class, 'showVerifyCode'])->middleware('auth')->name('verification.notice');
Route::post('/email/verify-code', [AuthController::class, 'verifyCode'])->middleware('auth')->name('verification.verify_code');
Route::post('/email/resend-code', [AuthController::class, 'resendCode'])->middleware(['auth', 'throttle:6,1'])->name('verification.resend_code');
Route::post('/email/verification-notification', [AuthController::class, 'resendCode'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect()->route(Auth::user()->role . '.dashboard')->with('success', 'Email đã được xác minh thành công.');
})->middleware(['auth', 'signed', 'throttle:6,1'])->name('verification.verify');

/*
|--------------------------------------------------------------------------
| Dashboard khach hang
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:customer'])->group(function () {
    Route::get('/customer/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
});

/*
|--------------------------------------------------------------------------
| Dashboard admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Product CRUD
    Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
});

/*
|--------------------------------------------------------------------------
| Trang chu
|--------------------------------------------------------------------------
*/

Route::get('/', function (Request $request) {

    // Danh muc
    $categories = [
        [
            'slug' => 'all',
            'name' => 'Tất cả phụ kiện',
            'icon' => 'fa-solid fa-list'
        ],
        [
            'slug' => 'ma-phanh',
            'name' => 'Má phanh / Đĩa',
            'icon' => 'fa-solid fa-circle-stop'
        ],
        [
            'slug' => 'loc-gio',
            'name' => 'Lọc gió / Bugi',
            'icon' => 'fa-solid fa-bolt'
        ],
        [
            'slug' => 'nhong-sen-dia',
            'name' => 'Nhông sên dĩa',
            'icon' => 'fa-solid fa-gear'
        ],
        [
            'slug' => 'den-xe',
            'name' => 'Đèn & Xi-nhan',
            'icon' => 'fa-solid fa-lightbulb'
        ],
        [
            'slug' => 'guong-bao-tay',
            'name' => 'Gương / Bao tay',
            'icon' => 'fa-solid fa-hand'
        ],
    ];

    // San pham mac dinh voi anh luu cuc bo
    $defaultProducts = [
        [
            'id' => 1,
            'code' => '06430-KVB-305',
            'name' => 'Bộ má phanh trước Air Blade 125',
            'price' => 120000,
            'category' => 'ma-phanh',
            'image' => asset('images/products/phanh-airblade.jpg')
        ],
        [
            'id' => 2,
            'code' => '17210-KVB-900',
            'name' => 'Lọc gió Wave RSX / Vision',
            'price' => 75000,
            'category' => 'loc-gio',
            'image' => asset('images/products/loc-gio-wave.jpg')
        ],
        [
            'id' => 3,
            'code' => '98069-56741',
            'name' => 'Bugi NGK CPR6EA-9 Chân Dài',
            'price' => 45000,
            'category' => 'loc-gio',
            'image' => asset('images/products/bugi-ngk.jpg')
        ],
        [
            'id' => 4,
            'code' => '06405-KYZ-901',
            'name' => 'Bộ nhông sên dĩa DID Future 125',
            'price' => 310000,
            'category' => 'nhong-sen-dia',
            'image' => asset('images/products/nhong-sen-dia.jpg')
        ],
        [
            'id' => 5,
            'code' => '33100-K1Z-J11',
            'name' => 'Cụm đèn pha LED Honda',
            'price' => 650000,
            'category' => 'den-xe',
            'image' => asset('images/products/den-pha-led.jpg')
        ],
        [
            'id' => 6,
            'code' => '88110-K97-T01',
            'name' => 'Gương chiếu hậu thời trang',
            'price' => 180000,
            'category' => 'guong-bao-tay',
            'image' => asset('images/products/guong-chieu-hau.jpg')
        ],
    ];

    // Lay san pham tu session
    $allProducts = session('products', $defaultProducts);

    // Tu dong sua link anh bi hong va cap nhat ten tieng Viet co dau trong session
    $mapImages = [
        '06430-KVB-305' => asset('images/products/phanh-airblade.jpg'),
        '17210-KVB-900' => asset('images/products/loc-gio-wave.jpg'),
        '98069-56741' => asset('images/products/bugi-ngk.jpg'),
        '06405-KYZ-901' => asset('images/products/nhong-sen-dia.jpg'),
        '33100-K1Z-J11' => asset('images/products/den-pha-led.jpg'),
        '88110-K97-T01' => asset('images/products/guong-chieu-hau.jpg'),
    ];

    $mapNames = [
        '06430-KVB-305' => 'Bộ má phanh trước Air Blade 125',
        '17210-KVB-900' => 'Lọc gió Wave RSX / Vision',
        '98069-56741' => 'Bugi NGK CPR6EA-9 Chân Dài',
        '06405-KYZ-901' => 'Bộ nhông sên dĩa DID Future 125',
        '33100-K1Z-J11' => 'Cụm đèn pha LED Honda',
        '88110-K97-T01' => 'Gương chiếu hậu thời trang',
    ];

    $hasUpdate = false;
    foreach ($allProducts as &$p) {
        if (isset($p['code'])) {
            if (isset($mapImages[$p['code']]) && (empty($p['image']) || str_contains($p['image'], 'unsplash.com') || str_contains($p['image'], '1486006920555'))) {
                $p['image'] = $mapImages[$p['code']];
                $hasUpdate = true;
            }
            if (isset($mapNames[$p['code']]) && (!isset($p['name']) || str_starts_with($p['name'], 'Bo ') || str_starts_with($p['name'], 'Loc ') || str_starts_with($p['name'], 'Cum ') || str_starts_with($p['name'], 'Guong '))) {
                $p['name'] = $mapNames[$p['code']];
                $hasUpdate = true;
            }
        }
    }
    unset($p);
    if ($hasUpdate) {
        session(['products' => $allProducts]);
    }

    // Loc danh muc
    $selectedCategory = $request->query('category', 'all');

    if ($selectedCategory !== 'all') {
        $products = array_values(
            array_filter(
                $allProducts,
                function ($product) use ($selectedCategory) {
                    return isset($product['category'])
                        && $product['category'] === $selectedCategory;
                }
            )
        );
    } else {
        $products = $allProducts;
    }

    // Xu ly tim kiem theo tu khoa
    $searchQuery = trim($request->query('search', $request->query('q', '')));
    if (!empty($searchQuery)) {
        // Neu co tim kiem, tim tren toan bo san pham
        $targetProducts = ($selectedCategory === 'all') ? $products : $allProducts;
        $normSearch = \Illuminate\Support\Str::slug($searchQuery, ' ');

        $products = array_values(
            array_filter(
                $targetProducts,
                function ($p) use ($searchQuery, $normSearch) {
                    $pName = $p['name'] ?? '';
                    $pCode = $p['code'] ?? '';
                    $pNameNorm = \Illuminate\Support\Str::slug($pName, ' ');
                    $pCodeNorm = \Illuminate\Support\Str::slug($pCode, ' ');

                    return mb_stripos($pName, $searchQuery) !== false
                        || mb_stripos($pCode, $searchQuery) !== false
                        || str_contains($pNameNorm, $normSearch)
                        || str_contains($pCodeNorm, $normSearch);
                }
            )
        );
    }

    // Tra ve view
    return view(
        'welcome',
        compact(
            'categories',
            'products',
            'selectedCategory',
            'searchQuery'
        )
    );

})->name('home');


/*
|--------------------------------------------------------------------------
| Upload san pham (Chi admin)
|--------------------------------------------------------------------------
*/

Route::post('/upload-product', function (Request $request) {

    // Validate
    $request->validate([
        'code' => 'required|string|max:100',
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'category' => 'required|string',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Tao thu muc uploads
    $uploadPath = public_path('uploads');

    if (!is_dir($uploadPath)) {
        mkdir($uploadPath, 0777, true);
    }

    // Upload anh
    $imageUrl = '';

    if ($request->hasFile('image')) {

        $image = $request->file('image');

        $imageName =
            time() .
            '_' .
            uniqid() .
            '.' .
            $image->getClientOriginalExtension();

        $image->move(
            $uploadPath,
            $imageName
        );

        $imageUrl = asset(
            'uploads/' . $imageName
        );
    }

    // Lay danh sach hien tai
    $products = session('products', []);

    // Neu session chua co san pham
    if (empty($products)) {

        $products = [
            [
                'code' => '06430-KVB-305',
                'name' => 'Bo may phanh truoc Air Blade 125',
                'price' => 120000,
                'category' => 'ma-phanh',
                'image' => 'https://images.unsplash.com/photo-1558981806-ec527fa84c39?w=600'
            ],
            [
                'code' => '17210-KVB-900',
                'name' => 'Loc gio Wave RSX / Vision',
                'price' => 75000,
                'category' => 'loc-gio',
                'image' => 'https://images.unsplash.com/photo-1568772585407-9361f9bf3a87?w=600'
            ],
            [
                'code' => '98069-56741',
                'name' => 'Bugi NGK CPR6EA-9 Chan Dai',
                'price' => 45000,
                'category' => 'loc-gio',
                'image' => 'https://images.unsplash.com/photo-1609630875171-b1321377ee65?w=600'
            ],
            [
                'code' => '06405-KYZ-901',
                'name' => 'Bo nhong sen dia DID Future 125',
                'price' => 310000,
                'category' => 'nhong-sen-dia',
                'image' => 'https://images.unsplash.com/photo-1486006920555-c77dce18193b?w=600'
            ],
        ];
    }

    // Them san pham moi len dau
    array_unshift($products, [
        'code' => $request->code,
        'name' => $request->name,
        'price' => (float) $request->price,
        'category' => $request->category,
        'image' => $imageUrl,
    ]);

    // Luu session
    session([
        'products' => $products
    ]);

    // Quay ve trang chu
    return redirect()
        ->route('home')
        ->with(
            'success',
            'Upload san pham moi thanh cong!'
        );

})->middleware(['auth', 'role:admin'])->name('product.upload');

/*
|--------------------------------------------------------------------------
| Giỏ hàng (Cart)
|--------------------------------------------------------------------------
*/
Route::get('/cart', function () {
    $cart = session('cart', []);
    $totalPrice = collect($cart)->sum(fn($item) => ($item['price'] ?? 0) * ($item['quantity'] ?? 1));
    return view('cart.index', compact('cart', 'totalPrice'));
})->name('cart.index');

Route::get('/user/cart', function () {
    return redirect()->route('cart.index');
})->name('user.cart.index');

Route::post('/cart/add', function (Request $request) {
    $request->validate([
        'product_id' => 'required',
        'quantity' => 'nullable|integer|min:1',
    ]);

    $productId = $request->product_id;
    $quantity = (int) ($request->quantity ?? 1);

    $product = Product::find($productId);
    $cart = session('cart', []);

    if ($product) {
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'quantity' => $quantity,
                'weight' => (int) ($product->weight ?? 200),
                'image' => $product->image ?? '',
            ];
        }
    } else {
        // Fallback session sample products
        $defaultName = $request->name ?? 'Sản phẩm ' . $productId;
        $defaultPrice = (float) ($request->price ?? 100000);
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'id' => $productId,
                'name' => $defaultName,
                'price' => $defaultPrice,
                'quantity' => $quantity,
                'weight' => 200,
                'image' => '',
            ];
        }
    }

    session(['cart' => $cart]);

    if ($request->wantsJson()) {
        return response()->json(['success' => true, 'cart_count' => count($cart)]);
    }

    return redirect()->route('cart.index')->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
})->name('cart.add');

Route::post('/cart/update', function (Request $request) {
    $cart = session('cart', []);
    if ($request->has('quantities') && is_array($request->quantities)) {
        foreach ($request->quantities as $id => $qty) {
            if (isset($cart[$id])) {
                $qty = (int) $qty;
                if ($qty <= 0) {
                    unset($cart[$id]);
                } else {
                    $cart[$id]['quantity'] = $qty;
                }
            }
        }
        session(['cart' => $cart]);
    }
    return back()->with('success', 'Đã cập nhật giỏ hàng!');
})->name('cart.update');

Route::delete('/cart/remove/{id}', function ($id) {
    $cart = session('cart', []);
    if (isset($cart[$id])) {
        unset($cart[$id]);
        session(['cart' => $cart]);
    }
    return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
})->name('cart.remove');

Route::post('/cart/sync', function (Request $request) {
    $items = $request->input('cart', []);
    $cart = [];
    foreach ($items as $idx => $item) {
        $id = $item['id'] ?? ($idx + 1);
        $cart[$id] = [
            'id' => $id,
            'name' => $item['name'] ?? 'Sản phẩm ' . $id,
            'price' => (float) ($item['price'] ?? 0),
            'quantity' => (int) ($item['quantity'] ?? 1),
            'weight' => (int) ($item['weight'] ?? 200),
            'image' => $item['image'] ?? '',
        ];
    }
    session(['cart' => $cart]);
    return response()->json(['success' => true]);
})->name('cart.sync');

/*
|--------------------------------------------------------------------------
| Lab 05 - Shipping (GHN) & Payment (COD, MoMo)
|--------------------------------------------------------------------------
*/

// Third-party webhooks & callbacks (GHN, MoMo IPN)
Route::post('/ghn/webhook', function () {
    return response()->json(['code' => 200, 'message' => 'GHN webhook received']);
})->name('ghn.webhook');

Route::post('/payment/momo/ipn', [MomoController::class, 'ipn'])->name('payment.momo.ipn');
Route::get('/payment/momo/callback', [MomoController::class, 'callback'])->name('user.payment.momo.callback');

// Payment & Orders
Route::middleware(['auth'])->group(function () {
    Route::get('/payment', [OrderController::class, 'index'])->name('payment.index');
    Route::post('/payment/process', [OrderController::class, 'processPayment'])->name('payment.process');

    // Orders
    Route::get('/orders', [OrderController::class, 'orderHistory'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    // MoMo payment
    Route::get('/orders/{order}/start-momo', [MomoController::class, 'start'])->name('orders.momo.start');
    Route::get('/orders/{order}/pay/momo', [MomoController::class, 'payAgain'])->name('orders.momo.pay');
    Route::get('/orders/{order}/momo-atm', [MomoController::class, 'showMockAtm'])->name('user.payment.momo.mock_atm');
    Route::post('/orders/{order}/momo-atm', [MomoController::class, 'processMockAtm'])->name('user.payment.momo.mock_atm.process');
});

// User prefixed route aliases
Route::name('user.')->middleware(['auth'])->group(function () {
    Route::get('/user/orders', [OrderController::class, 'orderHistory'])->name('orders.index');
    Route::get('/user/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/user/orders/{order}/start-momo', [MomoController::class, 'start'])->name('orders.momo.start');
    Route::get('/user/orders/{order}/pay/momo', [MomoController::class, 'payAgain'])->name('orders.momo.pay');
    Route::get('/user/payment', [OrderController::class, 'index'])->name('payment.index');
    Route::post('/user/payment/process', [OrderController::class, 'processPayment'])->name('payment.process');
});

// GHN Locations & Calculate Fee
Route::prefix('locations')->name('locations.')->group(function () {
    Route::get('/provinces', [GHNController::class, 'getProvinces'])->name('provinces');
    Route::get('/districts/{provinceId}', [GHNController::class, 'getDistricts'])->name('districts');
    Route::get('/wards/{districtId}', [GHNController::class, 'getWards'])->name('wards');
    Route::post('/calculate-fee', [GHNController::class, 'getShippingFee'])->name('fee');
});

/*
|--------------------------------------------------------------------------
| Chat - Tin nhắn (User & Admin)
|--------------------------------------------------------------------------
*/

// Với USER:
Route::middleware(['auth', 'verified'])->prefix('user')->name('user.')->group(function () {
    // User gửi tin
    Route::post('/chat/send', [UserChatController::class, 'send'])->name('chat.send');

    // User lấy tin (có thể lọc theo conversation sau này)
    Route::get('/chat/messages', [UserChatController::class, 'getMessages'])->name('chat.messages');
});

// Với ADMIN:
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Quản lý đơn hàng
    Route::post('/orders/bulk-status', [AdminOrderController::class, 'bulkUpdateStatus'])->name('orders.bulk_status');
    Route::resource('orders', AdminOrderController::class)->except(['create', 'store', 'destroy']);
    Route::match(['post', 'put', 'patch'], '/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update_status');
    Route::put('/orders/{order}', [AdminOrderController::class, 'updateStatus'])->name('orders.update');

    // Báo cáo doanh thu & biểu đồ
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/charts', [ReportController::class, 'charts'])->name('reports.charts');

    // Quản lý người dùng
    Route::resource('users', AdminUserController::class);

    // Lấy danh sách user đã chat
    Route::get('/chat/users', [AdminChatController::class, 'getUsers'])->name('chat.users');
    // Lấy tin nhắn theo từng user
    Route::get('/chat/messages/{userId}', [AdminChatController::class, 'getMessages'])->name('chat.messages');
    // Admin gửi tin nhắn
    Route::post('/chat/send', [AdminChatController::class, 'send'])->name('chat.send');
});

