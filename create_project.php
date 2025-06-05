<?php include './header.php'; ?>

<div class="row">
    <div class="container">
        <h2 class="text-center mb-4">Yangi Loyiha Qo‘shish</h2>
        <form enctype="multipart/form-data" class="border p-4 rounded bg-light shadow" id="create_project">
            <div class="mb-3">
                <label for="title" class="form-label">Loyiha nomi</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Tavsif</label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Rasm</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Saqlash</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function successAlert() {
        Swal.fire({
            icon: 'success',
            title: 'Bajarildi!',
            text: 'Amaliyot muvaffaqiyatli tugadi 😊'
        });
    }

    function errorAlert(message = 'Nimadadir muammo yuz berdi 😥') {
        Swal.fire({
            icon: 'error',
            title: 'Xatolik!',
            text: message,
        });
    }

    document.getElementById('create_project').addEventListener('submit', function (e) {
        e.preventDefault();

        const form = this;
        const formData = new FormData(form);

        fetch('./project/store.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                successAlert();
                form.reset();
            } else {
                errorAlert(data.message || 'Noma’lum xatolik yuz berdi');
            }
        })
        .catch(error => {
            console.error('Xatolik:', error);
            errorAlert('❌ Kutilmagan xatolik yuz berdi.');
        });
    });
</script>


<?php include './footer.php'; ?>