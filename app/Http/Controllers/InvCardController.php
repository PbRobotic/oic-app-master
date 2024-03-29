<?php

namespace App\Http\Controllers;

use App\Models\InvCard;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\InvCardStoreRequest;
use App\Http\Requests\InvCardUpdateRequest;

class InvCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invcards = InvCard::orderBy('buy_date', 'desc')->paginate(15);
        return view('invcard.invcard', compact('invcards'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::get();
        return view('invcard.addinvcard', compact('projects'));
    }

    public function print()
    {
        $invcards = InvCard::get();
        $pdf = app('dompdf.wrapper')->loadView('invcard.print', compact('invcards'));
        $pdf->setPaper(array(0, 0, 609.4488, 935.433), 'landscape');


        return $pdf->stream('databangunan.pdf');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\InvCardStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvCardStoreRequest $request)
    {
        $input = $request->safe([
            'inp_name', 'inp_inv_card', 'inp_project', 'inp_lokasi', 'inp_harga', 'inp_residu', 'inp_penyusutan', 'inp_deskripsi', 'inp_kondisi', 'inp_tglpeminjaman', 'inp_tglpembelian', 'inp_pemakai'
        ]);
        $create = InvCard::create([
            'name' => $input['inp_name'],
            'project' => $input['inp_project'],
            'inventory_card' => $input['inp_inv_card'],
            'location' => $input['inp_lokasi'],
            'price' => (int) $input['inp_harga'] ?? 0,
            'condition' => $input['inp_kondisi'],
            'description' => $input['inp_deskripsi'],
            'loan_date' => $input['inp_tglpeminjaman'],
            'buy_date' => $input['inp_tglpembelian'],
            'user' => $input['inp_pemakai'],
            'residu_value' => (int) $input['inp_residu'],
            'depreciation_value' => (int) $input['inp_penyusutan'],
        ]);
        return redirect()->route('invcard.index')->with('success', "Data produk berhasil ditambahkan");
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvCard  $invcard
     * @return \Illuminate\Http\Response
     */
    public function edit(InvCard $invcard)
    {
        $projects = Project::get();
        return view('invcard.editinvcard', compact('invcard', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  InvCardUpdateRequest $request
     * @param  \App\Models\InvCard  $invcard
     * @return \Illuminate\Http\Response
     */
    public function update(InvCardUpdateRequest $request, InvCard $invcard)
    {
        $input = $request->safe([
            'inp_name', 'inp_inv_card', 'inp_project', 'inp_lokasi', 'inp_harga', 'inp_residu', 'inp_penyusutan', 'inp_deskripsi', 'inp_kondisi', 'inp_tglpeminjaman', 'inp_tglpembelian', 'inp_pemakai'
        ]);
        $update = $invcard->update([
            'name' => $input['inp_name'],
            'project' => $input['inp_project'],
            'inventory_card' => $input['inp_inv_card'],
            'location' => $input['inp_lokasi'],
            'price' => (int) $input['inp_harga'] ?? 0,
            'condition' => $input['inp_kondisi'],
            'description' => $input['inp_deskripsi'],
            'loan_date' => $input['inp_tglpeminjaman'],
            'buy_date' => $input['inp_tglpembelian'],
            'user' => $input['inp_pemakai'],
            'residu_value' => (int) $input['inp_residu'],
            'depreciation_value' => (int) $input['inp_penyusutan'],
        ]);
        if (!$update) {
            return redirect()->back()->with('error', "Terjadi kesalahan pada sistem");
        }

        return redirect()->route('invcard.index')->with('success', "Data invcard berhasil diubah");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvCard  $invcard
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvCard $invcard)
    {
        $invcard->delete();
        return redirect()->route('invcard.index')->with('success', "Data invcard berhasil dihapus");
    }
}
