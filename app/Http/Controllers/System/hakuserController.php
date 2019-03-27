<?php

namespace App\Http\Controllers\System;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\m_customer;
use Carbon\carbon;
use App\Http\Controllers\Controller;
use DB;
use Datatables;
use Auth;
use App\d_mem;
use App\d_mem_access;
use App\d_access;
use App\d_mem_comp;
use App\d_group;
use App\mMember;

class hakuserController extends Controller
{
   public function manajemenuser()
   {

      return view('system.manajemenuser.manajemenuser');
   }

   public function tambah()
   {
      $akses = DB::select("select * from d_access order by a_id");
      $perusahaan = DB::table('m_comp')
                     ->get();
                     
      $gudang = DB::table('m_gudang')
                  ->get();

      return view('system.manajemenhakakses.tambah_manajemenhakakses', compact('perusahaan', 'gudang', 'akses'));
   }

   public function simpan(Request $request)
   {  
      DB::beginTransaction();
      try {
      $id = DB::table('d_mem')->max('m_id')+1;
      $password = sha1(md5('passwordAllah') . $request->password);
      DB::table('d_mem')
         ->insert([
         'm_id' => $id,
         'm_pegawai_id' => $request->IdPegawai,
         'm_username' => $request->username,
         'm_passwd' => $password,
         'm_name' => $request->NamaLengkap,
         'm_addr' => $request->alamat,
         'm_insert' => Carbon::now('Asia/Jakarta')
         ]);

      for ($i=0; $i < count($request->perusahaan) ; $i++) { 
         d_mem_comp::insert([
            'mc_mem' => $id,
            'mc_comp' => $request->perusahaan[$i],
            'mc_active' => 'Y',
            'mc_insert' => Carbon::now('Asia/Jakarta')
         ]);
      }
         

       for ($i=0; $i < count($request->id_access) ; $i++) 
       {
          d_mem_access::create([
                'ma_mem' =>$id,
                'ma_access'=>$request->id_access[$i],
                'ma_type' =>'M',
                'ma_read'=> $request->ma_read[$i],
                'ma_insert' =>$request->ma_insert[$i],
                'ma_update' =>$request->ma_update[$i],
                'ma_delete' =>$request->ma_delete[$i]
          ]);
       }

         DB::commit();
         return response()->json([
            'status' => 'berhasil'
         ]);
         } catch (\Exception $e) {
         DB::commit();
         return response()->json([
            'status' => 'gagal'
         ]);
      }

   }

   public function tableUser()
   {
      $tableUser = d_mem::select('d_mem.*',
                                 'm_pegawai_man.c_nama',
                                 'm_pegawai_man.c_code')
            ->join('m_pegawai_man','m_pegawai_man.c_id','=','m_pegawai_id')
            ->get();

      return DataTables::of($tableUser)
      ->editColumn('c_nama', function ($data) {
         return $data->c_code .' - '. $data->c_nama;
     
         })
      ->addColumn('action', function ($data) {
         return '<div class="text-center">
                       <button style="margin-left:5px;" 
                               title="Edit" 
                               type="button"
                               data-toggle="modal" 
                               data-target="#myModalEdit"
                               class="btn btn-warning btn-sm" 
                               onclick="edit('.$data->m_id.')">
                               <i class="fa fa-pencil"></i>
                       </button>
                       <button style="margin-left:5px;" 
                               type="button" 
                               onclick="hapusUser('.$data->m_id.')"
                               class="btn btn-danger btn-sm" 
                               title="Hapus">
                               <i class="fa fa-trash-o"></i>
                       </button>
                 </div>';
     
         })

      ->rawColumns(['action'])

      ->addIndexColumn()  

      ->make(true);
   }

