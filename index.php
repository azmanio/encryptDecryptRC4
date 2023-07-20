<!DOCTYPE html>
<html>

<head>
    <title>Enkripsi/Dekripsi RC4</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <h1>Program Enkripsi dan Dekripsi Menggunakan Algoritma RC4</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="action">Action:</label>
                <select class="form-control" name="action" id="action">
                    <?php
                    if($_POST["action"]) {
                        echo '<option selected value="'.$_POST["action"].'">'.$_POST["action"].'</option>';
                    } else {
                        echo '<option value="menu" selected disabled>--- Pilih Menu ---</option>';
                    }
                    ?>
                    <option value="Enkripsi">Enkripsi</option>
                    <option value="Dekripsi">Dekripsi</option>
                </select>
            </div>

            <div class="form-group">
                <label for="key">Key:</label>
                <input type="text" class="form-control" name="key" id="key" required value="<?php if(isset($_POST["key"])){
                    echo $_POST["key"];
                } ?>">
            </div>

            <div class="form-group">
                <label for="text">Text:</label>
                <textarea class="form-control" name="text" id="text" rows="5" required><?php if(isset($_POST["text"])){echo $_POST["text"];} ?></textarea>
            </div>

            <button type="proses" class="btn btn-primary">Proses</button>
            <input type="button" class="btn btn-primary" value="Reset" onclick="location.reload()">
        </form>

        <?php
        function rc4($key, $text)
        {
            $s = array();
            for ($i = 0; $i < 256; $i++) {
                $s[$i] = $i;
            }

            $j = 0;
            $keyLength = strlen($key);
            for ($i = 0; $i < 256; $i++) {
                $j = ($j + $s[$i] + ord($key[$i % $keyLength])) % 256;
                $temp = $s[$i];
                $s[$i] = $s[$j];
                $s[$j] = $temp;
            }

            $i = 0;
            $j = 0;
            $result = '';
            $textLength = strlen($text);
            for ($k = 0; $k < $textLength; $k++) {
                $i = ($i + 1) % 256;
                $j = ($j + $s[$i]) % 256;
                $temp = $s[$i];
                $s[$i] = $s[$j];
                $s[$j] = $temp;
                $result .= chr(ord($text[$k]) ^ $s[($s[$i] + $s[$j]) % 256]);
            }

            return $result;
        }

        // Mendapatkan input dari form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'];
            $key = $_POST['key'];
            $text = $_POST['text'];

            if ($action === 'Enkripsi') {
                $encryptedText = base64_encode(rc4($key, $text));
            } elseif ($action === 'Dekripsi') {
                $decryptedText = rc4($key, base64_decode($text));
            }
        }
        ?>

        <?php if (isset($encryptedText)) { ?>
            <h3>Encrypted Text:</h3>
            <textarea class="form-control" readonly rows="5"> <?php echo $encryptedText; ?> </textarea>
        <?php } ?>

        <?php if (isset($decryptedText)) { ?>
            <h3>Decrypted Text:</h3>
            <textarea class="form-control" readonly rows="5"> <?php echo $decryptedText; ?> </textarea>
        <?php } ?>
    </div>
    <nav class="navbar fixed-bottom">
        <div class="container-fluid">
            <p>
                Azis Rahman Prasetio | 200511018 | TI20B | Teknik Informatika | Universitas Muhammadiyah Cirebon
            </p>
        </div>
    </nav>
</body>

</html>