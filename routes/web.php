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

Route::get('/', function () {
    return view('welcome');
});

// Home Page
Route::get('/home', 'HomeController@index')->name('home');

// Login/Logout Functionality
Route::get('/login', 'LoginController@index')->name('login');

Route::post('/login', 'LoginController@create')->name('login-create');

Route::post('/logout', 'LoginController@logout')->name('logout');

// Register Functionality (As of 10/26/2023, needs to add info for client information)
Route::get('/register', 'RegisterController@index')->name('register');

Route::post('/register', 'RegisterController@create')->name('register-create');

// Displays the catalogue of Genres available, available to everyone, but some buttons and accesses depend on user type
Route::get('/catalogue', 'GenreController@index')->name('genre');

// Handles the search functionality of the Genres catalogue
Route::post('/catalogue/search', 'GenreController@search')->name('genre-search');

// Catalogue sub-pages are admin exclusive
Route::get('/catalogue/create', 'GenreController@create')->name('genre-create');
Route::post('/catalogue', 'GenreController@store')->name('genre-store');

Route::get('/catalogue/edit/{genre}', 'GenreController@edit')->name('genre-edit');
Route::post('/catalogue/update', 'GenreController@update')->name('genre-update');

Route::get('/catalogue/{genre}', 'GenreController@show')->name('genre-show');

//Route::get('/catalogue/destroy/{genre}', 'GenreController@destroy')->name('genre-destroy');



// Multiple versions of pages would be displayed. If a client is logged in, display only their subscriptions,
// If an admin is logged in, display all subscriptions, as well as clients associated.
Route::get('/subscriptions', 'SubscriptionController@index')->name('subscription');

// Handles the search functionality of the subscription catalogue
Route::post('/subscriptions/search', 'SubscriptionController@search')->name('subscription-search');

// Page used when a client clicks a button to make a new subscription from catalogue
Route::get('/subscriptions/create/{genre}', 'SubscriptionController@create')->name('subscription-create');
Route::post('/subscriptions', 'SubscriptionController@store')->name('subscription-store');

// Pages used exclusively by admin
Route::get('/subscriptions/edit/{subscription}', 'SubscriptionController@edit')->name('subscription-edit');
Route::post('/subscriptions/update', 'SubscriptionController@update')->name('subscription-update');

Route::get('/subscriptions/{subscription}', 'SubscriptionController@show')->name('subscription-show');

//Route::get('/subscriptions/destroy/{subscription}', 'SubscriptionController@destroy')->name('subscription-destroy');


// All user and Client listings will be completed through the ClientController as the majority of information is very directly linked
// Displays catalogue of users, admin and employee exclusive.
Route::get('/users', 'ClientController@index')->name('user');

// Handles the search functionality of the user catalogue
Route::post('/users/search', 'ClientController@search')->name('user-search');

// Page is admin exclusive, allows them to make new employee and admin accounts
Route::get('/users/create', 'ClientController@create')->name('user-create');
Route::post('/users', 'ClientController@store')->name('user-store');

// Admin exlusive, allows admin to update user accounts data. May display client information for updating if account is a clients
Route::get('/users/edit/{user}', 'ClientController@edit')->name('user-edit');
Route::post('/users/update', 'ClientController@update')->name('user-update');

Route::get('/users/{user}', 'ClientController@show')->name('user');

// Destroys an account, make several protocols with warnings, and cascade the destruction. 
// Admin exlusive, likely not necessary for sake of back tracking data. (Wait to develop for further info)
//Route::get('/users/destroy/{user}', 'UsersController@destroy')->name('user-destroy');

// Displays a client their own account information
Route::get('/account', 'ClientController@index')->name('client');
// All other account details should be listed in the User catalogue for admins and employees



// Displays catalogue of products
Route::get('/products', 'ProductController@index')->name('product');
Route::get('/products/create', 'ProductController@create')->name('product-create');

// Handles the search functionality of the products catalogue
Route::post('/products/search', 'ProductController@search')->name('product-search');

// Allows admins to create new products
Route::get('/products/{product}', 'ProductController@show')->name('product-show');
Route::post('/products', 'ProductController@store')->name('product-store');

