@extends('Admin.layouts.main')

@section('pageTitle')
    عرض مرتجع الفواتير
@endsection

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Add your custom CSS styles here */
        .custom-add-button {
            /* Add styles for the custom add button if needed */
        }

        /* Responsive styles */
        @media (max-width: 767px) {
            /* Add styles for mobile devices here */
            .custom-add-button {
                /* Add styles for the custom add button on mobile devices if needed */
            }
        }
    </style>
@endsection

@section('Content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>عرض مرتجع الفواتير</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">الرئيسية</a></li>
                    <li class="breadcrumb-item">الجداول</li>
                    <li class="breadcrumb-item active">البيانات</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <p></p>

                            <div class="table-responsive">
                                <!-- جدول بصفوف مخططة -->
                                <table id="Return_Management" class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>الرقم التعريفي</th>
                                        <th>رقم الفاتورة</th>
                                        <th>تاريخ الارجاع</th>
                                        <th>الكمية المرتجعة</th>
                                        <th>المبلغ المرتجع</th>
                                        <th>تاريخ الانشاء</th>
                                        <th>العملية</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <!-- نهاية الجدول بصفوف مخططة -->
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- نهاية #main -->
@endsection

@section('js')
    <script type="text/javascript">
        $(function() {

            var return_data = $('#Return_Management').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [0, "desc"]
                ],
                ajax: "{{ route('admin.purchaseReturn_management.data') }}", // يجب استبدال هذا بالمسار الصحيح للبيانات المطلوبة
                dom: 'Bfrltip',
                buttons: [{
                    text: 'إضافة',
                    className: 'custom-add-button',
                    action: function(e, dt, node, config) {
                        window.location.href = "{{ route('admin.purchase.purchase_management') }}"; // تحويل الى صفحة الإضافة
                    }
                },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5] // تحديد الأعمدة التي يجب تصديرها إلى ملف PDF
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5] // تحديد الأعمدة التي يجب تصديرها إلى ملف CSV
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5] // تحديد الأعمدة التي يجب تصديرها إلى ملف Excel
                        }
                    }, {
                        extend: 'print',
                        autoPrint: false,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5] // تحديد الأعمدة التي يجب تصديرها إلى الطباعة
                        }
                    }
                ],
                columns: [
                    {
                        // الرقم التعريفي
                        data: 'return_id',
                        name: 'return_id'
                    },
                    {
                        // رقم الفاتورة
                        data: 'purchase_details_id',
                        name: 'purchase_details_id'
                    },
                    {
                        // تاريخ الارجاع
                        data: 'return_date',
                        name: 'return_date'
                    },
                    {
                        // الكمية المرتجعة
                        data: 'quantity_returned',
                        name: 'quantity_returned'
                    },
                    {
                        // المبلغ المرتجع
                        data: 'amount_returned',
                        name: 'amount_returned'
                    },
                    {
                        // تاريخ الإنشاء
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, full, meta) {
                            return moment(data).format('YYYY-MM-DD HH:mm:ss');
                        }
                    },
                    {
                        // العملية
                        data: 'action',
                        name: 'action'
                    },
                ]

            });

        });

        $(document).on('click', '.delete_btn', function(e) {
            e.preventDefault();

            var return_id = $(this).data('id');

            Swal.fire({
                title: "هل أنت متأكد؟",
                text: "لن تتمكن من التراجع عن هذا",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "تراجع",
                confirmButtonText: "نعم، احذفه"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        },
                        url: "{{ route('admin.purchaseReturn_management.destroy') }}",
                        data: {
                            'return_id': return_id
                        },
                        success: function(data) {
                            Swal.fire({
                                title: "تم الحذف",
                                text: "تم حذف الملف بنجاح",
                                icon: "success"
                            });
                            $('#Return_Management').DataTable().ajax.reload();
                        },
                        error: function(reject) {
                            var errorMessage = reject.responseJSON && reject.responseJSON.message ? reject.responseJSON.message : 'حدث خطأ أثناء معالجة الاسترجاع.';
                            Swal.fire({
                                title: "خطأ",
                                text: errorMessage,
                                icon: "error"
                            });
                        }
                    });
                }
            });
        });

        // التحقق من حجم الشاشة وتحديد التصميم المناسب
        function checkScreenSize() {
            var screenWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;

            if (screenWidth < 768) {
                // تحديد تصميم للهواتف المحمولة
                // يمكنك إضافة أي تحديدات أو أنماط CSS إضافية هنا
                document.getElementById('main').classList.add('mobile-design');
            } else {
                // تحديد تصميم للأجهزة اللوحية والحواسيب الشخصية
                // يمكنك إضافة أي تحديدات أو أنماط CSS إضافية هنا
                document.getElementById('main').classList.add('desktop-design');
            }
        }

        // تحقق من حجم الشاشة عند تحميل الصفحة
        window.onload = function() {
            checkScreenSize();
        };

        // تحقق من حجم الشاشة عند تغيير حجم النافذة
        window.onresize = function() {
            checkScreenSize();
        }

    </script>
@endsection
