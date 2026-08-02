<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

const menuButton = document.getElementById("menuButton");
const sidebar = document.querySelector(".sidebar");
const overlay = document.getElementById("overlay");

if(menuButton && sidebar && overlay){

    menuButton.addEventListener("click", function(){

        sidebar.classList.add("show");
        overlay.classList.add("show");

    });

    overlay.addEventListener("click", function(){

        sidebar.classList.remove("show");
        overlay.classList.remove("show");

    });

    // Tutup sidebar jika ukuran layar berubah ke desktop
    window.addEventListener("resize", function(){

        if(window.innerWidth > 991){

            sidebar.classList.remove("show");
            overlay.classList.remove("show");

        }

    });

}

/* ===========================
   DETAIL PRODUK
=========================== */

document.querySelectorAll(".btn-detail").forEach(function(button){

    button.addEventListener("click", function(){

        let id = this.dataset.id;

        document.getElementById("detailProduk").innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-primary"></div>
                <p class="mt-3">Memuat data...</p>
            </div>
        `;

        fetch("produk_detail.php?id=" + id)
        .then(response => response.text())
        .then(data => {

            document.getElementById("detailProduk").innerHTML = data;

            new bootstrap.Modal(document.getElementById("modalDetail")).show();

        });

    });

});


/* ===========================
   EDIT PRODUK
=========================== */

document.querySelectorAll(".btn-edit").forEach(function(button){

    button.addEventListener("click", function(){

        let id = this.dataset.id;

        document.getElementById("editProduk").innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-warning"></div>
                <p class="mt-3">Memuat data...</p>
            </div>
        `;

        fetch("produk_edit.php?id=" + id)
        .then(response => response.text())
        .then(data => {

            document.getElementById("editProduk").innerHTML = data;

            // Tampilkan modal
            const modal = new bootstrap.Modal(document.getElementById("modalEdit"));
            modal.show();

            // Preview gambar setelah HTML dimuat
            const gambarEdit = document.getElementById("gambarEdit");
            const previewEdit = document.getElementById("previewEdit");

            if(gambarEdit && previewEdit){

                gambarEdit.addEventListener("change", function(){

                    if(this.files && this.files[0]){

                        const reader = new FileReader();

                        reader.onload = function(e){

                            previewEdit.src = e.target.result;

                        };

                        reader.readAsDataURL(this.files[0]);

                    }

                });

            }

        })
        .catch(err => {

            console.error(err);

            alert("Gagal memuat form edit.");

        });

    });

});

/* ===========================
   SUBMIT EDIT PRODUK
=========================== */

document.addEventListener("submit", function(e){

    if(e.target.id === "formEditProduk"){

        e.preventDefault();

        let form = e.target;
        let formData = new FormData(form);

        fetch(form.action, {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(res => {

            if(res.status){

                bootstrap.Modal.getInstance(document.getElementById("modalEdit")).hide();

                Swal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: res.pesan,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {

                    location.reload();

                });

            } else {

                Swal.fire({
                    icon: "error",
                    title: "Gagal",
                    text: res.pesan
                });

            }

        })
        .catch(err => {

            console.log(err);

            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Terjadi kesalahan."
            });

        }); 

    }

}); 

</script>

</body>
</html>