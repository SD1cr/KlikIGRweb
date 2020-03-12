<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BranchDistrict;
use App\Models\City;
use App\Models\District;
use App\Models\EmailRecv;
use App\Models\Monitoring;
use App\Models\ProductView;
use App\Models\Province;
use App\Models\SubDistrict;
use App\Models\TransactionDownload;
use App\Models\TransactionHeader;
use App\Models\User;
use App\Models\Address;
use App\Models\UserAdmin;
use App\Models\FreeOngkirDetail;
use App\Models\FreeOngkirHeader;
use App\Models\Ongkir;
use App\Models\NotificationContent;
use App\Models\Promotion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\Registrar;

use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel; 

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getMember(Request $Request){
        $htmlFormat="";
        $typeFormat="";
        $cabangAssoc = Branch::getAllBranches();

        $type = \DB::table('types')->get();

        foreach ($type as $index => $row) {
            $typeFormat .= "<option style='font-size: 12px;' value='" . $row->id . "'>" . $row->type . "</option>";
        }

        foreach ($cabangAssoc as $index => $row) {
            if($row['kode_igr'] == $Request->cab){
                $htmlFormat .= "<option style='font-size: 12px;' selected value='" . $row['kode_igr'] . "'>" . $row['name'] . "</option>";
            }else{
                $htmlFormat .= "<option style='font-size: 12px;' value='" . $row['kode_igr'] . "'>" . $row['name'] . "</option>";
            }
        }

        return view('admin.member')->with('cab', $htmlFormat)->with('type', $typeFormat);  
    }

    public function getMemberManagement(Request $request){
        if ($request->get('cab') !== "0") {
            $cab = "%{$request->get('cab')}%";
        }else{
            $cab = "%";
        }

        if ($request->get('tipemember') == "x") {
            $tipe = "%";
        }else{
            $tipe = $request->get('tipemember');
        }


        $usrAssoc = User::getAllUsers($cab, $tipe);

        for ($i=0; $i < count($usrAssoc) ; $i++) {
            if($usrAssoc[$i]['type_id'] == 2){
                $usrAssoc[$i]['edit'] = '<button id="btn_edit" type="button" class="btn btn-info" style="width:70px;" value="'.$usrAssoc[$i]['id'].'"> Edit </button>';
            }  
            else{
                $usrAssoc[$i]['edit'] = '<button id="btn_edit" type="button" class="btn btn-success" style="width:70px;" value="'.$usrAssoc[$i]['id'].'">View</button>';
            }
        }


        return \Datatables::of($usrAssoc)->make(true);
    }

    public function getDashboard(Request $Request){

        $status = $Request->get('STDWN'); //KoDe TRaNsaksi
        $kdtran = $Request->get('KDTRN'); //STatus DoWNload
        $htmlFormat="";
        $StatusFormat="";

        $typeFormat="";

        $type = \DB::table('types')->get();

        foreach ($type as $index => $row) {
            $typeFormat .= "<option style='font-size: 12px;' value='" . $row->id . "'>" . $row->type . "</option>";
        }

        $cabangAssoc = Branch::getAllBranches();
        $statuspembayaran = \DB::table('transaction_status')->get();

        foreach ($statuspembayaran as $index => $row) {
            $StatusFormat .= "<option style='font-size: 12px;' value='" . $row->id . "'>" . $row->description . "</option>";
        }

        foreach ($cabangAssoc as $index => $row) {
            if($row['kode_igr'] == $Request->cab){
                $htmlFormat .= "<option style='font-size: 12px;' selected value='" . $row['kode_igr'] . "'>" . $row['name'] . "</option>";
            }else{
                $htmlFormat .= "<option style='font-size: 12px;' value='" . $row['kode_igr'] . "'>" . $row['name'] . "</option>";
            }
        }

        $cab = $Request->get('cab');

        if(!isset($kdtran) || $kdtran == '' || $kdtran == null){
            $kdtran = '%';
        }else{
            try{
                $kdtran = intval(str_replace("TRX", NULL, strtoupper($kdtran)));
                if($kdtran == 0){
                    $kdtran = '%';
                }
            }catch(Exception $e){
                $kdtran = '%';
            }
        }
        if(!isset($status) || $status == '' || $status == null){
            $status = '%';
        }else{
            if($status == "yes"){
                $status = 0;

            }
        }

        $csvAssoc = TransactionDownload::getAllCSV($kdtran, $status, $cab);

        foreach($csvAssoc as $row){
            $tempHead = TransactionHeader::where('kode_transaksi', $row->kode_transaksi)->first();
            $row->kstatus = $tempHead->trstatus;
            $row->pstatus = $tempHead->paystatus;
        }

        $cabang = Branch::getAllFirstBranches($cab);

        if(\Auth::user('users_admin')->role == 2) {
            $status1 = \DB::table('transaction_headers')->whereIn('status_id', [1, 2, 3, 4, 5])->where('kode_cabang',\Auth::user('users_admin')->branch_code)->WhereNotNull('status_id')->Count();
        }else{
            $status1 = \DB::table('transaction_headers')->whereIn('status_id', [1, 2, 3, 4, 5])->where('kode_cabang','LIKE', $cab)->WhereNotNull('status_id')->Count();
        }

        if(\Auth::user('users_admin')->role == 2) {
            $status2 = \DB::table('transaction_headers')->whereIn('status_id', [6, 7, 8])->where('kode_cabang',\Auth::user('users_admin')->branch_code)->WhereNotNull('status_id')->Count();
        }else{
            $status2 = \DB::table('transaction_headers')->whereIn('status_id', [6, 7, 8])->where('kode_cabang','LIKE', $cab)->WhereNotNull('status_id')->Count();
        }

        if(\Auth::user('users_admin')->role == 2) {
            $status3 = \DB::table('transaction_headers')->where('status_id', 9)->where('kode_cabang',\Auth::user('users_admin')->branch_code)->WhereNotNull('status_id')->Count();
        }else{
            $status3 = \DB::table('transaction_headers')->where('status_id', 9)->where('kode_cabang','LIKE', $cab)->WhereNotNull('status_id')->Count();
        }

        
        if(\Auth::user('users_admin')->role == 2) {
            $statusall = \DB::table('transaction_headers')->WhereNotNull('status_id')->where('kode_cabang',\Auth::user('users_admin')->branch_code)->Count();
        }else{
            $statusall = \DB::table('transaction_headers')->WhereNotNull('status_id')->where('kode_cabang', 'LIKE', $cab)->Count();
        }

        $persenstatus1 =0;
        $persenstatus2 =0;
        $persenstatus3 =0;




        if($status1 > 0){
            $persenstatus1 = ($status1/$statusall)*100;
        }

        if($status2 > 0){
            $persenstatus2 = ($status2/$statusall)*100;
        }

        if($status3 > 0){
            $persenstatus3 = ($status3/$statusall)*100;

        }


        return view('admin.dashboard')->with('csv', $csvAssoc)->with('cab', $htmlFormat)->with('persen1', $persenstatus1)->with('persen2', $persenstatus2)->with('persen3', $persenstatus3)->with('statusall', $statusall)->with('cabang', $cabang)->with('status', $StatusFormat)->with('type', $typeFormat);
    }

    public function getViewAdminDashboard(Request $request){

        if ($request->get('cab') !== "0") {
            $cab = "%{$request->get('cab')}%";
        }else{
            $cab = "%";
        }

        if ($request->get('statusdownload') == "x") {
            $status = "%";
        }else{
            $status = $request->get('statusdownload');
        }

        if ($request->get('tipemember') == "x") {
            $tipe = "%";
        }else{
            $tipe = $request->get('tipemember');
        }


        $csvAssoc = TransactionDownload::getAllCSV($status, $cab, $tipe);  

        foreach($csvAssoc as $row){  
            $row->trx .="<strong><span style='min-width: 80px; display: block' class='label label-danger font-12'>TRX" . str_pad($row['kode_transaksi'], 6, '0', STR_PAD_LEFT) . "</span></strong>";
            if($row['status_pbidm'] == 0){
                if ($row->status_download == 0) {
                    $row->action .="" ."<b id='state" . $row['kode_transaksi'] . "' style='color:Salmon'>Belum di Download</b> &nbsp;<button class='btn btn-xs btn-primary' onClick='downloadCSV(". $row['kode_transaksi'] .")'><b style='color:White'> Download</b></button>". "";
                } elseif($row->status_download == 1){
                    $row->action .="" ."<b id='state" . $row['kode_transaksi'] . "' style='color:Salmon'>Sudah di Download</b> &nbsp;<button class='btn btn-xs btn-primary' onClick='downloadCSV(". $row['kode_transaksi'] .")'><b style='color:White'> Download</b></button>". "";
                }
            }else{
                $row->action .=" <td style='vertical-align: middle;text-align:center;'> Proses PB IDM</td>";
            }
        }

        return \Datatables::of($csvAssoc)->make(true);
    }

    public function getViewAdminEmail(Request $request){

        if ($request->get('cab') !== "0") {
            $cab = "%{$request->get('cab')}%";
        }else{
            $cab = "%";
        }

        if(\Auth::user('users_admin')->role == 2) {   
            $emailAssoc = EmailRecv::Where('kode_cabang',\Auth::user('users_admin')->branch_code)->get();
        }else {
            $emailAssoc = EmailRecv::Where('kode_cabang', 'like', '%'. $cab .'%')->get();
        }



        foreach ($emailAssoc as $row) {
            $row->action = "<a href=\"#\" class=\"btn btn-danger btn-xs\"  data-toggle=\"modal\" data-target=\"#confirm-delete\" data-href=\"deletemail?id=" . $row['id'] ."\"><i class='fa fa-times'></i> Delete </a>";
        }
//        return view('admin.email')->with('cabang', $htmlFormat)->with('email', $emailAssoc);

        return \Datatables::of($emailAssoc)->make(true);
    }

    public function getReloadDashboard(Request $request){
        $html = "";
        $cab = $request->get('kode_igr');
        $status = $request->get('STDWN'); //KoDe TRaNsaksi
        $kdtran = $request->get('KDTRN'); //STatus DoWNload

        if(\Auth::user('users_admin')->role == 1 || \Auth::user('users_admin')->role == 3){
            $csvAssoc = TransactionDownload::getAllCSV($kdtran, $status, $cab);
        }
        $html .="<table class='table'>
                                <tr style='text-align: center'>
                                    <th class='font-14'>No</th>
                                    <th class='font-14' style='text-align: center;'>Kode Transaksi</th>
                                    <th class='font-14' style='text-align: center;'>Kode Cabang</th>
                                    <th class='font-14' style='text-align: center;'>Status</th>
                                    <th class='font-14' style='text-align: center;'>Tanggal Transaksi</th>
                                    <th class='font-14' style='text-align: center;'>Status Pengiriman</th>
                                </tr>";

        $no = 1;
        foreach ($csvAssoc as $index => $row) {
            $html .="<tr>";
            $html .=	"<td>".$no."</td>";
            $html .=	" <td style='vertical-align: middle; text-align:center;'>
                                <strong><span style=\"min-width: 80px; display: block\" class=\"label label-danger font-12\">TRX " . str_pad($row['kode_transaksi'], 6, '0', STR_PAD_LEFT) . "</span></strong>
                            </td>";
            $html .=	" <td style='vertical-align: middle; text-align:center;'>" . $row['kode_cabang'] . "</td>";

            $html .=	" <td style='vertical-align: middle;text-align:center;'>";
                                                if($row['status_download'] == 0){
                                                    $html .= "<b id='state" . $row['kode_transaksi'] . "' style='color:Salmon'>Belum di Download</b> &nbsp;<button class='btn btn-xs btn-primary' onClick='downloadCSV(". $row['kode_transaksi'] .")'><b style='color:White'> Download</b></button>";
                                                }elseif($row['status_download'] == 1){
                                                    $html .= "<b id='state" . $row['kode_transaksi'] . "' style='color:Blue'>Sudah di Download</b> &nbsp;<button class='btn btn-xs btn-primary' onClick='downloadCSV(". $row['kode_transaksi'] .")'><b style='color:White'> Download</b></button>";
                                                }
            $html .="</td>";
            $html .=	" <td style='vertical-align: middle; text-align:center;'>" . $row['tgl_transaksi'] . "</td>";
            $html .=	" <td  style='vertical-align: middle; text-align:center;'>
                                                " . $row['description'] . "
                                            </td>";
            $html .="</tr>";
            $html .="</table>";
            $no++;
        }
        $html .= "<tr>";
        $html .=	"<td colspan = '8' style='text-align: center'>" . str_replace('/?', '?', $csvAssoc->render()) . "";
        $html .=	"</td>";
        $html .= "</tr>";
        return $html;
    }

    public function updateStatusKirim(Request $Request){
        $TrId = $Request->get('trid');

        if($TrId != null && $TrId != ''){
            $trhdr = TransactionHeader::where('kode_transaksi', $TrId)->first();
            $trhdr->trstatus = 1;
            $trhdr->save();

            return "OK";
        }else{
            return "NO TRID";
        }
    }

    public function getCSV(Request $Request){
        ini_set('max_execution_time', '-1');

        $kdTran = $Request->get('trid');

        $trAssoc = TransactionDownload::where('kode_transaksi', $kdTran)->first();
        $fileDir = "../resources/assets/csv/";
        $fileName = $fileDir . $trAssoc->nama_file;

        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: text/x-csv");
        readfile($fileName);
        echo "!@#$%";
        echo $trAssoc->nama_file;

        $trAssoc->status_download = 1;
        $trAssoc->save();
    }

    public function getCSVZipRange(Request $Request)
    {
//        //TODO: Finish This
//        $tgl_awal = $Request->input('start');
//        $tgl_akhir = $Request->input('end');
//
//        $csvAssoc = TransactionDownload::where('created_at', '>=', $tgl_awal)->where('created_at', '<=', $tgl_akhir)->where('kode_cabang', \Auth::cabang())->get();
//
//        $files = array();
//        $path = url('../resources/assets/zip') . "/";
//        foreach ($csvAssoc as $row) {
//            array_push($files, url('../resources/assets/csv') . "/" . $row->nama_file);
//        }
//
//        if($files) {
//            @unlink($path . 'data.zip');
//            $zipper = new \Chumper\Zipper\Zipper;
//            $zipper->make($path . 'data.zip')->add($files)->close();
//            if (file_exists($path . 'data.zip')) {
//                return \Response::download(
//                    $path . 'data.zip',
//                    'PB_' . date("dmY", strtotime($tgl_awal)) . '_' . date("dmy", strtotime($tgl_akhir)) . '.zip'
//                );
//            } else {
//                return redirect('dashboard')->with('errz', 'Tidak Ada Zip Untuk di Download');
//            }
//        } else {
//            return redirect('dashboard')->with('errz', 'Tidak Ada Data Untuk di Download');
//        }
    }

    public function forceDown(Request $Request){     
        ini_set('max_execution_time', '-1');

        if($Request->get('named')){
            $name = $Request->get('named');
        }else{
            $name = "PB_.csv";
        }

        $check = TransactionDownload::where('nama_file', $name)->first();
        if ($check === null) {
            return redirect('dashboard');
        }else{
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Content-Type: text/x-csv");
            header("Content-Disposition: attachment;filename=\"" . $name . "\"");

            if($Request->get('data')){
                print $Request->get('data');
            }
        }
    }

    public function getEmailList(Request $Request){
        $htmlFormat="";

        $cabangAssoc = Branch::getAllBranches();

        foreach ($cabangAssoc as $index => $row) {
            if($row['kode_igr'] == $Request->cab){
                $htmlFormat .= "<option style='font-size: 12px;' selected value='" . $row['kode_igr'] . "'>" . $row['name'] . "</option>";
            }else{
                $htmlFormat .= "<option style='font-size: 12px;' value='" . $row['kode_igr'] . "'>" . $row['name'] . "</option>";
            }
        }

        return view('admin.email')->with('cab', $htmlFormat);
    }

    public function getEmailCreatePage(){
        $htmlFormat = "";
        if(\Auth::user('users_admin')->role == 1){
            $cabangAssoc = Branch::getAllBranches();
        }else{
            $cabangAssoc = Branch::where('kode_igr', \Auth::user('users_admin')->branch_code)->get();
        }
        foreach ($cabangAssoc as $index => $row) {
            $htmlFormat .= "<option style='font-size: 12px;' value='" . $row['kode_igr'] . "'>" . $row['name'] . "</option>";
        }

        return view('admin.emailcreate')->with('cabang', $htmlFormat);
    }

    public function countMail($cab){
        $max = 3;
        $count = EmailRecv::where('kode_cabang', $cab)->count();
        if($count < $max){
            return true;
        }else{
            return false;
        }
    }

    public function createMail(Request $Request){
        $reg = new Registrar();

        $validator = $reg->validateNewEmailList($Request->all());

        if ($validator->fails())
        {
            $this->throwValidationException(
                $Request, $validator
            );
        }

        $email = $Request->get('Email');
        if(\Auth::user('users_admin')->role == 1){
            $kdcab = $Request->get('KodeCabang');
        }else{
            $kdcab = \Auth::user('users_admin')->branch_code;
        }

        if($this->countMail($kdcab) === true){
            $newMail = new EmailRecv();
            $newMail->email = $email;
            $newMail->kode_cabang = $kdcab;
            $newMail->save();
        }else{
            return redirect('emails')->with('maxeml', 'TES');
        }

        return redirect('emails')->with('suc', 'TES');
    }

    public function deleteMail(Request $Request){
        $toBeDeleted = EmailRecv::find($Request->get('id'));
        $toBeDeleted->delete();

        return redirect('emails');
    }

    public function DeleteOngkirAjax(Request $Request){ 

        $id = $Request->id;

        $toBeDeleted = Ongkir::find($id);
        $toBeDeleted->delete();

        return "true";
    }

    public function getRealisasi(Request $Request){
        $htmlFormat = "";
        $typeFormat = "";

        $type = \DB::table('types')->get();

        foreach ($type as $index => $row) { 
            $typeFormat .= "<option style='font-size: 12px;' value='" . $row->id . "'>" . $row->type . "</option>";
        }

        if(\Auth::user('users_admin')->role == 1){
            $cabangAssoc = Branch::getAllBranches();
        }else{
            $cabangAssoc = Branch::where('kode_igr', \Auth::user('users_admin')->branch_code)->Where('kode_igr','<>', '00')->get();
        }
        foreach ($cabangAssoc as $index => $row) {
            $htmlFormat .= "<option style='font-size: 12px;' value='" . $row['kode_igr'] . "'>" . $row['name'] . "</option>";
        }

        return view('admin.realisasi')->with('cabang', $htmlFormat)->with('type', $typeFormat);
    }

    public function getTransactionRealisasi(Request $Request){
        ini_set('max_execution_time', '-1');  
        $awal = $Request->get('start');
        $akhir = $Request->get('end');
        $typemember = $Request->get('tipemember');

        $cab = $Request->get('KodeCabang');


        $PBHdrAssoc = TransactionHeader::Distinct()
            ->SelectRaw('CASE WHEN kodemember IS NULL THEN customers.kode_member ELSE members.kodemember END as kode_member, type_id, nama, transaction_headers.kode_transaksi , transaction_headers.created_at as createdat, tgl_picking, shipping_address, customer_id, nama_file, date_format(tgl_transaksi, \'%m/%Y\')as tgltrans')
            ->leftJoin('members', 'transaction_headers.userid', '=', 'members.id')
            ->leftjoin('types', 'members.type_id','=','types.id')   
            ->leftjoin('customers', 'customers.id', '=', 'members.customer_id')
            ->leftJoin('transaction_downloads', 'transaction_headers.kode_transaksi', '=', 'transaction_downloads.kode_transaksi');
        if(\Auth::user('users_admin')->role == 2) {
            $PBHdrAssoc ->Where('transaction_downloads.kode_cabang', \Auth::user('users_admin')->branch_code);
        }else {
            $PBHdrAssoc ->Where('transaction_downloads.kode_cabang', 'LIKE', $cab);
        }
        $PBHdrAssoc->whereBetween('transaction_headers.tgl_transaksi', [$awal, $akhir]);

        if($Request->get('tipestatus') == "x") {
            $PBHdrAssoc->Where('status_id', 'LIKE', '%');
        }elseif($Request->get('tipestatus') == "y"){
            $PBHdrAssoc->Where('status_id', '<>', 9);
        }else{
            $PBHdrAssoc->Where('status_id', "=", 9);
        }
        $PBHdrAssoc = $PBHdrAssoc->Where('types.id','LIKE',$typemember)         
            ->Get();

        $cFormatRaw = "<div class='table-responsive'>
               <table class='table' border='!'>";
        $cFormatRaw .= "<tr><td colspan='9' style='text-align: center;'>Laporan Sales Bulanan Realisasi</td></tr>";
        $cFormatRaw .= "<tr><td colspan='9' style='text-align: center;margin-top: 30px;'>Periode : $awal s/d $akhir</td></tr></br>";

        $tot = 0;
        $totreal = 0;
        $count = 0;
//        $cFormatRaw = "";

        foreach ($PBHdrAssoc as $cIdx => $dRow) {

            $typeuserid = $dRow['type_id'];

            $tgltrans =  $dRow['tgltrans'];

            $notransaksi =  $dRow['kode_transaksi'];

            if($typeuserid == 1){
                $noPb = str_pad($notransaksi, 6, '0', STR_PAD_LEFT) . '/cor/' . $tgltrans;
            }else{
                $noPb = str_pad($notransaksi, 6, '0', STR_PAD_LEFT) . '/odr/' . $tgltrans;
            }

            $cFormatRaw .= "<tr><td colspan='9' style='vertical-align: middle;'></td></tr>";
            $cFormatRaw .= "<tr class='warning'>
                                <td class='font-14' style='text-align: left'>
                                    <b>No Pemesanan : </b>
                                </td>
                                <td class='font-14' style='text-align: left'>
                                     $noPb
                                </td>
                            </tr>";

            $cFormatRaw .= "<tr class='warning'>
                                <td class='font-14' style='text-align: left'>
                                    <b>Tanggal Pemesanan : </b>
                                </td>
                                <td class='font-14' style='text-align: left'>
                                      " .$dRow['createdat'] . "
                                </td>
                            </tr>";

            $cFormatRaw .= "<tr class='warning'>
                                <td class='font-14' style='text-align: left'>
                                    <b>Tanggal picking : </b>
                                </td>
                                <td class='font-14' style='text-align: left'>
                                      " .$dRow['tgl_picking'] . "
                                </td>
                            </tr>";


            $cFormatRaw .= "<tr class='warning'>
                                <td class='font-14' style='text-align: left'>
                                    <b>Kode Member : </b>
                                </td>
                                <td class='font-14' style='text-align: left'>
                                      " .$dRow['kode_member'] . "
                                </td>
                            </tr>";

            $cFormatRaw .= "<tr class='warning'>
                                <td class='font-14'style='text-align: left'>
                                    <b>Nama Member : </b>
                                </td>
                                <td class='font-14' style='text-align: left'>
                                       " .$dRow['nama'] . "
                                </td>
                            </tr>";

            $cFormatRaw .= "<tr class='warning'>
                                <td class='font-14' style='text-align: left'>
                                    <b>Alamat Kirim : </b>
                                </td>
                                <td class='font-14' style='text-align: left'>
                                     " .$dRow['shipping_address'] . "
                                </td>
                            </tr>";

            $PBDtlAssoc = TransactionHeader::getPBDetail($dRow['kode_transaksi']);

            $cFormatRaw .= "<tr class='info'>
                               <th class='font-15'>No.</th>

                               <th class='font-15'>Kode PLU</th>
                               <th class='font-15'>Desc</th>
                               <th class='font-15'>Qty Pesanan</th>
                               <th class='font-15'>Jumlah Rp</th>
                               <th class='font-15'>Qty Realisasi</th>
                               <th class='font-15'>Jumlah Rp</th>
                           </tr>";

            foreach ($PBDtlAssoc as $cIdx => $cRow) {
                $count++;
                $totreal = $cRow['qty_realisasi'] * $cRow['harga'];
                $tot = $cRow['qty'] * $cRow['harga'];
                $cFormatRaw .= "<tr>
                   <td style='vertical-align: middle;'>$count</td>
                   <td style='vertical-align: middle;'>" . $cRow['PLU'] . "</td>
                    <td style='vertical-align: middle;'>" . $cRow['PRD_DESKRIPSIPANJANG'] . "</td>  
                    <td style='vertical-align: middle;'>" . $cRow['qty'] . "</td>
                   <td style='vertical-align: middle;'>" . $tot . "</td>
                    <td style='vertical-align: middle;'>" . $cRow['qty_realisasi'] . "</td>
                   <td style='vertical-align: middle;'>" . $totreal . "</td>
                   </tr>";
            }

        }
        $cFormatRaw .= "</table></div>";

        return Excel::create('Laporan Sales Bulanan Realisasi', function($excel) use ($cFormatRaw) {

            $excel->sheet('mySheet', function($sheet) use ($cFormatRaw)
            {
                $sheet->loadView('admin.realisasiview')->with('mesah', $cFormatRaw);

            });
        })->download('xls');

    }

