<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>


        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">

            <table class="table table-striped">
                <thead>
                <tr>
                    <td>ID</td>
                    <td>Segmentación</td>
                    <td>Programa</td>
                    <td>Cumpleaños</td>
                    <td>Creado</td>
                    <td colspan = 2>Actions</td>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{$user['id']}}</td>
                        <td>{{$user['segmentation_id']}} </td>
                        <td>{{$user['program_id']}}</td>
                        <td>{{$user['birth_date']}}</td>
                        <td>{{$user['created_at']}}</td>
                        <td>

                            <a
                                href="javascript:void(0)"
                                id="show-user"
                                data-url="{{ route('users.show',['token' => last(request()->segments()),'client_id' => $user['id']]) }}"
                                class="btn btn-info"
                            >Transacciones</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
        <!-- Modal -->
        <div class="modal fade" id="userShowModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Transacciones</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="userTable">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function () {
                $("#userTable").html('');
                $('body').on('click', '#show-user', function () {
                    $("#userTable").html('');
                    var userURL = $(this).data('url');
                    $.getJSON(userURL , function(data) {
                        if(data !== 'El usuario no tiene transacciones.') {
                        var tbl_body = "<table class='table' id='userTable' border='1' style='border-collapse: collapse;'>"+
                        '<thead>'+
                        '<tr>'+
                        '<th>Id</th>'+
                        '<th>Monto</th>'+
                        '<th>Descripción</th>'+
                        '<th>Fecha</th>'+
                        '</tr>'+
                        '</thead>'+
                        '<tbody>';
                        $.each(data, function (index, value) {
                            console.log(value);
                            var tbl_row = "";
                            var myArray = ['id', 'transaction_detail', 'amount', 'created_at'];
                            $.each(value, function (k, v) {
                                if ($.inArray(k, myArray) !== -1) {
                                    tbl_row += "<td>" + v + "</td>";
                                }
                            });
                            tbl_body += "<tr>" + tbl_row + "</tr>";
                        });
                        tbl_body += "</tbody></table>";
                        }else{
                            tbl_body = '<div>'+data+'</div>'
                        }
                        $("#userTable").html(tbl_body);
                        $('#userShowModal').modal('show');
                    });
                });
            });
        </script>
    </body>
</html>
