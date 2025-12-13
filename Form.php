<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "swornabindu";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $full_name   = $_POST['full_name'];
    $gender      = $_POST['gender'];
    $age         = $_POST['age'];
    $district    = $_POST['district'];
    $municipality = $_POST['municipality'];
    $father_name = $_POST['father_name'];
    $mother_name = $_POST['mother_name'];
    $contact     = $_POST['contact_number'];

    // HEALTH INFO
    $bindu_status = $_POST['bindu_status'];
    $allergy      = $_POST['allergy_history'];
    $medical      = $_POST['medical_history'];
    $weight       = $_POST['weight'];
    $height       = $_POST['height'];
    $muac         = $_POST['muac'];
    $upper_arm    = $_POST['upper_arm_circ'];
    $chest        = $_POST['chest_circ'];

    // DOCTOR ADMIN
    $doctor_name = $_POST['doctor_name'];
    $batch_no    = $_POST['batch_no'];
    $dose        = $_POST['dose'];
    $note        = $_POST['note'];

    $consent_eligible = isset($_POST['consent_eligible']) ? 1 : 0;
    $consent_guardian = isset($_POST['consent_guardian']) ? 1 : 0;


    // qr save in db
    // $stmt = $conn->prepare("INSERT INTO full_registration (full_name, qr_blob) VALUES(?,?)");
    // $stmt->bind_param("sb",$full_name,$null);
    // $stmt-> send_long_data(1,$imageData);
    // $stmt->execute();

    // PREPARED STATEMENT
    $stmt = $conn->prepare("
        INSERT INTO full_registration(full_name, gender, child_age_year, age, district, municipality, father_name, mother_name, contact_number,
        bindu_status, allergy_history, medical_history, weight, height, muac, upper_arm_circ, chest_circ,
        doctor_name, batch_no, dose, note, consent_eligible, consent_guardian, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");

    $stmt->bind_param(
        "ssiissssssssdddddssisii",
        $full_name, $gender, $age_year, $age_month, $district, $municipality,
        $father_name, $mother_name, $contact,
        $bindu_status, $allergy, $medical,
        $weight, $height, $muac, $upper_arm, $chest,
        $doctor_name, $batch_no, $dose, $note,
        $consent_eligible, $consent_guardian
    );

    if ($stmt->execute()) {
        echo "<script>alert('Registration Successful');</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
<!-- qr code generate -->
<?php
$server = mysqli_connect("localhost", "root", "", "swornabindu");
if (!$server) {
    die("Database connection failed: " . mysqli_connect_error());
}

$full_name = '';
$gender    = '';
$age       = '';
$district  = '';

if (isset($_POST['btnsubmit'])) {

    $full_name = $_POST["full_name"] ?? '';
    $gender    = $_POST["gender"] ?? '';
    $age       = $_POST["age"] ?? '';
    $district  = $_POST["district"] ?? '';

    $qrtext = "Name: $full_name\nGender: $gender\nAge: $age\nDistrict: $district";

    require_once 'phpqrcode/qrlib.php';

    $path = "images/";
    if (!is_dir($path)) {
        mkdir($path, 0777, true);
    }

    $qr_image = time() . ".png";
    $full_qr_path = $path . $qr_image;

    QRcode::png($qrtext, $full_qr_path, "H", 4, 4);

    $query = "INSERT INTO full_registration 
              (full_name, gender, age, district, qr_image)
              VALUES ('$full_name', '$gender', '$age', '$district', '$qr_image')";

    if (mysqli_query($server, $query)) {
        $id = mysqli_insert_id($server);
        header("Location: RegistrationSucc.php?id=$id");
        exit;
    } else {
        echo "Database Error: " . mysqli_error($server);
    }
}
?>

<!DOCTYPE html>
<html lang="ne">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Registration & Health Info & Doctor Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background:#f5f7f8; font-family:'Noto Sans Devanagari','Segoe UI',sans-serif; font-size:14px; }
.main-box { max-width:1000px; margin:30px auto; border-radius:18px; background:#fff; padding:24px 28px 28px; box-shadow:0 4px 18px rgba(0,0,0,0.06);}
.section-box { border:1px solid #cfe3d8; border-radius:10px; padding:20px; background:#f9fff9; margin-bottom:20px; }
.toggle-btn.active { background-color:#28a745 !important; color:#fff !important; }
.custom-textarea:focus { border-color:gray; box-shadow:0 0 0 0.2rem rgba(101,102,104,0.25); outline:0; }
.active-doctor{ background:#0d6efd !important; color:white !important; border-color:#0d6efd !important; }
.doctor-btn button{width:100%; margin-bottom:5px;}
@media(min-width:576px){ .doctor-btn button{width:auto;} .doctor-btn{flex-wrap:wrap; gap:10px;} }
.security{
  background-color: #FEFCE8;
  color: rgb(137, 78, 22);
}
</style>
</head>
<body>

<div class="main-box">
<form method="POST" action="">

<!-- REGISTRATION -->
<div class="section-box">
<h5 class="fw-bold mb-3">बच्चाको विवरण | Child Info</h5>
<div class="row g-3">
    <div class="col-md-6"><label class="fw-semibold"> बच्चाको नाम *  </label>
    <input type="text" name="full_name" value="<?php echo $full_name;?>" class="form-control custom-textarea" required></div>
    <div class="col-md-6">
        <label class="fw-semibold">लिङ्ग *</label>
        <select name="gender"  value="<?php echo $gender;?>"class="form-control custom-textarea" required><option value="">Select

        </option><option value="Male">Male</option>
        <option value="Female">Female</option> </option>
        <option value="Other">Other</select>
    </div>

    <!-- Age -->
                        <div class="justify-content-between">
                            <label class="form-label custom-textarea "><b>बच्चाको उमेर *</b></label>
                            <div class="age-wrapper col-md-4 d-flex justify-content-between">
                                <div class="col-md-3">
                                <label for="">महिना</label>
                                    <input type="number" name="age" value=<?php echo $age; ?> class="form-control age-input custom-textarea" min="6" max="60" required>
                                    
                                </div>
                            </div>
                        </div>


    <div class="d-flex justify-content-between">
                        <div class="col-md-5">
                            <label class="form-label">District *</label>
                            <select class="form-select custom-textarea" name="district" value="<?php echo $district;?>" id="district" required onchange="updateMunicipalities()">
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
                            
                            </select>
                        </div>

                        <!-- Municipality -->
                        <div class="col-md-6">
                            <label class="form-label ">Municipality *</label>
                            <select class="form-select custom-textarea" name="municipality" id="municipality" required>
                                <option value="">-- Select Municipality --</option>
                            </select>
                        </div>
    </div>
            <div class=" col-lg-6">
            <label class="fw-semibold text-dark">अभिभावक विवरण | Guardian Info</label>
            <!-- Father name -->
                <div class="mt-4">
                            <label class="form-label ">बुबाको नाम</label>
                            <input type="text" class="form-control custom-textarea" name="father_name">
                        </div>

                        <!-- Mother name -->
                            <div class="mt-4">
                            <label class="form-label ">आमाको नाम</label>
                            <input type="text" class="form-control custom-textarea" name="mother_name">
                        </div>

                        <!-- Contact -->
                            <div class="mt-4">
                            <label class="form-label ">सम्पर्क नम्बर </label>
                            <div class="input-group">
                                <span class="input-group-text">+977</span>
                                <input type="text" class="form-control custom-textarea" name="contact_number"  placeholder="9800000000">
                            </div>
                        </div>

    </div>
</div>
</div>
<!-- HEALTH INFO -->
<div class="section-box">
<h5 class="fw-bold mb-3">स्वास्थ्य जानकारी | Health Info</h5>
<input type="hidden" name="bindu_status" id="bindu_status" value="New">
<div class="row g-4">
<div class="col-lg-6">
<label class="fw-bold mb-2">बिन्दु स्थिति | Bindu Status</label>
<div class="d-flex gap-2 mb-3">
<button type="button" class="btn btn-outline-dark toggle-btn active" onclick="setBindu('New', this)">New</button>
<button type="button" class="btn btn-outline-dark toggle-btn" onclick="setBindu('Old', this)">Old</button>
</div>
<label class="fw-semibold mb-2">Allergy History</label>
<textarea name="allergy_history" class="form-control custom-textarea mb-3" rows="3"></textarea>
<label class="fw-semibold mb-2">Medical History</label>
<textarea name="medical_history" class="form-control custom-textarea" rows="3"></textarea>
</div>
<div class="col-lg-6">
<h6 class="fw-bold mb-3"> शारीरिक मापन |Anthropometry</h6>
<div class="row gy-3">
<div class="col-md-4"><label class="fw-semibold">Weight (kg)</label><input type="number" name="weight" min="0" class="form-control custom-textarea" required></div>
<div class="col-md-4"><label class="fw-semibold">Height (cm)</label><input type="number" name="height" min="0" class="form-control custom-textarea" required></div>
<div class="col-md-4"><label class="fw-semibold">MUAC (cm)</label><input type="number" name="muac" min="0" class="form-control custom-textarea" required></div>
<div class="col-md-6"><label class="fw-semibold">Head circumference (cm)</label><input type="number" name="upper_arm_circ" min="0" class="form-control custom-textarea"></div>
<div class="col-md-6"><label class="fw-semibold">Chest (cm)</label><input type="number" name="chest_circ" min="0" class="form-control custom-textarea"></div>
</div>
</div>
</div>
</div>

<!-- DOCTOR ADMINISTRATION -->
<div class="section-box">
<h5 class="fw-bold mb-3">Administration Form | चिकित्सक विवरण</h5>
<p>सेवन गराउने व्यक्ति *</p>
<div class="doctor-btn d-flex mb-3">
<button type="button" class="btn btn-light doctor-select" onclick="setDoctor('डा. प्रतिभा शर्मा',this)">डा. प्रतिभा शर्मा</button>
<button type="button" class="btn btn-light doctor-select" onclick="setDoctor('डा. यक राज भण्डारी',this)">डा. यक राज भण्डारी</button>
</div>
<input type="hidden" id="doctor_name" name="doctor_name">
<div class="row mt-2">
<div class="col-md-6"><label>ब्याच नम्बर</label><input type="text" name="batch_no" class="form-control custom-textarea"></div>
<div class="col-md-6"><label>मात्रा (थोपा)</label><input type="number" name="dose" class="form-control custom-textarea" value="1"></div>
</div>
<div class="mt-2"><label>टिप्पणी</label><textarea name="note" class="form-control custom-textarea" rows="3"></textarea></div>
<div class="form-check mt-2"><input class="form-check-input" type="checkbox" name="consent_eligible" checked><label class="form-check-label">
  म पुष्टि गर्छु कि यो बच्चा योग्य छ र कुनै निषेधित अवस्था छैन।
</label></div>
<div class="form-check mt-1"><input class="form-check-input" type="checkbox" name="consent_guardian" checked><label class="form-check-label">अभिभावकको सहमति लिइएको छ र सबै सावधानीहरू बुझाइएको छ।</label></div>

<div class="col-lg-10 security fw-semibold mt-1">
  <p>सुरक्षा निर्देशनहरू:</p>
  <p>सेवन पछि ३० मिनेटसम्म खाना नदिनुहोस्</p>
  <p>कुनै प्रतिकूल प्रतिक्रिया देखिएमा तुरुन्त रोक्नुहोस्</p> 
  <p>अर्को मात्रा पुष्य नक्षत्रमा मात्र दिनुहोस्</p>
</div>
</div>

<div class="d-flex justify-content-between mt-3">
<button type="submit" name="btnsubmit" class="btn btn-dark">Submit All</button>
</div>

</form>
    <?php
    // include "phpqrcode/qrlib.php";
    $PNG_TEMP_DIR = 'temp/';
    if(!file_exists($PNG_TEMP_DIR)){
        mkdir($PNG_TEMP_DIR);
    }
    if(isset($_POST["btnsubmit"])){
        $codeString = $_POST["full_name"]."\n";
        $codeString .= $_POST["gender"]. "\n";
        $codeString .= $_POST["age"]. "\n";
        $codeString .= $_POST["district"];

        $filename = $PNG_TEMP_DIR.'test'.md5($codeString).'.png';
        QRcode :: png ($codeString, $filename);

        echo '<img src="' .$PNG_TEMP_DIR. basename ($filename).'">';
    }
    ?>
    <?php
    // if(extension_loaded('gd') && function_exists('imagecreatetruecolor')){
    //     echo "GD Library Enabled";
    // }
    // else
    // {
    //     echo "GD NOT Enabled";
    // }
    ?>

</div>

<script>
function setBindu(status, btn){
    document.getElementById('bindu_status').value = status;
    document.querySelectorAll('.toggle-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
}

const doctorBatchMap = {
    // "डा. प्रतिभा शर्मा": "P250600170",
    // "डा. यक राज भण्डारी": "SB251128280"
};

function setDoctor(name, btn){
    document.getElementById('doctor_name').value = name;
    document.querySelector('input[name="batch_no"]').value = doctorBatchMap[name] || "";
    document.querySelectorAll('.doctor-select').forEach(b=>b.classList.remove('active-doctor'));
    btn.classList.add('active-doctor');
}

const municipalities = {
    "Dang": ["Ghorahi Sub-Metropolitan City", "Tulsipur Sub-Metropolitan City", "Lamahi Municipality", "Rapti Rural Municipality", "Banglachuli Rural Municipality", "Gadhawa Rural Municipality", "Babai Rural Municipality", "Dangisharan Rural Municipality", "Rajpur Rural Municipality", "Shantinagar Rural Municipality"],
    "Rolpa": ["Runtigadhi Rural Municipality", "Triveni Rural  Municipality", "Sunilsmiriti Rural Municipality", "Thabang Rural Municipality" ,"Madi Rural Municipality", "Gangadev Rural Municipality", "Paribartan Rural Municipality"],
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
