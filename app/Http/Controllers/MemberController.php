<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::latest()->paginate(10);
        return view('member.index', compact('members'));
    }

    public function create()
    {
        return view('member.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'plat_nomor' => 'required|unique:members',
            'jenis_kendaraan' => 'required',
            'masa_aktif_sampai' => 'required|date'
        ]);

        Member::create([
            'nama' => $request->nama,
            'plat_nomor' => strtoupper(trim($request->plat_nomor)),
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'nomor_hp' => $request->nomor_hp,
            'rfid_code' => $request->rfid_code,
            'qr_code' => uniqid('MBR-'),
            'masa_aktif_sampai' => $request->masa_aktif_sampai,
        ]);

        return redirect()->route('member.index')->with('success', 'Member berhasil ditambahkan.');
    }

    public function edit(Member $member)
    {
        return view('member.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'nama' => 'required',
            'plat_nomor' => 'required|unique:members,plat_nomor,' . $member->id,
            'jenis_kendaraan' => 'required',
            'masa_aktif_sampai' => 'required|date'
        ]);

        $member->update([
            'nama' => $request->nama,
            'plat_nomor' => strtoupper(trim($request->plat_nomor)),
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'nomor_hp' => $request->nomor_hp,
            'rfid_code' => $request->rfid_code,
            'masa_aktif_sampai' => $request->masa_aktif_sampai,
        ]);

        return redirect()->route('member.index')->with('success', 'Member berhasil diupdate.');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('member.index')->with('success', 'Member berhasil dihapus.');
    }
}
