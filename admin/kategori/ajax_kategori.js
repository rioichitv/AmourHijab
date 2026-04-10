$(document).ready(function () {
  var data = "data_kategori.php";
  $("#data-kategori").load(data);

  $("#form-tambah").submit(function (e) {
    e.preventDefault();

    var dataform = new FormData($("#form-tambah")[0]);
    $.ajax({
      url: "aksi_query.php",
      type: "post",
      processData: false,
      contentType: false,
      data: dataform,
      success: function (result) {
        $("#modal-tambah").modal("hide");
        $("#form-tambah")[0].reset();
        alert("Input Data Sukses");
        $("#data-kategori").load(data);
      },
      error: function () {
        alert("Input Data Gagal");
      },
    });
  });

  $(document).on("click", "#edit", function (e) {
    e.preventDefault();
    $("#modal-edit").modal("show");
    $.post(
      "edit_kategori.php",
      { id: $(this).attr("data-id") },
      function (html) {
        $("#data-edit").html(html);
      }
    );
  });

  $("#form-edit").submit(function (e) {
    e.preventDefault();

    var dataform = new FormData($("#form-edit")[0]);
    $.ajax({
      url: "aksi_query.php",
      type: "post",
      processData: false,
      contentType: false,
      data: dataform,
      success: function (result) {
        $("#modal-edit").modal("hide");
        $("#form-edit")[0].reset();
        alert("Edit Data Sukses");
        $("#data-kategori").load(data);
      },
      error: function () {
        alert("Edit Data Gagal");
      },
    });
  });

  $(document).on("click", "#confirm_delete", function (e) {
    e.preventDefault();
    $("#modal-hapus").modal("show");
    $.post(
      "confirm_delete.php",
      { id: $(this).attr("data-id") },
      function (html) {
        $("#delete-kategori").html(html);
      }
    );
  });

  $(document).on("click", "#hapus", function (e) {
    e.preventDefault();
    $.post("aksi_query.php", { id: $(this).attr("data-id") }, function (html) {
      $("#modal-hapus").modal("hide");
      alert("Delete Data Sukses");
      $("#data-kategori").load(data);
    });
  });
});
