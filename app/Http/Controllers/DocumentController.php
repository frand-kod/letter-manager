<?php

namespace App\Http\Controllers;

use App\Models\DocumentModel;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
// use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\SvgWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    // here we will add methods to handle document upload, retrieval, and verification

    public function uploadForm()
    {
        return view('upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'document' => 'required|file|mimes:pdf,doc,docx',
        ]);
        $file = $request->file('document');
        $uuid = Str::uuid();
        $hash = hash_file('sha256', $file->getRealPath());

        $filename = $uuid.'.'.$file->getClientOriginalExtension();
        $file->storeAs('surat', $filename, 'public');

        // $qrCodePath = 'app/public/qrcodes/'.$uuid.'.png';
        $qrCodePath = 'app/public/qrcodes/'.$uuid.'.svg';

        // QrCode::format('png')->size(200)->generate(url('/verify/' . $uuid), storage_path('app/' . $qrCodePath));

        // buat QR code dengan Endroid
        $qrCode = new Builder(
            writer: new SvgWriter,
            data: url("/verify/$uuid"),
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            roundBlockSizeMode: RoundBlockSizeMode::Margin
        );
        $result = $qrCode->build();
        $result->saveToFile(storage_path($qrCodePath));

        DocumentModel::create([
            'id' => $uuid,
            'number' => $request->input('number'),
            'title' => $request->input('title'),
            'filename' => $filename,
            'hash' => $hash,
            'qr_code' => $qrCodePath,
            'status' => 'valid',
        ]);

        return redirect()->back()->with('success', 'Document uploaded successfully!');
    }

    // List documents
    public function index()
    {
        $document = DocumentModel::orderBy('uploaded_at', 'desc')->get();

        return view('dashboard', compact('document'));
    }

    // detail document
    public function show($id)
    {
        $doc = DocumentModel::findOrFail($id);

        return view('document_detail', compact('doc'));
    }

    // revoke document
    public function revoke($id)
    {
        $document = DocumentModel::findOrFail($id);
        $document->status = 'revoked';
        $document->save();

        return redirect()->back()->with('success', 'Document status changed to revoked successfully!');
    }

    // undo revoke
    public function unrevoke($id)
    {
        $document = DocumentModel::findOrFail($id);
        $document->status = 'valid';
        $document->save();

        return redirect()->back()->with('success', 'Document status changed to valid successfully!');
    }

    // qr verify
    public function verify($id)
    {
        $doc = DocumentModel::findOrfail($id);

        return view('verify', compact('doc'));
    }
}
