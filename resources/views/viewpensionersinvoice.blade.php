<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pensioner List</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            line-height: 1.5;
            margin: 40px;
            color: #000;
        }

        .text-center {
            text-align: center;
        }

        .header h1 {
            font-size: 22px;
            margin-bottom: 5px;
        }

        .header h3 {
            font-size: 16px;
            margin: 2px 0;
        }

        .letter-body {
            margin-top: 30px;
        }

        .letter-body h4 {
            margin: 3px 0;
            font-weight: normal;
        }

        .letter-body p {
            margin-top: 20px;
            text-align: justify;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            font-size: 13px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px 8px;
        }

        th {
            background: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }

        td {
            vertical-align: top;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .text-center-cell {
            text-align: center;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <div class="header text-center">
        <h1>Bangladesh Power Development Board</h1>
        <h3>{{ $officer->office->name_in_english }}</h3>
        <h3>{{ $officer->office->address }}</h3>
    </div>

    <!-- Letter Body -->
    <div class="letter-body">
        <h4>Manager</h4>
        <h4>{{ $bank_details->bank_name }}</h4>
        <h4>{{ $bank_details->bank_address }}</h4>

        <p>
            Dear Sir,
        </p>

        <p>
            You are kindly requested to transfer an amount of Tk.
            <strong>{{ number_format($totalPension, 2) }}</strong> in words
            <strong>{{ $amountInWords }}</strong>
            from Account No.
            <strong>{{ $paymentOfficeBank->account_number }}</strong>
            maintained with your bank in the name of
            <strong>{{ $paymentOfficeBank->account_name }}</strong>
            in favor of the pensioners as per the details described below.
        </p>
    </div>

    <!-- Table -->
    <table>
        <thead>
            <tr>
                <th style="width:5%;">SL</th>
                <th style="width:20%;">Pension Holder Name</th>
                <th style="width:15%;">Bank Name</th>
                <th style="width:15%;">Branch</th>
                <th style="width:15%;">Routing No.</th>
                <th style="width:15%;">Account No.</th>
                <th style="width:15%;">Amount (Tk)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pensionerspensions as $index => $pensionerspension)
                <tr>
                    <td class="text-center-cell">{{ $index + 1 }}</td>
                    <td>{{ $pensionerspension->pensioner->name }}</td>
                    <td>{{ $pensionerspension->pensioner->bank_name }}</td>
                    <td>{{ $pensionerspension->pensioner->branch_name }}</td>
                    <td class="text-center-cell">{{ $pensionerspension->pensioner->bank_routing_number }}</td>
                    <td>{{ $pensionerspension->pensioner->account_number }}</td>
                    <td class="text-right">
                        {{ number_format($pensionerspension->total_pension_amount, 2) }}
                    </td>
                </tr>
                @if ($loop->last)
                    <tr>
                        <td colspan="6" class="text-right">Total sum</td>
                        <td class="text-right"><strong>{{ number_format($totalPension, 2) }}</strong></td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

</body>

</html>
