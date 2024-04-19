<?php

namespace App\Http\Controllers;

use App\Exports\CustomerExport;
use App\Imports\CustomerImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    public function index()
    {
        return view('customer.index');
    }

    public function importExcelData(Request $request)
    {
        // $request->validate([
        //     'import_file' => [
        //         'required',
        //         'file'
        //     ],
        // ]);

        Excel::import(new CustomerImport, $request->file('import_file'));

        // (new CustomerImport)->import($request->file('import_file'));

        return 'success';
    }

    public function exportExcelData(Request $request)
    {


        switch ($request->type) {

            case 'xlsx':

                $extension = "xlsx";

                $exportFormat = \Maatwebsite\Excel\Excel::XLSX;

                break;

            case 'csv':

                $extension = "csv";

                $exportFormat = \Maatwebsite\Excel\Excel::CSV;

                break;

            case 'xls':

                $extension = "xls";

                $exportFormat = \Maatwebsite\Excel\Excel::XLS;

                break;

            default:

                $extension = "xlsx";

                $exportFormat = \Maatwebsite\Excel\Excel::XLS;

                break;
        }


        $filename = 'customers-' . date('d-m-y') . '.' . $extension;

        return Excel::download(new CustomerExport, $filename, $exportFormat);
    }
}
