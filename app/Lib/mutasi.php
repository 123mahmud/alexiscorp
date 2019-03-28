<?php
namespace App\Lib;

use App\d_stock_mutation;

use App\d_stock;

use DB;

class mutasi{
    /*($item,
    $totalPermintaan,
    $compTujuan,
    $positionTujuan,
    'TransferProduksi',
    11,
    $sm_reff,
    '',
    '',
    $getBarang[$k]->sm_hpp,
    $date)*/
    public static function tambahmutasi(
        $item,
        $totalPermintaan,
        $comp,
        $position,
        $flag,
        $mutcat,
        $sm_reff,
        $flagTujuan,
        $idMutasiTujuan,
        $hpp,
        $date
        ){
        return DB::transaction(function () use (
            $item,
            $totalPermintaan,
            $comp,
            $position,
            $flag,
            $mutcat,
            $sm_reff,
            $flagTujuan,
            $idMutasiTujuan,
            $hpp,
            $date
            ) {              

                $totalHpp='';
                    
                $updateStock=d_stock::where('s_item',$item)->where('s_comp',$comp)->where('s_position',$position);
                if(!$updateStock->first()){

                $idStock=d_stock::max('s_id')+1;
                        d_stock::create([
                                's_id'=>$idStock,
                                's_comp'=>$comp,
                                's_position'=>$position,
                                's_item'=>$item,
                                's_qty'=>$totalPermintaan,
                        ]);
                    
                }else{
                        $qty=$updateStock->first()->s_qty+$totalPermintaan;             
                        $updateStock->update([
                                's_qty'=>$qty
                            ]);             
            
                }
                

                    
            $sm_detailid=d_stock_mutation::where('sm_stock',$updateStock->first()->s_id)->max('sm_detailid')+1;
            d_stock_mutation::create([
                'sm_stock'=>$updateStock->first()->s_id,
                'sm_detailid'=>$sm_detailid,
                'sm_date' =>$date,
                'sm_comp' =>$comp,
                'sm_position'=>$position,                
                'sm_mutcat'=>$mutcat,
                'sm_item'=>$item ,
                'sm_qty'=>$totalPermintaan,
                'sm_qty_used'=>0,
                'sm_qty_sisa'=>$totalPermintaan,
                'sm_qty_expired'=>0,
                'sm_detail'=>$flag,
                'sm_hpp'=>$hpp,
                'sm_reff'=>$sm_reff,            
            ]);
            $totalHpp=$hpp*$totalPermintaan;
            $data=['true'=>true,'totalHpp'=>$totalHpp];
            return $data;
    });


    }



      public static function perbaruimutasi($item,$totalPermintaan,$comp,$position,$flag,$idFlag,$sm_reff,$flagTujuan,$idMutasiTujuan,$hpp){
    return DB::transaction(function () use ($item,$totalPermintaan,$comp,$position,$flag,$idFlag,$sm_reff,$flagTujuan,$idMutasiTujuan,$hpp){
                $totalHpp='';

                $updateMutasi=d_stock_mutation::where('sm_reff',$sm_reff)->where('sm_item',$item)->where('sm_qty','>',0); 



                

                $updateStock=d_stock::where('s_item',$item)->where('s_comp',$comp)->where('s_position',$position);
                
                        $qty=$updateStock->first()->s_qty+$totalPermintaan;                                     
                        
                        $updateStock->update([
                                's_qty'=>$qty
                            ]);             
            
            
            
            
            $updateMutasi->update([
                'sm_stock'=>$updateStock->first()->s_id,                                                                 
                'sm_qty'=>$updateMutasi->first()->sm_qty+$totalPermintaan,                
                'sm_qty_sisa'=>$updateMutasi->first()->sm_qty+$totalPermintaan,                                
                'sm_hpp'=>$hpp,                     
            ]);
  
            $totalHpp=$hpp*($updateMutasi->first()->sm_qty+$totalPermintaan);
            $data=['true'=>true,'totalHpp'=>$totalHpp];
            return $data;
        
    });


    }
public static function hapusMutasi($item,$permintaan,$comp,$position,$flag,$sm_reff){
    return DB::transaction(function () use ($item,$permintaan,$comp,$position,$flag,$sm_reff) {   
          $totalHpp=0;

          $updateStock=d_stock::where('s_item',$item)->where('s_comp',$comp)->where('s_position',$position);                                
                        $qty=$updateStock->first()->s_qty-$permintaan;             
                        $updateStock->update([
                                's_qty'=>$qty
                            ]);             
            


        $d_stock_mutation=d_stock_mutation::where('sm_reff',$sm_reff)->where('sm_item',$item)->where('sm_qty',$permintaan);

        
        $d_stock_mutation->delete(); 

            $data=['true'=>true,'totalHpp'=>$totalHpp];
            return $data;




    });
}

