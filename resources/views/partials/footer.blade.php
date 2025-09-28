<footer class="pt-5 pb-4 mt-5 text-black custom-border" style="background-color: #A2E8DD">
    <style>
        .custom-border {
            border: 3px solid black !important;
        }
    </style>
    <div class="container">
        <div class="row">

            <!-- About -->
            <div class="col-md-4 mb-4">
                <h5 class="text-uppercase fw-bold mb-3">Pension Management System</h5>
                <p>
                    A complete solution to manage pensioners, offices, officers, and invoices in one place.
                </p>
            </div>

            <!-- Quick Links -->
            <div class="col-md-3 mb-4">
                <h6 class="text-uppercase fw-bold mb-3">Quick Links</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ route('show.pensioner.section') }}" class="text-decoration-none">Manage
                            Pensioners</a></li>
                    <li><a href="{{ route('show.offices') }}" class="text-decoration-none">Manage
                            Offices</a></li>
                    <li><a href="{{ route('show.officers') }}" class="text-decoration-none">Manage
                            Officers</a></li>
                    <li><a href="" class="text-decoration-none">Download
                            Invoices</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div class="col-md-5 mb-4">
                <h6 class="text-uppercase fw-bold mb-3">Contact</h6>
                <p><i class="bi bi-geo-alt-fill me-2"></i> Pension Dept, Bangladesh Power Development Board, Bangladesh
                </p>
                <p><i class="bi bi-envelope-fill me-2"></i> support@pensionapp.com</p>
                <p><i class="bi bi-telephone-fill me-2"></i> +880 1234-567890</p>
            </div>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="text-center p-3 bg-secondary">
        © {{ date('Y') }} Pension Management System | All Rights Reserved
    </div>
</footer>
