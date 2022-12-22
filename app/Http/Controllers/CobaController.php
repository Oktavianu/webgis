<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CobaController extends Controller
{
    public function index(){
        
        // //$tes = ["makan","minum","tidur"];
        // $tes["makan"] = "Makan";
        // $tes["minum"] = "Minum";
        // $tes["tidur"] = "Tidur";
        // $tes["joging"] = "Joging";
        // $tes["ngopi"] = "Ngopi";
        // $tes["santai"] = "Santai";
        // $tes["rajin"] = "Rajin";
        // $tes["malas"] = "Malas";
        // $tes["lari"] = "Lari";
        
        // $will_insert = [];
        //     foreach($tes as $key => $value ){
        // //             $master_nilai = Master_nilai::where('id',$value)->first();
        //             // $nama = $master_nilai->nama;
        //              // $bobot = $master_nilai->bobot;
        //              array_push($will_insert, $value);
        //         }
        //     //return $will_insert[2];

        //     if ( $tes["makan"] == $will_insert[0]){
        //         $cek = "sama = tidur";
        //     }else{
        //         $cek = "Tidak sama = no tidur";
        //     }

        //     return $cek;

       $i = 10;
       for ($a=$i; $a>0; $a--){

        for($ab=1; $ab<=$a; $ab++){
            echo "&nbsp";
        }

        for ($b=$i; $b >= $a; $b--){
            //$c = $i - $b + 1;
            echo "*";
        }
        echo "<br>";
       }

    //    $i = 5;
    //    for ($a=$i; $a>0; $a--){

    //     for ($b = 1; $b <= $a; $b++){
    //         //$c = $i - $b + 1;
    //         echo "$b";
    //     }
        
    //     echo "<br>";
    //    }

    }

    public function store(Request $request, $id) {
        // buka //
        if(!empty($request->input('yes'))) {
            $request_yes = count($request->input('yes'));
            $yes = $request->input('yes');
        }else{
            $request_yes = "0";
            $yes = '';
        }
        if(!empty($request->input('no'))) {
            $request_no = count($request->input('no'));
            $no = $request->input('no');
        }else{
            $request_no = "0";
            $no = '';
        }
        // tutu p//
        $jumlah_master_nilai = Master_nilai::count();
        $jumlah_request = $request_yes + $request_no ;
        if($jumlah_request == $jumlah_master_nilai){
            if($yes) {
                $will_insert = [];
                foreach($request->input('yes') as $key => $value ){
                    $master_nilai = Master_nilai::where('id',$value)->first();
                    $nama = $master_nilai->nama;
                    $bobot = $master_nilai->bobot;
                    array_push($will_insert, ['nama'=>$nama,'id_proposal'=>$id, 'nilai'=> $bobot]);
                }
                Nilai::insert($will_insert);
    
            }if($no) {
                $will_insert = [];
                foreach($request->input('no') as $key => $value ){
                    $master_nilai = Master_nilai::where('id',$value)->first();
                    $nama = $master_nilai->nama;
                    array_push($will_insert, ['nama'=>$nama,'id_proposal'=>$id, 'nilai'=> 0]);
                }
                Nilai::insert($will_insert);
            }
                //insert status terima fersi baru dibuat tangal 05 juni 2021
                $data = Nilai::where('id_proposal', $id)->count();
                $cek_nilai = Nilai::where('nilai','>',0)->where('id_proposal',$id)->count();
                if ($data){
                    $a = '100';
                    //count data master nilai tgl 08 juni 2021
                    $b = Master_nilai::count();
                    $nilai = $cek_nilai * $a/$b;
                    Proposal::where('id',$id)->update(['nilai' => $nilai]);
                    if($nilai > 70){
                        Proposal::where('id',$id)->update(['status_terima' => 1 ]);
                        $status = "DITERIMA";
                    }else{
                        Proposal::where('id',$id)->update(['status_terima' => 0 ]);
                        $status = "DITOLAK";
                    }
                }
                //tutup//
    
                //menamoung judul proposal
                $judul = Proposal::where('id',$id)->first()->judul_proposal;
    
                //insert Beban//
                $id_penilai = \Auth::guard('user')->user()->id;
                $jumlah_beban = Proposal::where('penilai',$id_penilai)->whereNull('status_terima')->count();
                User::where('id',$id_penilai)->update(['beban' => $jumlah_beban]);
                // tutup insert beban //
            \Session::flash('sukses','Status pengajuan PKM dengan judul ' .$judul. ' dinyatakan ' .$status. ' Dengan sekor nilai ' .$nilai);
            return redirect('peserta_pkm');   
        }else{
            \Session::flash('gagal','Priksa kembali penilaiaan anda, pastika setiap kriteria sudah di nilai !');
            return redirect()->back();
        }
        
    }


    public function coba(){
       $data = [
        'sanggau' => 'sanggau',
       ];
        //return view('test');
    }
}
