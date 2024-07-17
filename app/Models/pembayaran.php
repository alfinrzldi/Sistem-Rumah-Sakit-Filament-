<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $primaryKey = 'id_pembayaran'; // Set the primary key

    public $incrementing = true; // Ensure the primary key is auto-incrementing

    protected $fillable = [
        'diagnosa_id',
        'tanggal_masuk',
        'tanggal_keluar',
    ];

    public function diagnosa(): BelongsTo
    {
        return $this->belongsTo(Diagnosa::class, 'diagnosa_id', 'rekam_medis');
    }

    public function calculateTotalHargaKamar()
    {
        $diagnosa = $this->diagnosa;

        if ($diagnosa->kamar_id) {
            $kamar = $diagnosa->kamar;
            $hargaKamarPerHari = $kamar->harga;

            $tanggalMasuk = new \DateTime($this->tanggal_masuk);
            $tanggalKeluar = new \DateTime($this->tanggal_keluar);
            $jumlahHari = $tanggalKeluar->diff($tanggalMasuk)->days + 1; // Include both start and end date

            return $hargaKamarPerHari * $jumlahHari;
        }

        return 0;
    }

    public function calculateTotalDiagnosa()
    {
        return $this->diagnosa->harga;
    }

    public function calculateTotal()
    {
        return $this->calculateTotalHargaKamar() + $this->calculateTotalDiagnosa();
    }
}