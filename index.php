<?php
// Inisialisasi variabel hasil
$result = "";

// Fungsi untuk menambahkan dua matriks
function addMatrices($matrixA, $matrixB) {
    $resultMatrix = [];
    for ($i = 0; $i < count($matrixA); $i++) {
        $resultMatrix[$i] = [];
        for ($j = 0; $j < count($matrixA[$i]); $j++) {
            $resultMatrix[$i][$j] = $matrixA[$i][$j] + $matrixB[$i][$j];
        }
    }
    return $resultMatrix;
}

// Fungsi untuk mengalikan dua matriks
function multiplyMatrices($matrixA, $matrixB) {
    $resultMatrix = [];
    for ($i = 0; $i < count($matrixA); $i++) {
        $resultMatrix[$i] = [];
        for ($j = 0; $j < count($matrixA[$i]); $j++) {
            $resultMatrix[$i][$j] = $matrixA[$i][$j] * $matrixB[$i][$j];
        }
    }
    return $resultMatrix;
}

// Fungsi untuk mengurangkan dua matriks
function subtractMatrices($matrixA, $matrixB) {
    $resultMatrix = [];
    for ($i = 0; $i < count($matrixA); $i++) {
        $resultMatrix[$i] = [];
        for ($j = 0; $j < count($matrixA[$i]); $j++) {
            $resultMatrix[$i][$j] = $matrixA[$i][$j] - $matrixB[$i][$j];
        }
    }
    return $resultMatrix;
}

// Fungsi untuk memeriksa apakah dua matriks memiliki dimensi yang sama
function haveSameDimensions($matrixA, $matrixB) {
    return count($matrixA) === count($matrixB) && count($matrixA[0]) === count($matrixB[0]);
}

// Fungsi untuk membersihkan dan memformat masukan matriks dari textarea
function cleanAndFormatMatrix($matrixString) {
    $matrixString = preg_replace("/[^0-9,\[\]\.\\-]/", "", $matrixString);
    $matrix = json_decode($matrixString, true);
    return $matrix;
}

// Logika PHP untuk menangani formulir HTML
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil matriks A dan B dari formulir
    $matrixA = cleanAndFormatMatrix($_POST["matrixA"]);
    $matrixB = cleanAndFormatMatrix($_POST["matrixB"]);

    // Ambil operasi yang dipilih
    $operation = $_POST["operation"];

    // Validasi matriks
    if (!empty($matrixA) && !empty($matrixB) && haveSameDimensions($matrixA, $matrixB)) {
        // Tentukan hasil berdasarkan operasi yang dipilih
        switch ($operation) {
            case "add":
                $resultMatrix = addMatrices($matrixA, $matrixB);
                $result = "Hasil Penjumlahan: " . json_encode($resultMatrix);
                break;
            case "multiply":
                $resultMatrix = multiplyMatrices($matrixA, $matrixB);
                $result = "Hasil Perkalian: " . json_encode($resultMatrix);
                break;
            case "subtract":
                $resultMatrix = subtractMatrices($matrixA, $matrixB);
                $result = "Hasil Pengurangan: " . json_encode($resultMatrix);
                break;
            default:
                $result = "Operasi tidak valid";
        }
    } else {
        $result = "Matriks tidak valid atau memiliki dimensi yang berbeda";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matriks Operasi</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #258bcf;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            width: 400px;
            background-color: #3498db;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 10px 10px 10px rgba(0, 0, 0, 0.5);
            text-align: center;
            color: #fff;
        }

        h1 {
            color: #fff;
        }

        .matrix-input {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #fff;
        }

        textarea, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: none;
            border-radius: 5px;
            background-color: #fff;
        }

        button {
            background-color: #2ecc71;
            color: #fff;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #27ae60;
        }

        #hasil {
            font-size: 18px;
            margin-top: 20px;
            background-color: #fff;
            padding: 10px;
            border-radius: 5px;
            color: #333;
        }

        /* Responsive styles */
        @media screen and (max-width: 600px) {
            .container {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Matriks Operasi</h1>
        <form method="post" action="">
            <div class="matrix-input">
                <label for="matrixA">Masukkan Matriks A Contoh: [[1, 2], [3, 4]]:</label>
                <textarea id="matrixA" name="matrixA" rows="3" cols="30"><?php echo isset($_POST['matrixA']) ? htmlspecialchars($_POST['matrixA']) : ''; ?></textarea>
                <label for="matrixB">Masukkan Matriks B Contoh: [[1, 2], [3, 4]]:</label>
                <textarea id="matrixB" name="matrixB" rows="3" cols="30"><?php echo isset($_POST['matrixB']) ? htmlspecialchars($_POST['matrixB']) : ''; ?></textarea>
                <label for="operation">Pilih Operasi:</label>
                <select id="operation" name="operation">
                    <option value="add">Penjumlahan</option>
                    <option value="multiply">Perkalian</option>
                    <option value="subtract">Pengurangan</option>
                </select>
                <button type="submit">Hitung</button>
            </div>
        </form>
        <div id="hasil"><?php echo $result; ?></div>
    </div>
</body>
</html>
