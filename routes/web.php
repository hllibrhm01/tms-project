<?php

use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

$router->get('/test', '\App\Http\Controllers\cms\UserController@test')->name('get.cms.user.index');

$router->get('/',  'cms\DashboardController@index')->middleware('auth');

Route::group(['namespace' => 'cms', 'prefix' => 'cms', 'middleware' => ['auth', 'role:Super Admin|Admin']], function () use ($router) {

    $router->get('/',  'DashboardController@index')->name('get.dashboard');

    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->get('/', 'UserController@index')->name('get.cms.user.index');
        $router->get('/add',  'UserController@add')->name('get.cms.user.add');
        $router->post('/add',  'UserController@store')->name('post.cms.user.add');
        $router->get('/edit/{id}',  'UserController@edit')->name('get.cms.user.edit');
        $router->get('/view/{id}',  'UserController@view')->name('get.cms.user.view');
        $router->post('/edit/{id}',  'UserController@update')->name('post.cms.user.update');
        $router->get('/delete/{id}',  'UserController@delete')->name('get.cms.user.delete');
    });

    $router->group(['prefix' => 'country'], function () use ($router) {
        $router->get('/',  'CountryController@index')->name('get.cms.country.index');
        $router->get('/add',  'CountryController@add')->name('get.cms.country.add');
        $router->post('/add',  'CountryController@store')->name('post.cms.country.add');
        $router->get('/edit/{id}',  'CountryController@edit')->name('get.cms.country.edit');
        $router->post('/edit/{id}',  'CountryController@update')->name('post.cms.country.update');
        $router->get('/delete/{id}',  'CountryController@destroy')->name('get.cms.country.delete');
    });

    $router->group(['prefix' => 'general-settings'], function () use ($router) {
        $router->get('/',  'GeneralSettingController@index')->name('get.cms.general.settings');
        $router->post('/update',  'GeneralSettingController@update')->name('post.cms.general.settings.update');
    });

    $router->group(['prefix' => 'city'], function () use ($router) {
        $router->get('/{countryId}',  'CityController@index')->name('get.cms.city.index');
        $router->get('/add/{countryId}',  'CityController@add')->name('get.cms.city.add');
        $router->post('/add',  'CityController@store')->name('post.cms.city.add');
        $router->get('/edit/{id}',  'CityController@edit')->name('get.cms.city.edit');
        $router->post('/edit/{id}',  'CityController@update')->name('post.cms.city.update');
        $router->get('/delete/{id}',  'CityController@destroy')->name('get.cms.city.delete');
        $router->post('/cities', 'CityController@getCityName')->name('post.cms.city.cities');
    });

    $router->group(['prefix' => 'district'], function () use ($router) {
        $router->post('/district', 'DistrictController@getDistrictName')->name('post.cms.district');
    });

    $router->group(['prefix' => 'role'], function () use ($router) {
        $router->get('/',  'RoleController@index')->name('get.cms.role.index');
        $router->get('/add',  'RoleController@add')->name('get.cms.role.add');
        $router->post('/add',  'RoleController@store')->name('post.cms.role.add');
        $router->get('/edit/{id}',  'RoleController@edit')->name('get.cms.role.edit');
        $router->post('/edit/{id}',  'RoleController@update')->name('post.cms.role.update');
        $router->get('/delete/{id}',  'RoleController@delete')->name('get.cms.role.delete');
    });

    $router->group(['prefix' => 'permission'], function () use ($router) {
        $router->get('/',  'PermissionController@index')->name('get.cms.permission.index');
        $router->get('/add',  'PermissionController@add')->name('get.cms.permission.add');
        $router->post('/add',  'PermissionController@store')->name('post.cms.permission.add');
        $router->get('/edit/{id}',  'PermissionController@edit')->name('get.cms.permission.edit');
        $router->post('/edit/{id}',  'PermissionController@update')->name('post.cms.permission.update');
        $router->get('/delete/{id}',  'PermissionController@delete')->name('get.cms.permission.delete');
    });
});