	public static function mutasiStok($item,$totalPermintaan,$comp,$position,$flag='Penjualan Toko',$sm_reff,$sm_ket='',$date,$mutcat=null){	
        return DB::transaction(function () use ($item,$totalPermintaan,$comp,$position,$flag,$sm_reff,$sm_ket,$date,
            $mutcat) {   


            $totalPermintaan= format::format($totalPermintaan);
            $totalHpp=0;
            
			$updateStock=d_stock::where('s_item',$item)->where('s_comp',$comp)->where('s_position',$position);		

            if(empty($updateStock->first())) {
                 $data=['true'=>false,'totalHpp'=>$totalHpp,'text'=>"Ma'af, Stok Tidak Mencukupi"];
                 return $data;
            }else{
    			if($updateStock->first()->s_qty>=$totalPermintaan){
    				$qty=$updateStock->first()->s_qty-$totalPermintaan;				
    				$updateStock->update([
    						's_qty'=>$qty
    					]);				
    			}else{				
            
            $data=['true'=>false,'totalHpp'=>$totalHpp];
            return $data;
        
    			}
            }
		 	$getBarang=d_stock_mutation::where('sm_qty_sisa','>',0)->where('sm_item',$item)->where('sm_comp',$comp)
		 			   ->where('sm_position',$position)->get();		 	
            
            /*$totalPermintaan = 35;*/
            $newMutasi=[];
            $updateMutasi=[];
            

                       
                    for ($k = 0; $k < count($getBarang); $k++) {
                    	$sm_detailidInsert=d_stock_mutation::where('sm_item',$item)->where('sm_comp',$comp)
		 			   ->where('sm_position',$position)->max('sm_detailid')+$k+1;

                        $totalQty = $getBarang[$k]->sm_qty_sisa;                                  
                        if ($totalPermintaan <= $totalQty) {
                        	$qty_used=$getBarang[$k]->sm_qty_used+$totalPermintaan;
                        	$qty_sisa = $getBarang[$k]->sm_qty_sisa-$totalPermintaan;


                        	$sm_stock=$getBarang[$k]->sm_stock;
                            $sm_detailid = $getBarang[$k]->sm_detailid;


                        $updateStokMutasi=d_stock_mutation::where('sm_stock',$sm_stock)
                                          ->where('sm_detailid',$sm_detailid);   


                        $updateStokMutasi->update([                                                             
                                'sm_qty_used'=>$qty_used,
                                'sm_qty_sisa'=>$qty_sisa
                            ]);

                        	$newMutasi[$k]['sm_stock']=$getBarang[$k]->sm_stock;
                            $newMutasi[$k]['sm_detailid'] = $sm_detailidInsert;
                            $newMutasi[$k]['sm_date'] = $date;
                            $newMutasi[$k]['sm_comp'] = $comp;
                            $newMutasi[$k]['sm_position'] = $position;
                            $newMutasi[$k]['sm_item'] = $item;
                            $newMutasi[$k]['sm_qty'] = -$totalPermintaan;
                            $newMutasi[$k]['sm_hpp'] = $getBarang[$k]->sm_hpp;
                            $newMutasi[$k]['sm_detail'] =$flag;
                            $newMutasi[$k]['sm_keterangan'] =$sm_ket;
                            $newMutasi[$k]['sm_reff'] = $sm_reff;  
                            $newMutasi[$k]['sm_stockreff'] = $getBarang[$k]->sm_stock;  
                            $newMutasi[$k]['sm_detailreff'] = $getBarang[$k]->sm_detailid;  
                            // $newMutasi[$k]['sm_mutcat'] =$getBarang[$k]->sm_mutcat;
                            $newMutasi[$k]['sm_mutcat'] =$mutcat;      
                            $totalHpp+=$totalPermintaan*$getBarang[$k]->sm_hpp;        
                            $k = count($getBarang);
                            
                        } elseif ($totalPermintaan > $totalQty) {
                        	$qty_used=$getBarang[$k]->sm_qty_used+$totalQty;
                        	$qty_sisa =$getBarang[$k]->sm_qty_sisa-$totalQty;                        	
                        	$sm_stock=$getBarang[$k]->sm_stock;
                            $sm_detailid = $getBarang[$k]->sm_detailid;
                            

                              $updateStokMutasi=d_stock_mutation::where('sm_stock',$sm_stock)
                                          ->where('sm_detailid',$sm_detailid);   


                        $updateStokMutasi->update([                                                             
                                'sm_qty_used'=>$qty_used,
                                'sm_qty_sisa'=>$qty_sisa
                            ]);

                        	$newMutasi[$k]['sm_stock']=$getBarang[$k]->sm_stock;
                            $newMutasi[$k]['sm_detailid'] = $sm_detailidInsert;
                            $newMutasi[$k]['sm_date'] = $date;
                            $newMutasi[$k]['sm_comp'] = $comp;
                            $newMutasi[$k]['sm_position'] = $position;
                            $newMutasi[$k]['sm_item'] = $item;
                            $newMutasi[$k]['sm_qty'] = -$totalQty;
                            $newMutasi[$k]['sm_hpp'] = $getBarang[$k]->sm_hpp;
                            $newMutasi[$k]['sm_detail'] =$flag;
                            $newMutasi[$k]['sm_reff'] = $sm_reff; 
                            $newMutasi[$k]['sm_keterangan'] =$sm_ket;

                            $newMutasi[$k]['sm_stockreff'] = $getBarang[$k]->sm_stock;  
                            $newMutasi[$k]['sm_detailreff'] = $getBarang[$k]->sm_detailid;  
                            // $newMutasi[$k]['sm_mutcat'] =$getBarang[$k]->sm_mutcat;    
                            $newMutasi[$k]['sm_mutcat'] =$mutcat;
                            $totalHpp+=$totalQty*$getBarang[$k]->sm_hpp;        
                            
                            $totalPermintaan = $totalPermintaan - $totalQty;
                        }
                    }

                    DB::table('d_stock_mutation')->insert($newMutasi);

                    $data=['true'=>true,'totalHpp'=>$totalHpp];
                    return $data;
                });
	}
    
