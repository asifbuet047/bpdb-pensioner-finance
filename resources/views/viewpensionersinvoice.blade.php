<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <title>Pensioner List</title>
    <style>
        .custom {
            font-family: 'Li Kobita Unicode', sans-serif;
            font-size: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }
    </style>
</head>

<body>
    <div>
        <h1>Bangladesh Power Development Board</h1>
        <h2 class="custom">বাংলাদেশ বিদ্যুৎ উন্নয়ন বোর্ড</h2>
        <h3>{{ $officer->office->name_in_english }}</h3>
        <h3>{{ $officer->office->address }}</h3>
        <h4>Manager</h4>
        <h4>{{ $bank_details->bank_name }}</h4>
        <h4>{{ $bank_details->bank_address }}</h4>
        <p>Dear Sir,
            You are kindly requested to transfer an amount of Tk. <span class="fw-bold">{{ $totalPension }}</span> from
            Account No. <span class="fw-bold">{{ $paymentOfficeBank->account_number }}</span> maintained with your bank
            in the name of <span class="fw-bold">{{ $paymentOfficeBank->account_name }}</span> in favor of the pensioners
            as per the details described below.</p>

    </div>

    <table>
        <thead>
            <tr>
                <th scope="col">
                    SL NO
                </th>
                <th scope="col">
                    Pension Holder Name
                </th>
                <th scope="col">
                    Bank Name
                </th>
                <th scope="col">
                    Branch
                </th>
                <th scope="col">
                    Routing Number
                </th>
                <th scope="col">
                    Account number
                </th>
                <th scope="col">
                    Amount
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pensionerspensions as $index => $pensionerspension)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pensionerspension->pensioner->name }}</td>
                    <td>{{ $pensionerspension->pensioner->bank_name }}</td>
                    <td>{{ $pensionerspension->pensioner->branch_name }}</td>
                    <td>{{ $pensionerspension->pensioner->bank_routing_number }}</td>
                    <td>{{ $pensionerspension->pensioner->account_number }}</td>
                    <td>{{ number_format($pensionerspension->total_pension_amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
