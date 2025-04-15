import axios_ins from "/js/axios.js";

document.addEventListener('DOMContentLoaded', function () {
    const emojiButton = document.getElementById('emoji-button');
    const emojiPickerContainer = document.getElementById('emoji-picker');
    const picker = emojiPickerContainer.querySelector('emoji-picker');
    const textarea = document.getElementById('comment');
    const inpComment = document.querySelector('#comment');
    const inpComments = document.querySelectorAll('.comment');
    const isAuthenticated = window.auth.isAuthenticated;
    const currentUser = window.auth.user;
    const user_id = isAuthenticated ? currentUser.id : null;
    const textareaInp = document.getElementById('comment');
    const btnComment = document.getElementById('btn-comment');
    

    emojiButton.addEventListener('click', function (e) {
        e.stopPropagation();

        // Toggle display
        const isVisible = emojiPickerContainer.style.display === 'block';
        emojiPickerContainer.style.display = isVisible ? 'none' : 'block';

        if (!isVisible) {
            // Xóa class cũ
            emojiPickerContainer.classList.remove('above', 'below');

            const rect = emojiPickerContainer.getBoundingClientRect();
            const spaceBelow = window.innerHeight - rect.bottom;
            const spaceAbove = rect.top;

            // Giả định chiều cao của emoji picker ~300px
            if (spaceBelow < 300 && spaceAbove > 300) {
                emojiPickerContainer.classList.add('above');
            } else {
                emojiPickerContainer.classList.add('below');
            }
        }
    });

    picker.addEventListener('emoji-click', event => {
        textarea.value += event.detail.unicode;
        emojiPickerContainer.style.display = 'none';
    });

    document.addEventListener('click', function (e) {
        if (!emojiPickerContainer.contains(e.target) && !emojiButton.contains(e.target)) {
            emojiPickerContainer.style.display = 'none';
        }
    });

    textareaInp.addEventListener('input', function () {
        if (textarea.value.trim().length > 0) {
            btnComment.removeAttribute('disabled');
        } else {
            btnComment.setAttribute('disabled', 'disabled');
        }
    });

    btnComment.onclick = async () => {
        const message = inpComment.value;
        const id = inpComment.getAttribute('data-id');
        const type = inpComment.getAttribute('data-type');

        const response = await axios_ins.post('/discussions', {message, user_id, id, type});
        textareaInp.value = '';
        await getAll();
    }

    const layoutComment = ({ user, message, created_at, id: discussion_id  }, id) => {
        const date = new Date(created_at);
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
    
        const formattedDate = `${day}-${month}-${year} ${hours}:${minutes}`;
    
        return (`
            <div class="mb-3 d-flex align-items-start justify-content-between" style="gap: 8px;">
                <div class="d-flex" style="gap: 8px;">
                    <div class="d-block avatar avatar-sm" style="width: 50px;">
                        <img class="rounded-circle object-fit-cover" src="${user.avatar}" width="45px" height="45px" alt="">
                    </div>
                    <div>
                        <strong>${user.name}</strong>
                        <span class="text-muted small">${formattedDate}</span>
                        <p class="mb-0">${message}</p>
                    </div>
                </div>
                
                <div class="dropdown">
                    <button class="btn text-primary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><span class="dropdown-item btn-edit-comment cursor-pointer" data-id="${discussion_id}">Sửa</span></li>
                        <li><span class="dropdown-item btn-delete-comment cursor-pointer" data-id="${discussion_id}">Xóa</span></li>
                    </ul>
                </div>
            </div>
        `);
        
    }
    

    const getAll = async () => {
        try {
            const data_id = inpComment.getAttribute('data-id');
            const type = inpComment.getAttribute('data-type');
            const comments = document.querySelector('#comments');
            const response = await axios_ins.get(`/discussions/${data_id}?type=${type}`);
            const listComment = response.data.data;
            if (listComment.length) {
                const htmls = listComment.map((comment) =>{
                    return layoutComment(comment, data_id);
                }).join('');
                comments.innerHTML = htmls;
            }

            document.querySelectorAll('.btn-delete-comment').forEach( item => {
                item.onclick = async () => {
                    const id = item.getAttribute('data-id');
        
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
                    }).then(async (Delete) => {
                        if (Delete) {
                            const response = await axios_ins.delete(`/discussions/${id}`);
                            await getAll();
                        }
                    });
                } 
            })
            
            document.querySelectorAll('.emoji-picker').forEach(item => {
                item.addEventListener('emoji-click', function (event) {
                    const textarea = item.closest('.form-comment').querySelector('.comment');
                    if (textarea) {
                        textarea.value += event.detail.unicode;
                        item.style.display = 'none';
                    }
                });
            });
    
        } catch (error) {
            console.error(error);
        }
    }
    
    getAll();
});