    public static function updateMutasi($item,$totalPermintaan,$comp,$position,$flag='',$sm_reff='',$sm_ket='',$date='',$mutcat=''){
        return DB::transaction(function () use ($item,$totalPermintaan,$comp,$position,$flag,$sm_reff,$sm_ket,$date,$mutcat) {   

        if ($totalPermintaan>0) {            
            
             $mutasiStok=new mutasi;             
             return $mutasiStok->mutasiStok($item,$totalPermintaan,$comp,$position,$flag,$sm_reff,$sm_ket,$date,$mutcat=null);
        }else{               
            
            $getBarang=d_stock_mutation::where('sm_item',$item)->where('sm_comp',$comp)
                       ->where('sm_position',$position)->where('sm_reff',$sm_reff)
                       ->orderBy('sm_detailid','DESC')->where('sm_qty','<',0)->get();
                       
            //mencari harga sebelum di hapus
            $totalHpp=0;

            $sm_hpp=[];
            $updateMutasi=[];
            $hapusMutasi=[];
            $awaltotalPermintaan=abs($totalPermintaan);
            $totalPermintaan=abs($awaltotalPermintaan);
            for ($k = 0; $k < count($getBarang); $k++) {                
                $totalQty=abs($getBarang[$k]->sm_qty);                
                    if ($totalPermintaan <= $totalQty) {

                            $hapusMutasi[$k]['sm_stock']    =$getBarang[$k]->sm_stock;
                            $hapusMutasi[$k]['sm_detailid'] = $getBarang[$k]->sm_detailid;
                            $hapusMutasi[$k]['sm_qty'] =-(abs($getBarang[$k]->sm_qty)-$totalPermintaan);

                            $sm_hpp[$k]=$getBarang[$k]->sm_hpp;
                            $k = count($getBarang);
                        }
                        elseif ($totalPermintaan  > $totalQty) {
                            $hapusMutasi[$k]['sm_stock']    =$getBarang[$k]->sm_stock;
                            $hapusMutasi[$k]['sm_detailid'] = $getBarang[$k]->sm_detailid;
                            $hapusMutasi[$k]['sm_qty'] =abs($getBarang[$k]->sm_qty)-$totalQty;                            
                            $sm_hpp[$k]=$getBarang[$k]->sm_hpp;
                            $totalPermintaan = $totalPermintaan - $totalQty;
                        }
            }
         $getBarangx=d_stock_mutation::where('sm_qty_used','>',0)->where('sm_item',$item)->where('sm_comp',$comp)
                       ->where('sm_position',$position)->whereIn('sm_hpp',$sm_hpp)
                       ->orderBy('sm_detailid','DESC')->get();

        
$totalPermintaan=abs($awaltotalPermintaan);

                          for ($k = 0; $k < count($getBarangx); $k++) {
                            
                            $totalQty=abs($getBarangx[$k]->sm_qty_used);  
                            if ($totalPermintaan <= $totalQty) {

                           
                            $qty_used=$getBarangx[$k]->sm_qty_used-$totalPermintaan;
                            $qty_sisa =$getBarangx[$k]->sm_qty_sisa- $totalPermintaan;

                                $updateMutasi[$k]['sm_stock']    =$getBarangx[$k]->sm_stock;
                                $updateMutasi[$k]['sm_detailid'] = $getBarangx[$k]->sm_detailid;
                                $updateMutasi[$k]['sm_qty_used'] =$getBarangx[$k]->sm_qty_used-$totalPermintaan;
                                $updateMutasi[$k]['sm_qty_sisa'] =$totalPermintaan+$getBarangx[$k]->sm_qty_sisa;                                
                                $updateMutasi[$k]['sm'] =$totalPermintaan; 
                                $updateMutasi[$k]['s'] ='x'; 

                            $k = count($getBarangx);
                            }
                            elseif ($totalPermintaan > $totalQty) {
                                
                                $updateMutasi[$k]['sm_stock']    =$getBarangx[$k]->sm_stock;
                                $updateMutasi[$k]['sm_detailid'] = $getBarangx[$k]->sm_detailid;
                                $updateMutasi[$k]['sm_qty_used'] =0;
                                $updateMutasi[$k]['sm_qty_sisa'] =$getBarangx[$k]->sm_qty_sisa+$getBarangx[$k]->sm_qty_used;
                                $updateMutasi[$k]['sm'] =$totalPermintaan+$getBarangx[$k]->sm_qty_used; 
                                $updateMutasi[$k]['s'] ='c2'; 

                                $totalPermintaan = $totalPermintaan - $totalQty;


                            }
                          }

            for ($sm=0; $sm <count($hapusMutasi); $sm++) { 
                    if($hapusMutasi[$sm]['sm_qty']==0){
                        $updateStokMutasi=d_stock_mutation::where('sm_stock',$hapusMutasi[$sm]['sm_stock'])
                                          ->where('sm_detailid',$hapusMutasi[$sm]['sm_detailid'])->delete(); 
                    }
                    else{                        
                        $updateStokMutasi=d_stock_mutation::where('sm_stock',$hapusMutasi[$sm]['sm_stock'])
                                          ->where('sm_detailid',$hapusMutasi[$sm]['sm_detailid']); 
                        $updateStokMutasi->update([                                                             
                                'sm_qty'=>$hapusMutasi[$sm]['sm_qty'],                                
                            ]);
                    }
            }


            
            for ($sm=0; $sm <count($updateMutasi); $sm++) { 
                        $updateStokMutasi=d_stock_mutation::where('sm_stock',$updateMutasi[$sm]['sm_stock'])
                                          ->where('sm_detailid',$updateMutasi[$sm]['sm_detailid']); 
                        $updateStokMutasi->update([                                                             
                                'sm_qty_used'=>$updateMutasi[$sm]['sm_qty_used'],
                                'sm_qty_sisa'=>$updateMutasi[$sm]['sm_qty_sisa']
                            ]);
            }

            $updateStock=d_stock::where('s_item',$item)->where('s_comp',$comp)->where('s_position',$position);

            $qty=$updateStock->first()->s_qty+$awaltotalPermintaan; 

            $updateStock->update([
                    's_qty'=>$qty
                ]);

            $totalHpp=$awaltotalPermintaan*5;
            $data=['true'=>true,'totalHpp'=>$totalHpp];
            return $data;           
            
        }
    });

    }
    public static function u(){
        $m=new mutasi;

        return $m->v();
    }
     public function v(){
        return 'f';
    }

