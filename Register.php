<?php
// ========== DATABASE CONNECTION ==========
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "swornabindu";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// ========== FORM SUBMISSION ==========
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $district        = $_POST['district'];
    $municipality    = $_POST['municipality'];
    $child_name      = $_POST['child_name'];
    $child_gender    = $_POST['child_gender'];
    $child_age_year  = $_POST['child_age_year'];
    $child_age_month = $_POST['child_age_month'];
    $father_name     = $_POST['father_name'];
    $mother_name     = $_POST['mother_name'];
    $contact_number  = $_POST['contact_number'];

    // Age validation
    $total_months = ($child_age_year * 12) + $child_age_month;

    if ($total_months < 6 || $total_months > 60) {
        echo "<script>alert('Child age must be between 6 months and 5 years.'); window.history.back();</script>";
        exit();
    }

    // Insert Query
    $sql = "INSERT INTO registration 
            (district, municipality, child_name, child_gender, child_age_year, child_age_month, father_name, mother_name, contact_number)
            VALUES 
            ('$district', '$municipality', '$child_name', '$child_gender', '$child_age_year', '$child_age_month', '$father_name', '$mother_name', '$contact_number')";

    if ($conn->query($sql) === TRUE) {
        $reg_id = $conn->insert_id;
        header("Location: Register1.php?id=$reg_id");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="ne">

<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Child Registration</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

<style>
    body {
        background-color: #f5f7f8;
        font-family: 'Noto Sans Devanagari', 'Segoe UI', sans-serif;
        font-size: 12px;
    }

    .main-box {
        max-width: 1000px;
        margin: 20px auto;
        border-radius: 18px;
        background-color: #ffffff;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
        padding: 24px 28px 28px;
    }

    .quick-bar {
        background-color: #bee0f5;
        border-radius: 12px;
        border: 1px solid #afdbf3;
    }

    .age-wrapper {
        background-color: #f3fff6;
        border: 1px solid rgb(190, 236, 190);
        border-radius: 9px;
        padding: 10px 16px;
        display: flex;
        align-items: center;
        gap: 18px;
        height: 70px;
    }

    .age-input {
        width: 70px;
        text-align: center;
        border-radius: 12px;
        border: 1px solid #e5e5e5;
    }

    .custom-textarea:focus {
        border-color: gray;
        box-shadow: 0 0 0 0.2rem rgba(101, 102, 104, 0.25);
        outline: 0;
    }
</style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm position-relative">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="#">स्वर्णबिन्दु</a>
    </div>
</nav>

<div class="main-box">

    <form action="" method="POST">

        <!-- Header -->
        <div class="bg-primary text-white p-3 rounded-3 mb-3 d-flex align-items-center gap-2">
            <h4 class="m-0">Child and Guardian Information</h4>
        </div>

        <!-- Quick Bar -->
        <div class="quick-bar d-flex justify-content-between align-items-center px-3 py-2 mb-4">
            <span class="text-primary fs-6">द्रुत दर्ता | Quick Registration</span>
            <span class="badge rounded-pill bg-white text-dark border fs-6">Step 1/3</span>
        </div>

        <div class="container my-4">
            <div class="row g-4">

                <!-- LEFT SIDE -->
                <div class="col-md-6">
                    <div class="border rounded p-4 bg-white">

                        <label class="fw-semibold text-primary">बच्चाको विवरण | Child Info</label>

                        <!-- District -->
                        <div class="mt-3">
                            <label class="form-label">District *</label>
                            <select class="form-select custom-textarea" name="district" id="district" required onchange="updateMunicipalities()">
                                <option value="">-- Select District --</option>
                                <option value="Dang">Dang</option>
                                <option value="Rolpa">Rolpa</option>
                                <option value="Pyuthan">Pyuthan</option>
                                <option value="Rukum">Rukum</option>
                                <option value="Nawalparasi">Nawalparasi</option>
                                <option value="Bardiya">Bardiya</option>
                                <option value="Palpa">Palpa</option>
                                <option value="Khuldindi">Khuldindi</option>
                                <option value="Banke">Banke</option>
                                <option value="Rupandehi">Rupandehi</option>
                                <option value="Chitwan">Chitwan</option>
                                <option value="Lumbini">Lumbini</option>

                                <option value="Bara">Bara</option>
                                <option value="Dhanusha">Dhanusha</option>
                                <option value="Mahottari">Mahottari</option>
                                <option value="Parsa">Parsa</option>
                                <option value="Rautahat">Rautahat</option>
                                <option value="Sarlahi">Sarlahi</option>
                                <option value="Siraha">Siraha</option>
                                <option value="Saptari">Saptari</option>


                                <option value="Jhapa">Jhapa</option>
                                <option value="Morang">Morang</option>
                                <option value="Sunsari">Sunsari</option>
                                <option value="Taplejung">Taplejung</option>
                                <option value="Sankhuwasabha">Sankhuwasabha</option>
                                <option value="Solukhumbu">Solukhumbu</option>
                                <option value="Okhaldhunga">Okhaldhunga</option>
                                <option value="Bhojpur">Bhojpur</option>
                                <option value="Dhankuta">Dhankuta</option>
                                <option value="Ilam">Ilam</option>
                                <option value="Khotang">Khotang</option>
                                <option value="Terhathum">Terhathum</option>
                                <option value="Udayapur">Udayapur</option>



                                <option value="Bhaktapur">Bhaktapur</option>
                                <option value="Chitwan">Chitwan</option>
                                <option value="Dhading">Dhading</option>
                                <option value="Dolakha">Dolakha</option>
                                <option value="Kathmandu">Kathmandu</option>
                                <option value="Kavrepalanchok">Kavrepalanchok</option>
                                <option value="Lalitpur">Lalitpur</option>
                                <option value="Makawan">Makawan</option>
                                <option value="Nuwakot">Nuwakot</option>
                                <option value="Ramechhap">Ramechhap</option>
                                <option value="Rasuwa">Rasuwa</option>
                                <option value="Sindhuli">Sindhuli</option>
                                <option value="Sindhupalchok">Sindhupalchok</option>


                                <option value="Baglung">Baglung</option>
                                <option value="Gorkha">Gorkha</option>
                                <option value="Kaski">Kaski</option>
                                <option value="Lamjung">Lamjung</option>
                                <option value="Manang">Manang</option>
                                <option value="Mustang">Mustang</option>
                                <option value="Myagdi">Myagdi</option>
                                <option value="Nawalpur">Nawalpur</option>
                                <option value="Parbat">Parbat</option>
                                <option value="Syangja">Syangja</option>
                                <option value="Tanahu">Tanahu</option>



                                <option value="Achham">Achham</option>
                                <option value="Baitadi">Baitadi</option>
                                <option value="Bajhang">Bajhang</option>
                                <option value="Bajura">Bajura</option>
                                <option value="Dadeldhura">Dadeldhura</option>
                                <option value="Darchula">Darchula</option>
                                <option value="Doti">Doti</option>
                                <option value="Kailali">Kailali</option>
                                <option value="Kanchanpur">Kanchanpur</option>


                                <option value="Dailekh">Dailekh</option>
                                <option value="Dolpa">Dolpa</option>
                                <option value="Humla">Humla</option>
                                <option value="Jajarkot">Jajarkot</option>
                                <option value="Jumla">Jumla</option>
                                <option value="Kalikot">Kalikot</option>
                                <option value="Mugu">Mugu</option>
                                <option value="Salyan">Salyan</option>
                                <option value="Surkhet">Surkhet</option>
                                <option value="West Rukum">West Rukum</option>
                                



                                
                                <!-- Add all 77 districts here -->
                            </select>
                        </div>

                        <!-- Municipality -->
                        <div class="mt-3">
                            <label class="form-label ">Municipality *</label>
                            <select class="form-select custom-textarea" name="municipality" id="municipality" required>
                                <option value="">-- Select Municipality --</option>
                            </select>
                        </div>

                        <!-- Gender -->
                        <label class="mt-4 mb-1"><b>लिङ्ग *</b></label>
                        <div class="d-flex gap-3">
                            <label class="btn btn-outline-dark flex-fill">
                                <input type="radio" name="child_gender" value="Male" required class="me-2"> पुरुष | Male
                            </label>

                            <label class="btn btn-outline-dark flex-fill">
                                <input type="radio" name="child_gender" value="Female" class="me-2"> महिला | Female
                            </label>
                        </div>

                        <!-- Child Name -->
                        <div class="mt-4">
                            <label class="form-label"><b>बच्चाको नाम *</b></label>
                            <input type="text" class="form-control custom-textarea" name="child_name" required>
                        </div>

                        <!-- Age -->
                        <div class="mt-4">
                            <label class="form-label custom-textarea "><b>बच्चाको उमेर *</b></label>

                            <div class="age-wrapper mt-1">
                                <div class="d-flex align-items-center">
                                    <input type="number" class="form-control age-input custom-textarea" name="child_age_year" min="0" required>
                                    <span class="ms-2">वर्ष</span>
                                </div>

                                <div class="d-flex align-items-center">
                                    <input type="number" class="form-control age-input custom-textarea" name="child_age_month" min="0" max="11" required>
                                    <span class="ms-2">महिना</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- RIGHT SIDE -->
                <div class="col-md-6">
                    <div class="border rounded p-4 bg-white">

                        <label class="fw-semibold text-primary">अभिभावक विवरण | Guardian Info</label>

                        <!-- Father Name -->
                        <div class="mt-4">
                            <label class="form-label ">बुबाको नाम</label>
                            <input type="text" class="form-control custom-textarea" name="father_name">
                        </div>

                        <!-- Mother Name -->
                        <div class="mt-4">
                            <label class="form-label ">आमाको नाम</label>
                            <input type="text" class="form-control custom-textarea" name="mother_name">
                        </div>

                        <!-- Contact -->
                        <div class="mt-4">
                            <label class="form-label ">सम्पर्क नम्बर *</label>
                            <div class="input-group">
                                <span class="input-group-text">+977</span>
                                <input type="text" class="form-control custom-textarea" name="contact_number" required placeholder="9800000000">
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- NEXT BUTTON -->
            <div class="text-end mt-4">
                <button class="btn btn-dark border" type="submit">अर्को चरण | Next Step</button>
            </div>

        </div>
    </form>

</div>

<script>
// District → Municipality mapping
const municipalities = {
    "Dang": ["Ghorahi Sub-Metropolitan City", "Tulsipur Sub-Metropolitan City", "Lamahi Municipality", "Rapti Rural Municipality", "Banglachuli Rural Municipality", "Gadhawa Rural Municipality", "Babai Rural Municipality", "Dangisharan Rural Municipality", "Rajpur Rural Municipality", "Shantinagar Rural Municipality"],
    "Rolpa": ["Rolpa Municipality 1", "Rolpa Municipality 2", "Rolpa Municipality 3"],
    "Rukum": ["Bhume Rural Municipality", "Sisne Rural Municipality", "Putha Uttarganga Rural Municipality", "Rolpa Municipality", "Uttarganga Municipality"],
    "Pyuthan": ["Pyuthan Municipality","Swargadwari Municipality","Mandavi Rural Municipality","Mallarani Rural Municipality","Naubahini Rural Municipality","Gaumukhi Rural Municipality","Jhimruk Rural Municipality","Airawati Rural Municipality"],
    "Nawalparasi": ["Bardaghat Municipality", "Sunwal Municipality", "Ramgram Municipality", "Sarawal Rural Municipality", "Susta Rural Municipality", "Pratappur Rural Municipality", "Palhi Nandan Rural Municipality"],
    "Bardiya": ["Gulariya Municipality", "Barbardiya Municipality", "Rajapur Municipality", "Bansgadhi Municipality", "Madhuwan Municipality", "Thakurbaba Municipality", "Badhaiyatal Rural Municipality", "Geruwa Rural Municipality"],
    "Palpa": ["Tansen Municipality", "Rampur Municipality", "Tinau Rural Municipality", "Mathagadhi Rural Municipality", "Ribdikot Rural Municipality", "Purbakhola Rural Municipality", "Bagnaskali Rural Municipality", "Rainadevi Rural Municipality"],
    "Khuldhindi": ["Khuldhindi Municipality", "Khuldhindi Rural Municipality"],
    "Banke": ["Nepalgunj Sub-Metropolitan City", "Khajura Rural Municipality", "Janaki Rural Municipality", "Baijanath Rural Municipality", "Duduwa Rural Municipality", "Narainapur Rural Municipality", "Rapti Sonari Rural Municipality"],
    "Rupandehi": ["Butwal Sub-Metropolitan City", "Devdaha Municipality", "Lumbini Sanskritik Municipality", "Sainamaina Municipality", "Siddharthanagar Municipality", "Tilottama Municipality", "Gaidahawa Rural Municipality", "Kanchan Rural Municipality", "Kotahimai Rural Municipality", "Marchawari Rural Municipality", "Mayadevi Rural Municipality", "Omsatiya Rural Municipality", "Rohini Rural Municipality", "Sammarimai Rural Municipality", "Siyari Rural Municipality", "Suddhodhan Rural Municipality"],
    "Chitwan": ["Bharatpur Metropolitan City", "Kalika Municipality", "Khairahani Municipality", "Madi Municipality", "Ratnanagar Municipality", "Rapti Municipality", "Ichchhakamana Rural Municipality"],
    "Lumbini": ["Lumbini Municipality", "Lumbini Rural Municipality", "Lumbini Sanskritik Municipality"],

    "Bara": ["Adarshkotwal Rural Municipality", "Baragadhi Rural Municipality", "Devtal Rural Municipality", "Kolhabi Municipality", "Pheta Rural Municipality", "Simara Urban Municipality", "Suvarna Rural Municipality"],
    "Dhanusha": ["Bideha Municipality", "Ganeshman-Charnath Municipality", "Janakpur Sub-Metropolitan City", "Kamala Municipality", "Mithila Municipality", "Nagarain Municipality", "Sahidnagar Municipality"],
    "Mahottari": ["Bardibas Municipality", "Gaushala Municipality", "Jaleshwar Municipality", "Manara Siswa Municipality", "Pipra Rural Municipality", "Ramgopalpur Municipality", "Sonama Rural Municipality"],
    "Parsa": ["Bindabasini Rural Municipality", "Birgunj Metropolitan City", "Chhipaharmai Rural Municipality", "Jirabhawani Rural Municipality", "Pakaha Mainpur Rural Municipality", "Paterwa Sugauli Rural Municipality", "Sakhuwa Prasauni Rural Municipality", "Thori Rural Municipality"],
    "Rautahat": ["Baudhimai Rural Municipality", "Chandrapur Municipality", "Durga Bhagwati Rural Municipality", "Garuda Municipality", "Gaur Municipality", "Madhav Narayan Municipality", "Phatuwa Bijayapur Municipality", "Paroha Municipality"],
    "Sarlahi": ["Basbariya Rural Municipality", "Chandranagar Rural Municipality", "Godaita Municipality", "Haripur Municipality", "Ishworpur Municipality", "Lalbandi Municipality", "Malangwa Municipality", "Ramnagar Rural Municipality"],
    "Siraha": ["Aurahi Rural Municipality", "Bariyarpatti Rural Municipality", "Bishnupur Rural Municipality", "Dhangadhimai Municipality", "Golbazar Municipality", "Karjanha Municipality", "Mirchaiya Municipality", "Siraha Municipality"],
    "Saptari": ["Dakneshwori Municipality", "Kanchanrup Municipality", "Rajbiraj Municipality", "Shambhunath Municipality", "Surunga Municipality"],

    "Jhapa": ["Bhadrapur Municipality", "Shivasataxi Municipality", "Kankai Municipality", "Birtamod Municipality", "Damak Municipality", "Mechinagar Municipality", "Arjundhara Municipality", "Gauradha Municipality"],
    "Morang": ["Biratnagar Metropolitan City", "Letang Municipality", "Sunwarshi Municipality", "Rangeli Municipality", "Patahrishanishchare Municipality", "Uralabari Municipality", "Belbari Municipality", "Sundarharaicha Municipality", "Ratuwamai Municipality"],
    "Sunsari": ["Inaruwa Municipality", "Itahari Sub-Metropolitan City", "Dharan Sub-Metropolitan City", "Duhabi Municipality", "Barahchhetra Municipality", "Ramdhuni Municipality", "Bhokraha Narsingh Rural Municipality", "Koshi Rural Municipality", "Gadhi Rural Municipality", "Harina Rural Municipality"],
    "Taplejung": ["Phungling Municipality", "Sidingba Rural Municipality", "Meringden Rural Municipality", "Maiwakhola Rural Municipality", "Phaktanglung Rural Municipality", "Sirijangha Rural Municipality", "Mikwakhola Rural Municipality", "Aathrai-Tribeni Rural Municipality", "Pathivara-Yangwarak Rural Municipality"],
    "Sankhuwasabha": ["Khandbari Municipality", "Dharmadevi Municipality", "Madi Municipality", "Panchakhapan Municipality", "Chainpur Municipality", "Chichila Rural Municipality", "Silichong Rural Municipality", "Bhotkhola Rural Municipality", "Sabhapokhari Rural Municipality"],
    "Solukhumbu": ["Solududhakunda Municipality", "Sotang Rural Municipality", "Mahakulung Rural Municipality", "Likhupike Rural Municipality", "Nechasalyan Rural Municipality", "Thulung Dudhkoshi Rural Municipality", "Mapya Dudhkoshi Rural Municipality", "Khumbupasanglahmu Rural Municipality"],
    "Okhaldhunga": ["Siddhicharan Municipality", "Likhu Rural Municipality", "Molung Rural Municipality", "Sunkoshi Rural Municipality", "Champadevi Rural Municipality", "Chisankhugadhi Rural Municipality", "Khijidemba Rural Municipality", "Manebhanjyang Rural Municipality"],
    "Bhojpur": ["Bhojpur Municipality", "Shadanand Municipality", "Hatuwagadhi Rural Municipality", "Arun Rural Municipality", "Aamchowk Rural Municipality", "Pauwadungma Rural Municipality", "Tyamkemaiyun Rural Municipality", "Salpasilichho Rural Municipality"],
    "Dhankuta": ["Dhankuta Municipality", "Mahalaxmi Municipality", "Pakhribas Municipality", "Sangurigadhi Rural Municipality", "Chhathar Rural Municipality", "Chhathar Jorpati Rural Municipality", "Chaubise Rural Municipality"],
    "Ilam": ["Ilam Municipality", "Mai Municipality", "Deumai Municipality", "Suryodaya Municipality"],
    "Panchthar": ["Phidim Municipality"],
    "Khotang": ["Halesi-Tuwachung Municipality", "Diktel Rupakot Majhuwagadhi Municipality"],
    "Terhathum": ["Myanglung Municipality", "Laligurans Municipality"],
    "Udayapur": ["Triyuga Municipality", "Chaudandigadhi Municipality", "Katari Municipality", "Belaka Municipality"],

    "Bhaktapur": ["Bhaktapur Municipality", "Changunarayan Municipality", "Madhyapur Thimi Municipality", "Suryabinayak Municipality"],
    "Chitwan": ["Bharatpur Metropolitan City", "Kalika Municipality", "Khairahani Municipality", "Madi Municipality", "Ratnanagar Municipality", "Rapti Municipality", "Ichchhakamana Rural Municipality"],
    "Dhading": ["Dhunibeshi Municipality", "Nilakantha Municipality", "Benighat Rorang Rural Municipality", "Gajuri Rural Municipality", "Galchhi Rural Municipality", "Gangajamuna Rural Municipality", "Jwalamukhi Rural Municipality", "Khaniyabas Rural Municipality", "Netrawati Dabjong Rural Municipality", "Rubi Valley Rural Municipality", "Siddhalek Rural Municipality", "Thakre Rural Municipality", "Tripurasundari Rural Municipality"],
    "Dolakha": ["Bhimeshwar Municipality", "Jiri Municipality", "Baiteshwar Rural Municipality", "Bigu Rural Municipality", "Gaurishankar Rural Municipality", "Kalinchok Rural Municipality", "Melung Rural Municipality", "Sailung Rural Municipality", "Tamakoshi Rural Municipality"],
    "Kathmandu": ["Budhanilakantha Municipality", "Chandragiri Municipality", "Dakshinkali Municipality", "Gokarneshwar Municipality", "Kageshwari Manohara Municipality", "Kathmandu Metropolitan City", "Kirtipur Municipality", "Nagarjun Municipality", "Shankharapur Municipality", "Tarakeshwar Municipality", "Tokha Municipality"],
    "Kavrepalanchok": ["Banepa Municipality", "Dhulikhel Municipality", "Mandandeupur Municipality", "Namobuddha Municipality", "Panauti Municipality", "Panchkhal Municipality", "Bethanchok Rural Municipality", "Bhumlu Rural Municipality", "Chaurideurali Rural Municipality", "Khanikhola Rural Municipality", "Mahabharat Rural Municipality", "Roshi Rural Municipality", "Temal Rural Municipality"],
    "Lalitpur": ["Godawari Municipality", "Lalitpur Metropolitan City", "Mahalakshmi Municipality", "Bagmati Rural Municipality", "Konjyosom Rural Municipality", "Mahankal Rural Municipality"],
    "Makwanpur": ["Hetauda Sub-Metropolitan City", "Thaha Municipality", "Bagmati Rural Municipality", "Bakaiya Rural Municipality", "Bhimphedi Rural Municipality", "Kailash Rural Municipality", "Makwanpurgadhi Rural Municipality", "Manahari Rural Municipality", "Raksirang Rural Municipality"],
    "Nuwakot": ["Bidur Municipality", "Belkotgadhi Municipality", "Dupcheshwar Rural Municipality", "Kakani Rural Municipality", "Kispang Rural Municipality", "Likhu Rural Municipality", "Meghang Rural Municipality", "Panchakanya Rural Municipality", "Shivapuri Rural Municipality", "Suryagadhi Rural Municipality", "Tadi Rural Municipality", "Tarkeshwar Rural Municipality"],
    "Ramechhap": ["Manthali Municipality", "Doramba Rural Municipality", "Gokulganga Rural Municipality", "Khadadevi Rural Municipality", "Likhu Rural Municipality", "Ramechhap Municipality", "Sunapati Rural Municipality", "Umakunda Rural Municipality"],
    "Rasuwa": ["Kalika Rural Municipality", "Naukunda Rural Municipality", "Parbatikunda Rural Municipality", "Gosaikunda Rural Municipality", "Uttargaya Rural Municipality"],
    "Sindhuli": ["Dudhauli Municipality", "Kamalamai Municipality", "Golanjor Rural Municipality", "Hariharpurgadhi Rural Municipality", "Khangsang Rural Municipality", "Marin Rural Municipality", "Phikkal Rural Municipality", "Sunkoshi Rural Municipality", "Tinpatan Rural Municipality"],
    "Sindhupalchok": ["Bahrabise Municipality", "Chautara Sangachokgadhi Municipality", "Melamchi Municipality", "Balefi Rural Municipality", "Bhotekoshi Rural Municipality", "Indrawati Rural Municipality", "Jugal Rural Municipality", "Lisankhu Pakhar Rural Municipality", "Panchpokhari Thangpal Rural Municipality", "Sunkoshi Rural Municipality", "Tripurasundari Rural Municipality"],

    "Baglung": ["Baglung Municipality", "Dhorpatan Municipality", "Galkot Municipality", "Jaimini Municipality", "Bareng Rural Municipality", "Kathekhola Rural Municipality", "Nisikhola Rural Municipality", "Taman Khola Rural Municipality", "Tara Khola Rural Municipality"],
    "Gorkha": ["Ajirkot Rural Municipality", "Arughat Rural Municipality", "Bhimsen Rural Municipality", "Chum Nubri Rural Municipality", "Dharche Rural Municipality", "Gandaki Rural Municipality", "Gorkha Municipality", "Palungtar Municipality", "Sahid Lakhan Rural Municipality", "Siranchok Rural Municipality", "Sulikot Rural Municipality"],
    "Kaski": ["Annapurna Rural Municipality", "Madi Rural Municipality", "Machhapuchchhre Rural Municipality", "Pokhara Metropolitan City", "Rupa Rural Municipality"],
    "Lamjung": ["Aarukhola Rural Municipality", "Besisahar Municipality", "Dordi Rural Municipality", "Dudhpokhari Rural Municipality", "Kwholasothar Rural Municipality", "Madhya Nepal Municipality", "Marsyangdi Rural Municipality", "Rainas Municipality", "Sundarbazar Municipality"],
    "Manang": ["Chame Rural Municipality", "Manang Ngisyang Rural Municipality", "Narpa Bhumi Rural Municipality", "Nashong Rural Municipality"],
    "Mustang": ["Barhagaun Muktikshetra Rural Municipality", "Dalome Rural Municipality", "Gharpajhong Rural Municipality", "Lomanthang Rural Municipality", "Thasang Rural Municipality", "Lo-Ghekar Damodarkunda Rural Municipality"],
    "Myagdi": ["Annapurna Rural Municipality", "Beni Municipality", "Dhawalagiri Rural Municipality", "Malika Rural Municipality", "Mangala Rural Municipality", "Raghuganga Rural Municipality"],
    "Nawalpur": ["Baudikali Rural Municipality", "Binayi Triveni Rural Municipality", "Bulingtar Rural Municipality", "Devchuli Municipality", "Gaindakot Municipality", "Hupsekot Rural Municipality", "Kawasoti Municipality", "Madhyabindu Municipality"],
    "Parbat": ["Bihadi Rural Municipality", "Jaljala Rural Municipality", "Kushma Municipality", "Mahashila Rural Municipality", "Modi Rural Municipality", "Paiyun Rural Municipality", "Phalebas Municipality"],
    "Syangja": ["Aandhikhola Rural Municipality", "Arjun Chaupari Rural Municipality", "Bhirkot Municipality", "Chapakot Municipality", "Galyang Municipality", "Harinas Rural Municipality", "Kaligandaki Rural Municipality", "Phedikhola Rural Municipality", "Putalibazar Municipality", "Waling Municipality"],
    "Tanahun": ["Aanbukhaireni Rural Municipality", "Bandipur Rural Municipality", "Bhanu Municipality", "Bhimad Municipality", "Byas Municipality", "Devghat Rural Municipality", "Ghiring Rural Municipality", "Myagde Rural Municipality", "Rhishing Rural Municipality", "Shuklagandaki Municipality"],

    "Achham": ["Sanphebagar Municipality", "Mangalsen Municipality", "Kamalbazar Municipality", "Panchadewal Binayak Municipality"],
    "Baitadi": ["Dasharathchanda Municipality", "Melauli Municipality", "Patan Municipality", "Purchaudi Municipality"],
    "Bajhang": ["JayaPrithivi Municipality", "Bungal Municipality", "Masta Rural Municipality", "Thalara Rural Municipality", "Talkot Rural Municipality", "Surma Rural Municipality", "Saipal Rural Municipality", "Durgathali Rural Municipality", "Bithadchir Rural Municipality", "Chabispathivera Rural Municipality"],
    "Bajura": ["Badimalika Municipality", "Tribeni Municipality", "Budhiganga Municipality", "Budhinanda Municipality", "Gaumul Rural Municipality", "Himali Rural Municipality", "Jagannath Rural Municipality", "Khaptad Chhededaha Rural Municipality", "Swami Kartik Khaapar Rural Municipality"],
    "Dadeldhura": ["Amargadhi Municipality", "Parashuram Municipality", "Alital Rural Municipality", "Ajaymeru Rural Municipality", "Bhageshwar Rural Municipality", "Nawadurga Rural Municipality", "Ganayapdhura Rural Municipality"],
    "Darchula": ["Mahakali Municipality", "Shailyashikhar Municipality", "Lekam Rural Municipality", "Naugad Rural Municipality", "Byas Rural Municipality", "Dunhu Rural Municipality", "Marma Rural Municipality", "Apihimal Rural Municipality", "Malikaarjun Rural Municipality"],
    "Doti": ["Dipayal Silgadhi Municipality", "Shikhar Municipality", "Sayal Rural Municipality", "Adarsha Rural Municipality", "Jorayal Rural Municipality", "Badikedar Rural Municipality", "Purbichauki Rural Municipality", "K I Singh Rural Municipality", "Bogtan Foodsil Rural Municipality"],
    "Kailali": ["Dhangadhi Sub-Metropolitan City", "Tikapur Municipality", "Ghodaghodi Municipality", "Bhajani Municipality", "Gauriganga Municipality", "Godawari Municipality", "Lamki Chuha Municipality", "Chure Rural Municipality", "Janaki Rural Municipality", "Kailari Rural Municipality", "Joshipur Rural Municipality", "Mohanyal Rural Municipality", "Bardagoriya Rural Municipality"],
    "Kanchanpur": ["Bhimdatta Municipality", "Punarbas Municipality", "Krishnapur Municipality", "Mahakali Municipality", "Bedkot Municipality", "Belauri Municipality", "Shuklaphanta Municipality", "Beldandi Rural Municipality", "Laljhadi Rural Municipality"],

    
    "Dailekh": ["Aathbis Municipality","Chamunda Bindrasaini Municipality","Dullu Municipality","Narayan Municipality","Bhagawatimai Rural Municipality","Bhairabi Rural Municipality","Dungeshwor Rural Municipality","Gurans Rural Municipality","Mahabu Rural Municipality"],
    "Dolpa": ["Tripurasundari Municipality","Thuli Bheri Municipality","Mudkechula Rural Municipality","Kaike Rural Municipality","Jagadulla Rural Municipality","Dolpo Buddha Rural Municipality","Shey Phoksundo Rural Municipality"],
    "Humla": ["Chankheli Rural Municipality","Kharpunath Rural Municipality","Namkha Rural Municipality","Sarkegad Rural Municipality","Simkot Rural Municipality","Adanchuli Rural Municipality"],
    "Jajarkot": ["Bheri Municipality","Nalgad Municipality","Chhedagad Municipality","Junichande Rural Municipality","Kuse Rural Municipality","Barekot Rural Municipality"],
    "Jumla": ["Chandannath Municipality","Kankasundari Rural Municipality","Patarasi Rural Municipality","Tatopani Rural Municipality","Tila Rural Municipality","Guthichaur Rural Municipality","Hima Rural Municipality","Sinja Rural Municipality"],
    "Kalikot": ["Raskot Municipality","Tilagufa Municipality","Khandachakra Municipality","Sanni Triveni Rural Municipality","Narharinath Rural Municipality","Pachaljharana Rural Municipality","Palata Rural Municipality","Shubha Kalika Rural Municipality"],
    "Mugu": ["Chhayanath Rara Municipality","Khatyad Rural Municipality","Mugu Rural Municipality","Soru Rural Municipality"],
    "Salyan": ["Bagchaur Municipality","Bangad Kupinde Municipality","Chhatreshwari Rural Municipality","Darma Rural Municipality","Kalimati Rural Municipality","Kapurkot Rural Municipality","Kumakh Rural Municipality","Sharada Municipality","Tribeni Rural Municipality"],
    "Surkhet": ["Birendranagar Municipality","Bheriganga Municipality","Chaukune Rural Municipality","Chingad Rural Municipality","Gurbhakot Municipality","Lekbesi Municipality","Barahatal Rural Municipality","Panchapuri Municipality"],
    "West Rukum": ["Aathbiskot Municipality","Banphikot Rural Municipality","Chaurjahari Municipality","Musikot Municipality","Sanibheri Rural Municipality","Tribeni Rural Municipality"]

    // Add all districts and their municipalities here
};

function normalizeStr(s) {
    if (!s) return '';
    // lower, remove diacritics, remove non-alphanum
    s = s.toString().toLowerCase().trim();
    // replace special unicode hyphens with normal hyphen
    s = s.replace(/[\u2010-\u2015]/g, '-');
    // remove diacritics
    s = s.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    // remove non alphanumeric
    s = s.replace(/[^a-z0-9]/g, '');
    return s;
}

// Levenshtein distance for fallback fuzzy match
function levenshtein(a, b){
    if (a === b) return 0;
    if (a.length === 0) return b.length;
    if (b.length === 0) return a.length;
    const matrix = [];
    let i;
    for (i = 0; i <= b.length; i++) {
        matrix[i] = [i];
    }
    let j;
    for (j = 0; j <= a.length; j++) {
        matrix[0][j] = j;
    }
    for (i = 1; i <= b.length; i++) {
        for (j = 1; j <= a.length; j++) {
            if (b.charAt(i-1) === a.charAt(j-1)) {
                matrix[i][j] = matrix[i-1][j-1];
            } else {
                matrix[i][j] = Math.min(
                    matrix[i-1][j] + 1,    // deletion
                    matrix[i][j-1] + 1,    // insertion
                    matrix[i-1][j-1] + 1   // substitution
                );
            }
        }
    }
    return matrix[b.length][a.length];
}

function findMunicipalityKey(selectedDistrict) {
    if (!selectedDistrict) return null;
    const keys = Object.keys(municipalities);
    const normSel = normalizeStr(selectedDistrict);

    // 1) exact normalized match
    for (let k of keys) {
        if (normalizeStr(k) === normSel) return k;
    }

    // 2) startsWith / includes match
    for (let k of keys) {
        const nk = normalizeStr(k);
        if (nk.indexOf(normSel) !== -1 || normSel.indexOf(nk) !== -1) return k;
    }

    // 3) fuzzy Levenshtein small threshold
    let best = null;
    let bestDist = Infinity;
    for (let k of keys) {
        const nk = normalizeStr(k);
        const dist = levenshtein(nk, normSel);
        if (dist < bestDist) {
            bestDist = dist;
            best = k;
        }
    }
    // allow match if reasonably close (threshold 3)
    if (bestDist <= 3) return best;

    // no match found
    return null;
}

function updateMunicipalities() {
    const district = document.getElementById('district').value;
    const municipalitySelect = document.getElementById('municipality');
    municipalitySelect.innerHTML = '<option value="">-- Select Municipality --</option>';

    // find best matching key in municipalities object
    const key = findMunicipalityKey(district);

    if (key && municipalities[key]) {
        municipalities[key].forEach(mun => {
            const opt = document.createElement('option');
            opt.value = mun;
            opt.textContent = mun;
            municipalitySelect.appendChild(opt);
        });
    } else {
        // nothing matched — leave the default option
        // optionally you can show a console warning for debugging
        console.warn('No municipalities found for district:', district, 'matched key:', key);
    }
}

// ensure event wired after DOM ready
document.addEventListener('DOMContentLoaded', function() {
    const districtSelect = document.getElementById('district');
    if (districtSelect) {
        districtSelect.addEventListener('change', updateMunicipalities, false);
    }
});
</script>

</body>
</html>
