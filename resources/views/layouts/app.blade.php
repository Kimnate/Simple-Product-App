<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> Simple Products App </title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- AlertifyJS CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    @yield('styles')

</head>

<body class="">

    <div class="wrapper">

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            @yield('content')

        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- ./wrapper -->

    <div class="footer text-center py-3">
        Developed By Nathan Chirchir | <i class="bx bxl-whatsapp"> </i> +254 720 134 035
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- AlertifyJS JS -->
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <script>

        $(document).ready(function () {
            // Handle form submission for adding or editing a product
            $('#product-form').on('submit', function (e) {
                e.preventDefault();

                const editId = $(this).data('edit-id'); // Check if we're editing
                const url = editId
                    ? `/products/${editId}` // Update edit URL
                    : "{{ route('products.store') }}"; // Store new data URL
                const method = editId ? 'PUT' : 'POST'; // Determine Method

                $.ajax({
                    url: url,
                    type: method,
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response.status === 'success') {
                            if (editId) {
                                updateProductRow(response.data, editId);
                            } else {
                                addProductRow(response.data);
                                updateTotal(response.data.total_value);
                            }
                            $('#product-form')[0].reset(); // Reset the form
                            $('#product-form').removeData('edit-id'); // Clear edit state
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success('Product SAVED Successfully!');
                        }
                    },
                    error: function (xhr) {
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.error('An error occurred while submitting the data.');
                    }
                });
            });

            // Handle edit button click
            $('#products-table').on('click', '.edit-product', function () {
                const row = $(this).closest('tr');
                const rowIndex = row.data('id');

                // Populate form with current row data
                $('#name').val(row.find('td:nth-child(1)').text());
                $('#stock_qty').val(row.find('td:nth-child(2)').text());
                $('#price_per_pc').val(row.find('td:nth-child(3)').text());

                // Store the row id in the form
                $('#product-form').data('edit-id', rowIndex);
            });

            // Add a new product row to table
            function addProductRow(data) {
                const row = `
                    <tr data-id="${data.id}">
                        <td>${data.name}</td>
                        <td>${data.stock_qty}</td>
                        <td>${data.price_per_pc}</td>
                        <td>${data.date_time}</td>
                        <td>${data.total_value}</td>
                        <td>
                            <button class="btn btn-warning btn-sm edit-product"> <i class="bx bx-edit"> </i>  Edit </button>
                        </td>
                    </tr>`;
                $('#products-table tbody #total-row').before(row);
            }

            // Update an existing product row in table
            function updateProductRow(data, id) {
                const row = $(`#products-table tbody tr[data-id="${id}"]`);
                row.find('td:nth-child(1)').text(data.name);
                row.find('td:nth-child(2)').text(data.stock_qty);
                row.find('td:nth-child(3)').text(data.price_per_pc);
                row.find('td:nth-child(4)').text(data.date_time);
                row.find('td:nth-child(5)').text(data.total_value);

                recalculateTotal(); // Recalculate the total value
            }

            // Update the total value
            function updateTotal(value) {
                let currentTotal = parseFloat($('#total-value').text());
                let newTotal = currentTotal + parseFloat(value);
                $('#total-value').text(newTotal.toFixed(2));
            }

            // Recalculate the total value of all rows
            function recalculateTotal() {
                let total = 0;
                $('#products-table tbody tr').each(function () {
                    const value = parseFloat($(this).find('td:nth-child(5)').text()) || 0;
                    total += value;
                });
                $('#total-value').text(total.toFixed(2));
            }
        });

    </script>

</body>
</html>