    public static function deleteMutasi($item,$totalPermintaan,$comp,$position,$flag='',$sm_reff=''){
          $getBarang=d_stock_mutation::where('sm_item',$item)->where('sm_comp',$comp)
                       ->where('sm_position',$position)->where('sm_reff',$sm_reff)
                       ->orderBy('sm_detailid','DESC')->get();    
    }


    public static function simpanTranferMutasi($item,$totalPermintaan,$comp,$position,$flag='Penjualan Toko',$sm_reff,$sm_ket='',$date,$compTujuan,$positionTujuan,$mutcatTujuan,$detailTujuan){ 
        return DB::transaction(function () use ($item,$totalPermintaan,$comp,$position,$flag,$sm_reff,$sm_ket,$date,$compTujuan,$positionTujuan,$mutcatTujuan,$detailTujuan) {   

            $totalPermintaan= format::format($totalPermintaan);
            $totalHpp=0;

            $updateStock=d_stock::where('s_item',$item)->where('s_comp',$comp)->where('s_position',$position);      
            
            if(!$updateStock->first()->s_qty){
                $idStock=d_stock::max('s_id')+1;
                d_stock::create([
                        's_id'=>$idStock,
                        's_comp'=>$comp,
                        's_position'=>$position,
                        's_item'=>$item,
                        's_qty'=>$totalPermintaan,
                    ]);
            }else{
                if($updateStock->first()->s_qty>=$totalPermintaan){
                    $qty=$updateStock->first()->s_qty-$totalPermintaan;             
                    $updateStock->update([
                            's_qty'=>$qty
                        ]);             
                }else{              
                    /*DB::rollBack();         */
                    
            
            $data=['true'=>false,'totalHpp'=>$totalHpp];
            return $data;
        
                }
            }





            $getBarang=d_stock_mutation::where('sm_qty_sisa','>',0)->where('sm_item',$item)->where('sm_comp',$comp)
                       ->where('sm_position',$position)->get();         
            
            /*$totalPermintaan = 35;*/
            $newMutasi=[];
            $updateMutasi=[];
            

                       
                    for ($k = 0; $k < count($getBarang); $k++) {
                        $sm_detailidInsert=d_stock_mutation::where('sm_item',$item)->where('sm_comp',$comp)
                       ->where('sm_position',$position)->max('sm_detailid')+$k+1;

                        $totalQty = $getBarang[$k]->sm_qty_sisa;                                  
                        if ($totalPermintaan <= $totalQty) {
                            $qty_used=$getBarang[$k]->sm_qty_used+$totalPermintaan;
                            $qty_sisa = $getBarang[$k]->sm_qty_sisa-$totalPermintaan;


                            $sm_stock=$getBarang[$k]->sm_stock;
                            $sm_detailid = $getBarang[$k]->sm_detailid;


                        $updateStokMutasi=d_stock_mutation::where('sm_stock',$sm_stock)
                                          ->where('sm_detailid',$sm_detailid);   


                        $updateStokMutasi->update([                                                             
                                'sm_qty_used'=>$qty_used,
                                'sm_qty_sisa'=>$qty_sisa
                            ]);






                            $newMutasi[$k]['sm_stock']=$getBarang[$k]->sm_stock;
                            $newMutasi[$k]['sm_detailid'] = $sm_detailidInsert;
                            $newMutasi[$k]['sm_date'] = $date;
                            $newMutasi[$k]['sm_comp'] = $comp;
                            $newMutasi[$k]['sm_position'] = $position;
                            $newMutasi[$k]['sm_item'] = $item;
                            $newMutasi[$k]['sm_qty'] = -$totalPermintaan;
                            $newMutasi[$k]['sm_hpp'] = $getBarang[$k]->sm_hpp;
                            $newMutasi[$k]['sm_detail'] =$detailTujuan;
                            $newMutasi[$k]['sm_keterangan'] =$sm_ket;
                            $newMutasi[$k]['sm_reff'] = $sm_reff;  
                            $newMutasi[$k]['sm_mutcat'] =$mutcatTujuan;  

                            $newMutasi[$k]['sm_stockreff'] = $getBarang[$k]->sm_stock;  
                            $newMutasi[$k]['sm_detailreff'] = $getBarang[$k]->sm_detailid;  

                            $totalHpp+=$totalPermintaan*$getBarang[$k]->sm_hpp;        


$mutasiStok=new mutasi;
$mutasiStok->tambahmutasi($item,$totalPermintaan,$compTujuan,$positionTujuan,'TransferProduksi',11,$sm_reff,'','',$getBarang[$k]->sm_hpp,$date);

                            $k = count($getBarang);






                        } elseif ($totalPermintaan > $totalQty) {
                            $qty_used=$getBarang[$k]->sm_qty_used+$totalQty;
                            $qty_sisa =$getBarang[$k]->sm_qty_sisa-$totalQty;                           
                            $sm_stock=$getBarang[$k]->sm_stock;
                            $sm_detailid = $getBarang[$k]->sm_detailid;
                            

                              $updateStokMutasi=d_stock_mutation::where('sm_stock',$sm_stock)
                                          ->where('sm_detailid',$sm_detailid);   


                        $updateStokMutasi->update([                                                             
                                'sm_qty_used'=>$qty_used,
                                'sm_qty_sisa'=>$qty_sisa
                            ]);




                            $newMutasi[$k]['sm_stock']=$getBarang[$k]->sm_stock;
                            $newMutasi[$k]['sm_detailid'] = $sm_detailidInsert;
                            $newMutasi[$k]['sm_date'] = $date;
                            $newMutasi[$k]['sm_comp'] = $comp;
                            $newMutasi[$k]['sm_position'] = $position;
                            $newMutasi[$k]['sm_item'] = $item;
                            $newMutasi[$k]['sm_qty'] = -$totalQty;
                            $newMutasi[$k]['sm_hpp'] = $getBarang[$k]->sm_hpp;
                            $newMutasi[$k]['sm_detail'] =$detailTujuan;
                            $newMutasi[$k]['sm_reff'] = $sm_reff; 
                            $newMutasi[$k]['sm_keterangan'] =$sm_ket;
                            $newMutasi[$k]['sm_mutcat'] =$mutcatTujuan;    

                            $newMutasi[$k]['sm_stockreff'] = $getBarang[$k]->sm_stock;  
                            $newMutasi[$k]['sm_detailreff'] = $getBarang[$k]->sm_detailid;  

                            $totalHpp+=$totalQty*$getBarang[$k]->sm_hpp;        
                            
                            $totalPermintaan = $totalPermintaan - $totalQty;


$mutasiStok=new mutasi;
$mutasiStok->tambahmutasi($item,$totalPermintaan,$compTujuan,$positionTujuan,'Transfer Produksi',11,$sm_reff,$flagTujuan,$idMutasiTujuan,$getBarang[$k]->sm_hpp,$date);


                        }
                    }

                    DB::table('d_stock_mutation')->insert($newMutasi);

                    $data=['true'=>true,'totalHpp'=>$totalHpp];
                    return $data;
                });
    }
    static function c(){
        return 'aku';
    }
}