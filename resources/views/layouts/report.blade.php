@extends('layouts.app')


@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css') }}">
    <!-- Custom CSS -->
    <link href="{{ asset('assets/dist/css/style.min.css') }}" rel="stylesheet">
    <style>
        table th {
            text-align: center;
            vertical-align: middle !important;
        }
    </style>
    
    {{-- Datatable RTL --}}
    @if(app()->getLocale() === 'ar')
        <style>
            div.dataTables_wrapper {
                direction: rtl;
            }
        </style>
    @endif

    {{-- Datepicker --}}
    <link href="{{ asset('assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@endsection

@section('body-class', 'skin-default fixed-layout')

@section('content')
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">UNICEF Egypt</p>
        </div>
    </div>
@endsection

@section('javascript')
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('assets/node_modules/jquery/jquery-3.2.1.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('assets/node_modules/popper/popper.min.js') }}"></script>
    <script src="{{ asset('assets/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ asset('assets/dist/js/perfect-scrollbar.jquery.min.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('assets/dist/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('assets/dist/js/sidebarmenu.js') }}"></script>
    <!--stickey kit -->
    <script src="{{ asset('assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
    <script src="{{ asset('assets/node_modules/sparkline/jquery.sparkline.min.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('assets/dist/js/custom.min.js') }}"></script>
    {{-- Datepicker --}}
    <script type="text/javascript" src="{{ asset('assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <!-- This is data table -->
    <script type="text/javascript" src="{{ asset('assets/node_modules/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/node_modules/moment/moment.min.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('assets/node_modules/datatables.net_plugins/range_dates.js') }}"></script> --}}
    <script type="text/javascript" src="{{ asset('assets/node_modules/datatables.net_plugins/datetime.js') }}"></script>
    {{-- Export to Excel --}}
    <script type="text/javascript" src="{{ asset('assets/node_modules/sheetjs/xlsx.full.min.js') }}"></script>
    <!-- END - This is for export functionality only --> 

    {{-- Declare function --}}
    <script>
        function getPrintableTable() {
            const customTable = document.createElement('table');
            customTable.setAttribute('id', 'reports-table');

            customTable.innerHTML = `
                <table id="reports-table"
                    class="display table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="3">@lang('ID')</th>
                            <th rowspan="3">@lang('Governorate')</th>
                            <th colspan="6">@lang('Kids under 15 years old')</th>
                            <th rowspan="3">@lang('Total kids visits')</th>
                            <th colspan="4">@lang('Females above 15 years old')</th>
                            <th rowspan="3">@lang('Total kids and women visits')</th>
                            <th rowspan="3">@lang('Total males above 15 years old visits')</th>
                            <th rowspan="3">@lang('Total all visits')</th>
                            <th rowspan="3">@lang('Date')</th>
                        </tr>
                        <tr>
                            <th colspan="2">@lang('Males')</th>
                            <th colspan="2">@lang('Females')</th>
                            <th colspan="2">@lang('Total')</th>
                            <th rowspan="2">@lang('Pregnancy visits')</th>
                            <th rowspan="2">@lang('Endangered pregnancies')</th>
                            <th rowspan="2">@lang('Other visits')</th>
                            <th rowspan="2">@lang('Total visits')</th>
                        </tr>
                        <tr>
                            <th>@lang('Under 5 years old')</th>
                            <th>@lang('From 5 to 15 years old')</th>
                            <th>@lang('Under 5 years old')</th>
                            <th>@lang('From 5 to 15 years old')</th>
                            <th>@lang('Under 5 years old')</th>
                            <th>@lang('From 5 to 15 years old')</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            `;
            for (let index = 0; index < table.rows({page: 'current'}).nodes().length; index++) {
                let elementCopy = table.rows({page: 'current'}).nodes()[index].cloneNode(true);
                customTable.getElementsByTagName('tbody')[0].appendChild(elementCopy);
            }
            
            return customTable;
        }
    </script>

    {{-- Datatable and Datepicker --}}
    <script>
        let table;

        $(document).ready(function() {
            // Initiate DataTable
            table = $('#reports-table').DataTable({
                ajax: {
                    url: "@yield('api-url')",
                    type: "GET",
                    beforeSend: (request) => {
                        request.setRequestHeader("Content-Language", "{{ app()->getLocale() }}");
                    }
                },
                columns: [
                    { data: "id" },
                    { data: "@yield('table-col')" },
                    { data: "males_under_5" },
                    { data: "males_from_5_to_15" },
                    { data: "females_under_5" },
                    { data: "females_from_5_to_15" },
                    { data: "total_under_5" },
                    { data: "total_from_5_to_15" },
                    { data: "total_kids_visits" },
                    { data: "pregnancy_visits" },
                    { data: "endangered_pregnancies" },
                    { data: "other_visits" },
                    { data: "total_women_visits" },
                    { data: "total_women_and_kids_visits" },
                    { data: "males_above_15_visits" },
                    { data: "total_visits" },
                    { data: "date" }
                ],
                columnDefs: [
                    {
                        targets: 16,
                        render: $.fn.dataTable.render.moment("YYYY-MM-DD", "MM-YYYY")
                    }
                ],
                order: [[ 16, "desc" ]],
                dom: 'Bfrtip',
                scrollX: true,
                @if(app()->getLocale() === 'ar')
                    language: {
                        url: "{{ asset('assets/node_modules/datatables.net_plugins/Arabic.json') }}" // Arabic localization
                    },
                    fixedColumns: true // Use for RTL
                @endif
            });

                
            // Create datepickers inputs
            $('#reports-table_filter').ready(function () {
                $('#reports-table_filter').append(`
                    <div style="float: left">
                        <div>
                            <label for="fini">@lang('From:')</label>
                            <input type="text" id="fini">
                        </div>
                        <div>
                            <label for="ffin" style="margin-right: 19px">@lang('To:')</label>
                            <input type="text" id="ffin">
                        </div>
                    </div>
                `);

                $('.dataTables_filter').css({'text-align': 'none'});

                $('.dataTables_filter').css({'float': 'none'});

                @if(app()->getLocale() === 'ar')
                    $('#ffin').prev().css({'margin-right': 0});
                @endif

                // Initiating datepicker
                const startDate = $('#fini');
                startDate.datepicker({
                    format: "mm-yyyy",
                    startView: 1,
                    minViewMode: 1,
                    todayBtn: "linked",
                    autoclose: true,
                    todayHighlight: true,
                }).on('changeDate', (e) => {
                        table.draw();
                    });
                startDate.datepicker('setDate', moment().startOf('year').format('MM-YYYY'));

                const endDate = $('#ffin');
                endDate.datepicker({
                    format: "mm-yyyy",
                    startView: 1,
                    minViewMode: 1,
                    todayBtn: "linked",
                    autoclose: true,
                    todayHighlight: true,
                }).on('changeDate', (e) => {
                        table.draw();
                    });
                endDate.datepicker('setDate', moment().format('MM-YYYY'));

                // Importing range_dates.js to sort table by date input
                $.getScript("{{ asset('assets/node_modules/datatables.net_plugins/range_dates.js') }}");
            })

            // Print button
            $('#print-table-btn').on('click', () => {
                const customTable = window.open();
                customTable.document.write(`
                    <div class="table-responsive m-t-40 dataTables_wrapper">
                        <table id="reports-table"
                            class="display table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th rowspan="3">@lang('ID')</th>
                                    @yield('table-head')
                                    <th colspan="6">@lang('Kids under 15 years old')</th>
                                    <th rowspan="3">@lang('Total kids visits')</th>
                                    <th colspan="4">@lang('Females above 15 years old')</th>
                                    <th rowspan="3">@lang('Total kids and women visits')</th>
                                    <th rowspan="3">@lang('Total males above 15 years old visits')</th>
                                    <th rowspan="3">@lang('Total all visits')</th>
                                    <th rowspan="3">@lang('Date')</th>
                                </tr>
                                <tr>
                                    <th colspan="2">@lang('Males')</th>
                                    <th colspan="2">@lang('Females')</th>
                                    <th colspan="2">@lang('Total')</th>
                                    <th rowspan="2">@lang('Pregnancy visits')</th>
                                    <th rowspan="2">@lang('Endangered pregnancies')</th>
                                    <th rowspan="2">@lang('Other visits')</th>
                                    <th rowspan="2">@lang('Total visits')</th>
                                </tr>
                                <tr>
                                    <th>@lang('Under 5 years old')</th>
                                    <th>@lang('From 5 to 15 years old')</th>
                                    <th>@lang('Under 5 years old')</th>
                                    <th>@lang('From 5 to 15 years old')</th>
                                    <th>@lang('Under 5 years old')</th>
                                    <th>@lang('From 5 to 15 years old')</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                `);

                for (let index = 0; index < table.rows({page: 'current'}).nodes().length; index++) {
                    let elementCopy = table.rows({page: 'current'}).nodes()[index].cloneNode(true);
                    customTable.document.getElementsByTagName('tbody')[0].appendChild(elementCopy);
                }

                $("link, style").each(function() {
                    $(customTable.document.head)
                        .append($(this).clone())
                        .append(`
                            <style type="text/css" media="print">
                                @page { size: landscape; }
                            </style>
                        `);
                }).ready(() => {
                    customTable.focus();
                    $(customTable.document).ready(() => {
                        customTable.print();
                        customTable.close();
                    });
                });

            })

            $('#export-table-btn').on('click', () => {
                const wb = XLSX.utils.table_to_book(getPrintableTable(), {sheet: "Sheet 1"});

                XLSX.writeFile(wb, 'report.xlsx');
            })
        });
    </script>
@endsection