<!DOCTYPE html>
<html lang="lo">
<head>
<meta charset="UTF-8">
<style>
    body {
        font-family: "DejaVu Sans", sans-serif;
        font-size: 14px;
        line-height: 1.8;
        margin: 40px;
    }

    .center { text-align: center; }
    .right { text-align: right; }

    .title {
        font-weight: bold;
        margin-top: 10px;
    }

    .content {
        margin-top: 20px;
        text-align: justify;
    }

    .signature {
        margin-top: 60px;
        width: 100%;
    }

    .signature td {
        width: 50%;
        text-align: center;
    }
</style>
</head>
<body> 
<div class="center">
    <div>ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ</div>
    <div>ສັນຕີພາບ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັດທະນະຖາວອນ</div>
</div>

<div class="title center">
    ບົດບັນທຶກ
</div>

<div class="center">
    ວັນທີ {{ date('d-m-Y', strtotime($data->date_in)) }}
</div>

<div class="content">
    ໃນວັນທີ {{ date('d-m-Y', strtotime($data->date_in)) }},
    ເວລາ {{ date('H:i', strtotime($data->date_in)) }} ໂມງ,
    ລົດຂົນສົ່ງ ໝາຍເລກ {{ $data->plate_number }}
    ປະເພດ {{ $data->t_type_name }}
    ຂອງບໍລິສັດ {{ $data->com_name }}

    ບ້ານ {{ $data->address }}
    ເມືອງ {{ $data->district }}
    ແຂວງ {{ $data->province }}

    ໄດ້ດຳເນີນການບໍ່ຖືກຕ້ອງຕາມເງື່ອນໄຂ...

    1. ຕ້ອງປະຕິບັດຕາມໃບອະນຸຍາດ  
    2. ຖ້າຝ່າຝືນ ຈະມີມາດຕະການ  
    3. ຕ້ອງແຈ້ງກ່ອນປ່ຽນແປງ  
</div>

<table class="signature">
    <tr>
        <td>ບໍລິສັດ</td>
        <td>ຜູ້ບັນທຶກ</td>
    </tr>
</table>

</body>
</html>