document.addEventListener('DOMContentLoaded', function () {
  const imageInput = document.querySelector('.image-input');
  const formWidget = document.querySelector('.form-widget');
  const imageList = document.createElement('div');
  imageList.className = 'row';
  formWidget.appendChild(imageList);

  function updateFileList() {
    imageList.innerHTML = ''; // Clear existing list

    Array.from(imageInput.files).forEach((file, index) => {
      const listItem = document.createElement('div');
      listItem.className = 'col-3 mb-4';
      const fileReader = new FileReader();

      fileReader.onload = function (e) {
        const img = document.createElement('img');
        img.src = e.target.result;
        img.className = 'img-fluid rounded mb-2';
        listItem.innerHTML = `
                    <div class="text-center">
                        ${file.name}
                        <button type="button" class="btn btn-danger btn-sm remove-button" data-index="${index}">Anuluj</button>
                    </div>
                `;
        listItem.insertBefore(img, listItem.firstChild);
      };

      fileReader.readAsDataURL(file);
      imageList.appendChild(listItem);
    });
  }

  imageList.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-button')) {
      e.preventDefault();
      const button = e.target;
      const index = parseInt(button.getAttribute('data-index'), 10);
      const dt = new DataTransfer();
      const files = imageInput.files;

      for (let i = 0; i < files.length; i++) {
        if (i !== index) {
          dt.items.add(files[i]);
        }
      }

      imageInput.files = dt.files;
      updateFileList();
    }
  });

  imageInput.addEventListener('change', updateFileList);
});