Route::group(['namespace' => 'crm', 'prefix' => 'crm', 'middleware' => ['auth']], function () use ($router) {
    $router->get('/insufficent',  [DashboardController::class, 'insufficent'])->name('get.crm.insufficent');

    $router->group(['prefix' => 'customer'], function () use ($router) {
        $router->get('/',  'CustomerController@index')->name('get.crm.customer.index');
        $router->get('/add',  'CustomerController@add')->name('get.crm.customer.add');
        $router->post('/add',  'CustomerController@store')->name('post.crm.customer.add');
        $router->get('/get/{id}',  'CustomerController@show')->name('get.crm.customer.show');
        $router->post('/edit/{id}',  'CustomerController@update')->name('post.crm.customer.update');
        $router->get('/delete/{id}',  'CustomerController@delete')->name('get.crm.customer.delete');
        $router->get('/search',  'CustomerController@search')->name('get.crm.customer.search');
        $router->get('/export',  'CustomerController@export')->name('get.crm.customer.export');
        $router->get('/update/responsiblity',  'CustomerController@updateResponsiblePerson')->name('get.crm.update.responsiblity')->middleware('role:Super Admin');
    });

    $router->group(['prefix' => 'assignment'], function () use ($router) {
        $router->get('/', 'AssignmentController@index')->name('get.crm.assignment.index');
        $router->get('/add',  'AssignmentController@add')->name('get.crm.assignment.add');
        $router->post('/add',  'AssignmentController@store')->name('post.crm.assignment.add');
        $router->get('/get/{id}',  'AssignmentController@show')->name('get.crm.assignment.show');
        $router->get('/edit/{id}',  'AssignmentController@edit')->name('get.crm.assignment.edit');
        $router->post('/edit/{id}',  'AssignmentController@update')->name('post.crm.assignment.update');
        $router->get('/delete/{id}',  'AssignmentController@delete')->name('get.crm.assignment.delete');
        $router->get('/search',  'AssignmentController@search')->name('get.crm.assignment.search');
    });

    $router->group(['prefix' => 'reminder'], function () use ($router) {
        $router->post('/add', 'ReminderController@store')->name('post.crm.reminder.add');
        $router->get('/edit', 'ReminderController@edit')->name('get.crm.reminder.edit');
        $router->post('/edit', 'ReminderController@update')->name('post.crm.reminder.update');
        $router->get('/delete',  'ReminderController@delete')->name('get.crm.reminder.delete');
    });

    $router->group(['prefix' => 'paper'], function () use ($router) {
        $router->post('/add', 'PaperController@store')->name('post.crm.paper.add');
        $router->get('/edit', 'PaperController@edit')->name('get.crm.paper.edit');
        $router->post('/edit',  'PaperController@update')->name('post.crm.paper.update');
        $router->get('/delete', 'PaperController@delete')->name('get.crm.paper.delete');
    });

    $router->group(['prefix' => 'meeting'], function () use ($router) {
        $router->post('/add', 'MeetingController@store')->name('post.crm.meeting.add');
        $router->get('/edit', 'MeetingController@edit')->name('get.crm.meeting.edit');
        $router->post('/edit', 'MeetingController@update')->name('post.crm.meeting.edit');
        $router->get('/delete', 'MeetingController@delete')->name('get.crm.meeting.delete');

        $router->group(['prefix' => 'note'], function () use ($router) {
            $router->post('/add',  'MeetingNoteController@store')->name('post.crm.meeting.note.add');
            $router->get('/edit',  'MeetingNoteController@edit')->name('get.crm.meeting.note.edit');
            $router->post('/edit',  'MeetingNoteController@update')->name('post.crm.meeting.note.update');
            $router->get('/delete',  'MeetingNoteController@delete')->name('get.crm.meeting.note.delete');
        });
    });


    $router->group(['prefix' => 'email'], function () use ($router) {
        $router->group(['prefix' => 'templates',  'middleware' => ["can:Email Şablon İşlemleri"]], function () use ($router) {
            $router->get('/', 'EmailTemplateController@index')->name('get.crm.email.templates.index');
            $router->get('/add', 'EmailTemplateController@add')->name('get.crm.email.templates.add');
            $router->post('/add',  'EmailTemplateController@store')->name('post.crm.email.templates.add');
            $router->get('/edit/{id}', 'EmailTemplateController@edit')->name('get.crm.email.templates.edit');
            $router->post('/edit/{id}', 'EmailTemplateController@update')->name('post.crm.email.templates.update');
            $router->get('/delete/{id}', 'EmailTemplateController@delete')->name('get.crm.email.templates.delete');
        });

        $router->post('customer/sent', 'EmailController@sentCustomerMail')->name('post.crm.customer.email.sent')->middleware(['can:Müşteri İşlemleri', 'throttle:limited-email']);
        $router->post('assignment/sent', 'EmailController@sentAssignmentMail')->name('post.crm.assignment.email.sent')->middleware(['can:Atama İşlemleri', 'throttle:limited-email']);

        $router->group([], function () use ($router) {
            $router->get('multi/sent', 'EmailController@multiMail')->name('get.crm.multi.mail.send');
            $router->post('multi/sent', 'EmailController@sendMultiMail')->name('post.crm.multi.mail.send');
        });
    });

    $router->group(['prefix' => 'excel'], function () use ($router) {
        $router->get('/export-customer', 'ExcelController@exportCustomer')->name('get.crm.excel.export.customer');
        $router->get('/export-assignment', 'ExcelController@exportAssignment')->name('get.crm.excel.export.assignment');
        $router->get('/import-excel',  'ExcelController@importExcel')->name('get.crm.import.excel');
        $router->post('/import/customer',   'ExcelController@importCustomerExcel')->name('post.crm.excel.import.customer');
        $router->post('/import/assignment',   'ExcelController@importAssignmentExcel')->name('post.crm.excel.import.assignment');
        $router->post('/import/customer-mail',   'ExcelController@importCustomerMail')->name('post.crm.excel.import.customer.mail');
        $router->post('/import/assignment-mail',   'ExcelController@importAssignmentMail')->name('post.crm.excel.import.assignment.mail');
        $router->post('/import/customer-paper',   'ExcelController@importCustomerPaper')->name('post.crm.excel.import.customer.paper');
        $router->post('/import/customer-reminder',   'ExcelController@importCustomerReminder')->name('post.crm.excel.import.customer.reminder');
        $router->post('/import/meeting',   'ExcelController@importMeeting')->name('post.crm.excel.import.meeting');
        $router->post('/import/meeting-notes',   'ExcelController@importMeetingNote')->name('post.crm.excel.import.meeting.notes');
        $router->post('/import/email-templates',   'ExcelController@importEmailTemplate')->name('post.crm.excel.import.email.templates');
    });
});

