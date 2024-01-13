<<?php
session_start();
if (!isset($_SESSION['user'])) {
    return header('Location: http://localhost:8080/konterzidan/views/login/' );
}
?>
!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembelian Stok Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">PEMBELIAN STOK KONTER ZIDAN</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../dashboard/index.php">Home</a>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Transaksi
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="../penjualan/index.php">Penjualan</a></li>
                                <li><a class="dropdown-item" href="../pembelian/index.php">Pembelian</a></li>
                            </ul>
                        </li>                    
                    </ul>
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                    </div>
                </div>
            </nav>
    <div class="">        
        <div id="message">
        </div>
        <div class="container px-4">
            <form class="row g-1" id="sample_form">
                <div class="col-md-6">
                    <label for="idtrx" class="form-label">ID TRX</label>
                    <input type="text" class="form-control" id="idtrx">
                </div>
                <div class="col-md-6">
                    <label for="nama_supp" class="form-label">Supplier</label>
                    <input type="text" class="form-control" id="nama_supp" placeholder="John Doe">
                </div>
                <div class="col-md-6">
                    <label for="kasir" class="form-label">Kasir</label>
                    <input type="text" class="form-control" id="kasir" value="<?php echo $_SESSION['user']['fullname']; ?>">
                </div>
                <div class="col-12" id="target_area">
                    <div class="row g-1 p-1" >
                        <div class="col-md-2">
                            <label for="kasir" class="form-label">Kode Barang</label>
                        </div>
                        <div class="col-md-2">
                            <label for="kasir" class="form-label">Nama Barang</label>
                        </div>
                        <div class="col-md-2">
                            <label for="kasir" class="form-label">Harga</label>
                        </div>
                        <div class="col-md-2">
                            <label for="kasir" class="form-label">QTY</label>
                        </div>
                        <div class="col-md-2">
                            <label for="kasir" class="form-label">Sub Total</label>
                        </div>
                        <div class="col-md-2">
                            <label for="deleteBrg" class="form-label">Action</label>
                        </div>
                    </div>
                    <div class="row g-1 p-1" data-area="area_50">
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="kd_barang[]" id="kd_barang">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="nm_barang[]" id="nm_barang">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="hrg_barang[]" id="hrg_barang">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="qty[]" id="qty">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="total_harga[]" id="total_harga" readonly>
                        </div>
                        <div class="col-md-2">
                            <button type="button" id="delete_colom" class="btn btn-danger" >Delete</button>
                            <button type="button" id="add_colom" class="btn btn-secondary">Add</button>
                        </div>
                    </div>
                </div>
                <div class="row g-1">
                    <div class="col-md-5 text-end align-items-center">
                        <label for="total" class="form-label" >GRAND TOTAL</label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="grand_total" readonly>
                    </div>
                    <div class="col-md-1">
                    <button type="submit" class="btn btn-primary" id="action_button">Save</button>
                </div>
            </form>
        </div>        
    </div>
    <div>
    <p>
        <h1 align = "center">
        Selamat Berbelanja!!!
        </h1>
    </p><br>

    </div>
    <script>
         $(document).ready(function() {

            handleBtnDeleteColom();
            handleBtnAddColom();
            handleHitung();

            $('#sample_form').on('submit', function(event){
                event.preventDefault();

                const details = [];
                $('[data-area]').each(function() {
                    detail = {
                        "idtrx": $('#idtrx').val(),
                        "kd_barang": $(this).find('input#kd_barang').val(),
                        "nm_barang":$(this).find('input#nm_barang').val(),
                        "hrg_barang": $(this).find('input#hrg_barang').val(),
                        "qty": $(this).find('input#qty').val(),
                        "total_harga":$(this).find('input#total_harga').val()
                    };
                    details.push(detail);
                });

                
                
                var formData = {
                    "idtrx": $('#idtrx').val(),
                    "tgl_pembelian": $('#tgl_pembelian').val(),
                    "nama_supp": $('#nama_supp').val(),
                    "kasir": $('#kasir').val(),
                    "grand_total" : $('#grand_total').val(),
                    "details" : details
                }
                console.log(JSON.stringify(formData));

                $.ajax({
                    url:"http://localhost:8080/konterzidan/api/pembelian/create.php",
                    method:"POST",
                    data: JSON.stringify(formData),
                    success:function(data){
                        $('#action_button').attr('disabled', false);
                        window.location.href = 'http://localhost:8080/konterzidan/views/pembelian/index.php';
                    },
                    error: function(err) {
                        console.log(err);   
                        $('#message').html('<div class="alert alert-danger">'+err.responseJSON+'</div>');  
                    }
                });
            });

            function handleBtnAddColom(){
                var target_area = $("#target_area");
                $("button#add_colom").off("click").on("click", function(){
                    var _this = $(this),
                    currentArea = _this.parent().parent(),
                    cloningan = currentArea.clone();

                    target_area.append(cloningan);
                    setTimeout(() => {
                        handleBtnAddColom();
                        handleHitung();
                        handleBtnDeleteColom();
                    }, 500);
                });
            }

            function handleBtnDeleteColom(){
                $("button#delete_colom").off("click").on("click", function(){
                    var el_count = $('[data-area]').length;
                    //alert(el_count);
                    if(el_count < 2){
                        return false;
                    }

                    var _this = $(this),
                    currentArea = _this.parent().parent();

                    currentArea.remove();
                    gotoView();
                });
            }

            function handleHitung(){
                $('input#qty').off("input").on("input", function(){
                    var _this = $(this),
                    currentArea = _this.parent().parent();
                    harga = currentArea.find('input[name="hrg_barang[]"]').val();
                    qty = currentArea.find('input[name="qty[]"]').val();
                    // console.log(bi+"*"+qty);
                    grand_total = harga*qty;

                    currentArea.find('input[name="total_harga[]"]').val(grand_total);
                    hitungTotal();
                });   
            }

            function hitungTotal(){
                var grand_total = 0;
                $('[data-area="area_50"]').each(function(){
                    var _this = $(this);
                    subtot =  _this.find("input[name='total_harga[]']").val();
                    grand_total += parseFloat(subtot);
                });
                $('#grand_total').val(grand_total);
                // console.log(total);

            }

            function gotoView(){
                var el = $('[data-area="area_50"]').find(".row:last-child")[0];
                el.scrollIntoView();
            }
});
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
  </body>
</html>