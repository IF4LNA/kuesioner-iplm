<?php

namespace Database\Seeders;

use App\Models\Kota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  // Seeder untuk Kota
public function run()
{
    $kota = Kota::create(['nama_kota' => 'Bandung']);
    
    // Menambahkan Kecamatan
    $andir = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Andir']);
    $astanaanyar = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Astanaanyar']);
    $antapani = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Antapani']);
    $arcamanik = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Arcamanik']);
    $babakanciparay = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Babakan Ciparay']);
    $bandungkidul = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Bandung Kidul']);
    $bandungkulon = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Bandung Kulon']);
    $bandungwetan = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Bandung Wetan']);
    $batununggal = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Batununggal']);
    $bojongloakaler = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Bojongloa Kaler']);
    $bojongloakidul = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Bojongloa Kidul']);
    $buahbatu = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Buahbatu']);
    $cibeunyingkaler = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Cibeunying Kaler']);
    $cibeunyingkidul = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Cibeunying Kidul']);
    $cibiru = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Cibiru']);
    $cicendo = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Cicendo']);
    $cidadap = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Cidadap']);
    $cinambo = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Cinambo']);
    $coblong = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Coblong']);
    $gedebage = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Gedebage']);
    $kiaracondong = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Kiaracondong']);
    $lengkong = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Lengkong']);
    $mandalajati = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Mandalajati']);
    $panyileukan = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Panyileukan']);
    $rancasari = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Rancasari']);
    $regol = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Regol']);
    $sukajadi = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Sukajadi']);
    $sukasari = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Sukasari']);
    $sumurbandung = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Sumurbandung']);
    $ujungberung = Kecamatan::create(['id_kota' => $kota->id, 'nama_kecamatan' => 'Ujungberung']);

     // Menambahkan untuk kelurahan Andir
     Kelurahan::create(['id_kecamatan' => $andir->id, 'nama_kelurahan' => 'Cempaka']);
     Kelurahan::create(['id_kecamatan' => $andir->id, 'nama_kelurahan' => 'Ciroyom']);
     Kelurahan::create(['id_kecamatan' => $andir->id, 'nama_kelurahan' => 'Dunguscariang']);
     Kelurahan::create(['id_kecamatan' => $andir->id, 'nama_kelurahan' => 'Garuda']);
     Kelurahan::create(['id_kecamatan' => $andir->id, 'nama_kelurahan' => 'Kebonjeruk']);
     Kelurahan::create(['id_kecamatan' => $andir->id, 'nama_kelurahan' => 'Maleber']);

    // Menambahkan kelurahan Astanaanyar
    Kelurahan::create(['id_kecamatan' => $astanaanyar->id, 'nama_kelurahan' => 'Cibadak']);
    Kelurahan::create(['id_kecamatan' => $astanaanyar->id, 'nama_kelurahan' => 'Karanganyar']);
    Kelurahan::create(['id_kecamatan' => $astanaanyar->id, 'nama_kelurahan' => 'Nyengseret']);
    Kelurahan::create(['id_kecamatan' => $astanaanyar->id, 'nama_kelurahan' => 'Panjunan']);
    Kelurahan::create(['id_kecamatan' => $astanaanyar->id, 'nama_kelurahan' => 'Pelindung Hewan']);
    Kelurahan::create(['id_kecamatan' => $astanaanyar->id, 'nama_kelurahan' => 'Karasak']);

    // Menambahkan untuk kelurahan Antapani
     Kelurahan::create(['id_kecamatan' => $antapani->id, 'nama_kelurahan' => 'Antapani Kidul']);
     Kelurahan::create(['id_kecamatan' => $antapani->id, 'nama_kelurahan' => 'Antapani Kulon']);
     Kelurahan::create(['id_kecamatan' => $antapani->id, 'nama_kelurahan' => 'Antapani Tengah']);
     Kelurahan::create(['id_kecamatan' => $antapani->id, 'nama_kelurahan' => 'Antapani Wetan']);

    // Menambahkan untuk kelurahan Arcamanik
    Kelurahan::create(['id_kecamatan' => $arcamanik->id, 'nama_kelurahan' => 'Cisaranten Bina Harapan']);
    Kelurahan::create(['id_kecamatan' => $arcamanik->id, 'nama_kelurahan' => 'Cisaranten Endah']);
    Kelurahan::create(['id_kecamatan' => $arcamanik->id, 'nama_kelurahan' => 'Cisaranten Kulon']);
    Kelurahan::create(['id_kecamatan' => $arcamanik->id, 'nama_kelurahan' => 'Sukamiskin']);
   
     // Menambahkan untuk kelurahan Babakan Ciparay
     Kelurahan::create(['id_kecamatan' => $babakanciparay->id, 'nama_kelurahan' => 'Babakan']);
     Kelurahan::create(['id_kecamatan' => $babakanciparay->id, 'nama_kelurahan' => 'Babakanciparay']);
     Kelurahan::create(['id_kecamatan' => $babakanciparay->id, 'nama_kelurahan' => 'Cirangrang']);
     Kelurahan::create(['id_kecamatan' => $babakanciparay->id, 'nama_kelurahan' => 'Margahayu Utara']);
     Kelurahan::create(['id_kecamatan' => $babakanciparay->id, 'nama_kelurahan' => 'Margasuka']);
     Kelurahan::create(['id_kecamatan' => $babakanciparay->id, 'nama_kelurahan' => 'Sukahaji']);
    
     // Menambahkan untuk kelurahan Bandung Kidul
     Kelurahan::create(['id_kecamatan' => $bandungkidul->id, 'nama_kelurahan' => 'Batununggal']);
     Kelurahan::create(['id_kecamatan' => $bandungkidul->id, 'nama_kelurahan' => 'Kujangsari']);
     Kelurahan::create(['id_kecamatan' => $bandungkidul->id, 'nama_kelurahan' => 'Mengger']);
     Kelurahan::create(['id_kecamatan' => $bandungkidul->id, 'nama_kelurahan' => 'Wates']);

    // Menambahkan untuk kelurahan Bandung wetan
    Kelurahan::create(['id_kecamatan' => $bandungwetan->id, 'nama_kelurahan' => 'Cihapit']);
    Kelurahan::create(['id_kecamatan' => $bandungwetan->id, 'nama_kelurahan' => 'Citarunm']);
    Kelurahan::create(['id_kecamatan' => $bandungwetan->id, 'nama_kelurahan' => 'Tamansari']);

     // Menambahkan untuk kelurahan Batununggal
     Kelurahan::create(['id_kecamatan' => $batununggal->id, 'nama_kelurahan' => 'Binong']);
     Kelurahan::create(['id_kecamatan' => $batununggal->id, 'nama_kelurahan' => 'Cibangkong']);
     Kelurahan::create(['id_kecamatan' => $batununggal->id, 'nama_kelurahan' => 'Gumuruh']);
     Kelurahan::create(['id_kecamatan' => $batununggal->id, 'nama_kelurahan' => 'Kacapiring']);
     Kelurahan::create(['id_kecamatan' => $batununggal->id, 'nama_kelurahan' => 'Kebongedang']);
     Kelurahan::create(['id_kecamatan' => $batununggal->id, 'nama_kelurahan' => 'Kebonwaru']);
     Kelurahan::create(['id_kecamatan' => $batununggal->id, 'nama_kelurahan' => 'Maleer']);
     Kelurahan::create(['id_kecamatan' => $batununggal->id, 'nama_kelurahan' => 'Samoja']);

     // Menambahkan untuk kelurahan Bojongloa Kaler
     Kelurahan::create(['id_kecamatan' => $bojongloakaler->id, 'nama_kelurahan' => 'Babakan Asih']);
     Kelurahan::create(['id_kecamatan' => $bojongloakaler->id, 'nama_kelurahan' => 'Babakan Tarogong']);
     Kelurahan::create(['id_kecamatan' => $bojongloakaler->id, 'nama_kelurahan' => 'Jamika']);
     Kelurahan::create(['id_kecamatan' => $bojongloakaler->id, 'nama_kelurahan' => 'Kopo']);
     Kelurahan::create(['id_kecamatan' => $bojongloakaler->id, 'nama_kelurahan' => 'Suka Asih']);
     
     // Menambahkan untuk kelurahan Bojongloa kidul
     Kelurahan::create(['id_kecamatan' => $bojongloakidul->id, 'nama_kelurahan' => 'Cibaduyut']);
     Kelurahan::create(['id_kecamatan' => $bojongloakidul->id, 'nama_kelurahan' => 'Cibaduyut Kidul']);
     Kelurahan::create(['id_kecamatan' => $bojongloakidul->id, 'nama_kelurahan' => 'Cibaduyut Wetan']);
     Kelurahan::create(['id_kecamatan' => $bojongloakidul->id, 'nama_kelurahan' => 'Kebon lega']);
     Kelurahan::create(['id_kecamatan' => $bojongloakidul->id, 'nama_kelurahan' => 'Mekarwangi']);
     Kelurahan::create(['id_kecamatan' => $bojongloakidul->id, 'nama_kelurahan' => 'Situsaeur']);

     // Menambahkan untuk kelurahan Bandung kulon
     Kelurahan::create(['id_kecamatan' => $bandungkulon->id, 'nama_kelurahan' => 'Caringin']);
     Kelurahan::create(['id_kecamatan' => $bandungkulon->id, 'nama_kelurahan' => 'Cibuntu']);
     Kelurahan::create(['id_kecamatan' => $bandungkulon->id, 'nama_kelurahan' => 'Cigondewah Kaler']);
     Kelurahan::create(['id_kecamatan' => $bandungkulon->id, 'nama_kelurahan' => 'Cigondewah Kidul']);
     Kelurahan::create(['id_kecamatan' => $bandungkulon->id, 'nama_kelurahan' => 'Cigondewah Rahayu']);
     Kelurahan::create(['id_kecamatan' => $bandungkulon->id, 'nama_kelurahan' => 'Cijerah']);
     Kelurahan::create(['id_kecamatan' => $bandungkulon->id, 'nama_kelurahan' => 'Gempolsari']);
     Kelurahan::create(['id_kecamatan' => $bandungkulon->id, 'nama_kelurahan' => 'Warungmuncang']);

     // Menambahkan untuk kelurahan Buahbatu
     Kelurahan::create(['id_kecamatan' => $buahbatu->id, 'nama_kelurahan' => 'Cijawura']);
     Kelurahan::create(['id_kecamatan' => $buahbatu->id, 'nama_kelurahan' => 'Jatisari']);
     Kelurahan::create(['id_kecamatan' => $buahbatu->id, 'nama_kelurahan' => 'Margasari']);
     Kelurahan::create(['id_kecamatan' => $buahbatu->id, 'nama_kelurahan' => 'Sekejati']);

     // Menambahkan untuk kelurahan Cibeunying Kaler
     Kelurahan::create(['id_kecamatan' => $cibeunyingkaler->id, 'nama_kelurahan' => 'Cigadung']);
     Kelurahan::create(['id_kecamatan' => $cibeunyingkaler->id, 'nama_kelurahan' => 'Cihaurgeulis']);
     Kelurahan::create(['id_kecamatan' => $cibeunyingkaler->id, 'nama_kelurahan' => 'Neglasari']);
     Kelurahan::create(['id_kecamatan' => $cibeunyingkaler->id, 'nama_kelurahan' => 'Sukaluyu']);
     
    // Menambahkan untuk kelurahan Cibeunying Kidul
    Kelurahan::create(['id_kecamatan' => $cibeunyingkidul->id, 'nama_kelurahan' => 'Cicadas']);
    Kelurahan::create(['id_kecamatan' => $cibeunyingkidul->id, 'nama_kelurahan' => 'Cikutra']);
    Kelurahan::create(['id_kecamatan' => $cibeunyingkidul->id, 'nama_kelurahan' => 'Padasuka']);
    Kelurahan::create(['id_kecamatan' => $cibeunyingkidul->id, 'nama_kelurahan' => 'Pasirlayung']);
    Kelurahan::create(['id_kecamatan' => $cibeunyingkidul->id, 'nama_kelurahan' => 'Sukamaju']);
    Kelurahan::create(['id_kecamatan' => $cibeunyingkidul->id, 'nama_kelurahan' => 'Sukapada']);

     // Menambahkan untuk kelurahan Cibiru
     Kelurahan::create(['id_kecamatan' => $cibiru->id, 'nama_kelurahan' => 'Cipadung']);
     Kelurahan::create(['id_kecamatan' => $cibiru->id, 'nama_kelurahan' => 'Cisurupan']);
     Kelurahan::create(['id_kecamatan' => $cibiru->id, 'nama_kelurahan' => 'Palasari']);
     Kelurahan::create(['id_kecamatan' => $cibiru->id, 'nama_kelurahan' => 'Pasirbiru']);

         // Menambahkan untuk kelurahan Cicendo
    Kelurahan::create(['id_kecamatan' => $cicendo->id, 'nama_kelurahan' => 'Arjuna']);
    Kelurahan::create(['id_kecamatan' => $cicendo->id, 'nama_kelurahan' => 'Husen Sastranegara']);
    Kelurahan::create(['id_kecamatan' => $cicendo->id, 'nama_kelurahan' => 'Pajajaran']);
    Kelurahan::create(['id_kecamatan' => $cicendo->id, 'nama_kelurahan' => 'Pamoyanan']);
    Kelurahan::create(['id_kecamatan' => $cicendo->id, 'nama_kelurahan' => 'Pasirkaliki']);
    Kelurahan::create(['id_kecamatan' => $cicendo->id, 'nama_kelurahan' => 'Sukaraja']);
     
          // Menambahkan untuk kelurahan Cidadap
    Kelurahan::create(['id_kecamatan' => $cidadap->id, 'nama_kelurahan' => 'Ciumbuleuit']);
    Kelurahan::create(['id_kecamatan' => $cidadap->id, 'nama_kelurahan' => 'Hegarmanah']);
    Kelurahan::create(['id_kecamatan' => $cidadap->id, 'nama_kelurahan' => 'Ledeng']);

         // Menambahkan untuk kelurahan Cinambo
     Kelurahan::create(['id_kecamatan' => $cinambo->id, 'nama_kelurahan' => 'Babakan Penghulu']);
     Kelurahan::create(['id_kecamatan' => $cinambo->id, 'nama_kelurahan' => 'Cisaranten Wetan']);
     Kelurahan::create(['id_kecamatan' => $cinambo->id, 'nama_kelurahan' => 'Pakemitan']);
     Kelurahan::create(['id_kecamatan' => $cinambo->id, 'nama_kelurahan' => 'Sukamulya']);

     // Menambahkan untuk kelurahan Coblong
     Kelurahan::create(['id_kecamatan' => $coblong->id, 'nama_kelurahan' => 'Cipaganti']);
     Kelurahan::create(['id_kecamatan' => $coblong->id, 'nama_kelurahan' => 'Dago']);
     Kelurahan::create(['id_kecamatan' => $coblong->id, 'nama_kelurahan' => 'Lebakgede']);
     Kelurahan::create(['id_kecamatan' => $coblong->id, 'nama_kelurahan' => 'Lebaksiliwangi']);
     Kelurahan::create(['id_kecamatan' => $coblong->id, 'nama_kelurahan' => 'Sadangserang']);
     Kelurahan::create(['id_kecamatan' => $coblong->id, 'nama_kelurahan' => 'Sekeloa']);

     // Menambahkan Kelurahan untuk Kecamatan Gedebage
    Kelurahan::create(['id_kecamatan' => $gedebage->id, 'nama_kelurahan' => 'Cisaranten Kidul']);
    Kelurahan::create(['id_kecamatan' => $gedebage->id, 'nama_kelurahan' => 'Rancabolang']);
    Kelurahan::create(['id_kecamatan' => $gedebage->id, 'nama_kelurahan' => 'Cimincring']);
    Kelurahan::create(['id_kecamatan' => $gedebage->id, 'nama_kelurahan' => 'Rancaumpang']);

           // Menambahkan untuk kelurahan Kiaracondong
     Kelurahan::create(['id_kecamatan' => $kiaracondong->id, 'nama_kelurahan' => 'Babakansari']);
     Kelurahan::create(['id_kecamatan' => $kiaracondong->id, 'nama_kelurahan' => 'Babakansurabaya']);
     Kelurahan::create(['id_kecamatan' => $kiaracondong->id, 'nama_kelurahan' => 'Cicaheum']);
     Kelurahan::create(['id_kecamatan' => $kiaracondong->id, 'nama_kelurahan' => 'Kebonkangkung']);
     Kelurahan::create(['id_kecamatan' => $kiaracondong->id, 'nama_kelurahan' => 'Kebunjayanti']);
     Kelurahan::create(['id_kecamatan' => $kiaracondong->id, 'nama_kelurahan' => 'Sukakura']);
      
            // Menambahkan untuk kelurahan Lengkong
     Kelurahan::create(['id_kecamatan' => $lengkong->id, 'nama_kelurahan' => 'Burangrang']);
     Kelurahan::create(['id_kecamatan' => $lengkong->id, 'nama_kelurahan' => 'Cijagra']);
     Kelurahan::create(['id_kecamatan' => $lengkong->id, 'nama_kelurahan' => 'Cikawao']);
     Kelurahan::create(['id_kecamatan' => $lengkong->id, 'nama_kelurahan' => 'Lingkar Selatan']);
     Kelurahan::create(['id_kecamatan' => $lengkong->id, 'nama_kelurahan' => 'Malabar']);
     Kelurahan::create(['id_kecamatan' => $lengkong->id, 'nama_kelurahan' => 'Paledang']);
     Kelurahan::create(['id_kecamatan' => $lengkong->id, 'nama_kelurahan' => 'Turangga']);

                 // Menambahkan untuk kelurahan Mandalajati
     Kelurahan::create(['id_kecamatan' => $mandalajati->id, 'nama_kelurahan' => 'Jadihandap']);
     Kelurahan::create(['id_kecamatan' => $mandalajati->id, 'nama_kelurahan' => 'Karangpamulang']);
     Kelurahan::create(['id_kecamatan' => $mandalajati->id, 'nama_kelurahan' => 'Pasir Impun']);
     Kelurahan::create(['id_kecamatan' => $mandalajati->id, 'nama_kelurahan' => 'Sindangjaya']);

                 // Menambahkan untuk kelurahan Panyileukan
     Kelurahan::create(['id_kecamatan' => $panyileukan->id, 'nama_kelurahan' => 'Cipadung Kidul']);
     Kelurahan::create(['id_kecamatan' => $panyileukan->id, 'nama_kelurahan' => 'Cipadung Kulon']);
     Kelurahan::create(['id_kecamatan' => $panyileukan->id, 'nama_kelurahan' => 'Cipadung Wetan']);
     Kelurahan::create(['id_kecamatan' => $panyileukan->id, 'nama_kelurahan' => 'Mekarmulya']);
     
                      // Menambahkan untuk kelurahan Rancasari
     Kelurahan::create(['id_kecamatan' => $rancasari->id, 'nama_kelurahan' => 'Cipamokolan']);
     Kelurahan::create(['id_kecamatan' => $rancasari->id, 'nama_kelurahan' => 'Darwati']);
     Kelurahan::create(['id_kecamatan' => $rancasari->id, 'nama_kelurahan' => 'Manjahlega']);
     Kelurahan::create(['id_kecamatan' => $rancasari->id, 'nama_kelurahan' => 'Mekar Jaya']);

                 // Menambahkan untuk kelurahan Regol
     Kelurahan::create(['id_kecamatan' => $regol->id, 'nama_kelurahan' => 'Ancol']);
     Kelurahan::create(['id_kecamatan' => $regol->id, 'nama_kelurahan' => 'Balonggede']);
     Kelurahan::create(['id_kecamatan' => $regol->id, 'nama_kelurahan' => 'Ciateul']);
     Kelurahan::create(['id_kecamatan' => $regol->id, 'nama_kelurahan' => 'Cigereleng']);
     Kelurahan::create(['id_kecamatan' => $regol->id, 'nama_kelurahan' => 'Ciseureuh']);
     Kelurahan::create(['id_kecamatan' => $regol->id, 'nama_kelurahan' => 'Pasirluyu']);
     Kelurahan::create(['id_kecamatan' => $regol->id, 'nama_kelurahan' => 'Pungkur']);

                      // Menambahkan untuk kelurahan Sukajadi
     Kelurahan::create(['id_kecamatan' => $sukajadi->id, 'nama_kelurahan' => 'Cipedes']);
     Kelurahan::create(['id_kecamatan' => $sukajadi->id, 'nama_kelurahan' => 'Pasteur']);
     Kelurahan::create(['id_kecamatan' => $sukajadi->id, 'nama_kelurahan' => 'Sukabungah']);
     Kelurahan::create(['id_kecamatan' => $sukajadi->id, 'nama_kelurahan' => 'Suksgslih']);
     Kelurahan::create(['id_kecamatan' => $sukajadi->id, 'nama_kelurahan' => 'Sukawarna']);

                      // Menambahkan untuk kelurahan sukasari
     Kelurahan::create(['id_kecamatan' => $sukasari->id, 'nama_kelurahan' => 'Gegerkalong']);
     Kelurahan::create(['id_kecamatan' => $sukasari->id, 'nama_kelurahan' => 'Isola']);
     Kelurahan::create(['id_kecamatan' => $sukasari->id, 'nama_kelurahan' => 'Sarijadi']);
     Kelurahan::create(['id_kecamatan' => $sukasari->id, 'nama_kelurahan' => 'Sukarasa']);
    
                     // Menambahkan untuk kelurahan Sumur Bandung
     Kelurahan::create(['id_kecamatan' => $sumurbandung->id, 'nama_kelurahan' => 'Babakanciamis']);
     Kelurahan::create(['id_kecamatan' => $sumurbandung->id, 'nama_kelurahan' => 'Braga']);
     Kelurahan::create(['id_kecamatan' => $sumurbandung->id, 'nama_kelurahan' => 'Kebonpisang']);
     Kelurahan::create(['id_kecamatan' => $sumurbandung->id, 'nama_kelurahan' => 'Merdeka']);
    
                      // Menambahkan untuk kelurahan Ujungberung
     Kelurahan::create(['id_kecamatan' => $ujungberung->id, 'nama_kelurahan' => 'Ciganding']);
     Kelurahan::create(['id_kecamatan' => $ujungberung->id, 'nama_kelurahan' => 'Pasanggrahan']);
     Kelurahan::create(['id_kecamatan' => $ujungberung->id, 'nama_kelurahan' => 'Pasirendah']);
     Kelurahan::create(['id_kecamatan' => $ujungberung->id, 'nama_kelurahan' => 'Pasirjati']);
     Kelurahan::create(['id_kecamatan' => $ujungberung->id, 'nama_kelurahan' => 'Pasirwangi']);

}
}