// Allows admins to update product information
Route::get('/products/edit/{product}', 'ProductController@edit')->name('product-edit');
Route::post('/products/update', 'ProductController@update')->name('product-update');

// Allows admins to destroy product information. Make several protocols with warnings, 
// and cascade the destruction. Admin exlusive, likely not necessary for sake of back tracking data. (Wait to develop for further info)
//Route::get('/products/destroy/{product}', 'ProductController@destroy')->name('product-destroy');

//Route::post('/products/destroy', 'ProductController@destroy');


// Admin and Employee Exlusive Displays catalogue of packages
Route::get('/packages', 'PackageController@index')->name('package');
Route::get('/packages/create', 'PackageController@create')->name('package-create');

// Handles the search functionality of the packages catalogue
Route::post('/packages/search', 'PackageController@search')->name('package-search');
Route::post('/packages/product/search', 'PackageController@search')->name('package-search');

// Allows admins to create new packages
Route::get('/packages/{package}', 'PackageController@show')->name('package-show');
Route::post('/packages', 'PackageController@store')->name('package-store');

// Allows admins to update package information
Route::get('/packages/edit/{package}', 'PackageController@edit')->name('package-edit');
Route::post('/packages/update', 'PackageController@update')->name('package-update');

// Allows admins to destroy package information. Make several protocols with warnings, 
// and cascade the destruction. Admin exlusive, likely not necessary for sake of back tracking data. (Wait to develop for further info)
//Route::get('/packages/destroy/{product}', 'PackageController@destroy')->name('package-destroy');

// Make more routes for shipments, package items (Which I believe will be tied into the packages somewhat), shipment items (Same but with shipments), and sent packages
// Admin and Employee Exlusive Displays catalogue of shipment
Route::get('/shipments', 'ShipmentController@index')->name('shipment');

// Handles the search functionality of the shipment catalogue
Route::post('/shipments/search', 'ShipmentController@search')->name('shipment-search');

// Allows admins to create new shipment
Route::get('/shipments/create', 'ShipmentController@create')->name('shipment-create');
Route::post('/shipments', 'ShipmentController@store')->name('shipment-store');

// Allows admins to update shipment information
Route::get('/shipments/edit/{shipment}', 'ShipmentController@edit')->name('shipment-edit');
Route::post('/shipments/update', 'ShipmentController@update')->name('shipment-update');

Route::get('/shipments/{shipment}', 'ShipmentController@show')->name('shipment-show');


// Admin and Employee Exlusive Displays catalogue of shipment
Route::get('/shipment-item', 'ShipmentItemController@index')->name('shipment-item');

// Handles the search functionality of the shipment catalogue
Route::post('/shipment-item/search', 'ShipmentItemController@search')->name('shipment-item-search');

// Allows admins to create new shipment
Route::get('/shipment-item/create/{shipment}', 'ShipmentItemController@create')->name('shipment-item-create');
Route::post('/shipment-item/create/{shipment}', 'ShipmentItemController@store')->name('shipment-item-store');

// Allows admins to update shipment information
Route::get('/shipment-item/edit/{package}', 'ShipmentItemController@edit')->name('shipment-item-edit');
Route::post('/shipment-item/update', 'ShipmentItemController@update')->name('shipment-item-update');



// Admin and Employee Exlusive Displays catalogue of shipment
Route::get('/packaged-item', 'PackagedItemController@index')->name('packaged_item');

// Handles the search functionality of the shipment catalogue
Route::post('/packaged-item/search', 'PackagedItemController@search')->name('packaged_item-search');

// Allows admins to create new shipment
Route::get('/packaged-item/create/{package}', 'PackagedItemController@create')->name('packaged_item-create');
Route::get('/packaged-item/assign/{product}', 'PackagedItemController@assign')->name('packaged_item-assign');
Route::post('/packaged-item', 'PackagedItemController@store')->name('packaged_item-store');

// Allows admins to update shipment information
Route::get('/packaged-item/edit/{package}', 'PackagedItemController@edit')->name('packaged_item-edit');
Route::post('/packaged-item/update', 'PackagedItemController@update')->name('packaged_item-update');

Route::get('/packaged-item/{packaged_item}', 'PackagedItemController@show')->name('packaged_item-show');