   public function autocompletePegawai(Request $request)
   {
      $term = $request->term;
      $results = array();
      $queries = DB::table('m_pegawai_man')
         ->select('m_pegawai_man.c_id','m_pegawai_man.c_nama', 'm_pegawai_man.c_jabatan_id', 'm_pegawai_man.c_ktp_alamat', 'm_pegawai_man.c_lahir', 'm_jabatan.c_posisi')
         ->join('m_jabatan', function($join) {
               $join->on('m_pegawai_man.c_jabatan_id','=','m_jabatan.c_id');
         })
         ->where('c_nama', 'LIKE', '%'.$term.'%')
         ->take(25)->get();

      foreach ($queries as $val) 
      {
         if ($queries == null) 
         {
               $results[] = [ 'id' => null, 'label' => 'tidak di temukan data terkait'];
         } 
         else {
               $results[] = [ 
                  'id' => $val->c_id,
                  'label' => $val->c_nama,
                  'jabatan_id' => $val->c_jabatan_id,
                  'jabatan_txt' => $val->c_posisi,
                  'lahir_txt' => $val->c_lahir,
                  'alamat_txt' => $val->c_ktp_alamat
               ];
         }
      }

      return response()->json($results);
   }

   public function editUserAkses($id){
      return DB::transaction(function () use ($id) {
          $group = d_group::get();  

          $compGudang = DB::table('m_comp')
                     ->get(); 

          $mem_group = d_mem_access::join('d_group',function($join) use ($id){
              $join->on('ma_mem','=',DB::raw("'$id'"));
              $join->on('ma_group','=','g_id');
          })->groupBy('g_id')->first();
          
          $mem_access = d_access::Leftjoin('d_mem_access',function($join) use ($id){
              $join->on('ma_mem','=',DB::raw("'$id'"));
              $join->on('ma_access','=','a_id');
              $join->on('ma_type','=',DB::raw("'M'"));
          })->orderBy('a_id')->get();
        
         $mem = mMember::leftjoin('m_pegawai_man', 'd_mem.m_pegawai_id', '=', 'm_pegawai_man.c_id' )
                      ->select('d_mem.*', 'm_pegawai_man.c_lahir')
                      ->where('m_id',$id)->first();
 
          if ($mem->m_pegawai_id != null) 
          {
              $posisi = DB::table('m_pegawai_man')
                  ->join('m_jabatan', 'm_pegawai_man.c_jabatan_id', '=', 'm_jabatan.c_id')
                  ->select('m_pegawai_man.c_jabatan_id', 'm_jabatan.c_posisi')
                  ->where('m_pegawai_man.c_id', $mem->m_pegawai_id)->first();
          }
          else
          {
              if ($mem->m_isadmin == 'Y') {
                  $mem->c_lahir = 'Surabaya, 17 Agustus 1945';
                  $posisi = [
                      'c_jabatan_id' => null,
                      'c_posisi' => 'Developer',
                  ];
                  $posisi = (object) $posisi;
              }else{
                  $nm_peg = $mem->m_name;
                  $data_pro = DB::table('m_pegawai_pro')
                      ->join('m_jabatan_pro', 'm_pegawai_pro.c_jabatan_pro_id', '=', 'm_jabatan_pro.c_id')
                      ->select('m_pegawai_pro.c_jabatan_pro_id', 'm_jabatan_pro.c_jabatan_pro')
                      ->where('m_pegawai_pro.c_id', '=', function($query) use ($nm_peg){
                          $query->select('c_id')
                                ->from('m_pegawai_pro')->where('c_nama', 'like', '%'.$nm_peg.'%');
                      })->first();
                  $mem->c_lahir = 'Surabaya, 17 Agustus 1945';
                  $posisi = [
                      'c_jabatan_id' => null,
                      'c_posisi' => $data_pro->c_jabatan_pro
                  ];
                  $posisi = (object) $posisi;
              }
          }
          
          $data = [
              'mem' => $mem,
              'group' => $group,
              'mem_group' => $mem_group,
              'mem_access' => $mem_access,
              'posisi' => $posisi,
              'compGudang' => $compGudang
          ];

         //  return response()->json($data);
        return view('system.manajemenhakakses.edit_user', $data);
     });
  }

