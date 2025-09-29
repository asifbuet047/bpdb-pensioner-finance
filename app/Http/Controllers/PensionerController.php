<?php

namespace App\Http\Controllers;

use App\Exports\PensionersExport;
use App\Exports\PensionersTemplateExport;
use App\Imports\PensionersImport;
use App\Models\Pensioner;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PensionerController extends Controller
{
    public function addPensionerIntoDB(Request $request)
    {

        if ($request->hasCookie('user_id')) {
            $validated = $request->validate([
                'erp_id'           => 'required|integer|unique:pensioners,erp_id',
                'name'             => 'required|string|max:255',
                'register_no'      => 'required|string|max:50|unique:pensioners,register_no',
                'basic_salary'     => 'required|integer|min:0',
                'medical_allowance' => 'required|integer|min:0',
                'incentive_bonus'  => 'required|numeric|min:0',
                'bank_name'        => 'required|string|max:255',
                'account_number'   => 'required|string|max:255|unique:pensioners,account_number',
            ]);

            $pensioner = Pensioner::create($validated);

            return redirect()->back()->with($validated);
        } else {
            return view('login');
        }
    }

    public function getAllPensionersFromDB(Request $request)
    {
        if ($request->hasCookie('user_id')) {
            $pensioners = Pensioner::orderBy('erp_id')->get();
            return view('viewpensioner')->with(compact('pensioners'));
        } else {
            return view('login');
        }
    }

    public function removePensionerFromDB(Request $request)
    {
        if ($request->cookie('user_role') === 'SUPER_ADMIN') {;
            $id = (int)$request->input('id');
            $pensioner = Pensioner::find($id);
            if ($pensioner) {
                $pensioner->delete();
                $pensioners = Pensioner::orderBy('name')->get();
                return redirect()->route('show.pensioner.section')->with(compact('pensioners'));
            } else {
                return response()->json(['message' => $id]);
            }
        } else {
            return view('login');
        }
    }


    public function updatePensionerIntoDB(Request $request)
    {
        if ($request->cookie('user_role') === 'SUPER_ADMIN') {;
            // $validated = $request->validate([
            //     'erp_id'           => 'required|integer|unique:pensioners,erp_id',
            //     'name'             => 'required|string|max:255',
            //     'register_no'      => 'required|string|max:50|unique:pensioners,register_no',
            //     'basic_salary'     => 'required|integer|min:0',
            //     'medical_allowance' => 'required|integer|min:0',
            //     'incentive_bonus'  => 'required|numeric|min:0',
            //     'bank_name'        => 'required|string|max:255',
            //     'account_number'   => 'required|string|max:255|unique:pensioners,account_number',
            // ]);

            $editedPensioner = $request->all();
            $exitingPensioner = Pensioner::find($editedPensioner['id']);
            if ($exitingPensioner) {
                $exitingPensioner->name = $editedPensioner['name'];
                $exitingPensioner->register_no = $editedPensioner['register_no'];
                $exitingPensioner->basic_salary = $editedPensioner['basic_salary'];
                $exitingPensioner->medical_allowance = $editedPensioner['medical_allowance'];
                $exitingPensioner->incentive_bonus = $editedPensioner['incentive_bonus'];
                $exitingPensioner->bank_name = $editedPensioner['bank_name'];
                $exitingPensioner->account_number = $editedPensioner['account_number'];
                $exitingPensioner->save();
                $pensioners = Pensioner::orderBy('name')->get();
                return redirect()->route('show.pensioner.section')->with(compact('pensioners'));
            } else {
                return response()->json(['message' => $editedPensioner['id']]);
            }
        } else {
            return view('login');
        }
    }

    public function exportPensioners(Request $request)
    {
        return Excel::download(new PensionersExport, 'pensioners.xlsx');
    }

    public function exportPensionersTemplate()
    {
        return Excel::download(new PensionersTemplateExport, 'penioners.xlsx');
    }

    public function importPensioner(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new PensionersImport, $request->file('file'));
        return back()->with('success', 'Pensioners imported successfully!');
    }

    public function showImportPensionerSection(Request $request)
    {
        return view('importpensioners');
    }


    public function showInvoiceBank(Request $request)
    {
        if ($request->hasCookie('user_id')) {
            $banks = Pensioner::select('bank_name')->distinct()->pluck('bank_name');
            return view('viewbanks')->with(compact('banks'));
        } else {
            return view('login');
        }
    }

    public function showSelectedBankPensionersForInvoiceGeneration(Request $request)
    {
        if ($request->hasCookie('user_id')) {
            if ($request->query('bank_name')) {
                $banks = Pensioner::select('bank_name')->distinct()->pluck('bank_name')->toArray();
                $bank_name = $request->query('bank_name');
                if (in_array($bank_name, $banks)) {
                    $pensioners = Pensioner::where('bank_name', '=', $bank_name)->get();
                    return view('viewselectedbankpensioners')->with(compact('pensioners', 'bank_name'));
                } else {
                }
            } else {
                return view('login');
            }
        } else {
            return view('login');
        }
    }

    public function generateInvoice(Request $request)
    {
        if ($request->hasCookie('user_id')) {
            if ($request->query('bank_name')) {
                $banks = Pensioner::select('bank_name')->distinct()->pluck('bank_name')->toArray();
                $bank_name = $request->query('bank_name');
                $pensioners = Pensioner::where('bank_name', '=', $bank_name)->get();
                if (in_array($bank_name, $banks)) {

                    /* $pdf = Pdf::setOptions([
                        'isHtml5ParserEnabled' => true,
                        'isRemoteEnabled' => true,
                        'defaultFont' => 'nikosh',
                    ]);
                    $pdf->loadView('viewpensionersinvoice', compact('pensioners', 'bank_name'))->setPaper('a4', 'portrait');
                    return $pdf->stream('invoice.pdf'); */


                    /*  $defaultConfig = (new ConfigVariables())->getDefaults();
                    $fontDirs = $defaultConfig['fontDir'];
                    $defaultFontConfig = (new FontVariables())->getDefaults();
                    $fontData = $defaultFontConfig['fontdata'];
                    $mpdf = new Mpdf([
                        'mode' => 'utf-8',
                        'format' => 'A4',
                        'fontDir' => array_merge($fontDirs, [
                            storage_path('fonts'),
                        ]),
                        'fontdata' => $fontData + [
                            'nikosh' => [
                                'R' => 'Nikosh.ttf',
                            ],
                            'siyamrupali' => [
                                'R' => 'SiyamRupali.ttf',
                            ]
                        ],
                        'default_font' => 'siyamrupali',
                    ]);
                    $html = view('viewpensionersinvoice', compact('pensioners', 'bank_name'))->render();
                    $mpdf->WriteHTML($html);
                    $mpdf->Output('pensioners.pdf', 'I'); */

                    $pdf = PDF::loadView('viewpensionersinvoice', compact('pensioners', 'bank_name'))
                        ->setPaper('a4')->setOption('encoding', 'utf-8');

                    return $pdf->inline('invoice.pdf');
                } else {
                }
            } else {
                return view('login');
            }
        } else {
            return view('login');
        }
    }
}