//Admin Create Member
    public function registerAdmin(){
        $userFormat = "";
        $htmlFormat = "";
        if(\Auth::user('users_admin')->role == 1){
            $cabangAssoc = Branch::getAllBranches();
            foreach ($cabangAssoc as $index => $row) {
                $htmlFormat .= "<option style='font-size: 12px;' value='" . $row['kode_igr'] . "'>" . $row['name'] . "</option>";
            }
        }elseif(\Auth::user('users_admin')->role == 2){
            $cabangAssoc = Branch::where('kode_igr', \Auth::user('users_admin')->branch_code)->get();
            foreach ($cabangAssoc as $index => $row) {
                $htmlFormat .= "<option style='font-size: 12px;' value='" . $row['kode_igr'] . "'>" . $row['name'] . "</option>";
            }
        }

        return view('admin.registeradmin')->with('cabangOpt', $htmlFormat);
    }

    public function createAdmin(Request $Request){
        $reg = new Registrar();

        $validator = $reg->validateNewEmailList($Request->all());

        if ($validator->fails())
        {
            $this->throwValidationException(
                $Request, $validator
            );
        }
        $date = new \DateTime;
        $email = $Request->get('Email');
        $name = $Request->get('Name');
        $role = $Request->get('rolestatus');
        if(\Auth::user('users_admin')->role == 1){
            $kdcab = $Request->get('KodeCabang');
        }else{
            $kdcab = \Auth::user('users_admin')->branch_code;
        }

        $newAdm = new UserAdmin();
        $newAdm->email = $email;
        $newAdm->name = $name;
        $newAdm->password = bcrypt($Request->get('Password'));
        $newAdm->branch_code = $kdcab;
        $newAdm->role = $role;
        $newAdm->created_at = $date;
        $newAdm->updated_at = $date;
        $newAdm->active = 1;
        $newAdm->save();

        return redirect('adminlist')->with('suc', 'TES');
    }

    public function deleteAdmin(Request $Request){
        $toBeDeleted = UserAdmin::find($Request->get('id'));
        $toBeDeleted->delete();

        return redirect('adminlist');
    }

    public function getAdminList(){
        if(!isset($_GET['KEY']) || $_GET['KEY'] == '' || $_GET['KEY'] == null){
            $key = '%';
        }else{
            $key = $_GET['KEY'];
        }

        $htmlFormat = "";
        if(\Auth::user('users_admin')->role == 1){
            $emailAssoc = UserAdmin::Where('email', 'LIKE', '%'. $key .'%')->Paginate(10);
        }else{
            $emailAssoc = UserAdmin::Where('branch_code', \Auth::user('users_admin')->branch_code)->Where('email', 'LIKE', '%'. $key .'%')->Paginate(10);
        }

        return view('admin.adminlist')->with('admin', $emailAssoc);
    }

    public function getKodeMember(Request $Request){
        if(!isset($_GET['KEY']) || $_GET['KEY'] == '' || $_GET['KEY'] == null){
            $key = '%';
        }else{
            $key = $_GET['KEY'];
        }

        if(\Auth::user('users_admin')->role == 1){
            $kdCabang = '%';
        }else{
            $kdCabang = Branch::where('kode_igr', \Auth::user('users_admin')->branch_code)->Where('kode_igr','<>', '00')->pluck('kode_igr');
        }

//        $usrAssoc = \DB::Table('customers')->Distinct()
//            ->Where('kode_igr', 'LIKE', $kdCabang);
//        if(\Auth::user('users_admin')->role == 2) {
//            $usrAssoc ->Where('kode_igr', \Auth::user('users_admin')->branch_code);
//        }else {
//            $usrAssoc ->Where('kode_igr', 'LIKE', $kdCabang);
//        }
//        $usrAssoc = $usrAssoc->Where('flag_membermerah', '=', 'Y')
//            ->whereRaw('(kode_member LIKE "%' . $key . '%" OR name LIKE "%' . $key . '%")')
//            ->take(10)->get();

        if($key == "%" ){
            $usrAssoc = \DB::Table('customers')->Distinct()
                ->Where('kode_igr', 'LIKE', $kdCabang)
                ->take(20)->get();
        }else{
            $usrAssoc = \DB::Table('customers')->Distinct()
                ->Where('kode_igr', 'LIKE', $kdCabang)
                ->whereRaw('(kode_member LIKE "%' . $key . '%" OR name LIKE "%' . $key . '%")')
                ->Paginate(20);
        }

        $htmlFormat = "
        <div class=\"panel panel-default\">
                    <div class=\"panel-heading\"><i style='font-size: larger;' class='fa fa-user'></i> List Member</div>
                    <div class=\"panel-body\">

                        <div class=\"form-group input-group\">
                            <input type='text' id='KODEKEY' class='form-control' placeholder='Cari Berdasarkan Nama / User ID...'/>
                        <span class=\"input-group-btn\">
                        <button onClick='searching()' class=\"btn btn-primary\" type=\"submit\">
                            Cari
                        </button>
                        </span>
                        </div>
                        <table width=\"100%\" id=\"srchMTable\" class=\"table table-striped table-condensed table-responsive\">
                            <tr style='text-align: center'>
                                <th style='text-align: center;'>
                                    No
                                </th>
                                <th style='text-align: center;'>
                                    Kode Cabang
                                </th>
                                <th style='text-align: center;'>
                                    Nama Member
                                </th>
                                <th style='text-align: center;'>
                                    Kode Member
                                </th>
                                <th style='text-align: center;'>
                                    Aksi
                                </th>
                            </tr>
        ";
        $sindex = 0;
        foreach ($usrAssoc as $index => $row) {
            $sindex++;
            $htmlFormat .= "
                <tr class='memberRow'>
                    <td style='vertical-align: middle;'>
                        <b>" . $sindex ."</b>
                    </td>
                    <td style='vertical-align: middle;'>
                        " . $row->kode_igr ."
                    </td>
                    <td style='vertical-align: middle;'>
                        " . $row->name ."
                    </td>
                    <td style='vertical-align: middle;'>
                        " . $row->kode_member ."
                    </td>
                     <td>
                        <button class='btn btn-success' onClick=\"sendKd('" . $row->kode_member . "')\"><i style='color:white'></i> Pilih</button>
                    </td>
                </tr>
            ";
        }
        $htmlFormat .= "</table>
                        <div style=\"text-align: center\">
                            <a data-dismiss=\"modal\" class='btn btn-primary'></i> Tutup</a>
                        </div>
                    </div>
                </div>
                 </div>
        ";
        return $htmlFormat;
        //return view('admin.kodemember')->with('kodemember', $usrAssoc);
    }

    public function registerMemberMerah(){
        $userFormat = "";
        $htmlFormat = "";

//        if(\Auth::role() == 'SYSTEM'){
        $provFormat="";
        $citFormat="";
        $disFormat="";
        $BranchFormat="";
        $SubDistrictFormat="";
        $Province = Province::getAllProvince();
        $Cities = City::getCityByProv("%");
        $District = District::getDistrictByCity("%");
        $BranchDistrict = BranchDistrict::getDistrictByBranch("%");
        $SubDistrict = SubDistrict::getSubDistrictByDistrict("%");

        $cabFormat = "";

        if(\Auth::user('users_admin')->role == 1){
            $cabangAssoc = Branch::getAllBranches();
        }else{
            $cabangAssoc = Branch::where('kode_igr', \Auth::user('users_admin')->branch_code)->Where('kode_igr','<>', '00')->get();
        }
        foreach ($cabangAssoc as $index => $row) {
            $cabFormat .= "<option style='font-size: 12px;' value='" . $row['id'] . "'>" . $row['name'] . "</option>";
        }

        foreach($Province as $index=> $prow) {

            $provFormat .= "<option style='font-size: 12px;' value='". $prow->id ."'>" . $prow->province_name . "</option>";
        }
        foreach($Cities as $index => $crow) {
            $citFormat .= "<option style='font-size: 12px;' value='" . $crow->id . "'>" . $crow->city_name . "</option>";
        }
        foreach($District as $index => $drow) {
            $disFormat .= "<option style='font-size: 12px;' value='" . $drow->id . "'>" . $drow->district_name . "</option>";
        }

//        foreach ($cabangAssoc as $index => $row) {
//            $htmlFormat .= "<option style='font-size: 12px;' value='" . $row['id'] . "'>" . $row['name'] . "</option>";
//        }

        foreach ($SubDistrict as $index => $prow) {
            $SubDistrictFormat .= "<option style='font-size: 12px;' value='" . $prow->id . "'>" . $prow->sub_district_name . "</option>";
        }

        return view('admin.registermember')->with('cabangOpt', $cabFormat)->with('provOpt', $provFormat)->with('citOpt', $citFormat)->with('disOpt', $disFormat)->with('SubDistrictOpt', $SubDistrictFormat);
    }

    public function createMemberMerah1(Request $Request)
    {
        $idbranch = $Request->get('subdistrict');

        $cab = BranchDistrict::Distinct()->Where('sub_district_id', $idbranch)->pluck('branch_id');

        $reg = new Registrar();  

        $validator = $reg->validator($Request->all());  
        if ($validator->fails()) {
            $this->throwValidationException($Request, $validator);
        }

        if ($cab != null) {
            $postalcode = SubDistrict::Distinct()->Where('id', $idbranch)->pluck('postal_code');

            $date = new \DateTime;



            \DB::beginTransaction();
            try {

                $newU = new User;
                $newU->nama = $Request->get('Nama');
                $newU->email = $Request->get('Email');
                $newU->password = bcrypt($Request->get('Password'));
                $newU->type_id = 2;
                $newU->kodemember = $Request->get('KodeMember');
                $newU->status = 1;
                $newU->activation_code = null;
                $newU->minor = $Request->get('MinimalOrder');
                $newU->shipping_fee = $Request->get('ShippingFee');
                $newU->created_at = $date;
                $newU->updated_at = $date;
                $newU->save();

                $newA = new Address;
                $newA->address = $Request->get('Alamat');
                $newA->branch_id = $Request->get('KodeCabang');      
                $newA->phone_number = $Request->get('NoHp');
                $newA->province_id = $Request->get('province');
                $newA->city_id = $Request->get('cities');
                $newA->district_id = $Request->get('district');
                $newA->sub_district_id = $idbranch;
                $newA->postal_code = $postalcode;
                $newA->member_id = $newU->id;
                $newA->created_at = $date;
                $newA->updated_at = $date;
                $newA->flag_default = 1;
                $newA->save();


                \DB::commit();

//                \Auth::loginUsingId($newU->id);

                return redirect('member')->with('new', 'TES');
            } catch (Exception $ex) {
                \DB::rollBack();
                return redirect('registermember')->with('err', 'Gagal menyimpan data, silahkan coba lagi');
            }

        } else {
            return redirect('registermember')->with('err', 'Kota Anda diluar jangkauan Indogrosir');
        }
        //$reg->create($Request->all());
    }

    public function createMemberMerah(Request $Request){
        $idbranch = $Request->get('subdistrict');

        $cab = BranchDistrict::Distinct()->Where('sub_district_id', $idbranch)->pluck('branch_id');

        $reg = new Registrar();

        $validator = $reg->validateNewMember($Request->all());
        if ($validator->fails()) {
            $this->throwValidationException($Request, $validator);
        }

        if ($cab != null) {
            $postalcode = SubDistrict::Distinct()->Where('id', $idbranch)->pluck('postal_code');

            $date = new \DateTime;

            $origin = Branch::select('latitude', 'longitude')->where('id', $cab)->get();

            foreach($origin as $index=> $prow) {
                $latitude1 = $prow->latitude;
                $longitude1 = $prow->longitude;
            }

            $destination = \DB::table('provinces')
                ->selectraw('CONCAT_WS(\' \', sub_district_name, district_name,city_name,province_name,sub_districts.postal_code) AS tujuan')
                ->join('cities', 'provinces.id','=','cities.province_id')
                ->join('districts', 'cities.id', '=', 'districts.city_id')
                ->join('sub_districts', 'districts.id', '=', 'sub_districts.district_id')
                ->where('provinces.id','LIKE', $Request->get('province'))
                ->where('cities.id','LIKE', $Request->get('cities'))
                ->where('districts.id','LIKE', $Request->get('district'))
                ->where('sub_districts.id','LIKE', $Request->get('subdistrict'))
//            ->Where('addresses.id',$id)
                ->Pluck('tujuan');


            $tujuantanpaspasi = str_replace(' ', '+', $destination);

            $aContext = array(
                'http' => array(
                    'proxy' => 'tcp://192.168.10.44:6115',
                    'request_fulluri' => true,
                ),
            );
            $cxContext = stream_context_create($aContext);

            $dataJson = file_get_contents("https://maps.googleapis.com/maps/api/directions/json?origin=". $latitude1 .",". $longitude1 ."&destination=". $tujuantanpaspasi ."&key=AIzaSyCrrmehQr0CFsfbpsJNZyacdTQpxFHNwrY", False, $cxContext);

//            $dataJson = file_get_contents("https://maps.googleapis.com/maps/api/directions/json?origin=". $latitude1 .",". $longitude1 ."&destination=". $tujuantanpaspasi ."&key=AIzaSyCrrmehQr0CFsfbpsJNZyacdTQpxFHNwrY");
      
            $data = json_decode($dataJson,true);


            try{
                $nilaiJarak = $data['routes'][0]['legs'][0]['distance']['text'];
                $lat = $data['routes'][0]['legs'][0]['end_location']['lat'];
                $longi = $data['routes'][0]['legs'][0]['end_location']['lng'];
            }catch(\Exception $ex){
                $nilaiJarak = "0";
                $lat = "0";
                $longi = "0";
            }

            \DB::beginTransaction();
            try {

                if($Request->get('KodeMember') == null || $Request->get('KodeMember') == ""){
                    return redirect('registermember')->with('err', 'Kode Member Belum di isi !');
                }

                $newU = new User;
                $newU->nama = $Request->get('Nama');
                $newU->email = $Request->get('Email');
                $newU->password = bcrypt($Request->get('Password'));
                $newU->type_id = 2;
                $newU->kodemember = $Request->get('KodeMember');
                $newU->status = 1;
                $newU->activation_code = null;
//                $newU->minor = $Request->get('MinimalOrder');
                $newU->minor = 500000;
                $newU->shipping_fee = 0;
                $newU->created_at = $date;
                $newU->updated_at = $date;
                $newU->save();

                $newA = new Address;
                $newA->address = $Request->get('Alamat');
                $newA->branch_id = $Request->get('KodeCabang');
                $newA->phone_number = $Request->get('NoHp');
                $newA->province_id = $Request->get('province');
                $newA->city_id = $Request->get('cities');
                $newA->district_id = $Request->get('district');
                $newA->sub_district_id = $idbranch;
                $newA->postal_code = $postalcode;
                $newA->member_id = $newU->id;
                $newA->created_at = $date;
                $newA->updated_at = $date;
                $newA->flag_default = 1;
                $newA->latitude = $lat;
                $newA->longitude = $longi;
                $newA->distance = $nilaiJarak;
                $newA->save();


                \DB::commit();

//                \Auth::loginUsingId($newU->id);

                return redirect('member')->with('new', 'TES');
            } catch (Exception $ex) {
                \DB::rollBack();
                return redirect('registermember')->with('err', 'Gagal menyimpan data, silahkan coba lagi');
            }

        } else {
            return redirect('registermember')->with('err', 'Kota Anda diluar jangkauan Indogrosir');
        }
    }

    public function simpan_alamat(Request $request){
        $id = $request->id;
        $hp = $request->no_hp;
        $alamat = $request->alamat;
        $provinsi = $request->provinsi;
        $kota = $request->kota;
        $kecamatan = $request->kecamatan;
        $kelurahan = $request->kelurahan;
        $kodepos = $request->kodepos;
        $minor = $request->minor;
        $shipping = $request->shipping;

        $data = Address::find($id);
        $data->address = $alamat;
        $data->phone_number = $hp;
        $data->province_id = $provinsi;
        $data->city_id = $kota;
        $data->district_id = $kecamatan;     
        $data->sub_district_id = $kelurahan;
        $data->postal_code = $kodepos;
        $data->updated_at = Carbon::now();

        $datamember = User::find($data->member_id);
        $datamember->minor = $minor;
//        $datamember->shipping_fee = $shipping;
        $datamember->save();

        $data->save();

        return "true";
    }

    public function EditOngkir(Request $request){
        $id = $request->id;

        $data = Ongkir::find($id);
        $data->km_a = $request->firstkm;
        $data->biaya_a = $request->firstfee;
        $data->km_b = $request->nextkm;
        $data->biaya_b = $request->nextfee;
        $data->km_c = $request->extrakm;
        $data->biaya_c = $request->extrafee;
        $data->km_max = $request->distance;
        $data->updated_at = Carbon::now();
        $data->modify_by = 'ADM';   
        $data->save();

        return "true";
    }

    public function get_alamat_admin(Request $request){
        $id = $request->id;
        $data = \DB::table('addresses')
            ->select('addresses.*', 'provinces.province_name', 'cities.city_name', 'districts.district_name', 'members.email', 'members.type_id', 'members.nama','branches.name', 'type', 'sub_districts.sub_district_name', 'npwp_name', 'npwp_address', 'npwp_number', 'shipping_fee', 'minor')

            //            ->select('addresses.*', 'provinces.province_name', 'cities.city_name', 'districts.district_name', 'members.email', 'members.type_id', 'members.nama', 'sub_districts.sub_district_name')
            ->join('provinces','addresses.province_id', '=', 'provinces.id')
            ->join('cities', 'addresses.city_id','=','cities.id')
            ->join('members', 'addresses.member_id', '=', 'members.id')
            ->join('types', 'members.type_id','=','types.id')
            ->join('branches','addresses.branch_id', '=', 'branches.id')
            ->join('districts', 'addresses.district_id', '=', 'districts.id')
            ->join('sub_districts', 'addresses.sub_district_id', '=', 'sub_districts.id')
            ->Where('addresses.id', $id)
            ->get();
        return $data;
    }

    public function get_provinsi(){
        $data = \DB::table('provinces')
            ->select('provinces.*')
            ->get();
        $html_provinsi = "";
        foreach ($data as $key => $value) {
            $html_provinsi .= "<option sytle='font-size:12px;' value='".$value->id."'>".$value->province_name."</option>";
        }
        return $html_provinsi;
    }

    public function get_kota(Request $request){
        $province_id = $request->id;
        $data = \DB::table('cities')
            ->select('cities.*');

        if($province_id != "" || $province_id != null){
            $data = $data->where('province_id', $province_id)->get();
        }else{
            $data = $data->get();
        }

        $html_kota = "";
        foreach ($data as $key => $value) {
            $html_kota .= "<option style='font-size:12px' value='".$value->id."'>".$value->city_name."</option>";
        }
        return $html_kota;
    }

    public function get_kecamatan(Request $request){
        $kota_id = $request->id;
        $data = \DB::table('districts')
            ->select('districts.*');
        if($kota_id != "" || $kota_id != null){
            $data = $data->Where('city_id', $kota_id )
                ->get();
        }else{
            $data = $data->get();
        }

        $html_kecamatan = "";
        foreach ($data as $key => $value) {
            $html_kecamatan .= "<option style ='font-size:12px;' value='".$value->id."'>".$value->district_name."</option>";
        }
        return $html_kecamatan;
    }

    public function get_kelurahan(Request $request){
        $kecamatan_id = $request->id;
        $data = \DB::table('sub_districts')
            ->select('sub_districts.*');

        if($kecamatan_id != "" || $kecamatan_id != null){
            $data = $data->where('district_id', $kecamatan_id)
                ->get();
        }else{
            $data = $data->get();
        }

        $html_kelurahan = "";
        foreach ($data as $key => $value) {
            $html_kelurahan .= "<option style='font-size:12px;' value='".$value->id."'>".$value->sub_district_name."</option>";
        }
        return $html_kelurahan;
    }

    public function get_kodepos(Request $request){
        $kelurahan_id = $request->id;
        $data = \DB::table('sub_districts')
            ->select('sub_districts.*')
            ->where('id', $kelurahan_id)
            ->get();
        $kodepost = "";
        foreach ($data as $key => $value) {
            $kodepost = $value->postal_code;
        }

        return $kodepost;
    }

    public function getMonitoringJob(Request $request){

        $MonitoringAssoc = Monitoring::Distinct()->OrderByRaw('id DESC')->get();

        foreach ($MonitoringAssoc as $row) {
            if ($row->status == 1) {    
                $row->action .= "<span class='label label-success' style='font-size: 20px; font-weight: bold;'><i class='fa fa-check-square'></i></span>";
            }else{
                $row->action .= "<span class='label label-danger' style='font-size: 20px; font-weight: bold;'><i class='fa fa-times'></i></span>";
            }
        }
        return \Datatables::of($MonitoringAssoc)->make(true);
    }  

    public function getListMonitoring(){
        return view('admin.monitoring');
    }

    public function getMasterKendaraan(){
        return view('admin.createkendaraan');
    }

    public function getMasterOngkir(){
        $cab = \DB::table('cabang_ongkir')->select('id', 'pulau')->get();
        $kendaraan = \DB::table('master_kendaraan')->select('id', 'nama')->get();

        return view('admin.createmasterongkir', compact('cab', 'kendaraan'));
    }

    public function getViewListOngkir(Request $Request){

        $ongkirAssoc = Ongkir::getDetailsOngkir();

        return view('admin.ongkir')->with('OngkirAssoc', $ongkirAssoc);
    }

    public function getOngkirAjax(Request $Request){

        $id = $Request->id;

        $data = \DB::table('ongkir_details')
//            ->selectRaw('ongkir_details.id as trxid, pulau_id, kendaraan_id, km_a, biaya_a, km_b, biaya_b, km_c, biaya_c, km_max')
            ->leftJoin('master_kendaraan', 'master_kendaraan.id', '=', 'ongkir_details.kendaraan_id')
            ->leftJoin('cabang_ongkir', 'cabang_ongkir.id', '=', 'ongkir_details.pulau_id')
            ->Where('ongkir_details.id', $id)
            ->Get();
        return $data;
    }

    public function getFreeOngkirAjax(Request $Request){

        if($Request->ajax()){
            $cFormatRaw="";

            $id = $Request->id;

            $data = \DB::table('freeongkir_dtl')
                ->SelectRaw('CASE WHEN members.kodemember IS NULL THEN customers.kode_member ELSE members.kodemember END as kode_member, nama, branches.name as namacabang, members.id as idmember')
                ->leftJoin('members', 'freeongkir_dtl.kodemember', '=', 'members.id')
                ->leftjoin('customers', 'customers.id', '=', 'members.customer_id')
                ->join('addresses', 'addresses.id', '=', 'freeongkir_dtl.address_id')
                ->Join('branches', 'branches.id', '=', 'addresses.branch_id')
                ->Where('ongkir_id', $id)
                ->Get();

//            dd($data);

            $cFormatRaw = "<div class='table-responsive'>
                            <table class='table'>
            <tr style='text-align: center'>
                                <th class='font-12' style='text-align: center;'>
                                    Nama Cabang
                                </th>
                                <th class='font-12' style='text-align: center;'>
                                    Kode Member
                                </th>
                                <th class='font-12' style='text-align: center;'>
                                    Nama Member
                                </th>

                            </tr>";

            $sindex = 0;

            foreach ($data as $row){

                $cFormatRaw .= "
                                    <tr>
                                     <td class=\"font-12\"; style='vertical-align: middle; text-align: center;'>
                                             " . $row->namacabang . "
                                        </td>
                                        <td class=\"font-12\"; style='vertical-align: middle; text-align: center;'>
                                             " . $row->kode_member . "
                                        </td>
                                         <td class=\"font-12\"; style='vertical-align: middle; text-align: center;'>
                                             " . $row->nama . "
                                        </td>


                                    </tr>";
            }
            $cFormatRaw .= "</table>";
            $cFormatRaw .= "</div>";
            return $cFormatRaw;
        }
    }

    public function getViewOngkir(){

        $ongkirAssoc = Ongkir::getDetailsOngkir();

        foreach ($ongkirAssoc as $row) {
            $row->action  = '<button id="btn_edit_ongkir" type="button" class="btn btn-info" style="width:70px;" value="'.$row['trxid'].'"> Edit </button>';
            $row->delete  = '<button id="btn_delete_ongkir" type="button" class="btn btn-danger" style="width:70px;" value="'.$row['trxid'].'"> Hapus </button>';
//            $row->action = "<a href=\"#\" id='idongkir' class=\"btn btn-info btn-xs\"  data-toggle=\"modal\" data-target=\"#EditModalOngkir\" value='" . $row['id'] ."'> Edit </a>";
//           $row->action = "<button data-target=\"#EditModalOngkir\" type='button' class='btn btn-info' style='width:70px;' value='" . $row['id'] ."'> Edit </button>";
        }
//        return view('admin.email')->with('cabang', $htmlFormat)->with('email', $emailAssoc);

        return \Datatables::of($ongkirAssoc)->make(true);
    }

    public function postOngkir(Request $request){
        $newOng = new Ongkir;
        $newOng->pulau_id = $request->get('area');
        $newOng->kendaraan_id = $request->get('kendaraan');
        $newOng->km_a = $request->get('firstkm');
        $newOng->biaya_a = $request->get('firstfee');
        $newOng->km_b = $request->get('nextkm');
        $newOng->biaya_b = $request->get('nextfee');
        $newOng->km_c = $request->get('extrakm');
        $newOng->biaya_c = $request->get('extrafee');
        $newOng->km_max = $request->get('distance');
//        $newOng->created_at = Carbon::now();
        $newOng->save();

        return redirect('viewongkir')->with('suc', 'TES');

    }

    public function postMasterKendaraan(Request $request){
        $Kend = $request->get('kendaraan');
        $date = new \DateTime;

        $cekExist = \DB::table('master_kendaraan')->where('nama', '=', $Kend)->Count();

        if($cekExist > 0){
            return redirect('masterkendaraan')->with('err', 'Err');
        }else{
            \DB::table('master_kendaraan')->insert(
                ['nama' => $Kend, 'created_by' => 'MIC', 'created_at' => $date]
            );
            return redirect('masterongkir')->with('suc', 'TES');
        }

    }

    public function getMasterFreeOngkir(){
        $cabangAssoc = Branch::getAllBranches();
        $cabFormat ="";


        ini_set('memory_limit', '-1');
        $memberFormat="";
        $Memberklik = \DB::table('members')
            ->SelectRaw('CASE WHEN kodemember IS NULL THEN customers.kode_member ELSE members.kodemember END as kode_member, nama,
                        npwp_name,
                        npwp_number,
                        npwp_address,
                        email,
                        members.id,
                        branches.kode_igr,
                        branches.name as namacabang,
                        addresses.id as idaddress')
            ->leftjoin('customers', 'customers.id', '=', 'members.customer_id')
            ->join('addresses', 'addresses.member_id', '=', 'members.id')
            ->leftjoin('branches','addresses.branch_id', '=', 'branches.id')
            ->whereNotIn(\DB::raw('(members.id, branches.kode_igr)'),function($query){
                $query->select('kodemember', 'kode_igr')->from('freeongkir_dtl')
                    ->leftjoin('freeongkir_hdr', 'freeongkir_hdr.id', '=', 'freeongkir_dtl.ongkir_id')
//                    ->where(\DB::raw('DATE(periode_start)'), '<=', Carbon::today())
//                    ->where(\DB::raw('DATE(periode_end)'), '>=',Carbon::today())
                    ->where('periode_start', '<=', Carbon::today())
                    ->where('periode_end', '>=', Carbon::today())
                    ->where('flag_all', 'N');
            })
            ->groupby('member_id', 'branch_id')
            ->WhereNull('addresses.deleted_at')
//           ->where('flag_default', 1)
            ->get();

        foreach($Memberklik as $index => $row) {
            $memberFormat .= "<option style='font-size: 12px;' value='" . $row->idaddress . "'>" . $row->kode_member . " --> " . $row->nama . "--> " . $row->email . " --> " . $row->namacabang .  "</option>";     
        }

        foreach ($cabangAssoc as $index => $row) {
            $cabFormat .= "<option style='font-size: 12px;' value='" . $row['kode_igr'] . "'>" . $row['name'] . "</option>";
        }

        return view('admin.freeongkir')->with('getmember', $memberFormat)->with('cabang', $cabFormat);
    }

    public function getCabangOngkirAjax(Request $Request){

        if($Request->ajax()){
            $cFormatRaw="";

            $id = $Request->id;

            $data = \DB::table('freeongkir_hdr')
                ->SelectRaw('name , nominal')
                ->leftjoin('branches','freeongkir_hdr.cabang', '=', 'branches.kode_igr')
                ->Where('nama', $id)
                ->Get();

//            dd($data);

            $cFormatRaw = "<div class='table-responsive'>
                            <table class='table'>
            <tr style='text-align: center'>
                                <th class='font-12' style='text-align: center;'>
                                    Nama Cabang
                                </th>
                                <th class='font-12' style='text-align: center;'>
                                    Nominal Order
                                </th>
                                <th class='font-12' style='text-align: center;'>
                                   Keterangan
                                </th>

                            </tr>";

            $sindex = 0;

            foreach ($data as $row){

                $cFormatRaw .= "
                                    <tr>
                                     <td class=\"font-12\"; style='vertical-align: middle; text-align: center;'>
                                             " . $row->name . "
                                        </td>
                                        <td class=\"font-12\"; style='vertical-align: middle; text-align: center;'>
                                             " . $row->nominal . "
                                        </td>
                                         <td class=\"font-12\"; style='vertical-align: middle; text-align: center;'>
                                             All Member
                                        </td>


                                    </tr>";
            }
            $cFormatRaw .= "</table>";
            $cFormatRaw .= "</div>";
            return $cFormatRaw;
        }
    }

    public function getMemberKlik(Request $Request){
        $cabang = $Request->get('cab');
//        $cab = implode(',', $cabang);

        ini_set('memory_limit', '-1');
        $memberFormat="";
        $Memberklik = \DB::table('members')
            ->SelectRaw('CASE WHEN kodemember IS NULL THEN customers.kode_member ELSE members.kodemember END as kode_member, nama,
                        npwp_name,
                        npwp_number,
                        npwp_address,
                        email,
                        members.id,
                        branches.kode_igr,
                        branches.name as namacabang,
                        addresses.id as idaddress')
            ->leftjoin('customers', 'customers.id', '=', 'members.customer_id')
            ->join('addresses', 'addresses.member_id', '=', 'members.id')
            ->leftjoin('branches','addresses.branch_id', '=', 'branches.id')
            ->whereNotIn( \DB::raw('(members.id, branches.kode_igr)'),function($query){
                $query->select('kodemember', 'kode_igr')->from('freeongkir_dtl')
                    ->leftjoin('freeongkir_hdr', 'freeongkir_hdr.id', '=', 'freeongkir_dtl.ongkir_id')
                    ->where('periode_start', '<=', Carbon::today())
                    ->where('periode_end', '>=', Carbon::today())
//                    ->where(\DB::raw('DATE(periode_start)'), '<=', Carbon::today())
//                    ->where(\DB::raw('DATE(periode_end)'), '>=',Carbon::today())
                    ->where('flag_all', 'N');
            })
//            ->where('flag_default', 1)
            ->wherein('branches.kode_igr', $cabang)
            ->groupby('member_id', 'branch_id')
            ->WhereNull('addresses.deleted_at')
            ->get();

        foreach($Memberklik as $index => $row) {
            $memberFormat .= "<option style='font-size: 12px;' value='" . $row->idaddress . "'>" . $row->kode_member . " --> " . $row->nama . "--> " . $row->email . " --> " . $row->namacabang .  "</option>";
        }
        return $memberFormat;
    }

    public function postFreeOngkir(Request $request){
        $cabang = $request->get('cab');
//        $cab = explode(',', $cabang);

        $countFlagFreeOngkir = \DB::table('freeongkir_hdr')
            ->where('periode_start', '<=', Carbon::today())
            ->where('periode_end', '>=', Carbon::today())
            ->where('flag_all', '=', 'Y')
            ->wherein('cabang', $cabang)
            ->Count();

        $member = $request->get('member');

        $memberAssoc = \DB::table('members')
            ->Selectraw('members.id as idmember, kode_igr, addresses.id as idaddresses, kode_igr')
            ->join('addresses', 'addresses.member_id', '=', 'members.id')
            ->Join('branches', 'branches.id', '=', 'addresses.branch_id')
            ->WhereIN('addresses.id', $member)
            ->wherein('kode_igr', $cabang)
            ->whereNotIn('addresses.id',function($query){
                $query->select('address_id')->from('freeongkir_dtl')
                    ->leftjoin('freeongkir_hdr', 'freeongkir_hdr.id', '=', 'freeongkir_dtl.ongkir_id')
//                    ->where('periode_start', '<=', Carbon::today())
//                    ->where('periode_end', '>=', Carbon::today());
                    ->where(\DB::raw('DATE(periode_start)'), '<=', Carbon::today())
                    ->where(\DB::raw('DATE(periode_end)'), '>=',Carbon::today());
            })
            ->groupby('kode_igr','idaddresses')
            ->get();


        if($request->get('start') =="" || $request->get('end') =="" || $request->get('namaproject')=="" || $request->get('cab')==""){
            return redirect('masterfreeongkir')->with('err2', 'Tes');
        }else{
            if($request->sendRadio == 0) {
                if($request->get('biayaongkir') ==""){
                    return redirect('masterfreeongkir')->with('err3', 'Tes');
                }else{
                    if($countFlagFreeOngkir > 0){
                        return redirect('masterfreeongkir')->with('err', 'TES');
                    }else{
                        foreach($cabang as $cab) {
                            $newFreeHdr = new FreeOngkirHeader();
                            $newFreeHdr->nama = $request->namaproject;
                            $newFreeHdr->periode_start = $request->start;
                            $newFreeHdr->periode_end = $request->end;
                            $newFreeHdr->cabang = $cab;
                            $newFreeHdr->flag_all = 'Y';
                            $newFreeHdr->nominal = $request->biayaongkir;
                            $newFreeHdr->modify_by = 'ADM';
                            $newFreeHdr->save();
                        }
                    }
                }

            }else{

                $newFreeHdr = new FreeOngkirHeader();
                $newFreeHdr->nama = $request->namaproject;
                $newFreeHdr->periode_start = $request->start;
                $newFreeHdr->periode_end = $request->end;
                $newFreeHdr->cabang = 'All';
                $newFreeHdr->flag_all = 'N';
                $newFreeHdr->nominal = $request->biayaongkir;
                $newFreeHdr->modify_by = 'ADM';
                $newFreeHdr->save();

                foreach ($memberAssoc as $index=> $row) {
                    $newFreeDtl = new FreeOngkirDetail();
                    $newFreeDtl->ongkir_id = $newFreeHdr->id;
                    $newFreeDtl->kodemember = $row->idmember;
                    $newFreeDtl->kode_igr = $row->kode_igr;
                    $newFreeDtl->address_id = $row->idaddresses;
                    $newFreeHdr->modify_by = 'ADM';
                    $newFreeDtl->save();
                }
            }


            return redirect('viewfreeongkir');
        }


    }

    public function getViewListFreeOngkir(Request $Request){
        return view('admin.viewfreeongkir');
    }

    public function getViewFreeOngkir()
    {
        $FreeOngkirAssoc = FreeOngkirHeader::getFreeOngkir();

        foreach ($FreeOngkirAssoc as $row) {
            if($row->flag_all == 'N'){
                $row->action = '<button id="btn_editfree_ongkir" type="button" class="btn btn-info" style="width:120px;" value="' . $row['idfree'] . '"> Lihat Member </button>';
            }else{
                $row->action = '<button id="btn_cabang_ongkir" type="button" class="btn btn-warning" style="width:120px;" value="' . $row['nama'] . '"> Lihat Cabang </button>';
            }

            if($row->flag_all == 'N'){
                $row->tipefree = '<span>-</span>';
            }else{
                $row->tipefree = '<span>' . $row['nominal'] . '</span>';
            }
        }
        return \Datatables::of($FreeOngkirAssoc)->make(true);
    }

    public function getViewDistance(Request $Request)
    { 

        $destination = \DB::table('addresses')
//            ->select('addresses.*', 'provinces.province_name', 'cities.city_name', 'districts.district_name', 'sub_districts.sub_district_name')
            ->selectraw('CONCAT_WS(\',\', addresses.address, sub_district_name, district_name,city_name,province_name,sub_districts.postal_code) AS tujuan, branches.address as branchaddress, addresses.id as idaddress, branches.latitude as lt, branches.longitude as lg, distance')
            ->leftjoin('provinces','addresses.province_id', '=', 'provinces.id')
            ->leftjoin('cities', 'addresses.city_id','=','cities.id')
            ->leftjoin('branches','addresses.branch_id', '=', 'branches.id')
            ->leftjoin('districts', 'addresses.district_id', '=', 'districts.id')
            ->leftjoin('sub_districts', 'addresses.sub_district_id', '=', 'sub_districts.id');
        if($Request->get('tipestatus') == "x") {
            $destination->Where('distance', 'LIKE', '%');
        }elseif($Request->get('tipestatus') == "y"){
            $destination->Where('distance', '<>', 0);
        }else{
            $destination->Where('distance', "=", 0);
        }
        $destination = $destination->WhereNull('addresses.deleted_at')
            ->get();

        $collection = collect($destination);

        foreach ($collection as $row) {
            if($row->distance == 0){
                $row->manual = '<button id="btn_edit_distance" type="button" class="btn btn-danger" style="width:120px;" value="' . $row->idaddress . '"> Edit Manual </button>';
            }else{
                $row->manual = '<button id="btn_edit_distance" type="button" class="btn btn-info" style="width:120px;" value="' . $row->idaddress . '"> Show Info </button>';
            }

//            $row->maps = '<div id="maps"> Peta </div>';
        }

        return \Datatables::of($collection)->make(true);
    }

    public function getKoordinatKodePos(Request $Request){

        $destination = \DB::table('addresses')
            ->Where('distance',0)
            ->WhereNull('addresses.deleted_at')
            ->Count();

        return view('admin.postalcode')->with('countdistance',$destination);
    }

    public function PostKoordinatKodePos(Request $Request)
    {
        ini_set('max_execution_time', -1);

        $destination = \DB::table('addresses')
//            ->select('addresses.*', 'provinces.province_name', 'cities.city_name', 'districts.district_name', 'sub_districts.sub_district_name')
            ->selectraw('CONCAT_WS(\',\', sub_district_name, district_name,city_name,province_name,sub_districts.postal_code) AS tujuan, branches.address as branchaddress, addresses.id as idaddress, branches.latitude as lt, branches.longitude as lg, distance')
            ->join('provinces','addresses.province_id', '=', 'provinces.id')
            ->join('cities', 'addresses.city_id','=','cities.id')
            ->join('branches','addresses.branch_id', '=', 'branches.id')
            ->join('districts', 'addresses.district_id', '=', 'districts.id')
            ->join('sub_districts', 'addresses.sub_district_id', '=', 'sub_districts.id')
//            ->Where('kode_igr',18)
            ->WhereNull('addresses.deleted_at')
            ->Where('addresses.distance',0)
            ->get();


        foreach($destination as $index=> $prow) {

            try{
            $ID =$prow->idaddress;
            $address = $prow->branchaddress;
            $tujuan = $prow->tujuan;
            $latittude = $prow->lt;
            $longitude = $prow->lg;

            $tujuantanpaspasi = str_replace(' ', '+', $tujuan);


//            if($prow->distance == 0){
                $aContext = array(
                    'http' => array(
                        'proxy' => 'tcp://192.168.10.202:6124',
                        'request_fulluri' => true,
                    ),
                );
                $cxContext = stream_context_create($aContext);


                $dataJson = file_get_contents("https://maps.googleapis.com/maps/api/directions/json?origin=". $latittude .",". $longitude ."&destination=". $tujuantanpaspasi ."&avoid=tolls&key=AIzaSyCrrmehQr0CFsfbpsJNZyacdTQpxFHNwrY", False, $cxContext);
//
                $data = json_decode($dataJson,true);

                    $nilaiJarak = $data['routes'][0]['legs'][0]['distance']['text'];
                    $lat = $data['routes'][0]['legs'][0]['end_location']['lat'];
                    $longi = $data['routes'][0]['legs'][0]['end_location']['lng'];
                }catch(\Exception $ex){
                    $nilaiJarak = "0";
                    $lat = "0";
                    $longi = "0";
                }


                $UpdateAddress = Address::where('addresses.id', '=',  $ID)->first();
                $UpdateAddress->distance = $nilaiJarak;
                $UpdateAddress->latitude = $lat;
                $UpdateAddress->longitude = $longi;
                $UpdateAddress->save();

//            }

        }

        $Countdestination = \DB::table('addresses')
            ->Where('distance',0)
            ->WhereNull('addresses.deleted_at')
            ->Count();

        return view('admin.postalcode')->with('countdistance',$Countdestination);


    }

    public function getEditDistanceAjax(Request $Request){

        $id = $Request->id;

        $destination = \DB::table('addresses')
            ->select('addresses.*', 'provinces.province_name', 'cities.city_name', 'districts.district_name', 'sub_districts.sub_district_name')
            ->selectraw('CONCAT_WS(\',\', addresses.address, sub_district_name, district_name,city_name,province_name,sub_districts.postal_code) AS tujuan, branches.address as branchaddress, addresses.address as asaladdress, addresses.id as idaddress, branches.latitude as lt, branches.longitude as lg, distance,sub_district_name, district_name,city_name,province_name,sub_districts.postal_code, addresses.longitude as lg1, addresses.latitude as lt1')
            ->leftjoin('provinces','addresses.province_id', '=', 'provinces.id')
            ->leftjoin('cities', 'addresses.city_id','=','cities.id')
            ->leftjoin('branches','addresses.branch_id', '=', 'branches.id')
            ->leftjoin('districts', 'addresses.district_id', '=', 'districts.id')
            ->leftjoin('sub_districts', 'addresses.sub_district_id', '=', 'sub_districts.id')
            ->Where('addresses.id', $id)
            ->WhereNull('addresses.deleted_at')
            ->get();

        return $destination;
    }

    public function getData(){
        $cabang = \DB::table('branches')->get();

        return response()->json($cabang);

    }

    public function EditJarakOngkir(Request $request){
        $id = $request->id;


        $destination = \DB::table('addresses')
//            ->select('addresses.*', 'provinces.province_name', 'cities.city_name', 'districts.district_name', 'sub_districts.sub_district_name')
            ->selectraw('CONCAT_WS(\',\', sub_district_name, district_name,city_name,province_name) AS tujuan, branches.address as branchaddress, addresses.address as asaladdress, addresses.id as idaddress, branches.latitude as lt, branches.longitude as lg, distance,sub_district_name, district_name,city_name,province_name,sub_districts.postal_code, addresses.longitude as lg1, addresses.latitude as lt1')
//            ->join('branches','addresses.branch_id', '=', 'branches.id')
            ->join('provinces','addresses.province_id', '=', 'provinces.id')
            ->join('cities', 'addresses.city_id','=','cities.id')
            ->join('branches','addresses.branch_id', '=', 'branches.id')
            ->join('districts', 'addresses.district_id', '=', 'districts.id')
            ->join('sub_districts', 'addresses.sub_district_id', '=', 'sub_districts.id')
            ->where('provinces.id','LIKE', $request->province_name)
            ->where('cities.id','LIKE', $request->citi_name)
            ->where('districts.id','LIKE', $request->district_name)
            ->where('sub_districts.id','LIKE', $request->sub_district_name)
            ->Where('addresses.id', $id)
            ->WhereNull('addresses.deleted_at')
            ->Pluck('tujuan');


        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $tujuantanpaspasi = str_replace(' ', '+', $destination);


        $aContext = array(
            'http' => array(
                'proxy' => 'tcp://192.168.10.202:6124',
                'request_fulluri' => true,
            ),
        );
        $cxContext = stream_context_create($aContext);

//
//        $dataJson = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$tujuantanpaspasi."&key=AIzaSyCrrmehQr0CFsfbpsJNZyacdTQpxFHNwrY", False, $cxContext);
//        $data = json_decode($dataJson,true);
//
//
//        try{
//            $lataddress = $data['results'][0]['geometry']['location']['lat'];
//            $longiaddress = $data['results'][0]['geometry']['location']['lng'];
//
//            $latstring =strval($lataddress);
//            $longistring=strval($longiaddress);
//        }catch(\Exception $ex){
//            $lataddress = "0";
//            $longiaddress = "0";
//        }


        $dataJson = file_get_contents("https://maps.googleapis.com/maps/api/directions/json?origin=". $latitude .",". $longitude ."&destination=". $tujuantanpaspasi ."&avoid=tolls&key=AIzaSyCrrmehQr0CFsfbpsJNZyacdTQpxFHNwrY", False, $cxContext);
//
        $data = json_decode($dataJson,true);


        try{
            $nilaiJarak = $data['routes'][0]['legs'][0]['distance']['text'];
            $lat = $data['routes'][0]['legs'][0]['end_location']['lat'];
            $longi = $data['routes'][0]['legs'][0]['end_location']['lng'];
        }catch(\Exception $ex){
            $nilaiJarak = "0";
            $lat = "0";
            $longi = "0";
        }


        if($nilaiJarak == 0){
            return "false";
        }



        $UpdateAddress = Address::where('addresses.id', '=',  $id)->first();
        $UpdateAddress->distance = $nilaiJarak;
        $UpdateAddress->province_id = $request->province_name;
        $UpdateAddress->city_id = $request->citi_name;
        $UpdateAddress->district_id = $request->district_name;
        $UpdateAddress->sub_district_id = $request->sub_district_name;
        $UpdateAddress->latitude = $lat;
        $UpdateAddress->longitude = $longi;
        $UpdateAddress->save();

        return "true";
    }


    public function getNotif() {
        return view('admin.notification');
    }

    public function getListPromo() {

        return view('admin.listpromo');
    }

    public function getPromoNotif() {

        $contentnotif = \DB::table('notification_content')->where('id', \DB::raw("(select max(`id`) from notification_content)"))->pluck('content');

        $productpromo = ProductView::getProductPromo();
//        $productpromo = \DB::table('product_views')->leftjoin('ms_picture_product', 'product_views.prdcd', '=', 'ms_picture_product.pic_prdcd')->take(10)->get();

        return view('admin.pushpromo')->with('notif', $contentnotif)->with('product', $productpromo);
    }

    public function getCreatePromo() {

        $type = \DB::table('types')
            ->Select('id', 'type')
            ->get();

        $member = \DB::table('members')
            ->SelectRaw('CASE WHEN kodemember IS NULL THEN customers.kode_member ELSE members.kodemember END as kodemember, nama,members.id as id')
            ->leftjoin('customers', 'customers.id', '=', 'members.customer_id')
            ->WhereNull('deleted_at')
            ->get();


        $cabangAssoc = Branch::getAllBranches();
        $cabFormat ="";
        $typeFormat ="";
        $memberFormat ="";

        foreach ($type as $index => $row) {
            $typeFormat .= "<option style='font-size: 12px;' value='" . $row->id . "'>" . $row->type . "</option>";
        }


        foreach ($cabangAssoc as $index => $row) {
            $cabFormat .= "<option data-max-options='3' style='font-size: 12px;' value='" . $row->kode_igr . "'>" . $row->name . "</option>";
        }

        foreach ($member as $index => $row) {
            $memberFormat .= "<option style='font-size: 12px;' value='" . $row->id . "'>" . $row->kodemember . "-" . $row->nama . "</option>";
        }

        return view('admin.createpromo')->with('cabang', $cabFormat)->with('types', $typeFormat)->with('member', $memberFormat);
    }

    public function get_member(Request $request){
        $html_cab = '<option value=0>-- Pilih Member --</option>';
//        $idcab = $request->get('id_cab');
//        $typeid = $request->get('id_type');

        if ($request->get('id_cab') == "%" || $request->get('id_cab') == "") {
            $idcab = "%";
        }else{
            $idcab = $request->get('id_cab');
        }

//        if ($request->get('id_type') == "%" || $request->get('id_type') == "") {
//            $typeid = "%";
//        }else{
//            $typeid = $request->get('id_type');
//        }
//        dd($typeid);

        $MemberKlik =  Address::Distinct()
            ->select('members.id as id', 'kodemember', 'nama', 'email')
            ->join('branches','addresses.branch_id', '=', 'branches.id')
            ->join('members', 'addresses.member_id', '=', 'members.id');
              if($request->get('id_cab') == "") {
                  $MemberKlik->Where('kode_igr', 'LIKE', '%');
              }else{
                  $MemberKlik->wherein('kode_igr', $idcab);
              }

        $MemberKlik = $MemberKlik->OrderByRaw('id DESC')->get();

        foreach ($MemberKlik as $key => $row) {
            $html_cab .= "<option style='font-size: 12px;' value='" . $row->id . "'>" . $row->kodemember . " --> " . $row->nama . "--> " . $row->email . "</option>";
        }
        return $html_cab;
    }

    public function createNotification() {

        $htmlFormat = "";

//        $notif = \DB::table('notification_master')
//            ->Select('id', 'type')
//            ->get();

       $type = \DB::table('types')
            ->Select('id', 'type')
            ->get();

        $member = \DB::table('members')
            ->SelectRaw('CASE WHEN kodemember IS NULL THEN customers.kode_member ELSE members.kodemember END as kodemember, nama,members.id as id')
            ->leftjoin('customers', 'customers.id', '=', 'members.customer_id')
            ->WhereNull('deleted_at')
            ->get();


        $cabangAssoc = Branch::getAllBranches();
        $cabFormat ="";
        $typeFormat ="";
        $memberFormat ="";

        foreach ($type as $index => $row) {
            $typeFormat .= "<option style='font-size: 12px;' value='" . $row->id . "'>" . $row->type . "</option>";
        }


        foreach ($cabangAssoc as $index => $row) {
            $cabFormat .= "<option data-max-options='3' style='font-size: 12px;' value='" . $row->kode_igr . "'>" . $row->name . "</option>";
        }

        foreach ($member as $index => $row) {
            $memberFormat .= "<option style='font-size: 12px;' value='" . $row->id . "'>" . $row->kodemember . "-" . $row->nama . "</option>";
        }


//        foreach ($notif as $index => $row) {
//            $htmlFormat .= "<option style='font-size: 12px;' value='" . $row->id . "'>" . $row->type . "</option>";
//        }

        return view('admin.createnotif')->with('cabang', $cabFormat)->with('types', $typeFormat)->with('member', $memberFormat);
    }

    public function postNotification(Request $request) {
        $image = $request->file('input-image');

        if ($request->get('id_cab') == "%" || $request->get('id_cab') == "") {
            $idcab = "%";
        }else{
            $idcab = $request->get('id_cab');
        }

        if ($request->get('member') == "%" || $request->get('member') == "") {
            $member = "%";
        }else{
            $member = $request->get('member');
        }


            if($image->isValid()) {
                $file = 'image/promotion/' . $image->getClientOriginalName();

                    $promotion = new Promotion;
                    $url = env('URLNOTIF') . $image->getClientOriginalName();
                    $promotion->title = $request->title;
                    $promotion->image_url = $url;
                    $promotion->type_notif = $request->id_type;
                    $promotion->description = $request->caption;
                    $promotion->content = htmlentities(htmlspecialchars($request->isi));
                    $promotion->save();

                \Image::make($image->getRealPath())
                    ->resize(200, 100)
                    ->save($file);


                //Getting api key
                $api_key = 'AAAAMmqWl8I:APA91bFk8iLeqKVzcXErVRZXbkfUNzlTszGb8nPW1gJqIZ0KGWpIdvWEikWVLq4Me7zOI81CLaINi6iecMyuny_kDt7c9XZgJFi7ZYoIfaLzAgx-BVrq1QBv6u5Wf1ZxqaT-wbfCoFQj';


                $tokens =  Address::Distinct()
//                    ->select('userid', 'reg_id')
                    ->join('branches','addresses.branch_id', '=', 'branches.id')
                    ->join('members', 'addresses.member_id', '=', 'members.id')
                    ->join('notification_reg', 'members.id', '=', 'userid')
                    ->WhereNull('members.deleted_at')
                    ->Where('flag_default', 1);
//                if($request->get('id_cab') == "") {
//                    $tokens->Where('kode_igr', 'LIKE', '%');
//                }else{
//                    $tokens->wherein('kode_igr', $idcab);
//                }
                if($request->get('member') == "") {
                    $tokens->Where('userid', 'LIKE', '%');
                }else{
                    $tokens->wherein('userid', $member);
                }

                $tokens = $tokens->get();

                $regid = $tokens->pluck('reg_id');

                $imgnotif = \DB::table('notification_content')->where('id', $promotion->id)->pluck('image_url');


                $urlcontent = "https://klikigrpentest.mitraindogrosir.co.id/promonotif";
//                foreach ($contentnotif as $index => $row) {
//                    $image = $row->image_url;
//                }

                //Creating a message array
                #prep the bundle
                $msg = array
                (
                    'body' 	=> $request->caption,
                    'title'	=> $request->title,
                    'icon'	=> 'default',
                    'sound' => '#203E78',
                );

            
                $msg['image'] = $imgnotif;
                $msg['url'] = $url;

                if (count($regid) == 1) {
                    $fields = array
                    (
                        'to'		        => $regid[0],
                        'notification'	    => $msg,
                        'time_to_live'      => 3600
                    );
                } else {
                    $fields = array
                    (
                        'registration_ids'  => $regid,
                        'notification'	    => $msg,
                        'time_to_live'      => 3600
                    );
                }

                //Creating a new array fileds and adding the msg array and registration token array here

                //Adding the api key in one more array header
                $headers = array
                (
                    'Authorization: key=' . $api_key,
                    'Content-Type: application/json'
                );

                #Send Reponse To FireBase Server
                $ch = curl_init();
                curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
                curl_setopt( $ch,CURLOPT_POST, true );
                curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
                $result = curl_exec($ch );
                curl_close( $ch );

                //Decoding json from result
//            $res = json_decode($result);

                return $result;

//        }


                return 1;


            }
    }

    public function sendNotif(Request $request) {
        //Getting the message
        $message = $request->message;

        $reg_token = $request->token;

        $image = $request->image;

        //Getting api key
        $api_key = 'AAAAMmqWl8I:APA91bFk8iLeqKVzcXErVRZXbkfUNzlTszGb8nPW1gJqIZ0KGWpIdvWEikWVLq4Me7zOI81CLaINi6iecMyuny_kDt7c9XZgJFi7ZYoIfaLzAgx-BVrq1QBv6u5Wf1ZxqaT-wbfCoFQj';

//        $tokens = Notification::Distinct()->get();

        $tokens =  Address::Distinct()
            ->select('userid', 'reg_id')
            ->join('branches','addresses.branch_id', '=', 'branches.id')
            ->join('members', 'addresses.member_id', '=', 'members.id')
            ->join('notification_reg', 'members.id', '=', 'userid')
            ->WhereNull('deleted_at')
            ->Where('flag_default', 1)
            ->Wherein('type_id')
            ->Wherein('kode_igr')
            ->Wherein('userid')
            ->get();


//        foreach($tokens as $token) {
        //Getting registration token we have to make it as array
//        $reg_token = array($reg_token);

        //Creating a message array
        #prep the bundle
        $msg = array
        (
            'body' 	=> $message,
            'title'	=> 'KlikIndogrosir',
            'icon'	=> 'default',
            'sound' => '#203E78',
        );

//        if ($activity) {
//            $msg['click_action'] = $activity;
//        }
//
        if ($image) {
            $msg['image'] = $image;
        }


        $fields = array
        (
            'to'		        => $reg_token,
            'notification'	    => $msg,
            'time_to_live'      => 3600
        );

//        if ($method == 'SINGLE') {
//            $fields = array
//            (
//                'to'		        => $registrationIDs,
//                'notification'	    => $msg,
//                'time_to_live'      => 3600
//            );
//        } else {
//            $fields = array
//            (
//                'registration_ids'  => $registrationIDs,
//                'notification'	    => $msg,
//                'time_to_live'      => 3600
//            );
//        }

        //Creating a new array fileds and adding the msg array and registration token array here

        //Adding the api key in one more array header
        $headers = array
        (
            'Authorization: key=' . $api_key,
            'Content-Type: application/json'
        );

        #Send Reponse To FireBase Server
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );

        //Decoding json from result
//            $res = json_decode($result);

        return $result;

//        }


        return 1;
    }



}
