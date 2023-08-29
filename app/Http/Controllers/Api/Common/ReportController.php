<?php

namespace App\Http\Controllers\Api\Common;

use App\Http\Controllers\Controller;
use App\Models\UploadPrescription;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{

    public function prescriptionPdf($id)
    {

        try {
            $prescription = UploadPrescription::where('id', $id)->first();

            if ($prescription) {

                $data = [
                    'prescription' => $prescription,
                ];

                // return $data['prescription'];

                $dompdf = PDF::loadView('PDF.prescription', $data);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();

                return $dompdf->stream('prescription.pdf', ['Attachment' => false]);
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => 'Not Found!'
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'msg' => $th->getMessage()
            ]);
        }
    }
}