Route::group(['namespace' => 'tms', 'prefix' => 'tms', 'middleware' => ['auth', 'role:Super Admin|Admin|Planner|Dealer']], function () use ($router) {

    $router->group(['prefix' => 'vehicle', 'middleware' => ['auth', 'role:Super Admin|Admin|Planner']], function () use ($router) {
        $router->get('/', 'VehicleController@index')->name('get.tms.vehicle.index');
        $router->get('/expense', 'VehicleController@expense')->name('get.tms.vehicle.expense');
        $router->get('/view/{id}', 'VehicleController@show')->name('get.tms.vehicle.view');
        $router->get('/add', 'VehicleController@add')->name('get.tms.vehicle.add');
        $router->post('/add',  'VehicleController@store')->name('post.tms.vehicle.add');
        $router->get('/edit/{id}', 'VehicleController@edit')->name('get.tms.vehicle.edit');
        $router->post('/edit/{id}', 'VehicleController@update')->name('post.tms.vehicle.edit');
        $router->get('/delete/{id}',  'VehicleController@delete')->name('get.tms.vehicle.delete');
        $router->get('/search',  'VehicleController@search')->name('get.tms.vehicle.search');
        $router->post('/services', 'VehicleController@getServiceName')->name('post.tms.vehicle.services');

        $router->get('/plan/make/{vehicleId}',  'VehicleController@makePlan')->name('get.tms.vehicle.plan.make');
        $router->get('/plan/make',  'VehicleController@getVehiclePlanByDate')->name('get.tms.vehicle.plan.vehicle.make');
        $router->get('/plan/completed',  'VehicleController@completed')->name('get.tms.vehicle.plan.completed');
        $router->post('/plan/update',  'VehicleController@updatePlan')->name('post.tms.vehicle.plan.update');
        $router->get('/plan/delete/{planId}',  'VehicleController@deletePlan')->name('get.tms.vehicle.plan.delete');
        $router->get('/plan/search',  'VehicleController@search')->name('get.tms.vehicle.plan.search');

        $router->get('/plan/{vehicleId}',  'PlanController@vehicle')->name('get.tms.vehicle.plan.vehicle');
        $router->get('/plan/date',  'VehicleController@vehiclePlanByDate')->name('get.tms.vehicle.plan.vehicle.date');
        $router->get('/plan/{vehicleId}',  'VehicleController@planIndex')->name('get.tms.vehicle.plan.index');

        $router->group(['prefix' => 'service'], function () use ($router) {
            $router->get('/', 'VehicleServiceController@index')->name('get.tms.vehicle.service.index');
            $router->get('/view/{id}', 'VehicleServiceController@show')->name('get.tms.vehicle.service.view');
            $router->get('/add', 'VehicleServiceController@add')->name('get.tms.vehicle.service.add');
            $router->post('/add',  'VehicleServiceController@store')->name('post.tms.vehicle.service.add');
            $router->get('/edit/{id}', 'VehicleServiceController@edit')->name('get.tms.vehicle.service.edit');
            $router->post('/edit/{id}', 'VehicleServiceController@update')->name('post.tms.vehicle.service.edit');
            $router->get('/delete/{id}',  'VehicleServiceController@delete')->name('get.tms.vehicle.service.delete');
            $router->get('/search',  'VehicleServiceController@search')->name('get.tms.service.search');
        });

        $router->group(['prefix' => 'expense'], function () use ($router) {
            $router->get('/', 'VehicleExpenseController@index')->name('get.tms.vehicle.expense.index');
            $router->post('/update', 'VehicleExpenseController@update')->name('post.tms.vehicle.expense.view');
        });

        $router->group(['prefix' => 'supplier'], function () use ($router) {
            $router->get('/', 'VehicleSupplierController@index')->name('get.tms.vehicle.supplier.index');
            $router->get('/view/{id}', 'VehicleSupplierController@show')->name('get.tms.vehicle.supplier.view');
            $router->get('/add', 'VehicleSupplierController@add')->name('get.tms.vehicle.supplier.add');
            $router->post('/add',  'VehicleSupplierController@store')->name('post.tms.vehicle.supplier.add');
            $router->get('/edit/{id}', 'VehicleSupplierController@edit')->name('get.tms.vehicle.supplier.edit');
            $router->post('/edit/{id}', 'VehicleSupplierController@update')->name('post.tms.vehicle.supplier.edit');
            $router->get('/delete/{id}',  'VehicleSupplierController@delete')->name('get.tms.vehicle.supplier.delete');
            $router->get('/search',  'VehicleSupplierController@search')->name('get.tms.supplier.search');
        });

        $router->group(['prefix' => 'paper'], function () use ($router) {
            $router->post('/add', 'VehiclePaperController@store')->name('post.paper.add');
            $router->get('/edit',  'VehiclePaperController@edit')->name('get.paper.edit');
            $router->post('/edit',  'VehiclePaperController@update')->name('post.paper.update');
            $router->get('/delete',  'VehiclePaperController@delete')->name('get.paper.delete');
        });

        $router->group(['prefix' => 'equipment'], function () use ($router) {
            $router->post('/add', 'VehicleEquipmentController@store')->name('post.equipment.add');
            $router->get('/edit',  'VehicleEquipmentController@edit')->name('get.equipment.edit');
            $router->post('/edit', 'VehicleEquipmentController@update')->name('post.equipment.update');
            $router->get('/delete', 'VehicleEquipmentController@delete')->name('get.equipment.delete');
        });

        $router->group(['prefix' => 'inspection'], function () use ($router) {
            $router->post('/add', 'VehicleInspectionController@store')->name('post.inspection.add');
            $router->get('/edit',  'VehicleInspectionController@edit')->name('get.inspection.edit');
            $router->post('/edit', 'VehicleInspectionController@update')->name('post.inspection.update');
            $router->get('/delete', 'VehicleInspectionController@delete')->name('get.inspection.delete');
        });

        $router->group(['prefix' => 'hgs'], function () use ($router) {
            $router->post('/add', 'VehicleHGSController@store')->name('post.hgs.add');
            $router->get('/edit',  'VehicleHGSController@edit')->name('get.hgs.edit');
            $router->post('/edit', 'VehicleHGSController@update')->name('post.hgs.update');
            $router->get('/delete', 'VehicleHGSController@delete')->name('get.hgs.delete');
        });

        $router->group(['prefix' => 'maintain'], function () use ($router) {
            $router->post('/add', 'VehicleMaintainController@store')->name('post.maintain.add');
            $router->get('/edit',  'VehicleMaintainController@edit')->name('get.maintain.edit');
            $router->post('/edit', 'VehicleMaintainController@update')->name('post.maintain.update');
            $router->get('/delete', 'VehicleMaintainController@delete')->name('get.maintain.delete');
        });

        $router->group(['prefix' => 'income'], function () use ($router) {
            $router->post('/add', 'VehicleIncomeController@store')->name('post.income.add');
            $router->get('/edit',  'VehicleIncomeController@edit')->name('get.income.edit');
            $router->post('/edit', 'VehicleIncomeController@update')->name('post.income.update');
            $router->get('/delete', 'VehicleIncomeController@delete')->name('get.income.delete');
        });
    });

    $router->group(['prefix' => 'customer', 'middleware' => ['auth', 'role:Super Admin|Admin|Planner']], function () use ($router) {
        $router->get('/', 'CustomerController@index')->name('get.tms.customer.index');
        $router->post('/taxdepartments', 'CustomerController@getTaxDepartmentName')->name('post.tms.customer.taxdepartments');
        $router->get('/add', 'CustomerController@add')->name('get.tms.customer.add');
        $router->post('/add/', 'CustomerController@store')->name('post.tms.customer.add');
        $router->get('/view/{id}', 'CustomerController@show')->name('get.tms.customer.view');
        $router->get('/edit/{id}', 'CustomerController@edit')->name('get.tms.customer.edit');
        $router->post('/edit/{id}', 'CustomerController@update')->name('post.tms.customer.edit');
        $router->get('/delete/{id}', 'CustomerController@delete')->name('get.tms.customer.delete');
        $router->get('/search', 'CustomerController@search')->name('get.tms.customer.search');


        $router->group(['prefix' => 'income'], function () use ($router) {
            $router->post('/add', 'CustomerIncomeController@store')->name('post.customer.income.add');
            $router->get('/edit',  'CustomerIncomeController@edit')->name('get.customer.income.edit');
            $router->post('/edit', 'CustomerIncomeController@update')->name('post.customer.income.update');
            $router->get('/delete', 'CustomerIncomeController@delete')->name('get.customer.income.delete');
        });

        $router->group(['prefix' => 'product'], function () use ($router) {
            $router->post('/add', 'CustomerProductController@store')->name('post.customer.product.add');
            $router->get('/edit',  'CustomerProductController@edit')->name('get.customer.product.edit');
            $router->post('/edit', 'CustomerProductController@update')->name('post.customer.product.update');
            $router->get('/delete', 'CustomerProductController@delete')->name('get.customer.product.delete');
            $router->get('/list', 'CustomerProductController@list')->name('get.customer.product.list');
        });

        $router->group(['prefix' => 'author'], function () use ($router) {
            $router->post('/add', 'CustomerAuthorController@store')->name('post.customer.author.add');
            $router->get('/edit',  'CustomerAuthorController@edit')->name('get.customer.author.edit');
            $router->post('/edit', 'CustomerAuthorController@update')->name('post.customer.author.update');
            $router->get('/delete', 'CustomerAuthorController@delete')->name('get.customer.author.delete');
        });

        $router->group(['prefix' => 'address'], function () use ($router) {
            $router->post('/add', 'CustomerAddressController@store')->name('post.address.add');
            $router->get('/edit',  'CustomerAddressController@edit')->name('get.address.edit');
            $router->post('/edit', 'CustomerAddressController@update')->name('post.address.update');
            $router->get('/delete', 'CustomerAddressController@delete')->name('get.address.delete');
        });

        $router->group(['prefix' => 'paper'], function () use ($router) {
            $router->post('/add', 'CustomerPaperController@store')->name('post.paper.add');
            $router->get('/edit',  'CustomerPaperController@edit')->name('get.paper.edit');
            $router->post('/edit',  'CustomerPaperController@update')->name('post.paper.update');
            $router->get('/delete',  'CustomerPaperController@delete')->name('get.paper.delete');
        });
    });

    $router->group(['prefix' => 'order', 'middleware' => ['auth', 'role:Super Admin|Admin|Planner']], function () use ($router) {
        $router->get('/', 'OrderController@index')->name('get.tms.order.index');
        $router->get('/search', 'OrderController@search')->name('get.tms.order.search');
        $router->post('/customers', 'OrderController@getCompanyName')->name('post.tms.order.customers');
        $router->get('/add', 'OrderController@add')->name('get.tms.order.add');
        $router->post('/add', 'OrderController@store')->name('post.tms.order.add');
        $router->get('/type/{typeld}', 'OrderController@getByType')->name('get.tms.order.type');
        $router->get('/view/{id}', 'OrderController@show')->name('get.tms.order.view');
        $router->get('/edit/{id}', 'OrderController@edit')->name('get.tms.order.edit');
        $router->post('/edit/{id}', 'OrderController@update')->name('post.tms.order.edit');
        $router->get('/delete/{id}', 'OrderController@delete')->name('get.tms.order.delete');
        $router->get('/tracking/{id}', 'OrderController@tracking')->name('get.tms.order.tracking');
        $router->get('/tracking',  'OrderController@orderTracking')->name('get.tms.order.tracking.notification');
        $router->post('/location', 'OrderController@location')->name('get.tms.order.location');
        $router->post('/nextStatus',  'OrderController@nextStatus')->name('get.tms.order.next.status');
        $router->post('/updateStatus',  'OrderController@updateOrderStatus')->name('get.tms.order.next.status');
    });

    $router->group(['prefix' => 'survey', 'middleware' => ['auth', 'role:Super Admin|Admin|Planner']], function () use ($router) {
        $router->get('/',  'SurveyController@survey')->name('get.tms.survey');
        $router->post('/send',  'SurveyController@send')->name('post.tms.survey.send');
    });

    $router->group(['prefix' => 'preorder', 'middleware' => ['auth', 'role:Super Admin|Admin|Planner']], function () use ($router) {
        $router->get('/', 'PreorderController@index')->name('get.tms.preorder.index');
        $router->get('/type/{typeld}', 'PreorderController@getByType')->name('get.tms.preorder.type');
        $router->get('/view/{id}', 'PreorderController@show')->name('get.tms.preorder.view');
        $router->get('/close/{id}', 'PreorderController@close')->name('get.tms.preorder.close');
        $router->get('/delete/{id}', 'PreorderController@delete')->name('get.tms.preorder.delete');
        $router->get('/search', 'PreorderController@search')->name('get.tms.preorder.search');
    });

    $router->group(['prefix' => 'dealer', 'middleware' => ['auth', 'role:Super Admin|Admin|Dealer']], function () use ($router) {
        $router->group(
            ['prefix' => 'preorder'],
            function () use ($router) {
                $router->get('/add', 'DealerController@addPreorder')->name('get.tms.dealer.preorder.add');
                $router->post('/add', 'DealerController@storePreorder')->name('post.tms.dealer.preorder.add');
                $router->get('/type/{typeld}', 'DealerController@getPreorderByType')->name('get.tms.dealer.preorder.type');
                $router->get('/view/{id}', 'DealerController@showPreorder')->name('get.tms.dealer.preorder.view');
                $router->get('/edit/{id}', 'DealerController@editPreorder')->name('get.tms.dealer.preorder.edit');
                $router->post('/edit/{id}', 'DealerController@updatePreorder')->name('post.tms.dealer.preorder.edit');
                $router->get('/delete/{id}', 'DealerController@deletePreorder')->name('get.tms.dealer.preorder.delete');
                $router->get('/search', 'DealerController@searchPreorder')->name('get.tms.dealer.preorder.search');
            }
        );

        $router->group(['prefix' => 'order', 'middleware' => ['auth', 'role:Super Admin|Admin|Dealer']], function () use ($router) {
            $router->get('/type/{typeld}', 'DealerController@getOrderByType')->name('get.tms.dealer.order.type');
            $router->get('/search', 'DealerController@searchOrders')->name('get.tms.dealer.order.search');
        });
    });
});

Route::group(['namespace' => 'wms', 'prefix' => 'wms', 'middleware' => ['auth', 'role:Super Admin|Admin']], function () use ($router) {
    $router->group(['prefix' => 'customer'], function () use ($router) {
        $router->get('/', 'CustomerController@index')->name('get.wms.customer.index');
        $router->get('/add', 'CustomerController@add')->name('get.wms.customer.add');
        $router->post('/add/', 'CustomerController@store')->name('post.wms.customer.add');
        $router->get('/edit/{id}', 'CustomerController@edit')->name('get.wms.customer.edit');
        $router->post('/edit/{id}', 'CustomerController@update')->name('post.wms.customer.edit');
        $router->get('/delete/{id}', 'CustomerController@delete')->name('get.wms.customer.delete');
    });

    $router->group(['prefix' => 'order'], function () use ($router) {
        $router->get('/', 'OrderController@index')->name('get.wms.order.index');
        $router->post('/customers', 'OrderController@getCompanyName')->name('post.wms.order.customers');
        $router->get('/add', 'OrderController@add')->name('get.wms.order.add');
        $router->post('/add/type/{typeld}', 'OrderController@store')->name('post.wms.order.add');
        $router->get('/type/{id}/status/{typeld}', 'OrderController@index')->name('get.wms.order.index');
        $router->get('/edit/type/{id}', 'OrderController@edit')->name('get.wms.order.edit');
        $router->post('/edit/type/{id}', 'OrderController@update')->name('get.wms.order.edit');
        $router->get('/delete/type/{id}', 'OrderController@delete')->name('get.wms.order.delete');
    });

    $router->group(['prefix' => 'location'], function () use ($router) {
        $router->get('/', 'LocationController@index')->name('get.wms.location.index');
        $router->get('/add', 'LocationController@add')->name('get.wms.location.add');
        $router->post('/add/', 'LocationController@store')->name('post.wms.location.add');
        $router->get('/edit/{id}', 'LocationController@edit')->name('get.wms.location.edit');
        $router->post('/edit/{id}', 'LocationController@update')->name('post.wms.location.edit');
        $router->get('/delete/{id}', 'LocationController@delete')->name('get.wms.location.delete');
    });
});

