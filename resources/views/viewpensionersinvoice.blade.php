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
        <h3>Regional Account Office (POIN)</h3>
        <h4>Manager</h4>
        <h4>{{ $bank_name }}</h4>
        <p>Your bank is requested to take the necessary steps for the transfer of funds from Account No. 1612136001142
            for Ahid, PNDCO, BUO, and the Dhaka office, corresponding to the total amount of Taka /= ( ). The monthly
            pension allowances for the pensioners mentioned above for October 2022, according to the respective
            bank-wise details, are to be transferred via your bank by issuing check no. ___ dated 01/11/2022, and the
            charges for online submission of the mentioned bills shall be debited from the Electricity Development
            Board's account.</p>

    </div>

    <table>
        <thead>
            <tr>
                <th scope="col">
                    No
                </th>
                <th scope="col">
                    ERP ID
                </th>
                <th scope="col">
                    Name
                </th>
                <th scope="col">
                    Register No
                </th>
                <th scope="col">
                    Basic Salary
                </th>
                <th scope="col">
                    Medical Allowance
                </th>
                <th scope="col">
                    Incentive Bonus
                </th>
                <th scope="col">
                    Account Number
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pensioners as $index => $pensioner)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pensioner->erp_id }}</td>
                    <td>{{ $pensioner->name }}</td>
                    <td>{{ $pensioner->register_no }}</td>
                    <td>{{ number_format($pensioner->basic_salary, 2) }}</td>
                    <td>{{ number_format($pensioner->medical_allowance, 2) }}</td>
                    <td>{{ number_format($pensioner->incentive_bonus, 2) }}</td>
                    <td>{{ $pensioner->account_number }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
