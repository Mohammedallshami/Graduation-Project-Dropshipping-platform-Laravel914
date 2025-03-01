@extends('User.layouts.main')

@section('pageTitle')
    تفاصيل الطلبات
@endsection

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>تفاصيل الطلب</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Forms</li>
                    <li class="breadcrumb-item active">Validation</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">

            <div class="row">
                <div class="col-lg-8">


                    <div class="card">
                        <div class="card-header text-center text-bg-light fs-5 fw-bold">المنتجات</div>
                        <div class="table-responsive">
                            <!-- Table with stripped rows -->
                            <table id="products" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>الصورة</th>
                                        <th>اسم المنتج</th>
                                        <th>الباركود</th>
                                        <th>الكمية</th>
                                        <th>الوزن</th>
                                        <th>الوزن فرعي</th>
                                        <th>السعر</th>
                                        <th>المبلغ الفرعي</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 xs-12">
                            <div class="card ">
                                <div class="card-header text-center text-bg-light fs-5 fw-bold">مجموع الطلب</div>
                                <div class="card-body py-3 justify-content-end">
                                    <p class="text-dark fs-5">المبلغ الجمالي:
                                        <span class="pe-3 text-dark" id="total_per_shp"></span>
                                        ر.ي
                                    </p>
                                    <p class="text-dark fs-5">الوزن الإجمالي:
                                        <span class="pe-3 text-dark" id="total_weight"></span>
                                        جرام
                                    </p>
                                    <p class="text-dark fs-5">رسوم الشحن:
                                        <span class="pe-3 text-dark" id="shipping_fees"></span>
                                        ر.ي
                                    </p>
                                    <p class="text-dark fs-5">المجموع الكلي:
                                        <span class="pe-3 text-dark" id="total_amount"></span>
                                        ر.ي
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 xs-12">
                            <div class="card">
                                <div class="card-header text-center text-bg-light fs-5 fw-bold"> معلومات الطلب</div>
                                <div class="card-body ">
                                    <p class="text-dark fs-5">رقم الطلب:
                                        <span class="p-3 text-dark" id="order_id"></span>
                                    </p>
                                    <p class="text-dark fs-5">تاريخ الطلب:
                                        <span class="p-3 text-dark" id="order_date"></span>
                                    </p>
                                    <p class="text-dark fs-5">طريقة التوصيل:
                                        <span class="p-3 text-dark" id="delivery_name"></span>
                                    </p>
                                    <p class="text-dark fs-6 fw-bold">حالة الطلب:
                                        <span class="p-3 text-warning" id="order_status"></span>
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">

                    <div class="card">
                        <div class="card-header text-center text-bg-light fs-5 fw-bold"> معلومات العميل</div>
                        <div class="card-body">
                            <form id="form" method="post" class="row g-3">

                                <div class="col-md-12">
                                    <label for="customer_name" class="form-label">اسم العميل</label>
                                    <input type="text" class="form-control" id="customer_name" name="customer_name"
                                        required>
                                    <small id="customer_name_error" class="form-text text-danger"></small>
                                </div>
                                <div class="col-md-12">
                                    <label for="customer_phone" class="form-label">رقم الجوال</label>
                                    <input type="number"  min="1" class="form-control" id="customer_phone" name="customer_phone"
                                        required>
                                    <small id="customer_phone_error" class="form-text text-danger"></small>
                                </div>
                                <div class="col-md-12">
                                    <label for="customer_email" class="form-label">البريد الإلكتروني</label>
                                    <input type="email" class="form-control" id="customer_email" name="customer_email"
                                        required>
                                    <small id="customer_email_error" class="form-text text-danger"></small>
                                </div>
                                <div class="col-md-12">
                                    <label for="shipping_address" class="form-label">العنوان</label>
                                    <textarea type="text" class="form-control" id="shipping_address" name="shipping_address" style=" height: auto"></textarea>
                                    <small id="shipping_address_error" class="form-text text-danger"></small>
                                </div>
                                <div class="text-center">
                                    <button type="submit" id="submit" class="btn btn-primary">تحديث</button>
                                </div>
                            </form><!-- End Multi Columns Form -->
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header text-center text-bg-light fs-5 fw-bold">حالة الدفع</div>
                        <div class="card-body py-3 text-center">
                            <p class=" fw-bolder mb-4" id="payment_status"></p>
                            <a href="#" id="pay" class="btn btn-outline-success">أدفع</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {

            //دالة تحديث حالة الدفع
            function updatePaymentStatus(order_id, payment_status, total_amount, wallet_id) {
                $.ajax({
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                    },
                    url: "{{ route('admin.order.update.payment.status') }}",
                    data: {
                        'order_id': order_id,
                        'payment_status': payment_status,
                        'total_amount': total_amount,
                        'wallet_id': wallet_id,
                    },
                    success: function(data) {
                        Swal.fire({
                            title: "تم التحديث",
                            text: "لقد تم تحديث حالة الدفع بنجاح",
                            icon: "success"
                        });

                        location.reload();
                    },
                    error: function(reject) {
                        if (reject.responseJSON.error) {
                            // إذا كان هناك خطأ في الباركود
                            Swal.fire({
                                title: reject.responseJSON.error,
                                icon: 'error'
                            });
                        }
                    }
                });
            }

            //دالة تحديث حالة الدفع
            function getWalletId() {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        type: 'get',
                        url: "{{ route('user.order.getWalletId') }}",
                        data: {
                            'store_id': {{ Auth::user()->store_id }},
                        },
                        success: function(data) {
                            resolve(data.wallet_id);
                        },
                        error: function(reject) {
                            reject("حدث خطأ أثناء الحصول على wallet_id");
                        }
                    });
                });
            }

            // تحديد دالة async لاستخدام await
            async function handlePayment() {
                var order_id = $('#order_id').text();
                console.log(order_id);
                var payment_status = 'تم الدفع';
                var total_amount = $('#total_amount').text();

                try {
                    // استدعاء الدالة واستخدام await داخل السياق الذي يدعم async
                    var wallet_id = await getWalletId();

                    Swal.fire({
                        title: "هل أنت متأكد؟",
                        text: "لن تتمكن من التراجع عن هذا",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        cancelButtonText: "تراجع",
                        confirmButtonText: "نعم، قم بتغيير حالة الدفع"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            updatePaymentStatus(order_id, payment_status, total_amount, wallet_id);
                        }
                    });
                } catch (error) {
                    console.error(error);
                }
            }

            // اندما تقوم بالنقر على زر الدفع
            $(document).on('click', '#pay', function(e) {
                e.preventDefault();
                // استدعاء الدالة
                handlePayment();
            });


            $.ajax({
                url: "{{ route('user.order.details.getOrderInfo') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    id: '{{ request('id') }}'
                },
                success: function(data) {
                    $('#order_id').text(data.order_id);
                    $('#order_date').text(moment(data.created_at).format('YYYY-MM-DD HH:mm:ss'));
                    $('#order_status').text(data.order_status);
                    // إزالة جميع الفئات الحالية لـ #order_status
                    $('#order_status').removeClass('text-success text-danger text-warning');
                    // إضافة الفئة المناسبة بناءً على قيمة data.order_status
                    if (data.order_status === 'تم التوصيل') {
                        $('#order_status').addClass('text-success');
                    } else if (data.order_status === 'تم الغاء الطلب') {
                        $('#order_status').addClass('text-danger');
                    } else {
                        $('#order_status').addClass('text-warning');
                    }

                    $('#delivery_name').text(data.delivery_name);
                    $('#customer_name').val(data.customer_name);
                    // $('#customer_phone').val(data.customer_phone);
                    $('#payment_status').text(data.payment_status);
                    if (data.payment_status === 'تم الدفع') {
                        $('#payment_status').addClass('text-success');
                        $('#pay').hide();
                    } else if (data.payment_status === 'تم الغاء الدفع') {
                        $('#payment_status').addClass('text-danger');
                        $('#pay').hide();
                    } else {
                        $('#payment_status').addClass('text-warning');
                    }

                    $('#customer_email').val(data.customer_email);
                    $('#shipping_address').text(data.shipping_address);
                    $('#customer_phone').val(data.customer_phone);
                    $('#total_per_shp').text(data.total_per_shp);
                    $('#total_weight').text(data.total_weight);
                    $('#shipping_fees').text(data.delivery_shipping_fees);
                    $('#total_amount').text(data.total_amount);
                },
                error: function(error) {
                    // إدارة الأخطاء هنا
                    console.error('حدث خطأ أثناء جلب البيانات', error);
                }
            });
            $(function() {

                var order_details_data = $('#products').DataTable({
                    processing: true,
                    serverSide: true,
                    "autoWidth": false,
                    //إمكانية تحريك الاعمدة
                    colReorder: true,
                    responsive: true,
                    order: [
                        [0, "desc"]
                    ],
                    //عرض اسم الحقل و محتويات الحقول من اليمين لليسار
                    columnDefs: [{
                        targets: '_all', //كل الحقول
                        className: 'dt-right' //الاتجاه
                    }],
                    ajax: "{{ Route('user.order.details.data') }}",
                    dom: "<'row'<'col-sm-12 col-md-4 p-2'B><'col-sm-12 col-md-4'><'col-sm-12 col-md-4 p-3'l>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Arabic.json" // توفير ملف ترجمة للعربية
                    },

                    buttons: [{
                        text: 'إضافة منتج',
                        className: 'custom-add-button',
                        action: function(e, dt, node, config) {
                            Swal.fire({
                                title: 'إضافة المزيد من المنتجات',
                                text: "قم بكتابة او لصق باركود المنتج المراد إضافته ( لإضافه المنتج يتطلب وجود المنتج في قائمة منتجاتي )",
                                input: 'number',
                                inputAttributes: {
                                    autocapitalize: 'off'
                                },
                                showCancelButton: true,
                                confirmButtonText: 'تأكيد',
                                cancelButtonText: 'إلغاء',
                                showLoaderOnConfirm: true,
                                preConfirm: (barcode) => {
                                    // هنا ستقوم بكتابة دالة Ajax لإرسال الباركود
                                    return axios.post(
                                            "{{ route('user.product.getProductByBarcode') }}", {
                                                barcode: barcode,
                                                order_id: '{{ request('id') }}' // إضافة معلمة الطلب هنا
                                            })
                                        .then(response => {
                                            if (response.data) {
                                                if (response.data
                                                    .error) {
                                                    // إذا كان هناك خطأ في الباركود
                                                    Swal.fire({
                                                        title: response
                                                            .data
                                                            .error,
                                                        icon: 'error'
                                                    });
                                                } else {
                                                    // هنا ستعرض معلومات المنتج في واجهة SweetAlert2
                                                    Swal.fire({
                                                        title: response
                                                            .data
                                                            .name,
                                                        html: '<a href="../../Products_img/' +
                                                            response
                                                            .data
                                                            .image +
                                                            '" data-lightbox="product-image" data-title="Product Image">' +
                                                            '<img src="../../Products_img/' +
                                                            response
                                                            .data
                                                            .image +
                                                            '" alt="Product Image" width="100" height="100">' +
                                                            '</a><br><br>' +
                                                            '<h4>السعر: ' +
                                                            response
                                                            .data
                                                            .selling_price +
                                                            ' ر.ي.</h4>',
                                                        input: 'number',
                                                        inputLabel: 'أدخل الكمية المطلوبة',
                                                        inputAttributes: {
                                                            min: 1
                                                        },
                                                        showCancelButton: true,
                                                        confirmButtonText: 'إضافة إلى الطلب',
                                                        cancelButtonText: 'إلغاء',
                                                        showLoaderOnConfirm: true,
                                                        preConfirm: (
                                                            quantity
                                                        ) => {
                                                            // هنا يمكنك التحكم في رسالة النجاح
                                                            return axios
                                                                .post(
                                                                    "{{ route('user.order.details.addProduct') }}", {
                                                                        product: response
                                                                            .data,
                                                                        quantity: quantity,
                                                                        order_id: '{{ request('id') }}' // إضافة معلمة الطلب هنا
                                                                    }
                                                                )
                                                                .then(
                                                                    response => {
                                                                        Swal.fire({
                                                                                title: 'تمت الإضافة بنجاح!',
                                                                                icon: 'success'

                                                                            })
                                                                            .then(
                                                                                (
                                                                                    result
                                                                                ) => {
                                                                                    if (result
                                                                                        .isConfirmed
                                                                                    ) {
                                                                                        location
                                                                                            .reload();
                                                                                    }
                                                                                }
                                                                            );
                                                                    }
                                                                )
                                                                .catch(
                                                                    error => {
                                                                        console
                                                                            .error(
                                                                                'حدث خطأ أثناء إضافة المنتج إلى التفاصيل',
                                                                                error
                                                                                .response
                                                                                .data
                                                                                .error,
                                                                            );
                                                                        Swal.fire({
                                                                            title: error
                                                                                .response
                                                                                .data
                                                                                .error,
                                                                            icon: 'error'
                                                                        });
                                                                    }
                                                                );
                                                        }
                                                    });
                                                }
                                            } else {
                                                // إذا كان الباركود غير صحيح
                                                Swal.fire({
                                                    title: 'الباركود غير صحيح',
                                                    icon: 'error'
                                                });
                                            }
                                        })
                                        .catch(error => {
                                            console.error(
                                                'حدث خطأ أثناء البحث عن المنتج بواسطة الباركود',
                                                error);
                                            Swal.fire({
                                                title: 'حدث خطأ أثناء البحث',
                                                icon: 'error'
                                            });
                                        });
                                }
                            });
                        }
                    }, ],

                    columns: [{
                            data: 'order_details_id',
                            name: 'order_details_id'
                        },
                        // {
                        //     data: 'id',
                        //     name: 'id'
                        // },
                        {
                            data: 'image',
                            name: 'image',
                            render: function(data, type, full, meta) {
                                return '<a href="../../Products_img/' + data +
                                    '" data-lightbox="product-image" data-title="Product Image">' +
                                    '<img src="../../Products_img/' + data +
                                    '" alt="Product Image" width="60" height="60">' +
                                    '</a>';
                            }
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'barcode',
                            name: 'barcode'
                        },
                        {
                            data: 'quantity',
                            name: 'quantity'
                        },

                        {
                            data: 'weight',
                            name: 'weight'
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                // حساب المبلغ الفرعي بضرب الكمية في التكلفة الإجمالية
                                return row.quantity * row.weight;
                            },
                            name: 'الوزن الفرعي'
                        },
                        {
                            data: 'selling_price',
                            render: function(data, type, row) {
                                // تنسيق سعر البيع بشكل "30.00 ر.س."
                                var formattedSellingPrice = row.selling_price.toFixed(2) +
                                    ' ر.ي.';
                                return formattedSellingPrice;
                            },
                            name: 'selling_price'
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                var subTotal = row.quantity * row.selling_price;
                                // تنسيق الناتج بشكل مثل "30.00 ر.س."
                                var formattedSubTotal = subTotal.toFixed(2) + ' ر.ي.';

                                return formattedSubTotal;
                            },
                            name: 'المبلغ الفرعي'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        },
                    ]
                });
            });

            //تحديث معلومات العميل
            $(document).on('click', '#submit', function(e) {
                e.preventDefault();
                //اخفاء رسالة الخطاء عند الصغط على زر الارسال مره اخرى
                $('#customer_name_error').text('');
                $('#customer_phone_error').text('');
                $('#customer_email_error').text('');
                $('#shipping_address_error').text('');
                var formData = new FormData($("#form")[0]);
                formData.append('id', '{{ request('id') }}');
                Swal.fire({
                    title: "هل انت متأكد ؟",
                    text: "لن تتمكن من التراجع عن هذا",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "تراجع",
                    confirmButtonText: "نعم، قم بالتحديث"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'post',
                            url: "{{ route('user.order.updateCustomerInfo') }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                            },
                            processData: false,
                            contentType: false,
                            data: formData,
                            success: function(data) {
                                Swal.fire({
                                    position: "top-end",
                                    icon: "success",
                                    title: "تمت عملية التحديث بنجاح",
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                                console.log('suc: ' + data);
                            },
                            error: function(reject) {
                                //لوب لعرض الاخطاء في الحقول في حال كان هناك خطاء ب سبب التحقق
                                var response = $.parseJSON(reject.responseText);
                                $.each(response.errors, function(key, val) {
                                    $("#" + key + "_error").text(val[0]);
                                });
                                Swal.fire({
                                    position: "top-end",
                                    icon: "error",
                                    title: "فشلت عملية التحديث",
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        });
                    }
                });



            });

            //حذف منتج من تفاصيل المنتجات
            $(document).on('click', '.delete_btn', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "هل انت متأكد ؟",
                    text: "لن تتمكن من التراجع عن هذا",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "تراجع",
                    confirmButtonText: "نعم، احذفه"
                }).then((result) => {
                    if (result.isConfirmed) {
                        var order_details_id = $(this).attr('data-order_details_id');
                        var payment_status = $(this).attr('data-payment_status');
                        $.ajax({
                            type: 'post',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                            },
                            url: "{{ route('user.order.details.destroy') }}",
                            data: {
                                'id': order_details_id,
                                'payment_status': payment_status,
                            },
                            success: function(data) { //تحديث الصفحة باكملها
                                Swal.fire({
                                    title: "تم الحذف ",
                                    text: "لقد تم حذف الطلب بنجاح",
                                    icon: "success"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    title: "فشلت عملية الحذف",
                                    text: xhr.responseJSON.error,
                                    icon: "error"
                                });

                            }
                        });

                    }
                });
            });
        });
    </script>
@endpush
