<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use Datatables;
use URL;
use App\m_item_price;
use App\m_price_group;
use App\m_item;

class DataHargaController extends Controller
{
    public function index()
    {
    	$group = m_price_group::where('pg_active','Y')
    		->get();

    	return view('master.dataharga.index',compact('group'));
    }

    public function tableGroup($id){
    	$item = m_item_price::select('ip_item',
    								'i_name',
    								'ip_price',
                                    'i_code')
    		->join('m_item','m_item.i_id','=','ip_item')
    		->where('ip_group',$id)
    		->get();
    	
    	return DataTables::of($item)

    	->editColumn('i_name', function ($data)
        {
            return $data->i_code.' - '.$data->i_name;
        })

        ->editColumn('ip_price', function ($data)
        {
            return '<div>
                      <span class="pull-right">
                        '.number_format( $data->ip_price ,2,'.',',').'
                      </span>
                    </div>';
        })

    	->addColumn('action', function($data)
		{
		  return '<div class="text-center">
		            <a onclick=hapus('.$data->ip_item.')
		              class="btn btn-danger btn-sm"
		              title="Hapus">
		              <i class="fa fa-trash-o"></i>
		            </a>
		          </div>';

		})
    	->rawColumns(['ip_price','action','i_name'])
        ->make(true);

    }

    public function tableMasterGroup(){
    	$masterGroup = m_price_group::all();

    	return DataTables::of($masterGroup)
    	->addIndexColumn()

        ->addColumn('pg_name', function ($data) {
            return $data->pg_code.' - '.$data->pg_name;
        })
    	->addColumn('action', function ($data) {
      	if ($data->pg_active == 'Y') {
      		return  '<div class="text-center">'.
	      				'<button id="edit" 
							onclick="edit('.$data->pg_id.')" 
                            class="btn btn-warning btn-sm" 
                            title="Edit">
                            <i class="fa fa-pencil"></i>
	   					</button>'.'
	                    <button id="status'.$data->pg_id.'" 
	        				onclick="ubahStatus('.$data->pg_id.')" 
	        				class="btn btn-primary btn-sm" 
	        				title="Aktif">
	        				<i class="fa fa-check-square" aria-hidden="true"></i>
	                    </button>'.
                    '</div>';
      	}else{
      		return  '<div class="text-center">'.
	      				'<button id="status'.$data->pg_id.'" 
	        				onclick="ubahStatus('.$data->pg_id.')" 
	        				class="btn btn-danger btn-sm" 
	        				title="Tidak Aktif">
	        				<i class="fa fa-minus-square" aria-hidden="true"></i>
	                    </button>'.
	                '</div>';
      	}
      })
		->rawColumns(['action', 'pg_name'])
    	->make(true);
    }
    
    public function insertGroup(Request $request){     
    	DB::beginTransaction();
            try {
    	$id = m_price_group::select('pg_id')->max('pg_id')+1;
        $code = 'PG000'.$id;
    	m_price_group::create([
    		'pg_id' => $id,
            'pg_code' => $code,
            'pg_name' => $request->pg_name,
            'pg_created' => Carbon::now()

    	]);
    	DB::commit();
	    return response()->json([
	          'status' => 'sukses'
	      ]);
	    } catch (\Exception $e) {
	    DB::rollback();
	    return response()->json([
	        'status' => 'gagal',
	        'data' => $e
	      ]);
	    }
    }

    public function moveStatusGroup($id){
    	DB::beginTransaction();
            try {
    	$data = m_price_group::where('pg_id',$id)
    		->first();
    	if ($data->pg_active == 'Y') 
    	{
    		$data->update([
    			'pg_active' => 'N'
    		]);
    	}
    	else
    	{
    		$data->update([
    			'pg_active' => 'Y'
    		]);
    	}
    	DB::commit();
	    return response()->json([
	          'status' => 'sukses'
	      ]);
	    } catch (\Exception $e) {
	    DB::rollback();
	    return response()->json([
	        'status' => 'gagal',
	        'data' => $e
	      ]);
	    }
    }

    public function editGroup(Request $request){
    	$group = m_price_group::where('pg_id',$request->x)
    		->first();

        return response()->json([
                           'status'=>$group
                     ]);
    }

    public function updateGroup(Request $request, $id){
    	DB::beginTransaction();
            try {
    	m_price_group::where('pg_id',$id)
    		->update([
    			'pg_name' => $request->pg_name,
    			'pg_updated' => Carbon::now()
    		]);
    	DB::commit();
	    return response()->json([
	          'status' => 'sukses'
	      ]);
	    } catch (\Exception $e) {
	    DB::rollback();
	    return response()->json([
	        'status' => 'gagal',
	        'data' => $e
	      ]);
	    }
    }

    public static function autocomplete(Request $request)
    {
        
        $search = $request->term;        
        $sql=DB::table('m_item')             
            ->join('m_satuan','m_satuan.s_id','=','i_sat1')
            ->where('i_name','like','%'.$search.'%')                                    
            ->orWhere('i_code','like','%'.$search.'%')
            ->get();
               
        $sql=$sql->get();
        

        $results=[];
        foreach ($sql as $query)
          {
            $results[] = [  'id' => $query->i_id, 
                            'label' => $query->i_code .' - '.$query->i_name,
                            'name' => $query->i_name,
                            'id_satuan' => [$query->i_sat1],
                            'satuan' => [$query->s_name],
                            'i_code' => $query->i_code];

          }

          
      return Response::json($results);


    }

    public function saveHargaItem(Request $request){    
    	DB::beginTransaction();
        try{

        	$cek = m_item_price::where('ip_group',$request->group)
        		->where('ip_item',$request->i_id)
        		->first();
        		// dd($cek);
        	if ($cek != null) 
        	{
        		m_item_price::where('ip_group',$request->group)
        		->where('ip_item',$request->i_id)
        		->update([
        			'ip_price' => str_replace(',', '', $request->price)
        		]);
        	}
        	else
        	{
        		m_item_price::create([
	        		'ip_group' => $request->group,
	        		'ip_item' => $request->i_id,
	        		'ip_price' => str_replace(',', '', $request->price)
	        	]);	
        	}
        	
        DB::commit();
	    return response()->json([
	          'status' => 'sukses'
	      ]);
	    } catch (\Exception $e) {
	    DB::rollback();
	    return response()->json([
	        'status' => 'gagal',
	        'data' => $e
	      ]);
	    }
    }

    public function deleteItemHarga(Request $request, $id)
    {
    	DB::beginTransaction();
        try{
        	m_item_price::where('ip_group',$request->idGroup)
        		->where('ip_item',$id)
        		->delete();
        DB::commit();
	    return response()->json([
	          'status' => 'sukses'
	      ]);
	    } catch (\Exception $e) {
	    DB::rollback();
	    return response()->json([
	        'status' => 'gagal',
	        'data' => $e
	      ]);
	    }
    }

}
