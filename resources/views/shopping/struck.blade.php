<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bukti Pembelian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            color: #e0e0e0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        #receipt {
            position: relative;
            max-width: 500px;
            width: 90%;
            margin: auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            backdrop-filter: blur(10px);
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.5);
            color: #fff;
        }

        .btn-back {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 8px 15px;
            color: #fff;
            background: #3a3a3a;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            font-size: 0.9rem;
            transition: background 0.3s;
            z-index: 10;
        }

        .btn-back:hover {
            background: #555;
        }

        .btn-print {
            position: absolute;
            top: 15px;
            left: 15px;
            padding: 8px 15px;
            color: #3a9efd;
            font-size: 0.9rem;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
            z-index: 10;
        }

        .btn-print:hover {
            color: #fff;
        }

        h2 {
            font-size: 1.2rem;
            margin: 10px 0;
        }

        p {
            font-size: 0.9rem;
            color: #b0b0b0;
            line-height: 1.4;
            margin: 5px 0;
        }

        .info {
            text-align: center;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .tabletitle {
            background: rgba(255, 255, 255, 0.15);
            color: #e0e0e0;
            font-weight: bold;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .itemtext {
            font-size: 0.9rem;
        }

        .payment {
            font-weight: bold;
            color: #3a9efd;
        }

        .legalcopy {
            text-align: center;
            font-size: 0.8rem;
            color: #ccc;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div id="receipt">
        <a href="{{route('export.pdf', $order['id'])}}" class="btn-print">Cetak (.pdf)</a>
        <a href="{{ route('orders.create') }}" class="btn-back">Kembali</a>
        <center id="top">
            <div class="info">
                <h2>Warung Madura</h2>
            </div>
        </center>
        <div id="mid">
            <div class="info">
                <p>
                    Alamat : Sepanjang jalan kenangan<br>
                    Email : ApotekJayaAbadi@gmail.com<br>
                    Telp : (021) 1234-5678<br>
                </p>
            </div>
        </div>

        <div id="bot">
            <table>
                <tr class="tabletitle">
                    <td>Nama Item</td>
                    <td>Total</td>
                    <td>Harga</td>
                </tr>
                @foreach ($order['items'] as $item)
                    <tr>
                        <td class="itemtext">{{ $item['name_item'] }}</td>
                        <td class="itemtext">{{ $item['quantity'] }}</td>
                        <td class="itemtext">Rp . {{ number_format($item['price'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr class="tabletitle">
                    <td></td>
                    <td>PPN (10%)</td>
                    @php
                        $ppn = $order['total_price'] * 0.1;
                    @endphp
                    <td class="payment">Rp . {{ number_format($ppn, 0, ',', '.') }}</td>
                </tr>
                <tr class="tabletitle">
                    <td></td>
                    <td>Total Harga</td>
                    <td class="payment">Rp . {{ number_format($order['total_price'] + $ppn, 0, ',', '.') }}</td>

                </tr>
            </table>
        </div>
        <div class="legalcopy">
            <p><strong>Terima Kasih Atas Pembelian Anda</strong></p>
        </div>
    </div>
</body>

</html>
