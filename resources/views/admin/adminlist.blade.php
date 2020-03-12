@extends('cms1')

@section('content')
    <div class="container" style="margin-top: 60px;">
        <div class="row" style="margin-left: 0px;padding-left: 80px;"> 
        <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class='fa fa-envelope-o' style="font-size: larger"></i> List Member</div>
                    <div class="panel-body">
                        @if (session('suc'))
                            <div style="text-align: center" class="alert alert-success">
                                <strong>Sukses Menambahkan Admin Baru</strong>
                            </div>
                        @endif
                        <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog" style="position: absolute; margin-left: -200px;">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">Konfirmasi Penghapusan</h4>
                                    </div>

                                    <div class="modal-body">
                                        <p>Anda akan menghapus Listing Email, aksi ini tidak dapat dibatalkan.</p>
                                        <p>Apakah anda yakin ingin melanjutkan?</p>
                                    </div>

                                    <div class="modal-footer">
                                        <a class="btn btn-danger btn-ok"><i class="fa fa-times"></i> Delete</a>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form method="get" action="adminlist" style="margin-bottom:0px">
                            <div class="form-group input-group">
                                <input type='text' name='KEY' class='form-control' placeholder='Cari Berdasarkan Email...'/>
                                <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit">
                                    Cari
                                </button>
                                </span>
                            </div>
                        </form>
                        <div class="col-xs-12" style="overflow:auto; padding-left:0px">
						<table class="table table-responsive">
                            <tr style="text-align: center">
                                <th class="1">
                                    No
                                </th>
                                <th class="2">
                                    Kode Cabang
                                </th>
                                <th class="7">
                                    Email
                                </th>
                                <th class="7">
                                    Nama
                                </th>
                                <th class="2">
                                    Aksi
                                </th>
                            </tr>
                            <?php
                            $sindex = 0;
                            if(isset($_GET['ORD'])){
                                if($_GET['ORD'] != "" && $_GET['ORD'] != null){
                                    $rpp = $_GET['ORD'];
                                }else{
                                    $rpp = 10;
                                }
                            }else{
                                $rpp = 10;
                            }
                            ?>
                            @foreach($admin as $index => $row)
                            <tr>
                                <td>
                                    <?php
                                    if(isset($_GET['page'])){
                                        if($_GET['page'] > 1){
                                            $sindex = $rpp * $_GET['page'] - $rpp;
                                        }
                                    }
                                    ?>
                                    <b>{{ $index + $sindex + 1 }}</b>
                                </td>
                                <td>
                                    {{ $row['branch_code'] }}
                                </td>
                                <td>
                                    {{ $row['email'] }}
                                </td>
                                <td>
                                    {{ $row['name'] }}
                                </td>
                                <td>
                                    <a href="#" class="btn btn-danger btn-xs"  data-toggle="modal" data-target="#confirm-delete" data-href="deleteadmin?id={{ $row['id'] }}"><i class='fa fa-times'></i> Delete </a>
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="8" style="text-align: center">{!! str_replace('/?', '?', $admin->appends(Input::except('page'))->render()) !!}</td>
                            </tr>
                        </table>
						</div>
                        <div style="text-align: center; margin-top:10px">
                            {{--<a class='btn btn-success' href="registeradmin"><i style='color:white' class='fa fa-plus'></i> Buat Admin Baru</a>--}}
                            <a class='btn btn-primary' href="dashboard"><i style='color:white' class='fa fa-dashboard'></i> Kembali ke Dashboard</a> 
                        </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('scripts')
    <script>
        $( document ).ready(function() {
            $('#confirm-delete').on('show.bs.modal', function(e) {
                $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
            });
        });
    </script>
@endsection