   public function perbaruiUser(Request $request, $m_id)
   {
      DB::beginTransaction();
      try 
      {

          $pass_lama = sha1(md5('passwordAllah').trim($request->PassLama));
          $mem_access = d_mem_access::where('ma_mem', $m_id)->first();
          //dd($mem_access);
          if (!empty($mem_access)) {
              $mMember = mMember::find($m_id);
              $mMember->m_username = $request->Username;
              if ($request->IdPegawai != null) {
                  $mMember->m_name = $request->NamaLengkap;
                  $mMember->m_addr = $request->alamat;
              }
              // $mMember->m_birth_tgl = $hasilTgl;
              $mMember->m_update = Carbon::now('Asia/Jakarta');
              if ($pass_lama == $mMember->m_passwd) {
                  $mMember->m_passwd = sha1(md5('passwordAllah').trim($request->PassBaru));
              }
              $mMember->save();

              DB::table('d_mem_access')->where('ma_mem','=',$m_id)->delete();
              
              $hakAkses = d_group::join('d_group_access','ga_group','=','g_id')
                ->join('d_access','a_id','=','ga_access')
                ->where('g_id',$request->groupAkses)->get();

              for ($i=0; $i < count($hakAkses) ; $i++) {
                  d_mem_access::create([
                     'ma_mem' => $m_id,
                     'ma_access' => $hakAkses[$i]->a_id,
                     'ma_group' => $hakAkses[$i]->g_id ,
                     'ma_type' => 'G',
                     'ma_read' => $hakAkses[$i]->ma_read,
                     'ma_insert' => $hakAkses[$i]->ma_insert,
                     'ma_update' => $hakAkses[$i]->ma_update,
                     'ma_delete' => $hakAkses[$i]->ma_delete
                  ]);
              }

              if($request->groupAkses == null)
              {
                  $hakAkses=d_access::get();
                  d_mem_access::create([
                     'ma_mem' => $m_id,
                     'ma_access'=> $hakAkses[$i]->a_id,
                     'ma_group' => 0,
                     'ma_type' => 'G'
                  ]);
              }

              for ($i=0; $i < count($request->id_access); $i++) { 
                  d_mem_access::create([
                     'ma_mem' =>$m_id,
                     'ma_access'=>$request->id_access[$i],
                     'ma_type' =>'M',
                     'ma_read'=> $request->ma_read[$i],
                     'ma_insert'=> $request->ma_insert[$i],
                     'ma_update'=> $request->ma_update[$i],
                     'ma_delete'=> $request->ma_delete[$i]
                  ]);
              }
              if ($request->perusahaan != null) 
              {
                  DB::table('d_mem_comp')
                     ->where('mc_mem',$m_id)->delete();

                  for ($i=0; $i < count($request->perusahaan); $i++) 
                  { 
                     DB::table('d_mem_comp')
                        ->insert([
                           'mc_mem' => $m_id,
                           'mc_comp' => $request->perusahaan[$i],
                           'mc_active' => 'Y',
                           'mc_update' => Carbon::now()
                        ]);
                  }
              }

              DB::commit();
              return response()->json([
                  'status' => 'sukses',
                  'pesan' => 'Berhasil Update data Hak Akses User'
              ]);
          }
          else
          {
              DB::commit();
              return response()->json([
                  'status' => 'gagal',
                  'pesan' => 'Tidak terdapat data yang akan diubah'
              ]); 
          }
      }
      catch (\Exception $e) 
      {
        DB::rollback();
        return response()->json([
              'status' => 'gagal',
              'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
          ]); 
      }    
  }    

    public function hapusUser(Request $request)
    {
        DB::beginTransaction();
        try {  
          $mem_access = DB::table('d_mem_access')->where('ma_mem','=',$request->id)->delete();
          $dMemComp = d_mem_comp::where('mc_mem','=',$request->id)->delete();
          $d_mem = DB::table('d_mem')->where('m_id','=',$request->id)->delete();
          DB::commit();
          return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Berhasil Dihapus'
          ]);
        } 
        catch (\Exception $e) 
        {
          DB::rollback();
          return response()->json([
              'status' => 'gagal',
              'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
          ]);
        }
    }

}
