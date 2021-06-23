<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;



//Login and Registration
Route::post("/register", 'App\Http\Controllers\LoginController@register');
Route::post("/login", 'App\Http\Controllers\LoginController@login');

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get("/user", 'App\Http\Controllers\LoginController@getUser');
    Route::post("/logOut", 'App\Http\Controllers\LoginController@logOut');
    Route::post("/check-admin", 'App\Http\Controllers\LoginController@cheackAdmin'); // this rout, if user check admin or user

});

//reset Password
Route::put("/AdminPasswordReset/{adminId}/{adminEmail}/{adminPassword}", 'App\Http\Controllers\resetPassword@adminResetPassword');
Route::put("/UserPasswordReset/{userId}/{userEmail}/{userPassword}", 'App\Http\Controllers\resetPassword@userResetPassword');



//Admin Api

//Bus management
Route::post("/BusRegister/{adminid}", 'App\Http\Controllers\bus_Management@CreateBus');
Route::put("/UpdateBus/{id}/{adminId}", 'App\Http\Controllers\bus_Management@updateBus');
Route::get('/viewAllBuses/{adminId}', 'App\Http\Controllers\bus_Management@viewAllBuses');
Route::get('/viewBus/{id}/{adminId}', 'App\Http\Controllers\bus_Management@viewBus');
Route::delete("/deleteBus/{id}/{adminId}", 'App\Http\Controllers\bus_Management@deleteBus');


//Seats managemant
Route::post("/CreateBusSeats/{adminId}/{busid}", 'App\Http\Controllers\bus_seats_management@CreateBusSeats');
Route::put("/updateSeat/{seatId}/{adminId}/{busid}", 'App\Http\Controllers\bus_seats_management@updateSeat');
Route::get('/viewAllSeates/{adminId}', 'App\Http\Controllers\bus_seats_management@viewAllSeates');
Route::get('/viewSeat/{seatId}/{adminId}', 'App\Http\Controllers\bus_seats_management@viewSeat');
Route::delete("/deleteSeate/{seatId}/{adminId}", 'App\Http\Controllers\bus_seats_management@deleteSeate');



////Booking management
//Route::post("/setBooking", 'App\Http\Controllers\my_booking@CreateBooking');
//Route::put("/updateBooking/{id}", 'App\Http\Controllers\my_booking@updateBooking');
//Route::get('/viewAllMyBooking', 'App\Http\Controllers\my_booking@viewAllMyBooking');
//Route::get('/viewBooking/{id}', 'App\Http\Controllers\my_booking@viewBooking');
//Route::delete("/cancelBooking/{id}", 'App\Http\Controllers\my_booking@deleteBooking');


//routes managemant
Route::post("/CreateRoute/{adminId}", 'App\Http\Controllers\route_management@CreateRoute');
Route::put("/updateRoute/{routeId}/{adminId}", 'App\Http\Controllers\route_management@updateRoute');
Route::get('/viewAllRoute/{adminId}', 'App\Http\Controllers\route_management@viewAllRoute');
Route::get('/viewRoute/{id}/{adminId}', 'App\Http\Controllers\route_management@viewRoute');
Route::delete("/deleteRoute/{id}/{adminId}", 'App\Http\Controllers\route_management@deleteRoute');


//route bus mapping
Route::post("/CreateBusMapping/{adminId}/{busid}/{routeid}", 'App\Http\Controllers\route_bus_mapping@CreateBusMapping');
Route::put("/updateBusMapping/{busMapingId}/{adminId}/{busid}/{routeid}", 'App\Http\Controllers\route_bus_mapping@updateBusMapping');
Route::get('/viewAllBusMapping/{adminId}', 'App\Http\Controllers\route_bus_mapping@viewAllBusMapping');
Route::get('/viewBusMapping/{id}/{adminId}', 'App\Http\Controllers\route_bus_mapping@viewBusMapping');
Route::delete("/deleteBusMapping/{id}/{adminId}", 'App\Http\Controllers\route_bus_mapping@deleteBusMapping');



//bus_schedules managemant
Route::post("/CreateSchedule/{adminId}/{busRoutid}", 'App\Http\Controllers\schedule_management@CreateSchedule');
Route::put("/updateSchedule/{id}/{adminId}/{busRoutid}", 'App\Http\Controllers\schedule_management@updateSchedule');
Route::get('/viewAllSchedule/{adminId}', 'App\Http\Controllers\schedule_management@viewAllSchedule');
Route::get('/viewSchedule/{id}/{adminId}', 'App\Http\Controllers\schedule_management@viewSchedule');
Route::delete("/deleteSchedule/{id}/{adminId}", 'App\Http\Controllers\schedule_management@deleteSchedule');


//User Api

//book schedule
Route::post("/BookSchedule/{userId}/{busSeatId}/{busSchedulId}", 'App\Http\Controllers\book_schedule@busScheduleBooking');

//my_booking
Route::get('/ViewAllMyBooking/{userId}', 'App\Http\Controllers\my_booking@viewAllMyBooking');

//bus_shedule_list
Route::get('/viewScheduleList', 'App\Http\Controllers\bus_shedule_list@viewScheduleList');

//cancel bookings
Route::put("/bookingCancel/{id}/{userid}", 'App\Http\Controllers\cancel_bookings@bookingCancel');






