<!DOCTYPE html>
<html>

<head>
    <title>data['prescription'] - PDF</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            color-adjust: exact;
        }

        body {
            height: 100vh;
            display: grid;
            place-items: center;
        }

        .invoice {
            /* width: min(600px, 90vw); */
            /* font: 100 0.7rem 'myriad pro', helvetica, sans-serif; */
            /* border: 0.5px solid black; */
            padding: 4rem 3rem;
            display: flex;
            flex-direction: column;
            gap: 3rem;
        }

        .invoice-wrapper {
            display: flex;
            justify-content: space-between;
            padding: 0 1rem;
        }

        .invoice-company {
            text-align: right;
        }

        .invoice-company-name {
            font-size: 16px;
            margin-bottom: 1.25rem;
        }

        .invoice-company-address {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .invoice-logo {
            width: 5rem;
            height: 5rem;
        }

        .invoice-billing-company {
            font-size: 16px;
            margin-bottom: 0.25rem;
        }

        .invoice-billing-address {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .invoice-info {
            display: flex;
            justify-content: space-between;
            gap: 2rem;
            margin: 0.25rem 0;
        }

        .invoice-info:nth-of-type(5) {
            margin-top: 1.5rem;
        }

        .invoice-info-value {
            font-weight: 900;
        }

        .invoicetable {
            width: 100%;
        }

        .invoice-table,
        th,
        td {
            border-collapse: collapse;
        }

        th,
        td {
            /* width: calc((600px - 3rem) / 4); */
            text-align: center;
            padding: 0.75rem;
        }

        tr:nth-of-type(1) {
            color: #fff;
            background-color: gray;
        }

        tr:nth-of-type(2),
        tr:nth-of-type(3) {
            border-bottom: 0.5px solid rgba(0, 0, 0, 0.25);
        }

        .invoice-total {
            font-weight: 900;
        }

    </style>

</head>

<body>
    <main class='invoice'>
        <div class='invoice-wrapper'>
            <img src='{{ public_path('panel/assets/images/logo.png') }}' alt='logo' class='invoice-logo'>
        </div>
        <div class='invoice-wrapper'>
            <div style="margin-top: 50px;">
                <h2 class='invoice-billing-company'>The Pharmassists</h2>
                <p class='invoice-billing-address'>
                    <span></span>
                    <span></span>
                </p>
            </div>
            <div class='invoice-details'>
                <div class='invoice-info'>
                    <span class='invoice-info-key' style="font-size: 16px;">#:</span>
                    <span class='invoice-info-value' style="font-size: 16px;">{{ $prescription->id }}</span>
                </div>
                <div class='invoice-info'>
                    <span class='invoice-info-key' style="font-size: 16px;">Customer:</span>
                    <span class='invoice-info-value' style="font-size: 16px;">{{ $prescription->user->firstname . ' ' . $prescription->user->lastname }}</span>
                </div>
                <div class='invoice-info'>
                    <span class='invoice-info-key' style="font-size: 16px;">Issue Date:</span>
                    <span class='invoice-info-value' style="font-size: 16px;">{{ date('F, j Y', strtotime($prescription->created_at)) }}</span>
                </div>
                <div class='invoice-info'>
                    <span class='invoice-info-key' style="font-size: 16px;">Status:</span>
                    <span class='invoice-info-value' style="font-size: 16px;">{{ $prescription->status }}</span>
                </div>
                <div class='invoice-info'>
                    <span class='invoice-info-key' style="font-size: 16px;">Address:</span>
                    <span class='invoice-info-value' style="font-size: 16px;">{{ $prescription->address }}</span>
                </div>
            </div>
        </div>
        @php
            $total = 0;
        @endphp
        <table class='invoice-table' style="margin-top: 20px">
            <tr>
                <th>Service Fee</th>
                <th>Is Copayment</th>
                <th>Copayment Price</th>
                <th>Vat Price</th>
                <th>Is Revised</th>
            </tr>
            @foreach (App\Models\PrescriptionPricing::where('upload_prescription_id', $prescription->id)->get() as $item)
                @php
                    $total += $item->service_fee + $item->copayment_price + $item->vat_price;
                @endphp
                <tr>
                    <td>{{ $item->service_fee }}</td>
                    <td>{{ $item->is_copayment }}</td>
                    <td>{{ $item->copayment_price }}</td>
                    <td>{{ $item->vat_price }}</td>
                    <td>{{ $item->is_revised }}</td>
                </tr>
            @endforeach
            <tr>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td class='invoice-total'>{{ $total }}</td>
            </tr>
        </table>
        <ion-icon name="print-outline" class='invoice-print'></ion-icon>
    </main>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
