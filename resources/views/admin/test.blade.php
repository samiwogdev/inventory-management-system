<?php 
// protected function checkReorderLevel()
//     {
//         // Retrieve all products that need restocking
//         $products = Product::where('quantity', '<=', 'reorderLevel')->get();
        
//         // Loop through the products and create notifications
//         foreach ($products as $product) {
//             $notification = new Notification();
//             $notification->user_id = Auth::guard('admin')->id(); // Correctly assigning user/admin ID
//             $notification->type = 'restock';
//             $notification->data = json_encode([
//                 'message' => "The product {$product->name} needs to be restocked.",
//                 'product_id' => $product->id,
//             ]);
//             $notification->read = false; // Mark the notification as unread
//             $notification->save();
//         }
//     }


// Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function () {

//     //Add middleware
//     Route::group(['middleware' => ['admin']], function () {

//         Route::get('/reports', 'ReportController@generateReport');
//         Route::get('/generateReport', 'ReportController@showGenerateReport');
//         Route::get('/ReportToCsv', 'ReportController@exportReportToCsv');


//     });
// });


// Could you generate a laravel test feature with the following routes, controller and models: