<h1> 🚀🚀🚀 Laravel Excel </h1>

## Installation

[ Requirements ] 

    -> php version [ ^ 7.2 | ^ 8.0 ]

    -> laravel version [ ^ 5.8 ]  


 
## [1] [ Command ] 

-> composer require maatwebsite/excel


## [2] [ Register ServiceProvider ] 

    [ Go to ] => 
    
        -> config/app.php

    Go to providers and add => [ Maatwebsite\Excel\ExcelServiceProvider ]

        ->  'providers' => [
        ->         /*
        ->          * Package Service Providers...
        ->          */
        ->           Maatwebsite\Excel\ExcelServiceProvider::class,
        ->    ]


## [3] Add the Facade in [ config/app.php ]

        -> 'aliases' => [
        ->    'Excel' => Maatwebsite\Excel\Facades\Excel::class,
        -> ]

## [4] To publish the config, run the vendor publish command:

    -> php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider" --tag=config

    Check if [ excel.php ] register in  [ config ]

## [5] Try to Create Migration [ Command ] 

    -> php artisan make:migration create_customer_table --create

## [6] Add Customer Name , Email , Phone in database/migration

    -> $table->string('name');
    -> $table->string('email');
    -> $table->string('phone');

## [7] Add Customer Model

    ->php artisan make:model Customer




<h1> 🚀🚀🚀 How to Import Excel Data </h1>

## [1] Add Form to Trigger Import Excel Data 

    -> action = action"{{ url(/customer/import) }}"
    -> method = POST
    -> enctype = multipart/form-data


    -> input = type[file] name[import_file]

## [2] 💪 Create an import class in app/Imports [ make:import ]

    -> php artisan make:import CustomersImport

## [3] Insert this code in collection function

    ->    foreach ($rows as $row) {
    ->         Customer::create([
    ->             'name' => $row['name'],    // small letter
    ->             'email' => $row['email'],  // small letter
    ->             'phone' => $row['phone'],  // small letter
    ->         ]);
    ->     }

## [4] Create Controller and make a ImportExcelData function 

    -> function importExcelData(Request $request){

    [ Add this code in your importExcelData function ]

    ->  Excel::import (new CustomerImport, $request->file('import_file));

    ->    return 'success';

    -> }


<h5> 
    Important Notice !!! 
    Make sure your excel file has one worksheet only
</h5>




## [5] To add Heading Row , implement [ WithHeadingRow ]

    ->  class CustomerImport implements ToCollection , withHeadingRow




<h1> 🚀🚀🚀 How to Export Excel Data </h1>


## [1] 💪 Create an export class in app/Exports [ make:export ]

    -> php artisan make:export CustomerExport


## [2] Insert this code in collection function 

    ->   return Customer::all();


## [3] Create Controller and make a ExportExcelData function => 

    -> function exportExcelData(Request $request){
   
    [ Add this code in your exportExcelData function ]

    -> $filename = 'customers.xlsx';
    ->  return Excel::download (new CustomerExport, $filename);

    -> }

## [4] Add Form to Trigger Export Excel Data 

    -> action = action"{{ url(/customer/export) }}"
    -> method = GET

    [ And now you can export/download the excel file ]


<h1> 🚀🚀 To improve your Export Excel Data </h1>

## [5] Go to collection again [...Step 2] if you want to [ Add Headings ]  

    =>  implement [ WithHeadingRow ]

    ->  class CustomerExport implements FromCollection , withHeadings

    And add function =>

    -> public function headings() : array 
    -> {
    ->     return [
    ->         "Name",
    ->         "Email",
    ->         "Password"
    ->     ]
    -> }

    and let's change this query also =>

    -> public function collection()
    -> {
    ->     return Customer::select('name','email','phone')->get();
    -> }

## [6] One more method of Downloading the Excel Sheet [ using the blade view ]

    =>  implement [ FromView ]

    ->  class CustomerExport implements FromView 

    And Import =>

    -> use Illuminate\Contracts\View\View
    -> use Maatwebsite\Excel\Concerns\FromView

    Add function => 

    -> public function view() : View
    -> {
    ->     return view('customer.invoices' , [
    ->         'customers' => Customer::all()
    ->     ])
    -> }

    Add [ View Resource ] and CopyPaste this HtmlCode => 

    -> <table>
    ->     <thead>
    ->         <tr>
    ->             <th>Name</th>
    ->             <th>Email</th>
    ->             <th>Phone</th>
    ->  
    ->         </tr>
    ->     </thead>
    ->     <tbody>
    ->         @foreach($customers as $customer)
    ->         <tr>
    ->             <td>{{ $customer->name }}</td>
    ->             <td>{{ $customer->email }}</td>
    ->             <td>{{ $customer->phone }}</td>
    ->  
    ->         </tr>
    ->         @endforeach
    ->     </tbody>
    -> </table>


## [7] 🚀 Export Format

    => Laravel Excel have three ways of Exporting Data [ xlsx ] [ csv ] [ xls ]

    ->       switch ($request->type) {
    ->
    ->           case 'xlsx':
    ->
    ->               $extension = "xlsx";
    ->
    ->               $exportFormat = \Maatwebsite\Excel\Excel::XLSX;
    ->
    ->               break;
    ->
    ->           case 'csv':
    ->
    ->               $extension = "csv";
    ->
    ->               $exportFormat = \Maatwebsite\Excel\Excel::CSV;
    ->
    ->               break;
    ->
    ->           case 'xls':
    ->
    ->               $extension = "xls";
    ->
    ->               $exportFormat = \Maatwebsite\Excel\Excel::XLS;
    ->
    ->               break;
    ->
    ->           default:
    ->
    ->               $extension = "xlsx";
    ->
    ->               $exportFormat = \Maatwebsite\Excel\Excel::XLS;
    ->
    ->               break;
    ->       }
    ->
    ->
    ->       $filename = 'customers-' . date('d-m-y') . '.' . $extension;
    ->
    ->       return Excel::download(new CustomerExport, $filename, $exportFormat);




##  🚀🚀🚀 To Explore more about <a href="https://docs.laravel-excel.com/3.1/getting-started/"> Laravel Excel </a>



