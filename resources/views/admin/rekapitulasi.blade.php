@extends('layouts.app') <!-- Menyesuaikan dengan layout yang kamu miliki -->

@section('content')
    <div class="container mt-4">
        <h2>Rekapitulasi Laporan</h2>
        <table class="table table-bordered" style="width: 120%">
            <thead>
                <tr>
                    <th colspan="2" class="text-center">Uplm</th>
                    <th colspan="3" class="text-center">Perpustakaan Umum</th>
                    <th colspan="7" class="text-center">Perpustakaan Sekolah</th>
                    <th rowspan="2" class="text-center">Perguruan Tinggi</th>
                    <th rowspan="2" class="text-center">Khusus</th>
                </tr>
                <tr>
                    <th>Uplm</th>
                    <th>Pertanyaan</th>
                    <th>Kab/Kota</th>
                    <th>Kecamatan</th>
                    <th>Desa/Kel</th>
                    <th>SD</th>
                    <th>MI</th>
                    <th>SMP</th>
                    <th>MTs</th>
                    <th>SMA</th>
                    <th>SMK</th>
                    <th>MA</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data Dummy 1 -->
                <tr>
                    <td>Uplm 1</td>
                    <td>Jumlah koleksi buku diperpustakaan?</td>
                    <td>100</td>
                    <td>50</td>
                    <td>30</td>
                    <td>200</td>
                    <td>150</td>
                    <td>100</td>
                    <td>50</td>
                    <td>250</td>
                    <td>150</td>
                    <td>200</td>
                    <td>100</td>
                    <td>300</td>
                </tr>
                
                <!-- Data Dummy 2 -->
                <tr>
                    <td>Uplm 2</td>
                    <td>Jumlah koleksi digital?</td>
                    <td>80</td>
                    <td>60</td>
                    <td>180</td>
                    <td>140</td>
                    <td>90</td>
                    <td>70</td>
                    <td>230</td>
                    <td>170</td>
                    <td>210</td>
                    <td>110</td>
                    <td>320</td>
                    <td>40</td>
                </tr>

                <!-- Data Dummy 3 -->
                <tr>
                    <td>Uplm 3</td>
                    <td>Jumlah tenaga kerja?</td>
                    <td>90</td>
                    <td>60</td>
                    <td>40</td>
                    <td>210</td>
                    <td>130</td>
                    <td>110</td>
                    <td>60</td>
                    <td>240</td>
                    <td>160</td>
                    <td>190</td>
                    <td>120</td>
                    <td>310</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