Route::group(['namespace' => 'api', 'prefix' => 'api'], function () use ($router) {

    $router->post('/login',  'LoginController@login');
    $router->post('/logout', 'LoginController@logout')->middleware('auth:api');
    $router->get('/roles',  'MobileUserController@getRoles');

    // $router->group(['prefix' => 'vehicle', 'middleware' => ['auth', 'role:Driver']], function () use ($router) {
    $router->group(['prefix' => 'vehicle'], function () use ($router) {
        $router->get('/service/{id}',  'MobileOrderController@showForService')->middleware('auth:api');
        $router->post('/location/{id}',  'MobileOrderController@location')->middleware('auth:api');
        $router->get('/plan/{vehicleId}',  'MobileOrderController@planInfo')->middleware('auth:api');
        $router->get('/plan/detail/{orderId}',  'MobileOrderController@getOrder')->middleware('auth:api');
        $router->get('/plan/show/{orderId}',  'MobileOrderController@order')->middleware('auth:api');
        $router->get('/plan/delete/{planId}',  'MobileOrderController@deletePlan')->middleware('auth:api');
        $router->post('/plan/status',  'MobileOrderController@nextStatus')->middleware('auth:api');
        $router->post('/plan/update',  'MobileOrderController@updatePlan')->middleware('auth:api');
        $router->post('/plan/updateOrderStatus',  'MobileOrderController@updateOrderStatus')->middleware('auth:api');
        $router->get('/order/allstatus',  'MobileOrderController@getAllOrderStatusBySettings')->middleware('auth:api');
    });

    // $router->group(['prefix' => 'dealer' , 'middleware' => ['role:Dealer']], function () use ($router) {
    $router->group(['prefix' => 'dealer'], function () use ($router) {
        $router->get('/list/{customerId}',  'MobileDealerController@list')->middleware('auth:api');
        $router->get('/getCityName',  'MobileDealerController@getCityName')->middleware('auth:api');
        $router->post('/getDistrictName',  'MobileDealerController@getDistrictName')->middleware('auth:api');
        $router->get('/view/{id}',  'MobileDealerController@show')->middleware('auth:api');
        $router->get('/type/{id}',  'MobileDealerController@getByType')->middleware('auth:api');
        $router->get('/delete/{id}', 'MobileDealerController@delete')->middleware('auth:api');
        $router->post('/add', 'MobileDealerController@store')->middleware('auth:api');
        $router->post('/edit/{id}', 'MobileDealerController@update')->middleware('auth:api');
        $router->post('/order/all/{id}', 'MobileDealerController@getOrderByStatusAndDate')->middleware('auth:api');
    });
});

Route::get('vehicle_papers/papers/{path}',  '\App\Http\Controllers\tms\VehiclePaperController@file')->name('get.paper.file');

Auth::routes(['register' => false]);
