$(document).ready(function () {
    event.preventDefault();
    $('#modal-konfirmasi').on('show.bs.modal', function (event) {
        var div = $(event.relatedTarget); // Tombol dimana modal ditampilkan
        var id = div.data('id');
        var modal = $(this);

        modal.find('#hapus-true-data').off('click').on('click', function () {
            $.ajax({
                url: "user/delete.php",
                type: "GET",
                data: { id: id },
                success: function (response) {
                    if (!response.error) {
                        $('#modal-konfirmasi').modal('hide');
                        location.reload(); // Refresh halaman setelah data dihapus
                    } else {
                        alert("Error: " + response.msg);
                    }
                },
                error: function (xhr, status, error) {
                    alert('Terjadi kesalahan: ' + error);
                }
            });
        });
    });
});
