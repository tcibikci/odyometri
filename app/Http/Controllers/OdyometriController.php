<?php

namespace App\Http\Controllers;

use App\Odyometri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class OdyometriController extends Controller
{
    public function index()
    {
        //Tüm verileri çek
        $data = Odyometri::all();
        return view('welcome')->with(array('data'=>$data));
    }


    //Yeni odyometri kaydet
    public function create(Request $request)
    {
        //date var mı kontrol ediyor.
        $request->validate([
            'date' => 'bail|required|max:255',
        ]);

        $odyometri = new Odyometri();

        $odyometri->date = $request->date;
        $odyometri->comment = $request->comment;
        $odyometri->L250hz = $request->L250hz;
        $odyometri->L500hz = $request->L500hz;
        $odyometri->L1khz = $request->L1khz;
        $odyometri->L2khz = $request->L2khz;
        $odyometri->L3khz = $request->L3khz;
        $odyometri->L4khz = $request->L4khz;
        $odyometri->L6khz = $request->L6khz;
        $odyometri->L8khz = $request->L8khz;
        $odyometri->LSSO  = $request->LSSO ;


        $odyometri->R250hz = $request->R250hz;
        $odyometri->R500hz = $request->R500hz;
        $odyometri->R1khz = $request->R1khz;
        $odyometri->R2khz = $request->R2khz;
        $odyometri->R3khz  = $request->R3khz;
        $odyometri->R4khz = $request->R4khz;
        $odyometri->R6khz = $request->R6khz;
        $odyometri->R8khz = $request->R8khz;
        $odyometri->RSSO = $request->RSSO;

        //Veriler kaydedildi.
        $odyometri->save();

        return redirect(route('index'));
    }

    //Bir tane odyometri bilgisi getirir.
    public function getOdyometri(Request $request)
    {
        //Id varmı kontrol ediliyor
        $request->validate([
            'id' => 'bail|required|max:255',
        ]);

        $data = Odyometri::ID($request->id)->first();

        return $data;
    }

    //Seçilmiş olan odyometri bilgilerini getirir
    public function getOdyometris(Request $request)
    {
        //Id varmı kontrol ediliyor
        $request->validate([
            'id' => 'bail|required|max:255',
        ]);

        $data = Odyometri::whereIn('id', $request->id)->get();
        return $data;
    }

    //Odyometri bilgilerini güncelliyor
    public function update(Request $request)
    {
        //date varmı
        $request->validate([
            'date' => 'bail|required|max:255',
        ]);

        //Kayıtlı item bul
        $odyometri = Odyometri::ID($request->id)->first();

        $odyometri->date = $request->date;
        $odyometri->comment = $request->comment;
        $odyometri->L250hz = $request->L250hz;
        $odyometri->L500hz = $request->L500hz;
        $odyometri->L1khz = $request->L1khz;
        $odyometri->L2khz = $request->L2khz;
        $odyometri->L3khz = $request->L3khz;
        $odyometri->L4khz = $request->L4khz;
        $odyometri->L6khz = $request->L6khz;
        $odyometri->L8khz = $request->L8khz;
        $odyometri->LSSO  = $request->LSSO ;


        $odyometri->R250hz = $request->R250hz;
        $odyometri->R500hz = $request->R500hz;
        $odyometri->R1khz = $request->R1khz;
        $odyometri->R2khz = $request->R2khz;
        $odyometri->R3khz  = $request->R3khz;
        $odyometri->R4khz = $request->R4khz;
        $odyometri->R6khz = $request->R6khz;
        $odyometri->R8khz = $request->R8khz;
        $odyometri->RSSO = $request->RSSO;

        //bilgileri guncelle
        $odyometri->update();

        return redirect(route('index'));
    }

    //Item silme
    public function delete(Request $request)
    {
        //Id varmı kontrol ediliyor
        $request->validate([
            'id' => 'bail|required|max:255',
        ]);

        //item siliniyor
        Odyometri::ID($request->id)->delete();

        //return true;
    }
    
}
