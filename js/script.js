const navbarNav = document.querySelector('.navbar-nav');

// ketika menu diklik
document.querySelector('#hamburger-menu').onclick = () => {
    navbarNav.classList.toggle('active');
};

// klik di luar sidebar untuk menghilangkan navbar
const hamburger = document.querySelector('#hamburger-menu');

document.addEventListener('click', function(e) {
    if (!hamburger.contains(e.target) && !navbarNav.contains(e.target)) {
        navbarNav.classList.remove('active');
    }
});

document.getElementById("imageInput").addEventListener("change", function(event){
    const file = event.target.files[0];
    const preview = document.getElementById("preview");

    if(file){
        const reader = new FileReader();
        reader.onload = function(e){
            preview.src = e.target.result;
            preview.style.display = "block";
        }
        reader.readAsDataURL(file);
    }
});

document.addEventListener("DOMContentLoaded", function () {

    const minusBtn = document.querySelector(".minus");
    const plusBtn  = document.querySelector(".plus");
    const qtyInput = document.querySelector("input[name='qty']");

    if (!minusBtn || !plusBtn || !qtyInput) {
        console.log("Qty button tidak ditemukan.");
        return;
    }

    const maxStock = parseInt(qtyInput.max) || 1;

    plusBtn.addEventListener("click", function () {
        let current = parseInt(qtyInput.value) || 1;
        if (current < maxStock) {
            qtyInput.value = current + 1;
        }
    });

    minusBtn.addEventListener("click", function () {
        let current = parseInt(qtyInput.value) || 1;
        if (current > 1) {
            qtyInput.value = current - 1;
        }
    });

});
