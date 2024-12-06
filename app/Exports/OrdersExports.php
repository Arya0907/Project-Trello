<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Events\AfterSheet;

class OrdersExports implements 
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::all();
    }

    public function headings(): array
    {
        return [
            "#", "Nama Pembeli", "Pembelian", "Kasir", "Tanggal", "Total Bayar",
        ];
    }

    public function map($order): array
    {
        $daftarItem = '';

        foreach (json_decode($order['items'], true) as $key => $value) {
            $format = $key+1 . ". " . $value['name_item'] . " : " . $value['quantity'] . " (pcs) Rp. " . 
                     number_format($value['sub_price'], 0,',', '.') . "\n";
            $daftarItem .= $format;
        }
        
        $tanggalPembelian = Carbon::parse($order->created_at)->locale('id')->translatedFormat('j F Y');

        $ppn = $order->total_price * 0.1;
    
        return [
            $order->id,
            $order->name_customer,
            $daftarItem,
            $order->user->name,
            $tanggalPembelian,
            "Rp. " . number_format($order->total_price + $ppn, 0, ',', '.'),
        ];
    }

    /**
     * Style the worksheet.
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style untuk header
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
            // Style untuk seluruh cell
            'A1:F' . ($sheet->getHighestRow()) => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
            // Style khusus untuk kolom pembelian (daftar obat)
            'C2:C' . ($sheet->getHighestRow()) => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    /**
     * Register events for the export.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                
                // Set semua kolom agar wrap text
                $sheet->getDelegate()->getStyle('A1:F' . $sheet->getHighestRow())
                    ->getAlignment()
                    ->setWrapText(true);

                // Set tinggi baris header
                $sheet->getDelegate()->getRowDimension(1)->setRowHeight(30);

                // Set lebar kolom
                $sheet->getDelegate()->getColumnDimension('A')->setWidth(5);  // No
                $sheet->getDelegate()->getColumnDimension('B')->setWidth(20); // Nama Pembeli
                $sheet->getDelegate()->getColumnDimension('C')->setWidth(50); // Pembelian
                $sheet->getDelegate()->getColumnDimension('D')->setWidth(20); // Kasir
                $sheet->getDelegate()->getColumnDimension('E')->setWidth(15); // Tanggal
                $sheet->getDelegate()->getColumnDimension('F')->setWidth(20); // Total Bayar

                // Freeze pane agar header tetap terlihat saat scroll
                $sheet->getDelegate()->freezePane('A2');
            },
        ];
    }
}