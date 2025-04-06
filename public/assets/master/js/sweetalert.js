const deletes = document.querySelectorAll('.delete');

deletes.forEach(item => {
  item.onclick = (e) => {
    e.preventDefault();
    const formId = item.getAttribute('data-id');
    const form = document.getElementById(`delete-form-${formId}`);

    swal({
        title: "Bạn có chắc?",
        text: "Bạn có chắc muốn xóa không!",
        type: "warning",
        buttons: {
          confirm: {
            text: "Có, xóa nó!",
            className: "btn btn-success",
          },
          cancel: {
            'text': 'Thoát',
            visible: true,
            className: "btn btn-danger",
          },
        },
    }).then((Delete) => {
        if (Delete) {
          form.submit();
        } else {
          swal.close();
        }
    });
  }
})
